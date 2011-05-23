<?php
/**
 * PHP file pages\wsp-admin\admin.php
 */
/**
 * Page admin
 * URL: http://127.0.0.1/website-php/wsp-admin/admin.html
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
 * @version     1.0.79
 * @access      public
 * @since       1.0.25
 */

require_once(dirname(__FILE__)."/includes/utils.inc.php");
require_once(dirname(__FILE__)."/includes/admin-template-button.inc.php");

class Admin extends Page {
	protected $USER_RIGHTS = "administrator";
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
