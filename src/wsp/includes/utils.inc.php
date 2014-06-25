<?php
/**
 * PHP file wsp\includes\utils.inc.php
 */
/**
 * WebSite-PHP file utils.inc.php
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2014 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 17/01/2014
 * @version     1.2.9
 * @access      public
 * @since       1.0.19
 */

	
	function is_browser_ie() {
		$pos = find($_SERVER['HTTP_USER_AGENT'], 'MSIE', 1, 0);
		if ($pos > 0) {
			return true;
		}
		return false;
	}
	
	function is_browser_ie_6() {
		$is_ie = false;
		$pos = find($_SERVER['HTTP_USER_AGENT'], 'MSIE', 1, 0);
		if ($pos > 0) {
			$pos2 = find($_SERVER['HTTP_USER_AGENT'], ';', 1, $pos);
			if ($pos2 > 0) {
				$ie_version = trim(substr($_SERVER['HTTP_USER_AGENT'], $pos, $pos2-$pos-1));
				if ($ie_version < 7) {
					return true;
				}
			}
		}
		return false;
	}
	
	function get_browser_ie_version() {
		$is_ie = false;
		$pos = find($_SERVER['HTTP_USER_AGENT'], 'MSIE', 1, 0);
		if ($pos > 0) {
			$pos2 = find($_SERVER['HTTP_USER_AGENT'], ';', 1, $pos);
			if ($pos2 > 0) {
				return trim(substr($_SERVER['HTTP_USER_AGENT'], $pos, $pos2-$pos-1));
			}
		}
		return false;
	}
    
    function getRemoteIp() {
    	if (isset($_SERVER["HTTP_X_FORWARDED_FOR"]) && $_SERVER["HTTP_X_FORWARDED_FOR"] != "") {
    		return $_SERVER["HTTP_X_FORWARDED_FOR"];
    	} else {
    		return $_SERVER["REMOTE_ADDR"];
    	}
    }
	
	function error_handler($code, $message, $file, $line) {
		if (0 == error_reporting() || $code == 0) {
	        return;
	    }
	    require_once(dirname(__FILE__)."/../class/NewException.class.php");
	    NewException::redirectOnError("");
	}
	
	function register_shutdown_handler() {
		require_once(dirname(__FILE__)."/../class/NewException.class.php");
	    NewException::redirectOnError("");
	}
	
	function extractJavaScriptFromHtml($html) {
		$javascript = "";
		$pos = find($html, "<script type=", 0, 0);
		while ($pos > 0) {
			$pos2 = find($html, ">", 0, $pos);
			$pos3 = find($html, "</script>", 0, $pos2);
			if ($pos3 == 0) {
				break;
			}
			$pos4 = $pos3 - 9;
			
			$html_before = substr($html, 0, $pos-13)."\n";
			$html_after = substr($html, $pos3, strlen($html));
			$javascript .= substr($html, $pos2, $pos4-$pos2)."\n";
			
			$html = $html_before.$html_after;
			$pos = find($html, "<script type=", 0, 0);
		}
		$javascript = str_replace("//<![CDATA[", "", $javascript);
		$javascript = str_replace("//]]>", "", $javascript);
		$javascript = str_replace("\r", "", $javascript);
		$javascript = str_replace("\n\n", "\n", $javascript);
		
		return array($html, $javascript);
	}
	
	function createHrefLink($str_or_object_link, $target='', $onclick='') {
		$html = "";
		if ($str_or_object_link != "") {
			if (gettype($str_or_object_link) != "object" && strtoupper(substr($str_or_object_link, 0, 11)) != "JAVASCRIPT:" && strtoupper(substr($str_or_object_link, 0, 1)) != "#") {
				$tmp_link = new Link($str_or_object_link, $target);
				if (!$tmp_link->getUserHaveRights()) {
					return "";
				}
				$html .= $tmp_link->getLink();
				if ($tmp_link->getTarget() != "") {
					$html .= "\" target=\"".$tmp_link->getTarget();
				}
				if ($onclick != "") {
					$html .= "\" onClick=\"".$onclick;
				}
			} else if (gettype($str_or_object_link) != "object" && strtoupper(substr($str_or_object_link, 0, 11)) == "JAVASCRIPT:") {
				$html .= "javascript:void(0);\" onClick=\"".str_replace("javascript:", "", str_replace("javascript:void(0);", "", $str_or_object_link)).$onclick;
			} else if (gettype($str_or_object_link) != "object" && strtoupper(substr($str_or_object_link, 0, 1)) == "#") {
				$cur_page = Page::getInstance($_GET['p']);
				$html .= $cur_page->getCurrentURL().$str_or_object_link;
				if ($onclick != "") {
					$html .= "\" onClick=\"".$onclick;
				}
			} else {
				if (get_class($str_or_object_link) == "Link") {
					if (!$str_or_object_link->getUserHaveRights()) {
						return "";
					}
					$html .= $str_or_object_link->getLink();
					if ($str_or_object_link->getTarget() != "") {
						$html .= "\" target=\"".$str_or_object_link->getTarget()."";
					}
				} else {
					if (get_class($str_or_object_link) == "DialogBox" || get_class($str_or_object_link) == "JavaScript" || is_subclass_of($str_or_object_link, "JavaScript")) {
						$str_or_object_link->displayFormURL();
					}
					$tmp_link = $str_or_object_link->render();
					if (strtoupper(substr($tmp_link, 0, 11)) == "JAVASCRIPT:") {
						$html .= "javascript:void(0);\" onClick=\"".str_replace("javascript:", "", str_replace("javascript:void(0);", "", $tmp_link)).$onclick;
					} else {
						$html .= $tmp_link;
					}
				}
			}
		} else {
			$html .= "javascript:void(0);";
		}
		return $html;
	}
	
	function get_browser_info($user_agent=null,$return_array=false) {
		$browser = array();
		if (get_cfg_var('browscap')) {
			$browser=get_browser($user_agent,$return_array); //If available, use PHP native function
		} else {
			require_once('browscap/php-local-browscap.php');
			$browser=get_browser_local($user_agent,$return_array,'php_browscap.ini',true);
		}
		return $browser;
	}
	
	// simple way to recursively delete a directory that is not empty
	function rrmdir($dir) {
		if (is_dir($dir)) {
			$objects = scandir($dir);
			foreach ($objects as $object) {
				if ($object != "." && $object != ".." && $object != ".svn") {
					if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object);
				}
			}
			reset($objects);
			return rmdir($dir);
		}
		return false;
	}
	
	function delMaskedFiles($mask_filepath) {
		$files = glob($mask_filepath);
		if (is_array($files)) {
			foreach ($files as $filename) {
			  @unlink($filename);
			}
		}
	}
		
	include_once("utils_label.inc.php");
	include_once("utils_string.inc.php");
	include_once("utils_xml.inc.php");
	include_once("utils2.inc.php");
?>
