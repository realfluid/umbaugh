<?php

class cnRetrieve
{
	/**
	 * @return array
	 */
	public function entries( $suppliedAttr = array() )
	{
		global $wpdb, $connections;
		
		$validate = new cnValidate();
		$join = array();
		$where[] = 'WHERE 1=1';
		
		$permittedEntryTypes = array('individual', 'organization', 'family', 'connection_group');
		
		/*
		 * // START -- Set the default attributes array. \\
		 */
			$defaultAttr['list_type'] = NULL;
			$defaultAttr['id'] = NULL;
			$defaultAttr['category'] = NULL;
			$defaultAttr['exclude_category'] = NULL;
			$defaultAttr['category_name'] = NULL;
			$defaultAttr['wp_current_category'] = FALSE;
			$defaultAttr['visibility'] = NULL;
			$defaultAttr['allow_public_override'] = FALSE;
			$defaultAttr['private_override'] = FALSE;
			$defaultAttr['limit'] = NULL;
			$defaultAttr['offset'] = NULL;
			$defaultAttr['order_by'] = NULL;
			
			$atts = $validate->attributesArray($defaultAttr, $suppliedAttr);
		/*
		 * // END -- Set the default attributes array if not supplied. \\
		 */
		
		/*
		 * If in a post get the category names assigned to the post.
		 */
		if ( $atts['wp_current_category'] && !is_page() )
		{
			// Get the current post categories.
			$wpCategories = get_the_category();
			
			// Build an array of the post categories.
			foreach ($wpCategories as $wpCategory)
			{
				$wpCategoryNames[] = $wpCategory->cat_name;
			}
		}
		
		/*
		 * Build and array of the supplied category names and their children.
		 */
		if ( !empty($atts['category_name']) )
		{
			// If value is a string convert to an array.
			if ( !is_array($atts['category_name']) )
			{
				$atts['category_name'] = explode(',', $atts['category_name']);
			}
			
			foreach ( $atts['category_name'] as $categoryName )
			{
				// Add the parent category to the array and remove any whitespace from the begining/end of the name in case the user added it when using the shortcode.
				$categoryNames[] = trim($categoryName);
				
				// Retrieve the children categories
				$results = $this->categoryChildren('name', $categoryName);
				
				foreach ( (array) $results as $term )
				{
					$categoryNames[] = $term->name;
				}
			}
		}
		
		/*
		 * Create the string to be used to query entries based on category names. This will merge the
		 * category names from the current post categories and the supplied category names and their
		 * respective children categories.
		 */
		$catNameString = implode("', '", array_merge( (array) $wpCategoryNames, (array) $categoryNames ) );
		unset( $wpCategoryNames );
		unset( $categoryNames );
		
		
		/*
		 * Build an array of all the categories and their children based on the supplied category IDs.
		 */
		if ( !empty($atts['category']) )
		{
			// If value is a string, string the white space and covert to an array.
			if ( !is_array($atts['category']) )
			{
				$atts['category'] = str_replace(' ', '', $atts['category']);
				
				$atts['category'] = explode(',', $atts['category']);
			}
			
			foreach ($atts['category'] as $categoryID)
			{
				// Add the parent category ID to the array.
				$categoryIDs[] = $categoryID;
				
				// Retrieve the children categories
				$results = $this->categoryChildren('term_id', $categoryID);
				
				foreach ( (array) $results as $term )
				{
					$categoryIDs[] = $term->term_id;
				}
			}
			
			/*
			 * Exclude the specified categories by ID.
			 */
			if ( !empty($atts['exclude_category']) )
			{
				// If value is a string, string the white space and covert to an array.
				if ( !is_array($atts['exclude_category']) )
				{
					$atts['exclude_category'] = str_replace(' ', '', $atts['exclude_category']);
					
					$atts['exclude_category'] = explode(',', $atts['exclude_category']);
				}
				
				$categoryIDs = array_diff($categoryIDs, $atts['exclude_category']);
			}
			
			/*
			 * Create the string to be used to query entries based on category IDs.
			 */
			$catIDString = implode("', '", $categoryIDs);
			
			unset( $categoryIDs );
		}
		
		
		
		if ( !empty($catIDString) || !empty($catNameString) )
		{
			// Set the query string to INNER JOIN the term relationship and taxonomy tables.
			$join[] = 'INNER JOIN ' . CN_TERM_RELATIONSHIP_TABLE . ' ON ( ' . CN_ENTRY_TABLE . '.id = ' . CN_TERM_RELATIONSHIP_TABLE . '.entry_id )';
			$join[] = 'INNER JOIN ' . CN_TERM_TAXONOMY_TABLE . ' ON ( ' . CN_TERM_RELATIONSHIP_TABLE . '.term_taxonomy_id = ' . CN_TERM_TAXONOMY_TABLE . '.term_taxonomy_id )';
			$join[] = 'INNER JOIN ' . CN_TERMS_TABLE . ' ON ( ' . CN_TERMS_TABLE . '.term_id = ' . CN_TERM_TAXONOMY_TABLE . '.term_id )';
			
			// Set the query string to return entries within the category taxonomy.
			$where[] = 'AND ' . CN_TERM_TAXONOMY_TABLE . '.taxonomy = \'category\'';
			
			if ( !empty($catIDString) )
			{
				$where[] = 'AND ' . CN_TERM_TAXONOMY_TABLE . '.term_id IN (\'' . $catIDString . '\')';
			}
			
			if ( !empty($catNameString) )
			{
				$where[] = 'AND ' . CN_TERMS_TABLE . '.name IN (\'' . $catNameString . '\')';
			}
		}
		
		
		
		// Convert the supplied IDs $atts['id'] to an array.
		if ( !is_array($atts['id']) && !empty($atts['id']))
		{
			// Trim the space characters if present.
			$atts['id'] = str_replace(' ', '', $atts['id']);
			
			// Convert to array.
			$atts['id'] = explode(',', $atts['id']);
		}
		
		// Set query string to return specific entries.
		if ( !empty($atts['id']) ) $where[] = 'AND `id` IN (\'' . implode("', '", (array) $atts['id']) . '\')';
		
		
		// Convert the supplied entry types $atts['list_type'] to an array.
		if ( !is_array($atts['list_type']) && !empty($atts['list_type']) )
		{
			// Trim the space characters if present.
			$atts['list_type'] = str_replace(' ', '', $atts['list_type']);
			
			// Convert to array.
			$atts['list_type'] = explode(',', $atts['list_type']);
		}
		
		// Set query string for entry type.
		if ( !empty($atts['list_type']) && (bool) array_intersect($atts['list_type'], $permittedEntryTypes) )
		{
			// Capatibility code to make sure any ocurrences of the deprecated entry type connections_group is changed to entry type family
			$atts['list_type'] = str_replace('connection_group', 'family', $atts['list_type']);
			
			$where[] = 'AND `entry_type` IN (\'' . implode("', '", (array) $atts['list_type']) . '\')';
		}
		
		
		// Set query string for visibility based on user permissions if logged in.
		if ( is_user_logged_in() )
		{
			if ( !$atts['visibility'] )
			{
				if ( current_user_can('connections_view_public') ) $visibility[] = 'public';
				if ( current_user_can('connections_view_private') ) $visibility[] = 'private';
				if ( current_user_can('connections_view_unlisted') && is_admin() ) $visibility[] = 'unlisted';
			}
			else
			{
				$visibility[] = $atts['visibility'];
			}
		}
		else
		{
			if ( $connections->options->getAllowPublic() ) $visibility[] = 'public';
			if ( $atts['allow_public_override'] == TRUE && $connections->options->getAllowPublicOverride() ) $visibility[] = 'public';
			if ( $atts['private_override'] == TRUE && $connections->options->getAllowPrivateOverride() ) $visibility[] = 'private';
		}
		
		$where[] = 'AND `visibility` IN (\'' . implode("', '", (array) $visibility) . '\')';
		
		( empty($atts['limit']) ) ? $limit = NULL : $limit = ' LIMIT ' . $atts['limit'] . ' ';
		( empty($atts['offset']) ) ? $offset = NULL : $offset = ' OFFSET ' . $atts['offset'] . ' ';
		
		$sql = 'SELECT DISTINCT ' . CN_ENTRY_TABLE . '.*,
				
				CASE `entry_type`
				  WHEN \'individual\' THEN `last_name`
				  WHEN \'organization\' THEN `organization`
				  WHEN \'connection_group\' THEN `family_name`
				  WHEN \'family\' THEN `family_name`
				END AS `sort_column`
				 
				FROM ' . CN_ENTRY_TABLE . ' ' . implode(' ', $join) . ' ' .
				
				implode(' ', $where) . ' ' . 
				
				'ORDER BY `sort_column`, `last_name`, `first_name`  ' . $limit . $offset;
		
		
		$results = $wpdb->get_results($sql);
		
		$connections->lastQuery = $wpdb->last_query;
		$connections->lastQueryError = $wpdb->last_error;
		$connections->lastInsertID = $wpdb->insert_id;
		$connections->resultCount = $wpdb->num_rows;
		$connections->recordCount = $this->recordCount($atts['allow_public_override'], $atts['private_override']);
		
		return $this->orderBy($results, $atts['order_by'], $atts['id']);
	}
	
	public function entry($id)
	{
		global $wpdb;
		return $wpdb->get_row('SELECT * FROM ' . $wpdb->prefix . 'connections WHERE id="' . $wpdb->escape($id) . '"');
	}
	
	public function entryCategories($id)
	{
		global $wpdb;
		
		// Retrieve the categories.
		$results =  $wpdb->get_results( $wpdb->prepare( "SELECT t.*, tt.* FROM " . CN_TERMS_TABLE . " AS t INNER JOIN " . CN_TERM_TAXONOMY_TABLE . " AS tt ON t.term_id = tt.term_id INNER JOIN " . CN_TERM_RELATIONSHIP_TABLE . " AS tr ON tt.term_taxonomy_id = tr.term_taxonomy_id WHERE tt.taxonomy = 'category' AND tr.entry_id = %d ", $id) );
		//SELECT t.*, tt.* FROM wp_connections_terms AS t INNER JOIN wp_connections_term_taxonomy AS tt ON t.term_id = tt.term_id INNER JOIN wp_connections_term_relationships AS tr ON tt.term_taxonomy_id = tr.term_taxonomy_id WHERE tt.taxonomy = 'category' AND tr.entry_id = 325
		
		if ( !empty($results) )
		{
			usort($results, array(&$this, 'sortTermsByName') );
		}
		
		return $results;
	}
	
	/**
	 * Sort the entries by the user set attributes.
	 * 
	 * $object	--	syntax is field|SORT_ASC(SORT_DESC)|SORT_REGULAR(SORT_NUMERIC)(SORT_STRING)
	 * 				
	 * example  --	'state|SORT_ASC|SORT_STRING, last_name|SORT_DESC|SORT_REGULAR
	 * 
	 * 
	 * Available order_by fields:
	 * 	id
	 *  date_added
	 *  date_modified
	 *  first_name
	 * 	last_name
	 * 	organization
	 * 	department
	 * 	city
	 * 	state
	 * 	zipcode
	 * 	country
	 * 	birthday
	 * 	anniversary
	 * 
	 * Order Flags:
	 * 	SORT_ACS
	 * 	SORT_DESC
	 *  SPECIFIED**
	 * 	RANDOM**
	 * 
	 * Sort Types:
	 * 	SORT_REGULAR
	 * 	SORT_NUMERIC
	 * 	SORT_STRING
	 * 
	 * **NOTE: The SPECIFIED and RANDOM Order Flags can only be used
	 * with the id field. The SPECIFIED flag must be used in conjuction
	 * with $suppliedIDs which can be either a comma delimited sting or
	 * an indexed array of entry IDs. If this is set, other sort fields/flags
	 * are ignored.
	 * 
	 * @param array of object $entries
	 * @param string $orderBy
	 * @param string || array $ids [optional]
	 * @return array of objects
	 */
	private function orderBy(&$entries, $orderBy, $suppliedIDs = NULL)
	{
		if ( empty($entries) || empty($orderBy) ) return $entries;
		
		$orderFields = array(
							'id',
							'date_added',
							'date_modified',
							'first_name',
							'last_name',
							'title',
							'organization',
							'department',
							'city',
							'state',
							'zipcode',
							'country',
							'birthday',
							'anniversary'
							);
		
		$sortFlags = array(
							'SPECIFIED' => 'SPECIFIED',
							'RANDOM' => 'RANDOM',
							'SORT_ASC' => SORT_ASC,
							'SORT_DESC' => SORT_DESC,
							'SORT_REGULAR' => SORT_REGULAR,
							'SORT_NUMERIC' => SORT_NUMERIC,
							'SORT_STRING' => SORT_STRING
							);
		
		$specifiedIDOrder = FALSE;
		
		// Build an array of each field to sort by and attributes.
		$sortFields = explode(',', $orderBy);
		
		// For each field the sort order can be defined as well as the sort type
		foreach ($sortFields as $sortField)
		{
			$sortAtts[] = explode('|', $sortField);
		}
		
		/*
		 * Dynamically build the variables that will be used for the array_multisort.
		 * 
		 * The field type should be the first item in the array if the user
		 * constructed the shortcode attribute correctly.
		 */
		foreach ($sortAtts as $field)
		{
			// Trim any spaces the user might have added to the shortcode attribute.
			$field[0] = strtolower(trim($field[0]));
			
			// If a user included a sort field that is invalid/mis-spelled it is skipped since it can not be used.
			if(!in_array($field[0], $orderFields)) continue;
			
			// The dynamic variable are being created and populated.
			foreach ($entries as $key => $row)
			{
				$entry = new cnEntry($row);
				
				switch ($field[0])
				{
					case 'id':
						${$field[0]}[$key] = $entry->getId();
					break;
					
					case 'date_added':
						${$field[0]}[$key] = $entry->getDateAdded('U');
					break;
					
					case 'date_modified':
						${$field[0]}[$key] = $entry->getUnixTimeStamp();
					break;
					
					case 'first_name':
						${$field[0]}[$key] = $entry->getFirstName();
					break;
					
					case 'last_name':
						${$field[0]}[$key] = $entry->getLastName();
					break;
					
					case 'title':
						${$field[0]}[$key] = $entry->getTitle();
					break;
					
					case 'organization':
						${$field[0]}[$key] = $entry->getOrganization();
					break;
					
					case 'department':
						${$field[0]}[$key] = $entry->getDepartment();
					break;
					
					case ($field[0] === 'city' || $field[0] === 'state' || $field[0] === 'zipcode' || $field[0] === 'country'):
						if ($entry->getAddresses())
						{
							$addresses = $entry->getAddresses();
							
							foreach ($addresses as $address)
							{
								//${$field[0]}[$key] = $address[$field[0]];
								${$field[0]}[$key] = $address->$field[0];
								
								// Only set the data from the first address.
								break;
							}
							
						}
						else
						{
							${$field[0]}[$key] = NULL;
						}
					break;
					
					case 'birthday':
						${$field[0]}[$key] = strtotime($entry->getBirthday());
					break;
					
					case 'anniversary':
						${$field[0]}[$key] = strtotime($entry->getAnniversary());
					break;
				}
				
			}
			// The sorting order to be determined by a lowercase copy of the original array.
			$$field[0] = array_map('strtolower', $$field[0]);
			
			// The arrays to be sorted must be passed by reference or it won't work.
			$sortParams[] = &$$field[0];
			
			// Add the flag and sort type to the sort parameters if they were supplied in the shortcode attribute.
			foreach($field as $key => $flag)
			{
				// Trim any spaces the user might have added and change the string to uppercase..
				$flag = strtoupper(trim($flag));
				
				// If a user included a sort tag that is invalid/mis-spelled it is skipped since it can not be used.
				if (!array_key_exists($flag, $sortFlags)) continue;
				
				/* 
				 * If the order is specified set the variable to true and continue
				 * because SPECIFIED should not be added to the $sortParams array
				 * as that would be an invalid argument for the array multisort.
				 */
				if ( $flag === 'SPECIFIED' || $flag === 'RANDOM' )
				{
					$idOrder = $flag;
					continue;
				}
				
				// Must be pass as reference or the multisort will fail.
				$sortParams[] = &$sortFlags[$flag];
				unset($flag);
			}
		}
		
		/*
		 * 
		 */
		if ( isset($id) && isset($idOrder) )
		{
			switch ($idOrder)
			{
				case 'SPECIFIED':
					$sortedEntries = array();
					
					/*
					 * Convert the supplied IDs value to an array if it is not.
					 */
					if ( !is_array( $suppliedIDs ) && !empty( $suppliedIDs ) )
					{
						// Trim the space characters if present.
						$suppliedIDs = str_replace(' ', '', $suppliedIDs);
						// Convert to array.
						$suppliedIDs = explode(',', $suppliedIDs);
					}
					
					foreach ( $suppliedIDs as $entryID )
					{
						$sortedEntries[] = $entries[array_search($entryID, $id)];
					}
					
					$entries = $sortedEntries;
					return $entries;
				break;
				
				case 'RANDOM':
					shuffle($entries);
					return $entries;
				break;
			}
		}
		
		/*print_r($sortParams);
		print_r($first_name);
		print_r($last_name);
		print_r($state);
		print_r($zipcode);
		print_r($organization);
		print_r($department);
		print_r($birthday);
		print_r($anniversary);*/
		
		// Must be pass as reference or the multisort will fail.
		$sortParams[] = &$entries;
		
		//$sortParams = array(&$state, SORT_ASC, SORT_REGULAR, &$zipcode, SORT_DESC, SORT_STRING, &$entries);
		call_user_func_array('array_multisort', $sortParams);
		
		return $entries;
	}
	
	/**
	 * Sorts terms by name.
	 * 
	 * @param object $a
	 * @param object $b
	 * @return integer
	 */
	private function sortTermsByName($a, $b)
	{
		return strcmp($a->name, $b->name);
	}
	
	/**
	 * Sorts terms by ID.
	 * 
	 * @param object $a
	 * @param object $b
	 * @return integer
	 */
	private function sortTermsByID($a, $b)
	{
		if ( $a->term_id > $b->term_id )
		{
			return 1;
		}
		elseif ( $a->term_id < $b->term_id )
		{
			return -1;
		} 
		else
		{
			return 0;
		}
	}
	
	/**
	 * Total record count based on current user permissions.
	 * 
	 * @param bool $allowPublicOverride
	 * @param bool $allowPrivateOverride
	 * @return integer
	 */
	private function recordCount($allowPublicOverride, $allowPrivateOverride)
	{
		global $wpdb, $connections;
		
		$where[] = 'WHERE 1=1';
		
		if ( is_user_logged_in() )
		{
			if ( current_user_can('connections_view_public') ) $visibility[] = 'public';
			if ( current_user_can('connections_view_private') ) $visibility[] = 'private';
			if ( current_user_can('connections_view_unlisted') && is_admin() ) $visibility[] = 'unlisted';
		}
		else
		{
			if ( $connections->options->getAllowPublic() ) $visibility[] = 'public';
			if ( $allowPublicOverride == TRUE && $connections->options->getAllowPublicOverride() ) $visibility[] = 'public';
			if ( $allowPrivateOverride == TRUE && $connections->options->getAllowPrivateOverride() ) $visibility[] = 'private';
		}
		
		$where[] =  'AND `visibility` IN (\'' . implode("', '", (array) $visibility) . '\')';
		
		return $wpdb->get_var( 'SELECT COUNT(`id`) FROM ' . CN_ENTRY_TABLE . ' ' . implode(' ', $where) );
	}
	
	/**
	 * Returns all the category terms.
	 * 
	 * @return object
	 */
	public function categories()
	{
		global $connections;
		
		return $connections->term->getTerms('category');
	}
	
	/**
	 * Returns category by ID.
	 * 
	 * @param interger $id
	 * @return object
	 */
	public function category($id)
	{
		global $connections;
		
		return $connections->term->getTerm($id, 'category');
	}
	
	/**
	 * Retrieve the children of the supplied parent.
	 * 
	 * @param interger $id
	 * @return array
	 */
	public function categoryChildren($field, $value)
	{
		global $connections;
		
		return $connections->term->getTermChildrenBy($field, $value, 'category');
	}
	
}

?>