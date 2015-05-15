<?php 
/**
 * PHP file pages\wsp-admin\includes\admin-menu.inc.php
 */
/**
 * Class to create admin-menu.inc
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
 * @since       1.2.10
 */

require_once(dirname(__FILE__)."/../../../wsp/config/config_admin.inc.php");
require_once(dirname(__FILE__)."/utils.inc.php");
define(GOOGLE_CODE_TRACKER_NOT_ACTIF, true);

class AdminMenu extends DefinedZone {
	function __construct($page_object, $array_menu) {
		parent::__construct();
		
		$this->render = new Menu();
		
		$wsp_admin_url = WSP_ADMIN_URL;
		$menu_items = new MenuItems();
		foreach($array_menu['MenuItems']['MenuItem'] as $menuitems) {
			eval("\$page_icon_16 = \"".$menuitems['Menu_attr']['icon_16']."\";");
			if (find($menuitems['Menu_attr']['name'], "__(", 0, 0) > 0) {
				eval("\$page_title = ".$menuitems['Menu_attr']['name'].";");
			} else {
				eval("\$page_title = \"".$menuitems['Menu_attr']['name']."\";");
			}
			eval("\$page_link = \"".$menuitems['Menu_attr']['url']."\";");
			if ($menuitems['Menu_attr']['url'] == "\$wsp_admin_url/admin.html") {
				$page_title = "";
			}
			$menu_item = new MenuItem($page_title, $page_link, $page_icon_16);
			if (isset($_GET['menu'])) {
				if ($page_link == $wsp_admin_url."/admin.html?menu=".$_GET['menu']) {
					$menu_item->setCurrent();
				}
			}
			$menu_items->add($menu_item);
			
			$sub_menu_items = new MenuItems();
			if (!isset($menuitems['MenuItems']['MenuItem'][0])) {
				$sub_menuitems = $menuitems['MenuItems'];
			} else {
				$sub_menuitems = $menuitems['MenuItems']['MenuItem'];
			}
			$nb_sub_menu = 0;
			foreach($sub_menuitems as $menuitem) {
				eval("\$page_icon_16 = \"".$menuitem['Menu_attr']['icon_16']."\";");
				if (find($menuitem['Menu_attr']['name'], "__(", 0, 0) > 0) {
					eval("\$page_title = ".$menuitem['Menu_attr']['name'].";");
				} else {
					eval("\$page_title = \"".$menuitem['Menu_attr']['name']."\";");
				}
				eval("\$page_link = \"".$menuitem['Menu_attr']['url']."\";");
				$sub_menu_item = new MenuItem($page_title, $page_link, $page_icon_16);
				if ($page_link == $_GET['p'].".html") {
					$sub_menu_item->setCurrent();
					$menu_item->setCurrent();
				}
				$sub_menu_items->add($sub_menu_item);
				$nb_sub_menu++;
			}
			if ($nb_sub_menu > 0) {
				$menu_item->setMenuItems($sub_menu_items);
			}
		}
		
		$this->render->setMenuItems($menu_items);
		$this->render->activateSupersubs();
		
		list($strAdminLogin, $strAdminPasswd, $strAdminRights) = getWspUserRightsInfo("admin");
		if ($strAdminLogin == "admin" && $strAdminPasswd==sha1("admin")) {
			$modalbox = new DialogBox(__(CHANGE_PASSWD), new Url($page_object->getBaseLanguageURL()."wsp-admin/change-passwd.call"));
			$modalbox->modal()->setWidth(400);
			$page_object->addObject($modalbox);
		}
	}
}
?>
