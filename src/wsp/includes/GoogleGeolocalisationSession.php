<?php 
/**
 * PHP file wsp\includes\GoogleGeolocalisationSession.php
 */
/**
 * WebSite-PHP file GoogleGeolocalisationSession.php
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2015 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 12/05/2015
 * @version     1.2.13
 * @access      public
 * @since       1.0.19
 */

include_once("../config/config.inc.php");
include_once("utils_session.inc.php");
@session_set_cookie_params(0, "/", $_SERVER['SERVER_NAME'], false, true);
@session_name(formalize_to_variable(SITE_NAME));
@session_start();

if (!defined('MAX_SESSION_TIME')) {
    define("MAX_SESSION_TIME", 1800); // 30 min.
}

if (!isset($_SESSION['google_geolocalisation']) || isset($_GET['user_share'])) {
	if ($_GET['latitude']!="undefined" && $_GET['longitude']!="undefined" && $_GET['city']!="undefined" 
		&& $_GET['country']!="undefined" && $_GET['country_code']!="undefined" && $_GET['region']!="undefined") {
        if (isset($_GET['user_share']) && isset($_SESSION['google_geolocalisation']) && isset($_SESSION['google_geolocalisation']['latitude']) &&
            ($_SESSION['google_geolocalisation']['latitude'] >= ($_GET['latitude'] - 0.04) && $_SESSION['google_geolocalisation']['latitude'] <= ($_GET['latitude'] + 0.04)) &&
            ($_SESSION['google_geolocalisation']['longitude'] >= ($_GET['longitude'] - 0.04) && $_SESSION['google_geolocalisation']['longitude'] <= ($_GET['longitude'] + 0.04))) {
                // Update latitude / longitude (city is already correct)
                $_SESSION['google_geolocalisation']['latitude'] = $_GET['latitude'];
                $_SESSION['google_geolocalisation']['longitude'] = $_GET['longitude'];
        } else {
            $_SESSION['google_geolocalisation'] = array();
            $_SESSION['google_geolocalisation']['latitude'] = $_GET['latitude'];
            $_SESSION['google_geolocalisation']['longitude'] = $_GET['longitude'];
            $_SESSION['google_geolocalisation']['cityName'] = $_GET['city'];
            $_SESSION['google_geolocalisation']['countryName'] = $_GET['country'];
            $_SESSION['google_geolocalisation']['countryCode'] = $_GET['country_code'];
            $_SESSION['google_geolocalisation']['regionName'] = $_GET['region'];
        }
		echo "expiresDate = new Date();expiresDate.setTime(expiresDate.getTime() + ((".MAX_SESSION_TIME."-1) * 1000));";
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
	echo "expiresDate = new Date();expiresDate.setTime(expiresDate.getTime() + ((".MAX_SESSION_TIME."-1) * 1000));";
	echo "$.cookie('wsp_geolocalisation_google', 'true', { path: '/', expires: expiresDate });";
}
?>
