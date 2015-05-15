<?php
/**
 * PHP file wsp\includes\utils_logger.inc.php
 */
/**
 * WebSite-PHP file utils_logger.inc.php
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
 * @since       1.1.12
 */

	function alert($text) {
		$page_object = Page::getInstance($_GET['p']);
		$page_object->addObject(new DialogBox("Alert", $text));
	}
	
	function logConsoleInfo($msg) {
		Logger::getInstance()->info($msg);
	}
	
	function logConsoleError($msg) {
		Logger::getInstance()->error($msg);
	}
	
	function logConsoleWarn($msg) {
		Logger::getInstance()->warn($msg);
	}
?>
