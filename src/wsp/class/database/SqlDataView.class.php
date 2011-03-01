<?php
/**
 * Description of PHP file wsp\class\database\SqlDataView.class.php
 * Class SqlDataView
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2011 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 03/10/2010
 *
 * @version     1.0.30
 * @access      public
 * @since       1.0.17
 */

class SqlDataView {
	/**#@+
	* @access public
	* @var string
	*/
	const JOIN_TYPE_INNER = "INNER";
	const JOIN_TYPE_LEFT = "LEFT";
	const JOIN_TYPE_LEFT_OUTER = "LEFT OUTER";
	const JOIN_TYPE_RIGHT = "RIGHT";
	const JOIN_TYPE_RIGHT_OUTER = "RIGHT OUTER";
	/**#@-*/
	
	/**#@+
	* @access public
	* @var string
	*/
	const ORDER_DESC = "DESC";
	const ORDER_ASC = "ASC";
	/**#@-*/
	
	/**#@+
	* @access private
	*/
	private $db_table_object = null;
	
	private $clause = "";
	private $clause_objects = null;
	private $offset = null;
	private $row_count = null;
	private $attributes = array();
	private $attributes_order = array();
	private $last_query = "";
	
	private $joins_object = array();
	private $join_clause = array();
	private $joins_type = array();
	
	private $iterator = null;
	private $activate_htmlentities = false;
	/**#@-*/
	
	function __construct($db_table_object) {
		if (!isset($db_table_object)) {
			throw new NewException("1 argument for ".get_class($this)."::__construct() is mandatory", 0, 8, __FILE__, __LINE__);
		}
		$this->db_table_object = $db_table_object;
		$this->last_query = "";
	}
	
	public function setClause($clause, $clause_objects=array()) {
		$this->clause = $clause;
		$this->clause_objects = $clause_objects;
		return $this;
	}
	
	public function setLimit($offset, $row_count) {
		if (!is_integer($offset)) {
			throw new NewException("Error SqlDataView->setLimit(): offset must be an integer", 0, 8, __FILE__, __LINE__);
		}
		if (!is_integer($row_count)) {
			throw new NewException("Error SqlDataView->setLimit(): row_count must be an integer", 0, 8, __FILE__, __LINE__);
		}
		$this->offset = $offset;
		$this->row_count = $row_count;
		return $this;
	}
	
	public function addOrder($attribute, $order='ASC') {
		if (strtoupper($order) != "ASC" && strtoupper($order) != "DESC") {
			throw new NewException("Error SqlDataView->addOrder(): order must be like ASC or DESC", 0, 8, __FILE__, __LINE__);
		}
		$this->attributes[] = $attribute;
		$this->attributes_order[] = $order;
		return $this;
	}
	
	public function addJoinAttribute($db_table_object_join, $join_attribute_1, $join_attribute_2, $join_type='INNER') {
		if (!isset($db_table_object_join) && !isset($join_attribute_1) && !isset($join_attribute_2)) {
			throw new NewException("Error SqlDataView->addJoinAttribute(): 3 arguments for method addJoin are mandatory", 0, 8, __FILE__, __LINE__);
		}
		
		$this->addJoinTableAttribute($db_table_object_join, null, $join_attribute_1, $join_attribute_2, $join_type);
	}
	
	public function addJoinTableAttribute($db_table_object_join_1, $db_table_object_join_2, $join_attribute_1, $join_attribute_2, $join_type='INNER') {
		if (!isset($db_table_object_join_1) && !isset($db_table_object_join_2) && !isset($join_attribute_1) && !isset($join_attribute_2)) {
			throw new NewException("Error SqlDataView->addJoinTableAttribute(): 4 arguments for method addJoin are mandatory", 0, 8, __FILE__, __LINE__);
		}
		
		$join_clause = "";
		if (find($join_attribute_1, ".", 0, 0) == 0) {
			$join_clause .= "`".$db_table_object_join_1->getDbTableName()."`.`".$join_attribute_1."`";
		} else {
			$join_clause .= $join_attribute_1;
		}
		$join_clause .= " = ";
		if (find($join_attribute_2, ".", 0, 0) == 0) {
			if ($db_table_object_join_2 != null) {
				$join_clause .= "`".$db_table_object_join_2->getDbTableName()."`.`".$join_attribute_2."`";
			} else {
				$join_clause .= "`".$this->db_table_object->getDbTableName()."`.`".$join_attribute_2."`";
			}
		} else {
			$join_clause .= $join_attribute_2;
		}
		$this->addJoinClause($db_table_object_join_1, $join_clause, $join_type);
	}
	
	public function addJoinClause($db_table_object_join, $join_clause, $join_type='INNER') {
		if (!isset($db_table_object_join) && !isset($join_clause)) {
			throw new NewException("Error SqlDataView->addJoinClause(): 2 arguments for method addJoin are mandatory", 0, 8, __FILE__, __LINE__);
		}
		
		$join_type = trim($join_type);
		if (strtoupper($join_type) != SqlDataView::JOIN_TYPE_INNER && strtoupper($join_type) != SqlDataView::JOIN_TYPE_LEFT 
			&& strtoupper($join_type) != SqlDataView::JOIN_TYPE_LEFT_OUTER && strtoupper($join_type) != SqlDataView::JOIN_TYPE_RIGHT 
			&& strtoupper($join_type) != SqlDataView::JOIN_TYPE_RIGHT_OUTER) {
			throw new NewException("Error SqlDataView->addJoin(): join type error, ".$join_type." doesn't exist", 0, 8, __FILE__, __LINE__);
		}
		$this->joins_object[] = $db_table_object_join;
		$this->join_clause[] = $join_clause;
		$this->joins_type[] = $join_type;
	}
	
	public function retrieve() {
		$list_attribute = "";
		$db_table_attributes = $this->db_table_object->getDbTableAttributes();
		for ($i=0; $i < sizeof($db_table_attributes); $i++) {
			if ($list_attribute != "") { $list_attribute .= ", "; }
			$list_attribute .= "`".$this->db_table_object->getDbTableName()."`.`".$db_table_attributes[$i]."`";
		}
		for ($i=0; $i < sizeof($this->joins_object); $i++) {
			$db_table_join_attributes = $this->joins_object[$i]->getDbTableAttributes();
			for ($j=0; $j < sizeof($db_table_join_attributes); $j++) {
				if ($list_attribute != "") { $list_attribute .= ", "; }
				$list_attribute .= "`".$this->joins_object[$i]->getDbTableName()."`.`".$db_table_join_attributes[$j]."`";
			}
		}
		$this->iterator = new DataRowIterator($this->db_table_object);
		if ($list_attribute != "") {
			$query = "SELECT ";
			if (sizeof($this->joins_object) > 0) {
				$query .= "DISTINCT ";
			}
			$query .= $list_attribute;
			$query .= " FROM ".$this->db_table_object->getDbTableSchemaName();
			for ($i=0; $i < sizeof($this->joins_object); $i++) {
				$query .= " ".$this->joins_type[$i]." JOIN ".$this->joins_object[$i]->getDbTableSchemaName()." ON ".$this->join_clause[$i];
			}
			if ($this->clause != "") {
				if (find($this->clause, "WHERE ", 1, 0) == 0) {
					$this->clause = " WHERE ".$this->clause;
				}
				$query .= $this->clause." ";
			}
			if (sizeof($this->attributes) > 0) {
				$query .= " ORDER BY ";
				for ($i=0; $i < sizeof($this->attributes); $i++) {
					if ($i != 0) { $query .= ", "; }
					$query .= $this->attributes[$i]." ".$this->attributes_order[$i];
				}
			}
			if ($this->row_count != null) {
				$query .= " LIMIT ".$this->offset.", ".$this->row_count;
			}
			$attributes_type = $this->db_table_object->getDbTableAttributesType();
			$this->last_query = $query;
			
			$stmt = DataBase::getInstance()->prepareStatement($query, $this->clause_objects);
			$row = DataBase::getInstance()->stmtBindAssoc($stmt, $row);
			while ($stmt->fetch()) {
				$data_row = $this->iterator->insert(true);
				if ($this->activate_htmlentities) {
					$data_row->enableHtmlentitiesMode();
				}
				$i=0;
				foreach ($row as $key => $value) {
					if (isset($attributes_type[$i]) && $attributes_type[$i] == "datetime") {
						$value = new DateTime($value);
					}
					$data_row->setValue($key, $value);
					$i++;
				}
				$data_row->disableSqlLoadMode();
			}
			$stmt->free_result();
			$stmt->close();
		}
		return $this->iterator;
	}
	
	public function getLastQuery($display_params=true) {
		$params = "";
		for ($i=0; $i < sizeof($this->clause_objects); $i++) {
			$value = $this->clause_objects[$i];
			if (gettype($value) == "object") {
				if (get_class($value) == "DateTime") {
					$value = $value->format("Y-m-d H:i:s");
				} else {
					$value = $value->__toString();
				}
			}
			if ($params != "") { $params .= ", "; }
			$params .= $value;
		}
		if ($display_params) {
			return $this->last_query." [params: ".$params."]";
		} else {
			return $this->last_query;
		}
	}
	
	public function createEmpty() {
		$this->last_query = "";
		$this->iterator = new DataRowIterator($this->db_table_object);
		return $this->iterator;
	}
	
	public function enableHtmlentitiesMode() {
		$this->activate_htmlentities = true;
		return $this;
	}
}
?>
