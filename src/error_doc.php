<?php
include_once(dirname(__FILE__)."/wsp/includes/utils.inc.php");

$_GET['error-redirect'] = "";
if (isset($_GET['error'])) {
	$_GET['error-redirect'] = $_GET['error'];
}

$http_type = "";
if ($_SERVER['SERVER_PORT'] == 443) {
	$current_url = $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
	$http_type = "https://";
} else {
	$port = "";
	if ($_SERVER['SERVER_PORT'] != 80 &&  $_SERVER['SERVER_PORT'] != "") {
		$port = ":".$_SERVER['SERVER_PORT'];
	}
	$current_url = $_SERVER['SERVER_NAME'].$port.$_SERVER['REQUEST_URI'];
	$http_type = "http://";
}

// define the base URL of the website
$my_base_url = "";
$array_cwd = explode('/',  str_replace('\\', '/', getcwd()));
$wsp_folder_name = $array_cwd[sizeof($array_cwd)-1];

$array_current_url = explode('/', $current_url);
for ($i=sizeof($array_current_url)-2; $i >= 0; $i--) {
	if ($array_current_url[$i] == $wsp_folder_name) {
		$my_base_url = $http_type;
		for ($j=0; $j <= $i; $j++) {
			$my_base_url .= $array_current_url[$j]."/";
		}
		break;
	}
}
if ($my_base_url == "") {
	$my_base_url = $http_type.$array_current_url[0]."/";
}
$current_url = $http_type.$current_url;

if (isset($_GET['url'])) {
	$_GET['error-redirect-url'] = $_GET['url'];
} else {
	$_GET['error-redirect-url'] = $current_url;
}

$my_param_url = "error-page.html?error-redirect=".$_GET['error-redirect']."&error-redirect-url=".urlencode($_GET['error-redirect-url'])."&error-redirect-referer=".urlencode($_SERVER['HTTP_REFERER']);

header('HTTP/1.1 301 Moved Temporarily');  
header('Status: 301 Moved Temporarily');  
if (isset($_SESSION['lang']) || isset($_GET['l'])) {
	if (isset($_SESSION['lang'])) {
		header("Location:".$my_base_url.$_SESSION['lang']."/".$my_param_url);
	} else {
		header("Location:".$my_base_url.$_GET['l']."/".$my_param_url);
	}
} else {
	header("Location:".$my_base_url.$my_param_url);
}
exit;
?>
