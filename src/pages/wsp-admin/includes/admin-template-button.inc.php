<?php
/**
 * PHP file pages\wsp-admin\includes\admin-template-button.inc.php
 */
/**
 * Template for admin-template-button.inc
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
 * @since       1.0.99
 */

require_once(dirname(__FILE__)."/../../../wsp/config/config_admin.inc.php");
require_once(dirname(__FILE__)."/../../../lang/".$_SESSION['lang']."/wsp-admin/all.inc.php");
require_once(dirname(__FILE__)."/admin-menu.inc.php");
require_once(dirname(__FILE__)."/utils.inc.php");
require_once(dirname(__FILE__)."/utils-users.inc.php");
require_once(dirname(__FILE__)."/utils-version.inc.php");

class AdminTemplateButton extends DefinedZone {
	private $array_link_obj = array();
	
	function __construct($page_object, $menu_url) {
		parent::__construct();
		
		$wsp_admin_url = WSP_ADMIN_URL;
		$array_menu = xml2array(file_get_contents(dirname(__FILE__)."/../menu.xml"));
		foreach($array_menu['MenuItems']['MenuItem'] as $menuitems) {
			if ($menuitems['Menu_attr']['url'] == "\$wsp_admin_url/".$menu_url) {
				eval("\$icon_16 = \"".$menuitems['Menu_attr']['icon_16']."\";");
				if (find($menuitems['Menu_attr']['name'], "__(", 0, 0) > 0) {
					eval("\$page_title = ".$menuitems['Menu_attr']['name'].";");
				} else {
					eval("\$page_title = \"".$menuitems['Menu_attr']['name']."\";");
				}
				
				if ($menuitems['Menu_attr']['url'] == "\$wsp_admin_url/admin.html") {
					$menuitems = $array_menu;
				}
				
				if (!isset($menuitems['MenuItems']['MenuItem'][0])) {
					$sub_menuitems = $menuitems['MenuItems'];
				} else {
					$sub_menuitems = $menuitems['MenuItems']['MenuItem'];
				}
				foreach($sub_menuitems as $menuitem) {
					if ($menuitem['Menu_attr']['url'] != "\$wsp_admin_url/admin.html") {
						eval("\$sub_page_icon_64 = \"".$menuitem['Menu_attr']['icon_64']."\";");
						if (find($menuitem['Menu_attr']['name'], "__(", 0, 0) > 0) {
							eval("\$sub_page_title = ".$menuitem['Menu_attr']['name'].";");
						} else {
							eval("\$sub_page_title = \"".$menuitem['Menu_attr']['name']."\";");
						}
						eval("\$sub_page_link = \"".$menuitem['Menu_attr']['url']."\";");
						$this->addLink($sub_page_icon_64, $sub_page_title, $sub_page_link);
					}
				}
				break;
			}
		}
		
		if ($page_title == "" && $icon_16 == "") {
			throw new NewException("Administration page doesn't exists", 0, getDebugBacktrace(1));
		}
		
		$this->render = new Table();
		$this->render->setWidth("100%");
		$this->render->setDefaultAlign(RowTable::ALIGN_CENTER);
		
		$table = new Table();
		$table->setWidth("800");
		$table->setDefaultAlign(RowTable::ALIGN_LEFT);
		
		// Header
		$logo_pic = new Picture("img/wsp-admin/logo_60x160_".$_SESSION['lang'].".png", 60, 160, 0);
		$table->addRowColumns(new AdminMenu($page_object, $array_menu), new Link("http://www.website-php.com", Link::TARGET_BLANK, $logo_pic))->setColumnAlign(2, RowTable::ALIGN_RIGHT);
		
		// check WSP version
		$alert_version_obj = getAlertVersiobObject($page_object);
		if ($alert_version_obj != null) {
			$table->addRowColumns($alert_version_obj)->setColspan(2);
		}
		
		// Main
		$small_img = new Picture($icon_16, 16, 16, 0, Picture::ALIGN_ABSMIDDLE);
		$title_header = new Object($small_img);
		if ($page_title == __(ADMIN)) {
			$title_header->add($page_title);
		} else {
			$title_header->add(new Object(new Link(WSP_ADMIN_URL."/admin.html", Link::TARGET_NONE, __(ADMIN)), " > ", $page_title));
		}
		
		$admin_box = new Box($title_header, true, Box::STYLE_SECOND, Box::STYLE_SECOND, "", "admin_box", 800);
		$admin_obj = new Object("<br/>");
		
		$admin_obj->add(createTableFirstPagePic64($this->array_link_obj), "<br/><br/>");
		$admin_box->setContent($admin_obj);
		
		$table->addRow($admin_box)->setColspan(2);
		$this->render->addRow($table);
		$this->render->addRow(__(CURRENT_WSP_VERSION, getCurrentWspVersion()));
	}
	
	private function addLink($pic_64, $label, $url) {
		$link_pic = new Object(new Picture($pic_64, 64, 64), "<br/>", $label);
		$this->array_link_obj[] = new Link($url, Link::TARGET_NONE, $link_pic);
	}
}
?>
