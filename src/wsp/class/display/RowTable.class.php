<?php
class RowTable extends WebSitePhpObject {
	/**#@+
		* RowTable style class
		* @access public
		* @var string
		*/
	const STYLE_MAIN = "1";
	const STYLE_SECOND = "2";
	/**#@-*/
	
	/**#@+
		* RowTable alignment
		* @access public
		* @var string
		*/
	const ALIGN_LEFT = "left";
	const ALIGN_CENTER = "center";
	const ALIGN_RIGHT = "right";
	/**#@-*/
	
	/**#@+
		* RowTable vertical alignment
		* @access public
		* @var string
		*/
	const VALIGN_TOP = "top";
	const VALIGN_CENTER = "center";
	const VALIGN_BOTTOM = "bottom";
	/**#@-*/
	
	/**#@+
		* @access private
		*/
	private $col_object = array();
	private $width = "";
	private $height = "";
	private $align = "";
	private $class = "";
	private $style = "";
	private $valign = "";
	private $is_header_row = false; 
	private $colspan = "";
	private $rowspan = "";
	private $is_nowrap = false;
	/**#@-*/
	
	function __construct($align='center', $width='', $class='', $valign='') {
		parent::__construct();
		
		$this->width = $width;
		$this->align = $align;
		$this->class = $class;
		$this->valign = $valign;
		$this->style = "";
		$this->is_header_row = false;
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
	
	public function setHeaderClass($class="1") {
		if ($class == Table::STYLE_MAIN || $class == Table::STYLE_SECOND) {
			$this->is_header_row = true;
		}
		$this->setClass($class);
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function setStyle($style) {
		$this->style = $style;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function setAlign($align) {
		$this->align = $align;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function setValign($valign) {
		$this->valign = $valign;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function setColspan($colspan) {
		$this->colspan = $colspan;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function setRowspan($rowspan) {
		$this->rowspan = $rowspan;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function setNowrap() {
		$this->is_nowrap = true;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function getClass() {
		return $this->class;
	}
	
	public function add($content_object=null, $align='', $width='', $class='', $valign='', $style='', $colspan='', $rowspan='') {
		if (gettype($content_object) == "object" && get_class($content_object) == "DateTime") {
			throw new NewException(get_class($this)."->add() error: Please format your DateTime object (\$my_date->format(\"Y-m-d H:i:s\"))", 0, 8, __FILE__, __LINE__);
		}
		$ind = sizeof($this->col_object);
		$this->col_object[$ind]['content_object'] = $content_object;
		$this->col_object[$ind]['width'] = $width;
		$this->col_object[$ind]['align'] = $align;
		$this->col_object[$ind]['class'] = $class;
		$this->col_object[$ind]['valign'] = $valign;
		$this->col_object[$ind]['style'] = $style;
		$this->col_object[$ind]['colspan'] = $colspan;
		$this->col_object[$ind]['rowspan'] = $rowspan;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function setColumnContent($column_ind, $content_object) {
		if (isset($this->col_object[$column_ind-1])) {
			$this->col_object[$column_ind-1]['content_object'] = $content_object;
		}
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function setColumnWidth($column_ind, $width) {
		if (isset($this->col_object[$column_ind-1])) {
			$this->col_object[$column_ind-1]['width'] = $width;
		}
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function setColumnHeight($column_ind, $height) {
		if (isset($this->col_object[$column_ind-1])) {
			$this->col_object[$column_ind-1]['height'] = $height;
		}
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function setColumnClass($column_ind, $class) {
		if (isset($this->col_object[$column_ind-1])) {
			$this->col_object[$column_ind-1]['class'] = $class;
		}
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function setColumnStyle($column_ind, $style) {
		if (isset($this->col_object[$column_ind-1])) {
			$this->col_object[$column_ind-1]['style'] = $style;
		}
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function setColumnAlign($column_ind, $align) {
		if (isset($this->col_object[$column_ind-1])) {
			$this->col_object[$column_ind-1]['align'] = $align;
		}
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function setColumnValign($column_ind, $valign) {
		if (isset($this->col_object[$column_ind-1])) {
			$this->col_object[$column_ind-1]['valign'] = $valign;
		}
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function setColumnColspan($column_ind, $colspan) {
		if (isset($this->col_object[$column_ind-1])) {
			$this->col_object[$column_ind-1]['colspan'] = $colspan;
		}
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function setColumnRowspan($column_ind, $rowspan) {
		if (isset($this->col_object[$column_ind-1])) {
			$this->col_object[$column_ind-1]['rowspan'] = $rowspan;
		}
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function render($ajax_render=false) {
		$html = "";
		if (sizeof($this->col_object) == 0) {
			$this->add();
		}
		$html .= "<tr>\n";
		for ($i=0; $i < sizeof($this->col_object); $i++) {
			$is_droppable_object = false;
			if (gettype($this->col_object[$i]['content_object']) == "object" && method_exists($this->col_object[$i]['content_object'], "render")) {
				if ($this->col_object[$i]['content_object'] != null) {
					$html_content = $this->col_object[$i]['content_object']->render();
					if (get_class($this->col_object[$i]['content_object']) == "Object") {
						$is_droppable_object = $this->col_object[$i]['content_object']->getIsDroppable();
					}
				} else {
					$html_content = "&nbsp;";
				}
			} else {
				if ($this->col_object[$i]['content_object'] != "") {
					$html_content = $this->col_object[$i]['content_object'];
				} else {
					$html_content = "&nbsp;";
				}
			}
			$html .= " <td";
			if ($this->class != "" || $this->col_object[$i]['class'] != "") {
				$html .= " class=\"";
				if ($this->is_header_row) {
					$html .= "header_";
				}
				if ($this->col_object[$i]['class'] != "") {
					if (is_integer($this->col_object[$i]['class'])) {
						$html .= "bckg_".$this->col_object[$i]['class'];
					} else if (is_integer(substr($this->col_object[$i]['class'], 0, 1)) && find($this->col_object[$i]['class'], "_round") > 0) {
						$html .= "table_".substr($this->col_object[$i]['class'], 0, 1)."_round bckg_".substr($this->col_object[$i]['class'], 0, 1);
					} else {
						$html .= $this->col_object[$i]['class'];
					}
				} else {
					if (is_integer($this->class)) {
						$html .= "bckg_".$this->class;
					} else if (is_integer(substr($this->class, 0, 1)) && find($this->class, "_round") > 0) {
						$html .= "table_".substr($this->class, 0, 1)."_round bckg_".substr($this->class, 0, 1);
					} else {
						$html .= $this->class;
					}
				}
				$html .= "\"";
			}
			
			$html .= " style=\"";
			if ($this->col_object[$i]['width'] != "") {
				if (is_integer($this->col_object[$i]['width'])) {
					$html .= "width:".$this->col_object[$i]['width']."px;";
				} else {
					$html .= "width:".$this->col_object[$i]['width'].";";
				}
			} else if ($this->width != "") {
				if (is_integer($this->width)) {
					$html .= "width:".$this->width."px;";
				} else {
					$html .= "width:".$this->width.";";
				}
			}
			if ($this->col_object[$i]['height'] != "") {
				if (is_integer($this->col_object[$i]['height'])) {
					$html .= "height:".$this->col_object[$i]['height']."px;";
				} else {
					$html .= "height:".$this->col_object[$i]['height'].";";
				}
			} else if ($this->height != "") {
				if (is_integer($this->height)) {
					$html .= "height:".$this->height."px;";
				} else {
					$html .= "height:".$this->height.";";
				}
			}
			if ($this->style != "" || $this->col_object[$i]['style'] != "") {
				if ($this->col_object[$i]['style'] != "") {
					$html .= $this->col_object[$i]['style'];
				} else {
					$html .= $this->style;
				}
			}
			$html .= "\"";
			
			if ($this->valign != "" || $this->col_object[$i]['valign'] != "") {
				if ($this->col_object[$i]['valign'] != "") {
					$html .= " valign=\"".$this->col_object[$i]['valign']."\"";
				} else {
					$html .= " valign=\"".$this->valign."\"";
				}
			}
			if ($this->colspan != "" || $this->col_object[$i]['colspan'] != "") {
				if ($this->col_object[$i]['colspan'] != "") {
					$html .= " colspan=\"".$this->col_object[$i]['colspan']."\"";
				} else {
					$html .= " colspan=\"".$this->colspan."\"";
				}
			}
			if ($this->rowspan != "" || $this->col_object[$i]['rowspan'] != "") {
				if ($this->col_object[$i]['rowspan'] != "") {
					$html .= " rowspan=\"".$this->col_object[$i]['rowspan']."\"";
				} else {
					$html .= " rowspan=\"".$this->rowspan."\"";
				}
			}
			if ($this->is_nowrap) {
				$html .= " nowrap";
			}
			$html .= ">\n";
		
			$open_div = false;
			if ($this->align != "" || $this->col_object[$i]['align'] != "") {
				if ($this->col_object[$i]['align'] != "") {
					$html .= "	<div align=\"".$this->col_object[$i]['align']."\"";
				} else {
					$html .= "	<div align=\"".$this->align."\"";
				}
				if ($is_droppable_object) {
					$html .= " style=\"min-height: 24px;height: expression(this.scrollHeight < 26 ? '26px' : 'auto');\"";
				}
				$html .= ">\n";
				$open_div = true;
			}
			$html .= "		".$html_content."\n";
			if ($open_div) {
				$html .= "	</div>\n";
			}
			$html .= "</td>\n";
		}
		$html .= "</tr>\n";
		$this->object_change = false;
		return $html;
	}
	
}
?>
