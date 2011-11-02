<?php
/**
 * PHP file wsp\includes\init.inc.php
 */
/**
 * WebSite-PHP file init.inc.php
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2011 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 26/05/2011
 * @version     1.0.97
 * @access      public
 * @since       1.0.0
 */

	if (version_compare(PHP_VERSION, '5.2.0', '<') ) { 
		// Use of DateTime classes
		echo "Sorry, the FrameWork <a href='http://www.website-php.com' target='_blank'>WebSite-PHP</a> will only run on PHP version 5.2 or greater!<br/>Update your PHP version <a href='http://php.net/downloads.php' target='_blank'>http://php.net/downloads.php</a>\n";
		exit;
	}
	
	if (strtolower(substr($_SERVER['SERVER_SOFTWARE'], 0, 6)) == "apache") {
		if(!in_array("mod_rewrite", apache_get_modules())) {
			echo "Please change your Apache configuration to be compatible with <a href='http://www.website-php.com' target='_blank'>WebSite-PHP</a>:<br/>- You must activate the apache module mod_rewrite!<br/><a href='http://httpd.apache.org/docs/current/en/mod/mod_rewrite.html' target='_blank'>http://httpd.apache.org/docs/current/en/mod/mod_rewrite.html</a>\n";
			exit;
		}
	}
	
	if (!defined("DEFAULT_TIMEZONE") || DEFAULT_TIMEZONE == "") {
		define("DEFAULT_TIMEZONE", "Europe/Paris");
	}
	date_default_timezone_set(DEFAULT_TIMEZONE);
	$split_request_uri = explode("\?", $_SERVER['REQUEST_URI']);
	if (!defined('FORCE_SERVER_NAME') || FORCE_SERVER_NAME == "") {
		if ($_SERVER['SERVER_PORT'] == 443) {
			define("SITE_URL", "https://".str_replace("//", "/", $_SERVER['SERVER_NAME'].substr($split_request_uri[0], 0, strrpos($split_request_uri[0], "/"))."/"));
		} else {
			$port = "";
			if ($_SERVER['SERVER_PORT'] != 80 &&  $_SERVER['SERVER_PORT'] != "") {
				$port = ":".$_SERVER['SERVER_PORT'];
			}
			define("SITE_URL", "http://".str_replace("//", "/", $_SERVER['SERVER_NAME'].$port.substr($split_request_uri[0], 0, strrpos($split_request_uri[0], "/"))."/"));
		}
	} else {
		define("SITE_URL", "http://".str_replace("//", "/", FORCE_SERVER_NAME.substr($split_request_uri[0], 0, strrpos($split_request_uri[0], "/"))."/"));
	}
	
	$_SESSION['websitephp_register_object'] = null;
	
	// Load URL Variables
	$my_language_url = "";
	$my_subfolder_url = "";
	$my_site_base_url = SITE_URL;
	if (isset($_GET['folder_level']) && $_GET['folder_level'] > 0) { // when URL rewriting with folders
		if ($my_site_base_url[strlen($my_site_base_url) - 1] == "/") {
			$my_site_base_url = substr($my_site_base_url, 0, strlen($my_site_base_url) - 1);
		}
		for ($i=0; $i < $_GET['folder_level']; $i++) {
			$pos = strrpos($my_site_base_url, "/");
			if ($pos != false && $my_site_base_url[$pos-1] != "/") {
				$my_subfolder_url .= substr($my_site_base_url, $pos, strlen($my_site_base_url));
				$my_site_base_url = substr($my_site_base_url, 0, $pos);
			} else {
				break;
			}
		}
		$my_site_base_url .= "/";
	}
	if ($my_site_base_url[strlen($my_site_base_url) - 4] == "/") {
		$my_language_url = substr($my_site_base_url, strlen($my_site_base_url) - 3, 2);
		$my_site_base_url = substr($my_site_base_url, 0, strlen($my_site_base_url) - 3);
	}
	if ($my_language_url == "" && isset($_GET['l']) && $_GET['l'] != "") {
		$my_language_url = $_GET['l'];
	}
	define("BASE_URL", $my_site_base_url);
	define("LANGUAGE_URL", $my_language_url);
	define("SUBFOLDER_URL", $my_subfolder_url);
	
	$array_server_name = explode('.', $_SERVER['SERVER_NAME']);
	if (sizeof($array_server_name) > 1) {
		if ($array_server_name[0] != "www" && $array_server_name[0] != "127") {
			define("SUBDOMAIN_URL", $array_server_name[0]);
		} else {
			define("SUBDOMAIN_URL", "");
		}
	} else {
		define("SUBDOMAIN_URL", "");
	}
	
	$ind = 0;
	$params_url = "";
	if ($_GET['p'] != "" && strtoupper($_GET['p']) != "HOME") {
		if (isset($_GET['mime'])) {
			$params_url = $_GET['p'].".".$_GET['mime']; // mime type
		} else {
			$params_url = $_GET['p'].".html";
		}
	}
	foreach ($_GET as $key => $value) {
		if ($key != "l") {
			if ($key != "p" && $key != "mime" && $key != "folder_level") {
				if ($ind == 0) {
					$params_url .= "?";
				} else {
					$params_url .= "&";
				}
				$params_url .= $key."=".urlencode($value);
				$ind++;
			}
		}
	}
	define("PARAMS_URL", $params_url);
	define("SITE_DIRECTORY", dirname($_SERVER['SCRIPT_FILENAME']));
	
	include_once("wsp/config/config_db.inc.php"); 
	include_once("wsp/config/config_smtp.inc.php"); 
	include_once("wsp/includes/utils.inc.php");

	// Redirect wrong URL
	if (strtoupper($_GET['p']) != "HOME") {
		if (find($_SERVER['REQUEST_URI'], ".html", 1, 0) == 0 && !isset($_GET['mime'])) {
			header('HTTP/1.1 301 Moved Temporarily');  
			header('Status: 301 Moved Temporarily');  
			if (isset($_SESSION['lang']) || isset($_GET['l'])) {
				if (isset($_SESSION['lang'])) {
					header("Location:".BASE_URL.$_SESSION['lang']."/".PARAMS_URL);
				} else {
					header("Location:".BASE_URL.$_GET['l']."/".PARAMS_URL);
				}
			} else {
				header("Location:".BASE_URL.PARAMS_URL);
			}
			exit;
		}
	}
	
	include_once("wsp/includes/utils_image.inc.php"); 
	include_once("wsp/includes/utils_openssl.inc.php");
	include_once("wsp/includes/loader_lang.inc.php");

	global $months;
	$months = array(translate(__JANUARY__), translate(__FEBRUARY__), translate(__MARCH__), 
									translate(__APRIL__), translate(__MAY__), translate(__JUNE__), 
									translate(__JULY__), translate(__AUGUST__), translate(__SEPTEMBER__), 
									translate(__OCTOBER__), translate(__NOVEMBER__), translate(__DECEMBER__));
	
	global $days_week;
	$days_week = array(translate(__MONDAY__), translate(__TUESDAY__), translate(__WEDNESDAY__), translate(__THURSDAY__), 
									translate(__FRIDAY__), translate(__SATURDAY__), translate(__SUNDAY__));
	
	
	register_shutdown_function("register_shutdown_handler");
	set_error_handler("error_handler");
	require_once(dirname(__FILE__)."/../class/NewException.class.php");
	set_exception_handler(array("NewException", "printStaticException"));
									
	include_once("wsp/includes/loader_class.inc.php");
	 
	include_once("wsp/includes/html2text.inc.php"); 
	include_once("wsp/includes/securimage/securimage.php");
?>
