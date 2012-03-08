<?php
/**
 * PHP file wsp\class\display\Table.class.php
 * @package display
 */
/**
 * Class Table
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2012 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package display
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 26/05/2011
 * @version     1.1.0 
 * @access      public
 * @since       1.0.17
 */

class Table extends WebSitePhpObject {
	/**#@+
	* Table style
	* @access public
	* @var string
	*/
	const STYLE_MAIN = "1";
	const STYLE_SECOND = "2";
	const STYLE_MAIN_ROUNDBOX = "1 table_1_round";
	const STYLE_SECOND_ROUNDBOX = "2 table_2_round";
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
	* column type properties
	* @access public
	* @var string
	*/
	const COL_TYPE_STRING = "string";
	const COL_TYPE_NUMERIC = "numeric";
	const COL_TYPE_DATE = "date";
	const COL_TYPE_HTML = "html";
	const COL_TYPE_ALT_STRING = "alt-string";
	const COL_TYPE_ANTI_THE = "anti-the";
	const COL_TYPE_NUMERIC_COMMA = "numeric-comma";
	const COL_TYPE_CURRENCY = "currency";
	const COL_TYPE_DATE_EURO = "date-euro";
	const COL_TYPE_UK_DATE = "uk_date";
	const COL_TYPE_FILE_SIZE = "file-size";
	const COL_TYPE_FORMATTED_NUM = "formatted-num";
	const COL_TYPE_TITLE_NUMERIC = "title-numeric";
	const COL_TYPE_VALUE_NUMERIC = "value-numeric";
	const COL_TYPE_TITLE_STRING = "title-string";
	const COL_TYPE_VALUE_STRING = "value-string";
	const COL_TYPE_IP_ADDRESS = "ip-address";
	const COL_TYPE_MONTHYEAR_SORT = "monthYear-sort";
	const COL_TYPE_NUM_HTML = "num-html";
	const COL_TYPE_PERCENT = "percent";
	const COL_TYPE_PRIORITY = "priority";
	const COL_TYPE_SIGNED_NUM = "signed-num";
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
	private $max_nb_cols = 0;
	
	private $ajax_refresh_all_table = false;
	
	private $is_advance_table = false;
	private $advance_table_info = false;
	private $is_sortable = false;
	private $sort_col_number = -1;
	private $sort_order = "asc";
	private $pagination = false;
	private $pagination_row_per_page = -1;
	private $paginate_full_numbers = false;
	private $advance_table_title = "";
	private $advance_table_type_define = false;
	private $col_type = array();
	/**#@-*/
	
	/**
	 * Constructor Table
	 * @param integer $cellpadding [default value: 0]
	 * @param integer $cellspacing [default value: 0]
	 * @param string $width 
	 * @param string $default_align 
	 * @param string $default_valign 
	 */
	function __construct($cellpadding=0, $cellspacing=0, $width='', $default_align='', $default_valign='') {
		parent::__construct();
		
		$this->cellpadding = $cellpadding;
		$this->cellspacing = $cellspacing;
		$this->width = $width;
		$this->default_align = $default_align;
		$this->default_valign = $default_valign;
	}
	
	/**
	 * Method setCellpadding
	 * @access public
	 * @param integer $cellpadding 
	 * @return Table
	 * @since 1.0.36
	 */
	public function setCellpadding($cellpadding) {
		$this->cellpadding = $cellpadding;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setCellspacing
	 * @access public
	 * @param integer $cellspacing 
	 * @return Table
	 * @since 1.0.36
	 */
	public function setCellspacing($cellspacing) {
		$this->cellspacing = $cellspacing;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setWidth
	 * @access public
	 * @param integer $width 
	 * @return Table
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
	 * @return Table
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
	 * @param string $class 
	 * @return Table
	 * @since 1.0.36
	 */
	public function setClass($class) {
		$this->class = $class;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setDefaultAlign
	 * @access public
	 * @param string $default_align 
	 * @return Table
	 * @since 1.0.36
	 */
	public function setDefaultAlign($default_align) {
		$this->default_align = $default_align;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setDefaultValign
	 * @access public
	 * @param string $default_valign 
	 * @return Table
	 * @since 1.0.36
	 */
	public function setDefaultValign($default_valign) {
		$this->default_valign = $default_valign;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}

	/**
	 * Method setBorder
	 * @access public
	 * @param integer $border [default value: 1]
	 * @param string $border_color [default value: grey]
	 * @param string $border_style [default value: solid]
	 * @return Table
	 * @since 1.0.36
	 */
	public function setBorder($border=1, $border_color="grey", $border_style="solid") {
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
	 * @return Table
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
	 * @param mixed $style 
	 * @return Table
	 * @since 1.0.36
	 */
	public function setStyle($style) {
		$this->style = $style;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setId
	 * @access public
	 * @param mixed $id 
	 * @return Table
	 * @since 1.0.36
	 */
	public function setId($id) {
		$this->id = $id;
		return $this;
	}
		
	/**
	 * Method getId
	 * @access public
	 * @return string
	 * @since 1.0.36
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * Method addRow
	 * @access public
	 * @param mixed $row [default value: null]
	 * @param string $align 
	 * @param string $valign 
	 * @return RowTable
	 * @since 1.0.36
	 */
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
		} else {
			$row->setAlign($align);
			$row->setValign($valign);
		}
		if ($row->getClass() == "" && $this->class != "") {
			$row->setClass($this->class);
		}
		$this->rows[sizeof($this->rows)] = $row;
		
		if ($row->getNbColumns() > $this->max_nb_cols) {
    		$this->max_nb_cols = $row->getNbColumns();
    	}
		
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $row;
	}
	
	/**
	 * Method addRowColumns
	 * @access public
	 * @param mixed $object [default value: null]
	 * @param mixed $object2 [default value: null]
	 * @param mixed $object3 [default value: null]
	 * @param mixed $object4 [default value: null]
	 * @param mixed $object5 [default value: null]
	 * @return RowTable
	 * @since 1.0.36
	 */
	public function addRowColumns($object=null, $object2=null, $object3=null, $object4=null, $object5=null) {
		$row = new RowTable();
		$row->setAlign($this->default_align);
		$row->setValign($this->default_valign);
		
		$args = func_get_args();
		for ($i=0; $i < sizeof($args); $i++) {
    		if ($args[$i] !== null) {
				$row->add($args[$i]);
    		}
    	}
		if ($row->getClass() == "" && $this->class != "" ) {
			$row->setClass($this->class);
		}
    	$this->rows[sizeof($this->rows)] = $row;
    	
    	if ($row->getNbColumns() > $this->max_nb_cols) {
    		$this->max_nb_cols = $row->getNbColumns();
    	}
    	
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
    	return $row;
	}
	
	/**
	 * Method deleteRow
	 * @access public
	 * @param mixed $row_table_id 
	 * @param boolean $catch_exception [default value: true]
	 * @return boolean
	 * @since 1.0.93
	 */
	public function deleteRow($row_table_id, $catch_exception=true) {
		for ($i=0; $i < sizeof($this->rows); $i++) {
			if ($this->rows[$i]->getId() == $row_table_id) {
				$this->rows[$i]->delete();
				if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
				return true;
			}
		}
		if ($catch_exception) {
			throw new NewException(get_class($this)."->deleteRow() error: Unable to delete id ".$row_table_id." (not found)", 0, getDebugBacktrace(1));
		} else {
			return false;
		}
	}
	
	/**
	 * Method deleteAllRows
	 * @access public
	 * @return Table
	 * @since 1.0.97
	 */
	public function deleteAllRows() {
		for ($i=0; $i < sizeof($this->rows); $i++) {
			$this->rows[$i]->delete();
		}
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		
		return $this;
	}
	
	/**
	 * Method getNbRows
	 * @access public
	 * @return mixed
	 * @since 1.0.93
	 */
	public function getNbRows() {
		return sizeof($this->rows);
	}
	
	/**
	 * Method getMaxNbColumns
	 * @access public
	 * @return mixed
	 * @since 1.0.93
	 */
	public function getMaxNbColumns() {
		return $this->max_nb_cols;
	}
	
	/**
	 * Method setAjaxRefreshAllTable
	 * @access public
	 * @return Table
	 * @since 1.0.95
	 */
	public function setAjaxRefreshAllTable() {
		if ($this->id == "") {
			throw new NewException(get_class($this)."->setAjaxRefreshAllTable() error: you must define an id to the Table (".get_class($this)."->setId())", 0, getDebugBacktrace(1));
		}
		
		$this->ajax_refresh_all_table = true;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method activateAdvanceTable
	 * @access public
	 * @return Table
	 * @since 1.0.96
	 */
	public function activateAdvanceTable() {
		if ($this->id == "") {
			throw new NewException(get_class($this)."->activateAdvanceTable() error: you must define an id to the Table (".get_class($this)."->setId())", 0, getDebugBacktrace(1));
		}
		
		$this->is_advance_table = true;
		$this->addCss(BASE_URL."wsp/css/jquery.dataTables.css", "", true);
		$this->addJavaScript(BASE_URL."wsp/js/jquery.dataTables.min.js", "", true);
		
		return $this;
	}
	
	/**
	 * Method activateAdvanceTableInfo
	 * @access public
	 * @return Table
	 * @since 1.0.96
	 */
	public function activateAdvanceTableInfo() {
		if ($this->id == "") {
			throw new NewException(get_class($this)."->activatePagination() error: you must define an id to the Table (".get_class($this)."->setId())", 0, getDebugBacktrace(1));
		}
		
		$this->advance_table_info = true;
		$this->activateAdvanceTable();
		
		return $this;
	}
	
	/**
	 * Method activateSort
	 * @access public
	 * @param mixed $sort_col_number 
	 * @param string $sort_order [default value: asc]
	 * @return Table
	 * @since 1.0.96
	 */
	public function activateSort($sort_col_number, $sort_order='asc') {
		if ($this->id == "") {
			throw new NewException(get_class($this)."->activateSort() error: you must define an id to the Table (".get_class($this)."->setId())", 0, getDebugBacktrace(1));
		}
		
		if (!is_integer($sort_col_number)) {
			throw new NewException(get_class($this)."->activateSort() error: \$sort_col_number must be an integer", 0, getDebugBacktrace(1));
		}
		$this->sort_col_number = $sort_col_number;
		
		if ($sort_order != "asc" && $sort_order != "desc") {
			throw new NewException(get_class($this)."->activateSort() error: authorized values for \$sort_order paramter: asc, desc.", 0, getDebugBacktrace(1));
		}
		$this->sort_order = $sort_order;
		$this->is_sortable = true;
		$this->activateAdvanceTable();
		
		return $this;
	}
	
	/**
	 * Method setAdvanceTableColumnType
	 * @access public
	 * @param mixed $col_number 
	 * @param string $type [default value: html]
	 * @return Table
	 * @since 1.0.99
	 */
	public function setAdvanceTableColumnType($col_number, $type='html') {
		if ($this->id == "") {
			throw new NewException(get_class($this)."->setColumnType() error: you must define an id to the Table (".get_class($this)."->setId())", 0, getDebugBacktrace(1));
		}
		
		if (!is_integer($col_number)) {
			throw new NewException(get_class($this)."->setColumnType() error: \$sort_col_number must be an integer", 0, getDebugBacktrace(1));
		}
		
		$this->col_type[$col_number-1] = $type;
		$this->advance_table_type_define = true;
		
		$this->addJavaScript(BASE_URL."wsp/js/jquery.dataTables.sType.js", "", true);
		$this->activateAdvanceTable();
		
		return $this;
	}
	
	/**
	 * Method activatePagination
	 * @access public
	 * @param double $nb_row_per_page [default value: 10]
	 * @param boolean $style_full_numbers [default value: false]
	 * @return Table
	 * @since 1.0.96
	 */
	public function activatePagination($nb_row_per_page=10, $style_full_numbers=false) {
		if ($this->id == "") {
			throw new NewException(get_class($this)."->activatePagination() error: you must define an id to the Table (".get_class($this)."->setId())", 0, getDebugBacktrace(1));
		}
		if (!is_integer($nb_row_per_page)) {
			throw new NewException(get_class($this)."->activatePagination() error: \$nb_row_per_page must be an integer", 0, getDebugBacktrace(1));
		}
		
		$this->pagination = true;
		if ($nb_row_per_page > 10 && $nb_row_per_page <= 25) {
			$this->pagination_row_per_page = 25;
		} else if ($nb_row_per_page > 25 && $nb_row_per_page <= 50) {
			$this->pagination_row_per_page = 50;
		} else if ($nb_row_per_page > 50 && $nb_row_per_page <= 100) {
			$this->pagination_row_per_page = 100;
		} else {
			$this->pagination_row_per_page = 10;
		}
		$this->paginate_full_numbers = $style_full_numbers;
		$this->activateAdvanceTable();
		
		return $this;
	}
	
	/**
	 * Method activateSearch
	 * @access public
	 * @return Table
	 * @since 1.0.96
	 */
	public function activateSearch() {
		if ($this->id == "") {
			throw new NewException(get_class($this)."->activatePagination() error: you must define an id to the Table (".get_class($this)."->setId())", 0, getDebugBacktrace(1));
		}
		
		$this->is_filtered = true;
		$this->activateAdvanceTable();
		
		return $this;
	}
	
	/**
	 * Method setTitle
	 * @access public
	 * @param mixed $title 
	 * @return Table
	 * @since 1.0.97
	 */
	public function setTitle($title) {
		$this->advance_table_title = $title;
		return $this;
	}
	
	/**
	 * Method render
	 * @access public
	 * @param boolean $ajax_render [default value: false]
	 * @return string html code of object Table
	 * @since 1.0.36
	 */
	public function render($ajax_render=false) {
		$html = "";
		if (!$ajax_render && $this->is_advance_table && $this->width != "") {
			$html .= "<div style=\"";
			if (is_integer($this->width)) {
				$html .= "width:".$this->width."px;";
			} else {
				$html .= "width:".$this->width.";";
			}
			$html .= "\">";
		}
		$html .= "<table ";
		if ($this->border != "" && is_integer($this->border)) {
			$html .= "border=\"".$this->border."\" ";
		}
		$html .= "cellpadding=\"".$this->cellpadding."\" cellspacing=\"".$this->cellspacing."\"";
		if ($this->id != "") {
			$html .= " id=\"".$this->id."\"";
		}
		if ($this->class != "" || $this->is_advance_table) {
			$html .= " class=\"";
			if (is_integer($this->class) || (is_integer(substr($this->class, 0, 1)) && find($this->class, "_round") > 0)) {
				$html .= "table_".$this->class;
			} else {
				$html .= $this->class;
			}
			if ($this->is_advance_table) {
				$html .= " display";
			}
			$html .= "\"";
		}
		if ($this->border != "" || $this->width != "" || $this->height != "" || $this->font_size != "" || $this->font_family != "" || $this->font_weight != "" || $this->style != "") {
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
			if (!$this->rows[$i]->isDeleted()) {
				$html .= "	".$this->rows[$i]->render();
			}
		}
		$html .= "</table>\n";
		if (!$ajax_render && $this->is_advance_table && $this->width != "") {
			$html .= "</div>";
		}
		
		$html .= $this->renderAdvanceTable();
		
		$this->object_change = false;
		return $html;
	}
	
	/**
	 * Method renderAdvanceTable
	 * @access private
	 * @return mixed
	 * @since 1.0.96
	 */
	private function renderAdvanceTable() {
		$html = "";
		
		if ($this->is_advance_table) {
			if ($this->id == "") {
				throw new NewException("To use advance table propoerties (filter, sort, pagination) you must define an id (".get_class($this)."->setId())", 0, getDebugBacktrace(1));
			}
			
			if (sizeof($this->rows) == 0 || !$this->rows[0]->isHeader()) {
				throw new NewException("To use advance table you must define the first RowTable with Header type (RowTable->setHeaderClass(0))", 0, getDebugBacktrace(1));
			}
			
			$html .= $this->getJavascriptTagOpen();
			$html .= "$(\"#".$this->getId()."\").dataTable({'bJQueryUI': true";
			if ($this->is_sortable) {
				$html .= ", 'aaSorting': [[".($this->sort_col_number-1).", '".$this->sort_order."']]";
			} else {
				$html .= ", 'bSort': false";
			}
			if (!$this->pagination) {
				$html .= ", 'bLengthChange': false";
				$html .= ", 'bPaginate': false";
			} else {
				$html .= ", 'iDisplayLength': ".$this->pagination_row_per_page;
				if ($this->paginate_full_numbers) {
					$html .= ", 'sPaginationType': 'full_numbers'";
				}
			}
			if ($this->is_filtered) {
				$html .= ", 'bFilter': true";
			} else {
				$html .= ", 'bFilter': false";
			}
			if (!$this->advance_table_info) {
				$html .= ", 'bInfo': false";
			}
			if ($this->width != "") {
				$html .= ", 'bAutoWidth': false";
			}
			if ($this->advance_table_title != "") {
				$html .= ", 'sDom': '<\"toolbar\">frtip'";
			}
			if ($this->advance_table_type_define) {
				$html .= ", 'aoColumns': [";
				for ($i=0; $i < $this->max_nb_cols; $i++) {
					if ($i > 0) { $html .= ", "; }
					if ($this->col_type[$i] != "") {
						$html .= "{ 'sType': '".$this->col_type[$i]."' }";
					} else {
	            		$html .= "null";
					}
				}
	        	$html .= "]";
			}
			$html .= " });\n";
			if ($this->advance_table_title != "") {
				$html .= "$('#".$this->getId()."_wrapper').find('div.toolbar').html('";
				if (gettype($this->advance_table_title) == "object" && method_exists($this->advance_table_title, "render")) {
					$html .= addslashes($this->advance_table_title->render());
				} else {
					$html .= addslashes($this->advance_table_title);
				}
				$html .= "').attr('align', 'left');\n";
				if ($this->is_filtered) {
					$html .= "$('#".$this->getId()."_filter').attr('class', 'fg-toolbar ui-toolbar ui-widget-header ui-corner-tl ui-corner-tr ui-helper-clearfix');\n";
				}
				if ($this->pagination) {
					$html .= "$('#".$this->getId()."_paginate').attr('class', 'fg-toolbar ui-toolbar ui-widget-header ui-corner-bl ui-corner-br ui-helper-clearfix');\n";
				}
			}
			$html .= $this->getJavascriptTagClose();
		}
		
		return $html;
	}
	
	/**
	 * Method getAjaxRender
	 * @access public
	 * @return string javascript code to update initial html of object Table (call with AJAX)
	 * @since 1.0.93
	 */
	public function getAjaxRender() {
		$html = "";
		
		if ($this->object_change && !$this->is_new_object_after_init) {
			if ($this->ajax_refresh_all_table) { // refresh all table
				if ($this->is_advance_table || (is_browser_ie() && get_browser_ie_version() < 8)) {
					$html .= "var my_parent_node = $('#".$this->id."').parent();";
				} else {
					$html .= "var my_parent_node = $('#".$this->id."');";
				}
				$html .= "my_parent_node.empty();";
				
				$array_ajax_render = extract_javascript($this->render(false));
				for ($j=1; $j < sizeof($array_ajax_render); $j++) {
					new JavaScript($array_ajax_render[$j], true);
				}
				if (trim($array_ajax_render[0]) != "") {
					$html .= "my_parent_node.append('".str_replace("\n", "", str_replace("\r", "", addslashes($array_ajax_render[0])))."');";
				}
			} else {
				for ($i=0; $i < sizeof($this->rows); $i++) {
					if ($this->rows[$i]->isNew()) {
						$array_ajax_render = extract_javascript($this->rows[$i]->render(false));
						for ($j=1; $j < sizeof($array_ajax_render); $j++) {
							new JavaScript($array_ajax_render[$j], true);
						}
						
						$html .= "$('#".$this->id."').append('".str_replace("\n", "", str_replace("\r", "", addslashes($array_ajax_render[0])))."');";
					} else if ($this->rows[$i]->isDeleted()) {
						$html .= "$('#wsp_rowtable_".$this->rows[$i]->getId()."').remove();";
					}
				}
			}
		}
		
		if ($html != "" && $this->id == "") {
			throw new NewException(get_class($this)."->getAjaxRender() error: To update this object with Ajax event you must define an id (".get_class($this)."->setId())", 0, getDebugBacktrace(1));
		}
		
		return $html;
	}
	
}
?>
