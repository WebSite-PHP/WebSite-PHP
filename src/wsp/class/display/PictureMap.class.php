<?php
/**
 * PHP file wsp\class\display\PictureMap.class.php
 * @package display
 */
/**
 * Class PictureMap
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2011 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package display
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 26/05/2011
 * @version     1.0.91
 * @access      public
 * @since       1.0.17
 */

// tools: http://www.image-maps.com/
class PictureMap extends WebSitePhpObject {
	/**#@+
	* @access private
	*/
	private $id = "";
	private $default_tooltip_obj=null;
	
	private $array_rect = array();
	private $array_polygon = array();
	private $array_circle = array();
	private $default_link = "";
	private $default_link_title = "";
	/**#@-*/
	
	/**
	 * Constructor PictureMap
	 * @param string $id 
	 * @param ToolTip $default_tooltip_obj [default value: null]
	 */
	function __construct($id, $default_tooltip_obj=null) {
		parent::__construct();
		
		if (!isset($id)) {
			throw new NewException("1 argument for ".get_class($this)."::__construct() is mandatory", 0, 8, __FILE__, __LINE__);
		}
		
		$this->id = $id;
		if ($default_tooltip_obj != null) {
			if (get_class($default_tooltip_obj) != "ToolTip") {
				throw new NewException("Error ".get_class($this)."::__construct(): \$default_tooltip_obj is not a ToolTip object", 0, 8, __FILE__, __LINE__);
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
	 * @return PictureMap
	 * @since 1.0.35
	 */
	public function addRect($link, $title, $x1, $y1, $x2, $y2) {
		if (gettype($link) != "object" || get_class($link) != "Link") {
			throw new NewException(get_class($this)."->addRect() error: \$link must be a Link object", 0, 8, __FILE__, __LINE__);
		}
		
		$ind = sizeof($this->array_rect);
		$this->array_rect[$ind] = array();
		$this->array_rect[$ind]['link'] = $link;
		$this->array_rect[$ind]['title'] = $title;
		
		if (!is_integer($x1) || !is_integer($y1) || !is_integer($x2) || !is_integer($y2)) {
			throw new NewException(get_class($this)."->addRect() error: \$x1, \$y1, \$x2, \$y2 must be integer values", 0, 8, __FILE__, __LINE__);
		}
		
		$this->array_rect[$ind]['x1'] = $x1;
		$this->array_rect[$ind]['y1'] = $y1;
		$this->array_rect[$ind]['x2'] = $x2;
		$this->array_rect[$ind]['y2'] = $y2;
		
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
	 * @return PictureMap
	 * @since 1.0.35
	 */
	public function addPolygon($link, $title, $x1=null, $y1=null, $x2=null, $y2=null, $x3=null, $y3=null) {
		if (gettype($link) != "object" || get_class($link) != "Link") {
			throw new NewException(get_class($this)."->addPolygon() error: \$link must be a Link object", 0, 8, __FILE__, __LINE__);
		}
		
		$ind = sizeof($this->array_polygon);
		$this->array_polygon[$ind] = array();
		$this->array_polygon[$ind]['link'] = $link;
		$this->array_polygon[$ind]['title'] = $title;
		$args = func_get_args();
		for ($i=3; $i < sizeof($args); $i++) {
			if (!is_integer($args[$i])) {
				throw new NewException(get_class($this)."->addPolygon() error: \$x1, \$y1, \$x2, \$y2, \$x3, \$y3, ... must be integer values", 0, 8, __FILE__, __LINE__);
			}
    		$this->array_polygon[$ind][$i-3] = $args[$i];
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
	 * @return PictureMap
	 * @since 1.0.35
	 */
	public function addCircle($link, $title, $x, $y, $r) {
		if (gettype($link) != "object" || get_class($link) != "Link") {
			throw new NewException(get_class($this)."->addCircle() error: \$link must be a Link object", 0, 8, __FILE__, __LINE__);
		}
		
		$ind = sizeof($this->array_circle);
		$this->array_circle[$ind] = array();
		$this->array_circle[$ind]['link'] = $link;
		$this->array_circle[$ind]['title'] = $title;
		
		if (!is_integer($x) || !is_integer($y) || !is_integer($r)) {
			throw new NewException(get_class($this)."->addCircle() error: \$x, \$y, \$r must be integer values", 0, 8, __FILE__, __LINE__);
		}
		
		$this->array_circle[$ind]['x'] = $x;
		$this->array_circle[$ind]['y'] = $y;
		$this->array_circle[$ind]['r'] = $r;
		
		return $this;
	}
	
	/**
	 * Method setDefault
	 * Define the default link on the picture
	 * @access public
	 * @param string $link link when click on the picture
	 * @param string $title title of the link area
	 * @return PictureMap
	 * @since 1.0.35
	 */
	public function setDefault($link, $title='') {
		if (gettype($link) != "object" || get_class($link) != "Link") {
			throw new NewException(get_class($this)."->setDefault() error: \$link must be a Link object", 0, 8, __FILE__, __LINE__);
		}
		
		$this->default_link = $link;
		$this->default_link_title = $title;
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
		
		$ind = 0;
		$html .= "<map name=\"".$this->getId()."\" id=\"".$this->getId()."\">\n";
		for ($i=0; $i < sizeof($this->array_polygon); $i++) {
			if ($this->array_polygon[$i]['link']->getUserHaveRights()) {
				$html .= "	<area shape=\"poly\" coords=\"";
				$coords = "";
				for($j=0; $j < sizeof($this->array_polygon[$i]); $j++) {
					if ($this->array_polygon[$i][$j] != "") {
						if ($coords != "") { $coords .= ","; }
						$coords .= $this->array_polygon[$i][$j];
					}
				}
				$html .= $coords."\" ";
				$html .= "href=\"".createHrefLink($this->array_polygon[$i]['link']->getLink(), $this->array_polygon[$i]['link']->getTarget())."\" ";
				$html .= "alt=\"".str_replace("\"", " ", $this->array_polygon[$i]['title'])."\" title=\"".str_replace("\"", " ", $this->array_polygon[$i]['title'])."\">\n";
				$ind++;
			}
		}
		
		for ($i=0; $i < sizeof($this->array_rect); $i++) {
			if ($this->array_rect[$i]['link']->getUserHaveRights()) {
				$html .= "	<area shape=\"rect\" coords=\"";
				$html .= $this->array_rect[$i]['x1'].",".$this->array_rect[$i]['y1'].",".$this->array_rect[$i]['x2'].",".$this->array_rect[$i]['y2']."\" ";
				$html .= "href=\"".createHrefLink($this->array_rect[$i]['link']->getLink(), $this->array_rect[$i]['link']->getTarget())."\" ";
				$html .= "alt=\"".str_replace("\"", " ", $this->array_rect[$i]['title'])."\" title=\"".str_replace("\"", " ", $this->array_rect[$i]['title'])."\">\n";
				$ind++;
			}
		}
		
		for ($i=0; $i < sizeof($this->array_circle); $i++) {
			if ($this->array_circle[$i]['link']->getUserHaveRights()) {
				$html .= "	<area shape=\"circle\" coords=\"";
				$html .= $this->array_circle[$i]['x'].",".$this->array_circle[$i]['y'].",".$this->array_circle[$i]['r']."\" ";
				$html .= "href=\"".createHrefLink($this->array_circle[$i]['link']->getLink(), $this->array_circle[$i]['link']->getTarget())."\" ";
				$html .= "alt=\"".str_replace("\"", " ", $this->array_circle[$i]['title'])."\" title=\"".str_replace("\"", " ", $this->array_circle[$i]['title'])."\">\n";
				$ind++;
			}
		}
		
		if ($this->default_link != "") {
			if ($this->default_link->getUserHaveRights()) {
				$html .= "	<area shape=\"default\" href=\"".createHrefLink($this->default_link->getLink(), $this->default_link->getTarget())."\">\n";
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
		
		$this->object_change = false;
		return $html;
	}
}
?>
