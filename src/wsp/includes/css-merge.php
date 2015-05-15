<?php
/**
 * PHP file wsp\includes\css-merge.php
 */
/**
 * WebSite-PHP file css-merge.php
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
 * @since       1.0.19
 */


	/************************************************************************
	 * CSS and Javascript Combinator 0.5
	 * Copyright 2006 by Niels Leenheer
	 *
	 * Permission is hereby granted, free of charge, to any person obtaining
	 * a copy of this software and associated documentation files (the
	 * "Software"), to deal in the Software without restriction, including
	 * without limitation the rights to use, copy, modify, merge, publish,
	 * distribute, sublicense, and/or sell copies of the Software, and to
	 * permit persons to whom the Software is furnished to do so, subject to
	 * the following conditions:
	 * 
	 * The above copyright notice and this permission notice shall be
	 * included in all copies or substantial portions of the Software.
	 *
	 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
	 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
	 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
	 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
	 * LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
	 * OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
	 * WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
	 */


	$cache 	  = true;
	$cachedir = dirname(__FILE__) . '/../cache';
	$cssdir   = dirname(__FILE__) . '/../css';
	$jsdir    = dirname(__FILE__) . '/../js';

	// Determine the directory and type we should use
	switch ($_GET['type']) {
		case 'css':
			$base = realpath($cssdir);
			break;
		case 'javascript':
			$base = realpath($jsdir);
			break;
		default:
			header ("HTTP/1.0 503 Not Implemented");
			exit;
	};

	$type = $_GET['type'];
	$elements = explode(',', $_GET['files']);
	
	$base_root = realpath($base."/../../");
	
	// restricted wsp folders
	$base_pages = realpath($base_root."/pages/");
	$base_wsp = realpath($base_root."/wsp/");
	$base_lang = realpath($base_root."/lang/");
	
	if (isset($_GET['conf_file'])) {
		$_GET['conf_file'] = str_replace("|", "/", $_GET['conf_file']);
	}
	
	// Determine last modification date of the files
	$lastmodified = 0;
	foreach ($elements as $element) {
		$element = str_replace("|", "/", $element);
		$path = realpath($base . '/' . str_replace(".php.css", ".css.php", $element));
		if (!file_exists($path)) {
			$path = realpath($base . '/../../' . str_replace(".php.css", ".css.php", $element));
		}
		if (file_exists($path)) {
			if (($type == 'javascript' && substr($path, -3) != '.js') || 
				($type == 'css' && substr($path, -4) != '.css' && substr($path, -8) != '.css.php')) {
				header ("HTTP/1.0 403 Forbidden");
				exit;	
			}
		
			if (substr($path, 0, strlen($base)) != $base || !file_exists($path)) {
				if (!file_exists($path)) {
					header ("HTTP/1.0 404 Not Found");
					exit;
				} else if (substr($path, 0, strlen($base_pages)) == $base_pages ||
							substr($path, 0, strlen($base_wsp)) == $base_wsp ||
							substr($path, 0, strlen($base_lang)) == $base_lang) {
							// forbid access to restricted wsp folders
					header ("HTTP/1.0 404 Not Found");
					exit;
				}
			}
			
			if ($type == 'css' && substr($path, -8) == '.css.php') {
				if (isset($_SESSION['lang'])) {
					$_GET['l'] = $_SESSION['lang'];
				}
				if (isset($_GET['conf_file']) && file_exists("../config/".$_GET['conf_file'])) {
					$lastmodified = max($lastmodified, filemtime("../config/".$_GET['conf_file']));
				} else {
					$lastmodified = max($lastmodified, filemtime("../config/config_css.inc.php"));
				}
			} else {
				$lastmodified = max($lastmodified, filemtime($path));
			}
		}
	}
	
	$is_config_theme_page = false;
	if (file_exists("../config/config_admin.inc.php")) {
		include("../config/config_admin.inc.php");
		
		$config_css_url = WSP_ADMIN_URL."/theme/configure-css.html";
		if (isset($_SERVER['HTTP_REFERER']) && substr($_SERVER['HTTP_REFERER'], strlen($config_css_url)*-1) == $config_css_url) {
			$lastmodified = time();
			$is_config_theme_page = true;
		}
	}
	include_once("../includes/utils.inc.php");
	include_once("../includes/utils_string.inc.php");
	
	// Send Etag hash
	$hash = $lastmodified . '-' . md5($_GET['files']);
	if (isset($_GET['conf_file']) && file_exists("../config/".$_GET['conf_file'])) {
		if (find($_GET['conf_file'], "..") > 0) { // no config file with relative path (security check)
			exit;
		}
		$hash .= '-' . md5($_GET['conf_file']);
	}
	header ("Etag: \"" . $hash . "\"");
	
	$expires = 604800; // 7 days
	header("Pragma: public");
	header("Cache-Control: maxage=".$expires);
	header('Expires: ' . gmdate('D, d M Y H:i:s', time()+$expires) . ' GMT');
	
	if (isset($_SERVER['HTTP_IF_NONE_MATCH']) && 
		stripslashes($_SERVER['HTTP_IF_NONE_MATCH']) == '"' . $hash . '"') 
	{
		// Return visit and no modifications, so do not send anything
		header ("HTTP/1.0 304 Not Modified");
		header ('Content-Length: 0');
	} 
	else 
	{
		// First time visit or files were modified
		if ($cache) 
		{
			// Determine supported compression method
			if (!isset($_SERVER['HTTP_ACCEPT_ENCODING'])) {
				$gzip = false;
				$deflate = false;
			} else {
				$gzip = strstr($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip');
				$deflate = strstr($_SERVER['HTTP_ACCEPT_ENCODING'], 'deflate');
			}
	
			// Determine used compression method
			$encoding = $gzip ? 'gzip' : ($deflate ? 'deflate' : 'none');
			
			// TEMP
			$encoding = 'none';
	
			// Check for buggy versions of Internet Explorer
			if (!isset($_SERVER['HTTP_USER_AGENT'])) {
				$_SERVER['HTTP_USER_AGENT'] = "";
			}
			if (!strstr($_SERVER['HTTP_USER_AGENT'], 'Opera') && 
				preg_match('/^Mozilla\/4\.0 \(compatible; MSIE ([0-9]\.[0-9])/i', $_SERVER['HTTP_USER_AGENT'], $matches)) {
				$version = floatval($matches[1]);
				
				if ($version < 6)
					$encoding = 'none';
					
				if ($version == 6 && !strstr($_SERVER['HTTP_USER_AGENT'], 'EV1')) 
					$encoding = 'none';
			}
			
			// Try the cache first to see if the combined files were already generated
			$cachefile = 'cache-' . $hash . '.' . $type . ($encoding != 'none' ? '.' . $encoding : '');
			
			if (file_exists($cachedir . '/' . $_GET['type'] . '/' . $cachefile)) {
				if ($fp = fopen($cachedir . '/' . $_GET['type'] . '/' . $cachefile, 'rb')) {

					if ($encoding != 'none') {
						header ("Content-Encoding: " . $encoding);
					}
				
					header ("Content-Type: text/" . $type);
					header ("Content-Length: " . filesize($cachedir . '/' . $_GET['type'] . '/' . $cachefile));
		
					fpassthru($fp);
					fclose($fp);
					exit;
				}
			}
		}
	
		$my_site_base_url_merge_css = "";
		if (strrpos($_SERVER['REQUEST_URI'], "wsp/includes/css-merge.php") > 0) {
			$my_site_base_url_merge_css = substr($_SERVER['REQUEST_URI'], 0, strrpos($_SERVER['REQUEST_URI'], "wsp/includes/css-merge.php"));
		}
		if (strrpos($_SERVER['REQUEST_URI'], "combine-css/") > 0) {
			$my_site_base_url_merge_css = substr($_SERVER['REQUEST_URI'], 0, strrpos($_SERVER['REQUEST_URI'], "combine-css/"));
		}
		if (!isLocalDebug() && defined("CDN_SERVER") && 
			(CDN_SERVER != "" && CDN_SERVER != "http://")) {
				$cdn_server_url = CDN_SERVER;
				if ($cdn_server_url[strlen($cdn_server_url)-1] != "/") {
					$cdn_server_url .= "/";
				}
				$my_site_base_url_merge_css = $cdn_server_url;
		}
	
		// Get contents of the files
		$contents = '';
		reset($elements);
		while (list(,$element) = each($elements)) {
			$element = str_replace("|", "/", $element);
			$tmp_path_array = explode('/', $element);
			$path = realpath($base . '/' . str_replace(".php.css", ".css.php", $element));
			if (!file_exists($path)) {
				$path = realpath($base . '/../../' . str_replace(".php.css", ".css.php", $element));
			}
			if (file_exists($path)) {
				if ($type == 'css' && substr($path, -8) == '.css.php') {
					ob_start();
					include($path);
					$out_css = ob_get_contents();
					ob_end_clean();
					$contents .= "\n\n" . $out_css;
				} else {
					$tmp_content = file_get_contents($path);
					if (sizeof($tmp_path_array) == 3 && substr($tmp_path_array[0], 0, 6) == "jquery") {
						$tmp_content = str_replace("url(images/", "url(".$my_site_base_url_merge_css."wsp/css/".$tmp_path_array[0]."/".$tmp_path_array[1]."/images/", $tmp_content);
					}
					$contents .= "\n\n".$tmp_content;
				}
			}
		}
		
		if ($my_site_base_url_merge_css != "") {
			$contents = str_replace("../wsp/img/", $my_site_base_url_merge_css."wsp/img/", $contents);
			$contents = str_replace("../wsp/css/", $my_site_base_url_merge_css."wsp/css/", $contents);
			$contents = str_replace("../img/", $my_site_base_url_merge_css."img/", $contents);
		}
		
		if ($type == 'css') {
			include("cssmin.php");
			$contents = CssMin::minify($contents);
		}

		// Send Content-Type
		header ("Content-Type: text/" . $type);
		header("Cache-control: public");
		
		if (isset($encoding) && $encoding != 'none') 
		{
			// Send compressed contents
			$contents = gzencode($contents, 9, $gzip ? FORCE_GZIP : FORCE_DEFLATE);
			header ("Content-Encoding: " . $encoding);
			header ('Content-Length: ' . strlen($contents));
			echo $contents;
		} 
		else 
		{
			// Send regular contents
			header ('Content-Length: ' . strlen($contents));
			echo $contents;
		}

		// Store cache
		if ($cache) {
			if ($fp = fopen($cachedir . '/' . $_GET['type'] . '/' . $cachefile, 'wb')) {
				fwrite($fp, $contents);
				fclose($fp);
			}
		}
	}	
?>
