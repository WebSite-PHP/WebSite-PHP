<?php
// tools: http://www.image-maps.com/
class PictureMap extends WebSitePhpObject {
	/**#@+
	* @access private
	*/
	private $id = "";
	private $tooltip=false;
	private $tooltip_params="";
	
	private $array_rect = array();
	private $array_polygon = array();
	private $array_circle = array();
	private $default_link = "";
	/**#@-*/
	
	function __construct($id, $tooltip=false, $tooltip_params="") {
		parent::__construct();
		
		if (!isset($id)) {
			throw new NewException("1 argument for ".get_class($this)."::__construct() is mandatory", 0, 8, __FILE__, __LINE__);
		}
		
		$this->id = $id;
		$this->tooltip = $tooltip;
		$this->tooltip_params = $tooltip_params;
		
		if ($this->tooltip) {
			$this->addJavaScript(BASE_URL."wsp/js/jquery.qtip-1.0.0-rc3.min.js", "", true);
		}
	}
	
	public function addRect($link, $title, $tooltip_params, $x1, $y1, $x2, $y2) {
		if (gettype($link) != "object" && get_class($link) != "Link") {
			throw new NewException(get_class($this)."->addRect() error: \$link must be a Link object", 0, 8, __FILE__, __LINE__);
		}
		
		$ind = sizeof($this->array_rect);
		$this->array_rect[$ind] = array();
		$this->array_rect[$ind]['link'] = $link;
		$this->array_rect[$ind]['title'] = $title;
		$this->array_rect[$ind]['tooltip_params'] = $tooltip_params;
		
		if (!is_integer($x1) || !is_integer($y1) || !is_integer($x2) || !is_integer($y2)) {
			throw new NewException(get_class($this)."->addRect() error: \$x1, \$y1, \$x2, \$y2 must be integer values", 0, 8, __FILE__, __LINE__);
		}
		
		$this->array_rect[$ind]['x1'] = $x1;
		$this->array_rect[$ind]['y1'] = $y1;
		$this->array_rect[$ind]['x2'] = $x2;
		$this->array_rect[$ind]['y2'] = $y2;
		
		return $this;
	}
	
	public function addPolygon($link, $title, $tooltip_params, $x1, $y1, $x2, $y2, $x3, $y3) {
		if (gettype($link) != "object" && get_class($link) != "Link") {
			throw new NewException(get_class($this)."->addPolygon() error: \$link must be a Link object", 0, 8, __FILE__, __LINE__);
		}
		
		$ind = sizeof($this->array_polygon);
		$this->array_polygon[$ind] = array();
		$this->array_polygon[$ind]['link'] = $link;
		$this->array_polygon[$ind]['title'] = $title;
		$this->array_polygon[$ind]['tooltip_params'] = $tooltip_params;
		$args = func_get_args();
		for ($i=3; $i < sizeof($args); $i++) {
			if (!is_integer($args[$i])) {
				throw new NewException(get_class($this)."->addPolygon() error: \$x1, \$y1, \$x2, \$y2, \$x3, \$y3, ... must be integer values", 0, 8, __FILE__, __LINE__);
			}
    		$this->array_polygon[$ind][$i-3] = $args[$i];
    	}
		
		return $this;
	}
	
	public function addCircle($link, $title, $tooltip_params, $x, $y, $r) {
		if (gettype($link) != "object" && get_class($link) != "Link") {
			throw new NewException(get_class($this)."->addCircle() error: \$link must be a Link object", 0, 8, __FILE__, __LINE__);
		}
		
		$ind = sizeof($this->array_circle);
		$this->array_circle[$ind] = array();
		$this->array_circle[$ind]['link'] = $link;
		$this->array_circle[$ind]['title'] = $title;
		$this->array_circle[$ind]['tooltip_params'] = $tooltip_params;
		
		if (!is_integer($x) || !is_integer($y) || !is_integer($r)) {
			throw new NewException(get_class($this)."->addCircle() error: \$x, \$y, \$r must be integer values", 0, 8, __FILE__, __LINE__);
		}
		
		$this->array_circle[$ind]['x'] = $x;
		$this->array_circle[$ind]['y'] = $y;
		$this->array_circle[$ind]['r'] = $r;
		
		return $this;
	}
	
	public function setDefault($link, $title='', $tooltip_params='') {
		if (gettype($link) != "object" && get_class($link) != "Link") {
			throw new NewException(get_class($this)."->setDefault() error: \$link must be a Link object", 0, 8, __FILE__, __LINE__);
		}
		
		$this->default_link = $link;
		$this->default_link_title = $title;
		$this->default_link_tooltip_params = $tooltip_params;
		return $this;
	}
	
	public function getId() {
		return $this->id;
	}
	
	public function render($ajax_render=false) {
		$html = "";
		$tooltip_params = "";
		
		$ind = 0;
		$html .= "<map name=\"".$this->getId()."\">\n";
		for ($i=0; $i < sizeof($this->array_polygon); $i++) {
			if ($this->array_polygon[$i]['link']->getUserHaveRights()) {
				$html .= "	<area id=\"".$this->getId()."_".$ind."\" shape=\"poly\" coords=\"";
				$coords = "";
				for($j=0; $j < sizeof($this->array_polygon[$i]); $j++) {
					if ($coords != "") { $coords .= ","; }
					$coords .= $this->array_polygon[$i][$j];
				}
				$html .= $coords."\" ";
				$html .= "href=\"".createHrefLink($this->array_polygon[$i]['link']->getLink(), $this->array_polygon[$i]['link']->getTarget())."\" ";
				$html .= "alt=\"".str_replace("\"", " ", $this->array_polygon[$i]['title'])."\" title=\"".str_replace("\"", " ", $this->array_polygon[$i]['title'])."\">\n";
				$tooltip_params .= $this->createToolTips($this->array_polygon[$i], $ind);
				$ind++;
			}
		}
		
		for ($i=0; $i < sizeof($this->array_rect); $i++) {
			if ($this->array_rect[$i]['link']->getUserHaveRights()) {
				$html .= "	<area id=\"".$this->getId()."_".$ind."\" shape=\"rect\" coords=\"";
				$html .= $this->array_rect[$i]['x1'].",".$this->array_rect[$i]['y1'].",".$this->array_rect[$i]['x2'].",".$this->array_rect[$i]['y2']."\" ";
				$html .= "href=\"".createHrefLink($this->array_rect[$i]['link']->getLink(), $this->array_rect[$i]['link']->getTarget())."\" ";
				$html .= "alt=\"".str_replace("\"", " ", $this->array_rect[$i]['title'])."\" title=\"".str_replace("\"", " ", $this->array_rect[$i]['title'])."\">\n";
				$tooltip_params .= $this->createToolTips($this->array_rect[$i], $ind);
				$ind++;
			}
		}
		
		for ($i=0; $i < sizeof($this->array_circle); $i++) {
			if ($this->array_circle[$i]['link']->getUserHaveRights()) {
				$html .= "	<area id=\"".$this->getId()."_".$ind."\" shape=\"circle\" coords=\"";
				$html .= $this->array_circle[$i]['x'].",".$this->array_circle[$i]['y'].",".$this->array_circle[$i]['r']."\" ";
				$html .= "href=\"".createHrefLink($this->array_circle[$i]['link']->getLink(), $this->array_circle[$i]['link']->getTarget())."\" ";
				$html .= "alt=\"".str_replace("\"", " ", $this->array_circle[$i]['title'])."\" title=\"".str_replace("\"", " ", $this->array_circle[$i]['title'])."\">\n";
				$tooltip_params .= $this->createToolTips($this->array_circle[$i], $ind);
				$ind++;
			}
		}
		
		if ($this->default_link != "") {
			if ($this->default_link->getUserHaveRights()) {
				$html .= "	<area id=\"".$this->getId()."_".$ind."\" shape=\"default\" href=\"".createHrefLink($this->default_link->getLink(), $this->default_link->getTarget())."\">\n";
				$tooltip_params .= $this->createToolTips($this->default_link, $ind);
				$ind++;
			}
		}
		$html .= "</map>\n";
		
		if ($this->tooltip) {
			$html .= $this->getJavascriptTagOpen();
			$html .= "$(document).ready(function() {\n";
			$html .= $tooltip_params;
			$html .= "});\n";
			$html .= $this->getJavascriptTagClose();
		}
		
		$this->object_change = false;
		return $html;
	}
	
	private function createToolTips($map_area_info, $ind) {
		$html = "	$('#".$this->getId()."_".$ind."').qtip({ content: $('#".$this->getId()."_".$ind."').title";
		if ($this->tooltip_params != "" || $map_area_info['tooltip_params'] != "") {
			if ($this->tooltip_params != "") {
				$html .= ", ".$this->tooltip_params;
			}
			if ($map_area_info['tooltip_params'] != "") {
				$html .= ", ".$map_area_info['tooltip_params'];
			}
		}
		$html .= " });\n";
		return $html;
	}
}
?>
