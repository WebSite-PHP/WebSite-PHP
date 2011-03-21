<?php
/**
 * PHP file pages\error\error-page.php
 */
/**
 * Page error-page
 * URL: http://127.0.0.1/website-php/error/error-page.html
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
 * @copyright   WebSite-PHP.com 03/10/2010
 * @version     1.0.62
 * @access      public
 * @since       1.0.18
 */

require_once(dirname(__FILE__)."/error-template.php");

class ErrorPage extends Page {
	function __construct() {}
	
	public function Load() {
		parent::$PAGE_TITLE = __(ERROR_PAGE)." - ".SITE_NAME;
		
		$obj_error_msg = new Object(new Picture("wsp/img/warning.png", 48, 48, 0, "absmidlle"), "<br/>", new Label(__(ERROR_PAGE_MSG, $_SESSION['calling_page'].".php")));
		$obj_error_msg->add("<br/><br/>", __(MAIN_PAGE_GO_BACK), new Link(BASE_URL, Link::TARGET_NONE, SITE_NAME));
		
		$this->render = new ErrorTemplate($this, $obj_error_msg, __(ERROR_PAGE));
	}
}
?>
