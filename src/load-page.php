<?php
	error_reporting(E_ALL);
	
	include_once("wsp/config/config.inc.php");
	include_once("wsp/includes/utils_session.inc.php");
	$__AJAX_PAGE__ = true; // use for return catch exception and loadAllVariables method
	$__AJAX_LOAD_PAGE__ = true;
	$__PAGE_IS_INIT__ = false;
	$__LOAD_VARIABLES__ = false;
	$__DEBUG_PAGE_IS_PRINTING__ = false;
	
	session_name(formalize_to_variable(SITE_NAME));  
	if (isset($_COOKIE['WSP_WS_SESSION'])) {
		session_id($_COOKIE['WSP_WS_SESSION']);
	} else {
		session_start();
	}
	
	if (!isset($_GET['p'])) {
		$_GET['p'] = "home"; 
	}
	$_SESSION['calling_page'] = $_GET['p'];
	if (!file_exists("pages/".$_GET['p'].".php")) {
		header('HTTP/1.1 404 Could not find page '.$_GET['p']);
		exit;
	}
	
	include("wsp/includes/init.inc.php");
	
	// Connect to the DataBase
	if (DB_ACTIVE) {
		if (!DataBase::getInstance()->connect()) {
			header('HTTP/1.1 500 Error : unable to connect to database.');
			exit;
		}
	}
	
	header("Expires: Sat, 05 Nov 2005 00:00:00 GMT");
	header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	if (isset($_GET['mime'])) {
		$mime_type = "text/".$_GET['mime'];
		if ($_GET['mime'] == "rss") {
			$mime_type = "application/rss+xml";
		} else if ($_GET['mime'] == "doc") {
			$mime_type = "application/doc";
		} else if ($_GET['mime'] == "xls") {
			$mime_type = "application/vnd.ms-excel";
		} else if ($_GET['mime'] == "pdf") {
			$mime_type = "application/pdf";
		} else if ($_GET['mime'] == "wsdl") {
			$mime_type = "text/xml";
		} else if ($_GET['mime'] == "php" || $_GET['mime'] == "do" || $_GET['mime'] == "call" || $_GET['mime'] == "xhtml" || $_GET['mime'] == "wsp") {
			$mime_type = "text/html";
		} else if ($_GET['p'] == "rss" || find($_GET['p'], "rss-", 0, 0) > 0) {
			$mime_type = "application/rss+xml";
		}
		header("Content-Type: ".$mime_type);
	}
	
	if ($_GET['mime'] == "wsdl") {
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
			header('HTTP/1.1 500 Error: You have no rights on the page '.$_GET['p']);
			exit;
		}
		
		if (!method_exists($page_object, "Load")) {
			header('HTTP/1.1 500 Error : function Load doesn\'t exists for the page '.$_GET['p']);
			exit;
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
			$page_object->Load();
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
			
			if ($mime_type == "text/html") {
				$idLoadPage = rand(0,999999);
?>
				<div align="center" id="idLoadPageLoadingPicture<?php echo $idLoadPage; ?>"><img src="<?php echo BASE_URL; ?>wsp/img/loading.gif"/></div>
				<div id="idLoadPageContent<?php echo $idLoadPage; ?>" style="display:none;">
<?php 
				// call current page page
				list($html_current_page, $javascript_current_page) = extractJavaScriptFromHtml($page_object->render());
				echo $html_current_page;
				
				$ind_load_js = rand(0, 99999999);
?>
			</div>
			<script type="text/javascript">
				lauchJavascriptPage_<?php echo $ind_load_js; ?> = function() {
					$('#idLoadPageLoadingPicture<?php echo $idLoadPage; ?>').attr('style', 'display:none;');
					$('#idLoadPageContent<?php echo $idLoadPage; ?>').attr('style', 'display:block;');
					setTimeout(lauchJavascriptPageExecute<?php echo $ind_load_js; ?>, 1);
				};
				lauchJavascriptPageExecute<?php echo $ind_load_js; ?> = function() {
<?php
					echo $javascript_current_page;
?>
				};
<?php
				$combine_css = "";
				$array_css = CssInclude::getInstance()->get();
				for ($i=0; $i < sizeof($array_css); $i++) {
					if (CssInclude::getInstance()->getCombine($i)) {
						if ($combine_css != "") { $combine_css .= ","; }
						$combine_css .= str_replace(BASE_URL."wsp/css/", "", str_replace(BASE_URL."css/", "", $array_css[$i]));
					} else {
						echo "			";
						$conditional_comment = CssInclude::getInstance()->getConditionalComment($i);
						if ($conditional_comment != "") { echo "<!--[if ".$conditional_comment."]>\n				"; }
						echo "loadDynamicCSS('".$array_css[$i]."');\n";
						if ($conditional_comment != "") { echo "			<![endif]-->\n"; }
					}
				}
				if ($combine_css != "") {
					echo "			loadDynamicCSS('".BASE_URL."combine-css/".str_replace("/", "|", $combine_css)."');\n";
				}
				
				$combine_js = "";
				$array_js = JavaScriptInclude::getInstance()->get();
				for ($i=0; $i < sizeof($array_js); $i++) {
					if (JavaScriptInclude::getInstance()->getCombine($i)) {
						if ($combine_js != "") { $combine_js .= ","; }
						$combine_js .= str_replace(BASE_URL."wsp/js/", "", str_replace(BASE_URL."js/", "", $array_js[$i]));
					} else {
						echo "			";
						$conditional_comment = JavaScriptInclude::getInstance()->getConditionalComment($i);
						if ($conditional_comment != "") { echo "<!--[if ".$conditional_comment."]>\n				"; }
							echo "loadDynamicJS('".$array_js[$i]."', ".$ind_load_js.");\n";
						if ($conditional_comment != "") {
							echo "			<![endif]-->\n"; 
						}
					}
				}
				if ($combine_js != "") {
					echo "			loadDynamicJS('".BASE_URL."combine-js/".str_replace("/", "|", $combine_js)."', ".$ind_load_js.");\n";
				}
?>
				waitForJsScripts(<?php echo $ind_load_js; ?>);
				LoadPngPicture();
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
		DataBase::getInstance()->disconnect();
	}
?>