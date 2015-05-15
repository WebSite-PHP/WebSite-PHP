<?php
/**
 * PHP file wsp\includes\utils_string.inc.php
 */
/**
 * WebSite-PHP file utils_string.inc.php
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
 * @since       1.2.1
 */

	function is_utf8($string) {
		return preg_match('%(?:
	        [\xC2-\xDF][\x80-\xBF]             # non-overlong 2-byte
	        |\xE0[\xA0-\xBF][\x80-\xBF]        # excluding overlongs
	        |[\xE1-\xEC\xEE\xEF][\x80-\xBF]{2} # straight 3-byte
	        |\xED[\x80-\x9F][\x80-\xBF]        # excluding surrogates
	        |\xF0[\x90-\xBF][\x80-\xBF]{2}     # planes 1-3
	        |[\xF1-\xF3][\x80-\xBF]{3}         # planes 4-15
	        |\xF4[\x80-\x8F][\x80-\xBF]{2}     # plane 16
	        )+%xs', 
	    $string);
	}
	function utf8encode($text) {
		if (!is_utf8($text)) {
			return utf8_encode($text);
		}
		return $text;
	}
	function utf8decode($text) {
		if (is_utf8($text)) {
			return utf8_decode($text);
		}
		return $text;
	}
	
	function convert_utf8_to_html($text) {
		return mb_convert_encoding($text, 'HTML-ENTITIES', 'UTF-8');
	}
	
	function formatDate($date) {
		if (gettype($date) == "object") {
			if (get_class($date) == "DateTime") {
				$date = $date->format("Y-m-d H:i:s");
			}
		} else if (is_int($date)) {
			$date = date("Y-m-d H:i:s", $date);
		}
		list($date, $heure) = explode(" ", $date);
		list($year, $month, $day) = explode("-", $date);
		return $day." ".utf8encode($GLOBALS['months'][$month-1])." ".$year;
	}
	function formatDateHeure($date) {
		if (gettype($date) == "object") {
			if (get_class($date) == "DateTime") {
				$date = $date->format("Y-m-d H:i:s");
			}
		} else if (is_int($date)) {
			$date = date("Y-m-d H:i:s", $date);
		}
		list($date, $heure) = explode(" ", $date);
		return formatDate($date)." ".$heure;
	}
	function formatDateHeureSmall($date) {
		if (gettype($date) == "object") {
			if (get_class($date) == "DateTime") {
				$date = $date->format("Y-m-d H:i:s");
			}
		} else if (is_int($date)) {
			$date = date("Y-m-d H:i:s", $date);
		}
		list($date, $heure) = explode(" ", $date);
		return formatDate($date)." ".substr($heure, 0, 5);
	}
	
	function getMonth($month_number) {
		return utf8encode($GLOBALS['months'][$month_number]);
	}
	
	function convert12HourTo24Hour($hour) {
		$array_hour = explode(':', $hour);
		if (find($array_hour[1], "PM") > 0) {
			if (intval($array_hour[0]) != 12) {
				$hour = (intval($array_hour[0])+12).":".$array_hour[1];
			}
			$hour = str_replace(" PM", "", $hour);
		} else if (find($array_hour[1], "AM") > 0) {
			if (intval($array_hour[0]) == 12) {
				$hour = "00:".$array_hour[1];
			}
			$hour = str_replace(" AM", "", $hour);
		}
		return $hour;
	}
	
	function random($car) { 
		$string = ""; 
		$chaine = "abcdefghijklmnpqrstuvwxy0123456789"; 
		srand((double)microtime()*1000000); 
		for($i=0; $i<$car; $i++) { 
			$upper = rand(0, 1);
			if ($upper == 1) {
				$string .= strtoupper($chaine[rand()%strlen($chaine)]);
			} else {
				$string .= $chaine[rand()%strlen($chaine)];
			} 
		} 
		return $string; 
	} 
	
	function find($str, $find, $minus=0, $pos_dep=0){
	  if ($minus==1) {
	    $str=strtolower($str);
	    $find=strtolower($find);
	  }     //Si $minus=1, ne differencie pas les majuscules des minuscules
	  for ($l=$pos_dep;$l<strlen($str);$l++) {  //Faire une boucle du debut jusqu'a la fin de str
	    if (substr($str,$l,strlen($find))==$find){    //Si $trouve est trouve dans $str
	      $pos = $l+strlen($find);
	      return $pos;     //on retourne la position
	    }
	  }
	  return 0;   //Sinon, retourner 0 pour dire que c'est pas trouve
	}
	
	function str_replace_first($search, $replace, $subject) {
		$pos = strpos($subject, $search);
		if ($pos !== false) {
			$subject = substr_replace($subject, $replace, $pos, strlen($search));
		}
		return $subject;
	}

	function str_replace_last($search, $replace, $subject) {
	    $search = strrev($search);
	    $replace = strrev($replace);
	    $subject = strrev($subject);
	    return strrev(str_replace_first($search,$replace,$subject));
	}
	
	function echo_r($array){
	    ob_start();
	    if (is_bool($array)){
	        echo ($array ? 'true' : 'false');
	    } else {
	        print_r($array);
	    }
	
	    $echo = ob_get_contents();
	    ob_clean();
	
	    return highlight_string($echo, true);
	}
	
	function html_convert($text) { 
		global $html_convert_table; 
		foreach($html_convert_table as $key => $val) {
			$text = str_replace($key, $val, $text); 
		}
		return $text;
	}
	
	// return the difference of open and close characters
	function balanceChars($str, $open, $close) {
		if (trim($open) != "") { $str = str_replace("\\".$open, "", $str); }
		if (trim($close) != "") { $str = str_replace("\\".$close, "", $str); }
		if ($open == $close) {
			$retval = substr_count($str, $open);
		} else {
	    	$openCount = substr_count($str, $open);
	    	$closeCount = substr_count($str, $close);
	    	$retval = $openCount - $closeCount;
		}
	    return $retval;
	}
	
	// explode, but ignore delimiter until closing characters are found
	function explodeFunky($delimiter, $str, $open="'", $close="'") {
	    $retval = array();
	    $hold = array();
	    $balance = 0;
	    $parts = explode($delimiter, $str);
	    foreach ($parts as $part) {
	        $hold[] = $part;
	        $balance += balanceChars($part, $open, $close);
	        if ($balance % 2 == 0) {
	            $retval[] = implode($delimiter, $hold);
	            $hold = array();
	            $balance = 0;
	       }
	    }
	    if (count($hold) > 0) {
	        $retval[] = implode($delimiter, $hold);
	    }
	    return $retval;
	}
?>
