<?php
/**
 * Class SqlDataView
 * 
 * Instance of a new SqlDataView.
 * @access public
 * @author Emilien MOREL <admin@website-php.com>
 * @link http://www.website-php.com
 * @copyright website-php.com 05/03/2010
 * @version 1.0
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
										"blob" => array("string")
									);
	/**#@-*/
	
	function __construct($db_table_object, $is_sql_load_mode=false) {
		$this->db_table_object = $db_table_object;
		$this->is_sql_load_mode = $is_sql_load_mode;
		$this->is_inserted = !$is_sql_load_mode;
		$this->is_updated = false;
		$this->is_deleted = false;
	}
	
	function __destruct() {}
	
	public function getValue($attribute) {
		if (!array_key_exists($attribute, $this->row)) {
			throw new NewException("Error DataRow->getValue(): attribute ".$attribute." unknow in table ".$this->db_table_object->getDbTableName(), 0, 8, __FILE__, __LINE__);
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
			return $value;
		} else {
			return $this->row[$attribute];
		}
	}
	
	public function setValue($attribute, $value) {
		if (!$this->is_deleted) {
			$pos_attribute = array_search($attribute, $this->db_table_object->getDbTableAttributes());
			$primary_keys = $this->db_table_object->getDbTablePrimaryKeys();
			if (!$this->is_sql_load_mode && !$this->is_inserted && in_array($attribute, $primary_keys)) {
				throw new NewException("Error DataRow->setValue(): You can not change primary key value for attribute ".$attribute." in table ".$this->db_table_object->getDbTableName().".", 0, 8, __FILE__, __LINE__);
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
					throw new NewException("Error DataRow->setValue(): attribute ".$attribute." in table ".$this->db_table_object->getDbTableName()." must be a ".$type, 0, 8, __FILE__, __LINE__);
				}
			} else {
				throw new NewException("Error DataRow->setValue(): attribute ".$attribute." unknow in table ".$this->db_table_object->getDbTableName(), 0, 8, __FILE__, __LINE__);
			}
		}
	}
	
	public function isUpdated() {
		if (!$this->is_deleted) {
			return $this->is_updated;
		} else {
			return false;
		}
	}
	
	public function delete() {
		$this->is_deleted = true;
	}
	
	public function isDeleted() {
		return $this->is_deleted;
	}
	
	public function isInserted() {
		return $this->is_inserted;
	}
	
	public function disableSqlLoadMode() {
		$this->is_sql_load_mode = false;
	}
	
	public function enableHtmlentitiesMode() {
		$this->activate_htmlentities = true;
	}
	
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