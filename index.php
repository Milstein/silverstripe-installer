<?php

/************************************************************************************
 ************************************************************************************
 **                                                                                **
 **  If you can read this text in your browser then you don't have PHP installed.  **
 **  Please install PHP 5.0 or higher, preferably PHP 5.2.                         **
 **                                                                                **
 ************************************************************************************
 ************************************************************************************/

/**
 * This script bolts on top of SilverStripe/Sapphire to allow access without the use of .htaccess
 * rewriting rules.
 */

// This is the URL of the script that everything must be viewed with.
define('BASE_SCRIPT_URL','index.php/');

$ruLen = strlen($_SERVER['REQUEST_URI']);
$snLen = strlen($_SERVER['SCRIPT_NAME']);

if($ruLen > $snLen && substr($_SERVER['REQUEST_URI'],0,$snLen+1) == ($_SERVER['SCRIPT_NAME'] . '/')) {
	$url = substr($_SERVER['REQUEST_URI'],$snLen+1);
	$url = strtok($url, '?');
	$_GET['url'] = $_REQUEST['url'] = $url;

	$fileName = dirname($_SERVER['SCRIPT_FILENAME']) . '/' . $url;

	/**
	 * This code is a very simple wrapper for sending files
	 * Very quickly pass through references to files
	 */
	if(file_exists($fileName)) {
		$baseURL = dirname($_SERVER['SCRIPT_NAME']);
		if($baseURL == "\\" || $baseURL == "/") $baseURL = "";
		$fileURL =  "$baseURL/$url";
		header($_SERVER['SERVER_PROTOCOL'] . ' 301 Moved Permanently');
		header("Location: $fileURL");
		die();
	}
}

// For linux
$_SERVER['SCRIPT_FILENAME'] = str_replace('/index.php','/sapphire/main.php', $_SERVER['SCRIPT_FILENAME']);
$_SERVER['SCRIPT_NAME'] = str_replace('/index.php','/sapphire/main.php', $_SERVER['SCRIPT_NAME']);
// And for windows
$_SERVER['SCRIPT_FILENAME'] = str_replace('\\index.php','\\sapphire\\main.php', $_SERVER['SCRIPT_FILENAME']);
$_SERVER['SCRIPT_NAME'] = str_replace('\\index.php','\\sapphire\\main.php', $_SERVER['SCRIPT_NAME']);

chdir('sapphire');
require_once('sapphire/main.php');
