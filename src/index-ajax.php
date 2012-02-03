<?php
/**
 * PHP file index-ajax.php
 */
/**
 * Entry point of all AJAX requests
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2012 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 26/05/2011
 * @version     1.0.103
 * @access      public
 * @since       1.0.0
 */

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
	
	if (!method_exists($page_object, "Load") && !method_exists($page_object, "InitializeComponent")) {
		header('HTTP/1.1 500 Internal Server Error');
		echo 'Function Load or InitializeComponent doesn\'t exists for the page '.$_GET['p'];
		exit;
	}
	
	if (method_exists($page_object, "InitializeComponent")) {
		$page_object->InitializeComponent();
	}
	if (method_exists($page_object, "Load")) {
		$page_object->Load();
	}
	
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
	
	$add_to_render = $page_object->getBeginAddedObjects();
	for ($i=0; $i < sizeof($add_to_render); $i++) {
		if (gettype($add_to_render[$i]) == "object") {
			$ajax_render = str_replace("{#BASE_URL#}", BASE_URL, str_replace("{#QUOTE#}", "\"", str_replace("{#SIMPLE_QUOTE#}", "'", $add_to_render[$i]->getAjaxRender())));
			if ($ajax_render != "") {
				$array_ajax_object_render[] = $ajax_render;
			}
		}
	}
	
	$register_objects = WebSitePhpObject::getRegisterObjects();
	for ($i=0; $i < sizeof($register_objects); $i++) {
		$object = $register_objects[$i];
		if ($object->isObjectChange() && get_class($object) != "DialogBox" && get_class($object) != "JavaScript") {
			$ajax_render = str_replace("{#BASE_URL#}", BASE_URL, str_replace("{#QUOTE#}", "\"", str_replace("{#SIMPLE_QUOTE#}", "'", $object->getAjaxRender())));
			if ($ajax_render != "") {
				$array_ajax_object_render[] = $ajax_render;
			}
		}
		$register_objects = WebSitePhpObject::getRegisterObjects();
	}
	
	$add_to_render = $page_object->getEndAddedObjects();
	for ($i=0; $i < sizeof($add_to_render); $i++) {
		if (gettype($add_to_render[$i]) == "object") {
			$ajax_render = str_replace("{#BASE_URL#}", BASE_URL, str_replace("{#QUOTE#}", "\"", str_replace("{#SIMPLE_QUOTE#}", "'", $add_to_render[$i]->getAjaxRender())));
			if ($ajax_render != "") {
				$array_ajax_object_render[] = $ajax_render;
			}
		}
		if ($page_object->getNbEndAddedObjects() > $nb_end_added_object) {
			$add_to_render = $page_object->getEndAddedObjects();
			$nb_end_added_object = $page_object->getNbEndAddedObjects();
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
			$array_ajax_object_render[] = str_replace("{#BASE_URL#}", BASE_URL, str_replace("{#QUOTE#}", "\"", str_replace("{#SIMPLE_QUOTE#}", "'", $debug_dialogbox->getAjaxRender())));
		}
	}
	
	$array_ajax_object_render[] = "window.scrollTo(wsp_save_hscroll, wsp_save_vscroll);";
	echo str_replace("\n\n", "\n", str_replace("\r", "", str_replace("\t", "", json_encode($array_ajax_object_render))));
	
	// Disconnect DataBase
	if (DB_ACTIVE) {
		DataBase::getInstance(false)->disconnect();
	}
	unset($_SESSION['websitephp_register_object']);
?>
