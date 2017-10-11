<?php
/**
 * PHP file wsp\includes\init.inc.php
 */
/**
 * WebSite-PHP file init.inc.php
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2017 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 11/10/2017
 * @version     1.2.15
 * @access      public
 * @since       1.1.0
 */

	
	if (version_compare(PHP_VERSION, '5.2.0', '<') ) {
		// Use of DateTime classes
		echo "Sorry, the FrameWork <a href='http://www.website-php.com' target='_blank'>WebSite-PHP</a> will only run on PHP version 5.2 or greater!<br/>Update your PHP version <a href='http://php.net/downloads.php' target='_blank'>http://php.net/downloads.php</a>\n";
		exit;
	}
	
	if (strtolower(substr($_SERVER['SERVER_SOFTWARE'], 0, 6)) == "apache") {
		$mod_rewrite = false;
		if (function_exists('apache_get_modules')) {
			$mod_rewrite = in_array("mod_rewrite", apache_get_modules());
		} else {
			ob_start();
			phpinfo(INFO_MODULES);
			$contents = ob_get_contents();
			ob_end_clean();
			$mod_rewrite = (strpos($contents, 'mod_rewrite') !== false);
		}
		if (!$mod_rewrite) {
			echo "Please change your Apache configuration to be compatible with <a href='http://www.website-php.com' target='_blank'>WebSite-PHP</a>:<br/>- You must activate the apache module mod_rewrite!<br/>(Uncomment in Apache httpd.conf file the line with LoadModule rewrite_module modules/mod_rewrite.so)<br/><a href='http://httpd.apache.org/docs/current/en/mod/mod_rewrite.html' target='_blank'>http://httpd.apache.org/docs/current/en/mod/mod_rewrite.html</a>\n";
			exit;
		}
	}
	
	if (!defined("DEFAULT_TIMEZONE") || DEFAULT_TIMEZONE == "") {
		define("DEFAULT_TIMEZONE", "Europe/Paris");
	}
	date_default_timezone_set(DEFAULT_TIMEZONE);
	define("SERVER_TIMEZONE_OFFSET_SECONDES", date("Z"));
	
	list($current_url, $http_type, $port) = getCurrentPathUrlAndType();
	define("SITE_URL", $http_type.$current_url);
	$_SESSION['websitephp_register_object'] = null;
	
	$my_base_url = getMyBaseUrl($current_url, $http_type);
	$my_subfolder_url = str_replace($my_base_url, "", $http_type.$current_url);
	define("BASE_URL", $my_base_url);
	define("LANGUAGE_URL", substr($my_subfolder_url, 0, 2));
	define("SUBFOLDER_URL", $my_subfolder_url);
	
	if (file_exists('install.htaccess')) {
		$tmp_lang = SITE_DEFAULT_LANG;
		$lang_folder = dirname(__FILE__)."/../../lang/";
		if (!is_dir($lang_folder.$tmp_lang)) {
			$tmp_lang = "";
			$array_lang_dir = scandir($lang_folder);
			for ($i=0; $i < sizeof($array_lang_dir); $i++) {
				if (is_dir($lang_folder.$array_lang_dir[$i]) && $array_lang_dir[$i] != "" &&
						$array_lang_dir[$i] != "." && $array_lang_dir[$i] != ".." && $array_lang_dir[$i] != ".svn" &&
						strlen($array_lang_dir[$i]) == 2) {
					$tmp_lang = $array_lang_dir[$i];
					break;
				}
			}
		}
		if (strlen($tmp_lang) != 2) {
			echo "No language defined in WSP lang folder (".realpath($lang_folder).")\n";
			exit;
		}
		if (!rename('install.htaccess', '.htaccess')) {
			echo "The apache user has no right to rename the file install.htaccess to .htaccess. Please give the rights on this file to finalize the installation.\n";
			exit;
		} else {
			require_once(dirname(__FILE__)."/../class/utils/HTTP.class.php");
			$http = new Http();
			$http->execute(BASE_URL.$tmp_lang."/");
			$http_error = $http->getError();
			$http_result = $http->getResult();
			if ($http->getStatus() >= 400) {
				rename('.htaccess', 'install.htaccess');
				echo "Please change your configuration to be compatible with <a href='http://www.website-php.com' target='_blank'>WebSite-PHP</a>:<br/>- Webserver needs to support \"<b>AllowOverride <font color='red'>All</font></b>\" for your website directory!<br/>&lt;Directory /your_directory&gt;<br/>&nbsp;&nbsp;&nbsp;AllowOverride all<br/>&lt;/Directory&gt;<br/>Edit the configuration file httpd.conf of your apache server. In this file you need to find the tag \"Directory\" concerning website folder (i.e.: www) and set the property AllowOverride with the parameter \"All\" as explained before.<br/><a href='http://httpd.apache.org/docs/current/mod/core.html#allowoverride' target='_blank'>http://httpd.apache.org/docs/current/mod/core.html#allowoverride</a><br/><br/>\n";
				echo "<b>If you want to use <font color='red'>Alias</font></b> with WebSite-PHP you need to uncomment and configure the line with \"RewriteBase /myAliasName/\" in the file install.htaccess of the framework.<br/><br/>\n";
                echo "If all the previous elements are already configured, then your apache server is configure correctly. But may be, do you have an <b>PHP error</b> (ie: memory_limit).<br/>Please, open your php_error.log file and check if there are no error at the time of your last page refresh. And if you find an erreur, correct it; probably in the configuration file php.ini.<br/>";
                exit;
			}
		}
	}
	
	if (!defined('FORCE_SERVER_NAME') || FORCE_SERVER_NAME == "") {
		$array_server_name = explode('.', $_SERVER['SERVER_NAME']);
	} else {
		$array_server_name = explode('.', FORCE_SERVER_NAME);
	}
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
	define("SITE_DIRECTORY", str_replace("\\", "/", realpath(dirname(__FILE__)."/../..")));
	
	include_once("wsp/config/config_db.inc.php");
	include_once("wsp/config/config_smtp.inc.php");
	include_once("wsp/includes/utils.inc.php");
	
	// Redirect wrong URL
	if (strtoupper($_GET['p']) != "HOME") {
		if (find($_SERVER['REQUEST_URI'], ".html", 1, 0) == 0 && !isset($_GET['mime']) &&
				(!isset($_GET['error-redirect-url']) && !isset($_GET['error-redirect']))) {
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
				exit;
			}
		}
	}
	
	include_once("wsp/includes/utils_image.inc.php");
	include_once("wsp/includes/utils_openssl.inc.php");
	include_once("wsp/includes/utils_logger.inc.php");
	include_once("wsp/includes/loader_lang.inc.php");
	
	global $months;
	$months = array(__(__JANUARY__), __(__FEBRUARY__), __(__MARCH__),
			__(__APRIL__), __(__MAY__), __(__JUNE__),
			__(__JULY__), __(__AUGUST__), __(__SEPTEMBER__),
			__(__OCTOBER__), __(__NOVEMBER__), __(__DECEMBER__));
	
	global $days_week;
	$days_week = array(__(__MONDAY__), __(__TUESDAY__), __(__WEDNESDAY__), __(__THURSDAY__),
			__(__FRIDAY__), __(__SATURDAY__), __(__SUNDAY__));
	
	
	register_shutdown_function("register_shutdown_handler");
	set_error_handler("error_handler");
	require_once(dirname(__FILE__)."/../class/NewException.class.php");
	set_exception_handler(array("NewException", "printStaticException"));
	
	include_once("wsp/includes/html2text.inc.php");
	
	include_once("wsp/includes/loader_class.inc.php");
	include_once("wsp/includes/wsp_user_ban.inc.php");
	
	include_once("wsp/includes/securimage/securimage.php");
?>
