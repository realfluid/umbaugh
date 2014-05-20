<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Filter by grouped categories
 *
 * @package        low_search
 * @author         Lodewijk Schutte ~ Low <hi@gotolow.com>
 * @link           http://gotolow.com/addons/low-search
 * @copyright      Copyright (c) 2014, Low
 */
class Low_search_filter_categories extends Low_search_filter {

	/**
	 * Allows for category groups filtering: (1|2|3) && (4|5|6)
	 *
	 * @access     public
	 * @return     void
	 */
	public function filter($entry_ids)
	{
		// --------------------------------------
		// See if there are groups present, with correct values
		// --------------------------------------

		$groups = array_filter(
			$this->params->get_prefixed('category:'),
			'low_param_is_numeric'
		);

		// --------------------------------------
		// Bail out if there are no groups
		// --------------------------------------

		if (empty($groups)) return $entry_ids;

		// --------------------------------------
		// Log it
		// --------------------------------------

		$this->_log('Applying '.__CLASS__);

		// --------------------------------------
		// Loop through groups, compose SQL
		// --------------------------------------

		foreach ($groups AS $key => $val)
		{
			// Prep the value
			$val = $this->params->prep($key, $val);

			// Get the parameter
			list($ids, $in) = low_explode_param($val);

			// Match all?
			$all = (bool) strpos($val, '&');

			// One query per group
			ee()->db->select('entry_id')
			        ->from('category_posts')
			        ->{$in ? 'where_in' : 'where_not_in'}('cat_id', $ids);

			// Limit by already existing ids
			if ($entry_ids)
			{
				ee()->db->where_in('entry_id', $entry_ids);
			}

			// Do the having-trick to account for *all* given entry ids
			if ($in && $all)
			{
				ee()->db->select('COUNT(*) AS num')
				        ->group_by('entry_id')
				        ->having('num', count($ids));
			}

			// Execute query
			$query = ee()->db->get();

			// And get the entry ids
			$entry_ids = low_flatten_results($query->result_array(), 'entry_id');
			$entry_ids = array_unique($entry_ids);

			// Bail out if there aren't any matches
			if (is_array($entry_ids) && empty($entry_ids)) break;
		}

		return $entry_ids;
	}

	// --------------------------------------------------------------------

	/**
	 * Results: remove rogue {low_search_category:...} vars
	 */
	public function results($query)
	{
		$this->_remove_rogue_vars('category:');
		return $query;
	}
}
// End of file lsf.categories.php
