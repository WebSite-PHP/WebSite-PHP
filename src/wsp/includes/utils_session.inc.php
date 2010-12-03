<?php
	function formalize_to_variable($txt) {
		 $txt = str_replace("Î", "i", $txt);
		 $txt = str_replace("ï", "i", $txt);
		 $txt = str_replace("î", "i", $txt);
		 $txt = str_replace("Â", "n", $txt);
		 $txt = str_replace("ä", "a", $txt);
		 $txt = str_replace("â", "a", $txt);
		 $txt = str_replace("à", "a", $txt);
		 $txt = str_replace("á", "a", $txt);
		 $txt = str_replace("ë", "e", $txt);
		 $txt = str_replace("ê", "e", $txt);
		 $txt = str_replace("è", "e", $txt);
		 $txt = str_replace("é", "e", $txt);
		 $txt = str_replace(")", "", $txt);
		 $txt = str_replace("(", "", $txt);
		 $txt = str_replace("]", "", $txt);
		 $txt = str_replace("[", "", $txt);
		 $txt = str_replace("-", "", $txt);
		 $txt = str_replace("ß", "s", $txt);
		 $txt = str_replace("ñ", "n", $txt);
		 $txt = str_replace("ô", "o", $txt);
		 $txt = str_replace("ç", "c", $txt);
		 $txt = str_replace("ù", "u", $txt);
		 $txt = str_replace("ü", "u", $txt);
		 $txt = str_replace("û", "u", $txt);
		 $txt = str_replace("$", "", $txt);
		 $txt = str_replace("@", "", $txt);
		 $txt = str_replace("#", "", $txt);
		 $txt = str_replace("/", "", $txt);
		 $txt = str_replace("\"", "", $txt);
		 $txt = str_replace(".", "", $txt);
		 $txt = str_replace("|", "", $txt);
		 $txt = str_replace(":", "", $txt);
		 $txt = str_replace(";", "", $txt);
		 $txt = str_replace(",", "", $txt);
		 $txt = str_replace("?", "", $txt);
		 $txt = str_replace("!", "", $txt);
		 $txt = str_replace("\'", "", $txt);
		 $txt = str_replace("'", "", $txt);
		 $txt = str_replace("\\", "", $txt);
		 $txt = str_replace(" ", "_", $txt);
		 $txt = str_replace("²", "2", $txt);
		 $txt = str_replace("%", "", $txt);
		 $txt = str_replace("&", "", $txt);
		
		return strtolower($txt);
	}
?>