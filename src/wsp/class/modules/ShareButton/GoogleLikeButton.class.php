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
 * Copyright (c) 2009-2015 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package modules
 * @subpackage ShareButton
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 12/05/2015
 * @version     1.2.13
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

        if ($this->getPage()->isThirdPartyCookiesFilterEnable()){
            $html .= "<div class=\"g-plusone\"";
            if ($this->type_button != "") {
                $html .= " data-size=\"" . $this->type_button . "\"";
            }
            if (!$this->count) {
                $html .= " data-count=\"false\"";
            }
            if ($this->callback != "") {
                $html .= " data-callback=\"" . $this->callback . "\"";
            }
            if ($this->url != "") {
                $html .= " data-href=\"" . $this->url . "\"";
            }
            $html .= "></div>";
            $html .= "<script type=\"text/javascript\">(tarteaucitron.job = tarteaucitron.job || []).push('gplus');</script>";
        } else {
            $html .= "<g:plusone";
            if ($this->type_button != "") {
                $html .= " size=\"" . $this->type_button . "\"";
            }
            if (!$this->count) {
                $html .= " count=\"false\"";
            }
            if ($this->callback != "") {
                $html .= " callback=\"" . $this->callback . "\"";
            }
            if ($this->url != "") {
                $html .= " href=\"" . $this->url . "\"";
            }
            $html .= "></g:plusone>\n";

            $html .= "<script type=\"text/javascript\">\n";
            if ($_SESSION['lang'] != "en") {
                $html .= "window.___gcfg = {lang: '" . $_SESSION['lang'] . "'};\n";
            }
            $html .= "$( document ).ready(function() {\n";
            $html .= "(function() {\n";
            $html .= "  var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;\n";
            $html .= "  po.src = 'https://apis.google.com/js/plusone.js';\n";
            $html .= "  po.defer = \"defer\";\n";
            $html .= "  var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);\n";
            $html .= "})();\n";
            $html .= "});\n";
            $html .= "</script>\n";
        }
		
		return $html;
	}
}
?>
