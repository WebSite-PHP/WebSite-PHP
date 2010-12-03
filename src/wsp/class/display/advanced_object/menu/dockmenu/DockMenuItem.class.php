<?php
/**
 * Class DockMenuItem
 * 
 * Instance of a new DockMenuItem.
 * @access public
 * @author Emilien MOREL <admin@website-php.com>
 * @link http://www.website-php.com
 * @copyright website-php.com 14/04/2010
 * @version 1.0
 */

// Website JS/Css => http://www.twinhelix.com/dhtml/fsmenu/

class DockMenuItem extends WebSitePhpObject {
	/**#@+
	* @access private
	*/
	private $value = "";
	private $link = "";
	private $img = "";
	
	private $valign = "bottom";
	/**#@-*/
	
	function __construct($img, $value, $link='') {
		parent::__construct();
		
		if (!isset($img) && !isset($value)) {
			throw new NewException("2 arguments for ".get_class($this)."::__construct() are mandatory", 0, 8, __FILE__, __LINE__);
		}
		
		$this->img = $img;
		$this->value = $value;
		$this->link = $link;
	}
	
	public function setLink($link) {
		$this->link = $link;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function render($ajax_render=false) {
		$html = "";
		
		if (gettype($this->img) == "object") {
			$this->img = $this->img->getSrc();
		}
		
		$html .= "<a href=\"".createHrefLink($this->link)."\">"; 
		$html .= "<img src=\"".$this->img."\" border=\"0\" alt=\"".str_replace("\"", " ", $this->value)."\" title=\"".str_replace("\"", " ", $this->value)."\" />";
		$html .= "</a>\n";
		$this->object_change = false;
		return $html;
	}
}
?>
