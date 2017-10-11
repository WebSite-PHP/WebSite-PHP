<?php
/**
 * PHP file index-ajax.php
 */
/**
 * Entry point of all AJAX requests
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
 * @since       1.0.0
 */

	error_reporting(E_ALL);
	
	include_once("wsp/config/config.inc.php");
	include_once("wsp/includes/utils_session.inc.php");
	include_once("wsp/includes/utils_url.inc.php");
	$__AJAX_PAGE__ = true; // use for return catch exception and loadAllVariables method
	$__AJAX_LOAD_PAGE__ = false;
	$__PAGE_IS_INIT__ = false;
	$__LOAD_VARIABLES__ = false;
	$__DEBUG_PAGE_IS_PRINTING__ = false;
	$__GEOLOC_ASK_USER_SHARE_POSITION__ = false;
	$__WSP_OBJECT_UPLOADFILE_CHANGED__ = false;

    @session_set_cookie_params(0, "/", $_SERVER['SERVER_NAME'], false, true);
	session_name(formalize_to_variable(SITE_NAME)); 
	@session_start();
	
	if (!defined('MAX_SESSION_TIME')) {
		define("MAX_SESSION_TIME", 1800); // 30 min.
	}
	if (isset($_SESSION['WSP_LAST_ACTIVITY']) && (time() - $_SESSION['WSP_LAST_ACTIVITY'] > MAX_SESSION_TIME)) {
	    session_unset(); 
	    session_destroy();
	}
	$_SESSION['WSP_LAST_ACTIVITY'] = time();
	ini_set("session.gc_maxlifetime", MAX_SESSION_TIME);
	
	/*$zlib_OC_is_set = preg_match('/On|(^[0-9]+$)/i', ini_get('zlib.output_compression'));
	if ($zlib_OC_is_set) {
		if (@strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') !== FALSE) {
			header("Content-Encoding: gzip"); 
		}
	}*/
	
	include_once("wsp/includes/execution_time.php");
	$_SESSION['wspPageStartTime'] = slog_time();
	
	if (!isset($_GET['p'])) {
		$_GET['p'] = "home"; 
	}
	$_SESSION['calling_page'] = $_GET['p'];
	
	header("Expires: Sat, 05 Nov 2005 00:00:00 GMT");
	header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	
	if (!file_exists("pages/".$_GET['p'].".php")) {
		header('HTTP/1.1 404 Could not find page '.$_GET['p']);
		echo 'Could not find page '.$_GET['p'];
		exit;
	}
	
	include("wsp/includes/init.inc.php");
	include("wsp/includes/utils_ajax.inc.php");
	
	// Create current page object
	$page_object = Page::getInstance($_GET['p']);
	if (!$page_object->userHaveRights()) {
		header('HTTP/1.1 500 Internal Server Error');
		echo 'You have no rights on the page '.$_GET['p'];
		exit;
	}
	
	$page_object->InitializeComponent();
	$page_object->Load();
	
	// If page is not caching -> generate HTML
	if (!$page_object->getPageIsCaching()) {
		// set GET and POST data to the current page
		$page_object->loadAllVariables();
		$__PAGE_IS_INIT__ = true;
		
		// execute callback method
		$page_object->executeCallback();
		
		// call the loaded method
		$page_object->Loaded();
				
		// Get CDN server URL (or base URL if not exists)
		$cdn_server_url = $page_object->getCDNServerURL();
		
		// create current page ajax return
		$__PAGE_IS_INIT__ = false; // desactivate change log
		$array_ajax_object_render = array();
		
		$combine_js = "";
		$array_js = JavaScriptInclude::getInstance()->get(true);
		foreach ($array_js as $i => $script) {
			if (JavaScriptInclude::getInstance()->getCombine($i)) {
				if ($combine_js != "") { $combine_js .= ","; }
				$combine_js .= str_replace(BASE_URL."wsp/js/", "", str_replace(BASE_URL."js/", "", $script));
			} else {
				$array_ajax_object_render[] = "loadDynamicJS('".str_replace(BASE_URL, $cdn_server_url, $script)."', -1);";
			}
		}
		if ($combine_js != "") {
			$array_ajax_object_render[] = "loadDynamicJS('".$cdn_server_url."combine-js/".str_replace("/", "|", $combine_js)."', -1);";
		}
		
		$save_scroll_position = "var wsp_save_hscroll = f_scrollLeft();";
		$save_scroll_position .= "var wsp_save_vscroll = f_scrollTop();";
		$array_ajax_object_render[] = $save_scroll_position;
		
		if ($__GEOLOC_ASK_USER_SHARE_POSITION__ == true && !$page_object->isCrawlerBot()) {
			$array_ajax_object_render[] = "launchGeoLocalisation(true);";
		} else {
			$array_ajax_object_render[] = "launchGeoLocalisation(false);";
		}

		$add_to_render = $page_object->getBeginAddedObjects();
		for ($i=0; $i < sizeof($add_to_render); $i++) {
			if (gettype($add_to_render[$i]) == "object") {
				$ajax_render = str_replace("{#BASE_URL#}", BASE_URL, str_replace("{#CDN_BASE_URL#}", $page_object->getCDNServerURL(), str_replace("{#QUOTE#}", "\"", str_replace("{#SIMPLE_QUOTE#}", "'", $add_to_render[$i]->getAjaxRender()))));
				if ($ajax_render != "") {
					$array_ajax_object_render[] = $ajax_render;
				}
			}
		}
		
		$register_objects = WebSitePhpObject::getRegisterObjects();
		for ($i=0; $i < sizeof($register_objects); $i++) {
			$object = $register_objects[$i];
			if ($object->isObjectChange() && get_class($object) != "DialogBox" && !is_subclass_of($object, "DialogBox") && get_class($object) != "JavaScript") {
				$ajax_render = str_replace("{#BASE_URL#}", BASE_URL, str_replace("{#CDN_BASE_URL#}", $page_object->getCDNServerURL(), str_replace("{#QUOTE#}", "\"", str_replace("{#SIMPLE_QUOTE#}", "'", $object->getAjaxRender()))));
				if ($ajax_render != "") {
					$array_ajax_object_render[] = $ajax_render;
				}
			}
			$register_objects = WebSitePhpObject::getRegisterObjects();
		}
		
		$add_to_render = $page_object->getEndAddedObjects();
		for ($i=0; $i < sizeof($add_to_render); $i++) {
			if (gettype($add_to_render[$i]) == "object") {
				$ajax_render = str_replace("{#BASE_URL#}", BASE_URL, str_replace("{#CDN_BASE_URL#}", $page_object->getCDNServerURL(), str_replace("{#QUOTE#}", "\"", str_replace("{#SIMPLE_QUOTE#}", "'", $add_to_render[$i]->getAjaxRender()))));
				if ($ajax_render != "") {
					$array_ajax_object_render[] = $ajax_render;
				}
			}
			if ($page_object->getNbEndAddedObjects() > $nb_end_added_object) {
				$add_to_render = $page_object->getEndAddedObjects();
				$nb_end_added_object = $page_object->getNbEndAddedObjects();
			}
		}
		
		$combine_css = "";
		$array_css = CssInclude::getInstance()->get(true);
		foreach ($array_css as $i => $css) {
			if (CssInclude::getInstance()->getCombine($i)) {
				if ($combine_css != "") { $combine_css .= ","; }
				$combine_css .= str_replace(".css.php", ".php.css", str_replace(BASE_URL."wsp/css/", "", str_replace(BASE_URL."css/", "", $css)));
			} else {
				if (find($css, ".css.php") > 0 && CssInclude::getInstance()->getCssConfigFile() != "") {
					$css .= "?conf_file=".CssInclude::getInstance()->getCssConfigFile();
				}
				$array_ajax_object_render[] = "loadDynamicCSS('".str_replace(BASE_URL, $cdn_server_url, $css)."');";
			}
		}
		if ($combine_css != "") {
			if (find($combine_css, ".php.css") > 0 && CssInclude::getInstance()->getCssConfigFile() != "") {
				$combine_css .= "?conf_file=".CssInclude::getInstance()->getCssConfigFile();
			}
			$array_ajax_object_render[] = "loadDynamicCSS('".$cdn_server_url."combine-css/".str_replace("/", "|", $combine_css)."');";
		}
		
		if (DEBUG) {
			$log_debug_str = $page_object->getLogDebug();
			$html_debug = "";
			for ($i=0; $i < sizeof($log_debug_str); $i++) {
				$html_debug .= $log_debug_str[$i]."<br/>\n";
			}
			if ($html_debug != "") {
				$debug_dialogbox = new DialogBox("DEBUG Page ".$page_object->getPage().".php", $html_debug);
				$debug_dialogbox->setAlign(DialogBox::ALIGN_LEFT)->setWidth(700);
				$debug_dialogbox = new JavaScript($debug_dialogbox, true);
				$array_ajax_object_render[] = str_replace("{#BASE_URL#}", BASE_URL, str_replace("{#CDN_BASE_URL#}", $page_object->getCDNServerURL(), str_replace("{#QUOTE#}", "\"", str_replace("{#SIMPLE_QUOTE#}", "'", $debug_dialogbox->getAjaxRender()))));
			}
		}
		
		$goback_scroll_position = "window.scrollTo(wsp_save_hscroll, wsp_save_vscroll);";
		$array_ajax_object_render[] = $goback_scroll_position;
		
		// Encode to JSON + detect JSON encode error
		$json_error = false;
		$json_ajax_render = json_encode($array_ajax_object_render);
		if (version_compare(PHP_VERSION, '5.3.0', '>=') ) { 
			switch (json_last_error()) {
		        case JSON_ERROR_NONE:
		            // No errors
		        break;
		        case JSON_ERROR_DEPTH:
		            $json_error = 'Maximum stack depth exceeded';
		        break;
		        case JSON_ERROR_STATE_MISMATCH:
		            $json_error = 'Underflow or the modes mismatch';
		        break;
		        case JSON_ERROR_CTRL_CHAR:
		            $json_error = 'Unexpected control character found';
		        break;
		        case JSON_ERROR_SYNTAX:
		            $json_error = 'Syntax error, malformed JSON';
		        break;
		        case JSON_ERROR_UTF8:
		            $json_error = 'Malformed UTF-8 characters, possibly incorrectly encoded';
		        break;
		        default:
		            $json_error = 'Unknown error';
		        break;
		    }
		}
	    if ($json_error !== false) {
	    	$detected_json_error = array_diff($array_ajax_object_render, json_decode($json_ajax_render));
	    	$detected_json_error_ok = array();
	    	for ($i=0; $i < sizeof($detected_json_error); $i++) {
	    		$converted_html = trim(preg_replace("/[^A-Za-z0-9<>&'\" ()\[\]\/=:;_-}{]/", "", $detected_json_error[$i]));
	    		if ($converted_html != "") {
	    			$detected_json_error_ok[] = $converted_html;
	    		}
	    	}
	    	$json_error_msg = new Object($json_error);
	    	if (sizeof($detected_json_error_ok) > 0) {
	    		$json_error_msg->add("<br/><br/><div align='left'>DEBUG: ", echo_r($detected_json_error_ok), "</div>");
	    	}
	    	
	    	$page_object->disableCache();
	    	
	    	header('HTTP/1.1 500 Internal Server Error');
			echo $json_error_msg->render();
			exit;
	    }
	    
	    // Convert special caracters
	    $json_ajax_render = str_replace("\n\n", "\n", str_replace("\r", "", str_replace("{#wsp_tab}", "\\t", str_replace("\t", "", $json_ajax_render))));
	    
	    // convert caracters '<' and '>' if there is a UploadFile event
    	if ($__WSP_OBJECT_UPLOADFILE_CHANGED__) {
    		$json_ajax_render = str_replace("<", "{#wsp_lt}", str_replace(">", "{#wsp_gt}", $json_ajax_render));
    	}
	    
	    // Write Ajax result (JSON encoding)
		echo $json_ajax_render;
	// End If page is not caching
	} else {
		// call current page page cache
		echo $page_object->render();
	}
	
	// Disconnect DataBase
	if (DB_ACTIVE) {
		DataBase::getInstance(false)->disconnect();
	}
	unset($_SESSION['websitephp_register_object']);
?>
