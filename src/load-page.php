<?php
/**
 * PHP file load-page.php
 */
/**
 * Entry point of all other pages (.pdf, .xml, .call, ...)
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
	$__AJAX_LOAD_PAGE__ = true;
	$__PAGE_IS_INIT__ = false;
	$__LOAD_VARIABLES__ = false;
	$__DEBUG_PAGE_IS_PRINTING__ = false;
	$__GEOLOC_ASK_USER_SHARE_POSITION__ = false;

    @session_set_cookie_params(0, "/", $_SERVER['SERVER_NAME'], false, true);
	@session_name(formalize_to_variable(SITE_NAME));
	if (isset($_COOKIE['WSP_WS_SESSION'])) {
		session_id($_COOKIE['WSP_WS_SESSION']);
	} else {
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
	}
	
	include_once("wsp/includes/execution_time.php");
	$_SESSION['wspPageStartTime'] = slog_time();
	
	if (!isset($_GET['p'])) {
		$_GET['p'] = "home"; 
	}
	$_SESSION['calling_page'] = $_GET['p'];
	if (!file_exists("pages/".$_GET['p'].".php")) {
		header('HTTP/1.1 404 Could not find page '.$_GET['p']);
		echo 'Could not find page '.$_GET['p'];
		exit;
	}
	
	include("wsp/includes/init.inc.php");
	
	header("Expires: Sat, 05 Nov 2005 00:00:00 GMT");
	header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	
	$isWSDL = false;
	if (isset($_GET['mime'])) {
		if ($_GET['mime'] == "rss") {
			$_GET['mime'] = "application/rss+xml";
		} else if ($_GET['mime'] == "doc") {
			$_GET['mime'] = "application/doc";
		} else if ($_GET['mime'] == "xls") {
			$_GET['mime'] = "application/vnd.ms-excel";
		} else if ($_GET['mime'] == "pdf") {
			$_GET['mime'] = "application/pdf";
		} else if ($_GET['mime'] == "wsdl" || $_GET['mime'] == "xml") {
			if ($_GET['mime'] == "wsdl") {
				$isWSDL = true;
			}
			$_GET['mime'] = "text/xml";
		} else if ($_GET['mime'] == "json") {
			$_GET['mime'] = "text/plain";
		} else if ($_GET['mime'] == "php" || $_GET['mime'] == "do" || $_GET['mime'] == "call" || $_GET['mime'] == "xhtml" || $_GET['mime'] == "wsp") {
			$_GET['mime'] = "text/html";
		} else if ($_GET['p'] == "rss" || find($_GET['p'], "rss-", 0, 0) > 0) {
			$_GET['mime'] = "application/rss+xml";
		} else {
			$_GET['mime'] = "text/".$_GET['mime'];
		}
		header("Content-Type: ".$_GET['mime']);
		
		/*if ($_GET['mime'] == "text/html") {
			$zlib_OC_is_set = preg_match('/On|(^[0-9]+$)/i', ini_get('zlib.output_compression'));
			if ($zlib_OC_is_set) {
				if (@strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') !== FALSE) {
					header("Content-Encoding: gzip"); 
				}
			}
		}*/
	}
	
	if ($isWSDL) {
		include_once("pages/".$_GET['p'].".php");
		
		$page_tmp = str_replace("_", "-", $_GET['p']);
		$page_tmp = explode('/', $page_tmp);
		$page_names = explode('-', $page_tmp[sizeof($page_tmp)-1]);
		$page_class_name = "";
		for ($i=0; $i < sizeof($page_names); $i++) {
			$page_class_name .= ucfirst($page_names[$i]);
		}
		
		$page_object = new $page_class_name();
	} else {
		// Create current page object
		$page_object = Page::getInstance($_GET['p']);
		if (!$page_object->userHaveRights()) {
			if ($_GET['mime'] == "text/html") {
				$user_no_rights_redirect = $page_object->getUserNoRightsRedirect();
				if ($user_no_rights_redirect != "") {
					if (strtoupper(substr($user_no_rights_redirect, 0, 7)) != "HTTP://" && 
						strtoupper(substr($user_no_rights_redirect, 0, 8)) != "HTTPS://") {
							$user_no_rights_redirect = BASE_URL.$user_no_rights_redirect;
					}
					header('HTTP/1.1 301 Moved Temporarily');  
					header('Status: 301 Moved Temporarily');  
					header("Location:".$user_no_rights_redirect);
					exit;
				}
				$page_object = Page::getInstance("error-user-rights");
			} else {
				header('HTTP/1.1 500 Internal Server Error');
				echo 'You have no rights on the page '.$_GET['p'];
				exit;
			}
		}
				
		$call_load_method = false;
		if (CACHING_ALL_PAGES && substr($_GET['p'], 0, 6) != "error-") {
			if (!$page_object->setCache()) {
				$call_load_method = true;
			}
		} else {
			$call_load_method = true;
		}
		
		if ($call_load_method) {
			$page_object->InitializeComponent();
			$page_object->Load();
		}
		
		// If page is not caching -> generate HTML
		if (!$page_object->getPageIsCaching()) {
			// set GET and POST data to the current page
			$page_object->loadAllVariables();
			$__PAGE_IS_INIT__ = true;
			
			// execute callback method
			$page_object->executeCallback();
			
			// call the loaded method
			$page_object->Loaded();
			
			if ($_GET['mime'] == "text/html") {
				$idLoadPage = rand(0,999999);
				$__AJAX_LOAD_PAGE_ID__ = $idLoadPage;
				
				// Get CDN server URL (or base URL if not exists)
				$cdn_server_url = $page_object->getCDNServerURL();
?>
				<div align="center" id="idLoadPageLoadingPicture<?php echo $idLoadPage; ?>" style="width:100%;height:100%;#position:absolute;#top:50%;display:table-cell;vertical-align:middle;">
					<?php if (isset($_POST['oldContentHtml'])) { echo $_POST['oldContentHtml']; } ?>
					<img src="<?php echo $cdn_server_url; ?>wsp/img/loading.gif" width="32" height="32"/>
				</div>
				<script language="JavaScript">$('#idLoadPageLoadingPicture<?php echo $idLoadPage; ?>').height($('#idLoadPageLoadingPicture<?php echo $idLoadPage; ?>').parent().height());</script>
				<div id="idLoadPageContent<?php echo $idLoadPage; ?>" style="display:none;">
<?php 
				// call current page page
				list($html_current_page, $javascript_current_page) = extractJavaScriptFromHtml(str_replace("\r", "", str_replace("\t", "", $page_object->render())));
				echo str_replace("\n\n", "\n", str_replace("{#wsp_tab}", "\t", $html_current_page));
				
				$ind_load_js = rand(0, 99999999);
?>
			</div>
			<script type="text/javascript">
				launchJavascriptPage_<?php echo $ind_load_js; ?> = function() {
					$('#idLoadPageLoadingPicture<?php echo $idLoadPage; ?>').attr('style', 'display:none;');
					$('#idLoadPageContent<?php echo $idLoadPage; ?>').attr('style', 'display:block;');
					setTimeout(launchJavascriptPageExecute<?php echo $ind_load_js; ?>, 1);
				};
				launchJavascriptPageExecute<?php echo $ind_load_js; ?> = function() {
<?php
					echo str_replace("\n\n", "\n", $javascript_current_page);
?>
				};
<?php
				$combine_css = "";
				$array_css = CssInclude::getInstance()->get(true);
				foreach ($array_css as $i => $css) {
					if (CssInclude::getInstance()->getCombine($i)) {
						if ($combine_css != "") { $combine_css .= ","; }
						$combine_css .= str_replace(".css.php", ".php.css", str_replace(BASE_URL."wsp/css/", "", str_replace(BASE_URL."css/", "", $css)));
					} else {
						echo "			";
						$conditional_comment = CssInclude::getInstance()->getConditionalComment($i);
						if ($conditional_comment != "") { echo "<!--[if ".$conditional_comment."]>\n				"; }
						if (find($css, ".css.php") > 0 && CssInclude::getInstance()->getCssConfigFile() != "") {
							$css .= "?conf_file=".CssInclude::getInstance()->getCssConfigFile();
						}
						echo "loadDynamicCSS('".str_replace(BASE_URL, $cdn_server_url, $css)."');\n";
						if ($conditional_comment != "") { echo "			<![endif]-->\n"; }
					}
				}
				if ($combine_css != "") {
					if (find($combine_css, ".php.css") > 0 && CssInclude::getInstance()->getCssConfigFile() != "") {
						$combine_css .= "?conf_file=".CssInclude::getInstance()->getCssConfigFile();
					}
					echo "			loadDynamicCSS('".$cdn_server_url."combine-css/".str_replace("/", "|", $combine_css)."');\n";
				}
				
				$combine_js = "";
				$array_js = JavaScriptInclude::getInstance()->get(true);
				foreach ($array_js as $i => $script) {
					if (JavaScriptInclude::getInstance()->getCombine($i)) {
						if ($combine_js != "") { $combine_js .= ","; }
						$combine_js .= str_replace(BASE_URL."wsp/js/", "", str_replace(BASE_URL."js/", "", $script));
					} else {
						echo "			";
						$conditional_comment = JavaScriptInclude::getInstance()->getConditionalComment($i);
						if ($conditional_comment != "") { echo "<!--[if ".$conditional_comment."]>\n				"; }
							echo "loadDynamicJS('".str_replace(BASE_URL, $cdn_server_url, $script)."', ".$ind_load_js.");\n";
						if ($conditional_comment != "") {
							echo "			<![endif]-->\n"; 
						}
					}
				}
				if ($combine_js != "") {
					echo "			loadDynamicJS('".$cdn_server_url."combine-js/".str_replace("/", "|", $combine_js)."', ".$ind_load_js.");\n";
				}
?>
				waitForJsScripts(<?php echo $ind_load_js; ?>);
				LoadPngPicture();

				if(typeof launchGeoLocalisation == 'function' && typeof wsp_javascript_base_url != "undefined") { 
				<?php
				if ($__GEOLOC_ASK_USER_SHARE_POSITION__ == true && !$page_object->isCrawlerBot()) {
				?>
					launchGeoLocalisation(true);
				<?php
				} else {
				?>
					launchGeoLocalisation(false);
				<?php
				}
				?>
				}
			</script>
<?php 
			} else {
				echo $page_object->render();
			}
		// End If page is not caching
		} else {
			// call current page page cache
			echo $page_object->render();
		}
	}
	
	// Disconnect DataBase
	if (DB_ACTIVE) {
		DataBase::getInstance(false)->disconnect();
	}
	unset($_SESSION['websitephp_register_object']);
	
	if (DEBUG && $_GET['mime'] == "text/html") {
		$page_object->displayExecutionTime();
	}
?>
