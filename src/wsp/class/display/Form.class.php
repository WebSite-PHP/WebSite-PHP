<?php
/**
 * PHP file wsp\class\display\Form.class.php
 * @package display
 */
/**
 * Class Form
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

class Form extends WebSitePhpObject {
	/**#@+
	 * method properties
	 * @access public
	 * @var string
	 */
	const METHOD_POST = "POST";
	const METHOD_GET = "GET";
	/**#@-*/

	/**#@+
	 * @access private
	 */
	protected $page_object = null;
	private $name = "";
	private $id = "";
	private $method = "POST";
	private $action = "";
	private $real_action = "";
	private $content = null;
	private $onsubmitjs = "";
	private $onchangejs = "";

	private $encrypt_object = null;
	private $register_object = array();
	private $submit_dialog_box = null;
	private $dialog_box_display_delay = 200;

	private $sql_data_view_object = null;
	private $data_row_iterator_object = null;
	private $data_row_object = null;
	private $from_sql_data_view_insert = false;
	private $from_sql_data_view_update = false;
	private $from_sql_data_view_delete = false;
	private $from_sql_data_view_properties = array();
	private $table_from_sql_data_view = null;

	private $enctype_multipart = false;
	/**#@-*/

	/**
	 * Constructor Form
	 * @param mixed $page_object 
	 * @param string $name 
	 * @param string $id 
	 * @param string $method [default value: POST]
	 */
	function __construct($page_object, $name='', $id='', $method="POST") {
		parent::__construct();

		if (!isset($page_object) || gettype($page_object) != "object" || !is_subclass_of($page_object, "Page")) {
			throw new NewException("Argument page_object for ".get_class($this)."::__construct() error", 0, getDebugBacktrace(1));
		}

		if ($name == "") {
			$name = $page_object->createObjectName($this);
		} else {
			$exist_object = $page_object->existsObjectName($name);
			if ($exist_object != false) {
				throw new NewException("Tag name \"".$name."\" for object ".get_class($this)." already use for other object ".get_class($exist_object), 0, getDebugBacktrace(1));
			}
			$page_object->addEventObject($this);
		}

		$this->page_object = $page_object;
		$this->name = $name;
		if ($id == "") {
			$this->id = $name;
		} else {
			$this->id = $id;
		}
		$this->method = $method;
		JavaScriptInclude::getInstance()->add("form.js", "", true);

		if ($this->page_object->isAjaxLoadPage()) {
			$this->onSubmitJs("return false;");
		}
	}

	/**
	 * Method setName
	 * @access public
	 * @param mixed $name 
	 * @return Form
	 * @since 1.0.35
	 */
	public function setName($name) {
		$this->name = $name;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}

	/**
	 * Method setMethod
	 * @access public
	 * @param mixed $method 
	 * @return Form
	 * @since 1.0.35
	 */
	public function setMethod($method) {
		$this->method = $method;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}

	/**
	 * Method setContent
	 * @access public
	 * @param object $content 
	 * @return Form
	 * @since 1.0.35
	 */
	public function setContent($content) {
		$this->content = $content;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}

	/**
	 * Method setAction
	 * @access public
	 * @param mixed $action_file_name 
	 * @return Form
	 * @since 1.0.35
	 */
	public function setAction($action_file_name) {
		if (gettype($action_file_name) == "object" && get_class($action_file_name) != "Url") {
			throw new NewException(get_class($this)."->setAction() error: \$action_file_name must be a string or a Url object", 0, getDebugBacktrace(1));
		}
		if (gettype($action_file_name) == "object" && get_class($action_file_name) == "Url") {
			$action_file_name = $action_file_name->render();
		}

		//$this->action = str_replace(".php", ".html", str_replace(".call", ".html", str_replace(".do", ".html", str_replace(".xhtml", ".html", $action_file_name))));
		$this->action = $action_file_name;
		$this->action = str_replace($this->page_object->getBaseLanguageURL(), "", $this->action);
		$this->action = str_replace($this->page_object->getBaseURL(), "", $this->action);

		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}

	/**
	 * Method setRealAction
	 * @access public
	 * @param mixed $action_file_name 
	 * @return Form
	 * @since 1.2.14
	 */
	public function setRealAction($action_file_name) {
		if (gettype($action_file_name) == "object" && get_class($action_file_name) != "Url") {
			throw new NewException(get_class($this)."->setAction() error: \$action_file_name must be a string or a Url object", 0, getDebugBacktrace(1));
		}
		if (gettype($action_file_name) == "object" && get_class($action_file_name) == "Url") {
			$action_file_name = $action_file_name->render();
		}

		$this->real_action = $action_file_name;

		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}

	/**
	 * Method setEncryptObject
	 * @access public
	 * @param mixed $encrypt_object [default value: null]
	 * @return Form
	 * @since 1.0.67
	 */
	public function setEncryptObject($encrypt_object=null) {
		if ($encrypt_object == null) {
			$encrypt_object = new EncryptDataWspObject();
		}
		if (gettype($encrypt_object) != "object" || get_class($encrypt_object) != "EncryptDataWspObject") {
			throw new NewException(get_class($this)."->setEncryption(): \$encrypt_object must be a EncryptDataWspObject object.", 0, getDebugBacktrace(1));
		}

		$this->addJavaScript(BASE_URL."wsp/js/jsbn.js", "", true);
		$this->addJavaScript(BASE_URL."wsp/js/lowpro.jquery.js", "", true);
		$this->addJavaScript(BASE_URL."wsp/js/rsa.js", "", true);

		$this->encrypt_object = $encrypt_object;
		$this->encrypt_object->setObject($this);

		return $this;
	}

	/**
	 * Method disableEncryptObject
	 * @access public
	 * @return Form
	 * @since 1.1.11
	 */
	public function disableEncryptObject() {
		$this->encrypt_object = null;
		return $this;
	}

	/**
	 * Method setSubmitDialogBox
	 * @access public
	 * @param mixed $dialog_box 
	 * @param double $display_delay [default value: 200]
	 * @return Form
	 * @since 1.0.99
	 */
	public function setSubmitDialogBox($dialog_box, $display_delay=200) {
		if (gettype($dialog_box) != "object" || (get_class($dialog_box) != "DialogBox" && !is_subclass_of($dialog_box, "DialogBox"))) {
			throw new NewException(get_class($this)."->setSubmitDialogBox(): \$dialog_box must be a DialogBox object.", 0, getDebugBacktrace(1));
		}

		$this->submit_dialog_box = $dialog_box;
		$this->dialog_box_display_delay = $display_delay;
		return $this;
	}

	/**
	 * Method setEnctypeMultipart
	 * @access public
	 * @return Form
	 * @since 1.2.3
	 */
	public function setEnctypeMultipart() {
		$this->enctype_multipart = true;
		return $this;
	}

	/**
	 * Method getEncryptObject
	 * @access public
	 * @return mixed
	 * @since 1.0.67
	 */
	public function getEncryptObject() {
		return $this->encrypt_object;
	}

	/**
	 * Method isEncrypted
	 * @access public
	 * @return mixed
	 * @since 1.0.67
	 */
	public function isEncrypted() {
		return ($this->encrypt_object==null?false:true);
	}

	/**
	 * Method getName
	 * @access public
	 * @return mixed
	 * @since 1.0.35
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Method getMethod
	 * @access public
	 * @return mixed
	 * @since 1.0.35
	 */
	public function getMethod() {
		return $this->method;
	}

	/**
	 * Method getPageObject
	 * @access public
	 * @return mixed
	 * @since 1.0.35
	 */
	public function getPageObject() {
		return $this->page_object;
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
	 * Method registerObjectToForm
	 * @access public
	 * @param mixed $object 
	 * @return Form
	 * @since 1.0.35
	 */
	public function registerObjectToForm($object) {
		if ($object->isEventObject()) {
			$this->register_object[] = $object;
		}
		return $this;
	}

	/**
	 * Method getFormObjects
	 * @access public
	 * @return mixed
	 * @since 1.0.35
	 */
	public function getFormObjects() {
		return $this->register_object;
	}

	/**
	 * Method getAction
	 * @access public
	 * @return mixed
	 * @since 1.0.35
	 */
	public function getAction() {
		return $this->action;
	}

	/**
	 * Method getRealAction
	 * @access public
	 * @return mixed
	 * @since 1.2.14
	 */
	public function getRealAction() {
		if ($this->real_action == "") {
			return $this->getAction();
		}
		return $this->real_action;
	}

	/**
	 * Method onSubmitJs
	 * @access public
	 * @param string|JavaScript $js_function 
	 * @return Form
	 * @since 1.0.35
	 */
	public function onSubmitJs($js_function){
		if (gettype($js_function) != "string" && get_class($js_function) != "JavaScript" && !is_subclass_of($js_function, "JavaScript")) {
			throw new NewException(get_class($this)."->onSubmitJs(): \$js_function must be a string or JavaScript object.", 0, getDebugBacktrace(1));
		}
		if (get_class($js_function) == "JavaScript" || is_subclass_of($js_function, "JavaScript")) {
			$js_function = $js_function->render();
		}
		$this->onsubmitjs = $js_function;
		return $this;
	}

	/**
	 * Method getOnSubmitJs
	 * @access public
	 * @return mixed
	 * @since 1.2.3
	 */
	public function getOnSubmitJs() {
		return $this->onsubmitjs;
	}

	/**
	 * Method onChangeJs
	 * @access public
	 * @param mixed $js_function 
	 * @return Form
	 * @since 1.0.90
	 */
	public function onChangeJs($js_function){
		if (gettype($js_function) != "string" && get_class($js_function) != "JavaScript" && !is_subclass_of($js_function, "JavaScript")) {
			throw new NewException(get_class($this)."->onChangeJs(): \$js_function must be a string or JavaScript object.", 0, getDebugBacktrace(1));
		}
		if (get_class($js_function) == "JavaScript" || is_subclass_of($js_function, "JavaScript")) {
			$js_function = $js_function->render();
		}
		if (trim($this->onchangejs) == "" && $js_function != "") {
			$this->onchangejs = $js_function;
		}
		return $this;
	}

	/**
	 * Method resetFormChangeHiddenField
	 * @access public
	 * @return Form
	 * @since 1.0.90
	 */
	public function resetFormChangeHiddenField() {
		$_GET[$this->id."_WspFormChange"] = "";
		return $this;
	}

	/**
	 * Method loadFromSqlDataView
	 * @access public
	 * @param mixed $sql 
	 * @param mixed $properties [default value: array(]
	 * @return mixed
	 * @since 1.2.0
	 */
	public function loadFromSqlDataView($sql, $properties=array(), $hide_empty_fields=false) {
		if (gettype($sql) != "object" || get_class($sql) != "SqlDataView") {
			throw new NewException(get_class($this)."->loadFromSqlDataView() error: \$sql is not SqlDataView object", 0, getDebugBacktrace(1));
		}

		if ($insert || $update || $delete) {
			if ($sql->isQueryWithJoin()) {
				throw new NewException(get_class($this)."->loadFromSqlDataView() error: you need use SqlDataView object without JOIN if you want to use insert update or delete.", 0, getDebugBacktrace(1));
			}
		}

		if (!is_array($properties)) {
			throw new NewException(get_class($this)."->loadFromSqlDataView() error: \$properties need to be an array", 0, getDebugBacktrace(1));
		}

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
					$cmb = new ComboBox($this);

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

		$it = $sql->retrieve();
		if ($it->getRowsNum() > 1) {
			throw new NewException(get_class($this)."->loadFromSqlDataView() error: the query return more than 1 result. Form object can only modify 1 ".get_class($sql->getDbTableObject()).".", 0, getDebugBacktrace(1));
		}
		$this->table_from_sql_data_view = new Table();
		$this->table_from_sql_data_view->setDefaultAlign(RowTable::ALIGN_LEFT);
		$this->table_from_sql_data_view->setDefaultValign(RowTable::VALIGN_CENTER);

		// Generate form data
		$this->sql_data_view_object = $sql;
		$this->data_row_iterator_object = $it;
		if ($it->hasNext()) {
			$row = $it->next();
			$this->data_row_object = $row;
		} else {
			$temp_it = clone($it);
			$row = $temp_it->insert();
			for ($i=0; $i < sizeof($list_attribute); $i++) {
				$row->setValue($list_attribute[$i], "");
			}
		}

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

			$row_table = new RowTable();
			if (isset($attribute_properties["title"])) {
				$row_table->add($attribute_properties["title"].": ");
			} else {
				$row_table->add($list_attribute[$i].": ");
			}
			$row_table->add("&nbsp;");

			if ($list_attribute[$i] != $auto_increment_id && $is_update_ok) {
				$row_value = $row->getValue($list_attribute[$i]);
				if (gettype($row_value) == "object" && method_exists($row_value, "render")) {
					$row_value = $row_value->render();
				}

				$input_obj = $this->createDbAttributeObject($row, $list_attribute, $list_attribute_type, $i, $key_attributes);
				$row_table->add($input_obj);

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
			if ($hide_empty_fields && $value == '') {
				// Do not add the empty field
			} else {
				$this->table_from_sql_data_view->addRow($row_table);
			}
			if (isset($attribute_properties["row_id"]) && $attribute_properties["row_id"] != "") {
				$row_table->setId($attribute_properties["row_id"]);
			} else {
				$row_table->setId($i);
			}
		}
		return $it;
	}

	/**
	 * Method createDbAttributeObject
	 * @access private
	 * @param mixed $row 
	 * @param mixed $list_attribute 
	 * @param mixed $list_attribute_type 
	 * @param mixed $i 
	 * @param mixed $key_attributes 
	 * @return mixed
	 * @since 1.2.0
	 */
	private function createDbAttributeObject($row, $list_attribute, $list_attribute_type, $i, $key_attributes) {
		$object_id = $this->id."_input_".$list_attribute[$i]."_ind_";

		// get property cmb_obj (created by method loadFromSqlDataView)
		if (isset($this->from_sql_data_view_properties[$list_attribute[$i]]['cmb_obj'])) {
			$input_obj_tmp = $this->from_sql_data_view_properties[$list_attribute[$i]]['cmb_obj'];
			$input_obj = clone($input_obj_tmp);
			$input_obj->setName($object_id);
			$register_objects = WebSitePhpObject::getRegisterObjects();
			$register_objects[] = $input_obj;
			$_SESSION['websitephp_register_object'] = $register_objects;
		} else {
			// Get last register object when refresh the Form after an event (to update the data)
			if ($this->from_sql_data_view_refresh) {
				$input_obj = $this->getPage()->getObjectId($object_id);
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
					$input_obj = new Calendar($this, $object_id);
				} else if ($wspobject == "CheckBox") {
					$input_obj = new CheckBox($this, $object_id);
				} else if ($wspobject == "TextArea") {
					$input_obj = new TextArea($this, $object_id);
				} else if ($wspobject == "Editor") {
					$input_obj = new Editor($this, $object_id);
					if (isset($attribute_properties["editor_param"]) && $attribute_properties["editor_param"] != "") {
						$input_obj->setToolbar($attribute_properties["editor_param"]);
					}
				} else if ($wspobject == "ComboBox") {
					$input_obj = new ComboBox($this, $object_id);
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
					$input_obj = new TextBox($this, $object_id);
					if ($list_attribute_type[$i] == "integer" || $list_attribute_type[$i] == "double") {
						$input_obj->setWidth(70);
					}
					if (in_array($list_attribute[$i], $key_attributes)) {
						$lv = new LiveValidation();
						$input_obj->setLiveValidation($lv->addValidatePresence());
					}
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
	 * Method saveFormFromSqlDataView
	 * @access private
	 * @param mixed $insert 
	 * @param mixed $update 
	 * @return boolean
	 * @since 1.2.0
	 */
	private function saveFormFromSqlDataView($insert, $update) {
		if ($this->sql_data_view_object == null) {
			throw new NewException(get_class($this)."->saveFormFromSqlDataView() error: you need to use the method loadFromSqlDataView before.", 0, getDebugBacktrace(1));
		}

		$list_attribute = $this->sql_data_view_object->getListAttributeArray();
		$key_attributes = $this->sql_data_view_object->getPrimaryKeysAttributes();
		$list_attribute_type = $this->sql_data_view_object->getListAttributeTypeArray();
		$it = $this->data_row_iterator_object;

		$error = false;
		$objects_ok_array = array("TextBox", "ComboBox", "CheckBox", "Calendar", "TextArea", "Editor");
		$auto_increment_id = $this->sql_data_view_object->getDbTableObject()->getDbTableAutoIncrement();

		$already_add_by_db_attribute = array();
		if ($insert) {
			$row = $it->insert();
		} else if ($update) {
			if ($this->data_row_object == null) {
				return false;
			}
			$row = $this->data_row_object;
		}
		for ($i=0; $i < sizeof($list_attribute); $i++) {
			if ($update && $auto_increment_id != null && $auto_increment_id == $list_attribute[$i]) {
				continue;
			}

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
								$row->setValue($list_attribute[$i], $value);
								$row->disableSqlLoadMode();
							}
						} else {
							$row->setValue($list_attribute[$i], $value);
						}
					}
				} else if ($insert) {
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
			if ($insert && $auto_increment_id != null && $auto_increment_id != "") {
				$row->setValue($auto_increment_id, DataBase::getInstance()->getLastInsertId());
			}
			DataBase::getInstance()->commitTransaction();

			// Refresh form
			$this->from_sql_data_view_refresh = true;
			$this->loadFromSqlDataView($this->sql_data_view_object, $this->from_sql_data_view_properties);
			$this->from_sql_data_view_refresh = false;

			return true;
		} else {
			return false;
		}
	}

	/**
	 * Method insertFormFromSqlDataView
	 * @access public
	 * @return mixed
	 * @since 1.2.0
	 */
	public function insertFormFromSqlDataView() {
		if ($this->sql_data_view_object == null) {
			throw new NewException(get_class($this)."->insertFormFromSqlDataView() error: you need to use the method loadFromSqlDataView before.", 0, getDebugBacktrace(1));
		}

		return $this->saveFormFromSqlDataView(true, false);
	}

	/**
	 * Method updateFormFromSqlDataView
	 * @access public
	 * @return mixed
	 * @since 1.2.0
	 */
	public function updateFormFromSqlDataView() {
		if ($this->sql_data_view_object == null) {
			throw new NewException(get_class($this)."->updateFormFromSqlDataView() error: you need to use the method loadFromSqlDataView before.", 0, getDebugBacktrace(1));
		}

		return $this->saveFormFromSqlDataView(false, true);
	}

	/**
	 * Method deleteFormFromSqlDataView
	 * @access public
	 * @return boolean
	 * @since 1.2.0
	 */
	public function deleteFormFromSqlDataView() {
		if ($this->sql_data_view_object == null) {
			throw new NewException(get_class($this)."->insertFormFromSqlDataView() error: you need to use the method loadFromSqlDataView before.", 0, getDebugBacktrace(1));
		}

		DataBase::getInstance()->beginTransaction();
		$is_deleted = false;
		$it = $this->data_row_iterator_object;
		$it->initIterator();
		if ($it->hasNext()) {
			$row = $it->next();
			$row->delete();
			$is_deleted = true;
		}
		$it->save();
		DataBase::getInstance()->commitTransaction();

		// Refresh form
		if ($is_deleted) {
			$this->from_sql_data_view_refresh = true;
			$this->loadFromSqlDataView($this->sql_data_view_object, $this->from_sql_data_view_properties);
			$this->from_sql_data_view_refresh = false;
			return true;
		}
		return false;
	}

	/**
	 * Method getDataRowIterator
	 * @access public
	 * @return mixed
	 * @since 1.2.0
	 */
	public function getDataRowIterator() {
		return $this->data_row_iterator_object;
	}

	/**
	 * Method render
	 * @access public
	 * @param boolean $ajax_render [default value: false]
	 * @return string html code of object Form
	 * @since 1.0.35
	 */
	public function render($ajax_render=false) {
		$html = "";

		// Generate HTML
		if ($this->page_object != null) {
			if ($this->submit_dialog_box != null) {
				$html .= $this->getJavascriptTagOpen();
				$html .= "	isSubmitDialogBox".$this->submit_dialog_box->getDialogBoxLevel()."Display = false;\n";
				$html .= "	dialogBox".$this->submit_dialog_box->getDialogBoxLevel()."AlreadyDisplay = false;\n";
				$html .= "	submitForm".$this->getId()."AfterDialogBox".$this->submit_dialog_box->getDialogBoxLevel()." = function(delay) {\n";
				$html .= "		if (isSubmitDialogBox".$this->submit_dialog_box->getDialogBoxLevel()."Display == false) {\n";
				$html .= "			if (dialogBox".$this->submit_dialog_box->getDialogBoxLevel()."AlreadyDisplay == false) {\n";
				$html .= "				dialogBox".$this->submit_dialog_box->getDialogBoxLevel()."AlreadyDisplay = true;\n";
				$html .= "				".$this->submit_dialog_box->render()."\n";
				$html .= "				setTimeout(submitForm".$this->getId().", delay);\n";
				$html .= "			}";
				$html .= "			return false;\n";
				$html .= "		} else {\n";
				$html .= "			return true;\n";
				$html .= "		}";
				$html .= "	};\n";
				$html .= "	submitForm".$this->getId()." = function() {\n";
				$html .= "		isSubmitDialogBox".$this->submit_dialog_box->getDialogBoxLevel()."Display=true;\n";
				$html .= "		$('#".$this->getId()."').submit();\n";
				$html .= "	};\n";
				$html .= $this->getJavascriptTagClose();
			}

			$html .= "<form name=\"".get_class($this->page_object)."_".$this->name."\" ";
			if ($this->id != "") {
				$html .= "id=\"".$this->id."\" ";
			}
			$html .= "action=\"";
			if ($this->action == "") {
				$html .= str_replace("ajax/", "", $this->page_object->getCurrentURL());
			} else {
				if ((!defined('NO_ADD_AUTO_LINK_BASE_URL') || NO_ADD_AUTO_LINK_BASE_URL !== true) &&
					strtoupper(substr($this->action, 0, 7)) != "HTTP://" && strtoupper(substr($this->action, 0, 8)) != "HTTPS://") {
					$html .= $this->page_object->getBaseLanguageURL().$this->action;
				} else {
					$html .= $this->action;
				}
			}
			$html .= "\" ";
			$html .= "method=\"".$this->method."\" ";
			if ($this->onsubmitjs != "" || $this->submit_dialog_box != null) {
				$html .= "onSubmit=\"";
				if ($this->onsubmitjs != "") {
					$html .= $this->onsubmitjs;
				}
				if ($this->submit_dialog_box != null) {
					$html .= "submitForm".$this->getId()."AfterDialogBox".$this->submit_dialog_box->getDialogBoxLevel()."(".$this->dialog_box_display_delay.");";
				}
				$html .= "\" ";
			}
			if ($this->enctype_multipart) {
				$html .= " enctype=\"multipart/form-data\"";
			}
			$html .= ">\n";
			if ($this->table_from_sql_data_view != null) {
				$html .= $this->table_from_sql_data_view->render();
			}
			if ($this->content != null) {
				if (gettype($this->content) == "object" && method_exists($this->content, "render")) {
					$html .= $this->content->render();
				} else {
					$html .= $this->content;
				}
			}

			/*$hidden_form_change_value = "";
			if ($this->getMethod() == "POST" && isset($_POST[$this->id."_WspFormChange"])) {
				$hidden_form_change_value = $_POST[$this->id."_WspFormChange"];
			} else if (isset($_GET[$this->id."_WspFormChange"])) {
				$hidden_form_change_value = $_GET[$this->id."_WspFormChange"];
			}*/
			//$html .= "<input type=\"hidden\" id=\"".$this->id."_WspFormChange\" name=\"".$this->id."_WspFormChange\" value=\"".$hidden_form_change_value."\"/>\n";
			$html .= "<input type=\"hidden\" id=\"".$this->id."_WspFormChange\" value=\"\"/>\n";
			$html .= "<input type=\"hidden\" id=\"".$this->id."_LastChangeObjectValue\" value=\"\"/>\n";
			$html .= "</form>\n";
			if ($this->onchangejs != "") {
				$html .= $this->getJavascriptTagOpen();
				$html .= "createOnChangeFormEvent('".$this->id."');\n";
				if (trim($this->onchangejs) != "") {
					$html .= $this->onchangejs."\n";
				}
				$html .= $this->getJavascriptTagClose();
			}
		}
		$this->object_change = false;
		return $html;
	}
}
?>
