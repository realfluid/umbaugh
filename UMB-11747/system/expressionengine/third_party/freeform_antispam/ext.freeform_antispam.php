<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(PATH_THIRD . 'freeform_antispam/config.php');

class Freeform_antispam_ext {

    var $settings        = array();

    var $name				= FA_NAME;
    var $version			= FA_VERSION;
    var $description		= FA_DESC;
    var $settings_exist		= 'y';
    var $docs_url			= FA_DOCS;

    var $httpbl_key			= '';
    var $filter_type		= 'flag';
    var $enable_httpbl		= 'y';
	var	$last_activity		= 8;
	var $threat_score		= 7;
	var $visitor_type		= 4;
	var $subject_flag		= '[spam]';
	var $change_status		= 'y';
	var $ip_block_error		= 'Your IP address has recently been associated with spamming, so this form will not be submitted.';
    var $enable_sfs			= 'y';
	var $sfs_last_activity	= 8;
	var $sfs_threshold		= 5;
	var $enable_honeypot	= 'y';
	var $honeypot_names		= 'honeypot';
	var $honeypot_label		= 'This field is intended to catch out spammers - please leave it blank.';
	var $honeypot_error		= 'Please go back and leave the spam field blank.';
	var $uceprotect			= '1';
	var $omnilog			= 'y';
	var $max_logs			= '30';

    // -------------------------------
    //   Constructor
    // -------------------------------

	function __construct($settings='')
	{
		$this->EE =& get_instance();

		if(is_array($settings) && count($settings) > 0)
		{
			foreach($settings as $key => $val)
			{
				$this->{$key} = $val;
			}
		}

		$this->EE->lang->loadfile('freeform_antispam');

		// Logging, anyone?
		if ($this->omnilog == 'y' && file_exists(PATH_THIRD .'omnilog/classes/omnilogger' .EXT))
		{
			include_once PATH_THIRD .'omnilog/classes/omnilogger' .EXT;
		}
	}

	// --------------------------------
	//  Activate Extension
	// --------------------------------

	function activate_extension()
	{
	    global $DB;

	    $hooks = array(
			'form_submission_check' => 'freeform_module_validate_end',
			'admin_notify_check'    => 'freeform_module_admin_notification',
			'add_honeypot'          => 'freeform_module_form_end'
	    );

	    foreach ($hooks as $method => $hook)
	    {
    	    $this->EE->db->query($this->EE->db->insert_string('exp_extensions',
				array(
						'extension_id' => '',
						'class'        => __CLASS__,
						'method'       => $method,
						'hook'         => $hook,
						'settings'     => "",
						'priority'     => 50,
						'version'      => $this->version,
						'enabled'      => "y"
					)
				)
    		);
	    }
	}

	// --------------------------------
	//  Update Extension
	// --------------------------------

	function update_extension($current='')
	{
	    global $DB;

	    if ($current == '' OR $current == $this->version)
	    {
	        return FALSE;
	    }

	    $this->EE->db->query("UPDATE exp_extensions
	                SET version = '".$this->EE->db->escape_str($this->version)."'
	                WHERE class = '".__CLASS__."'");
	}

	// --------------------------------
	//  Disable Extension
	// --------------------------------

	function disable_extension()
	{
		$this->EE->db->query("DELETE FROM exp_extensions WHERE class = '".__CLASS__."'");
	}

	// --------------------------------
	//  Admin notify check
	// --------------------------------
	// Blocks admin notification if the IP is a known spammer
	// Set defaults for $form_id and $freeform as they're only supported by FF4.X

	function admin_notify_check($fields, $entry_id, $msg, $form_id = '', $freeform = FALSE)
	{
		if($this->EE->extensions->last_call)
		{
			$msg = $this->EE->extensions->last_call;
		}

		// Have we been asked to flag email subjects?
		if($this->filter_type == 'flag')
		{
			$ip = $this->EE->input->ip_address;

			if($this->_honeypot_is_full())
			{
				$is_spammer = true;
				$this->_log_activity('honeypot_flagged');
			}
			elseif($this->_in_httpbl($ip) || $this->_in_uceprotect($ip) || $this->_in_sfs($ip))
			{
				$is_spammer = true;
				$this->_log_activity('ip_flagged');
			}

			if(isset($is_spammer) && $is_spammer === true)
			{
				// Set the FF entry status to closed so it can easily be deleted/accessed later
				if($this->change_status == 'y')
				{
					$data = array('status' => 'closed');
					$this->EE->db->where('entry_id', $entry_id);

					if (is_object($freeform) && version_compare($freeform->version, '4.0.0', '>='))
					{
						$this->EE->db->update('freeform_form_entries_' . $form_id, $data);
					}
					else
					{
						$this->EE->db->update('freeform_entries', $data);
					}
				}

				$msg['subject'] = $this->subject_flag.' '.$msg['subject'];
			}
		}

		return $msg;
	}

	// --------------------------------
	//  Validate entry on submission
	// --------------------------------
	// Blocks submission altogether if the IP is a known spammer

	function form_submission_check($errors = array())
	{
		if($this->EE->extensions->last_call)
		{
			$errors = $this->EE->extensions->last_call;
		}

		// Have we been asked to block dodgy submissions altogether?
		if($this->filter_type == 'block')
		{
			$ip = $this->EE->input->ip_address;

			if($this->_honeypot_is_full())
			{
				$errors[] = $this->honeypot_error;
				$this->_log_activity('honeypot_blocked');
			}

			if($this->_in_httpbl($ip) || $this->_in_uceprotect($ip) || $this->_in_sfs($ip))
			{
				$errors[] = $this->ip_block_error;
				$this->_log_activity('ip_blocked');
			}
		}

		return $errors;
	}

	// --------------------------------
	//  Add a honeypot field to FF
	// --------------------------------

	function add_honeypot($r)
	{
		if($this->EE->extensions->last_call)
		{
			$r = $this->EE->extensions->last_call;
		}

		if($this->enable_honeypot == 'y')
		{
			// pick one of the provided honeypot field names at random
			$honeypot_name_array = explode(',', $this->honeypot_names);
			$random_name = trim($honeypot_name_array[ array_rand($honeypot_name_array) ]);

			$honeypot_field = <<<EOF
<div style="position:absolute; left: -1000em; overflow: hidden">
	<label for="{$random_name}">{$this->honeypot_label}</label>
	<input type="text" name="{$random_name}" id="{$random_name}" autocomplete="off" />
</div>

EOF;
			$r = str_ireplace('</form>', $honeypot_field.'</form>', $r);
		}

		return $r;
	}

	// --------------------------------
	//  Check Http:BL
	// --------------------------------
	function _in_httpbl($ip)
	{
		// If no key has been provided or if Http:BL checks are disabled, do not pass go, do not bother to send a request
		if($this->enable_httpbl == 'n' || empty($this->httpbl_key)) { return false; }

		// Grab the IP address and reverse the octets
		$ip_reversed = $this->_reverse_ip($ip);

		// Query http:BL
		$response = gethostbynamel($this->httpbl_key.".".$ip_reversed.".dnsbl.httpbl.org.");

		// Process response
		if (!empty($response)) {
			$ip = explode('.', $response[0]);

			// First octet should always be 127. If it isn't, bail out and let form processing continue, there's nothing we can do.
			if($ip[0] != 127) { return false; }

			// Second = days since activity, third = threat score, four = visitor type
			// Threat score ref: http://www.projecthoneypot.org/threat_info.php
			// Visitor type ref: http://www.projecthoneypot.org/httpbl_api.php

			if($ip[1] < $this->last_activity && $ip[2] > $this->threat_score && $ip[3] >= $this->visitor_type)
			{
				return true;
			}
		}

		return false;

	}

	// --------------------------------
	//  Check StopForumSpam.com
	// --------------------------------

	private function _in_sfs($ip)
	{
		if($this->enable_sfs == 'n') { return false; }

		// Set a 1 second timeout in case SFS is down/slow (otherwise form submission will be blocked or severely delayed)
		$context = stream_context_create(array(
				'http' => array(
				'timeout' => 1
				)
			)
		);

		$response_raw = @file_get_contents('http://www.stopforumspam.com/api?ip='.$ip.'&f=serial&unix', 0, $context);
		$response = @unserialize($response_raw);

		if($response !== FALSE && $response['success'] === 1 && $response['ip']['appears'] === 1)
		{
			$sfs_activity_min = $this->EE->localize->now - ($this->sfs_last_activity * 86400); // X days ago, unix timestamp

			if($response['ip']['lastseen'] > $sfs_activity_min && $response['ip']['frequency'] > $this->sfs_threshold)
			{
				return true;
			}
		}

		return false;
	}


	// --------------------------------
	//  Check UCE protect
	// --------------------------------

	private function _in_uceprotect($ip)
	{
		if(! in_array($this->uceprotect, array(1, 2, 3))) { return false; }

		// Query the blacklist that the user has requested.
		// Level 1 is known dodgy IPs only, level 3 is much more extreme and blocks
		// wide ranges of IPs in bad neighbourhoods.

		if($this->_query_uce($ip, $this->uceprotect))
		{
			// In the case of a match check two additional random IPs to verify that
			// this is a legit response. If both random IPs are listed this is probably
			// a false positive.

			if(
				! $this->_query_uce($this->_random_ip(), $this->uceprotect) AND
				! $this->_query_uce($this->_random_ip(), $this->uceprotect)
			)
			{
				return true;
			}
		}

		return false;
	}


	// --------------------------------
	//  UCE protect query
	// --------------------------------

	private function _query_uce($ip, $level)
	{
		$response = gethostbynamel($this->_reverse_ip($ip).".dnsbl-".$level.".uceprotect.net.");

		if(is_array($response) AND $response[0] == '127.0.0.2')
		{
			return true; // IP is listed
		}

		return false; // IP is not listed
	}


	// --------------------------------
	//  Check the honeypot field
	// --------------------------------
	private function _honeypot_is_full()
	{
		// Has the honeypot field been populated?
		if($this->enable_honeypot == 'y')
		{
			$honeypot_name_array = explode(',', $this->honeypot_names);

			foreach($honeypot_name_array as $name)
			{
				if(!empty($_POST[ trim($name) ]))
				{
					return true;
				}
			}
		}

		return false;
	}

	// --------------------------------
	//  Reverse IP octets
	// --------------------------------

	private function _reverse_ip($ip)
	{
		$ip_segs = array_reverse(explode('.', $ip));
		return implode('.', $ip_segs);
	}

	// --------------------------------
	//  Random IP
	// --------------------------------

	private function _random_ip()
	{
		return long2ip(rand(0, "4294967295"));
	}

	// --------------------------------
	//  Logging
	// --------------------------------

	private function _log_activity($type)
	{
		$ip		= $this->EE->input->ip_address;
		$name	= $this->EE->input->post('name', TRUE);

		// Include the 'name' the submitee provided in the main log text if poss
		if($name) { $id = $ip.' ('.$name.')'; }
		else { $id = $ip; }

		// It's spam. Clean it, then log it.

		$cleaned_post = '<code>' . print_r($this->_clean_log_value($_POST), TRUE) . '</code>';

		$this->_log_core(str_replace('%s', $id, $this->EE->lang->line($type)), $cleaned_post);

		return true;
	}

	// Clean user input for logging
	private function _clean_log_value($item)
	{
		if (is_array($item))
		{
			foreach($item as $k => $v)
			{
				$item[$k] = $this->_clean_log_value($v);
			}

			return $item;
		}
		else
		{
			$cleaned = htmlentities($item);

			// Trim any especially lengthy fields

			if(strlen($cleaned) > 600)
			{
				$cleaned = substr($cleaned, 0, 600) . '&hellip;';
			}

			return $cleaned;
		}
	}

	private function _log_core($msg, $extended = '', $severity = 1, $emails = array())
	{
		if (class_exists('Omnilog_entry') && class_exists('Omnilogger'))
		{
			switch ($severity)
			{
				case 3:
				$notify = TRUE;
				$type   = Omnilog_entry::ERROR;
				break;

				case 2:
				$notify = FALSE;
				$type   = Omnilog_entry::WARNING;
				break;

				case 1:
				default:
				$notify = FALSE;
				$type   = Omnilog_entry::NOTICE;
				break;
			}

			// Once we hit $max_logs it's a strict one-in, one-out policy

			$this->EE->db->from('omnilog_entries');
			$this->EE->db->where('addon_name', $this->name);

			if($this->EE->db->count_all_results() >= $this->max_logs)
			{
				$this->EE->db->where('addon_name', $this->name);
				$this->EE->db->order_by('log_entry_id', 'desc');
				$query = $this->EE->db->get('omnilog_entries', 1, $this->max_logs - 1);

				if($query->row('log_entry_id'))
				{
					$this->EE->db->where('log_entry_id <=', $query->row('log_entry_id'));
					$this->EE->db->where('addon_name', $this->name);
					$this->EE->db->delete('omnilog_entries');
				}
			}

			$omnilog_entry = new Omnilog_entry(array(
				'addon_name'    => $this->name,
				'admin_emails'  => $emails,
				'date'          => time(),
				'extended_data' => $extended,
				'message'       => $msg,
				'notify_admin'  => $notify,
				'type'          => $type
			));

			Omnilogger::log($omnilog_entry);
		}
	}


	// --------------------------------
	//  Settings
	// --------------------------------

	function settings()
	{
		$settings = array();

		// Generic
		$settings['filter_type']		= array('r', array(
											'flag' => $this->EE->lang->line('flag_spam'),
											'block' => $this->EE->lang->line('block_spam')
										  ), $this->filter_type);

		$settings['subject_flag']		= $this->subject_flag;
		$settings['change_status']		= array('r', array('y' => "Yes", 'n' => "No"), $this->change_status);
		$settings['ip_block_error']		= $this->EE->lang->line('standard_ip_block_error');

		$settings['enable_httpbl']		= array('r', array('y' => "Yes", 'n' => "No"), $this->enable_httpbl);
		$settings['httpbl_key']			= $this->httpbl_key;
		$settings['last_activity']		= $this->last_activity;
		$settings['threat_score']		= $this->threat_score;
		$settings['visitor_type']		= array('s',
											array(
												'0' => $this->EE->lang->line('type_0'),
												'1' => $this->EE->lang->line('type_1'),
												'2' => $this->EE->lang->line('type_2'),
												'3' => $this->EE->lang->line('type_3'),
												'4' => $this->EE->lang->line('type_4'),
												'5' => $this->EE->lang->line('type_5'),
												'6' => $this->EE->lang->line('type_6'),
												'7' => $this->EE->lang->line('type_7'),
											), $this->visitor_type);

		$settings['enable_sfs']			= array('r', array('y' => "Yes", 'n' => "No"), $this->enable_sfs);
		$settings['sfs_last_activity']	= $this->sfs_last_activity;
		$settings['sfs_threshold']		= $this->sfs_threshold;

		$settings['enable_honeypot']	= array('r', array('y' => "Yes", 'n' => "No"), $this->enable_honeypot);
		$settings['honeypot_names']		= $this->honeypot_names;
		$settings['honeypot_label']		= $this->EE->lang->line('standard_honeypot_label');
		$settings['honeypot_error']		= $this->EE->lang->line('standard_honeypot_error');

		$settings['uceprotect']			= array('s',
											array(
												'0' => $this->EE->lang->line('uce_disabled'),
												'1' => $this->EE->lang->line('uce_1'),
												'2' => $this->EE->lang->line('uce_2'),
												'3' => $this->EE->lang->line('uce_3')
											), $this->uceprotect);

		$settings['omnilog']			= array('r', array(
												'y' => $this->EE->lang->line('enabled'),
												'n' => $this->EE->lang->line('disabled')
										  ), $this->omnilog);
		$settings['max_logs']			= $this->max_logs;

		return $settings;
	}

}
// END CLASS

/* End of file ext.freeform_antispam.php */
/* Location: ./system/expressionengine/third_party/freeform_antispam/ext.freeform_antispam.php */