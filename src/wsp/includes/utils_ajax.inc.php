<?php
/**
 * PHP file wsp\includes\utils_ajax.inc.php
 */
/**
 * WebSite-PHP file utils_ajax.inc.php
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
 * @since       1.0.19
 */

	function extract_javascript($html) {
		$array_html_js = array();
		$array_html_js[0] = $html;
		
		$pos = find($html, "<script", 1, 0);
		while ($pos > 0) {
			$pos = $pos - 7;
			$pos2 = find($html, "</script>", 1, $pos);
			if ($pos2 > 0) {
				$sub_html1 = substr($html, 0, $pos);
				$sub_html2 = substr($html, $pos2, strlen($html));
				$pos3 = find($html, ">", 1, $pos);
				$script = substr($html, $pos3, $pos2-$pos3-9);
				$array_html_js[] = $script;
				$html = $sub_html1." ".$sub_html2;
			} else {
				break;
			}
			$pos = find($html, "<script", 1, 0);
		}
		$array_html_js[0] = $html;
		
		return $array_html_js;
	}
?>
