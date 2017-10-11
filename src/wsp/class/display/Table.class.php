<?php
/**
 * PHP file wsp\class\display\Table.class.php
 * @package display
 */
/**
 * Class Table
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2017 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package display
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 11/10/2017
 * @version     1.2.15
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
     * column filter position properties
     * @access public
     * @var string
     */
    const COL_FILTER_POSITION_TOP = "top";
    const COL_FILTER_POSITION_BOTTOM = "bottom";
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
    private $table_class = "";
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
    private $is_search_enable = false;
    private $is_fixe_header = false;
    private $is_column_filter = false;
    private $column_filter_params = "";
    private $column_filter_position = "top";
    private $column_filter_range_format = "";
    private $vertical_scroll = false;
    private $vertical_scroll_size = 200;
    private $horizontal_scroll = false;
    private $scrollX_inner = "110%";

    private $sql_data_view_object = null;
    private $data_row_iterator_object = null;
    private $is_table_form_object = false;
    private $table_form_object = null;
    private $from_sql_data_view_insert = false;
    private $from_sql_data_view_update = false;
    private $from_sql_data_view_delete = false;
    private $from_sql_data_view_properties = array();
    private $from_sql_data_view_add_button = null;
    private $from_sql_data_view_reload_pic = null;
    private $from_sql_data_view_data_row_array = array();
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
	 * Method setTableClass
	 * @access public
	 * @param mixed $class 
	 * @return Table
	 * @since 1.2.13
	 */
    public function setTableClass($class) {
        $this->table_class = $class;
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
        $this->id = str_replace("-", "_", $id);
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
            if (sizeof($this->rows) > 0 && $this->rows[0]->isHeader()) {
                $row->setBorderPredefinedStyle($this->class);
            }
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
            if (sizeof($this->rows) > 0 && $this->rows[0]->isHeader()) {
                $row->setBorderPredefinedStyle($this->class);
            }
        }
        $this->rows[sizeof($this->rows)] = $row;

        if ($row->getNbColumns() > $this->max_nb_cols) {
            $this->max_nb_cols = $row->getNbColumns();
        }

        if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
        return $row;
    }

	/**
	 * Method loadFromSqlDataView
	 * @access public
	 * @param mixed $sql 
	 * @param mixed $properties [default value: array(]
	 * @return boolean
	 * @since 1.1.6
	 */
    public function loadFromSqlDataView($sql, $properties=array(), $insert=false, $update=false, $delete=false) {
        if ($this->id == "") {
            throw new NewException(get_class($this)."->loadFromSqlDataView() error: you must define an id to the Table (".get_class($this)."->setId())", 0, getDebugBacktrace(1));
        }

        if (gettype($sql) != "object" || get_class($sql) != "SqlDataView") {
            throw new NewException(get_class($this)."->loadFromSqlDataView() error: \$sql is not SqlDataView object", 0, getDebugBacktrace(1));
        }

        if ($insert || $update || $delete) {
            if ($sql->isQueryWithJoin()) {
                throw new NewException(get_class($this)."->loadFromSqlDataView() error: you need use SqlDataView object without JOIN if you want to use insert update or delete.", 0, getDebugBacktrace(1));
            }

            $this->is_table_form_object = true;
            $this->table_form_object = new Form($this->getPage(), "Form_Table_".$this->id);
            $this->table_form_object->setContent($this);
            $this->table_form_object->onSubmitJs("return false;");
        }

        if (!is_array($properties)) {
            throw new NewException(get_class($this)."->loadFromSqlDataView() error: \$properties need to be an array", 0, getDebugBacktrace(1));
        }

        $this->from_sql_data_view_insert = $insert;
        $this->from_sql_data_view_update = $update;
        $this->from_sql_data_view_delete = $delete;

        $list_attribute = $sql->getListAttributeArray();
        // Add properties to apply on all fields
        if (isset($properties[ModelViewMapper::PROPERTIES_ALL]) && is_array($properties[ModelViewMapper::PROPERTIES_ALL])) {
            $apply_all_array = $properties[ModelViewMapper::PROPERTIES_ALL];
            foreach ($apply_all_array as $property_name => $property_value) {
                for ($i=0; $i < sizeof($list_attribute); $i++) {
                    $property[$property_name] = $property_value;
                    if (isset($properties[$list_attribute[$i]])) {
                        $properties[$list_attribute[$i]] = array_merge($properties[$list_attribute[$i]], $property);
                    } else {
                        $properties[$list_attribute[$i]] = $property;
                    }
                }
            }
        }

        // check foreign keys
        $db_table_foreign_keys = $sql->getDbTableObject()->getDbTableForeignKeys();
        foreach ($db_table_foreign_keys as $fk_attribute => $value) {
            if (isset($properties[$fk_attribute])) {
                $fk_property = $properties[$fk_attribute];
                if (isset($fk_property["fk_attribute"])) {
                    // create combobox
                    $cmb = new ComboBox(($this->table_form_object==null?$this->getPage():$this->table_form_object));

                    // get foreign key data
                    $query = "select distinct ".$value["column"]." as id, ".$fk_property["fk_attribute"]." as value from ".$value["table"];
                    if (isset($fk_property["fk_where"])) {
                        $query .= " where ".$fk_property["fk_where"];
                    }
                    if (isset($fk_property["fk_orderby"])) {
                        $query .= " order by ".$fk_property["fk_orderby"];
                    }
                    $stmt = DataBase::getInstance()->prepareStatement($query);
                    $row = DataBase::getInstance()->stmtBindAssoc($stmt, $row);
                    while ($stmt->fetch()) {
                        $cmb->addItem(utf8encode($row['id']), utf8encode($row['value']));
                    }

                    // add combo box in properties
                    $value['cmb_obj'] = $cmb;
                    $properties[$fk_attribute] = array_merge($properties[$fk_attribute], $value);
                }
            }
        }
        $this->from_sql_data_view_properties = $properties;

        // Define header
        $is_table_defined_style = false;
        $auto_header = (sizeof($this->rows) > 0?false:true);
        if ($auto_header) {
            $row_table = new RowTable();
            for ($i=0; $i < sizeof($list_attribute); $i++) {
                // get property display
                if (isset($this->from_sql_data_view_properties[$list_attribute[$i]]["display"]) &&
                    $this->from_sql_data_view_properties[$list_attribute[$i]]["display"] == false) {
                    continue;
                }
                $row_table->add($list_attribute[$i]);
            }
            if ($delete || $insert) {
                $row_table->add();
            }
            $row_table = $this->addRow($row_table);
            if ($this->class == "") {
                $row_table->setHeaderClass(0);
            } else if (is_numeric($this->class)) {
                $row_table->setHeaderClass($this->class);
                $is_table_defined_style = true;
            }
        } else if ($delete || $insert) {
            $row_table = $this->rows[0];
            $row_table->add();
        }

        $key_attributes = $sql->getPrimaryKeysAttributes();
        // check if all the fields of sql object are in the SQL attributes
        $list_attribute_change = false;
        $auto_hide_field_from = -1;
        $all_list_attributes = $sql->getDbTableObject()->getDbTableAttributes();
        for ($i=0; $i < sizeof($all_list_attributes); $i++) {
            if (!in_array($all_list_attributes[$i], $list_attribute)) {
                $tmp_list_attribute = $sql->getCustomFields();
                $tmp_list_attribute .= ", `".$sql->getDbTableObject()->getDbTableName()."`.`".$all_list_attributes[$i]."`";
                $sql->setCustomFields($tmp_list_attribute);
                if ($auto_hide_field_from == -1) {
                    $auto_hide_field_from = sizeof($list_attribute);
                }
            }
        }
        if ($auto_hide_field_from != -1) {
            $list_attribute = $sql->getListAttributeArray();
            for ($i=$auto_hide_field_from; $i < sizeof($list_attribute); $i++) {
                $properties[$list_attribute[$i]]["display"] = false;
            }
        }
        $list_attribute_type = $sql->getListAttributeTypeArray();
        $auto_increment_id = $sql->getDbTableObject()->getDbTableAutoIncrement();
        $this->from_sql_data_view_properties = $properties;

	if ($insert || $update || $delete) {
	        // create empty row (ack to keep correct order of the table)
	        $row_table = new RowTable();
	        $row_table->setId($this->id."_emptyrow_");
	        for ($i=0; $i < sizeof($list_attribute); $i++) {
	            // get property display
	            if (isset($this->from_sql_data_view_properties[$list_attribute[$i]]["display"]) &&
	                $this->from_sql_data_view_properties[$list_attribute[$i]]["display"] == false) {
	                continue;
	            }
	            $row_table->add();
	        }
	        if ($insert || $delete) {
	            $row_table->add();
	        }
	        $row_table->setStyle("display:none;");
	        $this->addRow($row_table);
        }

        // Create insert row
        if ($insert) {
            $row_table = new RowTable();
            $row_table->setId($this->id."_row_");
            for ($i=0; $i < sizeof($list_attribute); $i++) {
                // get property display
                if (isset($this->from_sql_data_view_properties[$list_attribute[$i]]["display"]) &&
                    $this->from_sql_data_view_properties[$list_attribute[$i]]["display"] == false) {
                    continue;
                }

                if ($list_attribute[$i] != $auto_increment_id) {
                    $input_obj = $this->createDbAttributeObject(null, $list_attribute, $list_attribute_type, $i, "", $key_attributes);
                    $row_table->add($input_obj);
                } else {
                    $row_table->add();
                }
            }
            $this->from_sql_data_view_add_button = new Button($this->table_form_object, $this->id."_btnadd__ind_");
            $this->from_sql_data_view_add_button->setPrimaryIcon("img/wsp-admin/button_ok_16.png");
            $this->from_sql_data_view_add_button->onClick("onChangeTableFromSqlDataView")->setAjaxEvent()->disableAjaxWaitMessage();
            $row_table->add($this->from_sql_data_view_add_button);
            if ($is_table_defined_style) {
                $row_table->setBorderPredefinedStyle($this->class);
            }
            $this->addRow($row_table);
        } else if (($insert || $update ||$delete) && $this->is_advance_table) {
            $row_table = clone($row_table);
            $this->addRow($row_table);
        }

        // create reload button
        if ($insert || $update) {
            $this->from_sql_data_view_reload_pic = new Picture("wsp/img/reload_16x16.png", 16, 16, 0, Picture::ALIGN_ABSMIDDLE, "Please reload");
            $this->from_sql_data_view_reload_pic->setId($this->id."_btnreload__ind_");
            $this->from_sql_data_view_reload_pic->onClick($this->getPage(), "onChangeTableFromSqlDataView")->setAjaxEvent()->disableAjaxWaitMessage();
        }

        // Check if a delete button is clicked (if no primary key defined in table)
        $deleted_ind = -1;
        $is_delete_action = false;
        $it = $sql->retrieve();
        if ($this->from_sql_data_view_delete && sizeof($key_attributes) == 0) {
            for ($i=0; $i < $it->getRowsNum(); $i++) {
                $delete_pic = new Picture("img/wsp-admin/delete_16.png", 16, 16, 0, Picture::ALIGN_ABSMIDDLE);
                $delete_pic->setId($this->id."_btndel__ind_".$i);
                $delete_pic->onClickJs("if (!confirm('".__(TABLE_CONFIME_DEL_ROW)."')) { return false; }");
                $delete_pic->onClick($this->getPage(), "onChangeTableFromSqlDataView")->setAjaxEvent()->disableAjaxWaitMessage();
                if ($delete_pic->isClicked()) {
                    $is_delete_action = true;
                    $deleted_ind = $i;
                    break;
                }
            }
        }

        // Generate table data
        $ind = 0;
        $this->sql_data_view_object = $sql;
        $this->data_row_iterator_object = $it;
        while ($it->hasNext()) {
            $row = $it->next();
            $key_str = "";
            if (sizeof($key_attributes) == 0) {
                $key_str = $ind;
            } else {
                try {
                    for ($i=0; $i < sizeof($key_attributes); $i++) {
                        if ($i > 0) { $key_str .= "-"; }
                        $key_str .= $row->getValue($key_attributes[$i]);
                    }
                    $key_str = strtolower(url_rewrite_format($key_str));
                } catch (Exception $ex) {
                    if ($insert || $update || $delete) {
                        throw new NewException(get_class($this)."->loadFromSqlDataView() error: \$properties need to include primary key of the table if you want to use insert, update or delete feature", 0, getDebugBacktrace(1));
                    } else {
                        $key_str = $ind;
                    }
                }
                if ($key_str === "") {
                    throw new NewException(get_class($this)."->loadFromSqlDataView() error: The system can't create empty key for row (key is created by the attribute(s): ".implode(", ",$key_attributes).")", 0, getDebugBacktrace(1));
                }
            }
            $this->from_sql_data_view_data_row_array[$key_str] = $row;

            if ($deleted_ind == $ind) { // if no primary key defined in table
                $deleted_ind = -1;
                $ind--;
            } else {
                $this->addRowLoadFromSqlDataView($row, $list_attribute, $list_attribute_type, $key_attributes, $key_str, $is_delete_action, $ind);
            }
            $ind++;
        }
    }

	/**
	 * Method addRowLoadFromSqlDataView
	 * @access private
	 * @param mixed $row 
	 * @param mixed $list_attribute 
	 * @param mixed $list_attribute_type 
	 * @param mixed $key_attributes 
	 * @param mixed $ind 
	 * @param boolean $is_delete_action [default value: false]
	 * @param double $line_nb [default value: 0]
	 * @return boolean
	 * @since 1.1.6
	 */
    private function addRowLoadFromSqlDataView($row, $list_attribute, $list_attribute_type, $key_attributes, $ind, $is_delete_action=false, $line_nb=null) {
        if ($this->from_sql_data_view_delete) {
            // create delete button if not already exists
            $bnt_del_id = $this->id."_btndel__ind_".str_replace("-", "_", $ind);
            $delete_pic = $this->getPage()->getObjectId($bnt_del_id);
            if ($delete_pic == null) {
                $delete_pic = new Picture("img/wsp-admin/delete_16.png", 16, 16, 0, Picture::ALIGN_ABSMIDDLE);
                $delete_pic->setId($bnt_del_id);
                $delete_pic->onClickJs("if (!confirm('".__(TABLE_CONFIME_DEL_ROW)."')) { return false; }");
                $delete_pic->onClick($this->getPage(), "onChangeTableFromSqlDataView")->setAjaxEvent()->disableAjaxWaitMessage();
            }
        }

        // create row
        $row_table = new RowTable();
        if ($this->from_sql_data_view_delete) { $row_table->setId($this->id."_row_".$ind); }
        for ($i=0; $i < sizeof($list_attribute); $i++) {
            // get field properties
            if (is_array($this->from_sql_data_view_properties[$list_attribute[$i]])) {
                $attribute_properties = $this->from_sql_data_view_properties[$list_attribute[$i]];
            } else {
                $attribute_properties = array();
            }

            // get property display
            if (isset($attribute_properties["display"]) && $attribute_properties["display"] == false) {
                continue;
            }

            // get property update
            $is_update_ok = true;
            if (isset($attribute_properties["update"]) && $attribute_properties["update"] == false) {
                $is_update_ok = false;
            }

            if ($this->from_sql_data_view_update && !in_array($list_attribute[$i], $key_attributes) && $is_update_ok) {
                $row_value = $row->getValue($list_attribute[$i]);
                if (gettype($row_value) == "object" && method_exists($row_value, "render")) {
                    $row_value = $row_value->render();
                }
                $edit_pic = new Picture("wsp/img/edit_16x16.png", 16, 16);
                $row_obj = new Object($edit_pic, trim($row_value)==""?"&nbsp;&nbsp;":utf8encode($row_value));
                $row_obj->setId($this->id."_".$list_attribute[$i]."_obj_".$ind)->setStyle("cursor:pointer;border:1px solid gray;");

                $input_obj = $this->createDbAttributeObject($row, $list_attribute, $list_attribute_type, $i, $ind, $key_attributes);
                if (get_class($input_obj) == "ComboBox") { // Get foreign key value
                    $row_obj->emptyObject();
                    $value = $input_obj->getText();
                    $row_obj->add($edit_pic, trim($value)==""?"&nbsp;&nbsp;":$value);
                } else if (get_class($input_obj) == "Calendar") {
                    $row_obj->emptyObject();
                    $value = $input_obj->getValueStr();
                    $row_obj->add($edit_pic, trim($value)==""?"&nbsp;&nbsp;":$value);
                    $row_table->setNowrap();
                }

                $row_obj_input = new Object($input_obj);
                $row_obj_input->setId($this->id."_".$list_attribute[$i]."_input_obj_".$ind);

                $cancel_pic = new Picture("wsp/img/cancel_12x12.png", 12, 12);
                $cancel_pic->setId($this->id."_img_".$ind."_cancel_".$list_attribute[$i]);
                $cancel_pic->onClickJs("$('#".$row_obj->getId()."').css('display', 'inline');$('#".$row_obj_input->getId()."').hide();".($this->from_sql_data_view_add_button!=null?"$('#".$this->from_sql_data_view_add_button->getId()."').button({ disabled: false });":""));
                $cancel_pic_obj = new Object($cancel_pic);
                $row_obj_input->add($cancel_pic_obj->forceSpanTag()->setStyle("position:absolute;"));

                if (!$this->getPage()->isAjaxPage() || $is_delete_action ||
                    ($this->from_sql_data_view_reload_pic != null && $this->from_sql_data_view_reload_pic->isClicked()) ||
                    ($this->from_sql_data_view_add_button != null && $this->from_sql_data_view_add_button->isClicked())) {
                    $this->getPage()->addObject(new JavaScript("$(document).ready(function() { $('#".$row_obj_input->getId()."').hide(); });"));
                }
                $row_obj->onClickJs("$('#".$row_obj->getId()."').hide();$('#".$row_obj_input->getId()."').show();".($this->from_sql_data_view_add_button!=null?"$('#".$this->from_sql_data_view_add_button->getId()."').button({ disabled: true });":""));
                $row_table->add(new Object($row_obj, $row_obj_input));

                // get properties align
                if (isset($attribute_properties["align"])) {
                    $row_table->setColumnAlign($i+1, $attribute_properties["align"]);
                }
            } else {
                $value = $row->getValue($list_attribute[$i]);
                if (isset($this->from_sql_data_view_properties[$list_attribute[$i]]['cmb_obj'])) {
                    $input_obj_tmp = $this->from_sql_data_view_properties[$list_attribute[$i]]['cmb_obj'];
                    $input_obj_tmp->setValue($value);
                    $value = $input_obj_tmp->getText();
                }
                if (get_class($value) == "DateTime") {
                    $value = $value->format("Y-m-d");
                }
                $row_table->add(utf8encode($value));
            }
        }
        if ($this->from_sql_data_view_delete) {
            $row_table->add($delete_pic);
        } else if ($this->from_sql_data_view_insert) {
            $row_table->add();
        }
        if ($is_table_defined_style) {
            $row_table->setBorderPredefinedStyle($this->class);
        }
        if ($this->is_advance_table && ($this->from_sql_data_view_insert || $this->from_sql_data_view_update || $this->from_sql_data_view_delete)) {
            if (isset($line_nb) && $line_nb !== null) {
                $row_table->setRowClass(($line_nb%2==0?"odd":"even"));
            } else if (is_numeric($ind)) {
                $row_table->setRowClass(($ind%2==0?"odd":"even"));
            } else {
                $row_table->setRowClass("even");
            }
        }
        $this->addRow($row_table);
    }

	/**
	 * Method createDbAttributeObject
	 * @access private
	 * @param mixed $row 
	 * @param mixed $list_attribute 
	 * @param mixed $list_attribute_type 
	 * @param mixed $i 
	 * @param mixed $ind 
	 * @param mixed $key_attributes 
	 * @return mixed
	 * @since 1.1.6
	 */
    private function createDbAttributeObject($row, $list_attribute, $list_attribute_type, $i, $ind, $key_attributes) {
        // get property cmb_obj (created by method loadFromSqlDataView)
        if (isset($this->from_sql_data_view_properties[$list_attribute[$i]]['cmb_obj'])) {
            $input_obj_tmp = $this->from_sql_data_view_properties[$list_attribute[$i]]['cmb_obj'];
            $input_obj = clone($input_obj_tmp);
            $input_obj->setName($this->id."_input_".$list_attribute[$i]."_ind_".str_replace("-", "_", $ind));
            $register_objects = WebSitePhpObject::getRegisterObjects();
            $register_objects[] = $input_obj;
            $_SESSION['websitephp_register_object'] = $register_objects;

        } else {
            $wspobject = "TextBox";
            $attribute_properties = array();
            if (is_array($this->from_sql_data_view_properties[$list_attribute[$i]])) {
                $attribute_properties = $this->from_sql_data_view_properties[$list_attribute[$i]];
            }
            if (isset($attribute_properties["wspobject"]) && $attribute_properties["wspobject"] != "") {
                $wspobject = $attribute_properties["wspobject"];
            } else {
                if ($list_attribute_type[$i] == "datetime") {
                    $wspobject = "Calendar";
                } else if ($list_attribute_type[$i] == "boolean") {
                    $wspobject = "CheckBox";
                }
            }

            if ($wspobject == "Calendar") {
                $input_obj = new Calendar($this->table_form_object, $this->id."_input_".$list_attribute[$i]."_ind_".str_replace("-", "_", $ind));
            } else if ($wspobject == "CheckBox") {
                $input_obj = new CheckBox($this->table_form_object, $this->id."_input_".$list_attribute[$i]."_ind_".str_replace("-", "_", $ind));
            } else if ($wspobject == "TextArea") {
                $input_obj = new TextArea($this->table_form_object, $object_id);
            } else if ($wspobject == "Editor") {
                $input_obj = new Editor($this->table_form_object, $object_id);
                if (isset($attribute_properties["editor_param"]) && $attribute_properties["editor_param"] != "") {
                    $input_obj->setToolbar($attribute_properties["editor_param"]);
                }
            } else if ($wspobject == "ComboBox") {
                $input_obj = new ComboBox($this->table_form_object, $object_id);
                if (isset($attribute_properties["combobox_values"])) {
                    if (is_array($attribute_properties["combobox_values"])) {
                        for ($j=0; $j < sizeof($attribute_properties["combobox_values"]); $j++) {
                            $input_obj->addItem($attribute_properties["combobox_values"][$j]['value'],
                                $attribute_properties["combobox_values"][$j]['text']);
                        }
                    } else {
                        throw new NewException(get_class($this)."->loadFromSqlDataView() error: the property combobox_values need to be an array.", 0, getDebugBacktrace(1));
                    }
                }
            } else {
                $input_obj = new TextBox($this->table_form_object, $this->id."_input_".$list_attribute[$i]."_ind_".str_replace("-", "_", $ind));
                if ($list_attribute_type[$i] == "integer" || $list_attribute_type[$i] == "double") {
                    $input_obj->setWidth(70);
                }
                if (in_array($list_attribute[$i], $key_attributes)) {
                    $lv = new LiveValidation();
                    $input_obj->setLiveValidation($lv->addValidatePresence());
                }
            }
        }

        // get properties width and strip_tags
        if (is_array($this->from_sql_data_view_properties[$list_attribute[$i]])) {
            $attribute_properties = $this->from_sql_data_view_properties[$list_attribute[$i]];
            if (isset($attribute_properties["width"]) && method_exists($input_obj, "setWidth")) {
                $input_obj->setWidth($attribute_properties["width"]);
            }
            if (isset($attribute_properties["height"]) && method_exists($input_obj, "setHeight")) {
                $input_obj->setHeight($attribute_properties["height"]);
            }
            if (isset($attribute_properties["class"]) && method_exists($input_obj, "setClass")) {
                $input_obj->setClass($attribute_properties["class"]);
            }
            if (isset($attribute_properties["style"]) && method_exists($input_obj, "setStyle")) {
                $input_obj->setStyle($attribute_properties["style"]);
            }
            if (isset($attribute_properties["disable"])) {
                if ($attribute_properties["disable"] == true && method_exists($input_obj, "disable")) {
                    $input_obj->disable();
                } else if ($attribute_properties["disable"] == false && method_exists($input_obj, "enable")) {
                    $input_obj->enable();
                }
            }
            if (get_class($input_obj) != "Calendar") {
                if (isset($attribute_properties["strip_tags"]) && $attribute_properties["strip_tags"] == true &&
                    method_exists($input_obj, "setStripTags")) {
                    if (isset($attribute_properties["allowable_tags"])) {
                        $input_obj->setStripTags($attribute_properties["allowable_tags"]);
                    } else {
                        $input_obj->setStripTags(""); // no tag allowed
                    }
                }
            }
        }
        if ($row != null) {
            // get property db_attribute
            $field_value = $row->getValue($list_attribute[$i]);
            if (isset($this->from_sql_data_view_properties[$list_attribute[$i]]["db_attribute"])) {
                $db_attribute = $this->from_sql_data_view_properties[$list_attribute[$i]]["db_attribute"];
                $field_value = $row->getValue($db_attribute);
            }

            $input_obj->onChange("onChangeTableFromSqlDataView")->setAjaxEvent()->disableAjaxWaitMessage();
            if (get_class($input_obj) == "TextBox") {
                $input_obj->onKeyUpJs("if (\$(this)[0].defaultValue != \$(this).val()) { $('#".$this->id."_img_".$ind."_cancel_".$list_attribute[$i]."').hide(); } else { $('#".$this->id."_img_".$ind."_cancel_".$list_attribute[$i]."').show(); }");
            }
            if ($list_attribute_type[$i] == "boolean") {
                if (!$input_obj->isChanged()) {
                    $input_obj->setValue($field_value==true?"on":"off");
                }
            } else {
                if (gettype($field_value) == "object") {
                    $input_obj->setValue($field_value);
                } else {
                    $input_obj->setValue(utf8encode($field_value));
                }
            }
        }
        return $input_obj;
    }

	/**
	 * Method onChangeTableFromSqlDataView
	 * @access public
	 * @param mixed $sender 
	 * @since 1.1.6
	 */
    public function onChangeTableFromSqlDataView($sender) {
        if ($this->id == "") {
            throw new NewException(get_class($this)."->onChangeTableFromSqlDataView() error: you must define an id to the Table (".get_class($this)."->setId()) or you don't call this method for the good table", 0, getDebugBacktrace(1));
        }

        if ($this->sql_data_view_object == null) {
            throw new NewException(get_class($this)."->onChangeTableFromSqlDataView() error: you need to use the method loadFromSqlDataView before.", 0, getDebugBacktrace(1));
        }

        if (gettype($sender) == "object") {
            if (get_class($sender) == "ComboBox") {
                $sender_id = $sender->getName();
            } else {
                $sender_id = $sender->getId();
            }
        } else {
            $sender_id = $sender;
        }

        $sender_table_id = substr($sender_id, 0, strlen($this->id));
        if ($sender_table_id != $this->id) {
            throw new NewException(get_class($this)."->onChangeTableFromSqlDataView() error: \$sender object is not link to this Table", 0, getDebugBacktrace(1));
        }

        $list_attribute = $this->sql_data_view_object->getListAttributeArray();
        $key_attributes = $this->sql_data_view_object->getPrimaryKeysAttributes();
        $list_attribute_type = $this->sql_data_view_object->getListAttributeTypeArray();

        $sender_id = substr($sender_id, strlen($this->id)+1, strlen($sender_id));
        $sender_id_array = explode('_', $sender_id);
        $sender_type = $sender_id_array[0];

        $input_ind = $sender_id_array[sizeof($sender_id_array)-1];
        for ($i=2; $i <= sizeof($key_attributes); $i++) {
        	$input_ind = $sender_id_array[sizeof($sender_id_array)-$i]."-".$input_ind;
        }
        $attribute_name = str_replace($sender_type."_", "", $sender_id);
        $attribute_name = str_replace("_ind_".str_replace("-", "_", $input_ind), "", $attribute_name);
        if ($sender_type == "btnadd" || $sender_type == "btnreload") {
        	$attribute_name = str_replace("_ind_", "", $attribute_name);
        }
	
        $it = $this->data_row_iterator_object;

        if ($sender_type == "input" && $attribute_name != "" && !in_array($list_attribute[$i], $key_attributes)) {
            if (isset($this->from_sql_data_view_data_row_array[$input_ind])) {
                $row = $this->from_sql_data_view_data_row_array[$input_ind];
                $value = $sender->getValue();

                $search_pos = array_search($attribute_name, $list_attribute);
                if ($search_pos !== false) {
                    settype($value, $list_attribute_type[$search_pos]);
                }
                if ($value == "") {
                    if (get_class($sender) == "CheckBox") {
                        $value = 0;
                    } else {
                        $value = null;
                    }
                }

                try {
                    // get property db_attribute
                    $is_db_attribute = false;
                    if (isset($this->from_sql_data_view_properties[$attribute_name]["db_attribute"])) {
                        $db_attribute = $this->from_sql_data_view_properties[$attribute_name]["db_attribute"];
                        $row->setValue($db_attribute, $value);
                        $is_db_attribute = true;
                    } else {
                        $row->setValue($attribute_name, $value);
                    }
                    DataBase::getInstance()->beginTransaction();
                    $it->save();
                    DataBase::getInstance()->commitTransaction();

                    $object_id = "wsp_object_".$this->id."_".$attribute_name."_input_obj_".$input_ind;
                    $object_text_id = "wsp_object_".$this->id."_".$attribute_name."_obj_".$input_ind;
                    $row_obj = $this->getPage()->getObjectId($object_text_id);
                    $row_obj->emptyObject();
                    if ($is_db_attribute) {
                        $this->from_sql_data_view_reload_pic->onClickJs("$('#".$object_id."').html('<img src=\'".$this->getPage()->getCDNServerURL()."wsp/img/loading.gif\' height=\'16\' width=\'16\'/>');");
                        $row_obj->add($this->from_sql_data_view_reload_pic, " ");
                    } else {
                        $edit_pic = new Picture("wsp/img/edit_16x16.png", 16, 16);
                        $row_obj->add($edit_pic, " ");
                    }
                    if (get_class($sender) == "ComboBox") {
                        $row_obj->add(($value===null?"&nbsp;&nbsp;":$sender->getText()));
                    } else if (get_class($sender) == "Calendar") {
                        $row_obj->add(($value===null?"&nbsp;&nbsp;":$sender->getValueStr()));
                    } else {
                        $row_obj->add(($value===null?"&nbsp;&nbsp;":$value));
                    }
                    $this->getPage()->addObject(new JavaScript("$('#".$object_text_id."').css('display', 'inline');$('#".$object_id."').hide();".($this->from_sql_data_view_add_button!=null?"$('#".$this->from_sql_data_view_add_button->getId()."').button({ disabled: false });":"")), false, true);
                } catch (Exception $e) {
                    $error_msg = $e->getMessage();
                    if (($pos=find($error_msg, ": ")) > 0) {
                        $error_msg = ucfirst(substr($error_msg, $pos, strlen($error_msg)));
                    }
                    $this->getPage()->addObject(new DialogBox(__(ERROR), $error_msg));
                }
            }
        } else if ($sender_type == "btnadd" && $attribute_name == "") {
            $error = false;
            $objects_ok_array = array("TextBox", "ComboBox", "CheckBox", "Calendar", "TextArea", "Editor");
            $auto_increment_id = $this->sql_data_view_object->getDbTableObject()->getDbTableAutoIncrement();

            $reload_pics_array = array();
            $already_add_by_db_attribute = array();
            $ind = $it->getRowsNum();
            $row = $it->insert();
            for ($i=0; $i < sizeof($list_attribute); $i++) {
                $object_id = $this->id."_input_".$list_attribute[$i]."_ind_";
                $input_obj = $this->getPage()->getObjectId($object_id);
                if (!in_array($list_attribute[$i], $already_add_by_db_attribute)) {
                    if ((!in_array($list_attribute[$i], $key_attributes) ||
                            (in_array($list_attribute[$i], $key_attributes) && $list_attribute[$i] != null && $list_attribute[$i] != $auto_increment_id)) &&
                        in_array(get_class($input_obj), $objects_ok_array)) {
                        $value = $input_obj->getValue();

                        $search_pos = array_search($list_attribute[$i], $list_attribute);
                        if ($search_pos !== false && $value != "") {
                            settype($value, $list_attribute_type[$search_pos]);

                            if ("".$value != "".$input_obj->getValue() && get_class($input_obj) != "CheckBox") {
                                $error_dialog = new DialogBox(__(ERROR), "Can't convert ".$input_obj->getValue()." to ".$list_attribute_type[$search_pos]);
                                $this->getPage()->addObject($error_dialog->activateCloseButton());
                                $error = true;
                            }
                        }
                        if ($value == "") {
                            if (get_class($input_obj) == "CheckBox") {
                                $value = 0;
                            } else {
                                $value = null;
                            }
                        }
                        if (!$error) {
                            // get property db_attribute
                            if (isset($this->from_sql_data_view_properties[$list_attribute[$i]]["db_attribute"]) ||
                                in_array($list_attribute[$i], $key_attributes)) {
                                if (in_array($list_attribute[$i], $key_attributes)) {
                                    $db_attribute = $list_attribute[$i];
                                } else {
                                    $db_attribute = $this->from_sql_data_view_properties[$list_attribute[$i]]["db_attribute"];
                                }
                                $row->setValue($db_attribute, $value);
                                $already_add_by_db_attribute[] = $db_attribute;

                                if (!in_array($list_attribute[$i], $key_attributes)) {
                                    $row->enableSqlLoadMode();
                                    $reload_pic = clone($this->from_sql_data_view_reload_pic);
                                    $reload_pic->setTag($list_attribute[$i]);
                                    $reload_pics_array[] = $reload_pic;
                                    $row->setValue($list_attribute[$i], new Object($reload_pic, $value));
                                    $row->disableSqlLoadMode();
                                }
                            } else {
                                $row->setValue($list_attribute[$i], $value);
                            }
                        }
                    } else {
                        // get property db_attribute
                        if (isset($this->from_sql_data_view_properties[$list_attribute[$i]]["db_attribute"])) {
                            $db_attribute = $this->from_sql_data_view_properties[$list_attribute[$i]]["db_attribute"];
                            $row->setValue($db_attribute, null);
                            $already_add_by_db_attribute[] = $db_attribute;

                            $row->enableSqlLoadMode();
                            $row->setValue($list_attribute[$i], null);
                            $row->disableSqlLoadMode();
                        } else {
                            $row->setValue($list_attribute[$i], null);
                        }
                    }
                }
            }
            if (!$error) {
                DataBase::getInstance()->beginTransaction();
                $it->save();
                if ($auto_increment_id != null && $auto_increment_id != "") {
                    $row->setValue($auto_increment_id, DataBase::getInstance()->getLastInsertId());
                }
                DataBase::getInstance()->commitTransaction();

                $key_str = "";
                if (sizeof($key_attributes) == 0) {
                    $key_str = $ind;
                } else {
                    for ($i=0; $i < sizeof($key_attributes); $i++) {
                        if ($i > 0) { $key_str .= "-"; }
                        $key_str .= $row->getValue($key_attributes[$i]);
                    }
                    $key_str = strtolower(url_rewrite_format($key_str));
                }

                for ($i=0; $i < sizeof($reload_pics_array); $i++) {
                    $reload_pics_array[$i]->onClickJs("$('#wsp_object_".$this->id."_".$reload_pics_array[$i]->getTag()."_input_obj_".$key_str."').html('<img src=\'".$this->getPage()->getCDNServerURL()."wsp/img/loading.gif\' height=\'16\' width=\'16\'/>');");
                }

                $this->addRowLoadFromSqlDataView($row, $list_attribute, $list_attribute_type, $key_attributes, $key_str);
            }
        } else if ($sender_type == "btndel" && $attribute_name == "") {
            if (isset($this->from_sql_data_view_data_row_array[$input_ind])) {
                $rowToDelete = $this->from_sql_data_view_data_row_array[$input_ind];
                $this->deleteRow($this->id."_row_".str_replace("-", "_", $input_ind));

                try {
                    $rowToDelete->delete();
                    DataBase::getInstance()->beginTransaction();
                    $it->save();
                    DataBase::getInstance()->commitTransaction();
                } catch (Exception $e) {
                    $error_msg = $e->getMessage();
                    if (($pos=find($error_msg, ": ")) > 0) {
                        $error_msg = ucfirst(substr($error_msg, $pos, strlen($error_msg)));
                    }
                    $error_msg = explode(" - Query:", $error_msg);
                    $error_msg = $error_msg[0];
                    $error_msg = explode("(", $error_msg);
                    $error_msg = $error_msg[0];
                    $this->getPage()->addObject(new DialogBox(__(ERROR), $error_msg));
                }
            }
        } else if ($sender_type == "btnreload" && $attribute_name == "") {
            /*if (isset($this->from_sql_data_view_data_row_array[$input_ind])) {
                $row = $this->from_sql_data_view_data_row_array[$input_ind];
                $this->deleteRow($this->id."_row_".$input_ind);
                $this->addRowLoadFromSqlDataView($row, $list_attribute, $list_attribute_type, $key_attributes, $input_ind);
            }*/
            $this->setAjaxRefreshAllTable();
        } else {
            throw new NewException(get_class($this)."->onChangeTableFromSqlDataView() error: \$sender type (".$sender_type.") is not valid", 0, getDebugBacktrace(1));
        }
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
	 * Method getWidth
	 * @access public
	 * @return mixed
	 * @since 1.2.13
	 */
    public function getWidth() {
        return $this->width;
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

        if ($sort_col_number != "" && !is_integer($sort_col_number)) {
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
            throw new NewException(get_class($this)."->activateSearch() error: you must define an id to the Table (".get_class($this)."->setId())", 0, getDebugBacktrace(1));
        }

        $this->is_search_enable = true;
        $this->activateAdvanceTable();

        return $this;
    }

	/**
	 * Method activateFixeHeader
	 * @access public
	 * @return Table
	 * @since 1.1.7
	 */
    public function activateFixeHeader() {
        if ($this->id == "") {
            throw new NewException(get_class($this)."->activateFixeHeader() error: you must define an id to the Table (".get_class($this)."->setId())", 0, getDebugBacktrace(1));
        }

        $this->is_fixe_header = true;
        $this->activateAdvanceTable();
        $this->addJavaScript(BASE_URL."wsp/js/jquery.dataTables.fixedHeader.js", "", true);

        return $this;
    }

	/**
	 * Method activateColumnsFilter
	 * @access public
	 * @param string $column_filter_params 
	 * @param string $position [default value: top]
	 * @return Table
	 * @since 1.1.7
	 */
    public function activateColumnsFilter($column_filter_params='', $position='top', $column_filter_range_format='From {from} to {to}') {
        if ($this->id == "") {
            throw new NewException(get_class($this)."->activateColumnsFilter() error: you must define an id to the Table (".get_class($this)."->setId())", 0, getDebugBacktrace(1));
        }

        $this->is_column_filter = true;
        $this->column_filter_params = $column_filter_params;
        $this->column_filter_position = $position;
        if ($column_filter_range_format != "From {from} to {to}") {
            $this->column_filter_range_format = $column_filter_range_format;
        }

        $this->activateAdvanceTable();
        $this->addJavaScript(BASE_URL."wsp/js/jquery.dataTables.columnFilter.js", "", true);

        return $this;
    }

	/**
	 * Method activateVerticalScroll
	 * @access public
	 * @param double $height [default value: 200]
	 * @return Table
	 * @since 1.1.7
	 */
    public function activateVerticalScroll($height=200) {
        if ($this->id == "") {
            throw new NewException(get_class($this)."->activateVerticalScroll() error: you must define an id to the Table (".get_class($this)."->setId())", 0, getDebugBacktrace(1));
        }

        $this->vertical_scroll = true;
        $this->vertical_scroll_size = $height;
        $this->activateAdvanceTable();

        return $this;
    }

	/**
	 * Method activateHorizontalScroll
	 * @access public
	 * @param string $scrollX_inner [default value: 110%]
	 * @return Table
	 * @since 1.1.7
	 */
    public function activateHorizontalScroll($scrollX_inner='110%') {
        if ($this->id == "") {
            throw new NewException(get_class($this)."->activateHorizontalScroll() error: you must define an id to the Table (".get_class($this)."->setId())", 0, getDebugBacktrace(1));
        }

        $this->horizontal_scroll = true;
        $this->scrollX_inner = $scrollX_inner;
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
	 * Method isEmpty
	 * @access public
	 * @return mixed
	 * @since 1.2.3
	 */
    public function isEmpty() {
        return (sizeof($this->rows) == 0 || ($this->rows[0]->isHeader() && sizeof($this->rows) == 1));
    }

	/**
	 * Method render
	 * @access public
	 * @param boolean $ajax_render [default value: false]
	 * @return string html code of object Table
	 * @since 1.0.36
	 */
    public function render($ajax_render=false) {
        // Table need to be included in Form when loadFromSqlDataView
        if ($this->is_table_form_object && !$this->ajax_refresh_all_table) {
            $this->is_table_form_object = false;
            return $this->table_form_object->render($ajax_render);
        } else {
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
            if ($this->class != "" || $this->table_class != "" || $this->is_advance_table) {
                $html .= " class=\"";
                if (is_numeric($this->class) || (is_numeric(substr($this->class, 0, 1)) && find($this->class, "_round") > 0)) {
                    $html .= "table_".$this->class;
                } else {
                    $html .= ($this->table_class != ""?$this->table_class:$this->class);
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
            if ($this->is_advance_table && $this->is_column_filter &&
                $this->column_filter_position == Table::COL_FILTER_POSITION_BOTTOM && sizeof($this->rows) > 0) {
                $html .= "<tfoot><tr>";
                $row = $this->rows[0]->getRowColumnsArray();
                for ($i=0; $i < sizeof($row); $i++) {
                    if (gettype($row[$i]['content_object']) == "object" && method_exists($row[$i]['content_object'], "render")) {
                        if ($row[$i]['content_object'] != null) {
                            $html_content = $row[$i]['content_object']->render();
                        } else {
                            $html_content = "&nbsp;";
                        }
                    } else {
                        if ($row[$i]['content_object'] != "") {
                            $html_content = $row[$i]['content_object'];
                        } else {
                            $html_content = "&nbsp;";
                        }
                    }
                    $html .= "<th>".$html_content."</th>";
                }
                $html .= "</tr></tfoot>";
            }
            $html .= "</table>\n";
            if (!$ajax_render && $this->is_advance_table && $this->width != "") {
                $html .= "</div>";
            }

            $html .= $this->renderAdvanceTable();

            $this->object_change = false;
            return $html;
        }
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
                throw new NewException("To use advance table propoerties (search, filter, sort, pagination) you must define an id (".get_class($this)."->setId())", 0, getDebugBacktrace(1));
            }

            if (sizeof($this->rows) == 0 || !$this->rows[0]->isHeader()) {
                throw new NewException("To use advance table you must define the first RowTable with Header type (RowTable->setHeaderClass(0))", 0, getDebugBacktrace(1));
            }

            $html .= $this->getJavascriptTagOpen();
            $html .= "if (typeof oTable".str_replace("-", "_", $this->getId())." !== 'undefined') { oTable".str_replace("-", "_", $this->getId()).".fnDestroy(); }";
            $html .= "oTable".str_replace("-", "_", $this->getId())." = $(\"#".$this->getId()."\").dataTable({'bJQueryUI': true";
            if ($this->is_sortable) {
            	if (sizeof($this->rows) > 1 && $this->rows[1]->getId()!=="") {
            		// Id on a row generate a tbody tag and it's not compatible with sorting
            		throw new NewException(get_class($this)."->activateSort() error: It's not possible to use columns sort with an Id on the rows.", 0, getDebugBacktrace(1));
            	}
            	$html .= ", 'bSort': true";
            	if (is_integer($this->sort_col_number)) {
	                $html .= ", 'aaSorting': [[".($this->sort_col_number-1).", '".$this->sort_order."']]";
		}
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
            if (!$this->is_column_filter) {
                if ($this->is_search_enable) {
                    $html .= ", 'bFilter': true";
                } else {
                    $html .= ", 'bFilter': false";
                }
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
            if (!$this->is_fixe_header) {
                if ($this->vertical_scroll || $this->horizontal_scroll) {
                    $html .= ", 'bScrollCollapse': true";
                    if ($this->vertical_scroll) {
                        $html .= ", 'sScrollY': '".$this->vertical_scroll_size."px'";
                    }
                    if ($this->horizontal_scroll) {
                        $html .= ", 'sScrollX': '100%'";
                        $html .= ", 'sScrollXInner': '".$this->scrollX_inner."'";
                    }
                    if ($this->width == "") {
                   	$html .= ", 'bAutoWidth': false";
                    }
                }
            }
            $html .= " });\n";
            if ($this->is_column_filter) {
            	if (sizeof($this->rows) > 1 && $this->rows[1]->getId()!=="") {
            		// Id on a row generate a tbody tag and it's not compatible with filtering
            		throw new NewException(get_class($this)."->activateColumnsFilter() error: It's not possible to use columns filter with an Id on the rows.", 0, getDebugBacktrace(1));
            	}
                $is_column_filter_param = false;
                $html .= "$(\"#".$this->getId()."\").dataTable().columnFilter({ ";
                if ($this->column_filter_position == Table::COL_FILTER_POSITION_TOP) {
                    $html .= "sPlaceHolder: 'head:after'";
                    $is_column_filter_param = true;
                }
                if ($this->column_filter_params != "") {
                    if ($is_column_filter_param) { $html .= ", "; }
                    $html .= "aoColumns: [".$this->column_filter_params."]";
                    $is_column_filter_param = true;
                }
                if ($this->column_filter_range_format != "") {
                    if ($is_column_filter_param) { $html .= ", "; }
                    $html .= "sRangeFormat: \"".$this->column_filter_range_format."\"";
                    $is_column_filter_param = true;
                }
                $html .= " });\n";
            }
            if ($this->is_fixe_header) {
                $html .= "$(window).load(function(){ new FixedHeader( oTable".str_replace("-", "_", $this->getId())." ); });\n";
            }
            if ($this->advance_table_title != "") {
                $html .= "$('#".$this->getId()."_wrapper').find('div.toolbar').html('";
                if (gettype($this->advance_table_title) == "object" && method_exists($this->advance_table_title, "render")) {
                    $html .= addslashes($this->advance_table_title->render());
                } else {
                    $html .= addslashes($this->advance_table_title);
                }
                $html .= "').attr('align', 'left');\n";
                if ($this->is_search_enable) {
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
                    if ($this->is_advance_table && $this->vertical_scroll) {
                    	$html .= "var my_parent_node = $('#".$this->id."').parent().parent().parent();";
                    } else {
                    	$html .= "var my_parent_node = $('#".$this->id."').parent();";
                    }
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
