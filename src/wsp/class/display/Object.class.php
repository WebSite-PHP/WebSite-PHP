<?php
class Object extends WebSitePhpEventObject {
	/**#@+
	* align properties
	* @access public
	* @var string
	*/
	const ALIGN_LEFT = "left";
	const ALIGN_CENTER = "center";
	const ALIGN_RIGHT = "right";
	
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
	private $align = "";
	private $width = "";
	private $height = "";
	private $min_height = "";
	private $border = 0;
	private $border_color = "";
	private $border_style = "";
	private $hide_object = false;
	private $style = "";
	private $class = "";
	
	private $font_size = "";
	private $font_family = "";
	private $font_weight = "";
	
	private $draggable = false;
	private $draggable_revert = false;
	private $draggable_event = null;
	private $draggable_sortable = false;
	private $draggable_params = "";
	
	private $droppable = false;
	private $droppable_style = "";
	private $droppable_event = null;
	private $droppable_params = "";
	
	private $sortable = false;
	private $sortable_event = null;
	private $sortable_params = "";
	
	private $onclick = "";
	private $callback_onclick = "";
	private $is_clicked = false;
	
	private $loaded_from_url = false;
	/**#@-*/
	
	function __construct($str_or_object=null, $str_or_object2=null, $str_or_object3=null, $str_or_object4=null, $str_or_object5=null) {
		parent::__construct();
		
		$args = func_get_args();
		for ($i=0; $i < sizeof($args); $i++) {
    		if ($args[$i] != null) {
				$this->addObject($args[$i]);
    		}
    	}
	}
	
	public function add($str_or_object, $str_or_object2=null, $str_or_object3=null, $str_or_object4=null, $str_or_object5=null) {
		$args = func_get_args();
		$object = array_shift($args);
		$this->addObject($object);
    	for ($i=0; $i < sizeof($args); $i++) {
    		if ($args[$i] != null) {
				$this->addObject($args[$i]);
    		}
    	}
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
    	return $this;
	}
	
	private function addObject($object) {
		if ($this->loaded_from_url || (gettype($object)=="object" && sizeof($this->objects) > 0 && get_class($object)=="Url")) {
			throw new NewException("Error Object->addObject(): This object already loaded from url", 0, 8, __FILE__, __LINE__);
		}
		if (gettype($object)=="object" && get_class($object)=="Url") {
			$this->loaded_from_url = true;
		}
		$this->objects[sizeof($this->objects)] = $object;
	}
	
	public function setAlign($align) {
		$this->align = $align;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function setWidth($width) {
		$this->width = $width;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function setHeight($height) {
		$this->height = $height;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function setMinHeight($min_height) {
		if (is_integer($this->min_height)) {
			$this->min_height = $min_height;
		} else {
			$this->min_height = str_replace("px", "", $min_height);
		}
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}

	public function setBorder($border=1, $border_color="black", $border_style="solid") {
		$this->border = $border;
		$this->border_color = $border_color;
		$this->border_style = $border_style;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function setFont($font_size, $font_family, $font_weight) {
		$this->font_size = $font_size;
		$this->font_family = $font_family;
		$this->font_weight = $font_weight;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
		
	public function setStyle($style) {
		$this->style = $style;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
		
	public function setClass($class) {
		$this->class = $class;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
		
	public function setId($id) {
		$this->id = $id;
		return $this;
	}
		
	public function emptyObject() {
		$this->objects = array();
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
		
	public function getId() {
		return "wsp_object_".$this->id;
	}
	
	public function hide() {
		if ($this->id == "") {
			throw new NewException("Error Object->hide(): You must specified an id (setId())", 0, 8, __FILE__, __LINE__);
		}
		$this->hide_object = true;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function show() {
		if ($this->id == "") {
			throw new NewException("Error Object->show(): You must specified an id (setId())", 0, 8, __FILE__, __LINE__);
		}
		$this->hide_object = false;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * function setDraggable
	 * @param string $bool if object can be move
	 * @param string $revert if object revert first place when dropped
	 */
	public function setDraggable($bool=true, $revert=false, $draggable_event=null, $sortable_zone=false, $draggable_params="") {
		if ($this->id == "") {
			throw new NewException("Error Object->setDraggable(): You must specified an id (setId())", 0, 8, __FILE__, __LINE__);
		}
		$this->draggable = $bool;
		$this->draggable_revert = $revert;
		if ($draggable_event != null) {
			if (get_class($draggable_event) != "DraggableEvent") {
				throw new NewException("Error Object->setDraggable(): $draggable_event is not a DraggableEvent object", 0, 8, __FILE__, __LINE__);
			}
			$this->draggable_event = $draggable_event;
			$this->draggable_event->setDraggableId($this->getId());
			if ($this->id == "") {
				throw new NewException("Error Object->setDraggable(): You must specified an id for this object", 0, 8, __FILE__, __LINE__);
			}
		}
		$this->draggable_sortable = $sortable_zone;
		$this->draggable_params = $draggable_params;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function getIsDraggable() {
		return $this->draggable;
	}
	
	/**
	 * function setDroppable
	 * @param string $bool if object can be dropped
	 */
	public function setDroppable($bool=true, $droppable_event=null, $droppable_params="", $droppable_style="droppablehover") {
		if ($this->id == "") {
			throw new NewException("Error Object->setDroppable(): You must specified an id (setId())", 0, 8, __FILE__, __LINE__);
		}
		$this->droppable = $bool;
		$this->droppable_style = $droppable_style;
		$this->droppable_params = $droppable_params;
		if ($droppable_event != null) {
			if (get_class($droppable_event) != "DroppableEvent") {
				throw new NewException("Error Object->setDroppable(): $draggable_event is not a DroppableEvent object", 0, 8, __FILE__, __LINE__);
			}
			$this->droppable_event = $droppable_event;
			$this->droppable_event->setDroppableId($this->getId());
			if ($this->id == "") {
				throw new NewException("Error Object->setDroppable(): You must specified an id for this object", 0, 8, __FILE__, __LINE__);
			}
		}
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function getIsDroppable() {
		return $this->droppable;
	}
	
	/**
	 * function setSortable
	 * @param string $bool if object can be sort
	 */
	public function setSortable($bool=true, $sortable_event=null, $sortable_params="") {
		if ($this->id == "") {
			throw new NewException("Error Object->setSortable(): You must specified an id (setId())", 0, 8, __FILE__, __LINE__);
		}
		$this->sortable = $bool;
		$this->sortable_params = $sortable_params;
		if ($sortable_event != null) {
			if (get_class($sortable_event) != "SortableEvent") {
				throw new NewException("Error Object->setDraggable(): $sortable_event is not a SortableEvent object", 0, 8, __FILE__, __LINE__);
			}
			$this->sortable_event = $sortable_event;
			$this->sortable_event->setSortableId($this->getId());
			if ($this->id == "") {
				throw new NewException("Error Object->setSortable(): You must specified an id for this object", 0, 8, __FILE__, __LINE__);
			}
		}
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function getIsSortable() {
		return $this->sortable;
	}
	
	/* Intern management of Object */
	public function setClick() {
		if ($GLOBALS['__LOAD_VARIABLES__']) { 
			$this->is_clicked = true; 
		}
		return $this;
	}
	
	public function getOnClickJs() {
		return $this->onclick;
	}
	
	public function onClick($page_object, $str_function, $arg1=null, $arg2=null, $arg3=null, $arg4=null, $arg5=null) {
		if ($this->id == "") {
			throw new NewException("Error Object->onClick(): You must specified an id (setId())", 0, 8, __FILE__, __LINE__);
		}
		if (!isset($page_object) || gettype($page_object) != "object" || !is_subclass_of($page_object, "Page")) {
			throw new NewException("Argument page_object for ".get_class($this)."::__construct() error", 0, 8, __FILE__, __LINE__);
		}
		
		$this->class_name = get_class($page_object);
		$this->name = $this->getId();
		$page_object->addEventObject($this);
		
		$this->page_object = $page_object;
		$args = func_get_args();
		$page_object = array_shift($args);
		$str_function = array_shift($args);
		
		$this->callback_onclick = $this->loadCallbackMethod($str_function, $args);
		
		return $this;
	}
	
	public function onClickJs($js_function) {
		if ($this->id == "") {
			throw new NewException("Error Object->onClickJs(): You must specified an id (setId())", 0, 8, __FILE__, __LINE__);
		}
		$this->onclick = trim($js_function);
		return $this;
	}
	
	public function isClicked() {
		if (!$this->is_clicked) {
			$this->page_object->getUserEventObject();
		}
		return $this->is_clicked;
	}
	
	public function render($ajax_render=false) {
		$html = "";
		$is_span_open = false;
		if ($this->id != "" || $this->align != "" || $this->border != "" || $this->width != "" || $this->font_size != "" || $this->font_family != "" || $this->font_weight != "" || $this->style != "" || $this->class != "") {
			if ($this->align != "" || $this->height != "" || $this->width != "" || $this->class != "") {
				$html .= "<div ";
				$html .= "align=\"".$this->align."\" ";
			} else {
				$html .= "<span ";
			}
			if ($this->id != "") {
				$html .= "id=\"".$this->getId()."\" ";
			}
			$html .= "style=\"";
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
			if ($this->droppable || $this->sortable) {
				$html .= "min-width: 24px;width: expression(this.scrollWidth < 26 ? '26px' : 'auto');";
			}
			if ($this->style != "") {
				$html .= $this->style;
			}
			$html .= "\"";
			
		 	if ($this->draggable || $this->droppable || $this->sortable || $this->class != "") {
				$html .= " class=\"";
				$class_exists = false;
		 		if ($this->draggable && !$this->draggable_sortable) {
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
				$html .= " onClick=\"".str_replace("\n", "", $this->getObjectEventValidationRender($this->onclick, $this->callback_onclick, $this->getId()))."\"";
			} else if ($this->onclick != "") {
				$html .= " onClick=\"".str_replace("\n", "", $this->onclick)."\"";
			}
			
			$html .= ">";
			$is_span_open = true;
		}
		if (!$this->loaded_from_url) {
			for ($i=0; $i < sizeof($this->objects); $i++) {
				if ($i != 0) {
					$html .= " ";
				}
				if (gettype($this->objects[$i]) == "object") {
					$html .= $this->objects[$i]->render();
				} else {
					$html .= $this->objects[$i];
				}
			}
		}
		if ($is_span_open) {
			if ($this->align != "" || $this->height != "" || $this->width != "" || $this->class != "") {
				$html .= "</div>";
			} else {
				$html .= "</span>";
			}
		}
		
		if ($this->draggable && !$this->draggable_sortable) {
			$html .= "\n".$this->getJavascriptTagOpen();
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
			$html .= $this->getJavascriptTagClose();
			
			if ($this->draggable_event != null) {
				$html .= $this->draggable_event->render($ajax_render);
			}
		} else if ($this->draggable_sortable) {
			$html .= "\n".$this->getJavascriptTagOpen();
			$html .= "$(\"#".$this->getId()."\").disableSelection();\n";
			$html .= $this->getJavascriptTagClose();
		}
		
		if ($this->droppable) {
			$html .= "\n".$this->getJavascriptTagOpen();
			$html .= "$(\"#".$this->getId()."\").droppable({ greedy: true";
			if ($this->droppable_style != "") {
				$html .= ", hoverClass: '".$this->droppable_style."'";
			} 
			if ($this->droppable_params != "") {
				$html .= ", ".$this->droppable_params;
			}
			$html .= "});\n";
			$html .= "$(\"#".$this->getId()."\").css('display', 'block');\n";
			$html .= $this->getJavascriptTagClose();
			
			if ($this->droppable_event != null) {
				$html .= $this->droppable_event->render($ajax_render);
			}
		}
		
		if ($this->sortable) {
			$html .= "\n".$this->getJavascriptTagOpen();
			$html .= "$('#".$this->getId()."').mousedown(function(e) { e.stopPropagation(); return false; });\n"; // ack for IE
			$html .= "$('#".$this->getId()."').sortable({connectWith: '.sortable'";
			if ($this->sortable_params != "") {
				$html .= ", ".$this->sortable_params;
			}
			$html .= "}).disableSelection();\n";
			if (!$this->droppable) {
				$html .= "$(\"#".$this->getId()."\").css('display', 'block');\n";
			}
			
			$html .= $this->getJavascriptTagClose();
			
			if ($this->sortable_event != null) {
				$html .= $this->sortable_event->render($ajax_render);
			}
		}
		
		if ($this->callback_onclick != "") {
			$html .= "<input type='hidden' id='Callback_".$this->getEventObjectName()."' name='Callback_".$this->getEventObjectName()."' value=''/>\n";
			if ($this->is_ajax_event && !$ajax_render) {
				if ($this->callback_onclick == "") {
					throw new NewException("Unable to activate action to this ".get_class($this)." : You must set a click event (method onClick)", 0, 8, __FILE__, __LINE__);
				}
				
				$html .= $this->getJavascriptTagOpen();
				$html .= $this->getAjaxEventFunctionRender();
				$html .= $this->getJavascriptTagClose();
			}
		}
		
		if ($this->loaded_from_url && sizeof($this->objects)==1 && get_class($this->objects[0])=="Url") {
			if ($this->id == "") {
				throw new NewException("Error Object: You must specified an id to load an object from an URL", 0, 8, __FILE__, __LINE__);
			}
			$html .= $this->getJavascriptTagOpen();
			$html .= "$('#".$this->getId()."').load('".$this->objects[0]->render()."');";
			$html .= $this->getJavascriptTagClose();
		}
		
		$this->object_change = false;
		return $html;
	}
	
	/**
	 * function getAjaxRender
	 * @return string javascript code to update initial html with ajax call
	 */
	public function getAjaxRender() {
		$html = "";
		if ($this->object_change && !$this->is_new_object_after_init && $this->id != "") {
			$content = "";
			for ($i=0; $i < sizeof($this->objects); $i++) {
				if ($i != 0) {
					$html .= " ";
				}
				if (gettype($this->objects[$i]) == "object") {
					$content .= $this->objects[$i]->render();
				} else {
					$content .= $this->objects[$i];
				}
			}
			// Extract JavaScript from HTML
			$array_ajax_render = extract_javascript($content);
			for ($i=1; $i < sizeof($array_ajax_render); $i++) {
				new JavaScript($array_ajax_render[$i], true);
			}
			
			$html .= "$('#".$this->getId()."').html(\"".str_replace('"', '\"', str_replace("\n", "", str_replace("\r", "", $array_ajax_render[0])))."\");\n";
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
				$html .= "display:block;";
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
		}
		return $html;
	}
	
}
?>
