<?php 
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
	
	function changeWspUser($login, $old_passwd, $new_passwd, $rights, $add_user=false, $del_user=false) {
		$status = false;
		$passwd_file = new File(dirname(__FILE__)."/../.passwd");
		$passwd_file->debug_mode(true);
		
		$passwd_data = "";
		$line = $passwd_file->read_line();
		while ($line != null) {
			if ($line == "login:".$login."\n") {
				if (!$del_user) { $passwd_data .= "login:".$login."\n"; }
				if ($add_user) { $status = true; }
				
				$line = $passwd_file->read_line();
				if ($line == "passwd:".sha1($old_passwd)."\n" || $del_user) {
					if (!$del_user) { $passwd_data .= "passwd:".sha1($new_passwd)."\n"; }
					
					$line = $passwd_file->read_line();
					if (!$del_user) { $passwd_data .= "rights:".$rights."\n"; }
					
					$status = true;
				} else {
					$passwd_data .= $line;
					$passwd_data .= $passwd_file->read_line();
				}
			} else {
				$passwd_data .= $line;
			}
			$line = $passwd_file->read_line();
		}
		$passwd_file->close();
		
		if ($add_user) {
			if ($status) {
				$status = false;
			} else {
				$passwd_data .= "login:".$login."\n";
				$passwd_data .= "passwd:".sha1($new_passwd)."\n";
				$passwd_data .= "rights:".$rights."\n";
				$status = true;
			}
		}
		
		if ($status) {
			$passwd_file = new File(dirname(__FILE__)."/../.passwd", false, true);
			$passwd_file->debug_mode(true);
			$passwd_file->write($passwd_data);
			$passwd_file->close();
			
			return true;
		}
		
		return false;
	}
	
	function getAllWspUsers() {
		$passwd_file = new File(dirname(__FILE__)."/../.passwd");
		
		$i = 0;
		$array_users = array();
		$line = $passwd_file->read_line();
		while ($line != null) {
			if (find($line, "login:") > 0) {
				$array_users[$i] = array();
				$array_users[$i]['login'] = trim(str_replace("login:", "", $line));
				$line = $passwd_file->read_line();
				$line = $passwd_file->read_line();
				$array_users[$i]['rights'] = trim(str_replace("rights:", "", $line));
				$i++;
			}
			$line = $passwd_file->read_line();
		}
		
		return $array_users;
	}
?>