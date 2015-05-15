<?php
/**
 * PHP file wsp\class\modules\ShareButton\TwiterLikeButton.class.php
 * @package modules
 * @subpackage ShareButton
 */
/**
 * Class TwiterLikeButton
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
 * @since       1.2.10
 */

class TwitterLikeButton extends WebSitePhpObject {
	/**#@+
	* Button style
	* @access public
	* @var string
	*/
	const BUTTON_HORIZONTAL_COUNT = "horizontal";
	const BUTTON_VERTICAL_COUNT = "vertical";
	const BUTTON_STANDARD = "none";
	/**#@-*/
	
	/**#@+
	* Button action
	* @access public
	* @var string
	*/
	const BUTTON_SIZE_STANDARD = "";
	const BUTTON_SIZE_LARGE = "large";
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
	private $url = "";
	private $count = "";
	private $via = "";
	private $size = "";
	/**#@-*/
	
	/**
	 * Constructor TwiterLikeButton
	 * @param string $url 
	 * @param mixed $count [default value: TwitterLikeButton::BUTTON_STANDARD]
	 * @param string $via 
	 * @param mixed $size [default value: TwitterLikeButton::BUTTON_SIZE_STANDARD]
	 */
	function __construct($url='', $count=TwitterLikeButton::BUTTON_STANDARD, $via='', $size=TwitterLikeButton::BUTTON_SIZE_STANDARD) {
		parent::__construct();
		
		$this->url = $url;
		$this->count = $count;
		$this->via = $via;
		$this->size = $size;
	}
	
	/**
	 * Method render
	 * @access public
	 * @param boolean $ajax_render [default value: false]
	 * @return string html code of object TwiterLikeButton
	 * @since 1.2.10
	 */
	public function render($ajax_render=false) {
        $html = "";
        if ($this->getPage()->isThirdPartyCookiesFilterEnable()) {
            $html .= "<span class=\"tacTwitter\"></span>";
        }
        $html .= "<a href=\"https://twitter.com/share\" class=\"twitter-share-button\"";
		if ($this->url != "") {
			$html .= " data-url=\"".$this->url."\"";
		}
		$html .= " data-count=\"".$this->count."\"";
		if ($this->via != "") {
			$html .= " data-via=\"".$this->via."\"";
		}
		if ($this->size != "") {
			$html .= " data-size=\"".$this->size."\"";
		}
		$html .= " data-lang=\"".$this->getPage()->getLanguage()."\"";
		$html .= ">".($this->getPage()->isThirdPartyCookiesFilterEnable()?"":"Tweet")."</a>";

        if ($this->getPage()->isThirdPartyCookiesFilterEnable()) {
            $html .= "<script type=\"text/javascript\">(tarteaucitron.job = tarteaucitron.job || []).push('twitter');</script>";
        } else {
            $html .= "<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>\n";
        }
		
		return $html;
	}
}
?>
