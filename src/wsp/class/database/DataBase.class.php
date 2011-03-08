<?php
/**
 * PHP file wsp\class\database\DataBase.class.php
 * @package database
 */
/**
 * Class DataBase
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2011 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package database
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 03/10/2010
 * @version     1.0.57
 * @access      public
 * @since       1.0.17
 */

class DataBase {
	private $host = "localhost";
	private $root = "root";
	private $password = "";
	private $database = "";
	private $port = 3306;
	
	private $db_is_connect = false;
	private $is_begin_transaction = false;
	private $connection = null;
	
	/**
	 * Constructor DataBase
	 * @param mixed $host 
	 * @param mixed $root 
	 * @param mixed $password 
	 * @param string $database 
	 * @param double $port [default value: 3306]
	 */
	function __construct($host, $root, $password, $database='', $port=3306) {
		$this->host = $host;
		$this->root = $root;
		$this->password = $password;
		$this->database = $database;
		$this->port = $port;
		$this->db_is_connect = false;
		$this->is_begin_transaction = false;
	}
	
	/**
	 * Method getInstance
	 * @access public
	 * @return mixed
	 * @since 1.0.35
	 */
	final public static function getInstance() {
		static $dbInstance = null;
		if (!isset($dbInstance)) {
			$dbInstance = new DataBase(DB_HOST, DB_ROOT, DB_PASSWORD, DB_DATABASE, DB_PORT);
		}
		return $dbInstance;
	}
	
	/**
	 * Method connect
	 * @access public
	 * @return boolean
	 * @since 1.0.35
	 */
	public function connect() {
		$this->db_is_connect = false;
		if (!function_exists('mysqli_init') && !extension_loaded('mysqli')) {
		    exit("Sorry, the FrameWork WebSite-PHP use MySqli, please install it!\n");
		} else {
			$this->connection = new mysqli($this->host, $this->root, $this->password, "", $this->port);
			if (mysqli_connect_errno()) {
				if ($this->host == DB_HOST && $this->root == DB_ROOT && $this->password == DB_PASSWORD && $this->port == DB_PORT) {
					throw new NewException("Error DataBase::getInstance()->connect(): unable to connect : ".mysqli_connect_error(), 0, 8, __FILE__, __LINE__);
				}
				return false;
			} else {
				$this->db_is_connect = true;
				if ($this->database != "" && !$this->select_db($this->database)) {
					$this->db_is_connect = false;
					return false;
				}
				return true;
			}
		}
	}
	
	/**
	 * Method select_db
	 * @access public
	 * @param mixed $schema 
	 * @return boolean
	 * @since 1.0.35
	 */
	public function select_db($schema) {
		if ($this->db_is_connect) {
			if ($schema != "") {
				if (!$this->connection->select_db($schema)) {
					if ($schema == DB_DATABASE) {
						throw new NewException("Error DataBase::getInstance()->connect(): unable to connect to the database schema ".$schema.". ".mysql_error(), 0, 8, __FILE__, __LINE__);
					} else {
						return false;
					}
				} else {
					return true;
				}
			}
		}
		return false;
	}
	
	/**
	 * Method disconnect
	 * @access public
	 */
	public function disconnect() {
		if ($this->connection != null) {
			if ($this->connection != false) {
				$this->connection->close();
			}
		}
		$this->db_is_connect = false;
	}
	
	/**
	 * Method prepareStatement
	 * @access public
	 * @param mixed $query 
	 * @param mixed $stmt_objects [default value: array(]
	 * @return mixed
	 * @since 1.0.35
	 */
	public function prepareStatement($query, $stmt_objects=array()) {
		if ($this->db_is_connect) {
			$list_type = "";
			$list_stmt_objects = "";
			$type_array = array("i", "d", "s", "b");
			for ($i=0; $i < sizeof($stmt_objects); $i++) {
				$attribute_type = gettype($stmt_objects[$i]);
				if ($attribute_type == "boolean") {
					$type = "s";
				} else {
					$type = substr($attribute_type, 0, 1);
					if (!in_array($type, $type_array)) { $type = "s"; }
				}
				
				$list_type .= $type;
			}
			if (get_magic_quotes_gpc()) {
				$query = stripslashes($query);
			}
			
			if (strtoupper(substr($query, 0, 5)) == "SHOW ") {
				if ($stmt = $this->connection->query($query)) {
					return $stmt;
				} else {
					throw new NewException("Error DataBase::getInstance()->prepareStatement(): ".$this->connection->error." - SHOW Query: ".$query, 0, 8, __FILE__, __LINE__);
				}
			} else {
				if ($stmt = $this->connection->prepare($query)) {
					$stmt_bind_param = array($list_type);
					for ($i=0; $i < sizeof($stmt_objects); $i++) {
						$stmt_objects[$i] = str_replace("\\", "{#WSP_BACKSLASHE_CODE#}", $stmt_objects[$i]);
						if (get_magic_quotes_gpc()) {
							$stmt_objects[$i] = stripslashes($stmt_objects[$i]);      
						}
						$stmt_objects[$i] = $this->connection->real_escape_string($stmt_objects[$i]);
						$stmt_bind_param[] = str_replace("{#WSP_BACKSLASHE_CODE#}", "\\", $this->convertInvisibleCar($stmt_objects[$i]));
					}
					if ($list_type=="" || call_user_func_array(array($stmt, "bind_param"), $this->refValues($stmt_bind_param))) {
						$stmt->execute();
						if ($stmt->errno != 0) {
							if ($this->is_begin_transaction) {
								$this->rollbackTransaction();
							}
							throw new NewException("Error DataBase::getInstance()->prepareStatement(): ".$stmt->error." - Query: ".$query." [types: ".$list_type."] [values: ".$this->getStmtObjectsList($stmt_objects)."]", 0, 8, __FILE__, __LINE__);
						}
						
						$stmt->store_result();
						if ($stmt->errno != 0) {
							if ($this->is_begin_transaction) {
								$this->rollbackTransaction();
							}
							throw new NewException("Error DataBase::getInstance()->prepareStatement(): ".$stmt->error." - Query: ".$query." [types: ".$list_type."] [values: ".$this->getStmtObjectsList($stmt_objects)."]", 0, 8, __FILE__, __LINE__);
						}
						
						return $stmt;
					} else {
						throw new NewException("Error DataBase::getInstance()->prepareStatement(): error bind_param - Query: ".$query." [types: ".$list_type."] [values: ".$this->getStmtObjectsList($stmt_objects)."]", 0, 8, __FILE__, __LINE__);
					}
				} else {
					throw new NewException("Error DataBase::getInstance()->prepareStatement(): ".$stmt->error." - Query: ".$query." [types: ".$list_type."] [values: ".$this->getStmtObjectsList($stmt_objects)."]", 0, 8, __FILE__, __LINE__);
				}
			}
		} else {
			throw new NewException("Error DataBase::getInstance()->prepareStatement(): Not connect to database", 0, 8, __FILE__, __LINE__);
		}
	}
	
	/**
	 * Method convertInvisibleCar
	 * @access private
	 * @param mixed $txt 
	 * @return mixed
	 * @since 1.0.35
	 */
	private function convertInvisibleCar($txt) {
		$txt = str_replace("\\r", "\r", $txt);
		$txt = str_replace("\\n", "\n", $txt);
		$txt = str_replace("\\a", "\a", $txt);
		$txt = str_replace("\\'", "'", $txt);
		$txt = str_replace('\\"', '"', $txt);
		return $txt;
	}
	
	/**
	 * Method getStmtObjectsList
	 * @access private
	 * @param mixed $stmt_objects 
	 * @return mixed
	 * @since 1.0.35
	 */
	private function getStmtObjectsList($stmt_objects) {
		$list_stmt_objects = "";
		for ($i=0; $i < sizeof($stmt_objects); $i++) {
			if ($list_stmt_objects != "") { $list_stmt_objects .= ", "; }
			$list_stmt_objects .= $stmt_objects[$i];
		}
		return $list_stmt_objects;
	}
	
	/**
	 * Method stmtBindAssoc
	 * @access public
	 * @param mixed $&stmt 
	 * @return mixed
	 * @since 1.0.35
	 */
	public function stmtBindAssoc(&$stmt) {
	    $data = $stmt->result_metadata();
	    $fields = array();
	    $row = array();
	    $count = 0;
	    
	    while($field = $data->fetch_field()) {
	        $fields[$count++] = &$row[$field->name];
	    }   
	    call_user_func_array(array($stmt, "bind_result"), $fields);
	    $data->free(); 
	    return $row;
	}
	
	/**
	 * Method refValues
	 * @access private
	 * @param mixed $arr 
	 * @return mixed
	 * @since 1.0.35
	 */
	private function refValues($arr){
	    if (strnatcmp(phpversion(),'5.3') >= 0) { //Reference is required for PHP 5.3+
	        $refs = array();
	        foreach($arr as $key => $value) {
	            $refs[$key] = &$arr[$key];
	        }
	        return $refs;
	    }
	    return $arr;
	} 
	
	/**
	 * Method beginTransaction
	 * @access public
	 * @return boolean
	 * @since 1.0.35
	 */
	public function beginTransaction() {
		if ($this->db_is_connect) {
			if ($this->is_begin_transaction == true) {
				return false;
			} else {
				$this->connection->autocommit(FALSE);
				$this->is_begin_transaction = true;
				return true;
			}
		} else {
			throw new NewException("Error DataBase::getInstance()->prepareStatement(): Not connect to database", 0, 8, __FILE__, __LINE__);
		}
	}
	
	/**
	 * Method commitTransaction
	 * @access public
	 */
	public function commitTransaction() {
		if ($this->db_is_connect && $this->is_begin_transaction) {
			$this->is_begin_transaction = false;
			$this->connection->commit();
		} else {
			throw new NewException("Error DataBase::getInstance()->prepareStatement(): Not connect to database", 0, 8, __FILE__, __LINE__);
		}
	}
	
	/**
	 * Method rollbackTransaction
	 * @access public
	 */
	public function rollbackTransaction() {
		if ($this->db_is_connect && $this->is_begin_transaction) {
			$this->is_begin_transaction = false;
			$this->connection->rollback();
		} else {
			throw new NewException("Error DataBase::getInstance()->prepareStatement(): Not connect to database", 0, 8, __FILE__, __LINE__);
		}
	}
	
	/**
	 * Method getLastInsertId
	 * @access public
	 * @return mixed
	 * @since 1.0.35
	 */
	public function getLastInsertId() {
		return $this->connection->insert_id;
	}
}
?>
