<?php
/**
 * PHP file wsp\class\abstract\database\DbTableObject.class.php
 * @package abstract
 * @subpackage database
 */
/**
 * Abstract Class DbTableObject
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2015 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package abstract
 * @subpackage database
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 12/05/2015
 * @version     1.2.13
 * @access      public
 * @since       1.0.17
 */

abstract class DbTableObject {
	/**#@+
	* @access private
	*/
	private $db_schema_name = "";
	private $db_table_name = "";
	private $db_table_attributes = array();
	private $db_table_attributes_type = array();
	private $db_table_primary_keys = array();
	private $db_table_auto_increment = "";
	private $db_table_foreign_keys = array();
	/**#@-*/
	
	/**
	 * Constructor DbTableObject
	 */
	function __construct() {}

	/**
	 * Method getDbSchemaName
	 * @return mixed
	 * @since 1.0.35
	 */
	function getDbSchemaName() {
		return $this->db_schema_name;
	}
	
	/**
	 * Method getDbTableName
	 * @return mixed
	 * @since 1.0.35
	 */
	function getDbTableName() {
		return $this->db_table_name;
	}
	
	/**
	 * Method getDbTableSchemaName
	 * @return mixed
	 * @since 1.0.35
	 */
	function getDbTableSchemaName() {
		return (($this->db_schema_name!="")? "`".$this->db_schema_name."`." : "")."`".$this->db_table_name."`";
	}
	
	/**
	 * Method getDbTableAttributes
	 * @return mixed
	 * @since 1.0.35
	 */
	function getDbTableAttributes() {
		return $this->db_table_attributes;
	}
	
	/**
	 * Method getDbTableAttributesType
	 * @return mixed
	 * @since 1.0.35
	 */
	function getDbTableAttributesType() {
		return $this->db_table_attributes_type;
	}
	
	/**
	 * Method getDbTablePrimaryKeys
	 * @return mixed
	 * @since 1.0.35
	 */
	function getDbTablePrimaryKeys() {
		return $this->db_table_primary_keys;
	}
	
	/**
	 * Method getDbTableAutoIncrement
	 * @return mixed
	 * @since 1.1.6
	 */
	function getDbTableAutoIncrement() {
		return $this->db_table_auto_increment;
	}

	/**
	 * Method getDbTableForeignKeys
	 * @return mixed
	 * @since 1.1.6
	 */
	function getDbTableForeignKeys() {
		return $this->db_table_foreign_keys;
	}
	
	/**
	 * Method setDbSchemaName
	 * @param mixed $db_schema_name 
	 * @since 1.0.59
	 */
	function setDbSchemaName($db_schema_name) {
		$this->db_schema_name = $db_schema_name;
	}
	
	/**
	 * Method setDbTableName
	 * @param mixed $db_table_name 
	 * @since 1.0.59
	 */
	function setDbTableName($db_table_name) {
		$this->db_table_name = $db_table_name;
	}
	
	/**
	 * Method setDbTableAttributes
	 * @param mixed $db_table_attributes 
	 * @since 1.0.59
	 */
	function setDbTableAttributes($db_table_attributes) {
		$this->db_table_attributes = $db_table_attributes;
	}
	
	/**
	 * Method setDbTableAttributesType
	 * @param mixed $db_table_attributes_type 
	 * @since 1.0.59
	 */
	function setDbTableAttributesType($db_table_attributes_type) {
		$this->db_table_attributes_type = $db_table_attributes_type;
	}
	
	/**
	 * Method setDbTablePrimaryKeys
	 * @param mixed $db_table_primary_keys 
	 * @since 1.0.59
	 */
	function setDbTablePrimaryKeys($db_table_primary_keys) {
		$this->db_table_primary_keys = $db_table_primary_keys;
	}
	
	/**
	 * Method setDbTableAutoIncrement
	 * @param mixed $db_table_auto_increment 
	 * @since 1.1.6
	 */
	function setDbTableAutoIncrement($db_table_auto_increment) {
		$this->db_table_auto_increment = $db_table_auto_increment;
	}
	
	/**
	 * Method setDbTableForeignKeys
	 * @param mixed $db_table_foreign_keys 
	 * @since 1.1.6
	 */
	function setDbTableForeignKeys($db_table_foreign_keys) {
		$this->db_table_foreign_keys = $db_table_foreign_keys;
	}
}
?>
