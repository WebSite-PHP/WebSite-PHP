<?php 
/**
 * PHP file wsp\class\modules\Facebook\FacebookComments.class.php
 * @package modules
 * @subpackage Facebook
 */
/**
 * Class FacebookComments
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2013 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package modules
 * @subpackage Facebook
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 11/04/2013
 * @version     1.2.5
 * @access      public
 * @since       1.0.86
 */

class FacebookComments extends WebSitePhpObject {
	/**#@+
	* FacebookComments style
	* @access public
	* @var string
	*/
	const STYLE_LIGHT = "light";
	const STYLE_DARK = "dark";
	/**#@-*/
	
	/**#@+
	* @access private
	*/
	private $url_to_comment = "";
	private $number_post = 2;
	private $width = 500;
	private $style = FacebookComments::STYLE_LIGHT;
	/**#@-*/
	
	/**
	 * Constructor FacebookComments
	 * @param string $url_to_comment 
	 * @param double $number_post [default value: 2]
	 * @param double $width [default value: 500]
	 * @param string $style [default value: light]
	 */
	function __construct($url_to_comment='', $number_post=2, $width=500, $style='light') {
		parent::__construct();
		
		if ($url_to_comment == "") {
			$http_type = "";
			$split_request_uri = explode("\?", $_SERVER['REQUEST_URI']);
			if (!defined('FORCE_SERVER_NAME') || FORCE_SERVER_NAME == "") {
				if ($_SERVER['SERVER_PORT'] == 443) {
					$http_type = "https://";
					$current_url = str_replace("//", "/", $_SERVER['SERVER_NAME'].substr($split_request_uri[0], 0, strrpos($split_request_uri[0], "/"))."/");
				} else {
					$port = "";
					if ($_SERVER['SERVER_PORT'] != 80 &&  $_SERVER['SERVER_PORT'] != "") {
						$port = ":".$_SERVER['SERVER_PORT'];
					}
					$http_type = "http://";
					$current_url = str_replace("//", "/", $_SERVER['SERVER_NAME'].$port.substr($split_request_uri[0], 0, strrpos($split_request_uri[0], "/"))."/");
				}
			} else {
				$http_type = "http://";
				$current_url = str_replace("//", "/", FORCE_SERVER_NAME.substr($split_request_uri[0], 0, strrpos($split_request_uri[0], "/"))."/");
			}
			$this->url_to_comment = $current_url;
		} else {
			$this->url_to_comment = $url_to_comment;
		}
		$this->number_post = $number_post;
		$this->width = $width;
		$this->style = $style;
	}

	/**
	 * Method setNumberPost
	 * @access public
	 * @param mixed $number_post 
	 * @return FacebookComments
	 * @since 1.0.86
	 */
	public function setNumberPost($number_post) {
		$this->number_post = $number_post;
		return $this;
	}
	
	/**
	 * Method setStyle
	 * @access public
	 * @param mixed $style 
	 * @return FacebookComments
	 * @since 1.0.86
	 */
	public function setStyle($style) {
		$this->style = $style;
		return $this;
	}
	
	/**
	 * Method setWidth
	 * @access public
	 * @param integer $width 
	 * @return FacebookComments
	 * @since 1.0.86
	 */
	public function setWidth($width) {
		$this->width = $width;
		return $this;
	}
	
	/**
	 * Method render
	 * @access public
	 * @param boolean $ajax_render [default value: false]
	 * @return string html code of object FacebookComments
	 * @since 1.0.86
	 */
	public function render($ajax_render=false) {
		$html = "<style type='text/css'>.fb_iframe_widget iframe { position: relative;! }</style>";
		$html .= "<div id=\"fb-root\"></div><script src=\"http://connect.facebook.net/en_US/all.js#xfbml=1\"></script><fb:comments href=\"".$this->url_to_comment."\" num_posts=\"".$this->number_post."\" width=\"".$this->width."\" colorscheme=\"".$this->style."\"></fb:comments>";
		
		return $html;
	}
}
?>
