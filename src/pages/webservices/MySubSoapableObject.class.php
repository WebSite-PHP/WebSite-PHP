<?php
class MySubSoapableObject {
	private $sub_text = "";
	
	public function setSubText($txt) {
		$this->sub_text = $txt;
	}
	
	public function getSubText() {
		return $this->sub_text;
	}
} 
?>
