<?php
/**
 * PHP file wsp\includes\utils_session.inc.php
 */
/**
 * WebSite-PHP file utils_session.inc.php
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2013 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 18/02/2013
 * @version     1.2.2
 * @access      public
 * @since       1.0.0
 */

	include_once("utils2.inc.php");

	function formalize_to_variable($txt) {
		$txt = url_rewrite_format($txt);
		return strtolower(str_replace("-", "_", $txt));
	}
?>
