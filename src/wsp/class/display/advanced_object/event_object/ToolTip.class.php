<?php
/**
 * PHP file wsp\class\display\advanced_object\event_object\ToolTip.class.php
 * @package display
 * @subpackage advanced_object.event_object
 */
/**
 * Class ToolTip
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2012 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package display
 * @subpackage advanced_object.event_object
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 26/05/2011
 * @version     1.1.5
 * @access      public
 * @since       1.0.77
 */

class ToolTip extends WebSitePhpObject {
	/**#@+
	* @access private
	*/
	private $id = "";
	private $content = "";
	private $params = "";
	private $follow_cursor = false;
	/**#@-*/
	
	/**
	 * Constructor ToolTip
	 * @param string $content 
	 * @param string $params 
	 * @param boolean $follow_cursor [default value: false]
	 */
	function __construct($content='', $params='', $follow_cursor=false) {
		$this->content = $content;
		$this->params = $params;
		$this->follow_cursor = $follow_cursor;
		
		$this->addJavaScript(BASE_URL."wsp/js/jquery.qtip.min.js", "", true);
		$this->addCss(BASE_URL."wsp/css/jquery.qtip.css");
	}
	
	/**
	 * Method setId
	 * @access public
	 * @param string $id 
	 * @return ToolTip
	 * @since 1.0.77
	 */
	public function setId($id) {
		$this->id = $id;
		return $this;
	}
	
	/**
	 * Method setParams
	 * @access public
	 * @param string $params 
	 * @return ToolTip
	 * @since 1.0.77
	 */
	public function setParams($params) {
		$this->params = $params;
		return $this;
	}
	
	/**
	 * Method followCursor
	 * @access public
	 * @return ToolTip
	 * @since 1.1.0
	 */
	public function followCursor() {
		$this->follow_cursor = true;
		return $this;
	}
	
	/**
	 * Method setContent
	 * @access public
	 * @param string|WebSitePhpObject $content 
	 * @return ToolTip
	 * @since 1.0.77
	 */
	public function setContent($content) {
		$this->content = $content;
		return $this;
	}
	
	/**
	 * Method getParams
	 * @access public
	 * @return mixed
	 * @since 1.0.91
	 */
	public function getParams() {
		return $this->params;
	}
	
	/**
	 * Method render
	 * @access public
	 * @param boolean $ajax_render [default value: false]
	 * @return string html code of object ToolTip
	 * @since 1.0.77
	 */
	public function render($ajax_render=false) {
		if (!isset($this->id) || $this->id == "") {
			throw new NewException("Error ".get_class($this).": Please set an id", 0, getDebugBacktrace(1));
		}
		
		if (gettype($this->content) == "object") {
			$this->content = $this->content->render();
		}
		
		$html = "";
		$html .= "$(document).ready(function() {\n";
		$html .= "	$('#".$this->id."').qtip({ content: ".(($this->content=="")?"$('#".$this->id."').title":"'".str_replace("'", "&#39;", $this->content)."'");
		$html .= ", style: { widget: true }";
		if ($this->params != "") {
			$html .= ", ".$this->params;
		}
		if ($this->follow_cursor) {
			$html .= ", position: { my: 'top left', target: 'mouse', viewport: $(window), adjust: { x: 10,  y: 10 } }";
		}
		$html .= " });\n";
		$html .= "});\n";
		return $html;
	}
}
?>
