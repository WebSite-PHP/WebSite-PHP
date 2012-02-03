<?php
/**
 * PHP file wsp\includes\wsp_user_ban.inc.php
 */
/**
 * WebSite-PHP file wsp_user_ban.inc.php
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2012 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 02/02/2012
 * @version     1.0.103
 * @access      public
 * @since       1.0.103
 */

	$array_wsp_banned_users = SharedMemory::get("wsp_banned_users");
	if ($array_wsp_banned_users == null) {
		$array_wsp_banned_users = array();
	}
	if (!defined('MAX_BAD_URL_BEFORE_BANNED')) {
		define("MAX_BAD_URL_BEFORE_BANNED", 4);
	}
	if ($array_wsp_banned_users[$_SERVER["REMOTE_ADDR"]] >= MAX_BAD_URL_BEFORE_BANNED) {
		$_GET['p'] = "error/error-user-ban";
	}
?>
