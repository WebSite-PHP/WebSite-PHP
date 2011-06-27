<?php
/**
 * PHP file wsp\class\modules\ShareButton\GoogleLikeButton.class.php
 * @package modules
 * @subpackage ShareButton
 */
/**
 * Class GoogleLikeButton
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2011 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package modules
 * @subpackage ShareButton
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 27/06/2011
 * @version     1.0.88
 * @access      public
 * @since       1.0.88
 */

class GoogleLikeButton extends WebSitePhpObject {
	/**#@+
	* Button style
	* @access public
	* @var string
	*/
	const BUTTON_SMALL = "small";
	const BUTTON_MEDIUM = "medium";
	const BUTTON_STANDARD = "";
	const BUTTON_TALL = "tall";
	/**#@-*/
	
	/**#@+
	* @access private
	*/
	private $type_button = "";
	private $count = true;
	private $callback = "";
	private $url = "";
	/**#@-*/
	
	/**
	 * Constructor GoogleLikeButton
	 * @param string $type_button 
	 * @param boolean $count [default value: true]
	 * @param string $url 
	 * @param string $callback 
	 */
	function __construct($type_button='', $count=true, $url='', $callback='') {
		parent::__construct();
		
		$this->type_button = $type_button;
		$this->count = $count;
		$this->url = $url;
		$this->callback = $callback;
		
		if ($_SESSION['lang'] == "en") {
			JavaScriptInclude::getInstance()->addUrlWithScript("https://apis.google.com/js/plusone.js", "");
		} else {
			JavaScriptInclude::getInstance()->addUrlWithScript("https://apis.google.com/js/plusone.js", "{lang: '".$_SESSION['lang']."'}");
		}
	}
	
	/**
	 * Method render
	 * @access public
	 * @param boolean $ajax_render [default value: false]
	 * @return string html code of object GoogleLikeButton
	 * @since 1.0.88
	 */
	public function render($ajax_render=false) {
		$html = "";
		
		$html .= "<g:plusone";
		if ($this->type_button != "") {
			$html .= " size=\"".$this->type_button."\"";
		}
		if (!$this->count) {
			$html .= " count=\"false\"";
		}
		if ($this->callback != "") {
			$html .= " callback=\"".$this->callback."\"";
		}
		if ($this->url != "") {
			$html .= " href=\"".$this->url."\"";
		}
		$html .= "></g:plusone>";
		
		return $html;
	}
}
?>
