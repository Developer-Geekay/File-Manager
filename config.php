<?php 
session_start();
date_default_timezone_set('Asia/Kolkata');

// App
define('VERSION', '2.3.6');
define('APP_TITLE', 'Dignet File Manager');

// Database
define('DB_USER','root');
define('DB_SCHEMA','filemgr');
define('DB_PASSWORD','');
define('DB_SERVER','localhost');
define('DB_PORT','3306');

// Common
defined('MAX_UPLOAD_SIZE') OR define('MAX_UPLOAD_SIZE', '2048');
defined('DATETIME_FORMAT') OR define('DATETIME_FORMAT', 'd/m/Y h:i A');
defined('ROOT_PATH') OR define('ROOT_PATH',$_SERVER['DOCUMENT_ROOT']);
defined('HOST') OR define('HOST',$_SERVER['HTTP_HOST']);
defined('ROOT_URL') OR define('ROOT_URL','http://' . HOST);
defined('SELF_URL') OR define('SELF_URL', 'http://' . HOST . $_SERVER['PHP_SELF']);
defined('DIRECTORY_SEPARATOR') OR define ('DIRECTORY_SEPARATOR', "/");
defined('SHOW_HIDDEN') OR define('SHOW_HIDDEN', true);
defined('FM_READONLY') OR define('FM_READONLY', false);
// defined('SHOW_HIDDEN') OR define('SHOW_HIDDEN', true);

$GLOBALS['exclude_items'] = array();

require_once('db.class.php');
require_once('functions.php');

$root_path = rtrim(getRootPath(),'\\/');
$root_path = str_replace('\\', '/', $root_path);
