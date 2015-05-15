<?php
/**
 * PHP file pages\wsp-admin\config\configure-modules.php
 */
/**
 * Content of the Page configure-modules
 * URL: http://127.0.0.1/website-php-install/wsp-admin/config/configure-modules.html
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
 * @since       1.0.85
 */

require_once(dirname(__FILE__)."/../includes/admin-template-form.inc.php");

class ConfigureModules extends Page {
	protected $USER_RIGHTS = Page::RIGHTS_ADMINISTRATOR;
	protected $USER_NO_RIGHTS_REDIRECT = "wsp-admin/admin.html";
	
	function __construct() {
		parent::__construct();
	}
	
	public function Load() {
		parent::$PAGE_TITLE = __(CONFIGURE_MODULES);
		
		$config_modules_obj = new Object();
		
		$construction_page = new Object(__(PAGE_IN_CONSTRUCTION));
		$construction_page->setClass("warning");
		$config_modules_obj->add($construction_page);
		
		$config_modules_obj->add("<br/>", __(PRESENTATION), "<br/><br/>");
		
		$sort_event_install = new SortableEvent($this);
		$sort_event_install->onSort("onChangeModule")->setAjaxEvent()->disableAjaxWaitMessage();
		
		$this->list_install_modules_obj = new Object();
		$this->list_install_modules_obj->setId("list_install_modules");
		$this->list_install_modules_obj->setSortable(true, $sort_event_install);
		$list_all_install_modules_obj = new Object();
		
		$module_style = "cursor:pointer;width:100px;border:1px solid gray;padding:2px;margin:2px;";
		
		$array_active_modules = array();
		$module_file = new File(dirname(__FILE__)."/../../../wsp/config/modules.cnf");
		while (($line = $module_file->read_line()) != false) {
			if (trim($line) != "") {
				$array_active_modules[] = trim($line);
				
				$module_obj = new Object(trim($line));
				$module_obj->setId("module_".str_replace("-", "_", trim($line)))->forceDivTag();
				if (trim($line) != "Authentication") {
					$module_obj->setStyle($module_style);
					$module_obj->setDraggable(true, false, null, true);
					$this->list_install_modules_obj->add($module_obj);
				} else {
					$module_obj->setStyle($module_style."cursor:none;");
					$list_all_install_modules_obj->add($module_obj);
				}
			}
		}
		$module_file->close();
		$list_all_install_modules_obj->add($this->list_install_modules_obj);
		
		$sort_event = new SortableEvent($this);
		$sort_event->onSort("onChangeModule")->setAjaxEvent()->disableAjaxWaitMessage();
		
		$this->list_modules_obj = new Object();
		$this->list_modules_obj->setId("list_modules");
		$this->list_modules_obj->setSortable(true, $sort_event);
		
		$folder = dirname(__FILE__)."/../../../wsp/class/modules";
		$array_module_dir = scandir($folder);
		for ($i=0; $i < sizeof($array_module_dir); $i++) {
			if (is_dir($folder."/".$array_module_dir[$i]) && !in_array($array_module_dir[$i], $array_active_modules) &&
				$array_module_dir[$i] != "." && $array_module_dir[$i] != ".." && $array_module_dir[$i] != ".svn") {
					$module_obj = new Object($array_module_dir[$i]);
					$module_obj->setId("module_".str_replace("-", "_", $array_module_dir[$i]))->forceDivTag();
					$module_obj->setDraggable(true, false, null, true)->setStyle($module_style);
					$this->list_modules_obj->add($module_obj);
			}
		}
		
		$config_table = new Table();
		$config_table->setWidth(400)->setDefaultAlign(RowTable::ALIGN_CENTER);
		$config_table->setDefaultValign(RowTable::VALIGN_TOP);
		$config_table->addRowColumns(new Object(new Label(__(ALL_MODULES), true), "<br/>", $this->list_modules_obj), "&nbsp;", 
									new Object(new Label(__(INSTALLED_MODULES), true), "<br/>", $list_all_install_modules_obj));
		
		$config_modules_obj->add($config_table, "<br/><br/>");
		
		$this->render = new AdminTemplateForm($this, $config_modules_obj);
	}
	
	public function onChangeModule($sender, $moved_object, $from_object, $to_object, $position) {
		if ($from_object->getId() != $to_object->getId()) {
			$new_conf_module_data = "";
			$module_file = new File(dirname(__FILE__)."/../../../wsp/config/modules.cnf");
			if ($this->list_modules_obj->getId() == $to_object->getId()) { // remove
				while (($line = $module_file->read_line()) != false) {
					if (trim($line) != "" && trim($line) != str_replace("_", "-", str_replace("wsp_object_module_", "", $moved_object->getId()))) {
						$new_conf_module_data .= trim($line)."\n";
					}
				}
			} else if ($this->list_install_modules_obj->getId() == $to_object->getId()) { // add
				while (($line = $module_file->read_line()) != false) {
					if (trim($line) != "") {
						$new_conf_module_data .= trim($line)."\n";
					}
				}
				$new_conf_module_data .= str_replace("_", "-", str_replace("wsp_object_module_", "", $moved_object->getId()))."\n";
			}
			$module_file->close();
			
			if ($new_conf_module_data != "") {
				$module_file = new File(dirname(__FILE__)."/../../../wsp/config/modules.cnf", false, true);
				$module_file->write($new_conf_module_data);
				$module_file->close();
			}
		}
	}
}
?>
