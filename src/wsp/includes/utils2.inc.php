<?php
/**
 * PHP file wsp\includes\utils2.inc.php
 */
/**
 * WebSite-PHP file utils2.inc.php
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
 * @copyright   WebSite-PHP.com 26/05/2011
 * @version     1.2.0
 * @access      public
 * @since       1.2.0
 */

	function url_rewrite_format($car){
		if (function_exists("is_utf8") && is_utf8($car)) {
			$car = utf8_decode($car);
		}
		$car=html_entity_decode($car);
		$string= array("'" => "_", "(" => "_", ")" => "_", "*" => "_", 
			"+" => "_", "," => "_", "-" => "_", "." => "_", 
			"/" => "_", ":" => "_", ";" => "_", "<" => "_", 
			"=" => "_", ">" => "_", "?" => "_", "@" => "_", 
			"[" => "_", "\\" => "_", "]" => "_", "^" => "_", 
			"`" => "_", "{" => "_", "|" => "_", "}" => "_", 
			"~" => "_", "\x7F" => "_", "\x80" => "_", "\x81" => "_", 
			"\x82" => "_", "\x83" => "_", "\x84" => "_", "\x85" => "_", 
			"\x86" => "_", "\x87" => "_", "\x88" => "_", "\x89" => "_", 
			"\x8A" => "s", "\x8B" => "_", "\x8C" => "oe", "\x8D" => "_", 
			"\x8E" => "Z", "\x8F" => "_", "\x90" => "_", "\x91" => "_", 
			"\x92" => "_", "\x93" => "_", "\x94" => "_", "\x96" => "_", 
			"\x96" => "_", "\x97" => "_", "\x98" => "_", "\x99" => "_", 
			"\x9A" => "s", "\x9B" => "_", "\x9C" => "_", "\x9D" => "z", 
			"\x9F" => "y", " " => "_", "\xA0" => "_", "\xA1" => "i", "\xA2" => "c", 
			"\xA3" => "l", "\xA4" => "_", "\xA5" => "y", "\xA6" => "_", 
			"\xA7" => "_", "\xA8" => "_", "\xA9" => "_", "\xAA" => "_", 
			"\xAB" => "_", "\xAC" => "_", "\xAD" => "_", "\xAE" => "_", 
			"\xAF" => "_", "\xB0" => "_", "\xB1" => "_", "\xB2" => "_", 
			"\xB3" => "_", "\xB4" => "_", "\xB5" => "u", "\xB6" => "_", 
			"\xB7" => "_", "\xB8" => "_", "\xB9" => "_", "\xBA" => "_", 
			"\xBB" => "_", "\xBC" => "_", "\xBD" => "_", "\xBE" => "_", 
			"\xBF" => "_", "\xC0" => "A", "\xC1" => "A", "\xC2" => "A", 
			"\xC3" => "A", "\xC4" => "A", "\xC5" => "A", "\xC6" => "AE", 
			"\xC7" => "C", "\xC8" => "E", "\xC9" => "E", "\xCA" => "E", 
			"\xCB" => "E", "\xCC" => "I", "\xCD" => "I", "\xCE" => "I", 
			"\xCF" => "I", "\xD0" => "D", "\xD1" => "N", "\xD2" => "O", 
			"\xD3" => "O", "\xD4" => "O", "\xD5" => "O", "\xD6" => "O", 
			"\xD7" => "x", "\xD8" => "O", "\xD9" => "U", "\xDA" => "U", 
			"\xDB" => "U", "\xDC" => "U", "\xDD" => "Y", "\xDE" => "_", 
			"\xDF" => "s", "\xE0" => "a", "\xE1" => "a", "\xE2" => "a", 
			"\xE3" => "a", "\xE4" => "a", "\xE5" => "a", "\xE6" => "ae", 
			"\xE7" => "c", "\xE8" => "e", "\xE9" => "e", "\xEA" => "e", 
			"\xEB" => "e", "\xEC" => "i", "\xED" => "i", "\xEE" => "i", 
			"\xEF" => "i", "\xF0" => "_", "\xF1" => "n", "\xF2" => "o", 
			"\xF3" => "o", "\xF4" => "o", "\xF5" => "o", "\xF6" => "o", 
			"\xF7" => "_", "\xF8" => "o", "\xF9" => "u", "\xFA" => "u", 
			"\xFB" => "u", "\xFC" => "u", "\xFD" => "y", "\xFE" => "_", 
			"\xFF" => "y", "&" => "_", "\"" => "_", "!" => "_",
			"&" => "_", "#" => "_", "$" => "_", "%" => "_");
			
		$car = strtr($car, $string);
		$car = stripslashes($car);
		
		$car = str_replace("__", "_", $car);
		$car = str_replace("__", "_", $car);
		$car = str_replace("__", "_", $car);
		if ($car[strlen($car)-1]=="_") {
			$car = substr($car, 0, strlen($car)-1);
		}
		$car = str_replace("_", "-", $car);
		return strtolower($car);
	}
	
	$html_convert_table = array (
	    "&" => "&amp;", "\xA1" => "&iexcl;", "\xA2" => "&cent;", "\xA3" => "&pound;", "\xA4" => "&curren;", "\xA5" => "&yen;",
	    "\xA6" => "&brvbar;", "\xA7" => "&sect;", "\xA8" => "&uml;", "\xA9" => "&copy;", "\xAA" => "&ordf;", "\xAB" => "&laquo;",
	    "\xAC" => "&not;", "\xAD" => "&shy;", "\xAE" => "&reg;", "\xAF" => "&macr;", "\xB0" => "&deg;", "\xB1" => "&plusmn;",
	    "\xB2" => "&sup2;", "\xB3" => "&sup3;", "\xB4" => "&acute;", "\xB5" => "&micro;", "\xB6" => "&para;", "\xB7" => "&middot;",
	    "\xB8" => "&cedil;", "\xB9" => "&sup1;", "\xBA" => "&ordm;", "\xBB" => "&raquo;", "\xBC" => "&frac14;", "\xBD" => "&frac12;",
	    "\xBE" => "&frac34;", "\xBF" => "&iquest;", "\xC0" => "&Agrave;", "\xC1" => "&Aacute;", "\xC2" => "&Acirc;", "\xC3" => "&Atilde;",
	    "\xC4" => "&Auml;", "\xC5" => "&Aring;", "\xC6" => "&AElig;", "\xC7" => "&Ccedil;", "\xC8" => "&Egrave;", "\xC9" => "&Eacute;",
	    "\xCA" => "&Ecirc;", "\xCB" => "&Euml;", "\xCC" => "&Igrave;", "\xCD" => "&Iacute;", "\xCE" => "&Icirc;", "\xCF" => "&Iuml;",
	    "\xD0" => "&ETH;", "\xD1" => "&Ntilde;", "\xD2" => "&Ograve;", "\xD3" => "&Oacute;", "\xD4" => "&Ocirc;", "\xD5" => "&Otilde;",
	    "\xD6" => "&Ouml;", "\xD7" => "&times;", "\xD8" => "&Oslash;", "\xD9" => "&Ugrave;", "\xDA" => "&Uacute;", "\xDB" => "&Ucirc;",
	    "\xDC" => "&Uuml;", "\xDD" => "&Yacute;", "\xDE" => "&THORN;", "\xDF" => "&szlig;", "\xE0" => "&agrave;", "\xE1" => "&aacute;",
	    "\xE2" => "&acirc;", "\xE3" => "&atilde;", "\xE4" => "&auml;", "\xE5" => "&aring;", "\xE6" => "&aelig;", "\xE7" => "&ccedil;",
	    "\xE8" => "&egrave;", "\xE9" => "&eacute;", "\xEA" => "&ecirc;", "\xEB" => "&euml;", "\xEC" => "&igrave;", "\xED" => "&iacute;",
	    "\xEE" => "&icirc;", "\xEF" => "&iuml;", "\xF0" => "&eth;", "\xF1" => "&ntilde;", "\xF2" => "&ograve;", "\xF3" => "&oacute;",
	    "\xF4" => "&ocirc;", "\xF5" => "&otilde;", "\xF6" => "&ouml;", "\xF7" => "&divide;", "\xF8" => "&oslash;", "\xF9" => "&ugrave;",
	    "\xFA" => "&uacute;", "\xFB" => "&ucirc;", "\xFC" => "&uuml;", "\xFD" => "&yacute;", "\xFE" => "&thorn;", "\xFF" => "&yuml;",
	    "\"" => "&quot;", "<" => "&lt;", ">" => "&gt;"
	);
?>
