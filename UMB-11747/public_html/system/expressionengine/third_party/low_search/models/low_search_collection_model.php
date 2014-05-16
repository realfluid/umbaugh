<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// include super model
if ( ! class_exists('Low_search_model'))
{
	require_once(PATH_THIRD.'low_search/model.low_search.php');
}

/**
 * Low Search Collection Model class
 *
 * @package        low_search
 * @author         Lodewijk Schutte <hi@gotolow.com>
 * @link           http://gotolow.com/addons/low-search
 * @copyright      Copyright (c) 2014, Low
 */
class Low_search_collection_model extends Low_search_model {

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
			'low_search_collections',
			'collection_id',
			array(
				'site_id'          => 'int(4) unsigned NOT NULL',
				'channel_id'       => 'int(6) unsigned NOT NULL',
				'collection_name'  => 'varchar(40) NOT NULL',
				'collection_label' => 'varchar(100) NOT NULL',
				'modifier'         => 'decimal(2,1) unsigned NOT NULL default 1.0',
				'excerpt'          => 'int(6) unsigned NOT NULL default 0',
				'settings'         => 'text NOT NULL',
				'edit_date'        => 'int(10) unsigned NOT NULL'
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
		ee()->db->query("ALTER TABLE {$this->table()} ADD INDEX (`channel_id`)");
	}

	// --------------------------------------------------------------

	/**
	 * Get all collections and cache them
	 *
	 * @access      public
	 * @param       int      Channel ID
	 * @return      array
	 */
	public function get_all()
	{
		static $all;

		// Get all from parent class
		if (is_null($all))
		{
			ee()->db->order_by('collection_label', 'asc');
			$all = parent::get_all();

			foreach ($all AS &$row)
			{
				$row['settings'] = low_search_decode($row['settings'], FALSE);
			}

			$all = low_associate_results($all, 'collection_id');
		}

		return $all;
	}

	// --------------------------------------------------------------

	/**
	 * Get collections based on collection ID
	 *
	 * @access      public
	 * @param       int      Channel ID
	 * @return      array
	 */
	public function get_by_id($collection_id, $in = TRUE)
	{
		return $this->_get_by_attr($collection_id, $this->pk(), $in);
	}

	/**
	 * Get collections based on a channel ID
	 *
	 * @access      public
	 * @param       int      Channel ID
	 * @return      array
	 */
	public function get_by_channel($channel_id, $in = TRUE)
	{
		return $this->_get_by_attr($channel_id, 'channel_id', $in);
	}

	/**
	 * Get collections based on a site ID
	 *
	 * @access      public
	 * @param       int      Site ID
	 * @return      array
	 */
	public function get_by_site($site_id, $in = TRUE)
	{
		return $this->_get_by_attr($site_id, 'site_id', $in);
	}

	/**
	 * Get collection IDs by parameter on a site ID
	 *
	 * @access      public
	 * @param       int      Site ID
	 * @return      array
	 */
	public function get_by_param($param)
	{
		list($ids, $in) = low_explode_param($param);

		$attr = low_array_is_numeric($ids) ? $this->pk() : 'collection_name';

		return $this->_get_by_attr($ids, $attr, $in);
	}

	// --------------------------------------------------------------

	/**
	 * Get channel IDs by parameter
	 */
	public function get_channel_ids($param)
	{
		$channel_ids = array();

		if ($param)
		{
			$cols = $this->get_by_param($param);
			$channel_ids = low_flatten_results($cols, 'channel_id');
			$channel_ids = array_unique($channel_ids);
		}

		return $channel_ids;
	}

	// --------------------------------------------------------------

	/**
	 * Get all rows based on attr and val
	 */
	private function _get_by_attr($val, $attr = 'collection_id', $in = TRUE)
	{
		$all  = $this->get_all();
		$rows = array();

		// Make sure value is in an array
		if ( ! is_array($val)) $val = array($val);

		// Loop through all and add maching to rows
		foreach ($all AS $id => $row)
		{
			if ($in === in_array($row[$attr], $val))
			{
				$rows[$id] = $row;
			}
		}

		return $rows;
	}

} // End class

/* End of file Low_search_collection_model.php */