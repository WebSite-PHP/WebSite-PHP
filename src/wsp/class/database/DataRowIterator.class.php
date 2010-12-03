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
 
class DataRowIterator {
	/**#@+
	* @access private
	*/
	private $db_table_object = null;
	
	private $rows = array();
	private $current_row = 0;
	/**#@-*/
	
	function __construct($db_table_object) {
		if (!isset($db_table_object)) {
			throw new NewException("1 argument for ".get_class($this)."::__construct() is mandatory", 0, 8, __FILE__, __LINE__);
		}
		
		$this->db_table_object = $db_table_object;
		$this->rows_num = 0;
	}
	
	public function insert($is_sql_load_mode=false) {
		$data_row = new DataRow($this->db_table_object, $is_sql_load_mode);
		$this->rows[] = $data_row;
		return $data_row;
	}
	
	public function save() {
		$where_cond = "";
		$db_table_primary_keys = $this->db_table_object->getDbTablePrimaryKeys();
		for ($i=0; $i < sizeof($db_table_primary_keys); $i++) {
			if ($where_cond != "") { $where_cond .= " AND "; }
			$where_cond .= "`".$this->db_table_object->getDbTableName()."`.`".$db_table_primary_keys[$i]."`=?";
		}
		
		$db_table_attributes = $this->db_table_object->getDbTableAttributes();
		
		$next_row = 0;
		while($next_row < sizeof($this->rows)) {
			$data_row = $this->rows[$next_row];
			if ($data_row->isDeleted()) { // Delete
				$this->deleteRow($data_row, $where_cond, $db_table_primary_keys);
			} else if ($data_row->isInserted()) { // Insert
				$this->insertRow($data_row, $db_table_attributes);
			} else if ($data_row->isUpdated()) { // Update
				$this->updateRow($data_row, $where_cond, $db_table_attributes, $db_table_primary_keys);
			}
			$next_row++;
		}
	}
	
	private function insertRow($data_row, $db_table_attributes) {
		// insert row
		$stmt_objects = array();
		$list_attribute = "";
		$list_prepare_stmt_insert = "";
		for ($i=0; $i < sizeof($db_table_attributes); $i++) {
			$value = $data_row->getValue($db_table_attributes[$i]);
			if ($value != null) {
				if ($list_attribute != "") { $list_attribute .= ", "; $list_prepare_stmt_insert .= ", "; }
				$list_attribute .= "`".$this->db_table_object->getDbTableName()."`.`".$db_table_attributes[$i]."`";
				if (gettype($value) == "object") {
					if (get_class($value) == "DateTime") {
						$value = $value->format("Y-m-d H:i:s");
					} else {
						$value = $value->__toString();
					}
				}
				$list_prepare_stmt_insert .= "?";
				$stmt_objects[] = $value;
			}
		}
		
		$query = "INSERT INTO ".$this->db_table_object->getDbTableSchemaName()." (".$list_attribute.") VALUES (".$list_prepare_stmt_insert.")";
		DataBase::getInstance()->prepareStatement($query, $stmt_objects);
	}
	
	private function deleteRow($data_row, $where_cond, $db_table_primary_keys) {
		// delete row
		$stmt_objects = array();
		for ($i=0; $i < sizeof($db_table_primary_keys); $i++) {
			$value= $data_row->getValue($db_table_primary_keys[$i]);;
			if (gettype($value) == "object") {
				if (get_class($value) == "DateTime") {
					$value = $value->format("Y-m-d H:i:s");
				} else {
					$value = $value->__toString();
				}
			}
			$stmt_objects[] = $value;
		}
		
		$query = "DELETE FROM ".$this->db_table_object->getDbTableSchemaName()." WHERE ".$where_cond;
		DataBase::getInstance()->prepareStatement($query, $stmt_objects);
	}
	
	private function updateRow($data_row, $where_cond, $db_table_attributes, $db_table_primary_keys) {
		// update row
		$stmt_objects = array();
		$list_prepare_stmt_update = "";
		for ($i=0; $i < sizeof($db_table_attributes); $i++) {
			$value = $data_row->getValue($db_table_attributes[$i]);
			if ($value != null && !in_array($db_table_attributes[$i], $db_table_primary_keys)) {
				if ($list_prepare_stmt_update != "") { $list_prepare_stmt_update .= ", "; }
				$list_prepare_stmt_update .= "`".$this->db_table_object->getDbTableName()."`.`".$db_table_attributes[$i]."`=";
				if (gettype($value) == "object") {
					if (get_class($value) == "DateTime") {
						$value = $value->format("Y-m-d H:i:s");
					} else {
						$value = $value->__toString();
					}
				}
				$list_prepare_stmt_update .= "?";
				$stmt_objects[] = $value;
			}
		}
		for ($i=0; $i < sizeof($db_table_primary_keys); $i++) {
			$stmt_objects[] = $data_row->getValue($db_table_primary_keys[$i]);
		}
		
		$query = "UPDATE ".$this->db_table_object->getDbTableSchemaName()." SET ".$list_prepare_stmt_update." WHERE ".$where_cond;
		DataBase::getInstance()->prepareStatement($query, $stmt_objects);
	}
	
	public function toArray() {
		$next_row = 0;
		$array_rows = array();
		while ($next_row < sizeof($this->rows)) {
			$data_row = $this->rows[$next_row];
			$next_row++;
			if (!$data_row->isDeleted()) {
				$array_rows[] = $data_row;
			}
		}
		return $array_rows;
	}

	public function getRowsNum() {
		$next_row = 0;
		$rows_num = 0;
		while ($next_row < sizeof($this->rows)) {
			$data_row = $this->rows[$next_row];
			$next_row++;
			if (!$data_row->isDeleted()) {
				$rows_num++;
			}
		}
		return $rows_num;
	}
	
	public function next() {
		$data_row = null;
		while ($this->current_row < sizeof($this->rows)) {
			$tmp_data_row = $this->rows[$this->current_row];
			$this->current_row++;
			if (!$tmp_data_row->isDeleted()) {
				$data_row = $tmp_data_row;
				break;
			}
		}
		return $data_row;
	}
	
	public function hasNext() {
		$data_row = null;
		$next_row = $this->current_row;
		while ($next_row < sizeof($this->rows)) {
			$tmp_data_row = $this->rows[$next_row];
			$next_row++;
			if (!$tmp_data_row->isDeleted()) {
				$data_row = $tmp_data_row;
				break;
			}
		}
		if ($data_row == null) {
			return false;
		} else {
			return true;
		}
	}
	
	public function initIterator() {
		$this->current_row = 0;
	}
}
?>
