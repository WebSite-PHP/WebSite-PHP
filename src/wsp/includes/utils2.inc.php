<?php
	function url_rewrite_format($car){
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
?>