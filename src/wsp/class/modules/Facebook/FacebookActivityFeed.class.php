<?php 
/**
 * PHP file wsp\class\modules\Facebook\FacebookActivityFeed.class.php
 * @package modules
 * @subpackage Facebook
 */
/**
 * Class FacebookActivityFeed
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2015 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package modules
 * @subpackage Facebook
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 12/05/2015
 * @version     1.2.13
 * @access      public
 * @since       1.0.86
 */

global $is_facebook_js_already_loaded;
$GLOBALS['is_facebook_js_already_loaded'] = false;

class FacebookActivityFeed extends WebSitePhpObject {
	/**#@+
	* FacebookActivityFeed style
	* @access public
	* @var string
	*/
	const STYLE_LIGHT = "light";
	const STYLE_DARK = "dark";
	/**#@-*/
	
	/**#@+
	* FacebookActivityFeed font
	* @access public
	* @var string
	*/
	const FONT_ARIAL = "arial";
	const FONT_LUCIDA_GRANDE = "lucida grande";
	const FONT_SEGOE_UI = "segoe ui";
	const FONT_TAHOMA = "tahoma";
	const FONT_TREBUCHET_MS = "trebuchet ms";
	const FONT_VERDANA = "verdana";
	/**#@-*/
	
	/**#@+
	* @access private
	*/
	private $domain = "";
	private $width = 300;
	private $height = 300;
	private $header = true;
	private $style = FacebookActivityFeed::STYLE_LIGHT;
	private $font = "";
	private $border_color = "";
	private $show_recommandations = false;
	/**#@-*/
	
	/**
	 * Constructor FacebookActivityFeed
	 * @param string $domain 
	 * @param double $width [default value: 300]
	 * @param double $height [default value: 300]
	 * @param boolean $header [default value: true]
	 * @param string $style [default value: light]
	 * @param string $font 
	 * @param string $border_color 
	 * @param boolean $show_recommandations [default value: false]
	 */
	function __construct($domain='', $width=300, $height=300, $header=true, $style='light', $font='', $border_color='', $show_recommandations=false) {
		parent::__construct();
		
		if ($domain == "") {
			$this->domain = BASE_URL;
		} else {
			$this->domain = $domain;
		}
		$this->width = $width;
		$this->height = $height;
		$this->header = $header;
		$this->style = $style;
		$this->font = $font;
		$this->border_color = $border_color;
		$this->show_recommandations = $show_recommandations;
	}
	
	/**
	 * Method setWidth
	 * @access public
	 * @param integer $width 
	 * @return FacebookActivityFeed
	 * @since 1.0.86
	 */
	public function setWidth($width) {
		$this->width = $width;
		return $this;
	}
	
	/**
	 * Method setHeight
	 * @access public
	 * @param integer $height 
	 * @return FacebookActivityFeed
	 * @since 1.0.86
	 */
	public function setHeight($height) {
		$this->height = $height;
		return $this;
	}
	
	/**
	 * Method setHeader
	 * @access public
	 * @param mixed $header 
	 * @return FacebookActivityFeed
	 * @since 1.0.86
	 */
	public function setHeader($header) {
		$this->header = $header;
		return $this;
	}
	
	/**
	 * Method setStyle
	 * @access public
	 * @param mixed $style 
	 * @return FacebookActivityFeed
	 * @since 1.0.86
	 */
	public function setStyle($style) {
		$this->style = $style;
		return $this;
	}
	
	/**
	 * Method setFont
	 * @access public
	 * @param mixed $font 
	 * @return FacebookActivityFeed
	 * @since 1.0.86
	 */
	public function setFont($font) {
		$this->font = $font;
		return $this;
	}
	
	/**
	 * Method setBorderColor
	 * @access public
	 * @param mixed $border_color 
	 * @return FacebookActivityFeed
	 * @since 1.0.86
	 */
	public function setBorderColor($border_color) {
		$this->border_color = $border_color;
		return $this;
	}
	
	/**
	 * Method setShowRecommandations
	 * @access public
	 * @param mixed $show_recommandations 
	 * @return FacebookActivityFeed
	 * @since 1.0.86
	 */
	public function setShowRecommandations($show_recommandations) {
		$this->show_recommandations = $show_recommandations;
		return $this;
	}
	
	/**
	 * Method render
	 * @access public
	 * @param boolean $ajax_render [default value: false]
	 * @return string html code of object FacebookActivityFeed
	 * @since 1.0.86
	 */
	public function render($ajax_render=false) {
		FacebookActivityFeed::getFacebookJsInclude();
		$html = "<div class=\"fb-activity\" data-site=\"".$this->domain."\" data-action=\"likes, recommends\" data-width=\"".$this->width."\" data-height=\"".$this->height."\" data-colorscheme=\"".$this->style."\" data-header=\"".($this->header?"true":"false")."\" style=\"border:none; overflow:hidden;background-color:".($this->style=="dark"?"black":"white")."; width:".$this->width."px; height:".$this->height."px;\"></div>";
		
		return $html;
	}
	
	/**
	 * Method getFacebookJsInclude
	 * @access static
	 * @since 1.2.9
	 */
	public static function getFacebookJsInclude() {
		if (!$GLOBALS['is_facebook_js_already_loaded']) {
			$page = Page::getInstance($_GET['p']);
            if ($page->isThirdPartyCookiesFilterEnable()) {
                $page->addObject(new Object("<script type=\"text/javascript\">(tarteaucitron.job = tarteaucitron.job || []).push('facebook');</script>"));
            } else {
                $page->addObject(new Object("<div id=\"fb-root\"></div>"));
                $js = "$( document ).ready(function() {\n";
                $js .= "(function(d, s, id) {\n";
                $js .= "  var js, fjs = d.getElementsByTagName(s)[0];\n";
                $js .= "  if (d.getElementById(id)) return;\n";
                $js .= "  js = d.createElement(s); js.id = id;\n";
                $facebook_language = $page->getLanguageLocale();
                $js .= "  js.src = \"//connect.facebook.net/" . $facebook_language . "/all.js#xfbml=1\";\n";
                $js .= "  js.defer = \"defer\";\n";
                $js .= "  fjs.parentNode.insertBefore(js, fjs);\n";
                $js .= "}(document, 'script', 'facebook-jssdk'));\n";
                $js .= "});\n";
                $page->addObject(new JavaScript($js), false, true);
            }
            $GLOBALS['is_facebook_js_already_loaded'] = true;
		}
	}
}
?>
