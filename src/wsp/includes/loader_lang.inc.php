<?php
/**
 * PHP file wsp\includes\loader_lang.inc.php
 */
/**
 * WebSite-PHP file loader_lang.inc.php
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2015 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 12/05/2015
 * @version     1.2.13
 * @access      public
 * @since       1.0.0
 */

	// default language parameters files
	$list_lang_param_files = array();
	$list_lang_param_files[] = "all";
	$list_lang_param_files[] = "default";
	$list_lang_param_files[] = "calendar";

	$last_lang = SITE_DEFAULT_LANG;
	if ($last_lang == "SITE_DEFAULT_LANG") {
		$last_lang = "en";
	}
	$redirect_to_default_lang = false;
	if (isset($_SESSION['lang']) && $_SESSION['lang'] != "") {
		$last_lang = $_SESSION['lang'];
	} else {
		$redirect_to_default_lang = true;
	}
	
	if (isset($_GET['l']) && $_GET['l'] != "") {
		$_SESSION['lang'] = $_GET['l'];
		$redirect_to_default_lang = false;
	}
	if (!isset($_SESSION['lang'])) {
		$default_language_exist = false;
		$detected_language = array();
		if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
			$detected_language = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
		}
		if (isset($detected_language[0]) && $detected_language[0] != "") {
			$detected_language = strtolower(substr(chop($detected_language[0]),0,2));
			$array_lang_dir = scandir("lang");
			for ($i=0; $i < sizeof($array_lang_dir); $i++) {
				if ($array_lang_dir[$i] != "." && $array_lang_dir[$i] != ".." && is_dir("lang/".$array_lang_dir[$i])) {
					$_SESSION['lang'] = $array_lang_dir[$i];
					if ($_SESSION['lang'] == $detected_language) {
						$default_language_exist = false;
						break;
					}
					if ($_SESSION['lang'] == SITE_DEFAULT_LANG) {
						$default_language_exist = true;
					}
				}
			}
		}
		if (!isset($_SESSION['lang']) || $default_language_exist) {
			$_SESSION['lang'] = SITE_DEFAULT_LANG;
		}
	}
	
	for ($i=0; $i < sizeof($list_lang_param_files); $i++) {
		if (file_exists("lang/".$_SESSION['lang']."/".$list_lang_param_files[$i].".inc.php")) {
			require("lang/".$_SESSION['lang']."/".$list_lang_param_files[$i].".inc.php");
		} else if ($list_lang_param_files[$i] != "all") {
			if (file_exists("lang/".$last_lang."/".$list_lang_param_files[$i].".inc.php")) {
				require("lang/".$last_lang."/".$list_lang_param_files[$i].".inc.php");
			}
			$_GET['p'] = "error-lang";
		}
	}
	if ($_GET['p'] == "error-lang") {
		$_SESSION['lang'] = $last_lang;
	}
	
	// check if it's an URL with language info
	if (LANGUAGE_URL != $_SESSION['lang'] || LANGUAGE_URL == "") {
		$redirect_to_default_lang = true;
	}
	
	if ($redirect_to_default_lang && (!isset($_GET['error-redirect-url']) && !isset($_GET['error-redirect']))) {
		header('HTTP/1.1 301 Moved Temporarily');  
		header('Status: 301 Moved Temporarily');  
		header("Location:".BASE_URL.$_SESSION['lang']."/".PARAMS_URL);
		//echo "DEBUG : redirect to ".BASE_URL.$_SESSION['lang']."/".PARAMS_URL."<br>";
		exit;
	}
	
	// load page translations
	if (file_exists("lang/".$_SESSION['lang']."/".$_GET['p'].".inc.php")) {
		require("lang/".$_SESSION['lang']."/".$_GET['p'].".inc.php");
	}
	
	// load modules translations
	if (is_dir("lang/".$_SESSION['lang']."/modules") && file_exists(dirname(__FILE__)."/../config/modules.cnf")) {
		$list_modules = file_get_contents(dirname(__FILE__)."/../config/modules.cnf");
		$array_modules = explode("\n", $list_modules);
		for ($i=0; $i < sizeof($array_modules); $i++) {
			if (file_exists("lang/".$_SESSION['lang']."/modules/".trim($array_modules[$i]).".inc.php")) {
				require("lang/".$_SESSION['lang']."/modules/".trim($array_modules[$i]).".inc.php");
			}
		}
	}
?>
