<?php

/**
 * Low Search config file
 *
 * @package        low_search
 * @author         Lodewijk Schutte <hi@gotolow.com>
 * @link           http://gotolow.com/addons/low-search
 * @copyright      Copyright (c) 2014, Low
 */

if ( ! defined('LOW_SEARCH_NAME'))
{
	define('LOW_SEARCH_NAME',       'Low Search');
	define('LOW_SEARCH_PACKAGE',    'low_search');
	define('LOW_SEARCH_VERSION',    '3.1.4');
	define('LOW_SEARCH_DOCS',       'http://gotolow.com/addons/low-search');
	define('LOW_SEARCH_DEBUG',      FALSE);
	define('LOW_SEARCH_MAX_WEIGHT', 3);
}

/**
 * < EE 2.6.0 backward compat
 */
if ( ! function_exists('ee'))
{
	function ee()
	{
		static $EE;
		if ( ! $EE) $EE = get_instance();
		return $EE;
	}
}

/**
 * NSM Addon Updater
 */
$config['name']    = LOW_SEARCH_NAME;
$config['version'] = LOW_SEARCH_VERSION;
$config['nsm_addon_updater']['versions_xml'] = LOW_SEARCH_DOCS.'/feed';
