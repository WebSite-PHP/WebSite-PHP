<?php
/**
 * PHP file pages\home.php
 */
/**
 * Page home
 * URL: http://127.0.0.1/website-php-install/home.html
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2014 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 10/11/2014
 * @version     1.2.10
 * @access      public
 * @since       1.0.51
 */

include(dirname(__FILE__)."/../wsp/config/config_admin.inc.php");
require_once(WSP_ADMIN_URL."/includes/utils-users.inc.php");

class Home extends Page {
	public function Load() {
		parent::$PAGE_TITLE = __(HOME_PAGE_TITLE);
		
		// Welcome message
		$small_img = new Picture("img/logo_16x16.png", 16, 16, 0, Picture::ALIGN_ABSMIDDLE);
		$title_header = new Object($small_img, __(WELCOME));
		
		$welcome_box = new Box($title_header, true, Box::STYLE_SECOND, Box::STYLE_SECOND, "", "welcome_box", 600);
		$welcome_obj = new Object(__(WELCOME_MSG));
		
		list($strAdminLogin, $strAdminPasswd, $strAdminRights) = getWspUserRightsInfo("admin");
		
		$quickstart_obj = new Object(new Picture("img/quickstart_128.png", 64, 64), "<br/>", __(QUICKSTART));
		$quickstart_link = new Link("http://www.website-php.com/".$this->getLanguage()."/quick-start.html", Link::TARGET_BLANK, $quickstart_obj);
		$quickstart_box = new RoundBox(3, "quickstart_box", 120, 120);
		$quickstart_box->setValign(RoundBox::VALIGN_CENTER);
		$quickstart_box->setContent($quickstart_link);
		
		$tutorial_obj = new Object(new Picture("img/tutorials_128.png", 64, 64), "<br/>", __(TUTORIALS));
		$tutorial_link = new Link("http://www.website-php.com/".$this->getLanguage()."/tutorials.html", Link::TARGET_BLANK, $tutorial_obj);
		$tutorial_box = new RoundBox(3, "tutorial_box", 120, 120);
		$tutorial_box->setValign(RoundBox::VALIGN_CENTER);
		$tutorial_box->setContent($tutorial_link);
		
		$connect_obj = new Object(new Picture("img/wsp-admin/admin_128.png", 64, 64), "<br/>", __(CONNECT));
		$connect_link = new Link("wsp-admin/connect.html", Link::TARGET_BLANK, $connect_obj);
		$connect_box = new RoundBox(3, "connect_box", 120, 120);
		$connect_box->setValign(RoundBox::VALIGN_CENTER);
		$connect_box->setContent($connect_link);
		
		$icon_table = new Table();
		$icon_table->setDefaultAlign(RowTable::ALIGN_CENTER)->setDefaultValign(RowTable::VALIGN_TOP);
		$icon_row = $icon_table->addRowColumns($quickstart_box, "&nbsp;", $tutorial_box, "&nbsp;", $connect_box);
		$icon_row->setColumnWidth(5, 120);
		
		if ($strAdminLogin == "admin" && $strAdminPasswd==sha1("admin")) {
			$finalize = new Font(__(FINALIZE_INSTALL));
			$finalize->setFontColor("red");
			$finalize->setFontWeight(Font::FONT_WEIGHT_BOLD);
			
			$welcome_obj->add("<br/>", $finalize, "<br/>", __(CONNECT_DEFAULT_PASSWD), "<br/>");
		}
		$welcome_obj->add("<br/>", $icon_table);
		
		$welcome_box->setContent($welcome_obj);
		
		// Footer
		$this->render= new Template($welcome_box);
	}
}
?>
