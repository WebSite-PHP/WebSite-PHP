<?php
/***************************************************************
 *
 * 09/05/2009
 *
 * Copyright notice
 *
 * (c) 2009 Yohann CERDAN <cerdanyohann@yahoo.fr>
 * All rights reserved
 *
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * This copyright notice MUST APPEAR in all copies of the script!
 *
 * List returned values for current:
 * - condition
 * - temp_f
 * - temp_c
 * - humidity
 * - icon
 * - wind_condition
 *
 * List returned values for forecast:
 * - day_of_week
 * - low
 * - high
 * - icon
 * - condition
 ***************************************************************/
 
class GoogleWeatherAPI {
	/** City code input **/
	private $city_code = '';
	
	/** City label get on the google webservice **/
	private $city = '';
	
	/** Domain of the google website **/
	private $domain = 'www.google.com';
	
	/** Prefix of the img link **/
	private $prefix_images = '';
	
	/** Array with current weather **/
	private $current_conditions = array();
	
	/** Array with forecast weather **/
	private $forecast_conditions = array();
	
	/** If the city was found **/
	private $is_found = true;

	/** The HTML response send by the service **/
	private $response;
	
	/**
	* Class constructor
	* @param $city_code is the label of the city
	* @param $lang the lang of the return weather labels
	* @return ...
	*/
	 
	function __construct ($city_code,$lang='') {
		if ($lang == '') {
			$lang = $_SESSION['lang'];
		}
		$this->city_code = $city_code;
		$this->prefix_images = 'http://'.$this->domain;
		$this->url = 'http://'.$this->domain.'/ig/api?weather='.urlencode($this->city_code).'&hl='.$lang;
		
		$getContentCode = $this->getContent($this->url);
				
		if($getContentCode == 200) {
		
			$content = utf8_encode($this->response);
			
			$xml = simplexml_load_string($content);
			
			if(!isset($xml->weather->problem_cause)) {
				
				$xml = simplexml_load_string($content);

				$this->city = utf8_decode((string)$xml->weather->forecast_information->city->attributes()->data);

				$this->current_conditions['condition'] = utf8_decode((string)$xml->weather->current_conditions->condition->attributes()->data);
				$this->current_conditions['temp_f'] = utf8_decode((string)$xml->weather->current_conditions->temp_f->attributes()->data);
				$this->current_conditions['temp_c'] = utf8_decode((string)$xml->weather->current_conditions->temp_c->attributes()->data);
				$this->current_conditions['humidity'] = utf8_decode((string)$xml->weather->current_conditions->humidity->attributes()->data);
				$this->current_conditions['icon'] = utf8_decode($this->prefix_images.(string)$xml->weather->current_conditions->icon->attributes()->data);
				$this->current_conditions['wind_condition'] = utf8_decode((string)$xml->weather->current_conditions->wind_condition->attributes()->data);
				
				foreach($xml->weather->forecast_conditions as $this->forecast_conditions_value) {
					$this->forecast_conditions_temp = array();
					$this->forecast_conditions_temp['day_of_week'] = utf8_decode((string)$this->forecast_conditions_value->day_of_week->attributes()->data);
					$this->forecast_conditions_temp['low'] = utf8_decode((string)$this->forecast_conditions_value->low->attributes()->data);
					$this->forecast_conditions_temp['high'] = utf8_decode((string)$this->forecast_conditions_value->high->attributes()->data);
					$this->forecast_conditions_temp['icon'] = utf8_decode($this->prefix_images.(string)$this->forecast_conditions_value->icon->attributes()->data);
					$this->forecast_conditions_temp['condition'] = utf8_decode((string)$this->forecast_conditions_value->condition->attributes()->data);
					$this->forecast_conditions []= utf8_decode($this->forecast_conditions_temp);
				}
			} else {
				$this->is_found = false;
			}
			
		} else {
			trigger_error('Google results parse problem : http error '.$getContentCode,E_USER_WARNING);
			return null;
		}
	}
	
	/**
           * Get URL content using cURL.
          * 
          * @param string $url the url 
          * 
          * @return string the html code
          */
		  
	public function getContent($url)
    {
		if (!extension_loaded('curl')) {
            throw new Exception('curl extension is not available');
        }
		
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_URL, $url);
        $this->response = curl_exec($curl);
		$infos = curl_getinfo($curl);
        curl_close ($curl);
        return $infos['http_code'];
    }
	
	/**
	 * Get the city
	 */
	 
	function getCity() {
		return $this->city;
	}
	
	/**
	 * Get the current weather
	 */
	 
	function getCurrent() {
		return $this->current_conditions;
	}
	
	/**
	 * Get the forecast weather
	 */
	 
	function getForecast() {
		return $this->forecast_conditions;
	}
	
	/**
	 * If teh city was found
	 */
	 
	function isFound() {
		return $this->is_found;
	}
	
}
/*
$gweather = new GoogleWeatherAPI('nantes','fr'); // "en" also work
if($gweather->isFound()) {
	echo '<pre>'; print_r($gweather->getCity()); echo '</pre>';
	echo '<pre>'; print_r($gweather->getCurrent()); echo '</pre>';
	echo '<pre>'; print_r($gweather->getForecast()); echo '</pre>';
}
*/
?>
