<?php
/**
 * PHP file wsp\class\display\RowTable.class.php
 * @package display
 */
/**
 * Class RowTable
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
	private $row_class = "";
	private $style = "";
	private $valign = "";
	private $is_header_row = false; 
	private $colspan = "";
	private $rowspan = "";
	private $is_nowrap = false;
	private $hide = false;
	private $id = "";
	
	private $is_new = false;
	private $is_deleted = false;
	/**#@-*/
	
	/**
	 * Constructor RowTable
	 * @param string $align [default value: center]
	 * @param string $width 
	 * @param string $class 
	 * @param string $valign 
	 */
	function __construct($align='center', $width='', $class='', $valign='') {
		parent::__construct();
		
		$this->width = $width;
		$this->align = $align;
		$this->class = $class;
		$this->valign = $valign;
		$this->style = "";
		$this->is_header_row = false;
	}
	
	/**
	 * Method setWidth
	 * @access public
	 * @param integer $width 
	 * @return RowTable
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
	 * @return RowTable
	 * @since 1.0.36
	 */
	public function setHeight($height) {
		$this->height = $height;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setClass
	 * @access public
	 * @param mixed $class 
	 * @return RowTable
	 * @since 1.0.36
	 */
	public function setClass($class) {
		$this->class = $class;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setRowClass
	 * @access public
	 * @param mixed $class 
	 * @return RowTable
	 * @since 1.1.6
	 */
	public function setRowClass($class) {
		$this->row_class = $class;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setHeaderClass
	 * @access public
	 * @param string $class [default value: 1]
	 * @param boolean $default_border_style [default value: true]
	 * @return RowTable
	 * @since 1.0.36
	 */
	public function setHeaderClass($class="1", $default_border_style=true) {
		CssInclude::getInstance()->loadCssConfigFileInMemory();
		
		if (is_numeric($class)) {
			$this->is_header_row = true;
			if ($default_border_style && $class > 0) {
				$this->setBorderPredefinedStyle($class);
			}
		}
		$this->setClass($class);
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setBorderPredefinedStyle
	 * @access public
	 * @param string $style [default value: 1]
	 * @return RowTable
	 * @since 1.0.89
	 */
	public function setBorderPredefinedStyle($style="1") {
		$this->setStyle("border: 1px solid ".constant('DEFINE_STYLE_BORDER_TABLE_'.$style).";");
		if (!$this->is_header_row) {
			$this->setStyle("background:".constant('DEFINE_STYLE_BCK_'.$style).";color:".constant('DEFINE_STYLE_COLOR_'.$style).";");
		}
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setStyle
	 * @access public
	 * @param mixed $style 
	 * @return RowTable
	 * @since 1.0.36
	 */
	public function setStyle($style) {
		$this->style = $this->style.$style;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setAlign
	 * @access public
	 * @param string $align 
	 * @return RowTable
	 * @since 1.0.36
	 */
	public function setAlign($align) {
		$this->align = $align;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setValign
	 * @access public
	 * @param string $valign 
	 * @return RowTable
	 * @since 1.0.36
	 */
	public function setValign($valign) {
		$this->valign = $valign;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setColspan
	 * @access public
	 * @param mixed $colspan 
	 * @return RowTable
	 * @since 1.0.36
	 */
	public function setColspan($colspan) {
		$this->colspan = $colspan;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setRowspan
	 * @access public
	 * @param mixed $rowspan 
	 * @return RowTable
	 * @since 1.0.36
	 */
	public function setRowspan($rowspan) {
		$this->rowspan = $rowspan;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setNowrap
	 * @access public
	 * @return RowTable
	 * @since 1.0.36
	 */
	public function setNowrap() {
		$this->is_nowrap = true;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method getClass
	 * @access public
	 * @return mixed
	 * @since 1.0.36
	 */
	public function getClass() {
		return $this->class;
	}
	
	/**
	 * Method getNbColumns
	 * @access public
	 * @return mixed
	 * @since 1.0.93
	 */
	public function getNbColumns() {
		return sizeof($this->col_object);
	}
	
	/**
	 * Method getRowColumnsArray
	 * @access public
	 * @return mixed
	 * @since 1.0.96
	 */
	public function getRowColumnsArray() {
		return $this->col_object;
	}
	
	/**
	 * Method add
	 * @access public
	 * @param object $content_object [default value: null]
	 * @param string $align 
	 * @param string $width 
	 * @param string $class 
	 * @param string $valign 
	 * @param string $style 
	 * @param string $colspan 
	 * @param string $rowspan 
	 * @return RowTable
	 * @since 1.0.36
	 */
	public function add($content_object=null, $align='', $width='', $class='', $valign='', $style='', $colspan='', $rowspan='') {
		if (gettype($content_object) == "object" && get_class($content_object) == "DateTime") {
			throw new NewException(get_class($this)."->add() error: Please format your DateTime object (\$my_date->format(\"Y-m-d H:i:s\"))", 0, getDebugBacktrace(1));
		}
		$ind = sizeof($this->col_object);
		$this->col_object[$ind]['content_object'] = $content_object;
		$this->col_object[$ind]['width'] = $width;
		$this->col_object[$ind]['height'] = "";
		$this->col_object[$ind]['align'] = $align;
		$this->col_object[$ind]['class'] = $class;
		$this->col_object[$ind]['valign'] = $valign;
		$this->col_object[$ind]['style'] = $style;
		$this->col_object[$ind]['colspan'] = $colspan;
		$this->col_object[$ind]['rowspan'] = $rowspan;
		$this->col_object[$ind]['nowrap'] = false;
		
		if ($GLOBALS['__PAGE_IS_INIT__']) {
			$this->object_change =true;
			$this->is_new = true;
			$this->is_deleted = false;
		}
		return $this;
	}
	
	/**
	 * Method delete
	 * @access public
	 * @return RowTable
	 * @since 1.0.93
	 */
	public function delete() {
		$this->is_deleted = true;
		$this->hide = true;
		$this->is_new = false;
		
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}

	/**
	 * Method isDeleted
	 * @access public
	 * @return mixed
	 * @since 1.0.93
	 */
	public function isDeleted() {
		return $this->is_deleted;
	}

	/**
	 * Method isNew
	 * @access public
	 * @return mixed
	 * @since 1.0.93
	 */
	public function isNew() {
		return $this->is_new;
	}
	
	/**
	 * Method isHeader
	 * @access public
	 * @return mixed
	 * @since 1.0.96
	 */
	public function isHeader() {
		return $this->is_header_row;
	}
	
	/**
	 * Method getId
	 * @access public
	 * @return mixed
	 * @since 1.0.93
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * Method setColumnContent
	 * @access public
	 * @param mixed $column_ind 
	 * @param object $content_object 
	 * @return RowTable
	 * @since 1.0.36
	 */
	public function setColumnContent($column_ind, $content_object) {
		if (isset($this->col_object[$column_ind-1])) {
			$this->col_object[$column_ind-1]['content_object'] = $content_object;
		}
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setColumnWidth
	 * @access public
	 * @param mixed $column_ind 
	 * @param integer $width 
	 * @return RowTable
	 * @since 1.0.36
	 */
	public function setColumnWidth($column_ind, $width) {
		if (isset($this->col_object[$column_ind-1])) {
			$this->col_object[$column_ind-1]['width'] = $width;
		}
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setColumnHeight
	 * @access public
	 * @param mixed $column_ind 
	 * @param integer $height 
	 * @return RowTable
	 * @since 1.0.36
	 */
	public function setColumnHeight($column_ind, $height) {
		if (isset($this->col_object[$column_ind-1])) {
			$this->col_object[$column_ind-1]['height'] = $height;
		}
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setColumnClass
	 * @access public
	 * @param mixed $column_ind 
	 * @param mixed $class 
	 * @return RowTable
	 * @since 1.0.36
	 */
	public function setColumnClass($column_ind, $class) {
		if (isset($this->col_object[$column_ind-1])) {
			$this->col_object[$column_ind-1]['class'] = $class;
		}
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setColumnStyle
	 * @access public
	 * @param mixed $column_ind 
	 * @param mixed $style 
	 * @return RowTable
	 * @since 1.0.36
	 */
	public function setColumnStyle($column_ind, $style) {
		if (isset($this->col_object[$column_ind-1])) {
			$this->col_object[$column_ind-1]['style'] = $style;
		}
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setColumnAlign
	 * @access public
	 * @param mixed $column_ind 
	 * @param string $align 
	 * @return RowTable
	 * @since 1.0.36
	 */
	public function setColumnAlign($column_ind, $align) {
		if (isset($this->col_object[$column_ind-1])) {
			$this->col_object[$column_ind-1]['align'] = $align;
		}
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setColumnValign
	 * @access public
	 * @param integer $column_ind 
	 * @param string $valign 
	 * @return RowTable
	 * @since 1.0.36
	 */
	public function setColumnValign($column_ind, $valign) {
		if (isset($this->col_object[$column_ind-1])) {
			$this->col_object[$column_ind-1]['valign'] = $valign;
		}
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setColumnColspan
	 * @access public
	 * @param mixed $column_ind 
	 * @param mixed $colspan 
	 * @return RowTable
	 * @since 1.0.36
	 */
	public function setColumnColspan($column_ind, $colspan) {
		if (isset($this->col_object[$column_ind-1])) {
			$this->col_object[$column_ind-1]['colspan'] = $colspan;
		}
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setColumnRowspan
	 * @access public
	 * @param mixed $column_ind 
	 * @param mixed $rowspan 
	 * @return RowTable
	 * @since 1.0.36
	 */
	public function setColumnRowspan($column_ind, $rowspan) {
		if (isset($this->col_object[$column_ind-1])) {
			$this->col_object[$column_ind-1]['rowspan'] = $rowspan;
		}
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setColumnNowrap
	 * @access public
	 * @param mixed $column_ind 
	 * @return RowTable
	 * @since 1.0.102
	 */
	public function setColumnNowrap($column_ind) {
		if (isset($this->col_object[$column_ind-1])) {
			$this->col_object[$column_ind-1]['nowrap'] = true;
		}
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}

	/**
	 * Method hide
	 * @access public
	 * @return RowTable
	 * @since 1.0.85
	 */
	public function hide() {
		$this->hide = true;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method show
	 * @access public
	 * @return RowTable
	 * @since 1.0.85
	 */
	public function show() {
		$this->hide = false;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setId
	 * @access public
	 * @param mixed $id 
	 * @return RowTable
	 * @since 1.0.85
	 */
	public function setId($id) {
		$this->id = str_replace("-", "_", $id);
		return $this;
	}
	
	/**
	 * Method render
	 * @access public
	 * @param boolean $ajax_render [default value: false]
	 * @return string html code of object RowTable
	 * @since 1.0.36
	 */
	public function render($ajax_render=false) {
		$html = "";
		if (!$ajax_render && $this->id != "") {
			if ($this->is_header_row) {
				$html .= "<thead";
			} else {
				$html .= "<tbody";
			}
			$html .= " id=\"wsp_rowtable_".$this->id."\">";;
		} else if (!$ajax_render && $this->is_header_row) {
			$html .= "<thead>";
		}
		if ($this->hide) { 
			if (!$ajax_render && $this->id != "") {
				if ($this->is_header_row) {
					$html .= "</thead>";
				} else {
					$html .= "</tbody>";
				}
			} else if (!$ajax_render && $this->is_header_row) {
				$html .= "</thead>";
			}
			$this->object_change = false;
			return $html; 
		}
		
		if (sizeof($this->col_object) == 0) {
			$this->add();
		}
		$html .= "<tr";
		if ($this->row_class != "") {
			$html .= " class=\"".$this->row_class."\"";
		}
		$html .= ">\n";
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
			
			if ($this->is_header_row) {
				$html .= " <th";
			} else {
				$html .= " <td";
			}
			
			if ($this->class != "" || $this->col_object[$i]['class'] != "") {
				$html .= " class=\"";
				if ($this->col_object[$i]['class'] != "") {
					if (is_numeric($this->col_object[$i]['class'])) {
						if ($this->is_header_row) {
							$html .= "header_".$this->col_object[$i]['class']."_bckg";
						} else {
							$html .= "bckg_".$this->col_object[$i]['class'];
						}
					} else if (is_numeric(substr($this->col_object[$i]['class'], 0, 1)) && find($this->col_object[$i]['class'], "_round") > 0) {
						if ($this->is_header_row) {
							$html .= "header_".$this->col_object[$i]['class']."_bckg";
						} else {
							$html .= "table_".substr($this->col_object[$i]['class'], 0, 1)."_round bckg_".substr($this->col_object[$i]['class'], 0, 1);
						}
					} else {
						$html .= $this->col_object[$i]['class'];
					}
				} else {
					if (is_numeric($this->class)) {
						if ($this->is_header_row) {
							$html .= "header_".$this->class."_bckg";
						} else {
							$html .= "bckg_".$this->class;
						}
					} else if (is_numeric(substr($this->class, 0, 1)) && find($this->class, "_round") > 0) {
						if ($this->is_header_row) {
							$html .= "header_".$this->class."_bckg";
						} else {
							$html .= "table_".substr($this->class, 0, 1)."_round bckg_".substr($this->class, 0, 1);
						}
					} else {
						$html .= $this->class;
					}
				}
				$html .= "\"";
			}
			
			$html .= " style=\"";
			if ($this->col_object[$i]['width'] != "") {
				if (is_numeric($this->col_object[$i]['width'])) {
					$html .= "width:".$this->col_object[$i]['width']."px;";
				} else {
					$html .= "width:".$this->col_object[$i]['width'].";";
				}
			} else if ($this->width != "") {
				if (is_numeric($this->width)) {
					$html .= "width:".$this->width."px;";
				} else {
					$html .= "width:".$this->width.";";
				}
			}
			if ($this->col_object[$i]['height'] != "") {
				if (is_numeric($this->col_object[$i]['height'])) {
					$html .= "height:".$this->col_object[$i]['height']."px;";
				} else {
					$html .= "height:".$this->col_object[$i]['height'].";";
				}
			} else if ($this->height != "") {
				if (is_numeric($this->height)) {
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
			if ($this->is_nowrap || $this->col_object[$i]['nowrap'] == true) {
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
			
			if ($this->is_header_row) {
				$html .= "</th>\n";
			} else {
				$html .= "</td>\n";
			}
		}
		$html .= "</tr>\n";
		if (!$ajax_render && $this->id != "") {
			if ($this->is_header_row) {
				$html .= "</thead>";
			} else {
				$html .= "</tbody>";
			}
		} else if (!$ajax_render && $this->is_header_row) {
			$html .= "</thead>";
		}
		
		$this->object_change = false;
		return $html;
	}
	
	/**
	 * Method getAjaxRender
	 * @access public
	 * @return string javascript code to update initial html of object RowTable (call with AJAX)
	 * @since 1.0.85
	 */
	public function getAjaxRender() {
		$html = "";
		if ($this->object_change && !$this->is_new_object_after_init) {
			if ($this->id == "") {
				throw new NewException(get_class($this)."->getAjaxRender() error: To update this object with Ajax event you must define an id (".get_class($this)."->setId())", 0, getDebugBacktrace(1));
			}
			
			$html .= "$('#wsp_rowtable_".$this->id."').html(\"".str_replace("\n", "", str_replace("\r", "", addslashes($this->render(true))))."\");\n";
		}
		return $html;
	}
	
}
?>
