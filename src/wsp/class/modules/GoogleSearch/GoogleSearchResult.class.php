<?php
/**
 * PHP file wsp\class\modules\GoogleSearch\GoogleSearchResult.class.php
 * @package modules
 * @subpackage GoogleSearch
 */
/**
 * Class GoogleSearchResult
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2015 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package modules
 * @subpackage GoogleSearch
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 12/05/2015
 * @version     1.2.13
 * @access      public
 * @since       1.0.17
 */

class GoogleSearchResult extends WebSitePhpObject {
	private $content_page = "";
	private $content_result = "";
	
	/**
	 * Constructor GoogleSearchResult
	 * @param string $content_page 
	 * @param string $content_result 
	 */
	function __construct($content_page="", $content_result="") {
		parent::__construct();
		$this->content_page = $content_page;
		$this->content_result = $content_result;
	}
	
	/**
	 * Method setContentPage
	 * @access public
	 * @param object $content_page 
	 * @return GoogleSearchResult
	 * @since 1.0.35
	 */
	public function setContentPage($content_page) {
		$this->content_page = $content_page;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setContentResult
	 * @access public
	 * @param object $content_result 
	 * @return GoogleSearchResult
	 * @since 1.0.35
	 */
	public function setContentResult($content_result) {
		$this->content_result = $content_result;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method render
	 * @access public
	 * @param boolean $ajax_render [default value: false]
	 * @return string html code of object GoogleSearchResult
	 * @since 1.0.35
	 */
	public function render($ajax_render=false) {
		$html = "<div id=\"cse-result-div\" style=\"text-align:left;display:none;padding-right:10px;padding-left:10px;\">";
		if ($this->content_result != "" && method_exists($this->content_result, "setContent")) {
			$this->content_result->setContent("<div id=\"cse-result\"></div>");
			$html .= $this->content_result->render();
		} else {
			$html .= "<div id=\"cse-result\"></div>";
		}
		$html .= "</div>\n";
		$html .= "<div id=\"cse-normal-content\">";
		if ($this->content_page != "") {
			if (gettype($this->content_page) == "object" && method_exists($this->content_page, "render")) {
				$html .= "\n".$this->content_page->render($ajax_render)."\n";
			} else {
				$html .= "\n".$this->content_page."\n";
			}
		}
		$html .= "</div>";
		$this->object_change = false;
		return $html;
	}
}
?>
