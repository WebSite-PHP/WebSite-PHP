<?php
/**
 * Description of PHP file pages\home.php
 * Page home
 * URL: http://127.0.0.1/website-php-install/home.html
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
 * @copyright   WebSite-PHP.com 21/07/2010
 *
 * @version     1.0.30
 * @access      public
 * @since       1.0.27
 */

require_once("wsp-admin/includes/utils.inc.php");

class Home extends Page {
	function __construct() {
		parent::__construct();
	}
	
	public function Load() {
		parent::$PAGE_TITLE = __(HOME_PAGE_TITLE);
		
		// Welcome message
		$small_img = new Picture("img/logo_16x16.png", 16, 16, 0, Picture::ALIGN_ABSMIDDLE);
		$title_header = new Object($small_img, __(WELCOME));
		
		$welcome_box = new Box($title_header, true, Box::STYLE_SECOND, Box::STYLE_SECOND, "", "welcome_box", 600);
		$welcome_obj = new Object(new Label(__(WELCOME_MSG), true));
		
		list($strAdminLogin, $strAdminPasswd, $strAdminRights) = getWspUserRightsInfo("admin");
		
		if ($strAdminLogin == "admin" && $strAdminPasswd==sha1("admin")) {
			$finalize = new Font(__(FINALIZE_INSTALL));
			$finalize->setFontColor("red");
			$finalize->setFontWeight(Font::FONT_WEIGHT_BOLD);
			
			$connect_obj = new Object(new LinkPage("wsp-admin/connect", __(CONNECT), "img/wsp-admin/admin_16.png"));
			
			$connect_box = new RoundBox(RoundBox::STYLE_SECOND, "connect_box", 280);
			$connect_box->setValign(RoundBox::VALIGN_CENTER);
			$connect_box->setContent($connect_obj);
			
			$welcome_obj->add("<br/>", $finalize, "<br/><br/>", $connect_box, __(CONNECT_DEFAULT_PASSWD), "<br/><br/>");
		} else {
			$connect_obj = new Object(new LinkPage("wsp-admin/connect", __(CONNECT), "img/wsp-admin/admin_16.png"));
			$connect_box = new RoundBox(RoundBox::STYLE_SECOND, "connect_box", 280);
			$connect_box->setValign(RoundBox::VALIGN_CENTER);
			$connect_box->setContent($connect_obj);
			
			$welcome_obj->add($connect_box, "<br/>");
		}
		
		$welcome_box->setContent($welcome_obj);
		
		// Footer
		$this->render= new Template($this, $welcome_box);
	}
}
?>
