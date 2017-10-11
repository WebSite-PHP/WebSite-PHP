<?php
/**
 * PHP file index.php
 */
/**
 * Entry point of all HTML pages
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
	$__AJAX_PAGE__ = false; // use for return catch exception and loadAllVariables method
	$__AJAX_LOAD_PAGE__ = false;
	$__PAGE_IS_INIT__ = false;
	$__LOAD_VARIABLES__ = false;
	$__DEBUG_PAGE_IS_PRINTING__ = false;
	$__GEOLOC_ASK_USER_SHARE_POSITION__ = false;

	if ($_SERVER['SERVER_NAME']==="localhost") { 
		// If URL contains "localhost" we redirect to "127.0.0.1"
		// Fix the issue on Internet Explorer with localhost URL when trying to log on wsp-admin
		list($current_url, $http_type, $port) = getCurrentPathUrlAndType();
		header('HTTP/1.1 301 Moved Temporarily');  
		header('Status: 301 Moved Temporarily');  
		header("Location:".str_replace($http_type.$_SERVER['SERVER_NAME'].$port."/", $http_type."127.0.0.1".$port."/", getCurrentUrl()));
		exit;
	}

    @session_set_cookie_params(0, "/", $_SERVER['SERVER_NAME'], false, true);
	@session_name(formalize_to_variable(SITE_NAME));
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
	if (substr($_GET['p'], 0, 6) == "error-") {
		if (!file_exists("pages/error/".$_GET['p'].".php")) {
			$_GET['p'] = "error-page";
		}
	} else if (!file_exists("pages/".$_GET['p'].".php")) {
		$_GET['p'] = "error-page"; 
	}
	
	if (DEBUG) {
		$wspPageTotalTime = elog_time($_SESSION['wspPageStartTime']); 
		$_SESSION['log_debug_str_session'][] = "<b>Execution Time Init WSP ...:</b> ".round($wspPageTotalTime,3)." Seconds";
	}
	include("wsp/includes/init.inc.php");
	if (DEBUG) {
		$wspPageTotalTime = elog_time($_SESSION['wspPageStartTime']); 
		$_SESSION['log_debug_str_session'][] = "<b>Execution Time End Init WSP:</b> ".round($wspPageTotalTime,3)." Seconds";
		$_SESSION['log_debug_str_session'][] = "";
	}
	
	// Create current page object
	if (DEBUG) {
		$wspPageTotalTime = elog_time($_SESSION['wspPageStartTime']); 
		$_SESSION['log_debug_str_session'][] = "<b>Execution Time Create Page ...:</b> ".round($wspPageTotalTime,3)." Seconds";
	}
	$page_object = Page::getInstance($_GET['p']);
	$page_object->addLogDebugExecutionTime("End Create Page");
	$page_object->addLogDebug("");
	if (!$page_object->userHaveRights()) {
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
		if (DEBUG) { $page_object->addLogDebugExecutionTime("InitializeComponent ..."); }
		$page_object->InitializeComponent();
		if (DEBUG) { $page_object->addLogDebugExecutionTime("End InitializeComponent ..."); $page_object->addLogDebug(""); }
	
		if (DEBUG) { $page_object->addLogDebugExecutionTime("Load ..."); }
		$page_object->Load();
		if (DEBUG) { $page_object->addLogDebugExecutionTime("End Load ..."); $page_object->addLogDebug(""); }
	}
	
	// If page is not caching -> generate HTML
	if (!$page_object->getPageIsCaching()) {
		// set GET and POST data to the current page
		if (DEBUG) { $page_object->addLogDebugExecutionTime("Variables ..."); }
		$page_object->loadAllVariables();
		if (DEBUG) { $page_object->addLogDebugExecutionTime("End Variables"); $page_object->addLogDebug(""); }
		$__PAGE_IS_INIT__ = true;
		
		// execute callback method
		if (DEBUG) { $page_object->addLogDebugExecutionTime("Callback ..."); }
		$page_object->executeCallback();
		if (DEBUG) { $page_object->addLogDebugExecutionTime("End Callback"); $page_object->addLogDebug(""); }
		
		// call the loaded method
		if (DEBUG) { $page_object->addLogDebugExecutionTime("Loaded ..."); }
		$page_object->Loaded();
		if (DEBUG) { $page_object->addLogDebugExecutionTime("End Loaded"); $page_object->addLogDebug(""); }
		
		if (DEBUG) { $page_object->addLogDebugExecutionTime("Page Header ..."); }
		
		// Get CDN server URL (or base URL if not exists)
		$cdn_server_url = $page_object->getCDNServerURL();
		
		// init page title
		if ($page_object->getPageTitle() != "") {
			$current_page_title = $page_object->getPageTitle();
		} else {
			$current_page_title = SITE_NAME;
		}
		
		// init page keywords
		if ($page_object->getPageKeywords() != "") {
			$current_page_keywords = $page_object->getPageKeywords();
		} else {
			$current_page_keywords = SITE_KEYS;
		}
		
		// init page description
		if ($page_object->getPageDescription() != "") {
			$current_page_description = $page_object->getPageDescription();
		} else {
			$current_page_description = SITE_DESC;
		}
		
		// init page meta robots
		if ($page_object->getPageMetaRobots() != "") {
			$current_page_meta_robots = $page_object->getPageMetaRobots();
		} else {
			$current_page_meta_robots = SITE_META_ROBOTS;
		}
		
		// init page meta googlebots
		if ($page_object->getPageMetaGooglebots() != "") {
			$current_page_meta_googlebots = $page_object->getPageMetaGooglebots();
		} else {
			$current_page_meta_googlebots = SITE_META_GOOGLEBOTS;
		}
		
		// init page revisit after
		if ($page_object->getPageMetaRevisitAfter() != "") {
			$current_page_meta_revisit_after = $page_object->getPageMetaRevisitAfter();
		} else {
			if (defined('SITE_META_REVISIT_AFTER')) {
				$current_page_meta_revisit_after = SITE_META_REVISIT_AFTER;
			} else {
				$current_page_meta_revisit_after = 1;
			}
		}
		
		// init page open graph type
		if ($page_object->getPageMetaOpenGraphType() != "") {
			$current_page_meta_opengraph_type = $page_object->getPageMetaOpenGraphType();
		} else {
			if (defined('SITE_META_OPENGRAPH_TYPE')) {
				$current_page_meta_opengraph_type = SITE_META_OPENGRAPH_TYPE;
			} else {
				$current_page_meta_opengraph_type = "";
			}
		}
		
		// init page open graph image
		if ($page_object->getPageMetaOpenGraphImage() != "") {
			$current_page_meta_opengraph_image = $page_object->getPageMetaOpenGraphImage();
		} else {
			if (defined('SITE_META_OPENGRAPH_IMAGE')) {
				$current_page_meta_opengraph_image = SITE_META_OPENGRAPH_IMAGE;
			} else {
				$current_page_meta_opengraph_image = "";
			}
		}
		if ($current_page_meta_opengraph_image != "") {
			if (strtoupper(substr($current_page_meta_opengraph_image, 0, 7)) != "HTTP://" && 
				strtoupper(substr($current_page_meta_opengraph_image, 0, 8)) != "HTTPS://") {
					$current_page_meta_opengraph_image = $cdn_server_url.$current_page_meta_opengraph_image;
			}
		}
		
		// init page iphone 57px image
		if ($page_object->getPageMetaIphoneImage57Px() != "") {
			$current_page_meta_iphone_image_57px = $page_object->getPageMetaIphoneImage57Px();
		} else {
			if (defined('SITE_META_IPHONE_IMAGE_57PX')) {
				$current_page_meta_iphone_image_57px = SITE_META_IPHONE_IMAGE_57PX;
			} else {
				$current_page_meta_iphone_image_57px = "";
			}
		}
		if ($current_page_meta_iphone_image_57px != "") {
			if (strtoupper(substr($current_page_meta_iphone_image_57px, 0, 7)) != "HTTP://" && 
				strtoupper(substr($current_page_meta_iphone_image_57px, 0, 8)) != "HTTPS://") {
					$current_page_meta_iphone_image_57px = $cdn_server_url.$current_page_meta_iphone_image_57px;
			}
		}
		
		// init page iphone 72px image
		if ($page_object->getPageMetaIphoneImage72Px() != "") {
			$current_page_meta_iphone_image_72px = $page_object->getPageMetaIphoneImage72Px();
		} else {
			if (defined('SITE_META_IPHONE_IMAGE_72PX')) {
				$current_page_meta_iphone_image_72px = SITE_META_IPHONE_IMAGE_72PX;
			} else {
				$current_page_meta_iphone_image_72px = "";
			}
		}
		if ($current_page_meta_iphone_image_72px != "") {
			if (strtoupper(substr($current_page_meta_iphone_image_72px, 0, 7)) != "HTTP://" && 
				strtoupper(substr($current_page_meta_iphone_image_72px, 0, 8)) != "HTTPS://") {
					$current_page_meta_iphone_image_72px = $cdn_server_url.$current_page_meta_iphone_image_72px;
			}
		}
		
		// init page iphone 114px image
		if ($page_object->getPageMetaIphoneImage114Px() != "") {
			$current_page_meta_iphone_image_114px = $page_object->getPageMetaIphoneImage114Px();
		} else {
			if (defined('SITE_META_IPHONE_IMAGE_114PX')) {
				$current_page_meta_iphone_image_114px = SITE_META_IPHONE_IMAGE_114PX;
			} else {
				$current_page_meta_iphone_image_114px = "";
			}
		}
		if ($current_page_meta_iphone_image_114px != "") {
			if (strtoupper(substr($current_page_meta_iphone_image_114px, 0, 7)) != "HTTP://" && 
				strtoupper(substr($current_page_meta_iphone_image_114px, 0, 8)) != "HTTPS://") {
					$current_page_meta_iphone_image_114px = $cdn_server_url.$current_page_meta_iphone_image_114px;
			}
		}

        // init page iphone 152px image
        if ($page_object->getPageMetaIphoneImage152Px() != "") {
            $current_page_meta_iphone_image_152px = $page_object->getPageMetaIphoneImage152Px();
        } else {
            if (defined('SITE_META_IPHONE_IMAGE_152PX')) {
                $current_page_meta_iphone_image_152px = SITE_META_IPHONE_IMAGE_152PX;
            } else {
                $current_page_meta_iphone_image_152px = "";
            }
        }
        if ($current_page_meta_iphone_image_152px != "") {
            if (strtoupper(substr($current_page_meta_iphone_image_152px, 0, 7)) != "HTTP://" &&
                strtoupper(substr($current_page_meta_iphone_image_152px, 0, 8)) != "HTTPS://") {
                $current_page_meta_iphone_image_152px = $cdn_server_url.$current_page_meta_iphone_image_152px;
            }
        }
		list($opensearchxml_url, $opensearchxml_title) = $page_object->getOpenSearchXmlParameters();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="<?php echo $_SESSION['lang']; ?>">
	<head>
<?php if ($page_object->isMobileMetaTag()) { ?>
		<meta content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" name="viewport"/>
		<meta name="format-detection" content="telephone=no"/>
		<meta name="format-detection" content="address=no"/>
<?php } ?>
<?php if ($page_object->isMobileWebAppMetaTag()) { ?>
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="mobile-web-app-capable" content="yes">
<?php } ?>
<?php if ($page_object->getJsonManifestFileName() != "") { ?>
		<link rel="manifest" href="<?php echo $page_object->getJsonManifestFileName(); ?>">
<?php } ?>
		<title><?php echo utf8encode(html_entity_decode($current_page_title)); ?></title>
		
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta http-equiv="pragma" content="no-cache" />
		<meta http-equiv="cache-control" content="public" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	
		<meta name="description" content="<?php echo utf8encode(html_entity_decode($current_page_description)); ?>" />
		<meta name="keywords" content="<?php echo utf8encode(html_entity_decode($current_page_keywords)); ?>" />
		
		<meta name="resource-type" content="document" />
		<meta name="distribution" content="global" />
		<meta name="author" content="<?php echo utf8encode(SITE_AUTHOR); ?>" />
		<meta name="copyright" content="<?php echo utf8encode(SITE_NAME); ?> by <?php echo utf8encode(SITE_AUTHOR); ?>" />
		<meta name="lang" content="<?php echo $_SESSION['lang']; ?>" />
		<meta name="Robots" content="<?php echo $current_page_meta_robots; ?>" />
<?php if ($current_page_meta_googlebots != "") { ?>
		<meta name="googlebot" content="<?php echo $current_page_meta_googlebots; ?>" />
<?php } ?>
		<meta name="revisit-after" content="<?php echo $current_page_meta_revisit_after; ?> day" />
		<meta name="rating" content="<?php echo SITE_RATING; ?>" />
		<meta name="identifier-url" content="<?php echo BASE_URL; ?>" />
		<meta name="expires" content="never" />
		<link rel="icon" type="image/ico" href="<?php echo $cdn_server_url; ?>favicon.ico" />
<?php 	if ($current_page_meta_iphone_image_152px != "") { ?>
		<link rel="apple-touch-icon" sizes="152x152" href="<?php echo $current_page_meta_iphone_image_152px; ?>" />
<?php 	} ?>
<?php 	if ($current_page_meta_iphone_image_114px != "") { ?>
		<link rel="apple-touch-icon" sizes="114x114" href="<?php echo $current_page_meta_iphone_image_114px; ?>" />
<?php 	} ?>
<?php 	if ($current_page_meta_iphone_image_72px != "") { ?>
		<link rel="apple-touch-icon" sizes="72x72" href="<?php echo $current_page_meta_iphone_image_72px; ?>" />
<?php 	} ?>
<?php 	if ($current_page_meta_iphone_image_57px != "") { ?>
		<link rel="apple-touch-icon" sizes="57x57" href="<?php echo $current_page_meta_iphone_image_57px; ?>" />
<?php 	} ?>
<?php 	if ($opensearchxml_url != "") { ?>
		<link rel="search" type="application/opensearchdescription+xml" href="<?php echo $opensearchxml_url; ?>" title="<?php echo $opensearchxml_title; ?>" />
<?php 	} ?>
		
		<base href="<?php echo BASE_URL; ?>" />

		<meta property="og:title" content="<?php echo utf8encode(html_entity_decode($current_page_title)); ?>"/>
		<meta property="og:site_name" content="<?php echo utf8encode(SITE_NAME); ?>"/>
		<meta property="og:description" content="<?php echo utf8encode(html_entity_decode($current_page_description)); ?>"/>
		<meta property="og:url" content="<?php echo $page_object->getCurrentURL(); ?>"/>
<?php 	if ($current_page_meta_opengraph_type != "" || $current_page_meta_opengraph_image != "") { 
	 		if ($current_page_meta_opengraph_type != "") { ?>
		<meta property="og:type" content="<?php echo utf8encode($current_page_meta_opengraph_type); ?>"/>
<?php 		}
	 		if ($current_page_meta_opengraph_image != "") { ?>
		<meta property="og:image" content="<?php echo $current_page_meta_opengraph_image; ?>"/>
<?php 		}
		} ?>
		<meta itemprop="name" content="<?php echo utf8encode(html_entity_decode($current_page_title)); ?>">
		<meta itemprop="description" content="<?php echo utf8encode(html_entity_decode($current_page_description)); ?>">
<?php 	if ($current_page_meta_opengraph_image != "") { ?>
		<meta itemprop="image" content="<?php echo $current_page_meta_opengraph_image; ?>">
<?php 	} ?>
		
<?php 	if (defined('DEFINE_STYLE_FONT') && DEFINE_STYLE_FONT != "") {
			$default_font_array = array("Arial", "Times New Roman", "Verdana", "Comic Sans MS", "Courier", "Courier New", "Impact", "Monaco");
			if (!in_array(DEFINE_STYLE_FONT, $default_font_array)) {  
?>
		<link href='http://fonts.googleapis.com/css?family=<?php echo str_replace(" ", "+", DEFINE_STYLE_FONT); ?>' rel='stylesheet' type='text/css'>
<?php 		}
		}
		CssInclude::getInstance()->add(BASE_URL."wsp/css/styles.css.php", "", true);
		
		// jQuery
		if (!defined('DEFINE_STYLE_JQUERY')) {
			define("DEFINE_STYLE_JQUERY", "");
		}
		if (!defined('JQUERY_LOAD_LOCAL')) {
			$jquery_load_local = true;
		} else {
            $jquery_load_local = JQUERY_LOAD_LOCAL;
            if ($jquery_load_local == false && $page_object->isThirdPartyCookiesFilterEnable()){
                // because jsapi is necessary to load jquery from google CDN
                $jquery_load_local = true;
            }
        }
		if (!defined('JQUERY_VERSION')) {
			define("JQUERY_VERSION", "1.6.2");
		}
		if (!defined('JQUERY_UI_VERSION')) {
			define("JQUERY_UI_VERSION", "1.8.14");
		}
		if ($jquery_load_local == true) {
			$jquery_ui_ver = JQUERY_UI_VERSION;
			if (!is_dir("wsp/css/jquery".JQUERY_UI_VERSION."/")) {
				$jquery_ui_ver = "1.8.14";
			}
			if (DEFINE_STYLE_JQUERY == "") {
				CssInclude::getInstance()->addToEnd(BASE_URL."wsp/css/jquery".$jquery_ui_ver."/smoothness/jquery-ui-".$jquery_ui_ver.".custom.css", "", true);
			} else {
				CssInclude::getInstance()->addToEnd(BASE_URL."wsp/css/jquery".$jquery_ui_ver."/".DEFINE_STYLE_JQUERY."/jquery-ui-".$jquery_ui_ver.".custom.css", "", true);
			}
		} else {
			if (DEFINE_STYLE_JQUERY == "") {
				CssInclude::getInstance()->addToEnd("http://ajax.googleapis.com/ajax/libs/jqueryui/".JQUERY_UI_VERSION."/themes/smoothness/jquery-ui.css");
			} else {
				CssInclude::getInstance()->addToEnd("http://ajax.googleapis.com/ajax/libs/jqueryui/".JQUERY_UI_VERSION."/themes/".DEFINE_STYLE_JQUERY."/jquery-ui.css");
			}
		}
		
		$combine_css = "";
		$array_css = CssInclude::getInstance()->get(true);
		foreach ($array_css as $i => $css) {
			if (CssInclude::getInstance()->getCombine($i)) {
				if ($combine_css != "") { $combine_css .= ","; }
				$combine_css .= str_replace(".css.php", ".php.css", str_replace(BASE_URL."wsp/css/", "", str_replace(BASE_URL."css/", "", $css)));
			} else {
				echo "		";
				$conditional_comment = CssInclude::getInstance()->getConditionalComment($i);
				if ($conditional_comment != "") { echo "<!--[if ".$conditional_comment."]>\n			"; }
				if (find($css, ".css.php") > 0 && CssInclude::getInstance()->getCssConfigFile() != "") {
					$css .= "?conf_file=".CssInclude::getInstance()->getCssConfigFile();
				}
				echo "<link type=\"text/css\" rel=\"StyleSheet\" href=\"".str_replace(BASE_URL, $cdn_server_url, $css)."\" media=\"screen\" />\n";
				if ($conditional_comment != "") { echo "		<![endif]-->\n"; }
			}
		}
		if ($combine_css != "") {
			if (find($combine_css, ".php.css") > 0 && CssInclude::getInstance()->getCssConfigFile() != "") {
				$combine_css .= "?conf_file=".CssInclude::getInstance()->getCssConfigFile();
			}
			echo "		<link type=\"text/css\" rel=\"StyleSheet\" href=\"".$cdn_server_url."combine-css/".str_replace("/", "|", $combine_css)."\" media=\"screen\" />\n";
		}
		?>		
		<!--[if ie 9]>
		<style type="text/css" media="screen">
<?php
		for ($i=1; $i <= NB_DEFINE_STYLE_BCK; $i++) { 
		?>
		    .Css3GradientBoxTitle<?php echo $i; ?> {  filter: none; }
<?php
		}
		?>
		</style>
		<![endif]-->
<?php		
		// jQuery
		if ($jquery_load_local == true) {
			$jquery_ver = JQUERY_VERSION;
			if (!is_file("wsp/js/jquery/jquery-".$jquery_ver.".min.js")) {
				$jquery_ver = "1.6.2";
			}
			$jquery_ui_ver = JQUERY_UI_VERSION;
			if (!is_file("wsp/js/jquery/jquery-ui-".$jquery_ui_ver.".custom.min.js")) {
				$jquery_ui_ver = "1.8.14";
			}
			JavaScriptInclude::getInstance()->addToBegin(BASE_URL."wsp/js/jquery/jquery-".$jquery_ver.".min.js", "", true);
			JavaScriptInclude::getInstance()->addToBegin(BASE_URL."wsp/js/jquery/jquery-ui-".$jquery_ui_ver.".custom.min.js", "", true);
		} else {
		?>

		<script type="text/javascript" src="http://www.google.com/jsapi"></script>
		<script type="text/javascript">
			// Load lib by google
			google.load("jquery", "<?php echo (JQUERY_VERSION=="1.7.2"?"1.7.1":JQUERY_VERSION); ?>");
			google.load("jqueryui", "<?php echo JQUERY_UI_VERSION; ?>");
		</script>
<?php
		}
?>
		<script type="text/javascript">
			wsp_user_language = "<?php echo $_GET['l']; ?>";
			wsp_javascript_base_url = "<?php echo BASE_URL; ?>";
			wsp_javascript_base_lang_url = "<?php echo $page_object->getBaseLanguageURL(); ?>";
			wsp_javascript_cdn_server = "<?php echo $cdn_server_url; ?>";
			wsp_js_session_cache_expire = <?php echo session_cache_expire(); ?>;
<?php if ($page_object->isCachingAsked()) { ?>
			wsp_cache_filename = "<?php echo str_replace("/", "{#%2F#}", str_replace(SITE_DIRECTORY."/wsp/cache/".$_GET['l'], "", $page_object->getOriginalCacheFileName())); ?>";
<?php } else { ?>
			wsp_cache_filename = "";
<?php } ?>
		</script>
<?php
		JavaScriptInclude::getInstance()->add(BASE_URL."wsp/js/jquery.cookie.js", "", true);
		JavaScriptInclude::getInstance()->add(BASE_URL."wsp/js/utils.js", "", true);
		JavaScriptInclude::getInstance()->add(BASE_URL."wsp/js/pngfix.js", "", true);
		
		// log JS error system
		if (!defined("SEND_JS_ERROR_BY_MAIL")) {
			define(SEND_JS_ERROR_BY_MAIL, false);
		}
		if (SEND_JS_ERROR_BY_MAIL) {
			if (defined('SEND_ERROR_BY_MAIL') && SEND_ERROR_BY_MAIL == true && !isLocalDebug()) {
				JavaScriptInclude::getInstance()->add(BASE_URL."wsp/js/jquery.onerror.js", "", true);
			}
		}
		
		$combine_js = "";
		$not_combine_js = "";
		$array_js = JavaScriptInclude::getInstance()->get(true);
		foreach ($array_js as $i => $script) {
			if (JavaScriptInclude::getInstance()->getCombine($i)) {
				if ($combine_js != "") { $combine_js .= ","; }
				$combine_js .= str_replace(BASE_URL."wsp/js/", "", str_replace(BASE_URL."js/", "", $script));
			} else {
				$not_combine_js .= "		";
				$conditional_comment = JavaScriptInclude::getInstance()->getConditionalComment($i);
				if ($conditional_comment != "") { $not_combine_js .= "<!--[if ".$conditional_comment."]>\n			"; }
					$not_combine_js .= "<script type=\"text/javascript\"".(JavaScriptInclude::getInstance()->getIsAsync($i)?" async":"")." src=\"".str_replace(BASE_URL, $cdn_server_url, $script)."\">".JavaScriptInclude::getInstance()->getJsIncludeScript($i)."</script>\n";
				if ($conditional_comment != "") {
					$not_combine_js .= "<![endif]-->\n		"; 
				}
			}
		}
		if ($combine_js != "") {
			echo "		<script type=\"text/javascript\" src=\"".$cdn_server_url."combine-js/".str_replace("/", "|", $combine_js)."\"></script>\n";
		}
		if ($not_combine_js != "") {
			echo $not_combine_js;
		}
		if (DEBUG) {
			echo "<script type=\"text/javascript\" src=\"wsp/js/debug.js\"></script>";
		} 
		if (DEBUG) { $page_object->addLogDebugExecutionTime("End Page Header ..."); $page_object->addLogDebug(""); }
		?>
		
		<script type="text/javascript">
			function windowHeaderTitle() {
<?php if (find($current_page_title, "&#") == 0) { ?> 
				document.title = '<?php echo addslashes(str_replace("\n", "", str_replace("\r", "", str_replace("\t", "", utf8encode(html_entity_decode($current_page_title)))))); ?>';
<?php } ?>
			}
		 	StkFunc(windowHeaderTitle);
			StkFunc(SaveDocumentWindowSize);StkFuncOR(SaveDocumentWindowSize);
		</script>
	</head>
	
	<noscript>
		<div style="width:100%;" align="center">
			<div style="width:80%;text-align:center;background-color:#FEEFB3;color:#9F6000;border: 1px solid;">
				<img src="<?php echo $cdn_server_url; ?>wsp/img/msg/warning.png" width="24" height="24" style="vertical-align:middle;">
				<?php echo __(JAVASCRIPT_NOT_ACTIVATE); ?>
			</div>
		</div>
	</noscript>
	<body>
    <?php if ($page_object->isThirdPartyCookiesFilterEnable()) { ?>
        <script type="text/javascript">var tarteaucitronForceLanguage='<?php echo $page_object->getLanguage() ?>';tarteaucitron.init({"hashtag":"#thirdpartyfilter","highPrivacy":false,"orientation":"<?php echo $page_object->getThirdPartyCookiesFilterPosition(); ?>","removeCredit":false,"showAlertSmall":true,"adblocker":<?php echo $page_object->getThirdPartyCookiesFilterAdBlocker()?"true":"false"; ?>,"cookieslist":<?php echo $page_object->getThirdPartyCookiesFilterCookiesList()?"true":"false"; ?>});</script>
    <?php } ?>
    <?php if (GOOGLE_CODE_TRACKER != "" && !isLocalDebug() && !defined('GOOGLE_CODE_TRACKER_NOT_ACTIF')) { ?>
		<script type="text/javascript">
          <?php if (!$page_object->isThirdPartyCookiesFilterEnable()) { ?>
		  window.google_analytics_uacct = "<?php echo GOOGLE_CODE_TRACKER; ?>";
		  <?php
			if (SUBDOMAIN_URL != "") { 
				if (!defined('FORCE_SERVER_NAME') || FORCE_SERVER_NAME == "") {
					$domain_name = str_replace("http://".SUBDOMAIN_URL.".", "", "http://".$_SERVER['SERVER_NAME']);
				} else {
					$domain_name = str_replace("http://".SUBDOMAIN_URL.".", "", FORCE_SERVER_NAME);
				}
			} else {
				if (!defined('FORCE_SERVER_NAME') || FORCE_SERVER_NAME == "") {
					$domain_name = str_replace("http://www.", "", "http://".$_SERVER['SERVER_NAME']);
				} else {
					$domain_name = str_replace("http://www.", "", FORCE_SERVER_NAME);
				}
			}
			?>

		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		  ga('create', '<?php echo GOOGLE_CODE_TRACKER; ?>', '<?php echo $domain_name; ?>');
		  ga('require', 'displayfeatures');
		  ga('send', 'pageview', {
			  'page': '<?php echo "/".str_replace($page_object->getBaseURL(), "", $page_object->getCurrentURL()); ?>',
			  'title': '<?php echo addslashes(str_replace("\n", "", str_replace("\r", "", str_replace("\t", "", utf8encode(html_entity_decode($current_page_title)))))); ?>'
			});
          <?php } else { ?>
          (tarteaucitron.job = tarteaucitron.job || []).push('analytics');
          tarteaucitron.user.analyticsUa = '<?php echo GOOGLE_CODE_TRACKER; ?>';
          tarteaucitron.user.analyticsMore = function () {
              ga('require', 'displayfeatures');
              ga('send', 'pageview', {
                  'page': '<?php echo "/".str_replace($page_object->getBaseURL(), "", $page_object->getCurrentURL()); ?>',
                  'title': '<?php echo addslashes(str_replace("\n", "", str_replace("\r", "", str_replace("\t", "", utf8encode(html_entity_decode($current_page_title)))))); ?>'
              });
          }
          <?php } ?>
		</script>
		<?php 
		}
		if ($jquery_load_local == true) {
		?>
            <?php if ($page_object->isThirdPartyCookiesFilterEnable()) { ?>
            <script type="text/javascript">(tarteaucitron.job = tarteaucitron.job || []).push('jsapi');</script>
            <?php } else { ?>
		    <script type="text/javascript" src="http://www.google.com/jsapi"></script>
            <?php } ?>
		<?php
			}
		?>
		<script type="text/javascript">
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
		if (SEND_JS_ERROR_BY_MAIL) {
			if (defined('SEND_ERROR_BY_MAIL') && SEND_ERROR_BY_MAIL == true && !isLocalDebug()) {
		?>
			$(document).jsErrorHandler();
		<?php
			}
		}
		?>
		</script>
		
		<?php 
			if (is_browser_ie_6() && !isset($_SESSION['WSP_IE6_MSG_'.formalize_to_variable(SITE_NAME)]) && $_SESSION['WSP_IE6_MSG_'.formalize_to_variable(SITE_NAME)] != "ok") {
				$alternative_browser = '';
				$alternative_browser .= '<a href="http://www.mozilla.com/"><img src="'.BASE_URL.'wsp/img/Firefox_128x128.png" height="60" width="60" border="0" title="Mozilla FireFox"/></a> ';
				$alternative_browser .= '<a href="http://www.microsoft.com/windows/internet-explorer/"><img src="'.BASE_URL.'wsp/img/IE_128x128.png" height="60" width="60" border="0" title="Internet Explorer"/></a> ';
				$alternative_browser .= '<a href="http://www.apple.com/safari/"><img src="'.BASE_URL.'wsp/img/Safari_128x128.png" height="60" width="60" border="0" title="Safari"/></a> ';
				$alternative_browser .= '<a href="http://www.google.com/chrome"><img src="'.BASE_URL.'wsp/img/Chrome_128x128.png" height="60" width="60" border="0" title="Chrome"/></a> ';
				$alternative_browser .= '<a href="http://www.opera.com/browser/"><img src="'.BASE_URL.'wsp/img/Opera_128x128.png" height="60" width="60" border="0" title="Opera"/></a> ';
				$page_object->addObject(new DialogBox(__(NOT_SUPPORTED_BROWSER_TITLE), "<br/>".__(NOT_SUPPORTED_BROWSER).$alternative_browser."<br/>"));
				$_SESSION['WSP_IE6_MSG_'.formalize_to_variable(SITE_NAME)] = "ok";
			}
			
			// call current page page
			if (DEBUG) { $page_object->addLogDebugExecutionTime("Render ..."); }
			echo str_replace("\n\n", "\n", str_replace("\r", "", str_replace("{#wsp_tab}", "\t", str_replace("\t", "", $page_object->render()))));
			if (DEBUG) { $page_object->displayExecutionTime("End Render"); }
		?>
		<!-- Please support the project: don't remove the WSP copyright -->
		<div align="center" id="wsp-copyright">
			<img src="http://www.website-php.com/img/logo_16x16.png" height="16" width="16" align="absmiddle"/> Site created with framework <a href="http://www.website-php.com" target="_blank">WebSite-PHP</a>
		</div>
		<script type="text/javascript">
			LoadPngPicture();
		</script>
	</body>
</html>
<?php 
	// End If page is not caching
	} else {
		// call current page page cache
		if (DEBUG) { $page_object->addLogDebugExecutionTime("Load Cache ..."); }
		echo $page_object->render();
		if (DEBUG) { $page_object->displayExecutionTime("End Load Cache"); }
	}
	
	// Disconnect DataBase
	if (DB_ACTIVE) {
		DataBase::getInstance(false)->disconnect();
	}
	unset($_SESSION['websitephp_register_object']);
?>
