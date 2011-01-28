<?php

class cnOutput extends cnEntry
{
	public function getCardImage()
	{
		if ( $this->getImageLinked() && $this->getImageDisplay() )
		{
			//if ( is_file(CN_IMAGE_PATH . $this->getImageNameCard()) ) 
			echo '<img class="photo" alt="Photo of ' . $this->getFirstName() . ' ' . $this->getLastName() . '" style="-moz-border-radius:4px; background-color: #FFFFFF; border:1px solid #E3E3E3; margin-bottom:10px; padding:5px;" src="' . CN_IMAGE_BASE_URL . $this->getImageNameCard() . '" />';
		}
	}
	
	public function getProfileImage()
	{
		if ( $this->getImageLinked() && $this->getImageDisplay() )
		{
			//if ( is_file(CN_IMAGE_PATH . $this->getImageNameProfile()) ) 
			echo '<img class="photo" alt="Photo of ' . $this->getFirstName() . ' ' . $this->getLastName() . '" style="-moz-border-radius:4px; background-color: #FFFFFF; border:1px solid #E3E3E3; margin-bottom:10px; padding:5px;" src="' . CN_IMAGE_BASE_URL . $this->getImageNameProfile() . '" />';
		}
	}
	
	public function getThumbnailImage( $atts = NULL )
	{
		global $connections;
		
		$defaultAtts = array( 'default' => FALSE, 'place_holder' => FALSE, 'style' => NULL, 'return' => FALSE );
		
		$atts = $this->validate->attributesArray($defaultAtts, (array) $atts);
		
		if ( $this->getImageLinked() && $this->getImageDisplay())
		{
			//if ( is_file(CN_IMAGE_PATH . $this->getImageNameThumbnail()) ) 
			$out = '<img class="photo" alt="Photo of ' . $this->getFirstName() . ' ' . $this->getLastName() . '" style="-moz-border-radius:4px; background-color: #FFFFFF; border:1px solid #E3E3E3; margin-bottom:10px; padding:5px;" src="' . CN_IMAGE_BASE_URL . $this->getImageNameThumbnail() . '" />';
		}
		elseif ( $atts['place_holder'] )
		{
			$out = '<div class="cn_thumbnail_place_holder" style="height: ' . $connections->options->getImgThumbY() . 'px ; width: ' . $connections->options->getImgThumbX() . 'px"></div>';
		}
		
		if ( $atts['return'] ) return $out;
		echo $out;
	}
	
	/**
	 * Echo the logo if associated in a HTML hCard compliant string.
	 * 
	 * Accepted option for the $atts property are:
	 * 		tag == string -- HTML tag.
	 * 		id == string -- The tag id.
	 * 		class == string -- The tag class.
	 * 		alt == string -- The tag alt text.
	 * 		title == string -- The tag title text.
	 * 		src == string -- The image source.
	 * 		longdesc == string -- URL to document containing text for image long description.
	 * 		style == associative array -- Customize an inline stlye tag. Array format key == attribute; value == value.
	 * 		before == string -- HTML to output before the logo.
	 *  	after == string -- HTML to output after the logo.
	 * 		display == string -- Display place holder area or default image or logo. Permitted values are logo, place_holder, default, blank.
	 * 		return == TRUE || FALSE -- Return string if set to TRUE instead of echo string.
	 * 
	 * @param array $atts [optional]
	 * @return string
	 */
	public function getLogoImage( $atts = NULL )
	{
		global $connections;
		
		$defaultAtts = array( 'tag' => array(),
							  'id' => NULL,
							  'class' => NULL,
							  'alt' => NULL,
							  'title' => NULL,
							  'src' => NULL,
							  'longdesc' => NULL,
							  'style' => NULL,
							  'before' => NULL,
							  'after' => NULL,
							  'display' => 'logo',
							  'return' => FALSE
							);
		
		$atts = $this->validate->attributesArray($defaultAtts, (array) $atts);
		$nonAtts = array('default', 'display', 'return', 'tag');
		
		$displayValues = array('logo', 'default', 'place_holder', 'blank');
		if ( !in_array($atts['display'], $displayValues) ) return NULL;
		
		$imageDimesion['height'] = $connections->options->getImgLogoY() . 'px';
		$imageDimesion['width'] = $connections->options->getImgLogoX() . 'px';
		
		switch ( $atts['display'] )
		{
			case 'logo':
				if ( $this->getLogoLinked() && $this->getLogoDisplay() )
				{
					if ( empty($atts['tag']) ) $atts['tag'] = 'img';
					if ( empty($atts['class']) ) $atts['class'] = 'logo';
					if ( empty($atts['alt']) ) $atts['alt'] = 'Logo for ' . $this->getFirstName() . ' ' . $this->getLastName();
					if ( empty($atts['title']) ) $atts['title'] = 'Logo for ' . $this->getFirstName() . ' ' . $this->getLastName();
					if ( empty($atts['style']) ) $atts['style'] = array('-moz-border-radius' => '4px', 'background-color' => '#FFFFFF', 'border' => '1px solid #E3E3E3', 'margin-bottom' => '10px', 'padding' => '5px');
					
					$atts['src'] = CN_IMAGE_BASE_URL . $this->getLogoName();
					$atts['height'] = $imageDimesion['height'];
					$atts['width'] = $imageDimesion['width'];
				}
				else
				{
					return NULL;
				}
			break;
			
			case 'place_holder':
				if ( empty($atts['tag']) ) $atts['tag'] = 'div';
				if ( empty($atts['class']) ) $atts['class'] = 'cn_logo_place_holder';
				
				$atts['style'] = array_merge( (array) $atts['style'], $imageDimesion);
			break;
			
			case 'default':
			break;
			
			case 'blank':
				return NULL;
			break;
			
			default:
				return NULL;
			break;
		}
		
		
		foreach ( (array) $atts['style'] as $attr => $value )
		{
			if ( !empty($value) ) $style[] = "$attr: $value;";
		}
		
		if ( !empty($style) ) $atts['style'] = implode(' ', $style);
		
			
		foreach ( $atts as $attr => $value)
		{
			if ( !empty($value) && !in_array($attr, $nonAtts) ) $tag[] = "$attr=\"$value\"";
		}
		
		if ( !empty($atts['before']) ) $out = $atts['before'];
		
		$out .= '<' . $atts['tag'] . ' ' . implode(' ', $tag) . '></' . $atts['tag'] . '>';
		
		if ( !empty($atts['after']) ) $out .= $atts['after'];
		
		if ( $atts['return'] ) return $out;
		echo $out;
	}
	
	public function getNameBlock($atts = NULL)
	{
		//global $connections;
		
		$defaultAtts = array( 'format' => '%prefix% %first% %middle% %last% %suffix%',
							  'return' => FALSE
							);
		
		$atts = $this->validate->attributesArray($defaultAtts, (array) $atts);
		
		$search = array('%prefix%', '%first%', '%middle%', '%last%', '%suffix%');
		$replace = array();
		
		switch ( $this->getEntryType() )
		{
			case 'individual':
				
				( $this->getHonorificPrefix() ) ? $replace[] = '<span class="honorific-prefix">' . $this->getHonorificPrefix() . '</span>' : $replace[] = '';;
				
				( $this->getFirstName() ) ? $replace[] = '<span class="given-name">' . $this->getFirstName() . '</span>' : $replace[] = '';
				
				( $this->getMiddleName() ) ? $replace[] = '<span class="additional-name">' . $this->getMiddleName() . '</span>' : $replace[] = '';
				
				( $this->getLastName() ) ? $replace[] = '<span class="family-name">' . $this->getLastName() . '</span>' : $replace[] = '';
				
				( $this->getHonorificSuffix() ) ? $replace[] = '<span class="honorific-suffix">' . $this->getHonorificSuffix() . '</span>' : $replace[] = '';
				
				$out = '<span class="fn n">' . str_ireplace( $search, $replace, $atts['format'] ) . '</span>';
			break;
			
			case 'organization':
				$out = '<span class="fn org">' . $this->getOrganization() . '</span>';
			break;
			
			case 'family':
				$out = '<span class="fn n"><span class="family-name">' . $this->getFamilyName() . '</span></span>';
			break;
		}
		
		
		if ( $atts['return'] ) return $out;
		echo $out;
	}
	
    public function getFullFirstLastNameBlock()
    {
        return $this->getNameBlock( array('format' => '%prefix% %first% %middle% %last% %suffix%', 'return' => TRUE) );		
    }
        
    public function getFullLastFirstNameBlock()
    {
    	return $this->getNameBlock( array('format' => '%last%, %first% %middle%', 'return' => TRUE) );	
    }
	
	/**
	 * Echos the family members of the family entry type.
	 * 
	 * @deprecated since 0.7.1.0
	 */
	public function getConnectionGroupBlock()
	{
		$this->getFamilyMemberBlock();
	}
	
	/**
	 * Echos the family members of the family entry type.
	 */
	public function getFamilyMemberBlock()
	{
		if ( $this->getFamilyMembers() )
		{
			global $connections;
			
			foreach ($this->getFamilyMembers() as $key => $value)
			{
				$relation = new cnEntry();
				$relation->set($key);
				echo '<span><strong>' . $connections->options->getFamilyRelation($value) . ':</strong> ' . $relation->getFullFirstLastName() . '</span><br />' . "\n";
				unset($relation);
			}
		}
	}
	
	public function getTitleBlock()
	{
		if ($this->getTitle()) return '<span class="title">' . $this->getTitle() . '</span>' . "\n";
	}
	
	public function getOrgUnitBlock()
	{
		if ($this->getOrganization() || $this->getDepartment()) $out = '<div class="org">' . "\n";
			if ($this->getOrganization() && $this->getEntryType() != 'organization') $out .= '<span class="organization-name">' . $this->getOrganization() . '</span><br />' . "\n";
			if ($this->getDepartment()) $out .= '<span class="organization-unit">' . $this->getDepartment() . '</span><br />' . "\n";
		if ($this->getOrganization() || $this->getDepartment()) $out .= '</div>' . "\n";
		
		return $out;
	}
	
	public function getOrganizationBlock()
	{
		if ($this->getOrganization() && $this->getEntryType() != 'organization') return '<span class="org">' . $this->getOrganization() . '</span>' . "\n";
	}
	
	public function getDepartmentBlock()
	{
		if ($this->getDepartment()) return '<span class="org"><span class="organization-unit">' . $this->getDepartment() . '</span></span>' . "\n";
	}
	
	public function getAddressBlock()
	{
		if ($this->getAddresses())
		{
			foreach ($this->getAddresses() as $address)
			{
				$out .= '<div class="adr" style="margin-bottom: 10px;">' . "\n";
					if ($address->name != NULL || $address->type != NULL) $out .= '<span class="address_name"><strong>' . $address->name . '</strong></span><br />' . "\n"; //The OR is for compatiblity for 0.2.24 and under
					if ($address->line_one != NULL) $out .= '<div class="street-address">' . $address->line_one . '</div>' . "\n";
					if ($address->line_two != NULL) $out .= '<div class="extended-address">' . $address->line_two . '</div>' . "\n";
					if ($address->city != NULL) $out .= '<span class="locality">' . $address->city . '</span>&nbsp;' . "\n";
					if ($address->state != NULL) $out .= '<span class="region">' . $address->state . '</span>&nbsp;' . "\n";
					if ($address->zipcode != NULL) $out .= '<span class="postal-code">' . $address->zipcode . '</span><br />' . "\n";
					if ($address->country != NULL) $out .= '<span class="country-name">' . $address->country . '</span>' . "\n";
					$out .= $this->gethCardAdrType($address->type);
				$out .= '</div>' . "\n\n";
															
			}
		}
		return $out;
	}
	
	public function getPhoneNumberBlock()
	{
		if ($this->getPhoneNumbers())
		{
			$out .= '<div class="phone-number-block" style="margin-bottom: 10px;">' . "\n";
			foreach ($this->getPhoneNumbers() as $phone) 
			{
				//Type for hCard compatibility. Hidden.
				if ($phone->number != null) $out .=  '<strong>' . $phone->name . '</strong>: <span class="tel">' . $this->gethCardTelType($phone->type) . '<span class="value">' .  $phone->number . '</span></span><br />' . "\n";
			}
			$out .= '</div>' . "\n";
		}
		return $out;
	}
	
	public function gethCardTelType($data)
    {
        //This is here for compatibility for versions 0.2.24 and earlier;
		switch ($data)
		{
			case 'home':
				$type = '<span class="type" style="display: none;">home</span>';
				break;
			case 'homephone':
				$type = '<span class="type" style="display: none;">home</span>';
				break;
			case 'homefax':
				$type = '<span class="type" style="display: none;">home</span><span class="type" style="display: none;">fax</span>';
				break;
			case 'cell':
				$type = '<span class="type" style="display: none;">cell</span>';
				break;
			case 'cellphone':
				$type = '<span class="type" style="display: none;">cell</span>';
				break;
			case 'work':
				$type = '<span class="type" style="display: none;">work</span>';
				break;
			case 'workphone':
				$type = '<span class="type" style="display: none;">work</span>';
				break;
			case 'workfax':
				$type = '<span class="type" style="display: none;">work</span><span class="type" style="display: none;">fax</span>';
				break;
			case 'fax':
				$type = '<span class="type" style="display: none;">work</span><span class="type" style="display: none;">fax</span>';
				break;
			
			default:
				$type = $data;
			break;
		}
		
		return $type;
    }
	
	public function gethCardAdrType($data)
    {
        //This is here for compatibility for versions 0.2.24 and earlier;
		switch ($data)
		{
			case 'home':
				$type = '<span class="type" style="display: none;">home</span>';
				break;
			case 'work':
				$type = '<span class="type" style="display: none;">work</span>';
				break;
			case 'school':
				$type = '<span class="type" style="display: none;">school</span>';
				break;
			case 'other':
				$type = '<span class="type" style="display: none;">other</span>';
				break;
			
			default:
				if ($this->getEntryType() == 'individual')
				{
					$type = '<span class="type" style="display: none;">home</span>';
				}
				elseif ($this->getEntryType() == 'organization')
				{
					$type = '<span class="type" style="display: none;">work</span>';
				}
			break;
		}
		
		return $type;
    }
	
	public function getEmailAddressBlock()
	{
		if ($this->getEmailAddresses())
		{
			$out .= '<div class="email-address-block">' . "\n";
			foreach ($this->getEmailAddresses() as $email)
			{
				//Type for hCard compatibility. Hidden.
				if ($email->address != NULL) $out .= '<strong>' . $email->name . ':</strong><br /><span class="email"><span class="type" style="display: none;">INTERNET</span><a class="value" href="mailto:' . $email->address . '">' . $email->address . '</a></span><br /><br />' . "\n";
			}
			$out .= '</div>' . "\n";
		}
		
		$out = apply_filters('cn_output_email_addresses', $out);
		
		return $out;
	}
	
	public function getImBlock()
	{
		if ($this->getIm())
		{
			/**
			 * @TODO: Out as clickable links using hCard spec.
			 */
			$out = '<div class="im-block" style="margin-bottom: 10px;">' . "\n";
			foreach ($this->getIm() as $imRow)
			{
				if ($imRow->id != NULL) $out .= '<span class="im-item"><strong>' . $imRow->name . ':</strong> ' . $imRow->id . '</span><br />' . "\n";
			}
			$out .= '</div>' . "\n";
		}
		return $out;
	}
	
	public function getSocialMediaBlock()
	{
		if ($this->getSocialMedia())
		{
			$out = '<div class="social-media-block" style="margin-bottom: 10px;">' . "\n";
			foreach ($this->getSocialMedia() as $socialNetwork)
			{
				if ($socialNetwork->id != null) $out .= '<span class="social-media-item"><a class="url uid ' . $socialNetwork->type . '" href="' . $socialNetwork->url . '" target="_blank" title="' . $socialNetwork->name . '">' . $socialNetwork->name . '</a></span><br />' . "\n";
			}
			$out .= '</div>' . "\n";
		}
		echo $out;
	}
	
	public function getWebsiteBlock()
	{
		if ($this->getWebsites())
		{
			$out = '<div class="website-block" style="margin-bottom: 10px;">' . "\n";
			foreach ($this->getWebsites() as $website)
			{
				if ($website->url != NULL) $out .= '<span class="website-address" style="display: block"><strong>Website:</strong> <a class="url" href="' . $website->url . '" target="_blank">' . $website->url . '</a></span>' . "\n";
			}
			$out .= "</div>" . "\n";
		}
		return $out;
	}
	
	public function getBirthdayBlock( $format = 'F jS' )
	{
		//NOTE: The vevent span is for hCalendar compatibility.
		//NOTE: The second birthday span [hidden] is for hCard compatibility.
		//NOTE: The third span series [hidden] is for hCalendar compatibility.
		if ($this->getBirthday()) $out = '<span class="vevent"><span class="birthday"><strong>Birthday:</strong> <abbr class="dtstart" title="' . $this->getBirthday('Ymd') .'">' . $this->getBirthday($format) . '</abbr></span>' .
										 '<span class="bday" style="display:none">' . $this->getBirthday('Y-m-d') . '</span>' .
										 '<span class="summary" style="display:none">Birthday - ' . $this->getFullFirstLastName() . '</span> <span class="uid" style="display:none">' . $this->getBirthday('YmdHis') . '</span> </span><br />' . "\n";
		return $out;
	}
	
	public function getAnniversaryBlock( $format = 'F jS' )
	{
		//NOTE: The vevent span is for hCalendar compatibility.
		if ($this->getAnniversary()) $out = '<span class="vevent"><span class="anniversary"><strong>Anniversary:</strong> <abbr class="dtstart" title="' . $this->getAnniversary('Ymd') . '">' . $this->getAnniversary($format) . '</abbr></span>' .
											'<span class="summary" style="display:none">Anniversary - ' . $this->getFullFirstLastName() . '</span> <span class="uid" style="display:none">' . $this->getAnniversary('YmdHis') . '</span> </span><br />' . "\n";
		return $out;
	}
	
	public function getNotesBlock()
	{
		return '<div class="note">' . $this->getNotes() . '</div>' . "\n";
	}
	
	public function getBioBlock()
	{
		return '<div class="bio">' . $this->getBio() . '</div>' . "\n";
	}
	
	/**
	 * Displays the category list in a HTML list or custom format
	 * 
	 * @TODO: Implement $parents.
	 * 
	 * Accepted option for the $atts property are:
	 * 		list == string -- The list type to output. Accepted values are ordered || unordered.
	 * 		separator == string -- The category separator.
	 * 		before == string -- HTML to output before the category list.
	 *  	after == string -- HTML to output after the category list.
	 * 		label == string -- String to display after the before attribute but before the category list.
	 * 		parents == bool -- Display the parents
	 * 		return == TRUE || FALSE -- Return string if set to TRUE instead of echo string.
	 * 
	 * @param array $atts [optional]
	 * @return string
	 */
	public function getCategoryBlock($atts = NULL)
	{
		$defaultAtts = array('list' => 'unordered',
							 'separator' => NULL,
							 'before' => NULL,
							 'after' => NULL,
							 'label' => 'Categories: ',
							 'parents' => FALSE,
							 'return' => FALSE
							);
		
		$atts = $this->validate->attributesArray($defaultAtts, (array) $atts);
		
		$categories = $this->getCategory();
		
		if ( empty($categories) ) return NULL;
		
		if ( !empty($atts['before']) ) $out = $atts['before'];
		
		if ( !empty($atts['label']) ) $out .= '<span class="cn_category_label">' . $atts['label'] . '</span>';
		
		if ( empty($atts['separator']) )
		{
			$atts['list'] === 'unordered' ? $out .= '<ul class="cn_category_list">' : $out .= '<ol class="cn_category_list">';
			
			foreach ($categories as $category)
			{
				$out .= '<li class="cn_category" id="cn_category_' . $category->term_id . '">' . $category->name . '</li>';
			}
			
			$atts['list'] === 'unordered' ? $out .= '</ul>' : $out .= '</ol>';
		}
		else
		{
			foreach ($categories as $category)
			{
				$out .= '<span class="cn_category" id="cn_category_' . $category->term_id . '">' . $category->name . '</span>';
				
				$i++;
				if ( count($categories) > $i ) $out .= $atts['separator'];
			}
			
			unset($i);
		}
		
		if ( !empty($atts['after']) ) $out .= $atts['after'];
		
		if ( $atts['return'] ) return $out;
		
		echo $out;
		
	}
	
	/**
	 * Displays the category list for use in the class tag.
	 * 
	 * @param bool $return [optional] Return instead of echo.
	 * @return string
	 */
	public function getCategoryClass($return = FALSE)
	{
		$categories = $this->getCategory();
		
		if ( empty($categories) ) return NULL;
		
		foreach ($categories as $category)
		{
			$out[] = $category->slug;
		}
		
		if ($return) return implode(' ', $out);
		
		echo implode(' ', $out);
		
	}
	
	public function getRevisionDateBlock()
	{
		return '<span class="rev">' . date('Y-m-d', strtotime($this->getUnixTimeStamp())) . 'T' . date('H:i:s', strtotime($this->getUnixTimeStamp())) . 'Z' . '</span>' . "\n";
	}
	
	public function getLastUpdatedStyle()
	{
		$age = (int) abs( time() - strtotime( $this->getUnixTimeStamp() ) );
		if ( $age < 657000 )	// less than one week: red
			$ageStyle = ' color:red; ';
		elseif ( $age < 1314000 )	// one-two weeks: maroon
			$ageStyle = ' color:maroon; ';
		elseif ( $age < 2628000 )	// two weeks to one month: green
			$ageStyle = ' color:green; ';
		elseif ( $age < 7884000 )	// one - three months: blue
			$ageStyle = ' color:blue; ';
		elseif ( $age < 15768000 )	// three to six months: navy
			$ageStyle = ' color:navy; ';
		elseif ( $age < 31536000 )	// six months to a year: black
			$ageStyle = ' color:black; ';
		else						// more than one year: don't show the update age
			$ageStyle = ' display:none; ';
		return $ageStyle;
	}
	
	public function returnToTopAnchor()
	{
		return '<a href="#connections-list-head" title="Return to top."><img src="' . WP_PLUGIN_URL . '/connections/images/uparrow.gif" alt="Return to top."/></a>';
	}
	
}

?>