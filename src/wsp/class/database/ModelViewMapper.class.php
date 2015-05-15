<?php
/**
 * PHP file wsp\class\database\ModelViewMapper.class.php
 * @package database
 */
/**
 * Class ModelViewMapper
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2015 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package database
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 12/05/2015
 * @version     1.2.13
 * @access      public
 * @since       1.2.1
 */

class ModelViewMapper {
	
	/**#@+
	* Properties to apply to all fields
	* Example: $properties = array(ModelViewMapper::PROPERTIES_ALL => 
	* 							array("update" => false), ...);
	* @access public
	* @var string
	*/
	const PROPERTIES_ALL = "properties_apply_to_all";
	/**#@-*/
	
	/**#@+
	* @access private
	*/
	private $page_object = null;
	private $form_or_page = null;
	private $database_model_object = null;
	private $database_object = null;
	private $fields_array = array();
	private $objects_ok_array = array("TextBox", "ComboBox", "CheckBox", "Calendar", "TextArea", "Editor");
	/**#@-*/

	/**
	 * Constructor ModelViewMapper
	 * @param mixed $page_or_form_object 
	 * @param mixed $database_model_object 
	 * @param mixed $database_object 
	 */
	function __construct($page_or_form_object, $database_model_object, $database_object) {
		if (!isset($page_or_form_object) || gettype($page_or_form_object) != "object" || (!is_subclass_of($page_or_form_object, "Page") && get_class($page_or_form_object) != "Form")) {
			throw new NewException("Argument page_or_form_object for ".get_class($this)."::__construct() error", 0, getDebugBacktrace(1));
		}
		if (!isset($database_model_object) || gettype($database_model_object) != "object") {
			throw new NewException("Argument database_model_object for ".get_class($this)."::__construct() error", 0, getDebugBacktrace(1));
		}
		if (!isset($database_object) || gettype($database_object) != "object" || !is_subclass_of($database_object, "DbTableObject")) {
			throw new NewException("Argument database_object for ".get_class($this)."::__construct() error", 0, getDebugBacktrace(1));
		}
		
		if (is_subclass_of($page_or_form_object, "Page")) {
			$this->page_object = $page_or_form_object;
		} else {
			$this->page_object = $page_or_form_object->getPageObject();
		}
		
		$this->form_or_page = $page_or_form_object;
		$this->database_model_object = $database_model_object;
		$this->database_object = $database_object;
	}
	
	/**
	 * Method prepareFieldsArray
	 * @access public
	 * @param mixed $properties [default value: array(]
	 * @return mixed
	 * @since 1.2.1
	 */
	public function prepareFieldsArray($properties=array()) {
		$this->fields_array = array();
		
		$list_attribute = $this->database_object->getDbTableAttributes();
		$list_attribute_type = $this->database_object->getDbTableAttributesType();
		$auto_increment_id = $this->database_object->getDbTableAutoIncrement();
		
		// Add properties to apply on all fields
		if (isset($properties[ModelViewMapper::PROPERTIES_ALL]) && is_array($properties[ModelViewMapper::PROPERTIES_ALL])) {
			$apply_all_array = $properties[ModelViewMapper::PROPERTIES_ALL];
			foreach ($apply_all_array as $property_name => $property_value) {
				for ($i=0; $i < sizeof($list_attribute); $i++) {
					$property[$property_name] = $property_value;
					if (isset($properties[$list_attribute[$i]])) {
					    // Handle child override of global property
                        if (!isset($properties[$list_attribute[$i]][$property_name])) {
                            $properties[$list_attribute[$i]] = array_merge($properties[$list_attribute[$i]], $property);
                        }
					} else {
						$properties[$list_attribute[$i]] = $property;
					}
				}
			}
		}
		
		// check foreign keys
		$db_table_foreign_keys = $this->database_object->getDbTableForeignKeys();
		foreach ($db_table_foreign_keys as $fk_attribute => $value) {
			if (isset($properties[$fk_attribute])) {
				$fk_property = $properties[$fk_attribute];
				if (isset($fk_property["fk_attribute"])) {
					// create combobox
					$cmb = new ComboBox($this->form_or_page);
					
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
		
		foreach ($list_attribute as $i => $attribute) {
			$wspobject = "TextBox";
			$attribute_properties = array();
			if (is_array($properties[$attribute])) {
				$attribute_properties = $properties[$attribute];
			}
			if (isset($attribute_properties["display"]) && $attribute_properties["display"] == false) {
				continue;
			}
			$is_update_ok = true;
			if (isset($attribute_properties["update"]) && $attribute_properties["update"] == false) {
				$is_update_ok = false;
			}
			
			$method = "get".$this->getFormatValue($attribute);
			$value = call_user_func_array(array($this->database_model_object, $method), array());
			
			if ($attribute != $auto_increment_id && $is_update_ok) {
			    // get property cmb_obj
				if (isset($attribute_properties['cmb_obj'])) {
					$field = $attribute_properties['cmb_obj'];
				} else {
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
						$field = new Calendar($this->form_or_page);
					} else if ($wspobject == "CheckBox") {
						$field = new CheckBox($this->form_or_page);
					} else if ($wspobject == "TextArea") {
						$field = new TextArea($this->form_or_page);
					} else if ($wspobject == "Editor") {
						$field = new Editor($this->form_or_page);
						if (isset($attribute_properties["editor_param"]) && $attribute_properties["editor_param"] != "") {
							$field->setToolbar($attribute_properties["editor_param"]);
						}
					} else if ($wspobject == "ComboBox") {
						$field = new ComboBox($this->form_or_page);
						if (isset($attribute_properties["combobox_values"])) {
							if (is_array($attribute_properties["combobox_values"])) {
								for ($j=0; $j < sizeof($attribute_properties["combobox_values"]); $j++) {
									$field->addItem($attribute_properties["combobox_values"][$j]['value'], 
														$attribute_properties["combobox_values"][$j]['text']);
								}
							} else {
								throw new NewException(get_class($this)."->prepareFieldsArray() error: the property combobox_values need to be an array.", 0, getDebugBacktrace(1));
							}
						}
					} else {
						$field = new TextBox($this->form_or_page);
						if ($list_attribute_type[$i] == "integer" || $list_attribute_type[$i] == "double") {
							$field->setWidth(70);
						}
						if (in_array($attribute, $key_attributes)) {
							$lv = new LiveValidation();
							$field->setLiveValidation($lv->addValidatePresence());
						}
					}
				}
				
				// Handle Checkbox case that only support value as "on" or "off"
				if (get_class($field) == "CheckBox") {
					if ($value == "1") {
						$field->setValue("on");
					} else {
						$field->setValue("off");
					}
				} else if (get_class($field) == "Calendar") {
					$field->setValue($value);
				} else {
					$field->setValue(utf8encode($value));
				}
				
				if (isset($attribute_properties["width"]) && method_exists($field, "setWidth")) {
					$field->setWidth($attribute_properties["width"]);
				}
				if (isset($attribute_properties["height"]) && method_exists($field, "setHeight")) {
					$field->setHeight($attribute_properties["height"]);
				}
				if (isset($attribute_properties["class"]) && method_exists($field, "setClass")) {
					$field->setClass($attribute_properties["class"]);
				}
				if (isset($attribute_properties["style"]) && method_exists($field, "setStyle")) {
					$field->setStyle($attribute_properties["style"]);
				}
				if (isset($attribute_properties["disable"])) {
					if ($attribute_properties["disable"] == true && method_exists($field, "disable")) {
						$field->disable();
					} else if ($attribute_properties["disable"] == false && method_exists($field, "enable")) {
						$field->enable();
					}
				}
				if (get_class($field) != "Calendar") {
					if (isset($attribute_properties["strip_tags"]) && $attribute_properties["strip_tags"] == true && 
							method_exists($field, "setStripTags")) {
						if (isset($attribute_properties["allowable_tags"])) {
							$field->setStripTags($attribute_properties["allowable_tags"]);
						} else {
							$field->setStripTags(""); // no tag allowed
						}
					}
				}
			} else {
				if (isset($attribute_properties['cmb_obj'])) {
					$field_tmp = $attribute_properties['cmb_obj'];
					$field_tmp->setValue($value);
					$value = $field_tmp->getText();
				}
				if (get_class($value) == "DateTime") {
					$value = $value->format("Y-m-d");
				}
				
				$field = new Object(utf8encode($value));
			}
			$this->fields_array[$attribute] = $field;
		}
		return $this->fields_array;
	}

	/**
	 * Method getFormatValue
	 * @access private
	 * @param mixed $table 
	 * @return mixed
	 * @since 1.2.1
	 */
	private function getFormatValue($table) {
		$table_tmp = str_replace("_", "-", $table);
		$table_names = explode('-', $table_tmp);
		$class_name = "";
		for ($i=0; $i < sizeof($table_names); $i++) {
			$class_name .= ucfirst($table_names[$i]);
		}
		return $class_name;
	}
	
	/**
	 * Method getField
	 * @access public
	 * @param mixed $attribute_name 
	 * @return mixed
	 * @since 1.2.1
	 */
	public function getField($attribute_name) {
		return $this->fields_array[$attribute_name];
	}
	
	/**
	 * Method setFieldValue
	 * @access public
	 * @param mixed $attribute_name 
	 * @param mixed $value 
	 * @return boolean
	 * @since 1.2.1
	 */
	public function setFieldValue($attribute_name, $value) {
		if (in_array(get_class($this->fields_array[$attribute_name]), $this->objects_ok_array)) {
			$this->fields_array[$attribute_name]->setValue($value);
			return true;
		}
		return false;
	}
	
	/**
	 * Method setField
	 * @access public
	 * @param mixed $attribute_name 
	 * @param mixed $field 
	 * @return boolean
	 * @since 1.2.1
	 */
	public function setField($attribute_name, $field) {
		if (!in_array(get_class($field), $this->objects_ok_array)) {
			throw new NewException(get_class($this)."->setField() error: field need to be ".implode(", ", $this->objects_ok_array).".", 0, getDebugBacktrace(1));
		}
		
		if (in_array(get_class($this->fields_array[$attribute_name]), $this->objects_ok_array)) {
			$this->fields_array[$attribute_name] = $field;
			return true;
		}
		return false;
	}
	
	/**
	 * Method getTableFields
	 * @access public
	 * @return mixed
	 * @since 1.2.1
	 */
	public function getTableFields() {
		$table = new Table();
		foreach ($this->fields_array as $attribute => $field) {
			$table->addRowColumns($attribute."&nbsp;:&nbsp;", $this->fields_array[$attribute_name]);
		}
		return $table;
	}
	
	/**
	 * Method getSynchronizeModelObject
	 * @access public
	 * @return mixed
	 * @since 1.2.1
	 */
	public function getSynchronizeModelObject() {
		$list_attribute = $this->database_object->getDbTableAttributes();
		$key_attributes = $this->database_object->getDbTablePrimaryKeys();
		$list_attribute_type = $this->database_object->getDbTableAttributesType();
		$is_insert = !$this->database_model_object->isDbObject();
		
		$error = false;
		foreach ($this->fields_array as $attribute => $field) {
			if ((!in_array($attribute, $key_attributes) || $is_insert) && in_array(get_class($field), $this->objects_ok_array)) {
				$value = $field->getValue();
				$search_pos = array_search($attribute, $list_attribute);
				if ($search_pos !== false && $value != "") {
					settype($value, $list_attribute_type[$search_pos]);
					
					if ("".$value != "".$field->getValue() && get_class($field) != "CheckBox") {
						$error_dialog = new DialogBox(__(ERROR), "Can't convert ".$field->getValue()." to ".$list_attribute_type[$search_pos]);
						$this->page_object->addObject($error_dialog->activateCloseButton());
						$error = true;
					}
				}
				
				if ($value == "") {
					if (get_class($field) == "CheckBox") {
						$value = 0;
					} else {
						$value = null;
					}
				}
				
				$method = "set".$this->getFormatValue($attribute);
				call_user_func_array(array($this->database_model_object, $method), array($value));
			}
		}
		return ($error?false:$this->database_model_object);
	}

	/**
	 * Method save
	 * @access public
	 * @since 1.2.1
	 */
	public function save() {
		$synchro = $this->getSynchronizeModelObject();
		if ($synchro !== false) {
			$this->database_model_object->save();
		}
	}
}
