<?php 

$lang = array(

'httpbl_key'				=> 'Http:BL - Access Key',
'filter_type'				=> 'Type of filtering',
'flag_spam'					=> 'Flag email subjects',
'block_spam'				=> 'Block form submissions entirely',
'change_status'				=> 'Set Freeform entry status to closed for flagged emails',
'subject_flag'				=> 'Subject prefix for flagged emails',
'ip_block_error'		 	=> 'Error shown to flagged IP addresses if blocking is enabled',
'enable_httpbl'				=> 'Http:BL - Enable Http:BL checks',
'last_activity'				=> 'Http:BL - Filter when: Days since last IP activity is less than &hellip;',
'threat_score'				=> 'Http:BL - And when: Threat score exceeds &hellip;',
'visitor_type'				=> 'Http:BL - And when: Visitor type is &hellip; (or higher)',
'enable_sfs'				=> 'StopForumSpam - Enable StopForumSpam checks',
'sfs_last_activity'			=> 'StopForumSpam - Filter when: Days since last IP activity is less than &hellip;',
'sfs_threshold'				=> 'StopForumSpam - And when: Reported instances of spamming exceeds &hellip;',
'enable_honeypot'			=> 'Honeypots - Automatically add a honeypot field to all forms',
'honeypot_names'			=> 'Honeypots - Field names (comma separated)',
'honeypot_label'			=> 'Honeypots - Field label (visible to users with CSS disabled)',
'honeypot_error'			=> 'Honeypots - Error shown if the honeypot is filled and blocking is enabled',


'standard_ip_block_error'	=> 'Your IP address has recently been associated with spamming, so this form will not be submitted.',
'standard_honeypot_label' 	=> 'This field is intended to catch out spammers - please leave it blank.',
'standard_honeypot_error'	=> 'Please go back and leave the spam field blank.',

'type_0'					=> '0 - Search engine',
'type_1'					=> '1 - Suspicious',
'type_2'					=> '2 - Harvester',
'type_3'					=> '3 - Suspicious &amp; Harvester',
'type_4'					=> '4 - Comment Spammer',
'type_5'					=> '5 - Suspicious &amp; Comment Spammer',
'type_6'					=> '6 - Harvester &amp; Comment Spammer',
'type_7'					=> '7 - Suspicious &amp; Harvester &amp; Comment Spammer',

'uceprotect'				=> 'UCE Protect - Select your preferred blacklist',
'uce_disabled'				=> 'Disable UCE blacklist checks',
'uce_1'						=> 'Level 1 - Conservative IP blocking',
'uce_2'						=> 'Level 2 - Moderate IP blocking',
'uce_3'						=> 'Level 3 - Aggressive IP blocking',

'omnilog'					=> 'Log spam activity (requires Omnilog)',
'honeypot_blocked'			=> 'A honeypot just caught %s and blocked their submission.',
'ip_blocked'				=> 'Form submission by %s was blocked.',
'honeypot_flagged'			=> 'A honeypot just caught %s and flagged their submission.',
'ip_flagged'				=> 'Form submission by %s was flagged.',
'max_logs'					=> 'Max number of log entries to retain at any one time',

''=>''
);

/* End of file lang.freeform_antispam.php */
/* Location: ./system/expressionengine/third_party/freeform_antispam/language/english/lang.freeform_antispam.php */