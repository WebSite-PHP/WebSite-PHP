<?php
/**
 * PHP file wsp\class\modules\ShareButton\FacebookLikeButton.class.php
 * @package modules
 * @subpackage ShareButton
 */
/**
 * Class FacebookLikeButton
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
 * @since       1.0.103
 */

class FacebookLikeButton extends WebSitePhpObject {
	/**#@+
	* Button style
	* @access public
	* @var string
	*/
	const BUTTON_COUNT = "button_count";
	const BUTTON_STANDARD = "";
	const BUTTON_BOX_COUNT = "box_count";
	/**#@-*/
	
	/**#@+
	* Button action
	* @access public
	* @var string
	*/
	const ACTION_LIKE = "";
	const ACTION_RECOMMAND = "recommend";
	/**#@-*/
	
	/**#@+
	* Button color
	* @access public
	* @var string
	*/
	const ACTION_LIGHT = "";
	const ACTION_DARK = "dark";
	/**#@-*/
	
	/**#@+
	* @access private
	*/
	private $type_button = "";
	private $url = "";
	private $send_button = false;
	private $width = 450;
	private $show_faces = false;
	private $action = "";
	private $color = "";
	/**#@-*/
	
	/**
	 * Constructor FacebookLikeButton
	 * @param string $type_button 
	 * @param string $url 
	 * @param boolean $send_button [default value: false]
	 * @param double $width [default value: 450]
	 * @param boolean $show_faces [default value: false]
	 * @param string $action 
	 * @param string $color 
	 */
	function __construct($type_button='', $url='', $send_button=false, $width=450, $show_faces=false, $action='', $color='') {
		parent::__construct();
		
		$this->type_button = $type_button;
		$this->url = $url;
		$this->send_button = $send_button;
		$this->width = $width;
		$this->show_faces = $show_faces;
		$this->action = $action;
		$this->color = $color;
	}
	
	/**
	 * Method render
	 * @access public
	 * @param boolean $ajax_render [default value: false]
	 * @return string html code of object FacebookLikeButton
	 * @since 1.0.88
	 */
	public function render($ajax_render=false) {
		FacebookLikeButton::getFacebookJsInclude();
		$html = "<div class=\"fb-like\"";
		if ($this->url != "") {
			$html .= " data-href=\"".$this->url."\"";
		}
		$html .= " data-send=\"".($this->send_button?"true":"false")."\"";
		if ($this->type_button != "") {
			$html .= " data-layout=\"".$this->type_button."\"";
		}
		$html .= " data-width=\"".$this->width."\" data-show-faces=\"".($this->show_faces?"true":"false")."\"";
		if ($this->action != "") {
			$html .= " data-action=\"".$this->action."\"";
		}
		if ($this->color != "") {
			$html .= " data-colorscheme=\"".$this->color."\"";
		}
		$html .= "></div>\n";
		
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
