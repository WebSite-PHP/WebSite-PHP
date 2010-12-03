<?php
	error_reporting(E_ALL);
	
	include_once("wsp/config/config.inc.php");
	include_once("wsp/includes/utils_session.inc.php");
	$__AJAX_PAGE__ = true; // use for return catch exception and loadAllVariables method
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
	
	header("Expires: Sat, 05 Nov 2005 00:00:00 GMT");
	header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	
	if (!file_exists("pages/".$_GET['p'].".php")) {
		header('HTTP/1.1 404 Could not find page '.$_GET['p']);
		exit;
	}
	
	include("wsp/includes/init.inc.php");
	include("wsp/includes/utils_ajax.inc.php");
	
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
	
	// Connect to the DataBase
	if (DB_ACTIVE) {
		if (!DataBase::getInstance()->connect()) {
			header('HTTP/1.1 500 Error : unable to connect to database.');
			exit;
		}
	}
	
	if (method_exists($page_object, "InitializeComponent")) {
		$page_object->InitializeComponent();
	}
	$page_object->Load();
	
	// set GET and POST data to the current page
	$page_object->loadAllVariables();
	$__PAGE_IS_INIT__ = true;
	
	// execute callback method
	$page_object->executeCallback();
	
	// call the display method
	if (method_exists($page_object, "Loaded")) {
		$page_object->Loaded();
	}
	
	// create current page ajax return
	$__PAGE_IS_INIT__ = false; // desactivate change log
	$array_ajax_object_render = array();
	$save_scroll_position = "var wsp_save_hscroll = f_scrollLeft();";
	$save_scroll_position .= "var wsp_save_vscroll = f_scrollTop();";
	$array_ajax_object_render[0] = $save_scroll_position;
	$register_objects = WebSitePhpObject::getRegisterObjects();
	for ($i=0; $i < sizeof($register_objects); $i++) {
		$object = $register_objects[$i];
		if ($object->isObjectChange() && get_class($object) != "DialogBox") {
			$ajax_render = str_replace("{#QUOTE#}", "\"", str_replace("{#SIMPLE_QUOTE#}", "'", $object->getAjaxRender()));
			if ($ajax_render != "") {
				$array_ajax_object_render[] = $ajax_render;
			}
		}
		$register_objects = WebSitePhpObject::getRegisterObjects();
	}
	
	$add_to_render = $page_object->getAddedObjects();
	for ($i=0; $i < sizeof($add_to_render); $i++) {
		if (gettype($add_to_render[$i]) == "object") {
			$ajax_render = str_replace("{#QUOTE#}", "\"", str_replace("{#SIMPLE_QUOTE#}", "'", $add_to_render[$i]->getAjaxRender()));
			if ($ajax_render != "") {
				$array_ajax_object_render[] = $ajax_render;
			}
		}
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
			$array_ajax_object_render[] = str_replace("{#QUOTE#}", "\"", str_replace("{#SIMPLE_QUOTE#}", "'", $debug_dialogbox->getAjaxRender()));
		}
	}
	
	$array_ajax_object_render[] = "window.scrollTo(wsp_save_hscroll, wsp_save_vscroll);";
	echo json_encode($array_ajax_object_render);
	
	// Disconnect DataBase
	if (DB_ACTIVE) {
		DataBase::getInstance()->disconnect();
	}
?>