<?php
/**
 * PHP file pages\wsp-admin\disconnect.php
 */
/**
 * Page disconnect
 * URL: http://127.0.0.1/website-php/wsp-admin/disconnect.html
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
 * @version     1.0.77
 * @access      public
 * @since       1.0.25
 */

define(GOOGLE_CODE_TRACKER_NOT_ACTIF, true);

class Disconnect extends Page {
	function __construct() {
		parent::__construct();
	}
	
	public function Load() {
		require_once(dirname(__FILE__)."/includes/utils-unset-var.inc.php");
		unsetWspAdminVariables();
		
		$this->setUserRights("");
		$this->redirect("connect.html");
	}
}
?>
