<?php
/**
 * Class MenuItem
 * 
 * Instance of a new MenuItem.
 * @access public
 * @author Emilien MOREL <admin@website-php.com>
 * @link http://www.website-php.com
 * @copyright website-php.com 29/11/2009
 * @version 1.0
 */

// Website JS/Css => http://www.twinhelix.com/dhtml/fsmenu/

class MenuItem extends WebSitePhpObject {
	/**#@+
	* MenuItem align
	* @access public
	* @var string
	*/
	const ALIGN_LEFT = "left";
	const ALIGN_CENTER = "center";
	const ALIGN_RIGHT = "right";
	/**#@-*/
	
	/**#@+
	* @access private
	*/
	private $value = "";
	private $link = "";
	private $img = "";
	private $current = false;
	
	private $menu_items = null;
	/**#@-*/
	
	function __construct($value, $link='', $img='', $current=false) {
		parent::__construct();
		
		if (!isset($value)) {
			throw new NewException("1 argument for ".get_class($this)."::__construct() is mandatory", 0, 8, __FILE__, __LINE__);
		}
		
		$this->value = $value;
		$this->link = $link;
		$this->img = $img;
		$this->current = $current;
	}
	
	public function setMenuItems($menu_items_object) {
		if (get_class($menu_items_object) != "MenuItems") {
			throw new NewException("Error MenuItem->setMenuItems(): $menu_items_object is not a MenuItems object", 0, 8, __FILE__, __LINE__);
		}
		$this->menu_items = $menu_items_object;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function setCurrent() {
		$this->current = true;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function render($ajax_render=false) {
		$html = "\t<li";
		if ($this->current) {
			$html .= " class=\"current\"";
		}
		$html .= ">";
		$html .= "<a ";
		if ($this->menu_items != null && sizeof($this->menu_items) > 0) {
			$html .= "class=\"sf-with-ul\" ";
		} 
		$html .= "href=\"".createHrefLink($this->link)."\" style=\"white-space: nowrap;\">";
		if ($this->img != "") {
			if (gettype($this->img) != "object") {
				$this->img = new Picture($this->img);
				$this->img->setAlign(Picture::ALIGN_ABSMIDDLE);
			}
			$html .= str_replace("\n", "", str_replace("\r", "", $this->img->render()))."&nbsp;";
		}
		$html .= $this->value."</a>";
		
		if ($this->menu_items != null && sizeof($this->menu_items) > 0) {
			$html .= "\n".$this->menu_items->render();
		}
		
		$html .= "</li>\n";
		$this->object_change = false;
		return $html;
	}
}
?>