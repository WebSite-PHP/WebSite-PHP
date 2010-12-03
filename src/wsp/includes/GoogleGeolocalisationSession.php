<?php 
include_once("../config/config.inc.php");
include_once("utils_session.inc.php");
session_name(formalize_to_variable(SITE_NAME)); 
session_start();

if (!isset($_SESSION['google_geolocalisation'])) {
	if ($_GET['latitude']!="undefined" && $_GET['longitude']!="undefined" && $_GET['city']!="undefined" 
		&& $_GET['country']!="undefined" && $_GET['country_code']!="undefined" && $_GET['region']!="undefined") {
		$_SESSION['google_geolocalisation'] = array();
		$_SESSION['google_geolocalisation']['Latitude'] = $_GET['latitude'];
		$_SESSION['google_geolocalisation']['Longitude'] = $_GET['longitude'];
		$_SESSION['google_geolocalisation']['City'] = $_GET['city'];
		$_SESSION['google_geolocalisation']['CountryName'] = $_GET['country'];
		$_SESSION['google_geolocalisation']['CountryCode'] = $_GET['country_code'];
		$_SESSION['google_geolocalisation']['RegionName'] = $_GET['region'];
	} else {
		echo "not all variables set !";
	}
}
?>