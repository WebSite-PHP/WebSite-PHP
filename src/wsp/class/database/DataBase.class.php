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
 
class DataBase {
	private $host = "localhost";
	private $root = "root";
	private $password = "";
	private $database = "";
	private $port = 3306;
	
	private $db_is_connect = false;
	private $is_begin_transaction = false;
	private $connection = null;
	
	function __construct($host, $root, $password, $database='', $port=3306) {
		$this->host = $host;
		$this->root = $root;
		$this->password = $password;
		$this->database = $database;
		$this->port = $port;
		$this->db_is_connect = false;
		$this->is_begin_transaction = false;
	}
	
	final public static function getInstance() {
		static $dbInstance = null;
		if (!isset($dbInstance)) {
			$dbInstance = new DataBase(DB_HOST, DB_ROOT, DB_PASSWORD, DB_DATABASE, DB_PORT);
		}
		return $dbInstance;
	}
	
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
	
	public function disconnect() {
		if ($this->connection != null) {
			if ($this->connection != false) {
				$this->connection->close();
			}
		}
		$this->db_is_connect = false;
	}
	
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
	
	private function convertInvisibleCar($txt) {
		$txt = str_replace("\\r", "\r", $txt);
		$txt = str_replace("\\n", "\n", $txt);
		$txt = str_replace("\\a", "\a", $txt);
		$txt = str_replace("\\'", "'", $txt);
		$txt = str_replace('\\"', '"', $txt);
		return $txt;
	}
	
	private function getStmtObjectsList($stmt_objects) {
		$list_stmt_objects = "";
		for ($i=0; $i < sizeof($stmt_objects); $i++) {
			if ($list_stmt_objects != "") { $list_stmt_objects .= ", "; }
			$list_stmt_objects .= $stmt_objects[$i];
		}
		return $list_stmt_objects;
	}
	
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
	
	public function commitTransaction() {
		if ($this->db_is_connect && $this->is_begin_transaction) {
			$this->is_begin_transaction = false;
			$this->connection->commit();
		} else {
			throw new NewException("Error DataBase::getInstance()->prepareStatement(): Not connect to database", 0, 8, __FILE__, __LINE__);
		}
	}
	
	public function rollbackTransaction() {
		if ($this->db_is_connect && $this->is_begin_transaction) {
			$this->is_begin_transaction = false;
			$this->connection->rollback();
		} else {
			throw new NewException("Error DataBase::getInstance()->prepareStatement(): Not connect to database", 0, 8, __FILE__, __LINE__);
		}
	}
	
	public function getLastInsertId() {
		return $this->connection->insert_id;
	}
}
?>
