<?php
/**
 * PHP file wsp\includes\utils_session.inc.php
 */
/**
 * WebSite-PHP file utils_session.inc.php
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
 * @version     1.0.68
 * @access      public
 * @since       1.0.0
 */

	function formalize_to_variable($txt) {
		 $txt = str_replace("�", "i", $txt);
		 $txt = str_replace("�", "i", $txt);
		 $txt = str_replace("�", "i", $txt);
		 $txt = str_replace("�", "n", $txt);
		 $txt = str_replace("�", "a", $txt);
		 $txt = str_replace("�", "a", $txt);
		 $txt = str_replace("�", "a", $txt);
		 $txt = str_replace("�", "a", $txt);
		 $txt = str_replace("�", "e", $txt);
		 $txt = str_replace("�", "e", $txt);
		 $txt = str_replace("�", "e", $txt);
		 $txt = str_replace("�", "e", $txt);
		 $txt = str_replace(")", "", $txt);
		 $txt = str_replace("(", "", $txt);
		 $txt = str_replace("]", "", $txt);
		 $txt = str_replace("[", "", $txt);
		 $txt = str_replace("-", "", $txt);
		 $txt = str_replace("�", "s", $txt);
		 $txt = str_replace("�", "n", $txt);
		 $txt = str_replace("�", "o", $txt);
		 $txt = str_replace("�", "c", $txt);
		 $txt = str_replace("�", "u", $txt);
		 $txt = str_replace("�", "u", $txt);
		 $txt = str_replace("�", "u", $txt);
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
		 $txt = str_replace("�", "2", $txt);
		 $txt = str_replace("%", "", $txt);
		 $txt = str_replace("&", "", $txt);
		
		return strtolower($txt);
	}
?>
