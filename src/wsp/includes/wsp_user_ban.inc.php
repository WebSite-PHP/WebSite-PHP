<?php
/**
 * PHP file wsp\includes\wsp_user_ban.inc.php
 */
/**
 * WebSite-PHP file wsp_user_ban.inc.php
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
 * @since       1.0.103
 */

	if (WspBannedVisitors::isBannedIp($_SERVER["REMOTE_ADDR"])) {
		$_GET['p'] = "error/error-user-ban";
	}
?>
