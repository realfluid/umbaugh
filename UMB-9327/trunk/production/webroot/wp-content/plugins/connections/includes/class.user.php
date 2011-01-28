<?php
class cnUser
{
	/**
	 * @TODO: Initialize the cnUser class with the current user ID and
	 * add a method to make a single call to get_user_meta() rather than
	 * making multiples calls to reduce db accesses.
	 */
	
	/**
	 * Interger: stores the current WP user ID
	 * @var interger
	 */
	private $ID;
	
	/**
	 * String: holds the last set entry type for the persistant filter
	 * @var string
	 */
	private $filterEntryType;
	
	/**
	 * String: holds the last set visibility type for the persistant filter
	 * @var string
	 */
	private $filterVisibility;
	
	public function getID()
    {
        return $this->ID;
    }
    
	public function setID($id)
	{
		$this->ID = $id;
	}
	
	public function getFilterEntryType()
    {
		/*
		 * Use get_user_meta() used in WP 3.0 and newer
		 * since get_usermeta() was deprecated.
		 */
		if ( function_exists('get_user_meta') )
		{
			$user_meta = get_user_meta($this->ID, 'connections', TRUE);
		}
		else
		{
			$user_meta = get_usermeta($this->ID, 'connections');
		}
		
		if ( !$user_meta == NULL && isset($user_meta['filter']['entry_type']) )
		{
			return $user_meta['filter']['entry_type'];
		}
		else
		{
			return 'all';
		}
    }
    
    public function setFilterEntryType($entryType)
    {
		$permittedEntryTypes = array('all', 'individual', 'organization', 'family');
		$entryType = esc_attr($entryType);
		
		if (!in_array($entryType, $permittedEntryTypes)) return FALSE;
		
		/*
		 * Use get_user_meta() used in WP 3.0 and newer
		 * since get_usermeta() was deprecated.
		 */
		if ( function_exists('get_user_meta') )
		{
			$user_meta = get_user_meta($this->ID, 'connections', TRUE);
		}
		else
		{
			$user_meta = get_usermeta($this->ID, 'connections');
		}
		
		$user_meta['filter']['entry_type'] = $entryType;
		
		/*
		 * Use update_user_meta() used in WP 3.0 and newer
		 * since update_usermeta() was deprecated.
		 */
		if ( function_exists('update_user_meta') )
		{
			update_user_meta($this->ID, 'connections', $user_meta);
		}
		else
		{
			update_usermeta($this->ID, 'connections', $user_meta);
		}
    }
	
	/**
	 * Returns the cached visibility filter setting as string or FALSE depending if the current user has sufficient permission.
	 * 
	 * @return string || bool
	 */
	public function getFilterVisibility()
    {
        /*
		 * Use get_user_meta() used in WP 3.0 and newer
		 * since get_usermeta() was deprecated.
		 */
		if ( function_exists('get_user_meta') )
		{
			$user_meta = get_user_meta($this->ID, 'connections', TRUE);
		}
		else
		{
			$user_meta = get_usermeta($this->ID, 'connections');
		}
		
		if ( !$user_meta == NULL && isset($user_meta['filter']['visibility']) )
		{
			/*
			 * Reset the user's cached visibility filter if they no longer have access.
			 */
			switch ($user_meta['filter']['visibility'])
			{
				case 'public':
					if (!current_user_can('connections_view_public'))
					{
						return FALSE;
					}
					else
					{
						return $user_meta['filter']['visibility'];
					}
				break;
				
				case 'private':
					if (!current_user_can('connections_view_private'))
					{
						return FALSE;
					}
					else
					{
						return $user_meta['filter']['visibility'];
					}
				break;
				
				case 'unlisted':
					if (!current_user_can('connections_view_unlisted'))
					{
						return FALSE;
					}
					else
					{
						return $user_meta['filter']['visibility'];
					}
				break;
				
				default:
					return FALSE;
				break;
			}
		}
		else
		{
			return FALSE;
		}
    }
    
    public function setFilterVisibility($visibility)
    {
		$permittedVisibility = array('all', 'public', 'private', 'unlisted');
		$visibility = esc_attr($visibility);
		
		if (!in_array($visibility, $permittedVisibility)) return FALSE;
		
		/*
		 * Use get_user_meta() used in WP 3.0 and newer
		 * since get_usermeta() was deprecated.
		 */
		if ( function_exists('get_user_meta') )
		{
			$user_meta = get_user_meta($this->ID, 'connections', TRUE);
		}
		else
		{
			$user_meta = get_usermeta($this->ID, 'connections');
		}
		
		$user_meta['filter']['visibility'] = $visibility;
		
		/*
		 * Use update_user_meta() used in WP 3.0 and newer
		 * since update_usermeta() was deprecated.
		 */
		if ( function_exists('update_user_meta') )
		{
			update_user_meta($this->ID, 'connections', $user_meta);
		}
		else
		{
			update_usermeta($this->ID, 'connections', $user_meta);
		}
    }
	
	public function getFilterCategory()
    {
        /*
		 * Use get_user_meta() used in WP 3.0 and newer
		 * since get_usermeta() was deprecated.
		 */
		if ( function_exists('get_user_meta') )
		{
			$user_meta = get_user_meta($this->ID, 'connections', TRUE);
		}
		else
		{
			$user_meta = get_usermeta($this->ID, 'connections');
		}
		
		if ( !$user_meta == NULL && isset($user_meta['filter']) )
		{
			return $user_meta['filter']['category'];
		}
		else
		{
			return '';
		}
    }
    
    public function setFilterCategory($id)
    {
        // If value is -1 from drop down, set to NULL
		if ($id == -1) $id = NULL;
		
		/*
		 * Use get_user_meta() used in WP 3.0 and newer
		 * since get_usermeta() was deprecated.
		 */
		if ( function_exists('get_user_meta') )
		{
			$user_meta = get_user_meta($this->ID, 'connections', TRUE);
		}
		else
		{
			$user_meta = get_usermeta($this->ID, 'connections');
		}
		
		$user_meta['filter']['category'] = $id;
		
		/*
		 * Use update_user_meta() used in WP 3.0 and newer
		 * since update_usermeta() was deprecated.
		 */
		if ( function_exists('update_user_meta') )
		{
			update_user_meta($this->ID, 'connections', $user_meta);
		}
		else
		{
			update_usermeta($this->ID, 'connections', $user_meta);
		}
    }
	
	public function setMessage($message)
	{
		/*
		 * Use get_user_meta() used in WP 3.0 and newer
		 * since get_usermeta() was deprecated.
		 */
		if ( function_exists('get_user_meta') )
		{
			$user_meta = get_user_meta($this->ID, 'connections', TRUE);
		}
		else
		{
			$user_meta = get_usermeta($this->ID, 'connections');
		}
		
		$user_meta['messages'][] = $message;
		
		/*
		 * Use update_user_meta() used in WP 3.0 and newer
		 * since update_usermeta() was deprecated.
		 */
		if ( function_exists('update_user_meta') )
		{
			update_user_meta($this->ID, 'connections', $user_meta);
		}
		else
		{
			update_usermeta($this->ID, 'connections', $user_meta);
		}
	}
	
	public function getMessages()
	{
		/*
		 * Use get_user_meta() used in WP 3.0 and newer
		 * since get_usermeta() was deprecated.
		 */
		if ( function_exists('get_user_meta') )
		{
			$user_meta = get_user_meta($this->ID, 'connections', TRUE);
		}
		else
		{
			$user_meta = get_usermeta($this->ID, 'connections');
		}
		//print_r($user_meta);
		if (!empty($user_meta['messages']))
		{
			return $user_meta['messages'];
		}
		else
		{
			return array();
		}
	}
	
	public function resetMessages()
	{
		/*
		 * Use get_user_meta() used in WP 3.0 and newer
		 * since get_usermeta() was deprecated.
		 */
		if ( function_exists('get_user_meta') )
		{
			$user_meta = get_user_meta($this->ID, 'connections', TRUE);
		}
		else
		{
			$user_meta = get_usermeta($this->ID, 'connections');
		}
		
		if ( isset($user_meta['messages']) )unset($user_meta['messages']);
		//print_r($user_meta);
		/*
		 * Use update_user_meta() used in WP 3.0 and newer
		 * since update_usermeta() was deprecated.
		 */
		if ( function_exists('update_user_meta') )
		{
			update_user_meta($this->ID, 'connections', $user_meta);
		}
		else
		{
			update_usermeta($this->ID, 'connections', $user_meta);
		}
	}
}
?>