<?php
/**
 * PHP file wsp\class\display\Url.class.php
 * @package display
 */
/**
 * Class Url
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2011 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package display
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 26/05/2011
 * @version     1.0.99
 * @access      public
 * @since       1.0.17
 */

class Url extends WebSitePhpObject {
	/**#@+
	* @access private
	*/
	private $url = "http://";
	/**#@-*/
	
	/**
	 * Constructor Url
	 * @param mixed $url 
	 */
	function __construct($url) {
		parent::__construct();
		
		if (!isset($url)) {
			throw new NewException("1 argument for ".get_class($this)."::__construct() is mandatory", 0, getDebugBacktrace(1));
		}
		
		$this->url = $url;
	}
	
	/**
	 * Method render
	 * @access public
	 * @param boolean $ajax_render [default value: false]
	 * @return mixed
	 * @since 1.0.35
	 */
	public function render($ajax_render=false) {
		if (strtoupper(substr($this->url, 0, 7)) != "HTTP://" && strtoupper(substr($this->url, 0, 8)) != "HTTPS://") {
			$this->url = BASE_URL.$_SESSION['lang']."/".$this->url;
		}
		return $this->url;
	}
}
?>
