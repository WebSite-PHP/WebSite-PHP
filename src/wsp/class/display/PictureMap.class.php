<?php
/**
 * PHP file wsp\class\display\PictureMap.class.php
 * @package display
 */
/**
 * Class PictureMap
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2015 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package display
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 12/05/2015
 * @version     1.2.13
 * @access      public
 * @since       1.0.17
 */

// tools: http://www.image-maps.com/
class PictureMap extends WebSitePhpObject {
	/**#@+
	* @access private
	*/
	private $id = "";
	private $is_render = false;
	private $default_tooltip_obj=null;
	
	private $array_rect = array();
	private $array_polygon = array();
	private $array_circle = array();
	
	private $default_link = "";
	private $default_link_title = "";
	private $default_onclick_js = "";
	private $default_onmouseover_js = "";
	private $default_onmouseout_js = "";
	/**#@-*/
	
	/**
	 * Constructor PictureMap
	 * @param string $id 
	 * @param ToolTip $default_tooltip_obj [default value: null]
	 */
	function __construct($id, $default_tooltip_obj=null) {
		parent::__construct();
		
		if (!isset($id)) {
			throw new NewException("1 argument for ".get_class($this)."::__construct() is mandatory", 0, getDebugBacktrace(1));
		}
		
		$this->id = $id;
		if ($default_tooltip_obj != null) {
			if (get_class($default_tooltip_obj) != "ToolTip") {
				throw new NewException("Error ".get_class($this)."::__construct(): \$default_tooltip_obj is not a ToolTip object", 0, getDebugBacktrace(1));
			}
			$this->default_tooltip_obj = $default_tooltip_obj;
		}
	}
	
	/**
	 * Method addRect
	 * Define a rectangle link area on a picture
	 * @access public
	 * @param string $link link when click on the picture
	 * @param string $title title of the link area
	 * @param integer $x1 coordonate x1 of the rectangle
	 * @param integer $y1 coordonate y1 of the rectangle
	 * @param integer $x2 coordonate x2 of the rectangle
	 * @param integer $y2 coordonate y2 of the rectangle
	 * @param string $onclick_js 
	 * @param string $onmouseover_js 
	 * @param string $onmouseout_js 
	 * @return PictureMap
	 * @since 1.0.35
	 */
	public function addRect($link, $title, $x1, $y1, $x2, $y2, $onclick_js='', $onmouseover_js='', $onmouseout_js='') {
		if (gettype($link) != "object" || get_class($link) != "Link") {
			throw new NewException(get_class($this)."->addRect() error: \$link must be a Link object", 0, getDebugBacktrace(1));
		}
		
		$ind = sizeof($this->array_rect);
		$this->array_rect[$ind] = array();
		$this->array_rect[$ind]['link'] = $link;
		$this->array_rect[$ind]['title'] = $title;
		
		if (!is_numeric($x1) || !is_numeric($y1) || !is_numeric($x2) || !is_numeric($y2)) {
			throw new NewException(get_class($this)."->addRect() error: \$x1, \$y1, \$x2, \$y2 must be integer values", 0, getDebugBacktrace(1));
		}
		
		$this->array_rect[$ind]['x1'] = $x1;
		$this->array_rect[$ind]['y1'] = $y1;
		$this->array_rect[$ind]['x2'] = $x2;
		$this->array_rect[$ind]['y2'] = $y2;
		
		if (gettype($onclick_js) != "string" && get_class($onclick_js) != "JavaScript") {
			throw new NewException(get_class($this)."->addRect(): \$onclick_js must be a string or JavaScript object.", 0, getDebugBacktrace(1));
		}
		if (get_class($onclick_js) == "JavaScript") {
			$onclick_js = $onclick_js->render();
		}
		if (gettype($onmouseover_js) != "string" && get_class($onmouseover_js) != "JavaScript") {
			throw new NewException(get_class($this)."->addRect(): \$onmouseover_js must be a string or JavaScript object.", 0, getDebugBacktrace(1));
		}
		if (get_class($onmouseover_js) == "JavaScript") {
			$onmouseover_js = $onmouseover_js->render();
		}
		if (gettype($onmouseout_js) != "string" && get_class($onmouseout_js) != "JavaScript") {
			throw new NewException(get_class($this)."->addRect(): \$onmouseout_js must be a string or JavaScript object.", 0, getDebugBacktrace(1));
		}
		if (get_class($onmouseout_js) == "JavaScript") {
			$onmouseout_js = $onmouseout_js->render();
		}
		$this->array_rect[$ind]['onclick_js'] = $onclick_js;
		$this->array_rect[$ind]['onmouseover_js'] = $onmouseover_js;
		$this->array_rect[$ind]['onmouseout_js'] = $onmouseout_js;
		
		return $this;
	}
	
	/**
	 * Method addPolygon
	 * Define a polygon link area on a picture
	 * The polygon is define by coordonate x1-y1, x2-y2, x3-y3, and more if necessary
	 * @access public
	 * @param string $link link when click on the picture
	 * @param string $title title of the link area
	 * @param integer $x1 coordonate x1 of the polygon [default value: null]
	 * @param integer $y1 coordonate y1 of the polygon [default value: null]
	 * @param integer $x2 coordonate x2 of the polygon [default value: null]
	 * @param integer $y2 coordonate y2 of the polygon [default value: null]
	 * @param integer $x3 coordonate x3 of the polygon [default value: null]
	 * @param integer $y3 coordonate y3 of the polygon [default value: null]
	 * @param string $onclick_js 
	 * @param string $onmouseover_js 
	 * @param string $onmouseout_js 
	 * @return PictureMap
	 * @since 1.0.35
	 */
	public function addPolygon($link, $title, $x1=null, $y1=null, $x2=null, $y2=null, $x3=null, $y3=null, $onclick_js='', $onmouseover_js='', $onmouseout_js='') {
		if (gettype($link) != "object" || get_class($link) != "Link") {
			throw new NewException(get_class($this)."->addPolygon() error: \$link must be a Link object", 0, getDebugBacktrace(1));
		}
		
		$ind = sizeof($this->array_polygon);
		$this->array_polygon[$ind] = array();
		$this->array_polygon[$ind]['link'] = $link;
		$this->array_polygon[$ind]['title'] = $title;
		
		$this->array_polygon[$ind]['onclick_js'] = "";
		$this->array_polygon[$ind]['onmouseover_js'] = "";
		$this->array_polygon[$ind]['onmouseout_js'] = "";
		
		if (is_array($x1)) {
			$args = array_merge(array($link, $title), $x1, array($y1, $x2, $y2));
		} else {
			$args = func_get_args();
		}
		$is_js = false;
		$js_idx = 0;
		for ($i=2; $i < sizeof($args); $i++) {
			if ($is_js && is_numeric($args[$i])) {
				throw new NewException(get_class($this)."->addPolygon() error: \$onclick_js, \$onmouseover_js, \$onmouseout_js must be string or JavaScript object [".$args[$i]."].", 0, getDebugBacktrace(1));
			} else if (!$is_js && !is_numeric($args[$i]) && $args[$i] != "") {
				throw new NewException(get_class($this)."->addPolygon() error: \$x1, \$y1, \$x2, \$y2, \$x3, \$y3, ... must be integer values [".$args[$i]."].", 0, getDebugBacktrace(1));
			}
			
			if (is_numeric($args[$i]) && $args[$i] != "") {
				$this->array_polygon[$ind][$i-2] = $args[$i];
			} else if ($args[$i] == "0") {
				$this->array_polygon[$ind][$i-2] = $args[$i];
			} else if (gettype($args[$i]) == "string" || get_class($args[$i]) == "JavaScript") {
				if (gettype($args[$i]) != "string" && get_class($args[$i]) != "JavaScript") {
					throw new NewException(get_class($this)."->addPolygon(): js must be a string or JavaScript object.", 0, getDebugBacktrace(1));
				}
				if (get_class($args[$i]) == "JavaScript") {
					$args[$i] = $args[$i]->render();
				}
				if ($js_idx == 0) {
					$this->array_polygon[$ind]['onclick_js'] = $args[$i];
				} else if ($js_idx == 1) {
					$this->array_polygon[$ind]['onmouseover_js'] = $args[$i];
				} else if ($js_idx == 2) {
					$this->array_polygon[$ind]['onmouseout_js'] = $args[$i];
				} else {
					throw new NewException(get_class($this)."->addPolygon(): only 3 javascript parameters.", 0, getDebugBacktrace(1));
				}
				$is_js = true;
				$js_idx++;
			}
    	}
		
		return $this;
	}
	
	/**
	 * Method addCircle
	 * Define a circle link area on a picture
	 * @access public
	 * @param string $link link when click on the picture
	 * @param string $title title of the link area
	 * @param integer $x coordonate x of the circle
	 * @param integer $y coordonate y of the circle
	 * @param integer $r rayon of the circle
	 * @param string $onclick_js 
	 * @param string $onmouseover_js 
	 * @param string $onmouseout_js 
	 * @return PictureMap
	 * @since 1.0.35
	 */
	public function addCircle($link, $title, $x, $y, $r, $onclick_js='', $onmouseover_js='', $onmouseout_js='') {
		if (gettype($link) != "object" || get_class($link) != "Link") {
			throw new NewException(get_class($this)."->addCircle() error: \$link must be a Link object", 0, getDebugBacktrace(1));
		}
		
		$ind = sizeof($this->array_circle);
		$this->array_circle[$ind] = array();
		$this->array_circle[$ind]['link'] = $link;
		$this->array_circle[$ind]['title'] = $title;
		
		if (!is_numeric($x) || !is_numeric($y) || !is_numeric($r)) {
			throw new NewException(get_class($this)."->addCircle() error: \$x, \$y, \$r must be integer values", 0, getDebugBacktrace(1));
		}
		
		$this->array_circle[$ind]['x'] = $x;
		$this->array_circle[$ind]['y'] = $y;
		$this->array_circle[$ind]['r'] = $r;
		
		if (gettype($onclick_js) != "string" && get_class($onclick_js) != "JavaScript") {
			throw new NewException(get_class($this)."->addCircle(): \$onclick_js must be a string or JavaScript object.", 0, getDebugBacktrace(1));
		}
		if (get_class($onclick_js) == "JavaScript") {
			$onclick_js = $onclick_js->render();
		}
		if (gettype($onmouseover_js) != "string" && get_class($onmouseover_js) != "JavaScript") {
			throw new NewException(get_class($this)."->addCircle(): \$onmouseover_js must be a string or JavaScript object.", 0, getDebugBacktrace(1));
		}
		if (get_class($onmouseover_js) == "JavaScript") {
			$onmouseover_js = $onmouseover_js->render();
		}
		if (gettype($onmouseout_js) != "string" && get_class($onmouseout_js) != "JavaScript") {
			throw new NewException(get_class($this)."->addCircle(): \$onmouseout_js must be a string or JavaScript object.", 0, getDebugBacktrace(1));
		}
		if (get_class($onmouseout_js) == "JavaScript") {
			$onmouseout_js = $onmouseout_js->render();
		}
		$this->array_circle[$ind]['onclick_js'] = $onclick_js;
		$this->array_circle[$ind]['onmouseover_js'] = $onmouseover_js;
		$this->array_circle[$ind]['onmouseout_js'] = $onmouseout_js;
		
		return $this;
	}
	
	/**
	 * Method setDefault
	 * Define the default link on the picture
	 * @access public
	 * @param string $link link when click on the picture
	 * @param string $title title of the link area
	 * @param string $onclick_js 
	 * @param string $onmouseover_js 
	 * @param string $onmouseout_js 
	 * @return PictureMap
	 * @since 1.0.35
	 */
	public function setDefault($link, $title='', $onclick_js='', $onmouseover_js='', $onmouseout_js='') {
		if (gettype($link) != "object" || get_class($link) != "Link") {
			throw new NewException(get_class($this)."->setDefault() error: \$link must be a Link object", 0, getDebugBacktrace(1));
		}
		
		$this->default_link = $link;
		$this->default_link_title = $title;
		
		if (gettype($onclick_js) != "string" && get_class($onclick_js) != "JavaScript") {
			throw new NewException(get_class($this)."->setDefault(): \$onclick_js must be a string or JavaScript object.", 0, getDebugBacktrace(1));
		}
		if (get_class($onclick_js) == "JavaScript") {
			$onclick_js = $onclick_js->render();
		}
		if (gettype($onmouseover_js) != "string" && get_class($onmouseover_js) != "JavaScript") {
			throw new NewException(get_class($this)."->setDefault(): \$onmouseover_js must be a string or JavaScript object.", 0, getDebugBacktrace(1));
		}
		if (get_class($onmouseover_js) == "JavaScript") {
			$onmouseover_js = $onmouseover_js->render();
		}
		if (gettype($onmouseout_js) != "string" && get_class($onmouseout_js) != "JavaScript") {
			throw new NewException(get_class($this)."->setDefault(): \$onmouseout_js must be a string or JavaScript object.", 0, getDebugBacktrace(1));
		}
		if (get_class($onmouseout_js) == "JavaScript") {
			$onmouseout_js = $onmouseout_js->render();
		}
		$this->default_onclick_js = $onclick_js;
		$this->default_onmouseover_js = $onmouseover_js;
		$this->default_onmouseout_js = $onmouseout_js;
		
		return $this;
	}
	
	/**
	 * Method getId
	 * @access public
	 * @return string
	 * @since 1.0.35
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * Method render
	 * @access public
	 * @param boolean $ajax_render [default value: false]
	 * @since 1.0.35
	 */
	public function render($ajax_render=false) {
		$html = "";
		
		if (!$this->is_render) {
			$ind = 0;
			$html .= "<map name=\"".$this->getId()."\" id=\"".$this->getId()."\">\n";
			for ($i=0; $i < sizeof($this->array_polygon); $i++) {
				if ($this->array_polygon[$i]['link']->getUserHaveRights()) {
					$html .= "	<area shape=\"poly\" coords=\"";
					$coords = "";
					for($j=0; $j < sizeof($this->array_polygon[$i]); $j++) {
						if (is_numeric($this->array_polygon[$i][$j])) {
							if ($coords != "") { $coords .= ","; }
							$coords .= $this->array_polygon[$i][$j];
						}
					}
					$html .= $coords."\" ";
					$html .= "href=\"".createHrefLink($this->array_polygon[$i]['link']->getLink(), $this->array_polygon[$i]['link']->getTarget())."\" ";
					$html .= "alt=\"".str_replace("\"", " ", $this->array_polygon[$i]['title'])."\" title=\"".str_replace("\"", " ", $this->array_polygon[$i]['title'])."\"";
					if ($this->array_polygon[$i]['onclick_js'] != "") {
						$html .= " onClick=\"".str_replace("\n", "", $this->array_polygon[$i]['onclick_js'])."\"";
					}
					if ($this->array_polygon[$i]['onmouseover_js'] != "") {
						$html .= " onMouseOver=\"".str_replace("\n", "", $this->array_polygon[$i]['onmouseover_js'])."\"";
					}
					if ($this->array_polygon[$i]['onmouseout_js'] != "") {
						$html .= " onMouseOut=\"".str_replace("\n", "", $this->array_polygon[$i]['onmouseout_js'])."\"";
					}
					$html .= ">\n";
					$ind++;
				}
			}
			
			for ($i=0; $i < sizeof($this->array_rect); $i++) {
				if ($this->array_rect[$i]['link']->getUserHaveRights()) {
					$html .= "	<area shape=\"rect\" coords=\"";
					$html .= $this->array_rect[$i]['x1'].",".$this->array_rect[$i]['y1'].",".$this->array_rect[$i]['x2'].",".$this->array_rect[$i]['y2']."\" ";
					$html .= "href=\"".createHrefLink($this->array_rect[$i]['link']->getLink(), $this->array_rect[$i]['link']->getTarget())."\" ";
					$html .= "alt=\"".str_replace("\"", " ", $this->array_rect[$i]['title'])."\" title=\"".str_replace("\"", " ", $this->array_rect[$i]['title'])."\"";
					if ($this->array_rect[$i]['onclick_js'] != "") {
						$html .= " onClick=\"".str_replace("\n", "", $this->array_rect[$i]['onclick_js'])."\"";
					}
					if ($this->array_rect[$i]['onmouseover_js'] != "") {
						$html .= " onMouseOver=\"".str_replace("\n", "", $this->array_rect[$i]['onmouseover_js'])."\"";
					}
					if ($this->array_rect[$i]['onmouseout_js'] != "") {
						$html .= " onMouseOut=\"".str_replace("\n", "", $this->array_rect[$i]['onmouseout_js'])."\"";
					}
					$html .= ">\n";
					$ind++;
				}
			}
			
			for ($i=0; $i < sizeof($this->array_circle); $i++) {
				if ($this->array_circle[$i]['link']->getUserHaveRights()) {
					$html .= "	<area shape=\"circle\" coords=\"";
					$html .= $this->array_circle[$i]['x'].",".$this->array_circle[$i]['y'].",".$this->array_circle[$i]['r']."\" ";
					$html .= "href=\"".createHrefLink($this->array_circle[$i]['link']->getLink(), $this->array_circle[$i]['link']->getTarget())."\" ";
					$html .= "alt=\"".str_replace("\"", " ", $this->array_circle[$i]['title'])."\" title=\"".str_replace("\"", " ", $this->array_circle[$i]['title'])."\"";
					if ($this->array_circle[$i]['onclick_js'] != "") {
						$html .= " onClick=\"".str_replace("\n", "", $this->array_circle[$i]['onclick_js'])."\"";
					}
					if ($this->array_circle[$i]['onmouseover_js'] != "") {
						$html .= " onMouseOver=\"".str_replace("\n", "", $this->array_circle[$i]['onmouseover_js'])."\"";
					}
					if ($this->array_circle[$i]['onmouseout_js'] != "") {
						$html .= " onMouseOut=\"".str_replace("\n", "", $this->array_circle[$i]['onmouseout_js'])."\"";
					}
					$html .= ">\n";
					$ind++;
				}
			}
			
			if ($this->default_link != "") {
				if ($this->default_link->getUserHaveRights()) {
					$html .= "	<area shape=\"default\" href=\"".createHrefLink($this->default_link->getLink(), $this->default_link->getTarget())."\"";
					if ($this->default_onclick_js != "") {
						$html .= " onClick=\"".str_replace("\n", "", $this->default_onclick_js)."\"";
					}
					if ($this->default_onmouseover_js != "") {
						$html .= " onMouseOver=\"".str_replace("\n", "", $this->default_onmouseover_js)."\"";
					}
					if ($this->default_onmouseout_js != "") {
						$html .= " onMouseOut=\"".str_replace("\n", "", $this->default_onmouseout_js)."\"";
					}
					$html .= ">\n";
					$ind++;
				}
			}
			$html .= "</map>\n";
			
			if ($this->default_tooltip_obj != null) {
				$html .= $this->getJavascriptTagOpen();
				$html .= "$(document).ready(function() { $('#".$this->getId()."').find('area').qtip({ content: { attr: 'alt' }, style: { widget: true }";
				if (trim($this->default_tooltip_obj->getParams()) != "") {
					$html .= ", ".$this->default_tooltip_obj->getParams();
				}
				$html .= " }); });";
				$html .= $this->getJavascriptTagClose();
			}
			
			$this->is_render = true;
			$this->object_change = false;
		}
		return $html;
	}
}
?>
