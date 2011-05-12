<?php
/**
 * PHP file wsp\includes\utils.inc.php
 */
/**
 * WebSite-PHP file utils.inc.php
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
 * @version     1.0.77
 * @access      public
 * @since       1.0.19
 */

	function __() {
		$args = func_get_args();
		return translate($args);
	}
	
	function translate($txt) {
		if (is_array($txt)) {
			$args = $txt;
		} else {
			$args = func_get_args();
		}
		$txt = array_shift($args);
		
		$txt = str_replace("<", "{#OPEN_TAG#}", $txt);
		$txt = str_replace(">", "{#CLOSE_TAG#}", $txt);
		$txt = str_replace('"', "{#TEMP_QUOTE#}", $txt);
		$txt = str_replace("'", "{#TEMP_SIMPLE_QUOTE#}", $txt);
		
		$txt = html_convert($txt);
		
		$txt = str_replace("{#OPEN_TAG#}", "<", $txt);
		$txt = str_replace("{#CLOSE_TAG#}", ">", $txt);
		$txt = str_replace("{#TEMP_QUOTE#}", '"', $txt);
		$txt = str_replace("{#TEMP_SIMPLE_QUOTE#}", "'", $txt);
		
		// convert %s by args
		for ($i=0; $i < sizeof($args); $i++) {
    		$txt = preg_replace('/%s/', $args[$i], $txt, 1);
    	}
    	return $txt;
	}
	
	function html_convert($text) { 
		global $html_convert_table; 
		foreach($html_convert_table as $key => $val) {
			$text = str_replace($key, $val, $text); 
		}
		return $text; 
	}
	
	function formatDate($date) {
		if (gettype($date) == "object") {
			if (get_class($date) == "DateTime") {
				$date = $date->format("Y-m-d H:i:s");
			}
		}
		list($date, $heure) = explode(" ", $date);
		list($year, $month, $day) = explode("-", $date);
		return $day." ".$GLOBALS['months'][$month-1]." ".$year;
	}
	function formatDateHeure($date) {
		if (gettype($date) == "object") {
			if (get_class($date) == "DateTime") {
				$date = $date->format("Y-m-d H:i:s");
			}
		}
		list($date, $heure) = explode(" ", $date);
		return formatDate($date)." ".$heure;
	}
	function formatDateHeureSmall($date) {
		if (gettype($date) == "object") {
			if (get_class($date) == "DateTime") {
				$date = $date->format("Y-m-d H:i:s");
			}
		}
		list($date, $heure) = explode(" ", $date);
		return formatDate($date)." ".substr($heure, 0, 5);
	}
	
	function random($car) { 
		$string = ""; 
		$chaine = "abcdefghijklmnpqrstuvwxy"; 
		srand((double)microtime()*1000000); 
		for($i=0; $i<$car; $i++) { 
			$string .= $chaine[rand()%strlen($chaine)]; 
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
	
	function is_browser_ie() {
		$pos = find($_SERVER['HTTP_USER_AGENT'], 'MSIE', 1, 0);
		if ($pos > 0) {
			return true;
		}
		return false;
	}
	
	function is_browser_ie_6() {
		$is_ie = false;
		$pos = find($_SERVER['HTTP_USER_AGENT'], 'MSIE', 1, 0);
		if ($pos > 0) {
			$pos2 = find($_SERVER['HTTP_USER_AGENT'], ';', 1, $pos);
			if ($pos2 > 0) {
				$ie_version = trim(substr($_SERVER['HTTP_USER_AGENT'], $pos, $pos2-$pos-1));
				if ($ie_version < 7) {
					return true;
				}
			}
		}
		return false;
	}
	
	function get_browser_ie_version() {
		$is_ie = false;
		$pos = find($_SERVER['HTTP_USER_AGENT'], 'MSIE', 1, 0);
		if ($pos > 0) {
			$pos2 = find($_SERVER['HTTP_USER_AGENT'], ';', 1, $pos);
			if ($pos2 > 0) {
				return trim(substr($_SERVER['HTTP_USER_AGENT'], $pos, $pos2-$pos-1));
			}
		}
		return false;
	}
	
	function error_handler($code, $message, $file, $line) {
		if (0 == error_reporting() || $code == 0) {
	        return;
	    }
	    require_once(dirname(__FILE__)."/../class/NewException.class.php");
	    NewException::redirectOnError("");
	}
	
	function register_shutdown_handler() {
		require_once(dirname(__FILE__)."/../class/NewException.class.php");
	    NewException::redirectOnError("");
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
	
	/**
	 * xml2array() will convert the given XML text to an array in the XML structure.
	 * Link: http://www.bin-co.com/php/scripts/xml2array/
	 * Arguments : $contents - The XML text
	 *                $get_attributes - 1 or 0. If this is 1 the function will get the attributes as well as the tag values - this results in a different array structure in the return value.
	 *                $priority - Can be 'tag' or 'attribute'. This will change the way the resulting array sturcture. For 'tag', the tags are given more importance.
	 * Return: The parsed XML in an array form. Use print_r() to see the resulting array structure.
	 * Examples: $array =  xml2array(file_get_contents('feed.xml'));
	 *              $array =  xml2array(file_get_contents('feed.xml', 1, 'attribute'));
	 */
	function xml2array($contents, $get_attributes=1, $priority = 'tag') {
	    if(!$contents) return array();
	
	    if(!function_exists('xml_parser_create')) {
	        throw new NewException("xml_parser_create() function not found!", 0, 8, __FILE__, __LINE__);
	    }
	
	    //Get the XML parser of PHP - PHP must have this module for the parser to work
	    $parser = xml_parser_create('');
	    xml_parser_set_option($parser, XML_OPTION_TARGET_ENCODING, "UTF-8"); # http://minutillo.com/steve/weblog/2004/6/17/php-xml-and-character-encodings-a-tale-of-sadness-rage-and-data-loss
	    xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
	    xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
	    xml_parse_into_struct($parser, trim($contents), $xml_values);
	    xml_parser_free($parser);
	
	    if(!$xml_values) return;//Hmm...
	
	    //Initializations
	    $xml_array = array();
	    $parents = array();
	    $opened_tags = array();
	    $arr = array();
	
	    $current = &$xml_array; //Refference
	
	    //Go through the tags.
	    $repeated_tag_index = array();//Multiple tags with same name will be turned into an array
	    foreach($xml_values as $data) {
	        unset($attributes,$value);//Remove existing values, or there will be trouble
	
	        //This command will extract these variables into the foreach scope
	        // tag(string), type(string), level(int), attributes(array).
	        extract($data);//We could use the array by itself, but this cooler.
	
	        $result = array();
	        $attributes_data = array();
	        
	        if(isset($value)) {
	            if($priority == 'tag') $result = $value;
	            else $result['value'] = $value; //Put the value in a assoc array if we are in the 'Attribute' mode
	        }
	
	        //Set the attributes too.
	        if(isset($attributes) and $get_attributes) {
	            foreach($attributes as $attr => $val) {
	                if($priority == 'tag') $attributes_data[$attr] = $val;
	                else $result['attr'][$attr] = $val; //Set all the attributes in a array called 'attr'
	            }
	        }
	
	        //See tag status and do the needed.
	        if($type == "open") {//The starting of the tag '<tag>'
	            $parent[$level-1] = &$current;
	            if(!is_array($current) or (!in_array($tag, array_keys($current)))) { //Insert New tag
	                $current[$tag] = $result;
	                if($attributes_data) $current[$tag. '_attr'] = $attributes_data;
	                $repeated_tag_index[$tag.'_'.$level] = 1;
	
	                $current = &$current[$tag];
	
	            } else { //There was another element with the same tag name
	
	                if(isset($current[$tag][0])) {//If there is a 0th element it is already an array
	                    $current[$tag][$repeated_tag_index[$tag.'_'.$level]] = $result;
	                    $repeated_tag_index[$tag.'_'.$level]++;
	                } else {//This section will make the value an array if multiple tags with the same name appear together
	                    $current[$tag] = array($current[$tag],$result);//This will combine the existing item and the new item together to make an array
	                    $repeated_tag_index[$tag.'_'.$level] = 2;
	                    
	                    if(isset($current[$tag.'_attr'])) { //The attribute of the last(0th) tag must be moved as well
	                        $current[$tag]['0_attr'] = $current[$tag.'_attr'];
	                        unset($current[$tag.'_attr']);
	                    }
	
	                }
	                $last_item_index = $repeated_tag_index[$tag.'_'.$level]-1;
	                $current = &$current[$tag][$last_item_index];
	            }
	
	        } elseif($type == "complete") { //Tags that ends in 1 line '<tag />'
	            //See if the key is already taken.
	            if(!isset($current[$tag])) { //New Key
	                $current[$tag] = $result;
	                $repeated_tag_index[$tag.'_'.$level] = 1;
	                if($priority == 'tag' and $attributes_data) $current[$tag. '_attr'] = $attributes_data;
	
	            } else { //If taken, put all things inside a list(array)
	                if(isset($current[$tag][0]) and is_array($current[$tag])) {//If it is already an array...
	
	                    // ...push the new element into that array.
	                    $current[$tag][$repeated_tag_index[$tag.'_'.$level]] = $result;
	                    
	                    if($priority == 'tag' and $get_attributes and $attributes_data) {
	                        $current[$tag][$repeated_tag_index[$tag.'_'.$level] . '_attr'] = $attributes_data;
	                    }
	                    $repeated_tag_index[$tag.'_'.$level]++;
	
	                } else { //If it is not an array...
	                    $current[$tag] = array($current[$tag],$result); //...Make it an array using using the existing value and the new value
	                    $repeated_tag_index[$tag.'_'.$level] = 1;
	                    if($priority == 'tag' and $get_attributes) {
	                        if(isset($current[$tag.'_attr'])) { //The attribute of the last(0th) tag must be moved as well
	                            
	                            $current[$tag]['0_attr'] = $current[$tag.'_attr'];
	                            unset($current[$tag.'_attr']);
	                        }
	                        
	                        if($attributes_data) {
	                            $current[$tag][$repeated_tag_index[$tag.'_'.$level] . '_attr'] = $attributes_data;
	                        }
	                    }
	                    $repeated_tag_index[$tag.'_'.$level]++; //0 and 1 index is already taken
	                }
	            }
	
	        } elseif($type == 'close') { //End of tag '</tag>'
	            $current = &$parent[$level-1];
	        }
	    }
	    
	    return($xml_array);
	}

	function extractJavaScriptFromHtml($html) {
		$javascript = "";
		$pos = find($html, "<script", 0, 0);
		while ($pos > 0) {
			$pos2 = find($html, ">", 0, $pos);
			$pos3 = find($html, "</script>", 0, $pos2);
			if ($pos3 == 0) {
				break;
			}
			$pos2 = $pos2 + 1;
			$pos4 = $pos3 - 9;
			
			$html_before = substr($html, 0, $pos-7)."\n";
			$html_after = substr($html, $pos3, strlen($html)-$pos3);
			$javascript .= substr($html, $pos2, $pos4-$pos2)."\n";
			
			$html = $html_before.$html_after;
			$pos = find($html, "<script", 0, 0);
		}
		$javascript = str_replace("//<![CDATA[", "", $javascript);
		$javascript = str_replace("//]]>", "", $javascript);
		$javascript = str_replace("\r\n\r\n", "\r\n", $javascript);
		$javascript = str_replace("\n\n", "\n", $javascript);
		
		return array($html, $javascript);
	}
	
	function createHrefLink($str_or_object_link, $target='') {
		$html = "";
		if ($str_or_object_link != "") {
			if (gettype($str_or_object_link) != "object" && strtoupper(substr($str_or_object_link, 0, 11)) != "JAVASCRIPT:") {
				$tmp_link = new Link($str_or_object_link, $target);
				if (!$tmp_link->getUserHaveRights()) {
					return "";
				}
				$html .= $tmp_link->getLink();
				if ($tmp_link->getTarget() != "") {
					$html .= "\" target=\"".$tmp_link->getTarget()."";
				}
			} else if (gettype($str_or_object_link) != "object" && strtoupper(substr($str_or_object_link, 0, 11)) == "JAVASCRIPT:") {
				$html .= "javascript:void(0);\" onClick=\"".$str_or_object_link;
			} else {
				if (get_class($str_or_object_link) == "Link") {
					if (!$str_or_object_link->getUserHaveRights()) {
						return "";
					}
					$html .= $str_or_object_link->getLink();
					if ($str_or_object_link->getTarget() != "") {
						$html .= "\" target=\"".$str_or_object_link->getTarget()."";
					}
				} else {
					if (get_class($str_or_object_link) == "DialogBox") {
						$str_or_object_link->displayFormURL();
					}
					$tmp_link = $str_or_object_link->render();
					if (strtoupper(substr($tmp_link, 0, 11)) == "JAVASCRIPT:") {
						$html .= "javascript:void(0);\" onClick=\"".$tmp_link;
					} else {
						$html .= $tmp_link;
					}
				}
			}
		} else {
			$html .= "javascript:void(0);";
		}
		return $html;
	}
	
	// return the difference of open and close characters
	function balanceChars($str, $open, $close) {
	    $openCount = substr_count($str, $open);
	    $closeCount = substr_count($str, $close);
	    $retval = $openCount - $closeCount;
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
	        if ($balance < 1) {
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
	
	function get_browser_info($user_agent=null,$return_array=false) {
		$browser = array();
		if (get_cfg_var('browscap')) {
			$browser=get_browser($user_agent,$return_array); //If available, use PHP native function
		} else {
			require_once('browscap/php-local-browscap.php');
			$browser=get_browser_local($user_agent,$return_array,'php_browscap.ini',true);
		}
		return $browser;
	}
	
	include("utils2.inc.php");
?>
