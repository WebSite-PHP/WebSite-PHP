<?php
/**
 * PHP file pages\wsp-admin\admin.php
 */
/**
 * Page admin
 * URL: http://127.0.0.1/website-php/wsp-admin/admin.html
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
 * @since       1.0.25
 */

require_once(dirname(__FILE__)."/includes/utils.inc.php");
require_once(dirname(__FILE__)."/includes/admin-template-button.inc.php");

class Admin extends Page {
	protected $USER_RIGHTS = array(Page::RIGHTS_ADMINISTRATOR, Page::RIGHTS_MODERATOR, Page::RIGHTS_TRANSLATOR, Page::RIGHTS_DEVELOPER);
	protected $USER_NO_RIGHTS_REDIRECT = "wsp-admin/connect.html";
	
	function __construct() {
		parent::__construct();
	}
	
	public function Load() {
		parent::$PAGE_TITLE = __(ADMIN);
		
		// Admin
		$this->render = new AdminTemplateButton($this, ($_GET[menu]=="")?"admin.html":"admin.html?menu=".$_GET[menu]);
	}
}
?>
