<?php
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