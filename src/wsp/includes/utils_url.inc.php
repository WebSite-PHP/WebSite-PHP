<?php
/**
 * PHP file wsp\includes\utils_url.inc.php
 */
/**
 * WebSite-PHP file utils_url.inc.php
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2016 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 11/05/2016
 * @version     1.2.14
 * @access      public
 * @since       1.2.14
 */

function getCurrentUrl() {
	if (!defined('FORCE_SERVER_NAME') || FORCE_SERVER_NAME == "") {
		if ($_SERVER['SERVER_PORT'] == 443) {
			$url = "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
		} else {
			$port = "";
			if ($_SERVER['SERVER_PORT'] != 80 &&  $_SERVER['SERVER_PORT'] != "") {
				$port = ":".$_SERVER['SERVER_PORT'];
			}
			$url = "http://".$_SERVER['SERVER_NAME'].$port.$_SERVER['REQUEST_URI'];
		}
	} else {
		$url = "http://".FORCE_SERVER_NAME.$_SERVER['REQUEST_URI'];
	}
	return $url;
}

function getCurrentPathUrlAndType() {
	$port = "";
	$http_type = "";
	$current_url = "";
	$split_request_uri = explode("\?", $_SERVER['REQUEST_URI']);
	if (!defined('FORCE_SERVER_NAME') || FORCE_SERVER_NAME == "") {
		if ($_SERVER['SERVER_PORT'] == 443) {
			$http_type = "https://";
			$current_url = str_replace("//", "/", $_SERVER['SERVER_NAME'].substr($split_request_uri[0], 0, strrpos($split_request_uri[0], "/"))."/");
		} else {
			$port = "";
			if ($_SERVER['SERVER_PORT'] != 80 &&  $_SERVER['SERVER_PORT'] != "") {
				$port = ":".$_SERVER['SERVER_PORT'];
			}
			$http_type = "http://";
			$current_url = str_replace("//", "/", $_SERVER['SERVER_NAME'].$port.substr($split_request_uri[0], 0, strrpos($split_request_uri[0], "/"))."/");
		}
	} else {
		$http_type = "http://";
		$current_url = str_replace("//", "/", FORCE_SERVER_NAME.substr($split_request_uri[0], 0, strrpos($split_request_uri[0], "/"))."/");
	}
	return array($current_url, $http_type, $port);
}

function getMyBaseUrl($current_url='', $http_type='') {
	if ($current_url == "" || $http_type == "") {
		list($current_url, $http_type) = getCurrentUrlAndType();
	}

	// define the base URL of the website
	$my_base_url = "";
	$array_cwd = explode('/',  str_replace('\\', '/', getcwd()));
	$wsp_folder_name = $array_cwd[sizeof($array_cwd)-1];

	// Detect base URL with the root folder of wsp
	$array_current_url = explode('/', $current_url);
	for ($i=sizeof($array_current_url)-2; $i >= 0; $i--) {
		if ($array_current_url[$i] == $wsp_folder_name) {
			$my_base_url = $http_type;
			for ($j=0; $j <= $i; $j++) {
				$my_base_url .= $array_current_url[$j]."/";
			}
			break;
		}
	}
	if ($my_base_url == "") {
		if (!defined('FORCE_SERVER_NAME') || FORCE_SERVER_NAME == "") {
			// If not find root folder then test if there is an alias
			$array_script_name = explode('/', $_SERVER['SCRIPT_NAME']);
			unset($array_script_name[sizeof($array_script_name)-1]);
			$alias_path = implode('/', $array_script_name);
			if ($alias_path != "") { // Alias detected
				$my_base_url = $http_type.$array_current_url[0].$alias_path."/";
			} else { // No Alias detected
				$my_base_url = $http_type.$array_current_url[0]."/";
			}
		} else {
			if (strtoupper(substr(FORCE_SERVER_NAME, 0, 7)) == "HTTP://" || strtoupper(substr(FORCE_SERVER_NAME, 0, 8)) == "HTTPS://") {
				$my_base_url = FORCE_SERVER_NAME."/";
			} else {
				$my_base_url = $http_type.FORCE_SERVER_NAME."/";
			}
		}
	}
	return $my_base_url;
}
?>
