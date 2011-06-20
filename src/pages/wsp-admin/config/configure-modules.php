<?php
/**
 * PHP file pages\wsp-admin\config\configure-modules.php
 */
/**
 * Content of the Page configure-modules
 * URL: http://127.0.0.1/website-php-install/wsp-admin/config/configure-modules.html
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
 * @copyright   WebSite-PHP.com 06/06/2011
 * @version     1.0.87
 * @access      public
 * @since       1.0.85
 */

require_once(dirname(__FILE__)."/../includes/admin-template-form.inc.php");

class ConfigureModules extends Page {
	protected $USER_RIGHTS = "administrator";
	protected $USER_NO_RIGHTS_REDIRECT = "wsp-admin/connect.html";
	
	function __construct() {
		parent::__construct();
	}
	
	public function Load() {
		parent::$PAGE_TITLE = __(CONFIGURE_USERS);
		
		$config_modules_obj = new Object();
		
		$construction_page = new Object(__(PAGE_IN_CONSTRUCTION));
		$construction_page->setClass("error");
		$config_modules_obj->add($construction_page);
		
		$config_modules_obj->add("<br/>", __(PRESENTATION), "<br/><br/>");
		
		$this->render = new AdminTemplateForm($this, $config_modules_obj);
	}
}
?>
