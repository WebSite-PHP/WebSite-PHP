<?php
include_once("TextBox.class.php");

class Password extends TextBox {
	function __construct($page_or_form_object, $name='', $id='', $value='', $width='', $length=0) {
		parent::__construct($page_or_form_object, $name, $id, $value, $width, $length);
		$this->type = "password";
	}
}
?>
