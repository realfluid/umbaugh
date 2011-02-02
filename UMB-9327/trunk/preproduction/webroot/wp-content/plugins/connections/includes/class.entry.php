<?php

/**
 * Entry class
 */
class cnEntry
{
	/**
	 * Interger: Entry ID
	 * @var integer
	 */
	private $id;
	
	/**
	 * Unix timestamp
	 * @var integer unix timestamp
	 */
	private $timeStamp;
	
	/**
	 * Date added.
	 * @var integer unix timestamp
	 */
	private $dateAdded;
	
	/**
	 * Honorific prefix.
	 * @var string
	 */
	private $honorificPrefix;
	
	/**
	 * String: First Name
	 * @var string
	 */
	private $firstName;
	
	/**
	 * Middle Name
	 * @var string
	 */
	private $middleName;
	
	/**
	 * String: Last Name
	 * @var string
	 */
	private $lastName;
	
	/**
	 * Honorific suffix
	 * @var string
	 */
	private $honorificSuffix;
	
	/**
	 * String: Title
	 * @var string
	 */
	private $title;
	
	/**
	 * String: Oranization
	 * @var string
	 */
	private $organization;
	
	/**
	 * String: Department
	 * @var string
	 */
	private $department;
	
	private $contactFirstName;
	
	private $contactLastName;
	
	/**
	 * String: Family Name
	 * @var string
	 */
	private $familyName;
	
	/**
	 * Associative array of addresses
	 * @var associative array
	 */
	private $addresses;
	
	/**
	 * Associative array of phone numbers
	 * @var associative arrya
	 */
	private $phoneNumbers;
	
	/**
	 * Associative array of email addresses
	 * @var
	 */
	private $emailAddresses;
	
	/**
	 * Associative array of websites
	 * @var array
	 */ 
	private $websites;
	
	/**
	 * Associative array of instant messengers IDs
	 * @var array
	 */
	private $im;
	
	private $socialMedia;
	
	/**
	 * Unix time: Birthday.
	 * @var unix time
	 */
	private $birthday;
	
	/**
	 * Unix time: Anniversary.
	 * @var unix time
	 */
	private $anniversary;
	
	/**
	 * String: Entry notes.
	 * @var string
	 */
	private $bio;
	
	/**
	 * String: Entry biography.
	 * @var string
	 */
	private $notes;
	
	/**
	 * String: Visibilty Type; public, private, unlisted
	 * @var string
	 */
	private $visibility;
	
	private $options;
	private $imageLinked;
	private $imageDisplay;
	private $imageNameThumbnail;
	private $imageNameCard;
	private $imageNameProfile;
	private $imageNameOriginal;
	private $logoLinked;
	private $logoDisplay;
	private $logoName;
	private $entryType;
	private $familyMembers;
	
	private $categories;
	
	private $addedBy;
	private $editedBy;
	
	public $format;
	public $validate;
	
	private $sortColumn;
	
	function __construct($entry = NULL)
	{
		global $connections;
		
		if ( isset($entry) )
		{
			if ( isset($entry->id) ) $this->id = (integer) $entry->id;
			if ( isset($entry->ts) ) $this->timeStamp = $entry->ts;
			if ( isset($entry->date_added) ) $this->dateAdded = (integer) $entry->date_added;
			if ( isset($entry->honorific_prefix) ) $this->honorificPrefix = $entry->honorific_prefix;
			if ( isset($entry->first_name) ) $this->firstName = $entry->first_name;
			if ( isset($entry->middle_name) ) $this->middleName = $entry->middle_name;
			if ( isset($entry->last_name) ) $this->lastName = $entry->last_name;
			if ( isset($entry->honorific_suffix) ) $this->honorificSuffix = $entry->honorific_suffix;
			if ( isset($entry->title) ) $this->title = $entry->title;
			if ( isset($entry->organization) ) $this->organization = $entry->organization;
			if ( isset($entry->contact_first_name) ) $this->contactFirstName = $entry->contact_first_name;
			if ( isset($entry->contact_last_name) ) $this->contactLastName = $entry->contact_last_name;
			if ( isset($entry->department) ) $this->department = $entry->department;
			if ( isset($entry->family_name) ) $this->familyName = $entry->family_name;
			if ( isset($entry->addresses) ) $this->addresses = $entry->addresses;
			if ( isset($entry->phone_numbers) ) $this->phoneNumbers = $entry->phone_numbers;
			if ( isset($entry->email) ) $this->emailAddresses = $entry->email;
			if ( isset($entry->im) ) $this->im = $entry->im;
			if ( isset($entry->social) ) $this->socialMedia = $entry->social;
			if ( isset($entry->websites) ) (integer) $this->websites = $entry->websites;
			if ( isset($entry->birthday) ) (integer) $this->birthday = $entry->birthday;
			if ( isset($entry->anniversary) ) $this->anniversary = $entry->anniversary;
			if ( isset($entry->bio) ) $this->bio = $entry->bio;
			if ( isset($entry->notes) ) $this->notes = $entry->notes;
			if ( isset($entry->visibility) ) $this->visibility = $entry->visibility;
			if ( isset($entry->sort_column) ) $this->sortColumn = $entry->sort_column;
			
			if ( isset($entry->options) )
			{
				$this->options = unserialize($entry->options);
				
				if ( isset($this->options['image']) )
				{
					$this->imageLinked = $this->options['image']['linked'];
					$this->imageDisplay = $this->options['image']['display'];
					$this->imageNameThumbnail =$this->options['image']['name']['thumbnail'];
					$this->imageNameCard = $this->options['image']['name']['entry'];
					$this->imageNameProfile = $this->options['image']['name']['profile'];
					$this->imageNameOriginal = $this->options['image']['name']['original'];
				}
				
				if ( isset($this->options['logo']) )
				{
					$this->logoLinked = $this->options['logo']['linked'];
					$this->logoDisplay = $this->options['logo']['display'];
					$this->logoName =$this->options['logo']['name'];
				}
				
				if ( isset($this->options['entry']['type']) ) $this->entryType = $this->options['entry']['type'];
				if ( isset($this->options['connection_group']) ) $this->familyMembers = $this->options['connection_group']; // For compatibility with versions <= 0.7.0.4
				if ( isset($this->options['group']['family']) ) $this->familyMembers = $this->options['group']['family'];
			}
			
			if ( isset($entry->id) ) $this->categories = $connections->retrieve->entryCategories($this->getId());
			
			if ( isset($entry->added_by) ) $this->addedBy = $entry->added_by;
			if ( isset($entry->edited_by) ) $this->editedBy = $entry->edited_by;
		}
		
		// Load the formatting class for sanitizing the get methods.
		$this->format = new cnFormatting();
		
		// Load the validation class.
		$this->validate = new cnValidate();
	}

    /**
     * Returns $id.
     * @see entry::$id
     */
    public function getId()
    {
        return (integer) $this->id;
    }
    
    /**
     * Sets $id.
     * @param object $id
     * @see entry::$id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Timestamp format can be sent as a string variable.
     * Returns $timeStamp
     * @param string $format
     * @see entry::$timeStamp
     */
    public function getFormattedTimeStamp($format = NULL)
    {
        if (!$format)
		{
			$format = "m/d/Y";
		}
		
		return date($format, strtotime($this->timeStamp));
    }
	
	/**
     * Timestamp format can be sent as a string variable.
     * Returns $unixTimeStamp
     * @see entry::$timeStamp
     */
    public function getUnixTimeStamp()
    {
        return $this->timeStamp;
    }
		
	public function getHumanTimeDiff()
	{
		return human_time_diff( strtotime( $this->timeStamp ), current_time('timestamp') );
	}
	
	public function getDateAdded($format = NULL)
	{
		if ($this->dateAdded != NULL)
		{
			if (!$format)
			{
				$format = 'm/d/Y';
			}
			
			return date($format, $this->dateAdded);
		}
		else
		{
			return 'Unknown';
		}
	}
    
    public function getHonorificPrefix()
	{
        return $this->format->sanitizeString($this->honorificPrefix);
    }
    
    public function setHonorificPrefix($honorificPrefix)
	{
        $this->honorificPrefix = $honorificPrefix;
    }
    
    /**
     * Returns the entries first name.
     * Returns $firstName.
     * @see entry::$firstName
     */
    public function getFirstName()
    {
		return $this->format->sanitizeString($this->firstName);
    }
    
    /**
     * Sets $firstName.
     * @param object $firstName
     * @see entry::$firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }
    
	public function getMiddleName()
    {
        return $this->format->sanitizeString($this->middleName);
    }
    
    public function setMiddleName($middleName)
    {
        $this->middleName = $middleName;
    }
	
    /**
     * The last name if the entry type is an individual.
     * If entry type is set to connection group the method will return the group name.
     * Returns $lastName.
     * @see entry::$lastName
     */
    public function getLastName()
    {
        switch ($this->getEntryType())
		{
			case 'individual':
				return $this->format->sanitizeString($this->lastName);
			break;
			
			case 'organization':
				return $this->getOrganization();;
			break;
			
			case 'family':
				return $this->getFamilyName();
			break;
			
			default:
				return $this->format->sanitizeString($this->lastName);
			break;
		}
    }
    
    /**
     * Sets $lastName.
     * @param string $lastName
     * @see entry::$lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }
    
    public function getHonorificSuffix()
	{
        return $this->format->sanitizeString($this->honorificSuffix);
    }
    
    public function setHonorificSuffix($honorificSuffix)
	{
        $this->honorificSuffix = $honorificSuffix;
    }
    
    
	 /**
     * The entries full name if the entry type is an individual.
     * If entry type is set to organization the method will return the organization name.
     * If entry type is set to connection group the method will return the group name.
     * Returns $fullFirstLastName.
     * @see entry::$fullFirstLastName
     */
    public function getFullFirstLastName()
    {
        switch ($this->getEntryType())
		{
			case 'individual':
				return $this->getFirstName() . ' ' . $this->getMiddleName() . ' ' . $this->getLastName();
			break;
			
			case 'organization':
				return $this->getOrganization();
			break;
			
			case 'family':
				return $this->getFamilyName();
			break;
			
			default:
				return $this->getFirstName() . ' ' . $this->getMiddleName() . ' ' . $this->getLastName();
			break;
		}
    }
        
    /**
     * The entries full name; last name first if the entry type is an individual.
     * If entry type is set to organization the method will return the organization name.
     * If entry type is set to connection group the method will return the group name.
     * Returns $fullLastFirstName.
     * @see entry::$fullLastFirstName
     */
    public function getFullLastFirstName()
    {
    	switch ($this->getEntryType())
		{
			case 'individual':
				return $this->getLastName() . ', ' . $this->getFirstName() . ' ' . $this->getMiddleName();
			break;
			
			case 'organization':
				return $this->getOrganization();;
			break;
			
			case 'family':
				return $this->getFamilyName();
			break;
			
			default:
				return $this->getLastName() . ', ' . $this->getFirstName();
			break;
		}
    }
	
    /**
     * Returns the entries Organization.
     * Returns $organization.
     * @see entry::$organization
     */
    public function getOrganization()
    {
        return $this->format->sanitizeString($this->organization);
    }
    
    /**
     * Sets $organization.
     * @param object $organization
     * @see entry::$organization
     */
    public function setOrganization($organization)
    {
        $this->organization = $organization;
    }
    
    /**
     * Returns the entries Title.
     * Returns $title.
     * @see entry::$title
     */
    public function getTitle()
    {
        return $this->format->sanitizeString($this->title);
    }
    
    /**
     * Sets $title.
     * @param object $title
     * @see entry::$title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }
    
    /**
     * Returns the entries Department.
     * Returns $department.
     * @see entry::$department
     */
    public function getDepartment()
    {
        return $this->format->sanitizeString($this->department);
    }
    
    /**
     * Sets $department.
     * @param object $department
     * @see entry::$department
     */
    public function setDepartment($department)
    {
        $this->department = $department;
    }
	
	public function getContactFirstName()
	{
		return $this->format->sanitizeString($this->contactFirstName);
	}
	
	public function setContactFirstName($contactFirstName)
	{
		$this->contactFirstName = $contactFirstName;
	}
	
	public function getContactLastName()
	{
		return $this->format->sanitizeString($this->contactLastName);
	}
	
	public function setContactLastName($contactLastName)
	{
		$this->contactLastName = $contactLastName;
	}
	
    /**
     * Returns $familyName.
     * 
     * @see entry::$familyName
     */
    public function getFamilyName()
    {
        return $this->format->sanitizeString($this->familyName);
    }
    
    /**
     * Sets $familyName.
     * 
     * @param object $familyName
     * @see entry::$familyName
     */
    public function setFamilyName($familyName)
    {
        $this->familyName = $familyName;
    }
	
	/**
     * Returns family member member entry ID and relation.
     */
    public function getFamilyMembers()
    {
        if ( !empty($this->familyMembers) )
		{
			return $this->familyMembers;
		}
		else
		{
			return array();
		}
    }
    
    /**
     * Sets $familyMembers.
     */
    public function setFamilyMembers($familyMembers)
    {
		/* 
		 * The form to capture the user IDs and relationship stores the data
		 * in a two-dementional array as follows:
		 * 		array[0]
		 * 			array[entry_id]
		 * 				 [relation]
		 * 
		 * This loop re-writes the data into an associative array entry_id => relation.
		 */
		if ($familyMembers)
		{
			foreach($familyMembers as $relation)
			{
				$family[$relation['entry_id']] .= $relation['relation'];
			}
		}
		//$this->options['connection_group'] = $family;
		$this->options['group']['family'] = $family;
    }
	
    /**
     * Returns $addresses.
     * @see entry::$addresses
     */
    public function getAddresses()
    {
        if ( !empty($this->addresses) )
		{
			$addresses = unserialize($this->addresses);
			
			foreach ( (array) $addresses as $key => $address)
			{
				$row->name = $this->format->sanitizeString($address['name']);
				$row->type = $this->format->sanitizeString($address['type']);
				$row->line_one = $this->format->sanitizeString($address['address_line1']);
				$row->line_two = $this->format->sanitizeString($address['address_line2']);
				$row->city = $this->format->sanitizeString($address['city']);
				$row->state = $this->format->sanitizeString($address['state']);
				$row->zipcode = $this->format->sanitizeString($address['zipcode']);
				$row->country = $this->format->sanitizeString($address['country']);
				$row->latitude = $this->format->sanitizeString($address['latitude']);
				$row->longitude = $this->format->sanitizeString($address['longitude']);
				$row->visibility = $this->format->sanitizeString($address['visibility']);
				
				// Start compatibility for versions 0.2.24 and older. \\
				if ( empty($row->name) )
				{
					switch ($row->type)
					{
			        	case "home":
			        		$row->name = "Home Address";
			        	break;
						
						case "work":
			        		$row->name = "Work Address";
			        	break;
						
						case "school":
			        		$row->name = "School Address";
			        	break;
						
						case "other":
			        		$row->name = "Other Address";
			        	break;
			        	
			        	default:
			        		$row->name = $this->format->sanitizeString($address['name']);
			        	break;
			        }	
				}
				// End compatibility for versions 0.2.24 and older. \\
				
				$out[] = $row;
				unset($row);
			}
			
			if ( !empty($out) ) return $out;
			
		}
		
		return NULL;
    }
    
    /**
     * Sets $addresses.
     * @param object $addresses
     * @see entry::$addresses
     */
    public function setAddresses($addresses)
    {
        global $connections;
		
		$validFields = array('name' => NULL, 'type' => NULL, 'address_line1' => NULL, 'address_line2' => NULL, 'city' => NULL, 'state' => NULL, 'zipcode' => NULL, 'country' => NULL, 'latitude' => NULL, 'longitude' => NULL, 'visibility' => NULL);
		
		if ( !empty($addresses) )
		{
			foreach ($addresses as $key => $address)
			{
				// First validate the supplied data.
				$address[$key] = $this->validate->attributesArray($validFields, $address);
				
				$addressValues = $connections->options->getDefaultAddressValues();
				
				if ( !empty( $address['type'] ) )
				{
					$addresses[$key]['name'] = $addressValues[$address['type']];
				}
			}
			
			$this->addresses = serialize($addresses);
		}
		else
		{
			$this->addresses = NULL;
		}
		
    }

    /**
     * Returns array of objects.
     * 
     * Each object contains:
     * 						->name
     * 						->type
     * 						->number
     * 						->visibility
     * 
     * NOTE: The output is sanitized for safe display.
     * 
     * @return array
     */
    public function getPhoneNumbers()
    {
        if ( !empty($this->phoneNumbers) )
		{
			$phoneNumbers = unserialize($this->phoneNumbers);
			
			foreach ( (array) $phoneNumbers as $key => $number)
			{
				$row->name = $this->format->sanitizeString($number['name']);
				$row->type = $this->format->sanitizeString($number['type']);
				$row->number = $this->format->sanitizeString($number['number']);
				$row->visibility = $this->format->sanitizeString($number['visibility']);
				
				// Start compatibility for versions 0.2.24 and older. \\
				switch ($row->type)
				{
					case 'home':
						$row->type = "homephone";
						break;
					case 'homephone':
						$row->type = "homephone";
						break;
					case 'homefax':
						$row->type = "homefax";
						break;
					case 'cell':
						$row->type = "cellphone";
						break;
					case 'cellphone':
						$row->type = "cellphone";
						break;
					case 'work':
						$row->type = "workphone";
						break;
					case 'workphone':
						$row->type = "workphone";
						break;
					case 'workfax':
						$row->type = "workfax";
						break;
					case 'fax':
						$row->type = "workfax";
						break;
					
					default:
						$row->type = $this->format->sanitizeString($number['type']);
					break;
				}
				
				if ( empty($row->name) )
				{
					switch ($row->type)
					{
						case 'home':
							$row->name = "Home Phone";
							break;
						case 'homephone':
							$row->name = "Home Phone";
							break;
						case 'homefax':
							$row->name = "Home Fax";
							break;
						case 'cell':
							$row->name = "Cell Phone";
							break;
						case 'cellphone':
							$row->name = "Cell Phone";
							break;
						case 'work':
							$row->name = "Work Phone";
							break;
						case 'workphone':
							$row->name = "Work Phone";
							break;
						case 'workfax':
							$row->name = "Work Fax";
							break;
						case 'fax':
							$row->name = "Work Fax";
							break;
						
						default:
							$row->name = $this->format->sanitizeString($number['name']);
						break;
					}
				}
				
				/*if ( isset($number['homephone']) )
				{
		        	$row->number = $this->format->sanitizeString($number['homephone']);
		        }
				else
				{
					$row->number = $this->format->sanitizeString($number['number']);
				}*/
				
				// End compatibility for versions 0.2.24 and older. \\
				
				$row = apply_filters('cn_phone_number', $row);
				
				$out[] = $row;
				unset($row);
			}
			
			$out = apply_filters('cn_phone_numbers', $out);
			
			if ( !empty($out) ) return $out;
			
		}
		
		return NULL;
    }
    
    /**
	 * Sets $phoneNumbers as an associative array.
	 * 
	 * $phoneNumbers is to be an array containing an array of the data for each phone number.
	 * 
	 * 
	 * @param array $phoneNumbers
	 */
    public function setPhoneNumbers($phoneNumbers)
    {
        global $connections;
		
		$validFields = array('name' => NULL, 'type' => NULL, 'number' => NULL, 'visibility' => NULL);
		
		if ( !empty($phoneNumbers) )
		{
			foreach ($phoneNumbers as $key => $phoneNumber)
			{
				// First validate the supplied data.
				$phoneNumber[$key] = $this->validate->attributesArray($validFields, $phoneNumber);
				
				$phoneNumberValues = $connections->options->getDefaultPhoneNumberValues();
				$phoneNumbers[$key]['name'] = $phoneNumberValues[$phoneNumber['type']];
				
				// If the number is emty, no need to store it.
				if ( empty($phoneNumber['number']) ) unset($phoneNumbers[$key]);
			}
			
			$this->phoneNumbers = serialize($phoneNumbers);
		}
		else
		{
			$this->phoneNumbers = NULL;
		}
		
    }

    /**
     * Returns array of objects.
     * 
     * Each object contains:
     * 						->name
     * 						->type
     * 						->address
     * 						->visibility
     * 
     * NOTE: The output is sanitized for safe display.
     * 
     * @return array
     */
    public function getEmailAddresses()
    {
        if ( !empty($this->emailAddresses) )
		{
			$emailAddresses = unserialize($this->emailAddresses);
			
			foreach ( (array) $emailAddresses as $key => $email)
			{
				$row->name = $this->format->sanitizeString($email['name']);
				$row->type = $this->format->sanitizeString($email['type']);
				$row->address = $this->format->sanitizeString($email['address']);
				$row->visibility = $this->format->sanitizeString($email['visibility']);
				
				// Start compatibility for versions 0.2.24 and older. \\
				if ( empty($row->name) )
				{
					switch ($row->type)
					{
						case 'personal':
							$row->name = "Personal Email";
							break;
						case 'work':
							$row->name = "Work Email";
							break;
						
						default:
							$row->name = $this->format->sanitizeString($email['name']);
						break;
					}
				}
				// End compatibility for versions 0.2.24 and older. \\
				
				$row = apply_filters('cn_email_address', $row);
				
				$out[] = $row;
				unset($row);
			}
			
			$out = apply_filters('cn_email_addresses', $out);
			
			if ( !empty($out) ) return $out;
			
		}
		
		return NULL;
    }
    
	/**
	 * Sets $emailAddresses as an associative array.
	 * 
	 * $emailAddresses is to be an array containing an array of the data for each email address.
	 * 
	 * @TODO: Validate as valid email address.
	 * 
	 * @param array $emailAddresses
	 */
    public function setEmailAddresses($emailAddresses)
    {
        global $connections;
		
		$validFields = array('name' => NULL, 'type' => NULL, 'address' => NULL, 'visibility' => NULL);
		
		if ( !empty($emailAddresses) )
		{
			foreach ($emailAddresses as $key => $email)
			{
				// First validate the supplied data.
				$email[$key] = $this->validate->attributesArray($validFields, $email);
				
				$emailValues = $connections->options->getDefaultEmailValues();
				$email[$key]['name'] = $emailValues[$email['type']];
				
				// If the address is emty, no need to store it.
				if ( empty($email['address']) ) unset($email[$key]);
			}
			
			$this->emailAddresses = serialize($emailAddresses);
		}
		else
		{
			$this->emailAddresses = NULL;
		}
		
    }

    /**
     * Returns array of objects.
     * 
     * Each object contains:
     * 						->name
     * 						->type
     * 						->id
     * 						->visibility
     * 
     * NOTE: The output is sanitized for safe display.
     * 
     * @return array
     */
    public function getIm()
    {
        if ( !empty($this->im) )
		{
			$networks = unserialize($this->im);
			
			foreach ( (array) $networks as $key => $network)
			{
				$row->name = $this->format->sanitizeString($network['name']);
				$row->type = $this->format->sanitizeString($network['type']);
				$row->id = $this->format->sanitizeString($network['id']);
				$row->visibility = $this->format->sanitizeString($network['visibility']);
				
				// Start compatibility with versions 0.5.48 and older. \\
				switch ($row->type)
				{
					case 'AIM':
						$row->type = 'aim';
					break;
					
					case 'Yahoo IM':
						$row->type = 'yahoo';
					break;
					
					case 'Jabber / Google Talk':
						$row->type = 'jabber';
					break;
					
					case 'Messenger':
						$row->type = 'messenger';
					break;
					
					default:
						$row->type = $this->format->sanitizeString($row->type);
					break;
				}
				// End compatibility with versions 0.5.48 and older. \\
				
				// Start compatibility with versions 0.5.48 and older. \\
				if ( empty($row->name) )
				{
					switch ($row->type)
					{
						case 'aim':
							$row->name = 'AIM';
						break;
						
						case 'yahoo':
							$row->name = 'Yahoo IM';
						break;
						
						case 'jabber':
							$row->name = 'Jabber / Google Talk';
						break;
						
						case 'messenger':
							$row->name = 'Messenger';
						break;
						
						default:
							$row->name = $this->format->sanitizeString($row->name);
						break;
					}
				}
				// End compatibility with versions 0.5.48 and older. \\
				
				$out[] = $row;
				unset($row);
			}
			
			if ( !empty($out) ) return $out;
		}
		
		return NULL;
    }
    
    /**
     * Sets $im as an associative array.
     * If the im network ID [id] is http:// or empty it is unset.
     * since there is no need to store it.
     * 
     * $im is to be an array containing an array of the data for each social network.
     * 
     * @TODO: Validate as valid url.
     * 
     * @param array $im
     */
    public function setIm($im)
    {
		global $connections;
		
		$validFields = array('name' => NULL, 'type' => NULL, 'id' => NULL, 'visibility' => NULL);
		
		if ( !empty($im) )
		{
			foreach ($im as $key => $imNetwork)
			{
				// First validate the supplied data.
				$im[$key] = $this->validate->attributesArray($validFields, $imNetwork);
				
				$imValues = $connections->options->getDefaultIMValues();
				$im[$key]['name'] = $imValues[$imNetwork['type']];
				
				// If the id is emty, no need to store it.
				if ( empty($imNetwork['id']) ) unset($im[$key]);
			}
			
			$this->im = serialize($im);
		}
		else
		{
			$this->im = NULL;
		}
		
		
    }
	
	/**
     * Returns array of objects.
     * 
     * Each object contains:
     * 						->name
     * 						->type
     * 						->id
     * 						->url
     * 						->visibility
     * 
     * NOTE: The output is sanitized for safe display.
     * 
     * @return array
     */
	public function getSocialMedia()
    {
		if ( !empty($this->socialMedia) )
		{
			$networks = unserialize($this->socialMedia);
			
			foreach ( (array) $networks as $key => $network)
			{
				$row->name = $this->format->sanitizeString($network['name']);
				$row->type = $this->format->sanitizeString($network['type']);
				$row->id = $this->format->sanitizeString($network['id']);
				$row->url = $this->format->sanitizeString($network['url']);
				$row->visibility = $this->format->sanitizeString($network['visibility']);
				
				// Start for Compatibility for versions <= 0.6.2.1 \\
				if ( empty($row->url) ) $row->url = $row->id;
				
				if ( empty($row->name) )
				{
					global $connections;
					
					$socialMediaValues = $connections->options->getDefaultSocialMediaValues();
					$row->name = $socialMediaValues[$row->type];
				}
				// End for Compatibility for versions <= 0.6.2.1 \\
				
				$out[] = $row;
				unset($row);
			}
			
			if ( !empty($out) ) return $out;
		}
		
		return NULL;
    }
    
	/**
     * Sets $socialMedia as an associative array.
     * If the social network ID [id] is http:// or empty it is unset.
     * since there is no need to store it.
     * 
     * $socialMedia is to be an array containing an array of the data for each social network.
     * 
     * @TODO: Validate as valid url.
     * 
     * @param array $socialMedia
     */
    public function setSocialMedia($socialMedia)
    {
    	global $connections;
		
		$validFields = array('name' => NULL, 'type' => NULL, 'id' => NULL, 'url' => NULL, 'visibility' => NULL);
		
		if ( !empty($socialMedia) )
		{
			foreach ($socialMedia as $key => $socialNetwork)
			{
				// First validate the supplied data.
				$socialMedia[$key] = $this->validate->attributesArray($validFields, $socialNetwork);
				
				$socialMediaValues = $connections->options->getDefaultSocialMediaValues();
				$socialMedia[$key]['name'] = $socialMediaValues[$socialNetwork['type']];
				
				// If the id is emty, no need to store it and if the http protocol is not part of the address, add it.
				switch ($socialNetwork['id'])
				{
					case '':
						unset($socialMedia[$key]);
					break;
					
					case 'http://':
						unset($socialMedia[$key]);
					break;
					
					default:
						if ( mb_substr($socialNetwork['id'], 0, 7) != 'http://' )
						{
							$socialMedia[$key]['id'] = 'http://' . $socialNetwork['id'];
						}
					break;
				}
				
				if ( array_key_exists($key, $socialMedia) ) $socialMedia[$key]['url'] = $socialMedia[$key]['id'];
				
			}
			
			$this->socialMedia = serialize($socialMedia);
		}
		else
		{
			$this->socialMedia = NULL;
		}
		
    }

    /**
     * Anniversary as unix time. Format can be sent as string.
     * @return string
     * @param string $format[optional]
     */
	public function getAnniversary( $format = 'F jS' )
    {
        if ($this->anniversary)
		{
			global $connections;
			
			if ( mktime(23, 59, 59, date('m', $this->anniversary), date('d', $this->anniversary), date('Y', $connections->options->wpCurrentTime) ) < $connections->options->wpCurrentTime )
			{
				$nextADay = mktime(0, 0, 0, date('m', $this->anniversary), date('d', $this->anniversary), date('Y', $connections->options->wpCurrentTime) + 1 );
			}
			else
			{
				$nextADay = mktime(0, 0, 0, date('m', $this->anniversary), date('d', $this->anniversary), date('Y', $connections->options->wpCurrentTime) );
			}
			
			return date($format, $nextADay);
		}

    }
    
    /**
     * Sets $anniversary.
     * @param object $anniversary
     * @see entry::$anniversary
     */
    public function setAnniversary($day, $month)
    {
        //Create the anniversary with a default year and time since we don't collect the year. And this is needed so a proper sort can be done when listing them.
		( !empty($day) && !empty($month) ) ? $this->anniversary = mktime(0, 0, 1, $month, $day, 1970) : $this->anniversary = NULL;
    }
    
    /**
     * Birthday as unix time. Format can be sent as string.
     * @return string
     * @param string $format[optional]
     */
    public function getBirthday( $format = 'F jS' )
    {
        if ($this->birthday)
		{		
			global $connections;
			
			if ( mktime(23, 59, 59, date('m', $this->birthday), date('d', $this->birthday), date('Y', $connections->options->wpCurrentTime) ) < $connections->options->wpCurrentTime )
			{
				$nextBDay = mktime(0, 0, 0, date('m', $this->birthday), date('d', $this->birthday), date('Y', $connections->options->wpCurrentTime) + 1 );
			}
			else
			{
				$nextBDay = mktime(0, 0, 0, date('m', $this->birthday), date('d', $this->birthday), date('Y', $connections->options->wpCurrentTime) );
			}
			
			return date($format, $nextBDay);
		}
    }
    
    /**
     * Sets $birthday.
     * @param object $birthday
     * @see entry::$birthday
     */
    public function setBirthday($day, $month)
    {
        //Create the birthday with a default year and time since we don't collect the year. And this is needed so a proper sort can be done when listing them.
		( !empty($day) && !empty($month) ) ? $this->birthday = mktime(0, 0, 1, $month, $day, 1970) : $this->birthday = NULL;
    }
	
	public function getUpcoming($type, $format = 'F jS')
    {
		global $connections;
			
		if ( mktime(23, 59, 59, date('m', $this->$type), date('d', $this->$type), date('Y', $connections->options->wpCurrentTime) ) < $connections->options->wpCurrentTime )
		{
			$nextUDay = mktime(0, 0, 0, date('m', $this->$type), date('d', $this->$type), date('Y', $connections->options->wpCurrentTime) + 1 );
		}
		else
		{
			$nextUDay = mktime(0, 0, 0, date('m', $this->$type), date('d', $this->$type), date('Y', $connections->options->wpCurrentTime) );
		}
		
		return date($format, $nextUDay);
    }
	
    /**
     * Returns $bio.
     * @see entry::$bio
     */
    public function getBio()
    {
		return $this->format->sanitizeString($this->bio, TRUE);
    }
    
    /**
     * Sets $bio.
     * @param object $bio
     * @see entry::$bio
     */
    public function setBio($bio)
    {
        $this->bio = $bio;
    }
    
    /**
     * Returns $notes.
     * @see entry::$notes
     */
    public function getNotes()
    {
        return $this->format->sanitizeString($this->notes, TRUE);
    }
    
    /**
     * Sets $notes.
     * @param object $notes
     * @see entry::$notes
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;
    }
	
	/**
	 * Create excerpt from the supplied text. Default is the bio.
	 * 
	 * Filters:
	 * 		cn_excerpt_length	=> change the default excerpt length of 55 words.
	 * 		cn_excerpt_more		=> change the default more string of [...]
	 * 		cn_trim_excerpt		=> change returned string
	 * 
	 * @param string $text [optional]
	 * @return 
	 */
	public function getExcerpt($text = NULL)
	{
		if ( !isset($text) ) $text = $this->getBio();
		
		$text = $this->format->sanitizeString($text, FALSE);
		$excerptLength = apply_filters('cn_excerpt_length', 55);
		$excerptMore = apply_filters('cn_excerpt_more', ' ' . '[...]');
		
		$words = preg_split("/[\n\r\t ]+/", $text, $excerptLength + 1, PREG_SPLIT_NO_EMPTY);
		
		if ( count($words) > $excerptLength )
		{
		  array_pop($words);
		  $text = implode(' ', $words);
		  $text = $text . $excerptMore;
		}
		else
		{
		  $text = implode(' ', $words);
		}
		
		return apply_filters('cn_trim_excerpt', $text);
	}
	
    /**
     * Returns $visibility.
     * @see entry::$visibility
     */
    public function getVisibility()
    {
        return $this->visibility;
    }
    
    /**
     * Sets $visibility.
     * @param object $visibility
     * @see entry::$visibility
     */
    public function setVisibility($visibility)
    {
        $this->visibility = $visibility;
    }
	
	public function displayVisibiltyType()
	{
		return ucfirst($this->getVisibility());
	}
    
    /**
     * Returns $category.
     *
     * @see cnEntry::$category
     */
    public function getCategory()
	{
		return $this->categories;
    }
    
	
    /**
     * Returns array of objects.
     * 
     * Each object contains:
     * 						->name
     * 						->type
     * 						->address
     * 						->url
     * 						->visibility
     * 
     * NOTE: The output is sanitized for safe display.
     * 
     * @return array
     */
	public function getWebsites()
    {
        if ( !empty($this->websites) )
		{
			$websites = unserialize($this->websites);
			
			foreach ( (array) $websites as $key => $website)
			{
				$websiteRow->name = $this->format->sanitizeString($website['name']);
				$websiteRow->type = $this->format->sanitizeString($website['type']);
				$websiteRow->address = $this->format->sanitizeString($website['address']);
				$websiteRow->url = $this->format->sanitizeString($website['url']);
				$websiteRow->visibility = $this->format->sanitizeString($website['visibility']);
				
				if ( empty($websiteRow->url) ) $websiteRow->url = $websiteRow->address;
				
				$websiteRow = apply_filters('cn_website', $websiteRow);
				
				$out[] = $websiteRow;
				unset($websiteRow);
			}
			
			$out = apply_filters('cn_websites', $out);
			
			if ( !empty($out) ) return $out;
		}
		
		return NULL;
    }
    
    /**
     * Sets $websites as an associative array.
     * If the website URL [address] is http:// or empty it is unset.
     * since there is no need to store it.
     * 
     * $websites is to be an array containing an array of the data for each website.
     * 
     * @TODO: Validate as valid web addresses.
     * 
     * @param array $websites
     */
    public function setWebsites($websites)
    {
		$validFields = array('name' => NULL, 'type' => NULL, 'address' => NULL, 'url' => NULL, 'visibility' => NULL);
		
		if ( !empty($websites) )
		{
			foreach ($websites as $key => $website)
			{
				// First validate the supplied data.
				$websites[$key] = $this->validate->attributesArray($validFields, $website);
				
				// If the address/url is emty, no need to store it and if the http protocol is not part of the address, add it.
				switch ($website['address'])
				{
					case '':
						unset($websites[$key]);
					break;
					
					case 'http://':
						unset($websites[$key]);
					break;
					
					default:
						if ( mb_substr($website['address'], 0, 7) != 'http://' )
						{
							$websites[$key]['address'] = 'http://' . $website['address'];
							$websites[$key]['url'] = $websites[$key]['address'];
						}
					break;
				}
				
			}
			
			$this->websites = serialize($websites);
		}
		else
		{
			$this->websites = NULL;
		}
		
		
    }

    /**
     * Returns the entry type.
     * 
     * Valid type are individual, organization and family.
     * 
     * @return string
     */
    public function getEntryType()
    {
        // This is to provide compatibility for versions >= 0.7.0.4
		if ( $this->entryType == 'connection_group' ) $this->entryType = 'family';
		
		return $this->entryType;
    }
    
    /**
     * Sets $entryType.
     * @param object $entryType
     * @see entry::$entryType
     */
    public function setEntryType($entryType)
    {
        $this->options['entry']['type'] = $entryType;
		$this->entryType = $entryType;
    }

    
	public function getLogoDisplay()
    {
        return $this->logoDisplay;
    }
    
    public function setLogoDisplay($logoDisplay)
    {
        $this->options['logo']['display'] = $logoDisplay;
    }
    
    public function getLogoLinked()
    {
        return $this->logoLinked;
    }
    
    public function setLogoLinked($logoLinked)
    {
        $this->options['logo']['linked'] = $logoLinked;
    }
	
	public function getLogoName()
    {
        if ( empty( $this->options['logo']['name'] ) ) return NULL;
		return $this->options['logo']['name'];
    }
    
    public function setLogoName($logoName)
    {
        $this->options['logo']['name'] = $logoName;
    }
	
    /**
     * Returns $imageDisplay.
     * @see entry::$imageDisplay
     */
    public function getImageDisplay()
    {
        return $this->imageDisplay;
    }
    
    /**
     * Sets $imageDisplay.
     * @param object $imageDisplay
     * @see entry::$imageDisplay
     */
    public function setImageDisplay($imageDisplay)
    {
        $this->options['image']['display'] = $imageDisplay;
    }
    
    /**
     * Returns $imageLinked.
     * @see entry::$imageLinked
     */
    public function getImageLinked()
    {
        return $this->imageLinked;
    }
    
    /**
     * Sets $imageLinked.
     * @param object $imageLinked
     * @see entry::$imageLinked
     */
    public function setImageLinked($imageLinked)
    {
        $this->options['image']['linked'] = $imageLinked;
    }

    /**
     * Returns $imageNameCard.
     * @see entry::$imageNameCard
     */
    public function getImageNameCard()
    {
        if ( empty( $this->options['image']['name']['entry'] ) ) return NULL;
		return $this->options['image']['name']['entry'];
    }
    
    /**
     * Sets $imageNameCard.
     * @param object $imageNameCard
     * @see entry::$imageNameCard
     */
    public function setImageNameCard($imageNameCard)
    {
        $this->options['image']['name']['entry'] = $imageNameCard;
    }
    
    /**
     * Returns $imageNameProfile.
     * @see entry::$imageNameProfile
     */
    public function getImageNameProfile()
    {
        if ( empty( $this->options['image']['name']['profile'] ) ) return NULL;
		return $this->options['image']['name']['profile'];
    }
    
    /**
     * Sets $imageNameProfile.
     * @param object $imageNameProfile
     * @see entry::$imageNameProfile
     */
    public function setImageNameProfile($imageNameProfile)
    {
        $this->options['image']['name']['profile'] = $imageNameProfile;
    }
    
    /**
     * Returns $imageNameThumbnail.
     * @see entry::$imageNameThumbnail
     */
    public function getImageNameThumbnail()
    {
        if ( empty( $this->options['image']['name']['thumbnail'] ) ) return NULL;
		return $this->options['image']['name']['thumbnail'];
    }
    
    /**
     * Sets $imageNameThumbnail.
     * @param object $imageNameThumbnail
     * @see entry::$imageNameThumbnail
     */
    public function setImageNameThumbnail($imageNameThumbnail)
    {
        $this->options['image']['name']['thumbnail'] = $imageNameThumbnail;
    }

    /**
     * Returns $imageNameOriginal.
     * @see entry::$imageNameOriginal
     */
    public function getImageNameOriginal()
    {
        if ( empty( $this->options['image']['name']['original'] ) ) return NULL;
		return $this->options['image']['name']['original'];
    }
    
    /**
     * Sets $imageNameOriginal.
     * 
     * @param object $imageNameOriginal
     * @see entry::$imageNameOriginal
     */
    public function setImageNameOriginal($imageNameOriginal)
    {
        $this->options['image']['name']['original'] = $imageNameOriginal;
    }
	
	public function getAddedBy()
	{
		$addedBy = get_userdata($this->addedBy);
		
		if ($addedBy)
		{
			return $addedBy->display_name;
		}
		else
		{
			return 'Unknown';
		}
		
		/*if (!$addedBy->display_name == NULL)
		{
			return $addedBy->display_name;
		}
		else
		{
			return 'Unknown';
		}*/
		
	}
	
	public function getSortColumn()
	{
		return $this->sortColumn;
	}
	
	public function getEditedBy()
	{
		$editedBy = get_userdata($this->editedBy);
		
		if ($editedBy)
		{
			return $editedBy->display_name;
		}
		else
		{
			return 'Unknown';
		}
		
		/*if (!$editedBy->display_name == NULL)
		{
			return $editedBy->display_name;
		}
		else
		{
			return 'Unknown';
		}*/
		
	}
	
    /**
     * Returns $options.
     * @see entry::$options
     */
    private function getOptions()
    {
        return $this->options;
    }
    
    /**
     * Sets $options.
     * @param object $options
     * @see entry::$options
     */
    private function serializeOptions()
    {
        $this->options = serialize($this->options);
    }
	
	/*public function get($id)
	{
		global $wpdb;
		return $wpdb->get_row('SELECT * FROM ' . $wpdb->prefix . 'connections WHERE id="' . $wpdb->escape($id) . '"');
	}*/
	
	public function set($id)
	{
		global $connections;
		$result = $connections->retrieve->entry($id);
		$this->__construct($result);
	}
	
	public function update()
	{
		global $wpdb, $connections;
		
		$this->serializeOptions();
		
		// Ensure fields that should be empty depending on the entry type.
		switch ($this->getEntryType())
		{
			case 'individual':
				$this->familyName = '';
				$this->familyMembers = '';
			break;
			
			case 'organization':
				$this->familyName = '';
				$this->honorificPrefix = '';
				$this->firstName = '';
				$this->middleName = '';
				$this->lastName = '';
				$this->honorific = '';
				$this->title = '';
				$this->familyMembers = '';
				$this->birthday = '';
				$this->anniversary = '';
			break;
			
			case 'family':
				$this->honorificPrefix = '';
				$this->firstName = '';
				$this->middleName = '';
				$this->lastName = '';
				$this->honorificSuffix = '';
				$this->title = '';
				$this->birthday = '';
				$this->anniversary = '';
			break;
			
			default:
				$this->entryType = 'individual';
				$this->familyName = '';
			break;
		}
		
		$wpdb->show_errors = true;
		
		return $wpdb->query($wpdb->prepare('UPDATE ' . CN_ENTRY_TABLE . ' SET
											ts			   		= "%s",
											entry_type			= "%s",
											honorific_prefix	= "%s",
											first_name			= "%s",
											middle_name			= "%s",
											last_name			= "%s",
											honorific_suffix	= "%s",
											title				= "%s",
											organization		= "%s",
											department			= "%s",
											contact_first_name	= "%s",
											contact_last_name	= "%s",
											family_name			= "%s",
											visibility			= "%s",
											birthday			= "%s",
											anniversary			= "%s",
											addresses			= "%s",
											phone_numbers		= "%s",
											email				= "%s",
											im					= "%s",
											social				= "%s",
											websites			= "%s",
											options				= "%s",
											bio					= "%s",
											notes				= "%s",
											edited_by			= "%d",
											status				= "%s"
											WHERE id			= "%d"',
											current_time('mysql'),
											$this->entryType,
											$this->honorificPrefix,
											$this->firstName,
											$this->middleName,
											$this->lastName,
											$this->honorificSuffix,
											$this->title,
											$this->organization,
											$this->department,
											$this->contactFirstName,
											$this->contactLastName,
											$this->familyName,
											$this->visibility,
											$this->birthday,
											$this->anniversary,
											$this->addresses,
											$this->phoneNumbers,
											$this->emailAddresses,
											$this->im,
											$this->socialMedia,
											$this->websites,
											$this->options,
											$this->bio,
											$this->notes,
											$connections->currentUser->getID(),
											'approved',
											$this->id));
		$wpdb->show_errors = FALSE;
	}
	
	public function save()
	{
		global $wpdb, $connections;
		
		$this->serializeOptions();
		
		// Ensure fields that should be empty depending on the entry type.
		switch ($this->getEntryType())
		{
			case 'individual':
				$this->familyName = '';
				$this->familyMembers = '';
			break;
			
			case 'organization':
				$this->familyName = '';
				$this->honorificPrefix = '';
				$this->firstName = '';
				$this->middleName = '';
				$this->lastName = '';
				$this->honorificSuffix = '';
				$this->title = '';
				$this->familyMembers = '';
				$this->birthday = '';
				$this->anniversary = '';
			break;
			
			case 'family':
				$this->honorificPrefix = '';
				$this->firstName = '';
				$this->middleName = '';
				$this->lastName = '';
				$this->honorificSuffix = '';
				$this->title = '';
				$this->birthday = '';
				$this->anniversary = '';
			break;
			
			default:
				$this->entryType = 'individual';
				$this->familyName = '';
			break;
		}
		
		$wpdb->show_errors = true;
		
		$sql = $wpdb->prepare('INSERT INTO ' . CN_ENTRY_TABLE . ' SET
											ts			   		= "%s",
											date_added   		= "%d",
											entry_type  		= "%s",
											visibility  		= "%s",
											family_name			= "%s",
											honorific_prefix	= "%s",
											first_name			= "%s",
											middle_name 		= "%s",
											last_name   		= "%s",
											honorific_suffix	= "%s",
											title    			= "%s",
											organization  		= "%s",
											department    		= "%s",
											contact_first_name 	= "%s",
											contact_last_name 	= "%s",
											addresses     		= "%s",
											phone_numbers 		= "%s",
											email	      		= "%s",
											im  	      		= "%s",
											social 	      		= "%s",
											websites      		= "%s",
											birthday      		= "%s",
											anniversary   		= "%s",
											bio           		= "%s",
											notes         		= "%s",
											options       		= "%s",
											added_by      		= "%d",
											edited_by     		= "%d",
											owner				= "%d",
											status	      		= "%s"',
											current_time('mysql'),
											current_time('timestamp'),
											$this->entryType,
											$this->visibility,
											$this->familyName,
											$this->honorificPrefix,
											$this->firstName,
											$this->middleName,
											$this->lastName,
											$this->honorificSuffix,
											$this->title,
											$this->organization,
											$this->department,
											$this->contactFirstName,
											$this->contactLastName,
											$this->addresses,
											$this->phoneNumbers,
											$this->emailAddresses,
											$this->im,
											$this->socialMedia,
											$this->websites,
											$this->birthday,
											$this->anniversary,
											$this->bio,
											$this->notes,
											$this->options,
											$connections->currentUser->getID(),
											$connections->currentUser->getID(),
											$connections->currentUser->getID(),
											'approved');
		
		$result = $wpdb->query($sql);
		
		$connections->lastQuery = $wpdb->last_query;
		$connections->lastQueryError = $wpdb->last_error;
		$connections->lastInsertID = $wpdb->insert_id;
		
		$wpdb->show_errors = FALSE;
		
		return $result;
	}
	
	public function delete($id)
	{
		global $wpdb, $connections;
		
		/*
		 * Delete images assigned to the entry.
		 * 
		 * Versions previous to 0.6.2.1 did not not make a duplicate copy of images when
		 * copying an entry so it was possible multiple entries could share the same image.
		 * Only images created after the date that version .0.7.0.0 was released will be deleted,
		 * plus a couple weeks for good measure.
		 */
		
		$compatiblityDate = mktime(0, 0, 0, 6, 1, 2010);
		
		if ( is_file( CN_IMAGE_PATH . $this->getImageNameOriginal() ) )
		{
			if ( $compatiblityDate < filemtime( CN_IMAGE_PATH . $this->getImageNameOriginal() ) ) unlink( CN_IMAGE_PATH . $this->getImageNameOriginal() );
		}
		
		if ( is_file( CN_IMAGE_PATH . $this->getImageNameThumbnail() ) )
		{
			if ( $compatiblityDate < filemtime( CN_IMAGE_PATH . $this->getImageNameThumbnail() ) ) unlink( CN_IMAGE_PATH . $this->getImageNameThumbnail() );
		}
		
		if ( is_file( CN_IMAGE_PATH . $this->getImageNameCard() ) )
		{
			if ( $compatiblityDate < filemtime( CN_IMAGE_PATH . $this->getImageNameCard() ) ) unlink( CN_IMAGE_PATH . $this->getImageNameCard() );
		}
		
		if ( is_file( CN_IMAGE_PATH . $this->getImageNameProfile() ) )
		{
			if ( $compatiblityDate < filemtime( CN_IMAGE_PATH . $this->getImageNameProfile() ) ) unlink( CN_IMAGE_PATH . $this->getImageNameProfile() );
		}
		
		$wpdb->query($wpdb->prepare('DELETE FROM ' . CN_ENTRY_TABLE . ' WHERE id="' . $wpdb->escape($id) . '"'));
		
		/**
		 * @TODO Only delete the category relationships if deleting the entry was successful
		 */
		
		$connections->term->deleteTermRelationships($id);
	}
	
}
?>