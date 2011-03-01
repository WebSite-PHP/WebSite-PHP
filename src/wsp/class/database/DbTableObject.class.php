<?php
/**
 * Description of PHP file wsp\class\database\DbTableObject.class.php
 * Class DbTableObject
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

class DbTableObject {
	/**#@+
	* @access private
	*/
	private $db_schema_name = "";
	private $db_table_name = "";
	private $db_table_attributes = array();
	private $db_table_attributes_type = array();
	private $db_table_primary_keys = array();
	/**#@-*/
	
	function __construct() {}

	function getDbSchemaName() {
		return $this->db_schema_name;
	}
	
	function getDbTableName() {
		return $this->db_table_name;
	}
	
	function getDbTableSchemaName() {
		return (($this->db_schema_name!="")? $this->db_schema_name."." : "").$this->db_table_name;
	}
	
	function getDbTableAttributes() {
		return $this->db_table_attributes;
	}
	
	function getDbTableAttributesType() {
		return $this->db_table_attributes_type;
	}
	
	function getDbTablePrimaryKeys() {
		return $this->db_table_primary_keys;
	}
	
	function setDbSchemaName($db_schema_name) {
		$this->db_schema_name = $db_schema_name;
	}
	
	function setDbTableName($db_table_name) {
		$this->db_table_name = $db_table_name;
	}
	
	function setDbTableAttributes($db_table_attributes) {
		$this->db_table_attributes = $db_table_attributes;
	}
	
	function setDbTableAttributesType($db_table_attributes_type) {
		$this->db_table_attributes_type = $db_table_attributes_type;
	}
	
	function setDbTablePrimaryKeys($db_table_primary_keys) {
		$this->db_table_primary_keys = $db_table_primary_keys;
	}
}
?>
