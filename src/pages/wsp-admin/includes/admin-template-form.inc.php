<?php
/**
 * PHP file pages\wsp-admin\includes\admin-template-form.inc.php
 */
/**
 * Template for admin-template-form.inc
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
 * @since       1.0.89
 */

require_once(dirname(__FILE__)."/../../../lang/".$_SESSION['lang']."/wsp-admin/all.inc.php");
require_once(dirname(__FILE__)."/admin-menu.inc.php");
require_once(dirname(__FILE__)."/utils.inc.php");
require_once(dirname(__FILE__)."/utils-users.inc.php");
require_once(dirname(__FILE__)."/utils-version.inc.php");

class AdminTemplateForm extends DefinedZone {
	function __construct($page_object, $content, $right_side_content=null) {
		parent::__construct();
		
		$page_object->includeJsAndCssFromObjectToPage("LiveValidation");
		
		$this->render = new Table();
		$this->render->setWidth("100%");
		$this->render->setDefaultAlign(RowTable::ALIGN_CENTER);
		
		$table = new Table();
		$table->setWidth("800");
		$table->setDefaultAlign(RowTable::ALIGN_LEFT);
		
		// search parent link and current page icon, name
		$pathway = "";
		$page_icon_16 = "";
		$wsp_admin_url = WSP_ADMIN_URL;
		$array_menu = xml2array(file_get_contents(dirname(__FILE__)."/../menu.xml"));
		foreach($array_menu['MenuItems']['MenuItem'] as $menuitems) {
			if (find($menuitems['Menu_attr']['name'], "__(", 0, 0) > 0) {
				eval("\$page_title = ".$menuitems['Menu_attr']['name'].";");
			} else {
				eval("\$page_title = \"".$menuitems['Menu_attr']['name']."\";");
			}
			eval("\$page_link = \"".$menuitems['Menu_attr']['url']."\";");
			
			if (!isset($menuitems['MenuItems']['MenuItem'][0])) {
				$sub_menuitems = $menuitems['MenuItems'];
			} else {
				$sub_menuitems = $menuitems['MenuItems']['MenuItem'];
			}
			foreach($sub_menuitems as $menuitem) {
				eval("\$sub_page_link = \"".$menuitem['Menu_attr']['url']."\";");
				if ($sub_page_link == $_GET['p'].".html") {
					eval("\$page_icon_16 = \"".$menuitem['Menu_attr']['icon_16']."\";");
					if (find($menuitem['Menu_attr']['name'], "__(", 0, 0) > 0) {
						eval("\$sub_page_title = ".$menuitem['Menu_attr']['name'].";");
					} else {
						eval("\$sub_page_title = \"".$menuitem['Menu_attr']['name']."\";");
					}
					$pathway = new Object(new Link($page_link, Link::TARGET_NONE, $page_title), " > ", $sub_page_title);
					break;
				}
			}
			if ($pathway != "") {
				break;
			}
		}
		
		// Header
		$logo_pic = new Picture("img/wsp-admin/logo_60x160_".$_SESSION['lang'].".png", 60, 160, 0);
		$table->addRowColumns(new AdminMenu($page_object, $array_menu), new Link("http://www.website-php.com", Link::TARGET_BLANK, $logo_pic))->setColumnAlign(2, RowTable::ALIGN_RIGHT);

		// check WSP version
		$alert_version_obj = getAlertVersiobObject($page_object);
		if ($alert_version_obj != null) {
			$table->addRowColumns($alert_version_obj)->setColspan(2);
		}
		
		// Main
		$small_img = new Picture($page_icon_16, 16, 16, 0, Picture::ALIGN_ABSMIDDLE);
		$title_header = new Object($small_img);
		$title_header->add(new Object(new Link("wsp-admin/admin.html", Link::TARGET_NONE, __(ADMIN)), " > ", $pathway));
		
		$box_width = 800;
		if ($right_side_content != null) {
			$box_width = 700;
		}
		$configure_box = new Box($title_header, true, Box::STYLE_SECOND, Box::STYLE_SECOND, "", "configure_database_box", $box_width);
		$configure_box->setContent($content);
		
		if ($right_side_content != null) {
			$table->addRowColumns($configure_box, "&nbsp;", $right_side_content)->setColumnColspan(1, 2)->setColumnWidth(1, $box_width)->setColumnWidth(2, 10);
		} else {
			$table->addRow($configure_box)->setColspan(2);
		}
		
		$this->render->addRow($table);
		$this->render->addRow(__(CURRENT_WSP_VERSION, getCurrentWspVersion()));
	}
}
?>
