<?php
/**
 * PHP file pages\wsp-admin\config\configure-database.php
 */
/**
 * Content of the Page configure-database
 * URL: http://127.0.0.1/website-php-install/wsp-admin/config/configure-database.html
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2017 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 11/10/2017
 * @version     1.2.15
 * @access      public
 * @since       1.0.25
 */

require_once(dirname(__FILE__)."/../includes/admin-template-form.inc.php");

class ConfigureDatabase extends Page {
	protected $USER_RIGHTS = Page::RIGHTS_ADMINISTRATOR;
	protected $USER_NO_RIGHTS_REDIRECT = "wsp-admin/admin.html";
	
	private $edtHost = null;
	private $edtPort = null;
	private $edtRoot = null;
	private $edtPassword = null;
	private $edtDatabase = null;
	private $btnValidate = null;
	
	private $objCreateDbClass = null;
	private $form = null;
	private $cmb_databases = null;
	private $cmb_tables = null;
	
	private $dbInstance = null;
	
	function __construct() {
		parent::__construct();
	}
	
	public function Load() {
		parent::$PAGE_TITLE = __(CONFIGURE_DATABASE);
		
		$this->includeJsAndCssFromObjectToPage("ComboBox(\$this)");
		
		// Admin
		$this->form = new Form($this);
		
		$table_form = new Table();
		$table_form->addRow();
		
		$this->edtHost = new TextBox($this->form);
		$this->edtHost->setValue(DB_HOST);
		$edtHostValidation = new LiveValidation();
		$table_form->addRowColumns(__(EDT_HOST).":&nbsp;", $this->edtHost->setLiveValidation($edtHostValidation->addValidatePresence()->setFieldName(__(EDT_HOST))));
		
		$this->edtPort = new TextBox($this->form);
		$this->edtPort->setValue(DB_PORT);
		$edtPortValidation = new LiveValidation();
		$table_form->addRowColumns(__(EDT_PORT).":&nbsp;", $this->edtPort->setLiveValidation($edtPortValidation->addValidateNumericality(true)->setFieldName(__(EDT_PORT))));
		
		$this->edtRoot = new TextBox($this->form);
		$this->edtRoot->setValue(DB_ROOT);
		$edtRootValidation = new LiveValidation();
		$table_form->addRowColumns(__(EDT_ROOT).":&nbsp;", $this->edtRoot->setLiveValidation($edtRootValidation->addValidatePresence()->setFieldName(__(EDT_ROOT))));
		
		$this->edtPassword = new Password($this->form);
		$this->edtPassword->setValue(DB_PASSWORD);
		$table_form->addRowColumns(__(EDT_PASSWORD).":&nbsp;", $this->edtPassword);
		
		$this->edtDatabase = new TextBox($this->form);
		$this->edtDatabase->setValue(DB_DATABASE);
		$table_form->addRowColumns(__(EDT_DATABASE).":&nbsp;", $this->edtDatabase);
		
		$table_form->addRow();
		
		$this->btnValidate = new Button($this->form);
		$this->btnValidate->setValue(__(BTN_VALIDATE))->onClick("configureDatabase")->setAjaxEvent();
		$table_form->addRowColumns($this->btnValidate)->setColumnColspan(1, 2)->setColumnAlign(1, RowTable::ALIGN_CENTER);
		
		$table_form->addRow();
		$table_form->addRow();
		
		$this->form->setContent($table_form);
		$this->render = new AdminTemplateForm($this, $this->form);
		
		// generate database object part
		$this->objCreateDbClass = new Object();
		$this->objCreateDbClass->setId("idCreateDbClass");
		$table_form->addRow($this->objCreateDbClass)->setColspan(2);
		
		$table_gen = new Table();
		$table_gen->addRow(__(GENERATE_DATABASE_OBJECTS))->setColspan(2);
		$table_gen->addRow();
		
		$this->cmb_databases = new ComboBox($this->form);
		$this->cmb_databases->onChange("configureGenDbObject")->setAjaxEvent();
		$table_gen->addRowColumns(__(DATABASES).":&nbsp;", $this->cmb_databases);
		
		$this->cmb_tables = new ComboBox($this->form);
		$table_gen->addRowColumns(__(TABLES).":&nbsp;", $this->cmb_tables);
		
		$table_gen->addRow();
		$btnGenObject = new Button($this->form);
		$btnGenObject->setValue(__(GENERATE_OBJECTS))->onClick("generateDbObject")->setAjaxEvent();
		$table_gen->addRow($btnGenObject)->setColspan(2);
		$table_gen->addRow();
		
		$this->objCreateDbClass->add($table_gen);
		
		// database list
		if ($this->testDbConnexion(null)) {
			$this->loadAllDatabases();
			$this->configureGenDbObject(null);
		}
	}
	
	public function testConnexion($sender) {
		$this->testDbConnexion($sender);
	}
	
	public function testDbConnexion($sender) {
		$this->dbInstance = new DataBase($this->edtHost->getValue()." ", $this->edtRoot->getValue(), $this->edtPassword->getValue(), $this->edtDatabase->getValue(), $this->edtPort->getValue());
		if ($this->dbInstance->connect()) {
			$this->displayCreateDbObjectZone(true);
			return true;
		} else {
			$this->displayCreateDbObjectZone(false);
			return false;
		}
	}
	
	private function displayCreateDbObjectZone($bool) {
		if ($bool) {
			$this->objCreateDbClass->show();
			
			/*$this->edtHost->onChange("testConnexion")->setAjaxEvent()->disableAjaxWaitMessage();
			$this->edtPort->onChange("testConnexion")->setAjaxEvent()->disableAjaxWaitMessage();
			$this->edtRoot->onChange("testConnexion")->setAjaxEvent()->disableAjaxWaitMessage();
			$this->edtPassword->onChange("testConnexion")->setAjaxEvent()->disableAjaxWaitMessage();
			$this->edtDatabase->onChange("testConnexion")->setAjaxEvent()->disableAjaxWaitMessage();*/	
		} else {
			$this->objCreateDbClass->hide();
			
			/*$this->edtHost->onChange("");
			$this->edtPort->onChange("");
			$this->edtRoot->onChange("");
			$this->edtPassword->onChange("");
			$this->edtDatabase->onChange("");*/
		}
	}
	
	private function saveDatabaseConfig() {
		$config_ok = false;
		
		$con = new mysqli($this->edtHost->getValue(), $this->edtRoot->getValue(), $this->edtPassword->getValue(), "", $this->edtPort->getValue());
		if (!mysqli_connect_errno()) {
			if ($this->edtDatabase->getValue() == "" || $con->select_db($this->edtDatabase->getValue())) {
				$con->close();
				
				$data_config_file = "<?php\n";
				$data_config_file .= "define(\"DB_ACTIVE\", true);\n";
				$data_config_file .= "define(\"DB_HOST\", \"".$this->edtHost->getValue()."\");\n";
				$data_config_file .= "define(\"DB_PORT\", \"".$this->edtPort->getValue()."\");\n";
				$data_config_file .= "define(\"DB_ROOT\", \"".$this->edtRoot->getValue()."\");\n";
				$data_config_file .= "define(\"DB_PASSWORD\", \"".$this->edtPassword->getValue()."\");\n";
				$data_config_file .= "define(\"DB_DATABASE\", \"".$this->edtDatabase->getValue()."\");\n";
				$data_config_file .= "?>";
				
				$config_file = new File(dirname(__FILE__)."/../../../wsp/config/config_db.inc.php", false, true);
				if ($config_file->write($data_config_file)) {
					$config_ok = true;
				}
				$config_file->close();
			}
		}
		
		return $config_ok;
	}
	
	public function configureDatabase($sender) {
		if ($this->saveDatabaseConfig()) {
			$this->displayCreateDbObjectZone(true);
			$this->configureGenDbObject(null);
			
			$dialog = new DialogBox(__(CONFIG_FILE), __(CONFIG_FILE_OK));
			$dialog->activateCloseButton();
			$this->addObject($dialog);
		} else {
			$this->displayCreateDbObjectZone(false);
			
			$dialog = new DialogBox(__(CONFIG_FILE), __(CONFIG_FILE_NOT_OK));
			$dialog->activateCloseButton();
			$this->addObject($dialog);
		}
	}
	
	private function loadAllDatabases() {
		$selected_db = $this->cmb_databases->getValue();
		if ($selected_db == "") {
			$selected_db = $this->edtDatabase->getValue();
		}
		$this->cmb_databases->removeItems();
		$query = "SHOW DATABASES";
		$result = $this->dbInstance->prepareStatement($query);
		while ($row = $result->fetch_array()) {
			$this->cmb_databases->addItem($row['Database'], $row['Database'], (strtolower($selected_db) == strtolower($row['Database'])?true:false));
		}
		if ($this->cmb_databases->getSelectedIndex() == -1) {
			$this->cmb_databases->setSelectedIndex(0);
		}
	}
	
	public function configureGenDbObject($sender) {
		$selected_db = $this->cmb_databases->getValue();
		if ($selected_db != "") {
			$this->setTimeout(120);
			
			$selected_table = $this->cmb_tables->getValue();
			$this->cmb_tables->removeItems();
			$this->cmb_tables->addItem("all", __(ALL_TABLES));
			$query = "SHOW TABLES FROM `".$selected_db."`";
			$result = $this->dbInstance->prepareStatement($query);
			while ($row = $result->fetch_array()) {
				$this->cmb_tables->addItem($row['Tables_in_'.$selected_db], $row['Tables_in_'.$selected_db], (strtolower($selected_table) == strtolower($row['Tables_in_'.$selected_db])?true:false));
			}
			if ($this->cmb_tables->getSelectedIndex() == -1) {
				$this->cmb_tables->setSelectedIndex(0);
			}
		} else {
			$dialog = new DialogBox(__(DATABASE), __(NO_DATABASE_SELECTED));
			$dialog->activateCloseButton();
			$this->addObject($dialog);
		}
	}
	
	public function generateDbObject($sender) {
		if ($this->saveDatabaseConfig()) {
			$database = $this->cmb_databases->getValue();
			if ($this->cmb_tables->getValue() == "all") {
				$query = "SHOW TABLES FROM `".$database."`";
				$result = $this->dbInstance->prepareStatement($query);
				while ($row = $result->fetch_array()) {
					$table = $row['Tables_in_'.$database];
					if (($db_key_identifier = $this->generateTableClass($database, $table)) != false) {
						$this->generateWspTableObject($database, $table, $db_key_identifier);
						$this->generateTableObject($database, $table, $db_key_identifier);
						$this->generateTableObjectList($database, $table);
						$dialog = new DialogBox(__(GENERATE_DATABASE_OBJECTS_TITLE), __(GENERATE_DATABASE_OBJECTS_OK, $database));
					} else {
						$dialog = new DialogBox(__(GENERATE_DATABASE_OBJECTS_TITLE), __(GENERATE_DATABASE_OBJECTS_ERROR, $database));
					}
				}
			} else {
				$table = $this->cmb_tables->getValue();
				if (($db_key_identifier = $this->generateTableClass($database, $table)) != false) {
					$this->generateWspTableObject($database, $table, $db_key_identifier);
					$this->generateTableObject($database, $table, $db_key_identifier);
					$this->generateTableObjectList($database, $table);
					$dialog = new DialogBox(__(GENERATE_DATABASE_OBJECTS_TITLE), __(GENERATE_DATABASE_OBJECTS_OK, $database.".".$table));
				} else {
					$dialog = new DialogBox(__(GENERATE_DATABASE_OBJECTS_TITLE), __(GENERATE_DATABASE_OBJECTS_ERROR, $database.".".$table));
				}
			}
			if ($dialog == null) {
				$dialog = new DialogBox(__(GENERATE_DATABASE_OBJECTS_TITLE), __(GENERATE_DATABASE_OBJECTS_ERROR, ""));
			}
			$dialog->activateCloseButton();
			$this->addObject($dialog);
		} else {
			$this->displayCreateDbObjectZone(false);
			
			$dialog = new DialogBox(__(CONFIG_FILE), __(CONFIG_FILE_NOT_OK));
			$dialog->activateCloseButton();
			$this->addObject($dialog);
		}
	}
	
	private function getFormatValue($table) {
		$table_tmp = str_replace("_", "-", formalize_to_variable($table));
		$table_names = explode('-', $table_tmp);
		$class_name = "";
		for ($i=0; $i < sizeof($table_names); $i++) {
			$class_name .= ucfirst($table_names[$i]);
		}
		return $class_name;
	}
	
	private function getTableFieldVariable($field) {
		return strtoupper(formalize_to_variable($field));
	}
	
	private function convertFieldTypeToWspType($type) {
		$pos = find($type, "(", 0, 0);
		if ($pos > 0) {
			$type=substr($type, 0, $pos-1);
		}
		$type = strtolower($type);
		if (in_array($type, array("char", "varchar", "text", "tinytext", "mediumtext", "longtext", "enum", "set", "bit"))) {
			return "string";
		} else if (in_array($type, array("tinyblob", "blob", "mediumblob", "longblob"))) {
			return "binary";
		} else if (in_array($type, array("int", "integer", "smallint", "mediumint", "bigint"))) {
			return "integer";
		} else if (in_array($type, array("float", "double", "real", "decimal", "numeric"))) {
			return "double";
		} else if (in_array($type, array("bool", "tinyint"))) {
			return "boolean";
		} else if (in_array($type, array("date", "time", "timestamp", "datetime", "year"))) {
			return "datetime";
		} else {
			return $type;
		}
	}
	
	private function generateTableClass($database, $table) {
		$class_name = $this->getFormatValue($table);
		
		$is_primary = false;
		$is_unique_key = false;
		$const = "";
		$attr = "";
		$attr_type = "";
		$attr_key = "";
		$attr_unique_key = "";
		$db_key_identifier = "PRI";
		$auto_increment_var = "";
		
		$query = "SHOW COLUMNS FROM `".$database."`.`".$table."`";
		$result = $this->dbInstance->prepareStatement($query);
		while ($row = $result->fetch_array()) {
			$wsp_field = "FIELD_".$this->getTableFieldVariable($row['Field']);
			$const .= "	const ".$wsp_field." = \"".$row['Field']."\";\n";
			if ($attr != "") { $attr .= ", "; }
			$attr .= $class_name."DbTable::".$wsp_field;
			if ($attr_type != "") { $attr_type .= ", "; }
			$attr_type .= "\"".$this->convertFieldTypeToWspType($row['Type'])."\"";
			
			if ($row['Key'] == "PRI") {
				if ($attr_key != "") { $attr_key .= ", "; }
				$attr_key .= $class_name."DbTable::".$wsp_field;
				$is_primary = true;
			} else if ($row['Key'] == "MUL") {
				if ($attr_unique_key != "") { $attr_unique_key .= ", "; }
				$attr_unique_key .= $class_name."DbTable::".$wsp_field;
				$is_unique_key = true;
			}
			
			if ($row['Extra'] == "auto_increment") {
				$auto_increment_var = $row['Field'];
			}
		}
		if (!$is_primary && $is_unique_key) {
			$attr_key = $attr_unique_key;
			$db_key_identifier = "MUL";
		}
		
		if (!$is_primary && !$is_unique_key) {
			$dialog = new DialogBox(__(PRIMARY_KEY), __(NO_PRIMARY_KEY, $database, $table));
			$dialog->activateCloseButton();
			$this->addObject($dialog);
			return false;
		}
		
		$attr_foreign_key = "";
		$query = "SELECT column_name, referenced_table_schema, referenced_table_name, referenced_column_name
					FROM INFORMATION_SCHEMA.key_column_usage 
					WHERE referenced_table_schema = '".$database."' 
					  AND table_name = '".$table."'
					  AND referenced_table_name IS NOT NULL 
					ORDER BY table_name, column_name";
		$stmt = $this->dbInstance->prepareStatement($query);
		$row = DataBase::getInstance()->stmtBindAssoc($stmt, $row);
		while ($stmt->fetch()) {
			if ($attr_foreign_key != "") { $attr_foreign_key .= ", "; }
			$attr_foreign_key .= "'".$row['column_name']."' => array('table' => '`".$row['referenced_table_schema']."`.`".$row['referenced_table_name']."`', 'column' => '`".$row['referenced_column_name']."`')";
		}
		$attr_foreign_key = "array(".$attr_foreign_key.")";
		
		$data = "<?php
class ".$class_name."DbTable extends DbTableObject {
	/**#@-*/
".$const."
	
	const SCHEMA_NAME = \"".$database."\";
	const TABLE_NAME = \"".$table."\";
	/**#@-*/
	
	function __construct() {
		parent::__construct();
		
		\$this->setDbSchemaName(".$class_name."DbTable::SCHEMA_NAME);
		\$this->setDbTableName(".$class_name."DbTable::TABLE_NAME);
		\$this->setDbTableAttributes(array(".$attr."));
		\$this->setDbTableAttributesType(array(".$attr_type."));
		\$this->setDbTablePrimaryKeys(array(".$attr_key."));
		\$this->setDbTableAutoIncrement(".($auto_increment_var==""?"''":$class_name."DbTable::FIELD_".$this->getTableFieldVariable($auto_increment_var)).");
		\$this->setDbTableForeignKeys(".$attr_foreign_key.");
	}
}
?>";
		$file = new File(dirname(__FILE__)."/../../../wsp/class/database_object/".$class_name."DbTable.class.php", false, true);
		$file->write($data);
		$file->close();
		
		return $db_key_identifier;
	}
	
	private function generateWspTableObject($database, $table, $db_key_identifier="PRI") {
		$class_name = $this->getFormatValue($table);
		
		$array_var = array();
		$array_var_key = array();
		$private_var = "";
		$construct_param = "";
		$construct_key_param = "";
		$key_param = "";
		$isset_key_param = "";
		$load_clause = "";
		$load_clause_obj = "";
		$auto_increment_var = "";
		
		$query = "SHOW COLUMNS FROM `".$database."`.`".$table."`";
		$result = $this->dbInstance->prepareStatement($query);
		while ($row = $result->fetch_array()) {
			$var = strtolower($this->getTableFieldVariable($row['Field']));
			$array_var[] = $var;
			$var_type = $this->convertFieldTypeToWspType($row['Type']);
			$array_var_type[] = $var_type;
			if ($row['Default'] != null) {
				if ($var_type == "integer" || $var_type == "double" || $var_type == "boolean") {
					$private_var .= "	private \$".$var." = ".$row['Default'].";\n";
				} else if ($var_type == "datetime") {
					$private_var .= "	private \$".$var." = new DateTime('".$row['Default']."');\n";
				} else {
					$private_var .= "	private \$".$var." = \"".str_replace("\"", "\\\"", $row['Default'])."\";\n";
				}
			} else {
				$private_var .= "	private \$".$var." = null;\n";
			}
			
			if ($row['Extra'] == "auto_increment") {
				$auto_increment_var = $var;
			}
			
			if ($row['Key'] == $db_key_identifier) { // primary key or unique key
				$array_var_key[] = $var;
				
				if ($key_param != "") { $key_param .= ", "; }
				$key_param .= "\$".$var;
				
				if ($construct_key_param != "") { $construct_key_param .= ", "; }
				$construct_key_param .= "\$".$var."=''";
				
				if ($isset_key_param != "") { $isset_key_param .= " && "; }
				$isset_key_param .= "\$".$var." != \"\"";
				
				if ($load_clause != "") { $load_clause .= ".\" AND \"."; }
				$load_clause .= "\"`\".".$class_name."DbTable::FIELD_".$this->getTableFieldVariable($row['Field']).".\"`='\".addslashes(\$".$var.").\"'\"";
				
				if ($load_clause_obj != "") { $load_clause_obj .= ".\" AND \"."; }
				$load_clause_obj .= "\"`\".".$class_name."DbTable::FIELD_".$this->getTableFieldVariable($row['Field']).".\"`='\".addslashes(\$this->get".$this->getFormatValue($var)."()).\"'\"";
			} else {
				if ($construct_param != "") { $construct_param .= ", "; }
				$construct_param .= "\$".$var."=''";
			}
		}
		if ($key_param != "") { $key_param .= ", "; }
		$key_param .= "\$activate_htmlentities";
		
		if ($construct_param != "") { $construct_key_param .= ", "; }
		$construct_param = $construct_key_param.$construct_param;
		if ($construct_param != "") { $construct_param .= ", "; }
		$construct_param .= "\$activate_htmlentities=false";
		
		$data = "<?php
class ".$class_name."WspObject {
	/**#@-
	* @access private
	* @var string
	*/
".$private_var."
	private \$is_synchronize_with_db = false;
	private \$is_db_object = false;
	private \$activate_htmlentities = false;
	/**#@-*/

	function __construct(".$construct_param.") {
		if (".$isset_key_param.") {
			\$this->load(".$key_param.");
		}
		if (!\$this->is_db_object) {\n";
			for ($i=0; $i < sizeof($array_var); $i++) {
				if (in_array($array_var[$i], $array_var_key)) {
					$data .= "			if (\$this->".$array_var[$i]." == \"\") {\n	";
				}
				$data .= "			\$this->set".$this->getFormatValue($array_var[$i])."(\$".$array_var[$i].");\n";
				if (in_array($array_var[$i], $array_var_key)) {
					$data .= "			}\n";
				}
			}
$data .= "		}
	}
	
	/**
	 * Method load
	 * @access public
	 * @return ".$class_name."Obj
	 */
	public function load(".$key_param."=false) {
		\$this->activate_htmlentities = \$activate_htmlentities;
		\$sql = new SqlDataView(new ".$class_name."DbTable());
		\$sql->setClause(".$load_clause.");
		if (\$activate_htmlentities) {
			\$sql->enableHtmlentitiesMode();
		}
		\$it = \$sql->retrieve();
		if (\$it->getRowsNum() > 1) {
			throw new NewException(\"".$class_name."WspObject->load(): too many rows returned\", 0, getDebugBacktrace(1));
		} else {
			if (\$it->hasNext()) {
				\$row = \$it->next();\n";
			for ($i=0; $i < sizeof($array_var); $i++) {
				$data .= "				\$this->set".$this->getFormatValue($array_var[$i])."(\$row->getValue(".$class_name."DbTable::FIELD_".$this->getTableFieldVariable($array_var[$i])."));\n";
			}
			$data .= "				\$this->is_synchronize_with_db = true;
				\$this->is_db_object = true;
			} else {\n";
			for ($i=0; $i < sizeof($array_var_key); $i++) {
				$data .= "				\$this->set".$this->getFormatValue($array_var_key[$i])."(\$".$array_var_key[$i].");\n";
			}
		$data .= "				\$this->is_synchronize_with_db = false;
				\$this->is_db_object = false;
			}
		}
		return \$this;
	}
	
	/**
	 * Method loadClause
	 * @access public
	 * @return ".$class_name."Obj
	 */
	public function loadClause(\$clause, \$activate_htmlentities=false) {
		\$this->activate_htmlentities = \$activate_htmlentities;
		\$sql = new SqlDataView(new ".$class_name."DbTable());
		\$sql->setClause(\$clause);
		if (\$activate_htmlentities) {
			\$sql->enableHtmlentitiesMode();
		}
		\$it = \$sql->retrieve();
		if (\$it->getRowsNum() > 1) {
			throw new NewException(\"".$class_name."WspObject->loadClause(): too many rows returned\", 0, getDebugBacktrace(1));
		} else {
			if (\$it->hasNext()) {
				\$row = \$it->next();\n";
			for ($i=0; $i < sizeof($array_var); $i++) {
				$data .= "				\$this->set".$this->getFormatValue($array_var[$i])."(\$row->getValue(".$class_name."DbTable::FIELD_".$this->getTableFieldVariable($array_var[$i])."));\n";
			}
			$data .= "				\$this->is_synchronize_with_db = true;
				\$this->is_db_object = true;
			} else {
				\$this->is_synchronize_with_db = false;
				\$this->is_db_object = false;
			}
		}
		return \$this;
	}
	
	/**
	 * Method save
	 * @access public
	 * @return ".$class_name."Obj
	 */
	public function save() {
		\$transaction_begin_now = DataBase::getInstance()->beginTransaction();
		\$sql = new SqlDataView(new ".$class_name."DbTable());
		\$sql->setClause(".$load_clause_obj.");
		\$it = \$sql->retrieve();
		if (\$it->getRowsNum() > 1) {
			throw new NewException(\"".$class_name."WspObject->save(): too many rows returned\", 0, getDebugBacktrace(1));
		} else {
			\$insert = false;
			if (\$it->hasNext()) {
				\$row = \$it->next();
			} else {
				\$row = \$it->insert();\n";
				for ($i=0; $i < sizeof($array_var_key); $i++) {
					$data .= "				\$row->setValue(".$class_name."DbTable::FIELD_".$this->getTableFieldVariable($array_var_key[$i]).", \$this->get".$this->getFormatValue($array_var_key[$i])."());\n";
				}
				$data .= "				\$insert = true;\n";
			$data .= "			}\n";
			for ($i=0; $i < sizeof($array_var); $i++) {
				if (!in_array($array_var[$i], $array_var_key)) {
					$data .= "			\$row->setValue(".$class_name."DbTable::FIELD_".$this->getTableFieldVariable($array_var[$i]).", \$this->get".$this->getFormatValue($array_var[$i])."());\n";
				}
			}
			$data .= "			\$it->save();\n";
			if ($auto_increment_var != "") {
				$data .= "			if (\$insert) {
				\$this->".$auto_increment_var." = \"\";
				\$this->set".$this->getFormatValue($auto_increment_var)."(DataBase::getInstance()->getLastInsertId());
			}\n";
			}
			$data .= "			if (\$transaction_begin_now) {
				DataBase::getInstance()->commitTransaction();
			}
			
			\$this->is_synchronize_with_db = true;
			\$this->is_db_object = true;
			
			return \$this;
		}
	}
	
	/**
	 * Method delete
	 * @access public
	 */
	public function delete() {
		\$transaction_begin_now = DataBase::getInstance()->beginTransaction();
		\$sql = new SqlDataView(new ".$class_name."DbTable());
		\$sql->setClause(".$load_clause_obj.");
		\$it = \$sql->retrieve();
		if (\$it->getRowsNum() > 1) {
			throw new NewException(\"".$class_name."WspObject->delete(): too many rows returned\", 0, getDebugBacktrace(1));
		} else {
			if (\$it->hasNext()) {
				\$row = \$it->next();
				\$row->delete();
				\$it->save();
			}
			if (\$transaction_begin_now) {
				DataBase::getInstance()->commitTransaction();
			}
			
			\$this->is_synchronize_with_db = false;
			\$this->is_db_object = false;
		}
	}
	
	/**
	 * Method copy
	 * @access public
	 * @return ".$class_name."Obj
	 */
	public function copy() {
		\$new_obj = new ".$class_name."Obj();\n";
		for ($i=0; $i < sizeof($array_var); $i++) {
			$data .= "		\$new_obj->set".$this->getFormatValue($array_var[$i])."(\$this->get".$this->getFormatValue($array_var[$i])."());\n";
		}
		$data .= "		return \$new_obj;
	}
";
		for ($i=0; $i < sizeof($array_var); $i++) {
			$data .= "\n	/**
	 * Method get".$this->getFormatValue($array_var[$i])."
	 * @access public
	 */
	public function get".$this->getFormatValue($array_var[$i])."() {\n";
	/*if ($array_var_type[$i] == "string") {
		$data .= "		if (\$this->activate_htmlentities) {
			return \$this->".$array_var[$i].";
		} else {
			return utf8_encode(\$this->".$array_var[$i].");
		}\n";
	} else {*/
		$data .= "		return \$this->".$array_var[$i].";\n";
	//}
	$data .= "	}

	";
	$data .= "/**
	 * Method set".$this->getFormatValue($array_var[$i])."
	 * @access public
	 * @return ".$class_name."Obj
	 */
	public function set".$this->getFormatValue($array_var[$i])."(\$".$array_var[$i].") {\n";
	if (in_array($array_var[$i], $array_var_key)) {
		$data .= "		if (\$this->is_db_object) {
			throw new NewException(\"".$class_name."WspObject->set".$this->getFormatValue($array_var[$i])."(): you can't change the value of the key ".$array_var[$i].".\", 0, getDebugBacktrace(1));
		}\n";
	}
	if ($array_var_type[$i] == "datetime") {
		$data .= "		if (\$".$array_var[$i]." == null || \$".$array_var[$i]." == '') {
			\$this->".$array_var[$i]." = \$".$array_var[$i].";
		} else if (gettype(\$".$array_var[$i].") != \"object\" || get_class(\$".$array_var[$i].") != \"DateTime\") {
			\$".$array_var[$i]." = new DateTime(\$".$array_var[$i].");
		}\n";
	}
	$data .= "		\$this->".$array_var[$i]." = \$".$array_var[$i].";
		\$this->is_synchronize_with_db = false;
		return \$this;
	}
";
		}

$data .= "	/**
	 * Method isSynchronizeWithDb
	 * @access public
	 * @return boolean
	 */
	public function isSynchronizeWithDb() {
		return \$this->is_synchronize_with_db;
	}

	/**
	 * Method isDbObject
	 * @access public
	 * @return boolean
	 */
	public function isDbObject() {
		return \$this->is_db_object;
	}
	
	/**
	 * Method foreignKeyLoadMode
	 * @access public
	 * @return ".$class_name."Obj
	 */
	public function foreignKeyLoadMode() {
		\$this->is_db_object = true;
		\$this->is_synchronize_with_db = true;
	}
	
	/**
	 * Method __toString
	 * @access public
	 * @return string
	 */
	public function __toString() {
		return serialize(\$this);
	}
";
		
		$array_code_table1 = array();
		$array_code_table_var1 = array();
		$array_code_table2 = array();
		$array_code_table_var2 = array();
		$query = "SELECT table_schema, table_name, column_name, referenced_table_name, referenced_column_name
					FROM INFORMATION_SCHEMA.key_column_usage 
					WHERE referenced_table_schema = '".$database."' 
					  AND (table_name = '".$table."' OR referenced_table_name = '".$table."')
					  AND referenced_table_name IS NOT NULL 
					ORDER BY table_name, column_name";
		$stmt = $this->dbInstance->prepareStatement($query);
		$row = DataBase::getInstance()->stmtBindAssoc($stmt, $row);
			while ($stmt->fetch()) {
				if ($row['table_name'] == $table) {
					if (!is_array($array_code_table_var1[$this->getFormatValue($row['referenced_table_name'])])) {
						$array_code_table_var1[$this->getFormatValue($row['referenced_table_name'])] = array();
					}
					$array_code_table_var1[$this->getFormatValue($row['referenced_table_name'])][] = $row['referenced_column_name']." = '\".addslashes(\$this->get".$this->getFormatValue($row['column_name'])."()).\"'";
					if (!isset($array_code_table1[$this->getFormatValue($row['referenced_table_name'])])) {
						$data_table = "\n	/**
	 * Method get".$this->getFormatValue($row['referenced_table_name'])."Object
	 * @access public
	 * @param boolean \$activate_htmlentities [default value: false]
	 * @return ".$this->getFormatValue($row['referenced_table_name'])."Obj
	 */
	public function get".$this->getFormatValue($row['referenced_table_name'])."Object(\$activate_htmlentities=false) {
		\$obj_".str_replace("-", "_", strtolower($row['referenced_table_name']))." = new ".$this->getFormatValue($row['referenced_table_name'])."Obj();
		return \$obj_".str_replace("-", "_", strtolower($row['referenced_table_name']))."->loadClause(\"/* #!#get_object_array_".$this->getFormatValue($row['referenced_table_name'])."_key#!# */\", \$activate_htmlentities);
	}
";
						$array_code_table1[$this->getFormatValue($row['referenced_table_name'])] = $data_table;
					}
				} else {
					if (!is_array($array_code_table_var2[$this->getFormatValue($row['table_name'])])) {
						$array_code_table_var2[$this->getFormatValue($row['table_name'])] = array();
					}
					$array_code_table_var2[$this->getFormatValue($row['table_name'])][] = $row['column_name']." = '\".addslashes(\$this->get".$this->getFormatValue($row['referenced_column_name'])."()).\"'";
					if (!isset($array_code_table2[$this->getFormatValue($row['table_name'])])) {
						$data_table = "\n	/**
	 * Method get".$this->getFormatValue($row['table_name'])."ObjectArray
	 * @access public
	 * @param string \$clause [default value: ]
	 * @param string \$sort_attribut [default value: ]
	 * @param string \$sort_order [default value: ASC]
	 * @param integer \$limit_offset [default value: 0]
	 * @param integer \$limit_row_count [default value: 0]
	 * @param boolean \$activate_htmlentities [default value: false]
	 * @return ".$this->getFormatValue($row['table_name'])."Obj[]
	 */
	public function get".$this->getFormatValue($row['table_name'])."ObjectArray(\$clause='', \$sort_attribut='', \$sort_order='ASC', \$limit_offset=0, \$limit_row_count=0, \$activate_htmlentities=false) {
		\$array_".str_replace("-", "_", strtolower($row['table_name']))." = array();
		
		\$sql = new SqlDataView(new ".$this->getFormatValue($row['table_name'])."DbTable());
		\$sql->setClause(\"/* #!#get_object_array_".$this->getFormatValue($row['table_name'])."_key#!# */\".(\$clause!=''?\" AND \".\$clause:\"\"));
		if (\$sort_attribut != '') {
			if (is_array(\$sort_attribut)) {
				for (\$i=0; \$i < sizeof(\$sort_attribut); \$i++) {
					\$sql->addOrder(\$sort_attribut[\$i], \$sort_order[\$i]);
				}
			} else {
				\$sql->addOrder(\$sort_attribut, \$sort_order);
			}
		}
		if (\$limit_row_count > 0) {
			\$sql->setLimit(\$limit_offset, \$limit_row_count);
		}
		if (\$activate_htmlentities) {
			\$sql->enableHtmlentitiesMode();
		}
		\$it = \$sql->retrieve();
		while (\$it->hasNext()) {
			\$row = \$it->next();
			\$obj_".str_replace("-", "_", strtolower($row['table_name']))." = new ".$this->getFormatValue($row['table_name'])."Obj();\n";
			$query2 = "SHOW COLUMNS FROM `".$row['table_schema']."`.`".$row['table_name']."`";
			$result2 = $this->dbInstance->prepareStatement($query2);
			while ($row2 = $result2->fetch_array()) {
				$data_table .= "			\$obj_".str_replace("-", "_", strtolower($row['table_name']))."->set".$this->getFormatValue(strtolower($row2['Field']))."(\$row->getValue(".$this->getFormatValue($row['table_name'])."DbTable::FIELD_".$this->getTableFieldVariable($row2['Field'])."));\n";
			}
			$data_table .= "			\$obj_".str_replace("-", "_", strtolower($row['table_name']))."->foreignKeyLoadMode();
			\$array_".str_replace("-", "_", strtolower($row['table_name']))."[] = \$obj_".str_replace("-", "_", strtolower($row['table_name'])).";
		}
		
		return \$array_".str_replace("-", "_", strtolower($row['table_name'])).";
	}
";
					$array_code_table2[$this->getFormatValue($row['table_name'])] = $data_table;
				}
			}
		}
		
		foreach ($array_code_table1 as $key => $value) {
			$get_object_array_table_key = "";
			for ($i=0; $i < sizeof($array_code_table_var1[$key]); $i++) {
				if ($i > 0) { $get_object_array_table_key .= " AND "; }
				$get_object_array_table_key .= $array_code_table_var1[$key][$i];
			}
			$data .= str_replace("/* #!#get_object_array_".$key."_key#!# */", $get_object_array_table_key, $value);
		}
		
		foreach ($array_code_table2 as $key => $value) {
			$get_object_array_table_key = "";
			for ($i=0; $i < sizeof($array_code_table_var2[$key]); $i++) {
				if ($i > 0) { $get_object_array_table_key .= " AND "; }
				$get_object_array_table_key .= $array_code_table_var2[$key][$i];
			}
			$data .= str_replace("/* #!#get_object_array_".$key."_key#!# */", $get_object_array_table_key, $value);
		}
		
		$data .= "}\n?>";
		
		$file = new File(dirname(__FILE__)."/../../../wsp/class/database_model/wsp/".$class_name."WspObject.class.php", false, true);
		$file->write($data);
		$file->close();
	}
	
	private function generateTableObject($database, $table, $db_key_identifier="PRI") {
		$class_name = $this->getFormatValue($table);
		if (!file_exists(dirname(__FILE__)."/../../../wsp/class/database_model/".$class_name."Obj.class.php")) {
			$construct_param = "";
			$construct_key_param = "";
			$params = "";
			$key_params = "";
			
			$query = "SHOW COLUMNS FROM `".$database."`.`".$table."`";
			$result = $this->dbInstance->prepareStatement($query);
			while ($row = $result->fetch_array()) {
				$var = strtolower($this->getTableFieldVariable($row['Field']));
				
				if ($row['Key'] == $db_key_identifier) { // primary key or unique key
					if ($construct_key_param != "") { $construct_key_param .= ", "; }
					$construct_key_param .= "\$".$var."=''";
					if ($key_params != "") { $key_params .= ", "; }
					$key_params .= "\$".$var;
				} else {
					if ($construct_param != "") { $construct_param .= ", "; }
					$construct_param .= "\$".$var."=''";
					if ($params != "") { $params .= ", "; }
					$params .= "\$".$var;
				}
			}
			if ($key_params != "") {
				$params = $key_params.", ".$params;
			}
			
			if ($construct_param != "") { $construct_key_param .= ", "; }
			$construct_param = $construct_key_param.$construct_param;
			if ($construct_param != "") { $construct_param .= ", "; }
			$construct_param .= "\$activate_htmlentities=false";
			
			$data = "<?php
	class ".$class_name."Obj extends ".$class_name."WspObject {
		
		function __construct(".$construct_param.") {
			parent::__construct(".$params.", \$activate_htmlentities);
		}
	}
?>";
			$file = new File(dirname(__FILE__)."/../../../wsp/class/database_model/".$class_name."Obj.class.php", false, true);
			$file->write($data);
			$file->close();
		}
	}
	
	private function generateTableObjectList($database, $table) {
		$class_name = $this->getFormatValue($table);
		$data = "<?php
	class ".$class_name."ObjList {
		
		function __construct() {
		}
		
		/**
		 * Method get".$class_name."ObjectArray
		 * @access public
		 * @param string \$clause
		 * @param string \$sort_attribut [default value: ]
		 * @param string \$sort_order [default value: ASC]
		 * @param integer \$limit_offset [default value: 0]
		 * @param integer \$limit_row_count [default value: 0]
		 * @param boolean \$activate_htmlentities [default value: false]
		 * @return ".$class_name."Obj[]
		 */
		public function get".$class_name."ObjectArray(\$clause, \$sort_attribut='', \$sort_order='ASC', \$limit_offset=0, \$limit_row_count=0, \$activate_htmlentities=false) {
			\$array_".str_replace("-", "_", strtolower($class_name))." = array();
			
			\$sql = new SqlDataView(new ".$class_name."DbTable());
			\$sql->setClause(\$clause);
			if (\$sort_attribut != '') {
				if (is_array(\$sort_attribut)) {
					for (\$i=0; \$i < sizeof(\$sort_attribut); \$i++) {
						\$sql->addOrder(\$sort_attribut[\$i], \$sort_order[\$i]);
					}
				} else {
					\$sql->addOrder(\$sort_attribut, \$sort_order);
				}
			}
			if (\$limit_row_count > 0) {
				\$sql->setLimit(\$limit_offset, \$limit_row_count);
			}
			if (\$activate_htmlentities) {
				\$sql->enableHtmlentitiesMode();
			}
			\$it = \$sql->retrieve();
			while (\$it->hasNext()) {
				\$row = \$it->next();
				\$obj_".str_replace("-", "_", strtolower($class_name))." = new ".$this->getFormatValue($class_name)."Obj();\n";
			$query2 = "SHOW COLUMNS FROM `".$database."`.`".$table."`";
			$result2 = $this->dbInstance->prepareStatement($query2);
			while ($row2 = $result2->fetch_array()) {
				$data .= "				\$obj_".str_replace("-", "_", strtolower($class_name))."->set".$this->getFormatValue(strtolower($row2['Field']))."(\$row->getValue(".$this->getFormatValue($class_name)."DbTable::FIELD_".$this->getTableFieldVariable($row2['Field'])."));\n";
			}
			$data .= "				\$array_".str_replace("-", "_", strtolower($class_name))."[] = \$obj_".str_replace("-", "_", strtolower($class_name)).";
			}
			
			return \$array_".str_replace("-", "_", strtolower($class_name)).";
		}
		
		/**
		 * Method count".$class_name."
		 * @access public
		 * @param string \$clause
		 * @param boolean \$activate_htmlentities [default value: false]
		 * @return \$count (nb of ".$class_name." respecting \$clause)
		 */
		public function count".$class_name."(\$clause, \$activate_htmlentities=false) {
			\$sql = new SqlDataView(new ".$class_name."DbTable());
			\$sql->setClause(\$clause);
			if (\$activate_htmlentities) {
				\$sql->enableHtmlentitiesMode();
			}
			return \$sql->retrieveCount();
		}
	}
?>";
		$file = new File(dirname(__FILE__)."/../../../wsp/class/database_model/".$class_name."ObjList.class.php", false, true);
		$file->write($data);
		$file->close();
	}
}
?>
