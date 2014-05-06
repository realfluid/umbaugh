<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// include config file
include(PATH_THIRD.'low_search/config.php');

/**
 * Low Search Base Class
 *
 * @package        low_search
 * @author         Lodewijk Schutte <hi@gotolow.com>
 * @link           http://gotolow.com/addons/low-search
 * @copyright      Copyright (c) 2014, Low
 */
class Low_search_base {

	// --------------------------------------------------------------------
	// PROPERTIES
	// --------------------------------------------------------------------

	/**
	 * Add-on name
	 *
	 * @var        string
	 * @access     public
	 */
	public $name = LOW_SEARCH_NAME;

	/**
	 * Add-on version
	 *
	 * @var        string
	 * @access     public
	 */
	public $version = LOW_SEARCH_VERSION;

	/**
	 * URL to module docs
	 *
	 * @var        string
	 * @access     public
	 */
	public $docs_url = LOW_SEARCH_DOCS;

	// --------------------------------------------------------------------

	/**
	 * Package name
	 *
	 * @var        string
	 * @access     protected
	 */
	protected $package = LOW_SEARCH_PACKAGE;

	/**
	 * Main class shortcut
	 *
	 * @var        string
	 * @access     protected
	 */
	protected $class_name;

	/**
	 * Site id shortcut
	 *
	 * @var        int
	 * @access     protected
	 */
	protected $site_id;

	/**
	 * Models used
	 *
	 * @var        array
	 * @access     protected
	 */
	protected $models = array(
		'low_search_collection_model',
		'low_search_index_model',
		'low_search_log_model',
		'low_search_replace_log_model',
		'low_search_group_model',
		'low_search_shortcut_model'
	);

	// --------------------------------------------------------------------
	// METHODS
	// --------------------------------------------------------------------

	/**
	 * Constructor
	 *
	 * @access     public
	 * @return     void
	 */
	public function __construct()
	{
		// -------------------------------------
		//  Define the package path
		// -------------------------------------

		ee()->load->add_package_path(PATH_THIRD.$this->package);

		// -------------------------------------
		//  Load helper
		// -------------------------------------

		ee()->load->helper($this->package);

		// -------------------------------------
		//  Libraries
		// -------------------------------------

		ee()->load->library('Low_search_settings');

		// -------------------------------------
		//  Load the models
		// -------------------------------------

		ee()->load->model($this->models);

		// -------------------------------------
		//  Class name shortcut
		// -------------------------------------

		$this->class_name = ucfirst(LOW_SEARCH_PACKAGE);

		// -------------------------------------
		//  Get site shortcut
		// -------------------------------------

		$this->site_id = (int) ee()->config->item('site_id');
	}

	// --------------------------------------------------------------------

	/**
	 * Return an MCP URL
	 *
	 * @access     protected
	 * @param      string
	 * @return     string
	 */
	protected function mcp_url($method = NULL, $extra = NULL)
	{
		$url = function_exists('cp_url')
		     ? cp_url('addons_modules/show_module_cp', array('module' => $this->package))
		     : BASE.AMP.'C=addons_modules&amp;M=show_module_cp&amp;module='.$this->package;

		if ($method) $url .= AMP.'method='.$method;
		if ($extra)  $url .= AMP.$extra;

		return $url;
	}

	// --------------------------------------------------------------------

} // End class Low_search_base