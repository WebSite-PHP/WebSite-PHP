<?php
/**
 * PHP file index.php
 */
/**
 * Entry point of all HTML pages
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
 * @version     1.0.88
 * @access      public
 * @since       1.0.0
 */

	error_reporting(E_ALL);
	
	include_once("wsp/config/config.inc.php");
	include_once("wsp/includes/utils_session.inc.php");
	$__AJAX_PAGE__ = false; // use for return catch exception and loadAllVariables method
	$__AJAX_LOAD_PAGE__ = false;
	$__PAGE_IS_INIT__ = false;
	$__LOAD_VARIABLES__ = false;
	$__DEBUG_PAGE_IS_PRINTING__ = false;
	
	session_name(formalize_to_variable(SITE_NAME));
	session_start();
	
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
	
	include("wsp/includes/init.inc.php");
	
	// Create current page object
	$page_object = Page::getInstance($_GET['p']);
	if (!$page_object->userHaveRights()) {
		$user_no_rights_redirect = $page_object->getUserNoRightsRedirect();
		if ($user_no_rights_redirect != "") {
			if (strtoupper(substr($user_no_rights_redirect, 0, 7)) != "HTTP://") {
				$user_no_rights_redirect = BASE_URL.$user_no_rights_redirect;
			}
			header('HTTP/1.1 301 Moved Temporarily');  
			header('Status: 301 Moved Temporarily');  
			header("Location:".$user_no_rights_redirect);
			exit;
		}
		$page_object = Page::getInstance("error-user-rights");
	}
	
	if (!method_exists($page_object, "Load") && !method_exists($page_object, "InitializeComponent")) {
		throw new NewException('function Load or InitializeComponent doesn\'t exists for the page '.$_GET['p'], 0, 8, __FILE__, __LINE__);
	}
	
	// Connect to the DataBase
	if (DB_ACTIVE) {
		if (!DataBase::getInstance()->connect()) {
			$_GET['p'] = "error-database";
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
		if (method_exists($page_object, "InitializeComponent")) {
			$page_object->InitializeComponent();
		}
		if (method_exists($page_object, "Load")) {
			$page_object->Load();
		}
	}
	
	// If page is not caching -> generate HTML
	if (!$page_object->getPageIsCaching()) {
		// set GET and POST data to the current page
		$page_object->loadAllVariables();
		$__PAGE_IS_INIT__ = true;
		
		// execute callback method
		$page_object->executeCallback();
		
		// call the display method
		if (method_exists($page_object, "Loaded")) {
			$page_object->Loaded();
		}
		
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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="<?php echo $_SESSION['lang']; ?>">
	<head>
		<title><?php echo html_entity_decode($current_page_title); ?></title>
		
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
		<meta http-equiv="pragma" content="no-cache" />
		<meta http-equiv="cache-control" content="public" />
	
		<meta name="description" content="<?php echo html_entity_decode($current_page_description); ?>" />
		<meta name="keywords" content="<?php echo html_entity_decode($current_page_keywords); ?>" />
		
		<meta name="resource-type" content="document" />
		<meta name="distribution" content="global" />
		<meta name="author" content="<?php echo SITE_AUTHOR; ?>" />
		<meta name="copyright" content="<?php echo SITE_NAME; ?> by <?php echo SITE_AUTHOR; ?>" />
		<meta name="lang" content="<?php echo $_SESSION['lang']; ?>" />
		<meta name="Robots" content="<?php echo $current_page_meta_robots; ?>" />
<?php if ($current_page_meta_googlebots != "") { ?>
		<meta name="googlebot" content="<?php echo $current_page_meta_googlebots; ?>" />
<?php } ?>
		<meta name="revisit-after" content="<?php echo $current_page_meta_revisit_after; ?> day" />
		<meta name="rating" content="<?php echo SITE_RATING; ?>" />
		<meta name="identifier-url" content="<?php echo BASE_URL; ?>" />
		<meta name="expires" content="never" />
		<link rel="icon" type="image/ico" href="<?php echo BASE_URL; ?>favicon.ico" />
		
		<base href="<?php echo BASE_URL; ?>" />
		
<?php 	if (defined('DEFINE_STYLE_FONT') && DEFINE_STYLE_FONT != "") { ?>
		<link href='http://fonts.googleapis.com/css?family=<?php echo str_replace(" ", "+", DEFINE_STYLE_FONT); ?>' rel='stylesheet' type='text/css'>
<?php 	} 
		CssInclude::getInstance()->add(BASE_URL."wsp/css/styles.css.php", "", true);
		
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
				echo "<link type=\"text/css\" rel=\"StyleSheet\" href=\"".$css."\" media=\"screen\" />\n";
				if ($conditional_comment != "") { echo "		<![endif]-->\n"; }
			}
		}
		if ($combine_css != "") {
			if (find($combine_css, ".php.css") > 0 && CssInclude::getInstance()->getCssConfigFile() != "") {
				$combine_css .= "?conf_file=".CssInclude::getInstance()->getCssConfigFile();
			}
			echo "		<link type=\"text/css\" rel=\"StyleSheet\" href=\"".BASE_URL."combine-css/".str_replace("/", "|", $combine_css)."\" media=\"screen\" />\n";
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
		if (!defined('DEFINE_STYLE_JQUERY')) {
			define("DEFINE_STYLE_JQUERY", "");
		}
		if (!defined('JQUERY_LOAD_LOCAL')) {
			define("JQUERY_LOAD_LOCAL", true);
		}
		
		if (DEFINE_STYLE_JQUERY == "") {
			echo "		<link type=\"text/css\" rel=\"StyleSheet\" href=\"".BASE_URL."wsp/css/jquery1.8.6/smoothness/jquery-ui-1.8.6.custom.css\" media=\"screen\" />\n";
		} else {
			echo "		<link type=\"text/css\" rel=\"StyleSheet\" href=\"".BASE_URL."wsp/css/jquery1.8.6/".DEFINE_STYLE_JQUERY."/jquery-ui-1.8.6.custom.css\" media=\"screen\" />\n";
		}
		
		if (JQUERY_LOAD_LOCAL == true) {
			JavaScriptInclude::getInstance()->addToBegin(BASE_URL."wsp/js/jquery-1.5.2.min.js", "", true);
			JavaScriptInclude::getInstance()->add(BASE_URL."wsp/js/jquery-ui-1.8.12.custom.min.js", "", true);
		} else {
		?>

		<script type="text/javascript" src="http://www.google.com/jsapi"></script>
		<script type="text/javascript">
			// Load lib by google
			google.load("jquery", "1.5.2");
			google.load("jqueryui", "1.8.12");
		</script>
<?php
		}
		
		JavaScriptInclude::getInstance()->add(BASE_URL."wsp/js/jquery.cookie.js", "", true);
		JavaScriptInclude::getInstance()->add(BASE_URL."wsp/js/utils.js", "", true);
		JavaScriptInclude::getInstance()->add(BASE_URL."wsp/js/pngfix.js", "", true);
		
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
					$not_combine_js .= "<script type=\"text/javascript\" src=\"".$script."\">".JavaScriptInclude::getInstance()->getJsIncludeScript($i)."</script>\n";
				if ($conditional_comment != "") {
					$not_combine_js .= "<![endif]-->\n		"; 
				}
			}
		}
		if ($combine_js != "") {
			echo "		<script type=\"text/javascript\" src=\"".BASE_URL."combine-js/".str_replace("/", "|", $combine_js)."\"></script>\n";
		}
		if ($not_combine_js != "") {
			echo $not_combine_js;
		}
		if (DEBUG) {
			echo "<script type=\"text/javascript\" src=\"wsp/js/debug.js\"></script>";
		} 
		?>
		
		<script type="text/javascript">
			function windowHeaderTitle() {
				document.title = '<?php echo addslashes(str_replace("\n", "", str_replace("\r", "", str_replace("\t", "", html_entity_decode($current_page_title))))); ?>';
			}
		 	StkFunc(windowHeaderTitle);
			StkFunc(SaveDocumentSize);StkFuncOR(SaveDocumentSize);
			StkFunc(SaveWindowSize);StkFuncOR(SaveWindowSize);
		</script>
	</head>
	
	<noscript>
		<div style="width:100%;" align="center">
			<div style="width:80%;text-align:center;background-color:#FEEFB3;color:#9F6000;border: 1px solid;">
				<img src="<?php echo BASE_URL; ?>wsp/img/msg/warning.png" width="24" height="24" style="vertical-align:middle;">
				<?php echo __(JAVASCRIPT_NOT_ACTIVATE); ?>
			</div>
		</div>
	</noscript>
	<body>
		<?php if (GOOGLE_CODE_TRACKER != "" && find(BASE_URL, "127.0.0.1/", 0, 0) == 0 && find(BASE_URL, "localhost/", 0, 0) == 0 && !defined('GOOGLE_CODE_TRACKER_NOT_ACTIF')) { ?>
		<script type="text/javascript">
		  var _gaq = _gaq || [];
		  _gaq.push(['_setAccount', '<?php echo GOOGLE_CODE_TRACKER; ?>']);
		  <?php 
			if (SUBDOMAIN_URL != "") { 
				echo "_gaq.push(['_setDomainName', '".str_replace(SUBDOMAIN_URL, "", $_SERVER['SERVER_NAME'])."']);\n";
			} else {
				echo "_gaq.push(['_setDomainName', 'none']);\n";
			}
			?>
		  _gaq.push(['_setAllowLinker', true]);
		  _gaq.push(['_trackPageview']);
		
		  (function() {
		    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		  })();
		</script>
		<?php 
		}
		if (!isset($_SESSION['google_geolocalisation'])) {
			if (JQUERY_LOAD_LOCAL == true) {
		?>
		<script type="text/javascript" src="http://www.google.com/jsapi"></script>
		<?php
			}
		?>
		<script type="text/javascript">
			function loadGoogleClientLocation() {
				if(google.loader.ClientLocation) {
					$.ajax({type: 'GET', url: '<?php  echo BASE_URL; ?>wsp/includes/GoogleGeolocalisationSession.php?latitude='+google.loader.ClientLocation.latitude+'&longitude='+google.loader.ClientLocation.longitude+'&city='+google.loader.ClientLocation.address.city+'&country='+google.loader.ClientLocation.address.country+'&country_code='+google.loader.ClientLocation.address.country_code+'&region='+google.loader.ClientLocation.address.region });
				}
			}
			StkFunc(loadGoogleClientLocation);
		</script>
		<?php 
		} 
		?>
		
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
			echo str_replace("\n\n", "\n", str_replace("\r", "", str_replace("\t", "", $page_object->render())));
		?>
		<div align="center">
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
		echo $page_object->render();
	}
	
	// Disconnect DataBase
	if (DB_ACTIVE) {
		DataBase::getInstance()->disconnect();
	}
	unset($_SESSION['websitephp_register_object']);
?>
