<?php

if (! defined('FA_NAME'))
{
	define('FA_NAME', 'Freeform Anti-Spam');
	define('FA_ID', 'freeform_antispam');
	define('FA_VERSION',  '1.3.0');
	define('FA_DESC', 'Protect Freeform forms from spam submissions.');
	define('FA_DOCS', 'http://www.vayadesign.net/software/freeform-antispam');
}

$config['name']    = FA_NAME;
$config['version'] = FA_VERSION;
$config['nsm_addon_updater']['versions_xml']='http://www.vayadesign.net/rss/freeform-antispam';