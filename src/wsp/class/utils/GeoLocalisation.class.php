<?php
/**
 * PHP file wsp\class\utils\GeoLocalisation.class.php
 * @package utils
 */
/**
 * Class GeoLocalisation
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2015 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package utils
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 12/05/2015
 * @version     1.2.13
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
	protected $version = 'v3';
	protected $apiKey = '';

	/**
	 * Constructor GeoLocalisation
	 */
	public function __construct(){
		if (!isset($_SESSION['geolocalisation_user_share']) || $_COOKIE['wsp_geolocalisation_user_share'] == "") {
			$_SESSION['geolocalisation_user_share'] = false;
		}
	}

	/**
	 * Destructor GeoLocalisation
	 */
	public function __destruct(){}

	/**
	 * Method setKey
	 * @access public
	 * @param mixed $key 
	 * @since 1.0.59
	 */
	public function setKey($key){
		if(!empty($key)) $this->apiKey = $key;
	}
	
	/**
	 * Method askUserToSharePosition
	 * @access public
	 * @param boolean $refresh_page [default value: false]
	 * @param string $js_onsuccess 
	 * @return GeoLocalisation
	 * @since 1.0.98
	 */
	public function askUserToSharePosition($refresh_page=false, $js_onsuccess='') {
		$GLOBALS['__GEOLOC_ASK_USER_SHARE_POSITION__'] = true;
		
		if (gettype($js_onsuccess) != "string" && get_class($js_onsuccess) != "JavaScript") {
			throw new NewException(get_class($this)."->askUserToSharePosition(): \$js_onsuccess must be a string or JavaScript object.", 0, getDebugBacktrace(1));
		}
		if (get_class($js_onsuccess) == "JavaScript") {
			$js_onsuccess = $js_onsuccess->render();
		}
		$_SESSION['geolocalisation_user_share_js'] = $js_onsuccess.($refresh_page?"refreshPage();":"");
		return $this;
	}
	
	/**
	 * Method isUserPositionShared
	 * @access public
	 * @return mixed
	 * @since 1.1.2
	 */
	public function isUserPositionShared() {
		return $_SESSION['geolocalisation_user_share'];
	}

	/**
	 * Method showTimezone
	 * @access public
	 * @return GeoLocalisation
	 * @since 1.0.59
	 */
	public function showTimezone(){
		$this->showTimezone = true;
		return $this;
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
	 * Method getPageFromUrlWithCurl
	 * @access private
	 * @param mixed $url 
	 * @param double $timeout [default value: 3]
	 * @return mixed
	 * @since 1.0.79
	 */
	private function getPageFromUrlWithCurl($url, $timeout=3) {
	    $curl = curl_init();
	
	    // HEADERS FROM FIREFOX - APPEARS TO BE A BROWSER REFERRED BY GOOGLE
	    $header[] = "Accept: text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";
	    $header[] = "Cache-Control: max-age=0";
	    $header[] = "Connection: keep-alive";
	    $header[] = "Keep-Alive: 300";
	    $header[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
	    $header[] = "Accept-Language: en-us,en;q=0.5";
	    $header[] = "Pragma: "; // browsers keep this blank.
	
	    // SET THE CURL OPTIONS - SEE http://php.net/manual/en/function.curl-setopt.php
	    curl_setopt($curl, CURLOPT_URL,            $url);
	    curl_setopt($curl, CURLOPT_USERAGENT,      'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.1.6) Gecko/20091201 Firefox/3.5.6');
	    curl_setopt($curl, CURLOPT_HTTPHEADER,     $header);
	    curl_setopt($curl, CURLOPT_REFERER,        'http://www.google.com');
	    curl_setopt($curl, CURLOPT_ENCODING,       'gzip,deflate');
	    curl_setopt($curl, CURLOPT_AUTOREFERER,    TRUE);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
	    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
	    curl_setopt($curl, CURLOPT_TIMEOUT,        $timeout);
	
	    // RUN THE CURL REQUEST AND GET THE RESULTS
	    $htm = curl_exec($curl);
	    $err = curl_errno($curl);
	    $inf = curl_getinfo($curl);
	    curl_close($curl);
	
	    // ON FAILURE
	    if (!$htm) {
	        return false;
	    }
	
	    // ON SUCCESS
	    return $htm;
	}

	/**
	 * Method getGeoLocation
	 * @access public
	 * @return array
	 * @since 1.0.35
	 */
	public function getGeoLocation(){
		if ($this->apiKey != "" && ((!isset($_SESSION['ipinfodb_geolocalisation']) && (!isset($_SESSION['google_geolocalisation']) && $this->_ip==$this->getRemoteIP()) || $this->_ip!=$this->getRemoteIP()))) {
	  		if(preg_match('/^(?:25[0-5]|2[0-4]\d|1\d\d|[1-9]\d|\d)(?:[.](?:25[0-5]|2[0-4]\d|1\d\d|[1-9]\d|\d)){3}$/', $this->_ip)){
	  			$service_url = 'http://' . $this->service . '/' . $this->version . '/ip-city/?key=' . $this->apiKey . '&format=xml&ip=' . $this->_ip;
	  			if (extension_loaded('curl')) {
	  				$xml = $this->getPageFromUrlWithCurl($service_url);
	  				if ($xml == false) {
	  					$xml = "";
	  				}
	  			} else {
	  				$xml = @file_get_contents($service_url);
	  			}
		
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
			//$this->errors[] = '"' . $host . '" is not a valid IP address or hostname.';
			
			$this->_geolocation = $result;
			if ($this->_ip==$this->getRemoteIP()) {
		    	$_SESSION['ipinfodb_geolocalisation'] = $this->_geolocation;
		    }
  	} else {
  		if (isset($_SESSION['google_geolocalisation']) && $this->_ip==$this->getRemoteIP()) {
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
	return $this;
  }
  
  public function setRemoteIP() {
  	$this->setIP($this->getRemoteIP());
	return $this;
  }
  
  private function getRemoteIP() {
  	if (isset($_SERVER["HTTP_X_FORWARDED_FOR"]) && $_SERVER["HTTP_X_FORWARDED_FOR"] != "") {
		return $_SERVER["HTTP_X_FORWARDED_FOR"];
	} else {
		return $_SERVER["REMOTE_ADDR"];
	}
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
	return $this;
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
  		if (isset($_SESSION['google_geolocalisation']) && $this->_ip==$this->getRemoteIP()) {
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
	  	if (isset($_SESSION['google_geolocalisation']) && $this->_ip==$this->getRemoteIP()) {
	  		$geolocation = $_SESSION['google_geolocalisation'];
	  	}
	  	//print_r($geolocation);
	  	if (isset($geolocation[$column_name])) {
	  		return utf8_decode($geolocation[$column_name]);
	  	} else {
	  		return "";
	  	}
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
  	return $this->_getInfoIp('latitude');
  }
  
  /**
  * Get Longitude as a string
  * @access public
  * @return	string
  */
  public function getLongitude() {
  	return $this->_getInfoIp('longitude');
  }
  
  /**
  * Get City as a string
  * @access public
  * @return	string
  */
  public function getCity() {
  	return utf8_encode($this->_getInfoIp('cityName'));
  }
  
  /**
  * Get Country as a string
  * @access public
  * @return	string
  */
  public function getCountry() {
  	return utf8_encode($this->_getInfoIp('countryName'));
  }
  
  /**
  * Get Country Code as a string
  * @access public
  * @return	string
  */
  public function getCountryCode() {
  	return $this->_getInfoIp('countryCode');
  }
  
  /**
  * Get Region as a string
  * @access public
  * @return	string
  */
  public function getRegion() {
  	return utf8_encode($this->_getInfoIp('regionName'));
  }

}
?>
