<?php 
/**
 * PHP file wsp\includes\GoogleGeolocalisationSession.php
 */
/**
 * WebSite-PHP file GoogleGeolocalisationSession.php
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2013 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 18/02/2013
 * @version     1.2.2
 * @access      public
 * @since       1.0.19
 */

include_once("../config/config.inc.php");
include_once("utils_session.inc.php");
session_name(formalize_to_variable(SITE_NAME)); 
@session_start();

if (!isset($_SESSION['google_geolocalisation']) || isset($_GET['user_share'])) {
	if ($_GET['latitude']!="undefined" && $_GET['longitude']!="undefined" && $_GET['city']!="undefined" 
		&& $_GET['country']!="undefined" && $_GET['country_code']!="undefined" && $_GET['region']!="undefined") {
		$_SESSION['google_geolocalisation'] = array();
		$_SESSION['google_geolocalisation']['Latitude'] = $_GET['latitude'];
		$_SESSION['google_geolocalisation']['Longitude'] = $_GET['longitude'];
		$_SESSION['google_geolocalisation']['City'] = $_GET['city'];
		$_SESSION['google_geolocalisation']['CountryName'] = $_GET['country'];
		$_SESSION['google_geolocalisation']['CountryCode'] = $_GET['country_code'];
		$_SESSION['google_geolocalisation']['RegionName'] = $_GET['region'];
		echo "expiresDate = new Date();expiresDate.setTime(expiresDate.getTime() + ".((session_cache_expire()-1) * 60 * 1000).");";
		echo "$.cookie('wsp_geolocalisation_google', 'true', { path: '/', expires: expiresDate });";
		
		if (isset($_GET['user_share'])) {
			$_SESSION['geolocalisation_user_share'] = true;
			echo "$.cookie('wsp_geolocalisation_user_share', 'true', { path: '/', expires: expiresDate });";
			if (isset($_SESSION['geolocalisation_user_share_js'])) {
				echo $_SESSION['geolocalisation_user_share_js'];
			}
		}
	} else if (!isset($_GET['user_share'])) {
		echo "/*not all variables set !*/";
	}
} else if (isset($_SESSION['google_geolocalisation'])) {
	echo "expiresDate = new Date();expiresDate.setTime(expiresDate.getTime() + ".((session_cache_expire()-1) * 60 * 1000).");";
	echo "$.cookie('wsp_geolocalisation_google', 'true', { path: '/', expires: expiresDate });";
}
?>
