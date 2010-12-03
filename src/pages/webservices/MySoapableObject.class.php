<?php
require_once(dirname(__FILE__)."/MySubSoapableObject.class.php");

class MySoapableObject {
	private $text = "";
	private $sub_object = null;
	
	public function setText($txt) {
		$this->text = $txt;
		$this->sub_object = new MySubSoapableObject();
		$this->sub_object->setSubText($txt." [sub_object]");
	}
	
	public function getText() {
		return $this->text;
	}
	
	public function getSubObject() {
		return $this->sub_object;
	}
} 
?>
