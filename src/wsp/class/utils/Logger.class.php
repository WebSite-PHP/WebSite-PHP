<?php
/**
 * PHP file wsp\class\utils\Logger.class.php
 * @package utils
 */
/**
 * Class Logger
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2015 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package utils
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 12/05/2015
 * @version     1.2.13
 * @access      public
 * @since       1.1.12
 */


class Logger extends JavaScript {
	
	private static $instance = null ;
	private static $anchorPage ;
	
	/**
	 * Constructor Logger
	 */
	function __construct() {
		$this->anchorPage = Page::getInstance($_GET['p']);
		JavaScriptInclude::getInstance()->add("wsp/js/consolelogger.js", "", true);
	}
	
	/**
	 * Method getInstance
	 * @access static
	 * @return mixed
	 * @since 1.1.12
	 */
	public static function getInstance()
	{
		if (is_null(self::$instance))
		{
			self::$instance = new self();
		}
		
		return self::$instance;
	}
	
	public function info($msg)
	{	
		$this->anchorPage->addObject(new JavaScript('consoleinfo("'.addslashes($msg).'");'));
	}
	
	public function error($msg)
	{
		$this->anchorPage->addObject(new JavaScript('consoleerror("'.addslashes($msg).'");'));
	}
	
	public function warn($msg)
	{
		$this->anchorPage->addObject(new JavaScript('consolewarn("'.addslashes($msg).'");'));
	}
}
?>
