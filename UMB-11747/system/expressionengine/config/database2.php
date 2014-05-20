<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$active_group = 'expressionengine';
$active_record = TRUE;

$db['expressionengine']['hostname'] = 'localhost';
$db['expressionengine']['username'] = 'umbaugh_eecms';
$db['expressionengine']['password'] = 'x09J1lYha3R9';
$db['expressionengine']['database'] = 'umbaugh_webcms';
$db['expressionengine']['dbdriver'] = 'mysql';
$db['expressionengine']['pconnect'] = FALSE;
$db['expressionengine']['dbprefix'] = 'exp_';
$db['expressionengine']['swap_pre'] = 'exp_';
$db['expressionengine']['db_debug'] = TRUE;
$db['expressionengine']['cache_on'] = FALSE;
$db['expressionengine']['autoinit'] = FALSE;
$db['expressionengine']['char_set'] = 'utf8';
$db['expressionengine']['dbcollat'] = 'utf8_general_ci';
//$db['expressionengine']['cachedir'] = 'C:\\www\\Umbaugh\\UMB-11747\\system/expressionengine/cache/db_cache/';
$db['expressionengine']['cachedir'] = '/home/umbaugh/_subdomains/dev/system/expressionengine/cache/db_cache/';
/* End of file database.php */
/* Location: ./system/expressionengine/config/database.php */