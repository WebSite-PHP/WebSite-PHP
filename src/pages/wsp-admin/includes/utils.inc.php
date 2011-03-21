<?php 
	function createTableFirstPagePic64($array_link) {
		$ind = 0;
		$row_table = null;
		$table = new Table(10, 10);
		for ($i=0; $i < sizeof($array_link); $i++) {
			if ($array_link[$i]->getUserHaveRights()) {
				if ($ind % 5 == 0) {
					if ($row_table != null) {
						$table->addRow($row_table);
					}
					$row_width = 20;
					if (sizeof($array_link) < 5) {
						$row_width = 100 / sizeof($array_link);
					}
					$row_table = new RowTable(RowTable::ALIGN_CENTER, $row_width."%");
				}
				$row_table->add($array_link[$i]);
				$ind++;
			}
		}
		if ($row_table != null) {
			$table->addRow($row_table);
		}
		
		return $table;
	}
	
	function getWspUserRightsInfo($login) {
		$passwd_file = new File(dirname(__FILE__)."/../.passwd");
		
		$nodata=true;
		$strAdminLogin = "";
		$strAdminPasswd = "";
		$strAdminRights = "";
		$line = $passwd_file->read_line();
		while ($line != null) {
			$nodata=false;
			if ($line == "login:".$login."\n") {
				$strAdminLogin = $login;
				$strAdminPasswd = str_replace("\n", "", str_replace("passwd:", "", $passwd_file->read_line()));
				$strAdminRights = str_replace("\n", "", str_replace("rights:", "", $passwd_file->read_line()));
				break;
			}
			$line = $passwd_file->read_line();
		}
		
		if ($nodata==true) {
			$strAdminLogin = "admin";
			$strAdminPasswd = sha1("admin");
			$strAdminRights = "administrator";
			
			$passwd_data = "login:".$strAdminLogin."\n";
			$passwd_data .= "passwd:".$strAdminPasswd."\n";
			$passwd_data .= "rights:".$strAdminRights."\n";
			$passwd_file->write($passwd_data);
		}
		$passwd_file->close();
		
		return array($strAdminLogin, $strAdminPasswd, $strAdminRights);
	}
	
	function changeWspUserPassword($login, $old_passwd, $new_passwd, $rights) {
		$status = false;
		$passwd_file = new File(dirname(__FILE__)."/../.passwd");
		$passwd_file->debug_mode(true);
		
		$passwd_data = "";
		$line = $passwd_file->read_line();
		while ($line != null) {
			if ($line == "login:".$login."\n") {
				$passwd_data .= "login:".$login."\n";
				
				$line = $passwd_file->read_line();
				if ($line == "passwd:".sha1($old_passwd)."\n") {
					$passwd_data .= "passwd:".sha1($new_passwd)."\n";
					
					$line = $passwd_file->read_line();
					$passwd_data .= "rights:".$rights."\n";
					
					$status = true;
				}
			} else {
				$data .= $line;
			}
			$line = $passwd_file->read_line();
		}
		$passwd_file->close();
		
		if ($status) {
			$passwd_file = new File(dirname(__FILE__)."/../.passwd", false, true);
			$passwd_file->debug_mode(true);
			$passwd_file->write($passwd_data);
			$passwd_file->close();
			
			return true;
		}
		
		return false;
	}
	
	function getCurrentWspVersion() {
		return file_get_contents(dirname(__FILE__)."/../../../wsp/version.txt");
	}
	
	function isNewWspVersion() {
		$user_wsp_version = getCurrentWspVersion();
		if (!isset($_SESSION['server_wsp_version'])) {
			$client = new WebSitePhpSoapClient("http://www.website-php.com/en/webservices/wsp-information-server.wsdl?wsdl");
			$_SESSION['server_wsp_version'] = $client->getLastVersionNumber();
		}
		if ($user_wsp_version != $_SESSION['server_wsp_version']) {
			return trim($_SESSION['server_wsp_version']);
		}
		return false;
	}
?>