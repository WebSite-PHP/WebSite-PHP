<?php
/**
 * PHP file wsp\class\display\Url.class.php
 * @package display
 */
/**
 * Class Url
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2016 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package display
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 10/05/2016
 * @version     1.2.14
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
		$url_array = explode("?", $this->url);
		$url_without_param =  $url_array[0];
		if ((!defined('NO_ADD_AUTO_LINK_BASE_URL') || NO_ADD_AUTO_LINK_BASE_URL !== true || substr($url_without_param, -5) != ".html") &&
			strtoupper(substr($this->url, 0, 7)) != "HTTP://" && strtoupper(substr($this->url, 0, 8)) != "HTTPS://"
		) {
			$this->url = BASE_URL . $_SESSION['lang'] . "/" . $this->url;
		}
		return $this->url;
	}
}
?>
