<?php
/**
 * PHP file wsp\class\display\Picture.class.php
 * @package display
 */
/**
 * Class Picture
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
 * @copyright   WebSite-PHP.com 22/10/2010
 * @version     1.0.79
 * @access      public
 * @since       1.0.17
 */

class Picture extends WebSitePhpObject {
	/**#@+
	* Align
	* @access public
	* @var string
	*/
	const ALIGN_LEFT = "left";
	const ALIGN_MIDDLE = "middle";
	const ALIGN_ABSMIDDLE = "absmiddle";
	const ALIGN_RIGHT = "right";
	const ALIGN_CENTER = "center";
	/**#@-*/
	
	private static $array_lightbox = array();
	
	/**#@+
	* @access private
	*/
	private $src = "";
	private $height = 0;
	private $width = 0;
	private $border = 0;
	private $align = "";
	private $title = "";
	private $alt = "";
	private $hspace = 0;
	private $vspace = 0;
	private $id = "";
	private $tooltip_obj = null;
	private $picture_map = "";
	
	private $is_lightbox = false;
	private $lightbox_name = "";
	private $pic_link = "";
	/**#@-*/
	
	/**
	 * Constructor Picture
	 * @param mixed $src 
	 * @param double $height [default value: 0]
	 * @param double $width [default value: 0]
	 * @param double $border [default value: 0]
	 * @param string $align 
	 * @param string $title 
	 */
	function __construct($src, $height=0, $width=0, $border=0, $align='', $title='') {
		parent::__construct();
		
		if (!isset($src)) {
			throw new NewException("1 argument for ".get_class($this)."::__construct() is mandatory", 0, 8, __FILE__, __LINE__);
		}
		
		$this->src = $src;
		$this->height = $height;
		$this->width = $width;
		$this->border = $border;
		$this->align = $align;
		$this->title = $title;
	}
	
	/**
	 * Method setId
	 * @access public
	 * @param mixed $id 
	 * @return Picture
	 * @since 1.0.35
	 */
	public function setId($id) {
		$this->id = $id;
		return $this;
	}
	
	/**
	 * Method setHeight
	 * @access public
	 * @param integer $height 
	 * @return Picture
	 * @since 1.0.35
	 */
	public function setHeight($height) {
		$this->height = $height;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setWidth
	 * @access public
	 * @param integer $width 
	 * @return Picture
	 * @since 1.0.35
	 */
	public function setWidth($width) {
		$this->width = $width;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setBorder
	 * @access public
	 * @param mixed $border 
	 * @return Picture
	 * @since 1.0.35
	 */
	public function setBorder($border) {
		$this->border = $border;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setAlign
	 * @access public
	 * @param string $align 
	 * @return Picture
	 * @since 1.0.35
	 */
	public function setAlign($align) {
		$this->align = $align;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setTitle
	 * @access public
	 * @param mixed $title 
	 * @return Picture
	 * @since 1.0.35
	 */
	public function setTitle($title) {
		$this->title = $title;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setAlt
	 * @access public
	 * @param mixed $alt 
	 * @return Picture
	 * @since 1.0.35
	 */
	public function setAlt($alt) {
		$this->alt = $alt;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setHspace
	 * @access public
	 * @param mixed $hspace 
	 * @return Picture
	 * @since 1.0.35
	 */
	public function setHspace($hspace) {
		$this->hspace = $hspace;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setVspace
	 * @access public
	 * @param mixed $vspace 
	 * @return Picture
	 * @since 1.0.35
	 */
	public function setVspace($vspace) {
		$this->vspace = $vspace;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method addLightbox
	 * @access public
	 * @param string $lightbox_name 
	 * @param string $pic_link 
	 * @return Picture
	 * @since 1.0.35
	 */
	public function addLightbox($lightbox_name='', $pic_link='') {
		$this->is_lightbox = true;
		$this->lightbox_name = $lightbox_name;
		$this->pic_link = $pic_link;
		
		if (!isset(self::$array_lightbox[$this->lightbox_name])) {
			self::$array_lightbox[$this->lightbox_name] = false;
		}
		
		$this->addCss(BASE_URL."wsp/css/jquery.lightbox-0.5.css", "", true);
		$this->addJavaScript(BASE_URL."wsp/js/jquery.lightbox-0.5.min.js", "", true);
		
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method tooltip
	 * @access public
	 * @param ToolTip $tooltip_obj 
	 * @return Picture
	 * @since 1.0.35
	 */
	public function tooltip($tooltip_obj) {
		if (get_class($tooltip_obj) != "ToolTip") {
			throw new NewException("Error Picture->tooltip(): \$tooltip_obj is not a ToolTip object", 0, 8, __FILE__, __LINE__);
		}
		$this->tooltip_obj = $tooltip_obj;
		
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setPictureMap
	 * @access public
	 * @param mixed $picture_map 
	 * @return Picture
	 * @since 1.0.35
	 */
	public function setPictureMap($picture_map) {
		if (gettype($picture_map) != "object" && get_class($picture_map) != "PictureMap") {
			throw new NewException(get_class($this)."->setPictureMap() error: \$picture_map must be a PictureMap object", 0, 8, __FILE__, __LINE__);
		}
		
		$this->picture_map = $picture_map;
		
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method getSrc
	 * @access public
	 * @return mixed
	 * @since 1.0.35
	 */
	public function getSrc() {
		return $this->src;
	}
	
	/**
	 * Method getHeight
	 * @access public
	 * @return mixed
	 * @since 1.0.35
	 */
	public function getHeight() {
		return $this->height;
	}

	/**
	 * Method getWidth
	 * @access public
	 * @return mixed
	 * @since 1.0.35
	 */
	public function getWidth() {
		return $this->width;
	}
	
	/**
	 * Method getId
	 * @access public
	 * @return mixed
	 * @since 1.0.35
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * Method render
	 * @access public
	 * @param boolean $ajax_render [default value: false]
	 * @return string html code of object Picture
	 * @since 1.0.35
	 */
	public function render($ajax_render=false) {
		$html = "";
		$align_center = false;
		if ($this->align == Picture::ALIGN_CENTER) {
			$html .= "<div align='center'>\n\t";
			$align_center = true;
			$this->align = "";
		}
		if ($this->is_lightbox) {
			$html .= "<a href='";
			if ($this->pic_link != "") {
				$html .= $this->pic_link;
			} else {
				$html .= $this->src;
			}
			$html .= "' rel='lightbox";
			if ($this->lightbox_name != "") {
				$html .= $this->lightbox_name;
			}
			$html .= "'";
			if ($this->title != "") {
				$html .= " title='".str_replace("'", "&#39;", str_replace("\"", "&quot;", $this->title))."'";
			}
			$html .= ">";
		}
		if (strtoupper(substr($this->src, 0, 7)) != "HTTP://") {
			$this->src = BASE_URL.$this->src;
		}
		$html .= "<img src='".$this->src."'";
		if ($this->id != "") {
			$html .= " id='".$this->id."'";
		}
		if ($this->height != 0) {
			$html .= " height='".$this->height."'";
		}
		if ($this->width != 0) {
			$html .= " width='".$this->width."'";
		}
		$html .= " border='".$this->border."'";
		if ($this->align != "") {
			if ($this->align == Picture::ALIGN_ABSMIDDLE) {
				$html .= " style='vertical-align:middle;'";
			} else {
				$html .= " align='".$this->align."'";
			}
		}
		if (gettype($this->title) == "object" && method_exists($this->title, "render")) {
			$this->title = $this->title->render();
		}
		if ($this->title != "") {
			$html .= " title='".str_replace("'", "&#39;", str_replace("\"", "&quot;", strip_tags($this->title)))."'";
			if ($this->alt == "") {
				$html .= " alt='".str_replace("'", "&#39;", str_replace("\"", "&quot;", strip_tags($this->title)))."'";
			}
		}
		if (gettype($this->alt) == "object" && method_exists($this->alt, "render")) {
			$this->alt = $this->alt->render();
		}
		if ($this->alt != "") {
			$html .= " alt='".str_replace("'", "&#39;", str_replace("\"", "&quot;", strip_tags($this->alt)))."'";
		}
		if ($this->hspace > 0) {
			$html .= " hspace='".$this->hspace."'";
		}
		if ($this->vspace > 0) {
			$html .= " vspace='".$this->vspace."'";
		}
		if ($this->picture_map != "") {
			$html .= " usemap='#".$this->picture_map->getId()."'";
		}
		$html .= "/>\n";
		
		if ($this->is_lightbox) {
			$html .= "</a>";
		}
		if ($align_center) {
			$html .= "</div>\n";
		}
		if ($this->picture_map != "") {
			$html .= $this->picture_map->render();
		}
		
		if ($this->is_lightbox) {
			if (!self::$array_lightbox[$this->lightbox_name]) {
				$html .= $this->getJavascriptTagOpen();
				$html .= "$(function() { $('a[rel=lightbox";
				if ($this->lightbox_name != "") {
					$html .= $this->lightbox_name;
				}
				$html .= "]').lightBox(); });\n";
				$html .= $this->getJavascriptTagClose();
				self::$array_lightbox[$this->lightbox_name] = true;
			}
		}
		if ($this->tooltip_obj != null) {
			$this->tooltip_obj->setId($this->getId());
			$html .= $this->getJavascriptTagOpen();
			$html .= $this->tooltip_obj->render();
			$html .= $this->getJavascriptTagClose();
		}
		$this->object_change = false;
		return $html;
	}
}
?>
