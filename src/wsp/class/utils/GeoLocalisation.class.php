<?php
/**
 * Description of PHP file wsp\class\utils\GeoLocalisation.class.php
 * Class GeoLocalisation
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2011 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 03/10/2010
 *
 * @version     1.0.40
 * @access      public
 * @since       1.0.16
 */

/**
* IPInfoDB geolocation API class
* http://ipinfodb.com/ip_location_api.php
*/
class GeoLocalisation {
	protected $errors = array();
	protected $_ip = "";
	protected $_geolocation = "";
  protected $_loaded = false;
	protected $showTimezone = false;
	
	protected $service = 'api.ipinfodb.com';
	protected $version = 'v2';
	protected $apiKey = '';

	/**
	 * Constructor GeoLocalisation
	 */
	public function __construct(){}

	/**
	 * Destructor GeoLocalisation
	 */
	public function __destruct(){}

	/**
	 * Method setKey
	 * @access public
	 * @param mixed $key 
	 */
	public function setKey($key){
		if(!empty($key)) $this->apiKey = $key;
	}

	/**
	 * Method showTimezone
	 * @access public
	 */
	public function showTimezone(){
		$this->showTimezone = true;
	}

	/**
	 * Method getError
	 * @access public
	 * @return mixed
	 * @since 1.0.35
	 */
	public function getError(){
		return implode("\n", $this->errors);
	}

	/**
	 * Method getGeoLocation
	 * @access public
	 * @return array
	 * @since 1.0.35
	 */
	public function getGeoLocation(){
		if (!isset($_SESSION['ipinfodb_geolocalisation']) && (!isset($_SESSION['google_geolocalisation']) && $this->_ip==$_SERVER["REMOTE_ADDR"]) || $this->_ip!=$_SERVER["REMOTE_ADDR"]) {
  		if(preg_match('/^(?:25[0-5]|2[0-4]\d|1\d\d|[1-9]\d|\d)(?:[.](?:25[0-5]|2[0-4]\d|1\d\d|[1-9]\d|\d)){3}$/', $this->_ip)){
  			$service_url = 'http://' . $this->service . '/' . $this->version . '/' . 'ip_query.php?key=' . $this->apiKey . '&ip=' . $this->_ip;
  			$xml = @file_get_contents($service_url);
	
				try{
					$response = @new SimpleXMLElement($xml);
					foreach($response as $field=>$value){
						$result[(string)$field] = (string)$value;
					}
				}
				catch(Exception $e){
					$this->errors[] = new Exception($e->getMessage());
					return false;
				}
			}
			$this->errors[] = '"' . $host . '" is not a valid IP address or hostname.';
			
			$this->_geolocation = $result;
			if ($this->_ip==$_SERVER["REMOTE_ADDR"]) {
	    	$_SESSION['ipinfodb_geolocalisation'] = $this->_geolocation;
	    }
  	} else {
  		if (isset($_SESSION['google_geolocalisation']) && $this->_ip==$_SERVER["REMOTE_ADDR"]) {
	  		$this->_geolocation = $_SESSION['google_geolocalisation'];
	  	} else {
  			$this->_geolocation = $_SESSION['ipinfodb_geolocalisation'];
  		}
  	}
    $this->_loaded = true;
    return $this->_geolocation;
	}
	
	/**
	 * Method setIP
	 * @access public
	 * @param string $ip The ip address
	 * @return void
	 * @since 1.0.35
	 */
  public function setIP($ip)
  {
    $this->_ip = $ip;
  }
  
  public function setRemoteIP() {
  	$this->setIP($_SERVER["REMOTE_ADDR"]);
  }
  
  /**
  * Set domain
  * @param string $domain The domain name
  * @param bool $test To test if the domain is valid or not
  * @access public
  * @return	void
  */
  public function setDomain($domain)
  {
    $this->_ip = gethostbyname($domain);
  }
  
  /**
  * Get IP as a string
  * @access public
  * @return	string
  */
  public function getIp() {
  	return $this->_ip;
  }
  
  /**
  * is a google geolocalisation
  * @access public
  * @return	boolean
  */
  public function isGoogleLocalisation() {
  	if ($this->_ip != "") {
  		if (isset($_SESSION['google_geolocalisation']) && $this->_ip==$_SERVER["REMOTE_ADDR"]) {
  			return true;
  		}
  	}
  	return false;
  }
  
  private function _getInfoIp($column_name) {
  	if ($this->_ip != "") {
  		if (isset($_SESSION['ipinfodb_geolocalisation'])) {
	  		$geolocation = $_SESSION['ipinfodb_geolocalisation'];
	  	} else {
	  		if (sizeof($this->_geolocation) == 0) {
	  			$this->getGeoLocation();
	  		}
	  		$geolocation = $this->_geolocation;
	  	}
	  	if (isset($_SESSION['google_geolocalisation']) && $this->_ip==$_SERVER["REMOTE_ADDR"]) {
	  		$geolocation = $_SESSION['google_geolocalisation'];
	  	}
	  	//print_r($geolocation);
	  	return utf8_decode($geolocation[$column_name]);
  	} else {
  		return "";
  	}
  }
  
  /**
  * Get Latitude as a string
  * @access public
  * @return	string
  */
  public function getLatitude() {
  	return $this->_getInfoIp('Latitude');
  }
  
  /**
  * Get Longitude as a string
  * @access public
  * @return	string
  */
  public function getLongitude() {
  	return $this->_getInfoIp('Longitude');
  }
  
  /**
  * Get City as a string
  * @access public
  * @return	string
  */
  public function getCity() {
  	return $this->_getInfoIp('City');
  }
  
  /**
  * Get Country as a string
  * @access public
  * @return	string
  */
  public function getCountry() {
  	return $this->_getInfoIp('CountryName');
  }
  
  /**
  * Get Country Code as a string
  * @access public
  * @return	string
  */
  public function getCountryCode() {
  	return $this->_getInfoIp('CountryCode');
  }
  
  /**
  * Get Region as a string
  * @access public
  * @return	string
  */
  public function getRegion() {
  	return $this->_getInfoIp('RegionName');
  }

}
?>
