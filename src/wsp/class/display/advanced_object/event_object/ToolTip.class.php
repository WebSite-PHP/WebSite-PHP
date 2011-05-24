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
 * Copyright (c) 2009-2011 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package display
 * @subpackage advanced_object.event_object
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 29/04/2011
 * @version     1.0.81
 * @access      public
 * @since       1.0.77
 */

class ToolTip extends WebSitePhpObject {
	/**#@+
	* @access private
	*/
	private $id = "";
	private $params = "";
	private $content = "";
	/**#@-*/
	
	/**
	 * Constructor ToolTip
	 * @param string $params 
	 * @param string $content 
	 */
	function __construct($params='', $content='') {
		$this->params = $params;
		$this->content = $content;
		
		$this->addJavaScript(BASE_URL."wsp/js/jquery.qtip-1.0.0-rc3.min.js", "", true);
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
	 * Method render
	 * @access public
	 * @param boolean $ajax_render [default value: false]
	 * @return string html code of object ToolTip
	 * @since 1.0.77
	 */
	public function render($ajax_render=false) {
		if (!isset($this->id) || $this->id == "") {
			throw new NewException("Error ".get_class($this).": Please set an id", 0, 8, __FILE__, __LINE__);
		}
		
		if (gettype($this->content) == "object") {
			$this->content = $this->content->render();
		}
		
		$html = "";
		$html .= "$(document).ready(function() {\n";
		$html .= "	$('#".$this->id."').qtip({ content: ".(($this->content=="")?"$('#".$this->id."').title":"'".str_replace("'", "&#39;", $this->content)."'");
		if ($this->params != "") {
			$html .= ", ".$this->params;
		}
		$html .= " });\n";
		$html .= "});\n";
		return $html;
	}
}
?>
