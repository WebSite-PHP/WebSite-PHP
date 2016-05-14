<?php
/**
 * PHP file wsp\class\display\Picture.class.php
 * @package display
 */
/**
 * Class Picture
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2016 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package display
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 10/05/2016
 * @version     1.2.14
 * @access      public
 * @since       1.0.17
 */

class Picture extends WebSitePhpEventObject {
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
    const ALIGN_TOP = "top";
	/**#@-*/
	
	private static $array_lightbox_last_pic = array();
	
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
	private $tooltip_obj = null;
	private $picture_map = "";
	private $style = "";
	
	private $is_lightbox = false;
	private $lightbox_name = "";
	private $pic_link = "";
	private $lightbox_max_width = "";
	private $lightbox_max_height = "";
	private $itemprop = false;
	
	private $onclick = "";
	private $callback_onclick = "";
	private $is_clicked = false;
	private $onload = "";
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
			throw new NewException("1 argument for ".get_class($this)."::__construct() is mandatory", 0, getDebugBacktrace(1));
		}
		
		$this->src = $src;
		$this->height = $height;
		$this->width = $width;
		$this->border = $border;
		$this->align = $align;
		$this->title = $title;
	}
	
	/**
	 * Method setSrc
	 * @access public
	 * @param mixed $src 
	 * @return Picture
	 * @since 1.0.88
	 */
	public function setSrc($src) {
		if (!isset($this->id) || $this->id == "") {
			throw new NewException(get_class($this)."->setSrc() error: You must define an id to the Picture to change the source.", 0, getDebugBacktrace(1));
		}
		
		$this->src = $src;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
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
		$this->name = $this->id;
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
	 * Method preloadPicture
	 * @access public
	 * @return Picture
	 * @since 1.0.99
	 */
	public function preloadPicture() {
		if (strtoupper(substr($this->src, 0, 7)) != "HTTP://" && strtoupper(substr($this->src, 0, 8)) != "HTTPS://" && strtoupper(substr($this->src, 0, 5)) != "DATA:") {
			$src = $this->getPage()->getCDNServerURL().$this->src;
		} else {
			$src = $this->src;
		}
		new JavaScript("$(document).ready( function() { PreloadPicture('".addslashes($src)."'); } );", 1);
		return $this;
	}
	
	/**
	 * Method addLightbox
	 * @access public
	 * @param string $lightbox_name 
	 * @param string $pic_link 
	 * @param string $max_width 
	 * @param string $max_height 
	 * @return Picture
	 * @since 1.0.35
	 */
	public function addLightbox($lightbox_name='', $pic_link='', $max_width='', $max_height='') {
		$this->is_lightbox = true;
		$this->lightbox_name = $lightbox_name;
		if ($pic_link != "") {
			if (strtoupper(substr($pic_link, 0, 7)) != "HTTP://" && strtoupper(substr($pic_link, 0, 8)) != "HTTPS://" && strtoupper(substr($this->src, 0, 5)) != "DATA:") {
				$pic_link = $this->getPage()->getCDNServerURL().$pic_link;
			}
		}
		$this->pic_link = $pic_link;
		$this->lightbox_max_width = $max_width;
		$this->lightbox_max_height = $max_height;
		
		self::$array_lightbox_last_pic[$this->lightbox_name] = $this;
		
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
			throw new NewException("Error Picture->tooltip(): \$tooltip_obj is not a ToolTip object", 0, getDebugBacktrace(1));
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
			throw new NewException(get_class($this)."->setPictureMap() error: \$picture_map must be a PictureMap object", 0, getDebugBacktrace(1));
		}
		
		$this->picture_map = $picture_map;
		
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setItemProp
	 * @access public
	 * @return Picture
	 * @since 1.1.1
	 */
	public function setItemProp() {
		$this->itemprop = true;
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
	 * Method getTitle
	 * @access public
	 * @return mixed
	 * @since 1.2.14
	 */
	public function getTitle() {
		return $this->title;
	}
	
	/**
	 * Method onClick
	 * @access public
	 * @param Page $page_object 
	 * @param string $str_function 
	 * @param mixed $arg1 [default value: null]
	 * @param mixed $arg2 [default value: null]
	 * @param mixed $arg3 [default value: null]
	 * @param mixed $arg4 [default value: null]
	 * @param mixed $arg5 [default value: null]
	 * @return Picture
	 * @since 1.0.85
	 */
	public function onClick($page_object, $str_function, $arg1=null, $arg2=null, $arg3=null, $arg4=null, $arg5=null) {
		if (!isset($page_object) || gettype($page_object) != "object" || !is_subclass_of($page_object, "Page")) {
			throw new NewException("Argument page_object for ".get_class($this)."->onClick() error", 0, getDebugBacktrace(1));
		}
		$this->class_name = get_class($page_object);
		$this->page_object = $page_object;
		$this->form_object = null;
		
		if ($this->id == "") {
			$this->id = $this->page_object->createObjectName($this);
		} else {
			$exist_object = $this->page_object->existsObjectName($this->id);
			if ($exist_object != false) {
				throw new NewException("Tag id \"".$this->id."\" for object ".get_class($this)." already use for other object ".get_class($exist_object), 0, getDebugBacktrace(1));
			}
			$this->page_object->addEventObject($this, $this->form_object);
		}
		$this->name = $this->id;
		
		$args = func_get_args();
		$page_object = array_shift($args);
		$str_function = array_shift($args);
		$this->callback_onclick = $this->loadCallbackMethod($str_function, $args);
		return $this;
	}
	
	/**
	 * Method onClickJs
	 * @access public
	 * @param string|JavaScript $js_function 
	 * @return Picture
	 * @since 1.0.85
	 */
	public function onClickJs($js_function) {
		if (gettype($js_function) != "string" && get_class($js_function) != "JavaScript" && !is_subclass_of($js_function, "JavaScript")) {
			throw new NewException(get_class($this)."->onClickJs(): \$js_function must be a string or JavaScript object.", 0, getDebugBacktrace(1));
		}
		if (get_class($js_function) == "JavaScript" || is_subclass_of($js_function, "JavaScript")) {
			$js_function = $js_function->render();
		}
		
		if ($this->page_object == null) {
			$this->class_name = get_class($page_object);
			$this->page_object = $this->getPage();
		}
		
		$this->onclick = trim($js_function);
		return $this;
	}
	
	/* Intern management of Object */
	/**
	 * Method setClick
	 * @access public
	 * @return Picture
	 * @since 1.0.85
	 */
	public function setClick() {
		if ($GLOBALS['__LOAD_VARIABLES__']) { 
			$this->is_clicked = true; 
		}
		return $this;
	}
	
	/**
	 * Method isClicked
	 * @access public
	 * @return mixed
	 * @since 1.0.85
	 */
	public function isClicked() {
		if ($this->callback_onclick == "") {
			throw new NewException(get_class($this)."->isClicked(): this method can be used only if an onClick event is defined on this ".get_class($this).".", 0, getDebugBacktrace(1));
		}
		if (!$this->is_clicked) {
			if (isset($_POST["Callback_".$this->getEventObjectName()]) && $_POST["Callback_".$this->getEventObjectName()] != "") {
				$this->is_clicked = true;
			} else if (isset($_GET["Callback_".$this->getEventObjectName()]) && $_GET["Callback_".$this->getEventObjectName()] != "") {
				$this->is_clicked = true;
			}
		}
		return $this->is_clicked;
	}
	
	/**
	 * Method onLoadJs
	 * @access public
	 * @param mixed $js_function 
	 * @return Picture
	 * @since 1.0.98
	 */
	public function onLoadJs($js_function) {
		if (gettype($js_function) != "string" && get_class($js_function) != "JavaScript" && !is_subclass_of($js_function, "JavaScript")) {
			throw new NewException(get_class($this)."->onClickJs(): \$js_function must be a string or JavaScript object.", 0, getDebugBacktrace(1));
		}
		if (get_class($js_function) == "JavaScript" || is_subclass_of($js_function, "JavaScript")) {
			$js_function = $js_function->render();
		}
		
		if ($this->page_object == null) {
			$this->class_name = get_class($page_object);
			$this->page_object = $this->getPage();
		}
		
		$this->onload = trim($js_function);
		return $this;
	}
	
	/**
	 * Method setStyle
	 * @access public
	 * @param mixed $style 
	 * @return Picture
	 * @since 1.0.85
	 */
	public function setStyle($style) {
		$this->style = $style;
		
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method render
	 * @access public
	 * @param boolean $ajax_render [default value: false]
	 * @return string html code of object Picture
	 * @since 1.0.35
	 */
	public function render($ajax_render=false) {
		$this->automaticAjaxEvent();
		
		$html = "";
		if ($this->callback_onclick != "") {
			$html .= "<input type='hidden' id='Callback_".$this->getEventObjectName()."' name='Callback_".$this->getEventObjectName()."' value=''/>\n";
			if ($this->is_ajax_event && !$ajax_render) {
				$html .= $this->getJavascriptTagOpen();
				$html .= $this->getAjaxEventFunctionRender();
				$html .= $this->getJavascriptTagClose();
			}
		}
		
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
				if ($this->tooltip_obj == null) {
					$html .= " title='";
				} else {
					$html .= " oldtitle='";
				}
				$html .= str_replace("'", "&#39;", str_replace("\"", "&quot;", $this->title))."'";
			}
			$html .= ">";
		}
		if (strtoupper(substr($this->src, 0, 7)) != "HTTP://" && strtoupper(substr($this->src, 0, 8)) != "HTTPS://" && strtoupper(substr($this->src, 0, 5)) != "DATA:") {
			$this->src = $this->getPage()->getCDNServerURL().$this->src;
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
		if ($this->align != "" || $this->onclick != "" || $this->callback_onclick != "" || $this->style != "") {
			$style_pic = false;
			if ($this->align == Picture::ALIGN_ABSMIDDLE) {
				$html .= " style='vertical-align:middle;";
				$style_pic = true;
			} else {
				$html .= " align='".$this->align."'";
			}
			if ($this->onclick != "" || $this->callback_onclick != "") {
				if (!$style_pic) { $html .= " style='"; }
				$html .= "cursor:pointer;";
				$style_pic = true;
			}
			if ($this->style != "") {
				if (!$style_pic) { $html .= " style='"; }
				$html .= $this->style;
				$style_pic = true;
			}
			if ($style_pic) { $html .= "'"; }
		}
		if (gettype($this->title) == "object" && method_exists($this->title, "render")) {
			$this->title = $this->title->render();
		}
		if ($this->title != "") {
			$html .= " title='".str_replace("'", "&#39;", str_replace("\"", "&quot;", str_replace("\n", "", str_replace("\r", "", $this->title))))."'";
			if ($this->alt == "") {
				$html .= " alt='".str_replace("'", "&#39;", str_replace("\"", "&quot;", str_replace("\n", "", str_replace("\r", "", $this->title))))."'";
			}
		}
		if (gettype($this->alt) == "object" && method_exists($this->alt, "render")) {
			$this->alt = $this->alt->render();
		}
		if ($this->alt != "") {
			$html .= " alt='".str_replace("'", "&#39;", str_replace("\"", "&quot;", str_replace("\n", "", str_replace("\r", "", $this->alt))))."'";
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
		if ($this->onclick != "" || $this->callback_onclick != "") {
			$html .= " onClick=\"".str_replace("\n", "", $this->getObjectEventValidationRender($this->onclick, $this->callback_onclick));
			if ($this->is_ajax_event) {
				$html .= "return false;";
			}
			$html .= "\"";
		}
		if ($this->onload != "") {
			$html .= " onLoad=\"".str_replace("\n", "", $this->onload)."\"";
		}
		if ($this->itemprop) {
			$html .= " itemprop=\"image\"";
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
			if (self::$array_lightbox_last_pic[$this->lightbox_name] == $this) {
				$html .= $this->getJavascriptTagOpen();
				$html .= "$('a[rel=lightbox";
				if ($this->lightbox_name != "") {
					$html .= $this->lightbox_name;
				}
				$html .= "]').lightBox(";
				$html .= "{";
				if ($this->lightbox_max_width != "") {
					$html .= "maxWidth: ".$this->lightbox_max_width;
				} else {
					$html .= "maxWidth: $(window).width()*0.9";
				}
				$html .= ", ";
				if ($this->lightbox_max_height != "") {
					$html .= "maxHeight: ".$this->lightbox_max_height;
				} else {
					$html .= "maxHeight: $(window).height()*0.9";
				}
				$html .= "}";
				$html .= ");\n";
				$html .= $this->getJavascriptTagClose();
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
	
	/**
	 * Method getAjaxRender
	 * @access public
	 * @return string javascript code to update initial html of object Picture (call with AJAX)
	 * @since 1.0.88
	 */
	public function getAjaxRender() {
		$html = "";
		if ($this->object_change && !$this->is_new_object_after_init) {
			$html .= "$('#".$this->getId()."').attr('src', '".$this->src."');";
			if ($this->height != 0) {
				$html .= "$('#".$this->getId()."').attr('height', '".$this->height."');";
			}
			if ($this->width != 0) {
				$html .= "$('#".$this->getId()."').attr('width', '".$this->width."');";
			}
			$html .= "$('#".$this->getId()."').attr('border', '".$this->border."');";
			if ($this->style != "") {
				$html .= "$('#".$this->getId()."').attr('style', '".$this->style."');";
			}
			
			if (gettype($this->title) == "object" && method_exists($this->title, "render")) {
				$this->title = $this->title->render();
			}
			if ($this->title != "") {
				$html .= "$('#".$this->getId()."').attr('title', '".str_replace("'", "&#39;", str_replace("\"", "&quot;", strip_tags($this->title)))."');";
				if ($this->alt == "") {
					$html .= "$('#".$this->getId()."').attr('alt', '".str_replace("'", "&#39;", str_replace("\"", "&quot;", strip_tags($this->title)))."');";
				}
			}
			if (gettype($this->alt) == "object" && method_exists($this->alt, "render")) {
				$this->alt = $this->alt->render();
			}
			if ($this->alt != "") {
				$html .= "$('#".$this->getId()."').attr('alt', '".str_replace("'", "&#39;", str_replace("\"", "&quot;", strip_tags($this->alt)))."';";
			}
			if ($this->hspace > 0) {
				$html .= "$('#".$this->getId()."').attr('hspace', '".$this->hspace."');";
			}
			if ($this->vspace > 0) {
				$html .= "$('#".$this->getId()."').attr('vspace', '".$this->vspace."');";
			}
		}
		return $html;
	}
}
?>
