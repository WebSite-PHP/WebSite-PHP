<?php
/**
 * PHP file wsp\class\database\DataRow.class.php
 * @package database
 */
/**
 * Class DataRow
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
 * @since       1.0.17
 */

class DataRow {
	/**#@+
	* @access private
	*/
	private $row = array();
	private $db_table_object = null;
	private $is_sql_load_mode = false;
	private $is_updated = false;
	private $is_deleted = false;
	private $is_inserted = false;
	private $activate_htmlentities = false;
	
	private $authorize_type = array(
										"string" => array("string", "integer", "double", "boolean"),
										"integer" => array("integer"),
										"double" => array("integer", "double"),
										"datetime" => array("datetime"),
										"blob" => array("string", "binary")
									);
	/**#@-*/
	
	/**
	 * Constructor DataRow
	 * @param mixed $db_table_object 
	 * @param boolean $is_sql_load_mode [default value: false]
	 */
	function __construct($db_table_object, $is_sql_load_mode=false) {
		$this->db_table_object = $db_table_object;
		$this->is_sql_load_mode = $is_sql_load_mode;
		$this->is_inserted = !$is_sql_load_mode;
		$this->is_updated = false;
		$this->is_deleted = false;
	}
	
	/**
	 * Destructor DataRow
	 */
	function __destruct() {}
	
	/**
	 * Method getValue
	 * @access public
	 * @param string $attribute 
	 * @return mixed
	 * @since 1.0.35
	 */
	public function getValue($attribute) {
		if (!array_key_exists($attribute, $this->row)) {
			throw new NewException("Error DataRow->getValue(): attribute ".$attribute." unknow in table ".$this->db_table_object->getDbTableName(), 0, getDebugBacktrace(1));
		}
		if (gettype($this->row[$attribute]) == "string") {
			$value = $this->row[$attribute];
			if ($this->activate_htmlentities) {
				$value = htmlentities(html_entity_decode($value));
				$value = str_replace("&lt;", "<", $value);
				$value = str_replace("&gt;", ">", $value);
				$value = str_replace("&quot;", "\"", $value);
				$value = str_replace("&#34;", "\"", $value);
				$value = str_replace("&#39;", "'", $value);
				$value = str_replace("&lsquo;", "'", $value);
				$value = str_replace("&rsquo;", "'", $value);
				$value = str_replace("&acute;", "'", $value);
			} 
			return utf8encode($value);
		} else {
			return $this->row[$attribute];
		}
	}
	
	/**
	 * Method setValue
	 * @access public
	 * @param string $attribute 
	 * @param mixed $value 
	 * @since 1.0.59
	 */
	public function setValue($attribute, $value) {
		if (!$this->is_deleted) {
			$pos_attribute = array_search($attribute, $this->db_table_object->getDbTableAttributes());
			$primary_keys = $this->db_table_object->getDbTablePrimaryKeys();
			if (!$this->is_sql_load_mode && !$this->is_inserted && in_array($attribute, $primary_keys)) {
				throw new NewException("Error DataRow->setValue(): You can not change primary key value for attribute ".$attribute." in table ".$this->db_table_object->getDbTableName().".", 0, getDebugBacktrace(1));
			}
			if ($pos_attribute !== false || $this->is_sql_load_mode) {
				if ($pos_attribute !== false) {
					$attributes_type = $this->db_table_object->getDbTableAttributesType();
					$type = $attributes_type[$pos_attribute];
					$type_value = gettype($value);
					if ($type_value == "object") {
						$type_value = get_class($value);
					}
					$type_value = strtolower($type_value);
				} else {
					$type_value = "string"; // inner join value
				}
				
				$type_is_ok = false;
				if ($this->is_sql_load_mode) {
					$type_is_ok = true;
				} else if ($type != "") {
					if (array_search($type_value, $this->authorize_type[$type]) !== false) {
						$type_is_ok = true;
					}
				}
				if ($value == null || $type_is_ok) {
					$this->row[$attribute] = $value;
					if (!$this->is_sql_load_mode) {
						$this->is_updated = true;
					}
				} else {
					throw new NewException("Error DataRow->setValue(): attribute ".$attribute." in table ".$this->db_table_object->getDbTableName()." must be a ".$type." [value: ".$value."][type: ".$type_value."]", 0, getDebugBacktrace(1));
				}
			} else {
				throw new NewException("Error DataRow->setValue(): attribute ".$attribute." unknow in table ".$this->db_table_object->getDbTableName(), 0, getDebugBacktrace(1));
			}
		}
	}
	
	/**
	 * Method isUpdated
	 * @access public
	 * @return boolean
	 * @since 1.0.35
	 */
	public function isUpdated() {
		if (!$this->is_deleted) {
			return $this->is_updated;
		} else {
			return false;
		}
	}
	
	/**
	 * Method delete
	 * @access public
	 * @since 1.0.59
	 */
	public function delete() {
		$this->is_deleted = true;
	}
	
	/**
	 * Method isDeleted
	 * @access public
	 * @return mixed
	 * @since 1.0.35
	 */
	public function isDeleted() {
		return $this->is_deleted;
	}
	
	/**
	 * Method isInserted
	 * @access public
	 * @return mixed
	 * @since 1.0.35
	 */
	public function isInserted() {
		return $this->is_inserted;
	}
	
	/**
	 * Method disableSqlLoadMode
	 * @access public
	 * @since 1.0.59
	 */
	public function disableSqlLoadMode() {
		$this->is_sql_load_mode = false;
	}

	/**
	 * Method enableSqlLoadMode
	 * @access public
	 * @since 1.1.6
	 */
	public function enableSqlLoadMode() {
		$this->is_sql_load_mode = true;
	}
	
	/**
	 * Method enableHtmlentitiesMode
	 * @access public
	 * @since 1.0.59
	 */
	public function enableHtmlentitiesMode() {
		$this->activate_htmlentities = true;
	}
	
	/**
	 * Method __toString
	 * @access public
	 * @return mixed
	 * @since 1.0.35
	 */
	public function __toString() {
		$str = "";
		foreach ($this->row as $key =>$value) {
			if ($str != "") { $str .= ", "; }
			if (gettype($value) == "object") {
				if (get_class($value) == "DateTime") {
					$value = $value->format("Y-m-d H:i:s");
				} else {
					$value = $value->__toString();
				}
			}
			$str .= $key."='".$value."'";
		}
		return $str;
	}
}
?>
