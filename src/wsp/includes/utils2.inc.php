<?php
/**
 * PHP file wsp\includes\utils2.inc.php
 */
/**
 * WebSite-PHP file utils2.inc.php
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2012 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 26/05/2011
 * @version     1.1.12
 * @access      public
 * @since       1.1.12
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
			"~" => "_", "" => "_", "�" => "_", "�" => "_", 
			"�" => "_", "�" => "_", "�" => "_", "�" => "_", 
			"�" => "_", "�" => "_", "�" => "_", "�" => "_", 
			"�" => "s", "�" => "_", "�" => "oe", "�" => "_", 
			"�" => "Z", "�" => "_", "�" => "_", "�" => "_", 
			"�" => "_", "�" => "_", "�" => "_", "�" => "_", 
			"�" => "_", "�" => "_", "�" => "_", "�" => "_", 
			"�" => "s", "�" => "_", "�" => "_", "�" => "z", 
			"�" => "y", " " => "_", "�" => "i", "�" => "c", 
			"�" => "l", "�" => "_", "�" => "y", "�" => "_", 
			"�" => "_", "�" => "_", "�" => "_", "�" => "_", 
			"�" => "_", "�" => "_", "�" => "_", "�" => "_", 
			"�" => "_", "�" => "_", "�" => "_", "�" => "_", 
			"�" => "_", "�" => "_", "�" => "u", "�" => "_", 
			"�" => "_", "�" => "_", "�" => "_", "�" => "_", 
			"�" => "_", "�" => "_", "�" => "_", "�" => "_", 
			"�" => "_", "�" => "A", "�" => "A", "�" => "A", 
			"�" => "A", "�" => "A", "�" => "A", "�" => "AE", 
			"�" => "C", "�" => "E", "�" => "E", "�" => "E", 
			"�" => "E", "�" => "I", "�" => "I", "�" => "I", 
			"�" => "I", "�" => "D", "�" => "N", "�" => "O", 
			"�" => "O", "�" => "O", "�" => "O", "�" => "O", 
			"�" => "x", "�" => "O", "�" => "U", "�" => "U", 
			"�" => "U", "�" => "U", "�" => "Y", "�" => "_", 
			"�" => "s", "�" => "a", "�" => "a", "�" => "a", 
			"�" => "a", "�" => "a", "�" => "a", "�" => "ae", 
			"�" => "c", "�" => "e", "�" => "e", "�" => "e", 
			"�" => "e", "�" => "i", "�" => "i", "�" => "i", 
			"�" => "i", "�" => "_", "�" => "n", "�" => "o", 
			"�" => "o", "�" => "o", "�" => "o", "�" => "o", 
			"�" => "_", "�" => "o", "�" => "u", "�" => "u", 
			"�" => "u", "�" => "u", "�" => "y", "�" => "_",
			"&" => "_", "\"" => "_", "�" => "ae", "!" => "_",
			"&" => "_", "#" => "_", "$" => "_", "%" => "_",
			"�" => "_");
			
		$car = strtr($car, $string);
		$car = stripslashes($car);
		
		$car = str_replace("__", "_", $car);
		$car = str_replace("__", "_", $car);
		$car = str_replace("__", "_", $car);
		if ($car[strlen($car)-1]=="_") {
			$car = substr($car, 0, strlen($car)-1);
		}
		$car = str_replace("_", "-", $car);
		return ucfirst($car);
	}
	
	$html_convert_table = array (
	    "&" => "&amp;", "�" => "&iexcl;", "�" => "&cent;", "�" => "&pound;", "�" => "&curren;", "�" => "&yen;",
	    "�" => "&brvbar;", "�" => "&sect;", "�" => "&uml;", "�" => "&copy;", "�" => "&ordf;", "�" => "&laquo;",
	    "�" => "&not;", "�" => "&shy;", "�" => "&reg;", "�" => "&macr;", "�" => "&deg;", "�" => "&plusmn;",
	    "�" => "&sup2;", "�" => "&sup3;", "�" => "&acute;", "�" => "&micro;", "�" => "&para;", "�" => "&middot;",
	    "�" => "&cedil;", "�" => "&sup1;", "�" => "&ordm;", "�" => "&raquo;", "�" => "&frac14;", "�" => "&frac12;",
	    "�" => "&frac34;", "�" => "&iquest;", "�" => "&Agrave;", "�" => "&Aacute;", "�" => "&Acirc;", "�" => "&Atilde;",
	    "�" => "&Auml;", "�" => "&Aring;", "�" => "&AElig;", "�" => "&Ccedil;", "�" => "&Egrave;", "�" => "&Eacute;",
	    "�" => "&Ecirc;", "�" => "&Euml;", "�" => "&Igrave;", "�" => "&Iacute;", "�" => "&Icirc;", "�" => "&Iuml;",
	    "�" => "&ETH;", "�" => "&Ntilde;", "�" => "&Ograve;", "�" => "&Oacute;", "�" => "&Ocirc;", "�" => "&Otilde;",
	    "�" => "&Ouml;", "�" => "&times;", "�" => "&Oslash;", "�" => "&Ugrave;", "�" => "&Uacute;", "�" => "&Ucirc;",
	    "�" => "&Uuml;", "�" => "&Yacute;", "�" => "&THORN;", "�" => "&szlig;", "�" => "&agrave;", "�" => "&aacute;",
	    "�" => "&acirc;", "�" => "&atilde;", "�" => "&auml;", "�" => "&aring;", "�" => "&aelig;", "�" => "&ccedil;",
	    "�" => "&egrave;", "�" => "&eacute;", "�" => "&ecirc;", "�" => "&euml;", "�" => "&igrave;", "�" => "&iacute;",
	    "�" => "&icirc;", "�" => "&iuml;", "�" => "&eth;", "�" => "&ntilde;", "�" => "&ograve;", "�" => "&oacute;",
	    "�" => "&ocirc;", "�" => "&otilde;", "�" => "&ouml;", "�" => "&divide;", "�" => "&oslash;", "�" => "&ugrave;",
	    "�" => "&uacute;", "�" => "&ucirc;", "�" => "&uuml;", "�" => "&yacute;", "�" => "&thorn;", "�" => "&yuml;",
	    "\"" => "&quot;", "<" => "&lt;", ">" => "&gt;"
	);
?>
