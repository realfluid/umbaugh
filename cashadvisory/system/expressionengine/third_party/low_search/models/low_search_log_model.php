<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// include super model
if ( ! class_exists('Low_search_model'))
{
	require_once(PATH_THIRD.'low_search/model.low_search.php');
}

/**
 * Low Search Log Model class
 *
 * @package        low_search
 * @author         Lodewijk Schutte <hi@gotolow.com>
 * @link           http://gotolow.com/addons/low-search
 * @copyright      Copyright (c) 2014, Low
 */
class Low_search_log_model extends Low_search_model {

	// --------------------------------------------------------------------
	// METHODS
	// --------------------------------------------------------------------

	/**
	 * Constructor
	 *
	 * @access      public
	 * @return      void
	 */
	function __construct()
	{
		// Call parent constructor
		parent::__construct();

		// Initialize this model
		$this->initialize(
			'low_search_log',
			'log_id',
			array(
				'site_id'      => 'int(4) unsigned NOT NULL',
				'member_id'    => 'int(10) unsigned NOT NULL',
				'search_date'  => 'int(10) unsigned NOT NULL',
				'ip_address'   => 'varchar(16) NOT NULL',
				'keywords'     => 'varchar(150) NOT NULL',
				'parameters'   => 'TEXT NOT NULL'
			)
		);
	}

	// --------------------------------------------------------------------

	/**
	 * Installs given table
	 *
	 * @access      public
	 * @return      void
	 */
	public function install()
	{
		// Call parent install
		parent::install();

		// Add indexes to table
		ee()->db->query("ALTER TABLE {$this->table()} ADD INDEX (`site_id`)");
	}

	// --------------------------------------------------------------------

	/**
	 * Get filtered rows
	 *
	 * @access      public
	 * @return      array
	 */
	public function get_filtered_rows($filters = array())
	{
		$this->_set_filters($filters);
		return $this->get_all();
	}

	/**
	 * Get row count for filters
	 */
	public function get_filtered_count($filters = array())
	{
		$this->_set_filters($filters);
		return ee()->db->count_all_results($this->table());
	}

	/**
	 * Set the filters
	 */
	private function _set_filters($filters = array())
	{
		// Make sure these are
		$filters = (array) $filters;
		$filters = array_map('trim', $filters);
		$filters = array_filter($filters, 'low_not_empty');

		// Loop through filter options
		foreach ($filters AS $key => $val)
		{
			if ( ! in_array($key, $this->attributes())) continue;

			switch ($key)
			{
				case 'keywords':
				case 'ip_address':
					ee()->db->like($key, $val);
				break;

				case 'search_date':
					ee()->db->where("FROM_UNIXTIME(search_date, '%Y-%m-%d') =", $val);
				break;

				default:
					ee()->db->where($key, $val);
			}
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Get popular keywords
	 *
	 * @access      public
	 * @return      array
	 */
	public function get_popular_keywords()
	{
		$query = ee()->db->select('keywords, COUNT(*) AS search_count')
		       ->from($this->table())
		       ->where('keywords !=', '')
		       ->group_by('keywords')
		       ->order_by('search_count', 'desc')
		       ->order_by('search_date', 'desc')
		       ->get();

		return $query->result_array();
	}

	// --------------------------------------------------------------------

	/**
	 * Prune rows
	 *
	 * @access      public
	 * @param       int
	 * @param       int
	 * @return      void
	 */
	public function prune($site_id, $keep = 500)
	{
		// Get first id after keep-threshold
		$query = ee()->db->select($this->pk())
		       ->from($this->table())
		       ->where('site_id', $site_id)
		       ->order_by($this->pk(), 'desc')
		       ->limit(1, $keep)
		       ->get();

		// That's the one
		// If the id is larger than the amount to keep,
		// go ahead and prune...
		if ($id = $query->row($this->pk()))
		{
			ee()->db->where($this->pk(). ' <=', $id);
			ee()->db->where('site_id', $site_id);
			ee()->db->delete($this->table());
		}
	}

	// --------------------------------------------------------------

} // End class

/* End of file Low_search_log_model.php */