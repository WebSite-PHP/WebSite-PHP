<?php
/**
 * PHP file pages\wsp-admin\disconnect.php
 */
/**
 * Page disconnect
 * URL: http://127.0.0.1/website-php/wsp-admin/disconnect.html
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

require_once(dirname(__FILE__)."/../../wsp/config/config_admin.inc.php");
define(GOOGLE_CODE_TRACKER_NOT_ACTIF, true);

class Disconnect extends Page {
	function __construct() {
		parent::__construct();
	}
	
	public function Load() {
		require_once(dirname(__FILE__)."/includes/utils-unset-var.inc.php");
		unsetWspAdminVariables();
		
		$this->setUserRights("");
		if (isset($_GET['referer'])) {
			$this->redirect(WSP_ADMIN_URL."/connect.html?referer=".urlencode($_GET['referer']));
		} else {
			$this->redirect(WSP_ADMIN_URL."/connect.html");
		}
	}
}
?>
