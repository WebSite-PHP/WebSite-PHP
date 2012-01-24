<?php 
	function unsetWspAdminVariables() {
		unset($_SESSION['server_wsp_version']);
		unset($_SESSION['user_browscap_version']);
		unset($_SESSION['server_browscap_version']);
		unset($_SESSION['user_try_connect_wsp_admin']);
	}
?>