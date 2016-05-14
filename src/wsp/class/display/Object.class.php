<?php
/**
 * PHP file wsp\class\display\Object.class.php
 * @package display
 */
/**
 * Class Object
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
 * @copyright   WebSite-PHP.com 11/05/2016
 * @version     1.2.14
 * @access      public
 * @since       1.0.17
 */

class Object extends WebSitePhpEventObject {
	/**#@+
	* align properties
	* @access public
	* @var string
	*/
	const ALIGN_LEFT = "left";
	const ALIGN_CENTER = "center";
	const ALIGN_RIGHT = "right";
	/**#@-*/
	
	/**#@+
	* border style properties
	* @access public
	* @var string
	*/
	const BORDER_STYLE_DOTTED = "dotted";
	const BORDER_STYLE_DASHED = "dashed";
	const BORDER_STYLE_SOLID = "solid";
	const BORDER_STYLE_DOUBLE = "double";
	const BORDER_STYLE_GROOVE = "groove";
	const BORDER_STYLE_RIDGE = "ridge";
	const BORDER_STYLE_INSET = "inset";
	const BORDER_STYLE_OUTSET = "outset";
	/**#@-*/
	
	/**#@+
	* Font family
	* @access public
	* @var string
	*/
	const FONT_ARIAL = "Arial";
	const FONT_TIMES = "Times New Roman";
	/**#@-*/
	
	/**#@+
	* Font weight
	* @access public
	* @var string
	*/
	const FONT_WEIGHT_BOLD = "bold";
	const FONT_WEIGHT_NONE = "none";
	/**#@-*/
	
	
	/**#@+
	* @access private
	*/
	private $objects = array();
	private $objects_after_init = array();
	private $object_is_cleared = false;
	private $align = "";
	private $width = "";
	private $height = "";
	private $min_height = "";
	private $max_height = "";
	private $border = 0;
	private $border_color = "";
	private $border_style = "";
	private $hide_object = false;
	private $style = "";
	private $class = "";
	
	private $itemprop = "";
	private $itemprop_content = "";
	private $itemtype = "";
	private $typeof = "";
	private $xmlns = "";
	private $xmlnsv = "";
	private $property = "";
	
	private $font_size = "";
	private $font_family = "";
	private $font_weight = "";
	
	private $draggable = false;
	private $draggable_revert = false;
	private $draggable_event = null;
	private $draggable_params = "";
	
	private $droppable = false;
	private $droppable_style = "";
	private $droppable_event = null;
	private $droppable_params = "";
	
	private $sortable = false;
	private $sortable_event = null;
	private $sortable_params = "";
	private $sortable_disable_selection = false;
	
	private $onclick = "";
	private $callback_onclick = "";
	private $ondblclick = "";
	private $callback_ondblclick = "";
	private $is_clicked = false;
	private $onmouseover = "";
	private $onmouseout = "";
	
	private $loaded_from_url = false;
	private $force_div_tag = false;
	private $force_span_tag = false;
	
	private $context_menu = null;
	private $tooltip_obj = null;
	/**#@-*/
	
	/**
	 * Constructor Object
	 * @param string|WspObject|Url $str_or_object [default value: null]
	 * @param string|WspObject $str_or_object2 [default value: null]
	 * @param string|WspObject $str_or_object3 [default value: null]
	 * @param string|WspObject $str_or_object4 [default value: null]
	 * @param string|WspObject $str_or_object5 [default value: null]
	 */
	function __construct($str_or_object=null, $str_or_object2=null, $str_or_object3=null, $str_or_object4=null, $str_or_object5=null) {
		parent::__construct();
		
		$args = func_get_args();
		for ($i=0; $i < sizeof($args); $i++) {
    		if ($args[$i] !== null) {
				$this->addObject($args[$i]);
    		}
    	}
	}
	
	/**
	 * Method add
	 * @access public
	 * @param string|WspObject|Url $str_or_object 
	 * @param string|WspObject $str_or_object2 [default value: null]
	 * @param string|WspObject $str_or_object3 [default value: null]
	 * @param string|WspObject $str_or_object4 [default value: null]
	 * @param string|WspObject $str_or_object5 [default value: null]
	 * @return Object
	 * @since 1.0.36
	 */
	public function add($str_or_object, $str_or_object2=null, $str_or_object3=null, $str_or_object4=null, $str_or_object5=null) {
		$args = func_get_args();
		$object = array_shift($args);
		$this->addObject($object);
    	for ($i=0; $i < sizeof($args); $i++) {
    		if ($args[$i] !== null) {
				$this->addObject($args[$i]);
    		}
    	}
    	return $this;
	}
	
	/**
	 * Method addObject
	 * @access private
	 * @param WspObject|DateTime|string $object 
	 * @since 1.0.59
	 */
	private function addObject($object) {
		if (gettype($object) == "object" && get_class($object) == "DateTime") {
			throw new NewException(get_class($this)."->addObject() error: Please format your DateTime object (\$my_date->format(\"Y-m-d H:i:s\"))", 0, getDebugBacktrace(1));
		}
		if ($this->loaded_from_url) {
			throw new NewException("Error Object->addObject(): This object already loaded from url", 0, getDebugBacktrace(1));
		}
		if (gettype($object)=="object" && sizeof($this->objects) > 1 && get_class($object)=="Url") {
			throw new NewException("Error Object->addObject(): You can load Object from Url if there is no other content (or only 1: loading content).", 0, getDebugBacktrace(1));
		}
		if (gettype($object)=="object" && get_class($object)=="Url") {
			$this->loaded_from_url = true;
		}
		$this->objects[sizeof($this->objects)] = $object;
		if ($GLOBALS['__PAGE_IS_INIT__']) {
			$this->object_change =true;
			$this->objects_after_init[sizeof($this->objects_after_init)] = true;
		} else {
			$this->objects_after_init[sizeof($this->objects_after_init)] = false;
		}
	}
	
	/**
	 * Method setAlign
	 * @access public
	 * @param string $align 
	 * @return Object
	 * @since 1.0.36
	 */
	public function setAlign($align) {
		$this->align = $align;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setWidth
	 * @access public
	 * @param integer $width 
	 * @return Object
	 * @since 1.0.36
	 */
	public function setWidth($width) {
		$this->width = $width;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setHeight
	 * @access public
	 * @param integer $height 
	 * @return Object
	 * @since 1.0.36
	 */
	public function setHeight($height) {
		$this->height = $height;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setMinHeight
	 * @access public
	 * @param integer $min_height 
	 * @return Object
	 * @since 1.0.36
	 */
	public function setMinHeight($min_height) {
		if (is_integer($this->min_height)) {
			$this->min_height = $min_height;
		} else {
			$this->min_height = str_replace("px", "", $min_height);
		}
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}

	/**
	 * Method setMaxHeight
	 * @access public
	 * @param mixed $max_height 
	 * @return Object
	 * @since 1.0.97
	 */
	public function setMaxHeight($max_height) {
		if (is_integer($this->max_height)) {
			$this->max_height = $max_height;
		} else {
			$this->max_height = str_replace("px", "", $max_height);
		}
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}

	/**
	 * Method setBorder
	 * @access public
	 * @param integer $border [default value: 1]
	 * @param string $border_color [default value: black]
	 * @param string $border_style [default value: solid]
	 * @return Object
	 * @since 1.0.36
	 */
	public function setBorder($border=1, $border_color="black", $border_style="solid") {
		$this->border = $border;
		$this->border_color = $border_color;
		$this->border_style = $border_style;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setFont
	 * @access public
	 * @param integer $font_size 
	 * @param string $font_family 
	 * @param string $font_weight 
	 * @return Object
	 * @since 1.0.36
	 */
	public function setFont($font_size, $font_family, $font_weight) {
		$this->font_size = $font_size;
		$this->font_family = $font_family;
		$this->font_weight = $font_weight;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
		
	/**
	 * Method setStyle
	 * @access public
	 * @param string $style 
	 * @return Object
	 * @since 1.0.36
	 */
	public function setStyle($style) {
		$this->style = $style;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
		
	/**
	 * Method setClass
	 * @access public
	 * @param string $class 
	 * @return Object
	 * @since 1.0.36
	 */
	public function setClass($class) {
		$this->class = $class;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
		
	/**
	 * Method setId
	 * @access public
	 * @param string $id 
	 * @return Object
	 * @since 1.0.36
	 */
	public function setId($id) {
		$this->id = $id;
		
		$register_objects = WebSitePhpObject::getRegisterObjects();
		$register_objects[] = $this;
		$_SESSION['websitephp_register_object'] = $register_objects;
		
		return $this;
	}

	/**
	 * Method tooltip
	 * @access public
	 * @param mixed $tooltip_obj 
	 * @return Object
	 * @since 1.2.14
	 */
	public function tooltip($tooltip_obj) {
		if (get_class($tooltip_obj) != "ToolTip") {
			throw new NewException("Error Object->tooltip(): \$tooltip_obj is not a ToolTip object", 0, getDebugBacktrace(1));
		}
		$this->tooltip_obj = $tooltip_obj;

		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
		
	/**
	 * Method emptyObject
	 * @access public
	 * @return Object
	 * @since 1.0.36
	 */
	public function emptyObject() {
		$this->objects = array();
		$this->objects_after_init = array();
		$this->object_is_cleared = true;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method getObjects
	 * @access public
	 * @return mixed
	 * @since 1.2.11
	 */
	public function getObjects() {
		return $this->objects;
	}
	
	/**
	 * Method getObject
	 * @access public
	 * @param mixed $index 
	 * @return mixed
	 * @since 1.2.11
	 */
	public function getObject($index) {
		return $this->objects[$index];
	}
		
	/**
	 * Method getId
	 * @access public
	 * @return string
	 * @since 1.0.36
	 */
	public function getId() {
		return "wsp_object_".$this->id;
	}

	/**
	 * Method getStyle
	 * @access public
	 * @return mixed
	 * @since 1.2.13
	 */
    public function getStyle() {
        $html = "";
        if ($this->width != "") {
            if (is_integer($this->width)) {
                $html .= "width:".$this->width."px;";
            } else {
                $html .= "width:".$this->width.";";
            }
        }
        if ($this->height != "") {
            if (is_integer($this->height)) {
                $html .= "height:".$this->height."px;";
            } else {
                $html .= "height:".$this->height.";";
            }
        }
        if ($this->font_size != "") {
            if (is_integer($this->font_size)) {
                $html .= "font-size:".$this->font_size."pt;";
            } else {
                $html .= "font-size:".$this->font_size.";";
            }
        }
        if ($this->font_family != "") {
            $html .= "font-family:".$this->font_family.";";
        }
        if ($this->font_weight != "") {
            $html .= "font-weight:".$this->font_weight.";";
        }
        if ($this->border != "") {
            $html .= "border:";
            if (is_integer($this->border)) {
                $html .= $this->border."px";
            } else {
                $html .= $this->border;
            }
            $html .= " ".$this->border_style." ".$this->border_color.";";
        }
        if ($this->hide_object) {
            $html .= "display:none;";
        }
        if ($this->min_height != "") {
            $html .= "min-height: ".$this->min_height."px;height: expression(this.scrollHeight < ".$this->min_height." ? '".$this->min_height."px' : 'auto');";
        } else if ($this->droppable || $this->sortable) {
            $html .= "min-height: 24px;height: expression(this.scrollHeight < 22 ? '24px' : 'auto');";
        }
        if ($this->max_height != "") {
            $html .= "max-height: ".$this->max_height."px;overflow:auto;".(is_browser_ie()?"overflow-x:scroll;":"")."height: expression(this.scrollHeight > ".$this->max_height." ? '".$this->max_height."px' : 'auto');";
        }
        if ($this->droppable || $this->sortable) {
            $html .= "min-width: 24px;width: expression(this.scrollWidth < 26 ? '26px' : 'auto');";
        }
        if ($this->style != "") {
            $html .= $this->style;
        }
        return $html;
    }

	/**
	 * Method getHeight
	 * @access public
	 * @return mixed
	 * @since 1.2.13
	 */
    public function getHeight() {
        return $this->height;
    }

	/**
	 * Method getWidth
	 * @access public
	 * @return mixed
	 * @since 1.2.13
	 */
    public function getWidth() {
        return $this->width;
    }
	
	/**
	 * Method hide
	 * @access public
	 * @return Object
	 * @since 1.0.36
	 */
	public function hide() {
		if ($this->id == "") {
			throw new NewException("Error Object->hide(): You must specified an id (setId())", 0, getDebugBacktrace(1));
		}
		$this->hide_object = true;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method show
	 * @access public
	 * @return Object
	 * @since 1.0.36
	 */
	public function show() {
		if ($this->id == "") {
			throw new NewException("Error Object->show(): You must specified an id (setId())", 0, getDebugBacktrace(1));
		}
		$this->hide_object = false;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setDraggable
	 * @access public
	 * @param boolean $bool if object can be move [default value: true]
	 * @param boolean $revert if object revert first place when dropped [default value: false]
	 * @param DraggableEvent $draggable_event [default value: null]
	 * @param string $draggable_params 
	 * @return Object
	 * @since 1.0.36
	 */
	public function setDraggable($bool=true, $revert=false, $draggable_event=null, $draggable_params="") {
		if ($this->id == "") {
			throw new NewException("Error Object->setDraggable(): You must specified an id (setId())", 0, getDebugBacktrace(1));
		}
		$this->draggable = $bool;
		$this->draggable_revert = $revert;
		if ($draggable_event != null) {
			if (get_class($draggable_event) != "DraggableEvent") {
				throw new NewException("Error Object->setDraggable(): $draggable_event is not a DraggableEvent object", 0, getDebugBacktrace(1));
			}
			$this->draggable_event = $draggable_event;
			$this->draggable_event->setDraggableId($this->getId());
			if ($this->id == "") {
				throw new NewException("Error Object->setDraggable(): You must specified an id for this object", 0, getDebugBacktrace(1));
			}
		}
		$this->draggable_params = $draggable_params;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method getIsDraggable
	 * @access public
	 * @return boolean
	 * @since 1.0.36
	 */
	public function getIsDraggable() {
		return $this->draggable;
	}
	
	/**
	 * Method setDroppable
	 * @access public
	 * @param boolean $bool if object can be dropped [default value: true]
	 * @param DroppableEvent $droppable_event [default value: null]
	 * @param string $droppable_params 
	 * @param string $droppable_style [default value: droppablehover]
	 * @return Object
	 * @since 1.0.36
	 */
	public function setDroppable($bool=true, $droppable_event=null, $droppable_params="", $droppable_style="droppablehover") {
		if ($this->id == "") {
			throw new NewException("Error Object->setDroppable(): You must specified an id (setId())", 0, getDebugBacktrace(1));
		}
		$this->droppable = $bool;
		$this->droppable_style = $droppable_style;
		$this->droppable_params = $droppable_params;
		if ($droppable_event != null) {
			if (get_class($droppable_event) != "DroppableEvent") {
				throw new NewException("Error Object->setDroppable(): $draggable_event is not a DroppableEvent object", 0, getDebugBacktrace(1));
			}
			$this->droppable_event = $droppable_event;
			$this->droppable_event->setDroppableId($this->getId());
			if ($this->id == "") {
				throw new NewException("Error Object->setDroppable(): You must specified an id for this object", 0, getDebugBacktrace(1));
			}
		}
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method getIsDroppable
	 * @access public
	 * @return boolean
	 * @since 1.0.36
	 */
	public function getIsDroppable() {
		return $this->droppable;
	}
	
	/**
	 * Method setSortable
	 * @access public
	 * @param boolean $bool if object can be sort [default value: true]
	 * @param SortableEvent $sortable_event [default value: null]
	 * @param string $sortable_params 
	 * @param boolean $disable_selection [default value: false]
	 * @return Object
	 * @since 1.0.36
	 */
	public function setSortable($bool=true, $sortable_event=null, $sortable_params="", $disable_selection=false) {
		if ($this->id == "") {
			throw new NewException("Error Object->setSortable(): You must specified an id (setId())", 0, getDebugBacktrace(1));
		}
		$this->sortable = $bool;
		$this->sortable_params = $sortable_params;
		$this->sortable_disable_selection = $disable_selection;
		if ($sortable_event != null) {
			if (get_class($sortable_event) != "SortableEvent") {
				throw new NewException("Error Object->setDraggable(): $sortable_event is not a SortableEvent object", 0, getDebugBacktrace(1));
			}
			$this->sortable_event = $sortable_event;
			$this->sortable_event->setSortableId($this->getId());
			if ($this->id == "") {
				throw new NewException("Error Object->setSortable(): You must specified an id for this object", 0, getDebugBacktrace(1));
			}
		}
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method getIsSortable
	 * @access public
	 * @return boolean
	 * @since 1.0.36
	 */
	public function getIsSortable() {
		return $this->sortable;
	}
	
	/* Intern management of Object */
	/**
	 * Method setClick
	 * @access public
	 * @return Object
	 * @since 1.0.36
	 */
	public function setClick() {
		if ($GLOBALS['__LOAD_VARIABLES__']) { 
			$this->is_clicked = true; 
		}
		return $this;
	}
	
	/**
	 * Method setContextMenu
	 * @access public
	 * @param mixed $context_menu_object 
	 * @return Object
	 * @since 1.0.97
	 */
	public function setContextMenu($context_menu_object) {
		if (get_class($context_menu_object) != "ContextMenu") {
			throw new NewException("Error Object->setContextMenuFile(): $context_menu_object is not a ContextMenu object", 0, getDebugBacktrace(1));
		}
		$this->context_menu = $context_menu_object;
		$this->context_menu->attachContextMenuToObjectId("$(\"#".$this->getId()."\")");
		return $this;
	}
	
	/**
	 * Method getOnClickJs
	 * @access public
	 * @return mixed
	 * @since 1.0.36
	 */
	public function getOnClickJs() {
		return $this->onclick;
	}
	
	/**
	 * Method onClick
	 * @access public
	 * @param Page|Form $page_or_form_object 
	 * @param string $str_function 
	 * @param mixed $arg1 [default value: null]
	 * @param mixed $arg2 [default value: null]
	 * @param mixed $arg3 [default value: null]
	 * @param mixed $arg4 [default value: null]
	 * @param mixed $arg5 [default value: null]
	 * @return Object
	 * @since 1.0.36
	 */
	public function onClick($page_or_form_object, $str_function, $arg1=null, $arg2=null, $arg3=null, $arg4=null, $arg5=null) {
		if ($this->id == "") {
			throw new NewException("Error Object->onClick(): You must specified an id (setId())", 0, getDebugBacktrace(1));
		}
		if (!isset($page_or_form_object) || gettype($page_or_form_object) != "object" || (!is_subclass_of($page_or_form_object, "Page") && get_class($page_or_form_object) != "Form")) {
			throw new NewException("Argument page_or_form_object for ".get_class($this)."::onClick() error", 0, getDebugBacktrace(1));
		}
		
		if (is_subclass_of($page_or_form_object, "Page")) {
			$this->class_name = get_class($page_or_form_object);
			$this->page_object = $page_or_form_object;
			$this->form_object = null;
		} else {
			$this->page_object = $page_or_form_object->getPageObject();
			$this->class_name = get_class($this->page_object)."_".$page_or_form_object->getName();
			$this->form_object = $page_or_form_object;
		}
		$this->name = $this->getId();
		$this->page_object->addEventObject($this);
		
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
	 * @return Object
	 * @since 1.0.36
	 */
	public function onClickJs($js_function) {
		if (gettype($js_function) != "string" && get_class($js_function) != "JavaScript" && !is_subclass_of($js_function, "JavaScript")) {
			throw new NewException(get_class($this)."->onClickJs(): \$js_function must be a string or JavaScript object.", 0, getDebugBacktrace(1));
		}
		if (get_class($js_function) == "JavaScript" || is_subclass_of($js_function, "JavaScript")) {
			$js_function = $js_function->render();
		}
		$this->onclick = trim($js_function);
		return $this;
	}
	
	/**
	 * Method onDblClick
	 * @access public
	 * @param mixed $page_or_form_object 
	 * @param mixed $str_function 
	 * @param mixed $arg1 [default value: null]
	 * @param mixed $arg2 [default value: null]
	 * @param mixed $arg3 [default value: null]
	 * @param mixed $arg4 [default value: null]
	 * @param mixed $arg5 [default value: null]
	 * @return Object
	 * @since 1.0.97
	 */
	public function onDblClick($page_or_form_object, $str_function, $arg1=null, $arg2=null, $arg3=null, $arg4=null, $arg5=null) {
		if ($this->id == "") {
			throw new NewException("Error Object->onDblClick(): You must specified an id (setId())", 0, getDebugBacktrace(1));
		}
		if (!isset($page_or_form_object) || gettype($page_or_form_object) != "object" || (!is_subclass_of($page_or_form_object, "Page") && get_class($page_or_form_object) != "Form")) {
			throw new NewException("Argument page_or_form_object for ".get_class($this)."::onDblClick() error", 0, getDebugBacktrace(1));
		}
		
		if (is_subclass_of($page_or_form_object, "Page")) {
			$this->class_name = get_class($page_or_form_object);
			$this->page_object = $page_or_form_object;
			$this->form_object = null;
		} else {
			$this->page_object = $page_or_form_object->getPageObject();
			$this->class_name = get_class($this->page_object)."_".$page_or_form_object->getName();
			$this->form_object = $page_or_form_object;
		}
		$this->name = $this->getId();
		$this->page_object->addEventObject($this);
		
		$args = func_get_args();
		$page_object = array_shift($args);
		$str_function = array_shift($args);
		
		$this->callback_ondblclick = $this->loadCallbackMethod($str_function, $args);
		
		return $this;
	}
	
	/**
	 * Method onDblClickJs
	 * @access public
	 * @param mixed $js_function 
	 * @return Object
	 * @since 1.0.97
	 */
	public function onDblClickJs($js_function) {
		if (gettype($js_function) != "string" && get_class($js_function) != "JavaScript" && !is_subclass_of($js_function, "JavaScript")) {
			throw new NewException(get_class($this)."->onDblClickJs(): \$js_function must be a string or JavaScript object.", 0, getDebugBacktrace(1));
		}
		if (get_class($js_function) == "JavaScript" || is_subclass_of($js_function, "JavaScript")) {
			$js_function = $js_function->render();
		}
		$this->ondblclick = trim($js_function);
		return $this;
	}

	/**
	 * Method onMouseOverJs
	 * @access public
	 * @param string|JavaScript $js_function 
	 * @return Object
	 * @since 1.0.63
	 */
	public function onMouseOverJs($js_function) {
		if (gettype($js_function) != "string" && get_class($js_function) != "JavaScript" && !is_subclass_of($js_function, "JavaScript")) {
			throw new NewException(get_class($this)."->onMouseOverJs(): \$js_function must be a string or JavaScript object.", 0, getDebugBacktrace(1));
		}
		if (get_class($js_function) == "JavaScript" || is_subclass_of($js_function, "JavaScript")) {
			$js_function = $js_function->render();
		}
		$this->onmouseover = trim($js_function);
		return $this;
	}

	/**
	 * Method onMouseOutJs
	 * @access public
	 * @param string|JavaScript $js_function 
	 * @return Object
	 * @since 1.0.63
	 */
	public function onMouseOutJs($js_function) {
		if (gettype($js_function) != "string" && get_class($js_function) != "JavaScript" && !is_subclass_of($js_function, "JavaScript")) {
			throw new NewException(get_class($this)."->onMouseOutJs(): \$js_function must be a string or JavaScript object.", 0, getDebugBacktrace(1));
		}
		if (get_class($js_function) == "JavaScript" || is_subclass_of($js_function, "JavaScript")) {
			$js_function = $js_function->render();
		}
		$this->onmouseout = trim($js_function);
		return $this;
	}
	
	/**
	 * Method isClicked
	 * @access public
	 * @return boolean
	 * @since 1.0.36
	 */
	public function isClicked() {
		if ($this->callback_onclick == "" && $this->callback_ondblclick == "") {
			throw new NewException(get_class($this)."->isClicked(): this method can be used only if an onClick or onDblClick event is defined on this ".get_class($this).".", 0, getDebugBacktrace(1));
		}
		return $this->is_clicked;
	}
	
	/**
	 * Method forceDivTag
	 * @access public
	 * @return Object
	 * @since 1.0.36
	 */
	public function forceDivTag() {
		$this->force_div_tag = true;
		$this->force_span_tag = false;
	
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method forceSpanTag
	 * @access public
	 * @return Object
	 * @since 1.0.36
	 */
	public function forceSpanTag() {
		$this->force_div_tag = false;
		$this->force_span_tag = true;
	
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setItemProp
	 * @access public
	 * @param mixed $itemprop 
	 * @param string $itemprop_content 
	 * @return Object
	 * @since 1.0.103
	 */
	public function setItemProp($itemprop, $itemprop_content='') {
		if (!$this->force_div_tag && !$this->force_span_tag) {
			$this->forceSpanTag();
		}
		$this->itemprop = $itemprop;
		$this->itemprop_content = $itemprop_content;
		
		return $this;
	}
	
	/**
	 * Method setItemType
	 * @access public
	 * @param mixed $itemtype 
	 * @return Object
	 * @since 1.0.103
	 */
	public function setItemType($itemtype) {
		if (!$this->force_div_tag && !$this->force_span_tag) {
			$this->forceSpanTag();
		}
		$this->itemtype = $itemtype;
		
		return $this;
	}
	
	/**
	 * Method setTypeOf
	 * @access public
	 * @param mixed $typeof 
	 * @return Object
	 * @since 1.1.8
	 */
	public function setTypeOf($typeof) {
		if (!$this->force_div_tag && !$this->force_span_tag) {
			$this->forceSpanTag();
		}
		$this->typeof = $typeof;
		
		return $this;
	}
	
	/**
	 * Method setXmlns
	 * @access public
	 * @param mixed $xmlns 
	 * @return Object
	 * @since 1.1.8
	 */
	public function setXmlns($xmlns) {
		if (!$this->force_div_tag && !$this->force_span_tag) {
			$this->forceSpanTag();
		}
		$this->xmlns = $xmlns;
		
		return $this;
	}
	
	/**
	 * Method setXmlnsV
	 * @access public
	 * @param mixed $xmlnsv 
	 * @return Object
	 * @since 1.1.8
	 */
	public function setXmlnsV($xmlnsv) {
		if (!$this->force_div_tag && !$this->force_span_tag) {
			$this->forceSpanTag();
		}
		$this->xmlnsv = $xmlnsv;
		
		return $this;
	}
	
	/**
	 * Method setProperty
	 * @access public
	 * @param mixed $property 
	 * @return Object
	 * @since 1.1.8
	 */
	public function setProperty($property) {
		if (!$this->force_div_tag && !$this->force_span_tag) {
			$this->forceSpanTag();
		}
		$this->property = $property;
		
		return $this;
	}
	
	/**
	 * Method forceAjaxRender
	 * @access public
	 * @return Object
	 * @since 1.2.14
	 */
	public function forceAjaxRender() {
		$this->object_change = true;
		$this->is_new_object_after_init = false;
		for ($i=0; $i < sizeof($this->objects); $i++) {
			$this->objects_after_init[$i] = true;
		}
		return $this;
	}
	
	/**
	 * Method render
	 * @access public
	 * @param boolean $ajax_render [default value: false]
	 * @return string html code of object Object
	 * @since 1.0.36
	 */
	public function render($ajax_render=false) {
		$this->automaticAjaxEvent();
		
		$html = "";
		$is_span_open = false;
		if ($this->force_div_tag || $this->force_span_tag || $this->id != "" || $this->align != "" || 
			$this->border != "" || $this->width != "" || $this->height != "" || $this->font_size != "" || $this->font_family != "" || 
			$this->font_weight != "" || $this->style != "" || $this->class != "" || $this->min_height != "" || 
			$this->max_height != "" || $this->onclick != "" || $this->ondblclick != "" || 
			$this->onmouseover != "" || $this->onmouseout != "") {
				
			if ($this->force_div_tag || (!$this->force_span_tag &&
				($this->align != "" || $this->height != "" || $this->width != "" || $this->class != "" || 
				$this->min_height != "" || $this->max_height != ""))) {
					$html .= "<div ";
					if ($this->align != "") {
						$html .= "align=\"".$this->align."\" ";
					}
			} else {
					$html .= "<span ";
			}
			if ($this->id != "") {
				$html .= "id=\"".$this->getId()."\" ";
			}
			if ($this->itemprop != "") {
				$html .= "itemprop=\"".$this->itemprop."\" ";
				if ($this->itemprop_content != "") {
					$html .= "content=\"".$this->itemprop_content."\" ";
				}
			}
			if ($this->itemtype != "") {
				$html .= "itemscope itemtype=\"".$this->itemtype."\" ";
			}
			if ($this->typeof != "") {
				$html .= "typeof=\"".$this->typeof."\" ";
			}
			if ($this->xmlns != "") {
				$html .= "xmlns=\"".$this->xmlns."\" ";
			}
			if ($this->xmlnsv != "") {
				$html .= "xmlns:v=\"".$this->xmlnsv."\" ";
			}
			if ($this->property != "") {
				$html .= "property=\"".$this->property."\" ";
			}
			$html .= "style=\"".$this->getStyle()."\"";
			
		 	if ($this->draggable || $this->droppable || $this->sortable || $this->class != "") {
				$html .= " class=\"";
				$class_exists = false;
		 		if ($this->draggable) {
					$html .= "draggable";
					$class_exists = true;
				}
		 		if ($this->droppable) {
		 			if ($class_exists) { $html .= " "; }
					$html .= "droppable";
					$class_exists = true;
				}
		 		if ($this->sortable) {
		 			if ($class_exists) { $html .= " "; }
					$html .= "sortable";
					$class_exists = true;
				}
				if ($this->class != "") {
					if ($class_exists) { $html .= " "; }
					$html .= $this->class;
					$class_exists = true;
				}
				$html .= "\"";
			}
			
			if ($this->callback_onclick != "") {
				$html .= " onClick=\"".str_replace("\n", "", $this->getObjectEventValidationRender($this->onclick, $this->callback_onclick))."\"";
			} else if ($this->onclick != "") {
				$html .= " onClick=\"".str_replace("\n", "", $this->onclick)."\"";
			}
			
			if ($this->callback_ondblclick != "") {
				$html .= " onDblClick=\"".str_replace("\n", "", $this->getObjectEventValidationRender($this->ondblclick, $this->callback_ondblclick))."\"";
			} else if ($this->ondblclick != "") {
				$html .= " onDblClick=\"".str_replace("\n", "", $this->ondblclick)."\"";
			}
			
			if ($this->onmouseover != "") {
				$html .= " onMouseOver=\"".str_replace("\n", "", $this->onmouseover)."\"";
			}
			if ($this->onmouseout != "") {
				$html .= " onMouseOut=\"".str_replace("\n", "", $this->onmouseout)."\"";
			}
			
			$html .= ">";
			$is_span_open = true;
		}
		if (!$this->loaded_from_url) {
			for ($i=0; $i < sizeof($this->objects); $i++) {
				if ($i != 0) {
					$html .= " ";
				}
				if (gettype($this->objects[$i]) == "object" && method_exists($this->objects[$i], "render")) {
					$html .= $this->objects[$i]->render();
				} else {
					$html .= $this->objects[$i];
				}
			}
			if (sizeof($this->objects) == 0) {
				$html .= "&nbsp;";
			}
		} else { // loading from Url
			if (sizeof($this->objects) == 2) {
				if (gettype($this->objects[0]) == "object" && method_exists($this->objects[0], "render")) {
					$html .= $this->objects[0]->render();
				} else {
					$html .= $this->objects[0];
				}
			} else {
				$html .= "<div align=\"center\" style=\"";
				if ($this->height != "") {
					if (is_integer($this->height)) {
						$html .= "height:".$this->height."px;";
					} else {
						$html .= "height:".$this->height.";";
					}
				}
				if (!$this->disable_ajax_wait_message) {
					$html .= "#position:absolute;#top:50%;display:table-cell;vertical-align:middle;\"><img src=\"".$this->getPage()->getCDNServerURL()."wsp/img/loading.gif\" width=\"32\" height=\"32\"/>";
				} else {
					$html .= "\">";
				}
				$html .= "</div>";
			}
		}
		if ($is_span_open) {
			if ($this->force_div_tag || (!$this->force_span_tag &&
				($this->align != "" || $this->height != "" || $this->width != "" || $this->class != "" || 
				$this->min_height != "" || $this->max_height != ""))) {
					$html .= "</div>";
			} else {
					$html .= "</span>";
			}
		}
		
		$html .= $this->generateObjectJavascript($ajax_render);
		
		if ($this->callback_onclick != "" || $this->callback_ondblclick != "") {
			$html .= "<input type='hidden' id='Callback_".$this->getEventObjectName()."' name='Callback_".$this->getEventObjectName()."' value=''/>\n";
			if ($this->is_ajax_event && !$ajax_render) {
				$html .= $this->getJavascriptTagOpen();
				$html .= $this->getAjaxEventFunctionRender();
				$html .= $this->getJavascriptTagClose();
			}
		}
		
		$html .= $this->renderLoadFromUrl($ajax_render);

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
	 * Method renderLoadFromUrl
	 * @access private
	 * @param mixed $ajax_render 
	 * @return mixed
	 * @since 1.2.14
	 */
	private function renderLoadFromUrl($ajax_render) {
		$html = "";
		if ($this->loaded_from_url) {
			if ($this->id == "") {
				throw new NewException("Error Object: You must specified an id to load an object from an URL", 0, getDebugBacktrace(1));
			}
			if (sizeof($this->objects) == 2) { // When we want to define a content before ajax loading
				$loaded_url = $this->objects[1]->render();
			} else {
				$loaded_url = $this->objects[0]->render();
			}
			if (!$ajax_render) { $html .= $this->getJavascriptTagOpen(); }
			$html .= "$( document ).ready(function() {\n";
			$html .= "var oldContentHtml = ''; if (trim($('#".$this->getId()."').html().replace(/<div[^>]*>(.*?)<\/div>/gi, '')) != '') { oldContentHtml = $('#".$this->getId()."').html(); }\n";
			$html .= "$('#".$this->getId()."').load('".$loaded_url."', { 'oldContentHtml': oldContentHtml }, ";
			$html .= "function (response, status, xhr) { if (status == 'error' && response != '') { $('#".$this->getId()."').html('<table><tr><td><img src=\'".$this->getPage()->getCDNServerURL()."wsp/img/warning.png\' height=\'24\' width=\'24\' border=\'0\' align=\'absmidlle\'/></td><td><b>Error</b></td></tr></table>' + response); } } );\n";
			$html .= "});";
			if (!$ajax_render) { $html .= $this->getJavascriptTagClose(); }
		}
		return $html;
	}
	
	/**
	 * Method generateObjectJavascript
	 * @access private
	 * @param mixed $ajax_render 
	 * @return mixed
	 * @since 1.2.3
	 */
	private function generateObjectJavascript($ajax_render) {
		$html = "";
		if ($this->context_menu != null) {
			$html .= $this->context_menu->render($ajax_render);
		}
		
		if ($this->draggable) {
			if ($this->sortable) {
				throw new NewException(get_class($this)." error: You can't define draggable properties on sortable Object.", 0, getDebugBacktrace(1));
			}
			
			if (!$ajax_render) {
				$html .= "\n".$this->getJavascriptTagOpen();
			}
			$html .= "$(document).ready( function() {\n";
			$html .= "$(\"#".$this->getId()."\").draggable({opacity: 0.8, scroll: true";
			if ($this->draggable_revert) {
				$html .= ", revert: true";
			}
			if ($this->draggable_params != "") {
				$html .= ", ".$this->draggable_params;
			}
			$html .= "}).resizable();\n";
			$html .= "$(\"#".$this->getId()."\").find('.ui-resizable-e').remove();\n";
			$html .= "$(\"#".$this->getId()."\").find('.ui-resizable-s').remove();\n";
			$html .= "$(\"#".$this->getId()."\").find('.ui-resizable-se').remove();\n";
			$html .= "});\n";
			
			if (!$ajax_render) {
				$html .= $this->getJavascriptTagClose();
			}
			
			if ($this->draggable_event != null) {
				$html .= $this->draggable_event->render($ajax_render);
			}
		}
		
		if ($this->droppable) {
			if (!$ajax_render) {
				$html .= "\n".$this->getJavascriptTagOpen();
			}
			
			$html .= "$(document).ready( function() {\n";
			$html .= "$(\"#".$this->getId()."\").droppable({ greedy: true";
			if ($this->droppable_style != "") {
				$html .= ", hoverClass: '".$this->droppable_style."'";
			} 
			if ($this->droppable_params != "") {
				$html .= ", ".$this->droppable_params;
			}
			$html .= "});\n";
			$html .= "$(\"#".$this->getId()."\").css('display', 'block');\n";
			$html .= "});\n";
			
			if (!$ajax_render) {
				$html .= $this->getJavascriptTagClose();
			}
			
			if ($this->droppable_event != null) {
				$html .= $this->droppable_event->render($ajax_render);
			}
		}
		
		if ($this->sortable) {
			if (!$ajax_render) {
				$html .= "\n".$this->getJavascriptTagOpen();
			}
			
			$html .= "$(document).ready( function() {\n";
			// remove since include jquery 1.6.2 (wsp 1.0.90)
			//$html .= "$('#".$this->getId()."').mousedown(function(e) { e.stopPropagation(); return false; });\n"; // ack for IE
			$html .= "$('#".$this->getId()."').sortable({connectWith: '.sortable'";
			if ($this->sortable_params != "") {
				$html .= ", ".$this->sortable_params;
			}
			$html .= "})";
			if ($this->sortable_disable_selection) {
				$html .= ".disableSelection()";
			}
			$html .= ";\n";
			
			if (!$this->droppable) {
				$html .= "$(\"#".$this->getId()."\").css('display', 'block');\n";
			}
			$html .= "});\n";
			
			if (!$ajax_render) {
				$html .= $this->getJavascriptTagClose();
			}
			
			if ($this->sortable_event != null) {
				$html .= $this->sortable_event->render($ajax_render);
			}
		}
		
		return $html;
	}
	
	/**
	 * Method getAjaxRender
	 * @access public
	 * @return string javascript code to update initial html of object Object (call with AJAX)
	 * @since 1.0.36
	 */
	public function getAjaxRender() {
		$this->automaticAjaxEvent();
		
		$html = "";
		if ($this->object_change && !$this->is_new_object_after_init) {
			if ($this->id == "") {
				throw new NewException("Error Object: You must specified an id (setId())", 0, getDebugBacktrace(1));
			}
			
			$content = "";
			if (!$this->loaded_from_url) {
				for ($i=0; $i < sizeof($this->objects); $i++) {
					if ($this->objects_after_init[$i] === true) {
						if ($i != 0) {
							$html .= " ";
						}
						if (gettype($this->objects[$i]) == "object" && method_exists($this->objects[$i], "render")) {
							$content .= $this->objects[$i]->render();
						} else {
							$content .= $this->objects[$i];
						}
					}
				}
			} else { // loading from Url
				if (sizeof($this->objects) == 2) {
					if (gettype($this->objects[0]) == "object" && method_exists($this->objects[0], "render")) {
						$content .= $this->objects[0]->render();
					} else {
						$content .= $this->objects[0];
					}
				} else {
					$content .= "<div align=\"center\" style=\"";
					if ($this->height != "") {
						if (is_integer($this->height)) {
							$content .= "height:".$this->height."px;";
						} else {
							$content .= "height:".$this->height.";";
						}
					}
					if (!$this->disable_ajax_wait_message) {
						$content .= "#position:absolute;#top:50%;display:table-cell;vertical-align:middle;\"><img src=\"".$this->getPage()->getCDNServerURL()."wsp/img/loading.gif\" width=\"32\" height=\"32\"/>";
					} else {
						$content .= "\">";
					}
					$content .= "</div>";
				}
			}
			
			// Extract JavaScript from HTML
			$array_ajax_render = extract_javascript($content);
			for ($i=1; $i < sizeof($array_ajax_render); $i++) {
				new JavaScript($array_ajax_render[$i], true);
			}
			
			// Add current object javascript
			$js = $this->generateObjectJavascript(true);
			if ($js != "") {
				$this->getPage()->addObject(new JavaScript($js), false, true);
			}
			
			if ($this->object_is_cleared) {
				$html .= "$('#".$this->getId()."').html(\"\");\n";
			}
			$html .= "$('#".$this->getId()."').append(\"".str_replace("\n", "", str_replace("\r", "", addslashes($array_ajax_render[0])))."\");\n";
			$html .= "$('#".$this->getId()."').attr('style', \"";
			if ($this->width != "") {
				if (is_integer($this->width)) {
					$html .= "width:".$this->width."px;";
				} else {
					$html .= "width:".$this->width.";";
				}
			}
			if ($this->height != "") {
				if (is_integer($this->height)) {
					$html .= "height:".$this->height."px;";
				} else {
					$html .= "height:".$this->height.";";
				}
			}
			if ($this->font_size != "") {
				if (is_integer($this->font_size)) {
					$html .= "font-size:".$this->font_size."pt;";
				} else {
					$html .= "font-size:".$this->font_size.";";
				}
			}
			if ($this->font_family != "") {
				$html .= "font-family:".$this->font_family.";";
			}
			if ($this->font_weight != "") {
				$html .= "font-weight:".$this->font_weight.";";
			}
			if ($this->border != "") {
				$html .= "border:";
				if (is_integer($this->border)) {
					$html .= $this->border."px";
				} else {
					$html .= $this->border;
				}
				$html .= " ".$this->border_style." ".$this->border_color.";";
			}
			if ($this->hide_object) {
				$html .= "display:none;";
			} else {
				$html .= "display:".($this->force_span_tag?"inline":"block").";";
			}
			if ($this->min_height != "") {
				$html .= "min-height: ".$this->min_height."px;height: expression(this.scrollHeight < ".$this->min_height." ? '".$this->min_height."px' : 'auto');";
			} else if ($this->droppable || $this->sortable) {
				$html .= "min-height: 24px;height: expression(this.scrollHeight < 22 ? '24px' : 'auto');";
			}
			if ($this->droppable || $this->sortable) {
				$html .= "min-width: 24px;width: expression(this.scrollWidth < 26 ? '26px' : 'auto');";
			}
			if ($this->style != "") {
				$html .= $this->style;
			}
			$html .= "\");\n";
			if ($this->draggable || $this->droppable || $this->sortable || $this->class != "") {
				$html .= "$('#".$this->getId()."').attr('class', '";
				$class_exists = false;
		 		if ($this->draggable) {
					$html .= "draggable";
					$class_exists = true;
				}
		 		if ($this->droppable) {
		 			if ($class_exists) { $html .= " "; }
					$html .= "droppable";
					$class_exists = true;
				}
		 		if ($this->sortable) {
		 			if ($class_exists) { $html .= " "; }
					$html .= "sortable";
					$class_exists = true;
				}
				if ($this->class != "") {
					if ($class_exists) { $html .= " "; }
					$html .= $this->class;
					$class_exists = true;
				}
				$html .= "');\n";
			}
			
			$html .= $this->renderLoadFromUrl(true);
			
			$this->object_change = false;
		}
		return $html;
	}
	
}
?>
