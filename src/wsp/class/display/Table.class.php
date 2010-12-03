<?php
class Table extends WebSitePhpObject {
	/**#@+
	* Table style
	* @access public
	* @var string
	*/
	const STYLE_MAIN = "main";
	const STYLE_SECOND = "second";
	const STYLE_MAIN_ROUNDBOX = "main table_main_round";
	const STYLE_SECOND_ROUNDBOX = "second table_second_round";
	
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
	private $rows = array();
	private $cellpadding = 0;
	private $cellspacing = 0;
	private $width = "100%";
	private $height = "";
	private $class = "";
	private $default_align = "";
	private $default_valign = "";
	private $id="";
	
	private $border = 0;
	private $border_color = "grey";
	private $border_style = "solid";
	
	private $font_size = "";
	private $font_family = "";
	private $font_weight = "";
	private $style = "";
	/**#@-*/
	
	function __construct($cellpadding=0, $cellspacing=0, $width='', $default_align='', $default_valign='') {
		parent::__construct();
		
		$this->cellpadding = $cellpadding;
		$this->cellspacing = $cellspacing;
		$this->width = $width;
		$this->default_align = $default_align;
		$this->default_valign = $default_valign;
	}
	
	public function setCellpadding($cellpadding) {
		$this->cellpadding = $cellpadding;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function setCellspacing($cellspacing) {
		$this->cellspacing = $cellspacing;
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
	
	public function setClass($class) {
		$this->class = $class;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function setDefaultAlign($default_align) {
		$this->default_align = $default_align;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function setDefaultValign($default_valign) {
		$this->default_valign = $default_valign;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}

	public function setBorder($border=1, $border_color="grey", $border_style="solid") {
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
	
	public function setId($id) {
		$this->id = $id;
		return $this;
	}
		
	public function getId() {
		return $this->id;
	}
	
	public function addRow($row=null, $align='', $valign='') {
		if ($align == "") {
			$align = $this->default_align;
			if ($align == "") {
				$align = RowTable::ALIGN_CENTER;
			}
		}
		if ($valign == "") {
			$valign = $this->default_valign;
			if ($valign == "") {
				$valign = RowTable::VALIGN_TOP;
			}
		}
		if ($row == null) {
			$row = new RowTable();
		} else if (gettype($row) != "object" || get_class($row) != "RowTable") {
			$content = $row;
			$row = new RowTable($align);
			$row->setValign($valign);
			$row->add($content);
		}
		if ($row->getClass() == "" && ($this->class == Table::STYLE_MAIN || $this->class == Table::STYLE_SECOND
									|| $this->class == Table::STYLE_MAIN_ROUNDBOX || $this->class == Table::STYLE_SECOND_ROUNDBOX)) {
			$row->setClass($this->class);
		}
		$this->rows[sizeof($this->rows)] = $row;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $row;
	}
	
	public function addRowColumns($object=null, $object2=null, $object3=null, $object4=null, $object5=null) {
		$row = new RowTable();
		$row->setAlign($this->default_align);
		$row->setValign($this->default_valign);
		
		$args = func_get_args();
		for ($i=0; $i < sizeof($args); $i++) {
    		if ($args[$i] != null) {
				$row->add($args[$i]);
    		}
    	}
		if ($row->getClass() == "" && ($this->class == Table::STYLE_MAIN || $this->class == Table::STYLE_SECOND
									|| $this->class == Table::STYLE_MAIN_ROUNDBOX || $this->class == Table::STYLE_SECOND_ROUNDBOX)) {
			$row->setClass($this->class);
		}
    	$this->rows[sizeof($this->rows)] = $row;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
    	return $row;
	}
	
	public function render($ajax_render=false) {
		$html = "";
		$html .= "<table ";
		if ($this->border != "" && is_integer($this->border)) {
			$html .= "border=\"".$this->border."\" ";
		}
		$html .= "cellpadding=\"".$this->cellpadding."\" cellspacing=\"".$this->cellspacing."\"";
		if ($this->id != "") {
			$html .= " id=\"".$this->id."\"";
		}
		if ($this->class != "") {
			$html .= " class=\"";
			if ($this->class == Table::STYLE_MAIN || $this->class == Table::STYLE_SECOND
				|| $this->class == Table::STYLE_MAIN_ROUNDBOX || $this->class == Table::STYLE_SECOND_ROUNDBOX) {
				$html .= "table_".$this->class;
			} else {
				$html .= $this->class;
			}
			$html .= "\"";
		}
		if ($this->border != "" || $this->width != "" || $this->font_size != "" || $this->font_family != "" || $this->font_weight != "" || $this->style != "") {
			$html .= " style=\"";
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
			if ($this->style != "") {
				$html .= $this->style;
			}
			$html .= "\"";
		}
		$html .= ">\n";
		for ($i=0; $i < sizeof($this->rows); $i++) {
			$html .= "	".$this->rows[$i]->render();
		}
		$html .= "</table>\n";
		$this->object_change = false;
		return $html;
	}
	
}
?>
