<?php
/**
 * Class Menu
 * 
 * Instance of a new Menu.
 * @access public
 * @author Emilien MOREL <admin@website-php.com>
 * @link http://www.website-php.com
 * @copyright website-php.com 29/11/2009
 * @version 1.0
 */

// Website JS/Css => http://www.twinhelix.com/dhtml/fsmenu/

class Menu extends WebSitePhpObject {
	/**#@+
	* Menu position style
	* @access public
	* @var string
	*/
	const POSITION_VERTICAL = "Vertical";
	const POSITION_HORIZONTAL = "Horizontal";
	const POSITION_NAV_BAR = "Nav Bar";
	/**#@-*/
	
	/**#@+
	* @access private
	*/
	private $id = "";
	private $position = "";
	private $menu_items = null;
	private $max_width = -1;
	private $min_width = -1;
	
	private $is_supersubs = false;
	/**#@-*/
	
	function __construct($position='Horizontal', $id='listMenu') {
		parent::__construct();
		
		$this->id = $id;
		
		$this->addCss(BASE_URL."wsp/css/menu/superfish.css", "", true);
		
		$this->addJavaScript(BASE_URL."wsp/js/menu/hoverIntent.js", "", true);
		$this->addJavaScript(BASE_URL."wsp/js/menu/jquery.bgiframe.min.js", "", true);
		$this->addJavaScript(BASE_URL."wsp/js/menu/superfish.js", "", true);
		$this->addJavaScript(BASE_URL."wsp/js/menu/supersubs.js", "", true);
		
		$this->setPosition($position);
	}
	
	public function setMenuItems($menu_items_object) {
		if (get_class($menu_items_object) != "MenuItems") {
			throw new NewException("Error Menu->setMenuItems(): menu_items_object is not a MenuItems object", 0, 8, __FILE__, __LINE__);
		}
		$this->menu_items = $menu_items_object;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function setPosition($position) {
		if ($position != Menu::POSITION_VERTICAL && $position != Menu::POSITION_HORIZONTAL
			&& $position != Menu::POSITION_NAV_BAR) {
			throw new NewException("Menu position ".$position." doesn't exist", 0, 8, __FILE__, __LINE__);
		}
		
		if ($position == Menu::POSITION_VERTICAL) {
			$this->addCss(BASE_URL."wsp/css/menu/superfish-vertical.css", "", true); 
		} else if ($position == Menu::POSITION_NAV_BAR) {
			$this->addCss(BASE_URL."wsp/css/menu/superfish-navbar.css", "", true); 
		}
		
		$this->position = $position;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function activateSupersubs() {
		$this->is_supersubs = true;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function setMaxWidth($max_width) {
		$this->max_width = $max_width;
		$this->is_supersubs = true;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function setMinWidth($min_width) {
		$this->min_width = $min_width;
		$this->is_supersubs = true;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function render($ajax_render=false) {
		$html = "";
		
		if ($this->menu_items != null) {
			$this->menu_items->setMenuRoot($this->id)->setPosition($this->position);
			$html .= $this->menu_items->render(false);
			
			$html .= $this->getJavascriptTagOpen();
			$html .= "	if ($.browser.mozilla && parseFloat($.browser.version) < 1.9 && navigator.appVersion.indexOf('Mac') !== -1) $('body').css('-moz-opacity',.999);\n";
			$html .= "	$(document).ready(function(){\n";
			$html .= "		$(\"#".$this->id."\")";
			if ($this->is_supersubs && $this->position != Menu::POSITION_NAV_BAR) {
				$html .= ".supersubs({";
				$supersubs_option = "";
				if ($this->min_width > 0) {
					if ($supersubs_option != "") { $supersubs_option .= ", "; }
					$supersubs_option .= "minWidth: ".$this->min_width;
				}
				if ($this->max_width > 0) {
					if ($supersubs_option != "") { $supersubs_option .= ", "; }
					$supersubs_option .= "maxWidth: ".$this->max_width;
				}
				$html .= "})";
			}
			$html .= ".superfish({";
			$option = "";
			if ($this->position == Menu::POSITION_NAV_BAR) {
				if ($option != "") { $option .= ", "; }
				$option .= "pathClass: 'current'";
			}
			$html .= $option."}).find('ul').bgIframe({opacity:false});\n";
			$html .= "	});\n";
			$html .= $this->getJavascriptTagClose();
		}
		$this->object_change = false;
		return $html;
	}
}
?>