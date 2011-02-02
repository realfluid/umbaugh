<?php

/**
 * Create custom HTML forms.
 */
class cnFormObjects
{
	private $nonceBase = 'connections';
	
	public function __construct()
	{
		//if ( is_admin() ) $this->registerMetaboxes();
	}
	
	/**
	 * The form open tag.
	 * 
	 * @todo Finish adding form tag attributes.
	 * @param array
	 * @return string
	 */
	 public function open($attr)
	{
		if ( isset($attr['name']) ) $attr['name'] = 'name="' . $attr['name'] . '" ';
		if ( isset($attr['action']) ) $attr['action'] = 'action="' . $attr['action'] . '" ';
		if ( isset($attr['accept']) ) $attr['accept'] = 'accept="' . $attr['accept'] . '" ';
		if ( isset($attr['accept-charset']) ) $attr['accept-charset'] = 'accept-charset="' . $attr['accept-charset'] . '" ';
		if ( isset($attr['enctype']) ) $attr['enctype'] = 'enctype="' . $attr['enctype'] . '" ';
		if ( isset($attr['method']) ) $attr['method'] = 'method="' . $attr['method'] . '" ';
				
		$out = '<form ';
		
		foreach ($attr as $key => $value)
		{
			$out .= $value;
		}
		
		echo $out , '>';
	}
	
	/**
	 * @return string HTML close tag
	 */
	public function close()
	{
		echo '</form>';
	}
		
	//Function inspired from:
	//http://www.melbournechapter.net/wordpress/programming-languages/php/cman/2006/06/16/php-form-input-and-cross-site-attacks/
	/**
	 * Creates a random token.
	 * 
	 * @param string $formId The form ID
	 * 
	 * @return string
	 */
	public function token($formId)
	{
		$token = md5(uniqid(rand(), true));
		
		return $token;
	}
	
	public function tokenCheck($tokenID, $token)
	{
		global $connections;
		$token = attribute_escape($token);
		
		/**
		 * @TODO: Check for $tokenID.
		 */
		
		if (isset($_SESSION['cn_session']['formTokens'][$tokenID]['token']))
		{
			$sessionToken = esc_attr($_SESSION['cn_session']['formTokens'][$tokenID]['token']);
		}
		else
		{
			$connections->setErrorMessage('form_no_session_token');
			$error = TRUE;
		}
		
		if (empty($token))
		{
			$connections->setErrorMessage('form_no_token');
			$error = TRUE;
		}
		
		if ($sessionToken === $token && !$error)
		{
			unset($_SESSION['cn_session']['formTokens']);
			return TRUE;
		}
		else
		{
			$connections->setErrorMessage('form_token_mismatch');
			return FALSE;
		}
				
	}
	
	/**
	 * Retrieves or displays the nonce field for forms using wp_nonce_field.
	 * 
	 * @param string $action Action name.
	 * @param string $item [optional] Item name. Use when protecting multiple items on the same page.
	 * @param string $name [optional] Nonce name.
	 * @param bool $referer [optional] Whether to set and display the refer field for validation.
	 * @param bool $echo [optional] Whether to display or return the hidden form field.
	 * 
	 * @return string
	 */
	public function tokenField($action, $item = FALSE, $name = '_cn_wpnonce', $referer = TRUE, $echo = TRUE)
	{
		$name = esc_attr($name);
		
		if ($item == FALSE)
		{
			$token = wp_nonce_field($this->nonceBase . '_' . $action, $name, TRUE, FALSE);
		}
		else
		{
			$token = wp_nonce_field($this->nonceBase . '_' . $action . '_' . $item, $name, TRUE, FALSE);
		}
		
		if ($echo) echo $token;
		if ($referer) wp_referer_field($echo, 'previous');
		
		return $token;
	}
	
	/**
	 * Retrieves URL with nonce added to the query string.
	 * 
	 * @param string $actionURL URL to add the nonce to.
	 * @param string $item Nonce action name.
	 * @return string
	 */
	public function tokenURL($actionURL, $item)
	{
		return wp_nonce_url($actionURL, $item);
	}
	
	/**
	 * Generate the complete nonce string, from the nonce base, the action and an item.
	 * 
	 * @param string $action Action name.
	 * @param string $item [optional] Item name. Use when protecting multiple items on the same page.
	 * @return string
	 */
	public function getNonce($action, $item = FALSE)
	{
		if ($item == FALSE)
		{
			$nonce = $this->nonceBase . '_' . $action;
		}
		else
		{
			$nonce = $this->nonceBase . '_' . $action . '_' . $item;
		}
		
		return $nonce;
	}
	
	/**
	 * Builds an alpha index.
	 * @return string
	 */
	public function buildAlphaIndex() {
		$alphaindex = range("A","Z");
		
		foreach ($alphaindex as $letter) {
			$linkindex .= '<a href="#' . $letter . '">' . $letter . '</a> ';
		}
		
		return $linkindex;
	}
	
	/**
	 * Builds a form select list
	 * @return HTML form select
	 * @param string $name
	 * @param array $value_options Associative array where the key is the name visible in the HTML output and the value is the option attribute value
	 * @param string $selected[optional]
	 */
	public function buildSelect($name, $value_options, $selected=null)
	{
		
		$select = "<select name='" . $name . "'> \n";
		foreach($value_options as $key=>$value)
		{
			$select .= "<option ";
			if ($value != null)
			{
				$select .= "value='" . $key . "'";
			}
			else
			{
				$select .= "value=''";
			}
			if ($selected == $key) $select .= " SELECTED";
			
			$select .= ">";
			$select .= $value;
			$select .= "</option> \n";
		}
		$select .= "</select> \n";
		
		return $select;
	}
	
	/**
	 * Builds and returns radio groups. 
	 * 
	 * @param object $name
	 * @param object $id
	 * @param object $value_labels associative string array label name [key] and value [value]
	 * @param object $checked[optional] value to be selected by default
	 * 
	 * @return string
	 */
	public function buildRadio($name, $id, $value_labels, $checked=null)
	{
		$selected = NULL;
		$radio = NULL;
		$count = 0;
		
		foreach ($value_labels as $label => $value)
		{
			$idplus = $id . '_' . $count;
			
			if ($checked == $value) $selected = 'CHECKED';
			
			$radio .= '<label for="' . $idplus . '">';
			$radio .= '<input id="' . $idplus . '" type="radio" name="' . $name . '" value="' . $value . '" ' . $selected . ' />';
			$radio .= $label . '</label>';
			
			$selected = null;
			$idplus = null;
			$count = $count + 1;
		}
		
		return $radio;
	}
	
	/**
	 * Registers the entry edit form meta boxes
	 */
	public function registerEditMetaboxes()
	{
		global $connections;
		
		/*
		 * Interestingly if either 'submitdiv' or 'linksubmitdiv' is used as 
		 * the $id in the add_meta_box function it will show up as a meta box 
		 * that can not be hidden when the Screen Options tab is output via the 
		 * meta_box_prefs function
		 */
		
		add_meta_box('submitdiv', 'Publish', array(&$this, 'metaboxPublish'), $connections->pageHook->manage, 'side', 'core');
		//add_meta_box('metabox-fields', 'Fields', array(&$this, 'metaboxFields'), $connections->pageHook->manage, 'side', 'core');
		add_meta_box('categorydiv', 'Categories', array(&$this, 'metaboxCategories'), $connections->pageHook->manage, 'side', 'core');
		//add_meta_box('metabox-name', 'Name', array(&$this, 'metaboxName'), $connections->pageHook->manage, 'normal', 'core');
		add_meta_box('metabox-image', 'Image', array(&$this, 'metaboxImage'), $connections->pageHook->manage, 'normal', 'core');
		add_meta_box('metabox-logo', 'Logo', array(&$this, 'metaboxLogo'), $connections->pageHook->manage, 'normal', 'core');
		add_meta_box('metabox-address', 'Addresses', array(&$this, 'metaboxAddress'), $connections->pageHook->manage, 'normal', 'core');
		add_meta_box('metabox-phone', 'Phone Numbers', array(&$this, 'metaboxPhone'), $connections->pageHook->manage, 'normal', 'core');
		add_meta_box('metabox-email', 'Email Addresses', array(&$this, 'metaboxEmail'), $connections->pageHook->manage, 'normal', 'core');
		add_meta_box('metabox-messenger', 'Messenger IDs', array(&$this, 'metaboxMessenger'), $connections->pageHook->manage, 'normal', 'core');
		add_meta_box('metabox-social-media', 'Social Media IDs', array(&$this, 'metaboxSocialMedia'), $connections->pageHook->manage, 'normal', 'core');
		add_meta_box('metabox-website', 'Websites', array(&$this, 'metaboxWebsite'), $connections->pageHook->manage, 'normal', 'core');
		add_meta_box('metabox-birthday', 'Birthday', array(&$this, 'metaboxBirthday'), $connections->pageHook->manage, 'normal', 'core');
		add_meta_box('metabox-anniversary', 'Anniversary', array(&$this, 'metaboxAnniversary'), $connections->pageHook->manage, 'normal', 'core');
		add_meta_box('metabox-bio', 'Biographical Info', array(&$this, 'metaboxBio'), $connections->pageHook->manage, 'normal', 'core');
		add_meta_box('metabox-note', 'Notes', array(&$this, 'metaboxNotes'), $connections->pageHook->manage, 'normal', 'core');
	}
	
	/**
	 * Outputs the publish meta box.
	 * 
	 * Array must be an associtive array contain the key names of
	 * action, type and visibility. These are used to set the default 
	 * values when building the form bits.
	 * 
	 * @param array $data
	 */
	public function metaboxPublish($entry = NULL)
	{
		if ( isset($_GET['action']) )
		{
			$action = esc_attr($_GET['action']);
		}
		else
		{
			$action = NULL;
		}
		
		( $entry->getVisibility() ) ? $visibility = $entry->getVisibility() : $visibility = 'unlisted';
		( $entry->getEntryType() ) ? $type = $entry->getEntryType() : $type = 'individual';
		
		
		echo '<div id="minor-publishing">';
			echo '<div id="entry-type">';
				echo $this->buildRadio("entry_type","entry_type",array("Individual"=>"individual","Organization"=>"organization","Family"=>"family"), $type);
			echo '</div>';
			echo '<div id="visibility">';
				echo '<span class="radio_group">' . $this->buildRadio('visibility','vis',array('Public'=>'public','Private'=>'private','Unlisted'=>'unlisted'), $visibility) . '</span>';
				echo '<div class="clear"></div>';
			echo '</div>';
		echo '</div>';
		
		echo '<div id="major-publishing-actions">';
			
			switch ($action)
			{
				case 'edit':
					echo '<div id="cancel-button"><a href="admin.php?page=connections" class="button button-warning">Cancel</a></div><div id="publishing-action"><input  class="button-primary" type="submit" name="update" value="Update" /></div>';
				break;
				
				case 'copy':
					echo '<div id="cancel-button"><a href="admin.php?page=connections" class="button button-warning">Cancel</a></div><div id="publishing-action"><input class="button-primary" type="submit" name="save" value="Add Entry" /></div>';;
				break;
				
				default:
					echo '<div id="publishing-action"><input class="button-primary" type="submit" name="save" value="Add Entry" /></div>';
				break;
			}
									
			echo '<div class="clear"></div>';
		echo '</div>';
	}
	
	public function metaboxFields()
	{
		echo '<p><a id="add_address" class="button">Add Address</a></p>';
		echo '<p><a id="add_phone_number" class="button">Add Phone Number</a></p>';
		echo '<p><a id="add_email_address" class="button">Add Email Address</a></p>';
		echo '<p><a id="add_im_id" class="button">Add Messenger ID</a></p>';
		echo '<p><a id="add_social_media" class="button">Add Social Media ID</a></p>';
		echo '<p><a id="add_website_address" class="button">Add Website Address</a></p>';
	}
	
	public function metaboxCategories($entry = NULL)
	{
		global $connections;
		
		$categoryObjects = new cnCategoryObjects();
		
		echo '<div class="categorydiv" id="taxonomy-category">';
			echo '<div id="category-all" class="tabs-panel">';
				echo '<ul id="categorychecklist">';
					echo $categoryObjects->buildCategoryRow('checklist', $connections->retrieve->categories(), NULL, $connections->term->getTermRelationships($entry->getId()));
				echo '</ul>';
			echo '</div>';
		echo '</div>';
	}
	
	public function metaboxName($entry = NULL)
	{
		global $connections;
		
		echo '<div id="family" class="form-field">';
				
					echo '<label for="family_name">Family Name:</label>';
					echo '<input type="text" name="family_name" value="' . $entry->getFamilyName() . '" />';
					echo '<div id="relations">';
							
						// --> Start template for Connection Group <-- \\
						echo '<textarea id="relation_row_base" style="display: none">';
							echo $this->getEntrySelect('family_member[::FIELD::][entry_id]');
							echo $this->buildSelect('family_member[::FIELD::][relation]', $connections->options->getDefaultFamilyRelationValues());
						echo '</textarea>';
						// --> End template for Connection Group <-- \\
						
						if ($entry->getFamilyMembers())
						{
							foreach ($entry->getFamilyMembers() as $key => $value)
							{
								$relation = new cnEntry();
								$relation->set($key);
								$token = $this->token($relation->getId());
								
								echo '<div id="relation_row_' . $token . '" class="relation_row">';
									echo $this->getEntrySelect('family_member[' . $token . '][entry_id]', $key);
									echo $this->buildSelect('family_member[' . $token . '][relation]', $connections->options->getDefaultFamilyRelationValues(), $value);
									echo '<a href="#" id="remove_button_' . $token . '" class="button button-warning" onClick="removeEntryRow(\'#relation_row_' . $token . '\'); return false;">Remove</a>';
								echo '</div>';
								
								unset($relation);
							}
						}						
						
					echo '</div>';
					echo '<p class="add"><a id="add_relation" class="button">Add Relation</a></p>';
					
				echo '
			</div>
			
			<div class="form-field namefield">
					<div class="">';
						
						echo '
						<div style="float: left; width: 8%">
							<label for="honorific_prefix">Prefix:</label>
							<input type="text" name="honorific_prefix" value="' . $entry->getHonorificPrefix() . '" />
						</div>';
					
						echo '
						<div style="float: left; width: 30%">
							<label for="first_name">First Name:</label>
							<input type="text" name="first_name" value="' . $entry->getFirstName() . '" />
						</div>
						
						<div style="float: left; width: 24%">
							<label for="middle_name">Middle Name:</label>
							<input type="text" name="middle_name" value="' . $entry->getMiddleName() . '" />
						</div>
					
						<div style="float: left; width: 30%">
							<label for="last_name">Last Name:</label>
							<input type="text" name="last_name" value="' . $entry->getLastName() . '" />
						</div>';
					
						echo '
						<div style="float: left; width: 8%">
							<label for="honorific_suffix">Suffix:</label>
							<input type="text" name="honorific_suffix" value="' . $entry->getHonorificSuffix() . '" />
						</div>';
						
						echo '
						<label for="title">Title:</label>
						<input type="text" name="title" value="' . $entry->getTitle() . '" />
					</div>
				</div>
				
				<div class="form-field">
					<div class="organization">
						<label for="organization">Organization:</label>
						<input type="text" name="organization" value="' . $entry->getOrganization() . '" />
						
						<label for="department">Department:</label>
						<input type="text" name="department" value="' . $entry->getDepartment() . '" />';
						
						echo '
						<div id="contact_name">
							<div class="input inputhalfwidth">
								<label for="contact_first_name">Contact First Name:</label>
								<input type="text" name="contact_first_name" value="' . $entry->getContactFirstName() . '" />
							</div>
							<div class="input inputhalfwidth">
								<label for="contact_last_name">Contact Last Name:</label>
								<input type="text" name="contact_last_name" value="' . $entry->getContactLastName() . '" />
							</div>
							
							<div class="clear"></div>
						</div>';
					echo '
					</div>
			</div>';
	}
	
	public function metaboxImage($entry = NULL)
	{
		echo '<div class="form-field">';
					
			if ( $entry->getImageLinked() )
			{
				if ( $entry->getImageDisplay() ) $selected = 'show'; else $selected = 'hidden';
				
				$imgOptions = $this->buildRadio('imgOptions', 'imgOptionID_', array('Display'=>'show', 'Not Displayed'=>'hidden', 'Remove'=>'remove'), $selected);
				echo '<div style="text-align: center;"> <img src="' . CN_IMAGE_BASE_URL . $entry->getImageNameProfile() . '" /> <br /> <span class="radio_group">' . $imgOptions . '</span></div> <br />'; 
			}
			
			echo '<div class="clear"></div>';
			echo '<label for="original_image">Select Image:
			<input type="file" value="" name="original_image" size="25" /></label>
				
		</div>';
	}
	
	public function metaboxLogo($entry = NULL)
	{
		echo '<div class="form-field">';
					
			if ( $entry->getLogoLinked() )
			{
				( $entry->getLogoDisplay() ) ? $selected = 'show' : $selected = 'hidden';
				
				$logoOptions = $this->buildRadio('logoOptions', 'logoOptionID_', array('Display'=>'show', 'Not Displayed'=>'hidden', 'Remove'=>'remove'), $selected);
				echo '<div style="text-align: center;"> <img src="' . CN_IMAGE_BASE_URL . $entry->getLogoName() . '" /> <br /> <span class="radio_group">' . $logoOptions . '</span></div> <br />'; 
			}
			
			echo '<div class="clear"></div>';
			echo '<label for="original_logo">Select Logo:
			<input type="file" value="" name="original_logo" size="25" /></label>
			
		</div>';
	}
	
	public function metaboxAddress($entry = NULL)
	{
		global $connections;
		
		echo  '<div class="form-field addresses">';
			echo  '<div id="addresses">';
				
				// --> Start template for Addresses <-- \\
				echo  '<textarea id="address_row_base" style="display: none">';
					echo  '<div class="form-field connectionsform address">';
					echo  '<div class="address">';
						echo  '<span class="selectbox alignright">Type: ' . $this->buildSelect('address[::FIELD::][type]', $connections->options->getDefaultAddressValues() ) . '</span>';
						echo  '<div class="clear"></div>';
						
							echo  '<label for="address">Address Line 1:</label>';
							echo  '<input type="text" name="address[::FIELD::][address_line1]" value="" />';
				
							echo  '<label for="address">Address Line 2:</label>';
							echo  '<input type="text" name="address[::FIELD::][address_line2]" value="" />';
				
							echo  '<div class="input" style="width:60%">';
								echo  '<label for="address">City:</label>';
								echo  '<input type="text" name="address[::FIELD::][city]" value="" />';
							echo  '</div>';
							echo  '<div class="input" style="width:15%">';
								echo  '<label for="address">State:</label>';
								echo  '<input type="text" name="address[::FIELD::][state]" value="" />';
							echo  '</div>';
							echo  '<div class="input" style="width:25%">';
								echo  '<label for="address">Zipcode:</label>';
								echo  '<input type="text" name="address[::FIELD::][zipcode]" value="" />';
							echo  '</div>';
							
							echo  '<label for="address">Country</label>';
							echo  '<input type="text" name="address[::FIELD::][country]" value="" />';
							
							echo  '<div class="input" style="width:50%">';
								echo  '<label for="latitude">Latitude</label>';
								echo  '<input type="text" name="address[::FIELD::][latitude]" value="" />';
							echo  '</div>';
							echo  '<div class="input" style="width:50%">';
								echo  '<label for="longitude">Longitude</label>';
								echo  '<input type="text" name="address[::FIELD::][longitude]" value="" />';
							echo  '</div>';
							
							echo  '<input type="hidden" name="address[::FIELD::][visibility]" value="public" />';
						
							echo  '<div class="clear"></div>';
							echo  '<br />';
							echo  '<p><a href="#" id="remove_button_::FIELD::" class="button button-warning" onClick="removeEntryRow(\'#address_row_::FIELD::\'); return false;">Remove</a></p>';
					echo  '</div>';
					echo  '</div>';
				echo  '</textarea>';
				// --> End template for Addresses <-- \\
				
				//if ( !empty($data->addresses) )
				if ( $entry->getAddresses() )
				{
					$addressValues = $entry->getAddresses();
					
					if ( !empty($addressValues) )
					{
						foreach ($addressValues as $address)
						{
							$token = $this->token($entry->getId());
							echo  '<div class="form-field connectionsform address" id="address_row_'  . $token . '">';
								
								$selectName = 'address['  . $token . '][type]';
							
								echo  '<span class="selectbox alignright">Type: ' . $this->buildSelect($selectName, $connections->options->getDefaultAddressValues(), $address->type) . '</span>';
								echo  '<div class="clear"></div>';
								
								echo  '<label for="address">Address Line 1:</label>';
								echo  '<input type="text" name="address[' . $token . '][address_line1]" value="' . $address->line_one . '" />';
					
								echo  '<label for="address">Address Line 2:</label>';
								echo  '<input type="text" name="address[' . $token . '][address_line2]" value="' . $address->line_two . '" />';
					
								echo  '<div class="input" style="width:60%">';
									echo  '<label for="address">City:</label>';
									echo  '<input type="text" name="address[' . $token . '][city]" value="' . $address->city . '" />';
								echo  '</div>';
								echo  '<div class="input" style="width:15%">';
									echo  '<label for="address">State:</label>';
									echo  '<input type="text" name="address[' . $token . '][state]" value="' . $address->state . '" />';
								echo  '</div>';
								echo  '<div class="input" style="width:25%">';
									echo  '<label for="address">Zipcode:</label>';
									echo  '<input type="text" name="address[' . $token . '][zipcode]" value="' . $address->zipcode . '" />';
								echo  '</div>';
								
								echo  '<label for="address">Country</label>';
								echo  '<input type="text" name="address[' . $token . '][country]" value="' . $address->country . '" />';
								
								echo  '<div class="input" style="width:50%">';
									echo  '<label for="latitude">Latitude</label>';
									echo  '<input type="text" name="address[' . $token . '][latitude]" value="' . $address->latitude . '" />';
								echo  '</div>';
								echo  '<div class="input" style="width:50%">';
									echo  '<label for="longitude">Longitude</label>';
									echo  '<input type="text" name="address[' . $token . '][longitude]" value="' . $address->longitude . '" />';
								echo  '</div>';
								
								echo  '<input type="hidden" name="address[' . $token . '][visibility]" value="' . $address->visibility . '" />';
							
								echo  '<div class="clear"></div>';
								echo  '<br />';
								echo  '<p><a href="#" id="remove_button_'. $token . '" class="button button-warning" onClick="removeEntryRow(\'#address_row_'. $token . '\'); return false;">Remove</a></p>';
								
							echo  '</div>';
							
						}
					}
				}
				
			echo  '</div>';
			echo  '<p class="add"><a id="add_address" class="button">Add Address</a></p>';
		echo  '</div>';
	}
	
	public function metaboxPhone($entry = NULL)
	{
		global $connections;
		
		echo  '<div id="phone_numbers">';
			
			// --> Start template for Phone Numbers <-- \\
			echo  '<textarea id="phone_number_row_base" style="display: none">';
				echo  '<div class="form-field connectionsform phone_number">';
				echo  $this->buildSelect('phone_numbers[::FIELD::][type]', $connections->options->getDefaultPhoneNumberValues());
				echo  '<input type="text" name="phone_numbers[::FIELD::][number]" value="" style="width: 30%"/>';
				echo  '<input type="hidden" name="phone_numbers[::FIELD::][visibility]" value="public" />';
				echo  '<a href="#" id="remove_button_::FIELD::" class="button button-warning" onClick="removeEntryRow(\'#phone_number_row_::FIELD::\'); return false;">Remove</a>';
				echo  '</div>';
			echo  '</textarea>';
			// --> End template for Phone Numbers <-- \\
			
			//if ( isset($data->phone_numbers) )
			if ( $entry->getPhoneNumbers() )
			{
				$phoneNumberValues = $entry->getPhoneNumbers();
				
				if ( !empty($phoneNumberValues) )
				{
					foreach ($phoneNumberValues as $phone)
					{
						if ($phone->number != NULL)
						{
							$token = $this->token($entry->getId());
							echo  '<div class="form-field connectionsform phone_number" id="phone_number_row_'  . $token . '">';
								echo  '<div class="phone_number_row">';
									echo  $this->buildSelect('phone_numbers[' . $token . '][type]', $connections->options->getDefaultPhoneNumberValues(), $phone->type);
									echo  '<input type="text" name="phone_numbers[' . $token . '][number]" value="' . $phone->number . '" style="width: 30%"/>';
									echo  '<input type="hidden" name="phone_numbers[' . $token . '][visibility]" value="' . $phone->visibility . '" />';
									echo  '<a href="#" id="remove_button_'. $token . '" class="button button-warning" onClick="removeEntryRow(\'#phone_number_row_'. $token . '\'); return false;">Remove</a>';
								echo  '</div>';
							echo  '</div>';
						}
					}
				}
			}
			
		echo  '</div>';
		echo  '<p class="add"><a id="add_phone_number" class="button">Add Phone Number</a></p>';
	}
	
	public function metaboxEmail($entry = NULL)
	{
		global $connections;
		
		echo  '<div id="email_addresses">';
				
			// --> Start template for Email Addresses <-- \\
			echo  '<textarea id="email_address_row_base" style="display: none">';
			echo  '<div class="form-field connectionsform email">';
				echo  $this->buildSelect('email[::FIELD::][type]', $connections->options->getDefaultEmailValues());
				echo  '<input type="text" name="email[::FIELD::][address]" value="" style="width: 30%"/>';
				echo  '<input type="hidden" name="email[::FIELD::][visibility]" value="public" />';
				echo  '<a href="#" id="remove_button_::FIELD::" class="button button-warning" onClick="removeEntryRow(\'#email_address_row_::FIELD::\'); return false;">Remove</a>';
				echo  '</div>';
			echo  '</textarea>';
			// --> End template for Email Addresses <-- \\
			
			//if ( !empty($data->email) )
			if ( $entry->getEmailAddresses() )
			{
				$emailValues = $entry->getEmailAddresses();
				
				if ( !empty($emailValues) )
				{
					foreach ($emailValues as $emailRow)
					{
						if ($emailRow->address != NULL)
						{
							$token = $this->token($entry->getId());
							echo  '<div class="form-field connectionsform email" id="email_address_row_'  . $token . '">';
								echo  '<div class="email_address_row">';
									echo  $this->buildSelect('email[' . $token . '][type]', $connections->options->getDefaultEmailValues(), $emailRow->type);
									echo  '<input type="text" name="email[' . $token . '][address]" value="' . $emailRow->address . '" style="width: 30%"/>';
									echo  '<input type="hidden" name="email[' . $token . '][visibility]" value="' . $emailRow->visibility . '" />';
									echo  '<a href="#" id="remove_button_'. $token . '" class="button button-warning" onClick="removeEntryRow(\'#email_address_row_'. $token . '\'); return false;">Remove</a>';
								echo  '</div>';
							echo  '</div>';
						}
					}
				}
			}
			
		echo  '</div>';
		echo  '<p class="add"><a id="add_email_address" class="button">Add Email Address</a></p>';
	}
	
	public function metaboxMessenger($entry = NULL)
	{
		global $connections;
		
		echo  '<div id="im_ids">';
				
			// --> Start template for IM IDs <-- \\
			echo  '<textarea id="im_row_base" style="display: none">';
				echo  '<div class="form-field connectionsform im">';
				echo  $this->buildSelect('im[::FIELD::][type]', $connections->options->getDefaultIMValues());
				echo  '<input type="text" name="im[::FIELD::][id]" value="" style="width: 30%"/>';
				echo  '<input type="hidden" name="im[::FIELD::][visibility]" value="public" />';
				echo  '<a href="#" id="remove_button_::FIELD::" class="button button-warning" onClick="removeEntryRow(\'#im_row_::FIELD::\'); return false;">Remove</a>';
				echo  '</div>';
			echo  '</textarea>';
			// --> End template for IM IDs <-- \\
			
			//if ( !empty($data->im) )
			if ( $entry->getIm() )
			{
				$imValues = $entry->getIm();
				
				if ( !empty($imValues) )
				{
					foreach ($imValues as $imRow)
					{
						if ($imRow->id != null)
						{
							$token = $this->token($entry->getId());
							echo  '<div class="form-field connectionsform im" id="im_row_'  . $token . '">';
								echo  '<div class="im_row">';
									echo  $this->buildSelect('im[' . $token . '][type]', $connections->options->getDefaultIMValues(), $imRow->type);
									echo  '<input type="text" name="im[' . $token . '][id]" value="' . $imRow->id . '" style="width: 30%"/>';
									echo  '<input type="hidden" name="im[' . $token . '][visibility]" value="' . $imRow->visibility . '" />';
									echo  '<a href="#" id="remove_button_'. $token . '" class="button button-warning" onClick="removeEntryRow(\'#im_row_'. $token . '\'); return false;">Remove</a>';
								echo  '</div>';
							echo  '</div>';
						}
					}
				}
			}
			
		echo  '</div>';
		echo  '<p class="add"><a id="add_im_id" class="button">Add Messenger ID</a></p>';
	}
	
	public function metaboxSocialMedia($entry = NULL)
	{
		global $connections;
		
		echo  '<div id="social_media">';
				
			// --> Start template for Social Media IDs <-- \\
			echo  '<textarea id="social_media_row_base" style="display: none">';
				echo  '<div class="form-field connectionsform socialmedia">';
				echo  $this->buildSelect('social_media[::FIELD::][type]', $connections->options->getDefaultSocialMediaValues());
				echo  '<input type="text" name="social_media[::FIELD::][id]" style="width: 30%" value="http://" />';
				echo  '<input type="hidden" name="social_media[::FIELD::][visibility]" value="public"/>';
				echo  '<a href="#" id="remove_button_::FIELD::" class="button button-warning" onClick="removeEntryRow(\'#social_media_row_::FIELD::\'); return false;">Remove</a>';
				echo  '</div>';
			echo  '</textarea>';
			// --> End template for Social Media IDs <-- \\
			
			//if ( !empty($data->social) )
			if ( $entry->getSocialMedia() )
			{
				$socialMedia = $entry->getSocialMedia();
				
				if ( !empty($socialMedia) )
				{
					foreach ($socialMedia as $socialNetwork)
					{
						if ($socialNetwork->id != null)
						{
							$token = $this->token($entry->getId());
							echo  '<div class="form-field connectionsform socialmedia" id="social_media_row_'  . $token . '">';
								echo  '<div class="social_media_row">';
									echo  $this->buildSelect('social_media[' . $token . '][type]', $connections->options->getDefaultSocialMediaValues(), $socialNetwork->type);
									echo  '<input type="text" name="social_media[' . $token . '][id]" value="' . $socialNetwork->id . '" style="width: 30%"/>';
									echo  '<input type="hidden" name="social_media[' . $token . '][visibility]" value="' . $socialNetwork->visibility . '" />';
									echo  '<a href="#" id="remove_button_'. $token . '" class="button button-warning" onClick="removeEntryRow(\'#social_media_row_'. $token . '\'); return false;">Remove</a>';
								echo  '</div>';
							echo  '</div>';
						}
					}
				}
			}
		
		echo  '</div>';
		echo  '<p class="add"><a id="add_social_media" class="button">Add Social Media ID</a></p>';
	}
	
	public function metaboxWebsite($entry = NULL)
	{
		global $connections;
		
		echo  '<div id="website_addresses">';
			
			// --> Start template for Website Addresses <-- \\
			echo  '<textarea id="website_address_row_base" style="display: none">';
				echo  '<div class="form-field connectionsform websites">';
				echo  '<label for="websites">Website: <input type="text" name="website[::FIELD::][address]" style="width: 50%" value="http://" /></label>';
				echo  '<input type="hidden" name="website[::FIELD::][type]" value="personal" />';
				echo  '<input type="hidden" name="website[::FIELD::][name]" value="Personal" />';
				echo  '<input type="hidden" name="website[::FIELD::][visibility]" value="public"/>';
				echo  '<a href="#" id="remove_button_::FIELD::" class="button button-warning" onClick="removeEntryRow(\'#website_address_row_::FIELD::\'); return false;">Remove</a>';
				echo  '</div>';
			echo  '</textarea>';
			// --> End template for Website Addresses <-- \\
			
			$websites = $entry->getWebsites();
			
			if ( !empty($websites) )
			{
				foreach ($websites as $website)
				{
					if ($website->url == NULL) continue;
					
					$token = $this->token($entry->getId());
					
					echo  '<div class="form-field connectionsform websites" id="website_address_row_'  . $token . '">';
						echo  '<div class="website_address_row">';
							echo  '<label for="websites">Website: <input type="text" name="website[' . $token . '][address]" style="width: 50%" value="' . $website->url . '" /></label>';
							echo  '<input type="hidden" name="website[' . $token . '][type]" value="personal" />';
							echo  '<input type="hidden" name="website[' . $token . '][name]" value="Personal" />';
							echo  '<input type="hidden" name="website[' . $token . '][visibility]" value="public" />';
							echo  '<a href="#" id="remove_button_'. $token . '" class="button button-warning" onClick="removeEntryRow(\'#website_address_row_'. $token . '\'); return false;">Remove</a>';
						echo  '</div>';
					echo  '</div>';
				}
			}
			
		echo  '</div>';
		echo  '<p class="add"><a id="add_website_address" class="button">Add Website Address</a></p>';
	}
	
	public function metaboxBirthday($entry = NULL)
	{
		$date = new cnDate();
		
		echo "<div class='form-field celebrate'>
				<span class='selectbox'>Birthday: " . $this->buildSelect('birthday_month',$date->months,$date->getMonth($entry->getBirthday())) . "</span>
				<span class='selectbox'>" . $this->buildSelect('birthday_day',$date->days,$date->getDay($entry->getBirthday())) . "</span>
		</div>";
	}
	
	public function metaboxAnniversary($entry = NULL)
	{
		$date = new cnDate();
		
		echo "<div class='form-field celebrate'>
				<span class='selectbox'>Anniversary: " . $this->buildSelect('anniversary_month',$date->months,$date->getMonth($entry->getAnniversary())) . "</span>
				<span class='selectbox'>" . $this->buildSelect('anniversary_day',$date->days,$date->getDay($entry->getAnniversary())) . "</span>
		</div>";
	}
	
	public function metaboxBio($entry = NULL)
	{
		echo "<div class='form-field'>
				
				<a class='button alignright' id='toggleBioEditor'>Toggle Editor</a>
				
				<textarea class='tinymce' id='bio' name='bio' rows='15'>" . $entry->getBio() . "</textarea>
				<p><strong>Permitted tags:</strong> &lt;p&gt; &lt;ul&gt; &lt;ol&gt; &lt;li&gt; &lt;span&gt; &lt;a&gt; &lt;b&gt; &lt;strong&gt; &lt;i&gt; &lt;em&gt; &lt;u&gt; &lt;br&gt;</p>
		</div>";
	}
	
	public function metaboxNotes($entry = NULL)
	{
		echo "<div class='form-field'>
				
				<a class='button alignright' id='toggleNoteEditor'>Toggle Editor</a>
				
				<textarea class='tinymce' id='note' name='notes' rows='15'>" . $entry->getNotes() . "</textarea>
				<p><strong>Permitted tags:</strong> &lt;p&gt; &lt;ul&gt; &lt;ol&gt; &lt;li&gt; &lt;span&gt; &lt;a&gt; &lt;b&gt; &lt;strong&gt; &lt;i&gt; &lt;em&gt; &lt;u&gt; &lt;br&gt;</p>
		</div>";
	}
	
	private function getEntrySelect($name, $selected = NULL)
	{
		global $wpdb, $connections;
		
		$atts['list_type'] = 'individual';
		$atts['category'] = NULL;
		$atts['visibility'] = NULL;
		
		$results = $connections->retrieve->entries($atts);
		
	    $out = '<select name="' . $name . '">';
			$out .= '<option value="">Select Entry</option>';
			foreach($results as $row)
			{
				$entry = new cnEntry($row);
				$out .= '<option value="' . $entry->getId() . '"';
				if ($selected == $entry->getId()) $out .= ' SELECTED';
				$out .= '>' . $entry->getFullLastFirstName() . '</option>';
			}
		$out .= '</select>';
		
		return $out;
	}
}


class cnCategoryObjects
{
	private $rowClass = '';
		
	public function buildCategoryRow($type, $parents, $level = 0, $selected = NULL)
	{
		$out = NULL;
		
		foreach ($parents as $child)
		{
			$category = new cnCategory($child);
			
			if ($type === 'table') $out .= $this->buildTableRowHTML($child, $level);
			if ($type === 'option') $out .= $this->buildOptionRowHTML($child, $level, $selected);
			if ($type === 'checklist') $out .= $this->buildCheckListHTML($child, $level, $selected);
			
			if (is_array($category->getChildren()))
			{
				++$level;
				if ($type === 'table') $out .= $this->buildCategoryRow('table', $category->getChildren(), $level);
				if ($type === 'option') $out .= $this->buildCategoryRow('option', $category->getChildren(), $level, $selected);
				if ($type === 'checklist') $out .= $this->buildCategoryRow('checklist', $category->getChildren(), $level, $selected);
				--$level;
			}
			
		}
		
		$level = 0;
		return $out;
	}
	
	private function buildTableRowHTML($term, $level)
	{
		global $connections;
		$form = new cnFormObjects();
		$category = new cnCategory($term);
		$pad = str_repeat('&#8212; ', max(0, $level));
		$this->rowClass = 'alternate' == $this->rowClass ? '' : 'alternate';
		
		/*
		 * Genreate the edit & delete tokens.
		 */
		$editToken = $form->tokenURL('admin.php?page=connections_categories&action=edit&id=' . $category->getId(), 'category_edit_' . $category->getId());
		$deleteToken = $form->tokenURL('admin.php?page=connections_categories&action=delete&id=' . $category->getId(), 'category_delete_' . $category->getId());
		
		$out = '<tr id="cat-' . $category->getId() . '" class="' . $this->rowClass . '">';
			$out .= '<th class="check-column">';
				$out .= '<input type="checkbox" name="category[]" value="' . $category->getId() . '"/>';
			$out .= '</th>';
			$out .= '<td class="name column-name"><a class="row-title" href="' . $editToken . '">' . $pad . $category->getName() . '</a><br />';
				$out .= '<div class="row-actions">';
					$out .= '<span class="edit"><a href="' . $editToken . '">Edit</a> | </span>';
					$out .= '<span class="delete"><a onclick="return confirm(\'You are about to delete this category. \\\'Cancel\\\' to stop, \\\'OK\\\' to delete\');" href="' . $deleteToken . '">Delete</a></span>';
				$out .= '</div>';
			$out .= '</td>';
			$out .= '<td class="description column-description">' . $category->getDescription() . '</td>';
			$out .= '<td class="slug column-slug">' . $category->getSlug() . '</td>';
			$out .= '<td>';
				/*
				 * Genreate the category link token URL.
				 */
				$categoryFilterURL = $form->tokenURL('admin.php?page=connections&action=filter&category_id=' . $category->getId(), 'filter');
				
				if ( (integer) $category->getCount() > 0 )
				{
					$out .= '<strong>Count:</strong> ' . '<a href="' . $categoryFilterURL . '">' . $category->getCount() . '</a><br />';
				}
				else
				{
					$out .= '<strong>Count:</strong> ' . $category->getCount() . '<br />';
				}
				
				$out .= '<strong>ID:</strong> ' . $category->getId();
			$out .= '</td>';
		$out .= '</tr>';
		
		return $out;
	}
	
	private function buildOptionRowHTML($term, $level, $selected)
	{
		global $rowClass;
		$selectString = NULL;
		
		$category = new cnCategory($term);
		$pad = str_repeat('&nbsp;&nbsp;&nbsp;', max(0, $level));
		if ($selected == $category->getId()) $selectString = ' SELECTED ';
		
		$out = '<option value="' . $category->getId() . '"' . $selectString . '>' . $pad . $category->getName() . '</option>';
		
		return $out;
	}
	
	private function buildCheckListHTML($term, $level, $checked)
	{
		global $rowClass;
		
		$category = new cnCategory($term);
		$pad = str_repeat('&nbsp;&nbsp;&nbsp;', max(0, $level));
		
		if (!empty($checked))
		{
			if (in_array($category->getId(), $checked))
			{
				$checkString = ' CHECKED ';
			}
			else
			{
				$checkString = NULL;
			}
		}
		else
		{
			$checkString = NULL;
		}
		
		$out = '<li id="category-' . $category->getId() . '" class="category"><label class="selectit">' . $pad . '<input id="check-category-' . $category->getId() . '" type="checkbox" name="entry_category[]" value="' . $category->getId() . '" ' . $checkString . '> ' . $category->getName() . '</input></label></li>';
		
		return $out;
	}
	
	public function showForm($data = NULL)
	{
		global $connections;
		$form = new cnFormObjects();
		$category = new cnCategory($data);
		$parent = new cnCategory($connections->retrieve->category($category->getParent()));
		$level = NULL;
		
		$out = '<div class="form-field form-required connectionsform">';
			$out .= '<label for="cat_name">Category Name</label>';
			$out .= '<input type="text" aria-required="true" size="40" value="' . $category->getName() . '" id="category_name" name="category_name"/>';
			$out .= '<input type="hidden" value="' . $category->getID() . '" id="category_id" name="category_id"/>';
		$out .= '</div>';
		
		$out .= '<div class="form-field connectionsform">';
			$out .= '<label for="category_nicename">Category Slug</label>';
			$out .= '<input type="text" size="40" value="' . $category->getSlug() . '" id="category_slug" name="category_slug"/>';
		$out .= '</div>';
		
		$out .= '<div class="form-field connectionsform">';
			$out .= '<label for="category_parent">Category Parent</label>';
			$out .= '<select class="postform" id="category_parent" name="category_parent">';
				$out .= '<option value="0">None</option>';
				$out .= $this->buildCategoryRow('option', $connections->retrieve->categories(), $level, $parent->getID());
			$out .= '</select>';
		$out .= '</div>';
		
		$out .= '<div class="form-field connectionsform">';
			$out .= '<label for="category_description">Description</label>';
			$out .= '<textarea cols="40" rows="5" id="category_description" name="category_description">' . $category->getDescription() . '</textarea>';
		$out .= '</div>';
		
		echo $out;
	}
}

?>