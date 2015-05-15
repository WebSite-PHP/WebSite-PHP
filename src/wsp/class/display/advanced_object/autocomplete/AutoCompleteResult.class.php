<?php
/**
 * PHP file wsp\class\display\advanced_object\autocomplete\AutoCompleteResult.class.php
 * @package display
 * @subpackage advanced_object.autocomplete
 */
/**
 * Class AutoCompleteResult
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2015 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package display
 * @subpackage advanced_object.autocomplete
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 12/05/2015
 * @version     1.2.13
 * @access      public
 * @since       1.0.17
 */

class AutoCompleteResult extends WebSitePhpObject {
	/**#@+
	* @access private
	*/
	private $array_result_id = array();
	private $array_result_label = array();
	private $array_result_value = array();
	private $array_result_icon = array();
	/**#@-*/
	
	/**
	 * Constructor AutoCompleteResult
	 */
	function __construct() {
		parent::__construct();
	}
	
	/**
	 * Method add
	 * @access public
	 * @param string $id 
	 * @param string|WebSitePhpObject $label 
	 * @param string $value 
	 * @param string $icon 
	 * @return AutoCompleteResult
	 * @since 1.0.35
	 */
	public function add($id, $label, $value, $icon='') {
		$this->array_result_id[] = str_replace("\n", "", str_replace("\r", "", $id));
		if (gettype($label) == "object" && method_exists($label, "render")) {
			$label = $label->render();
		}
		$this->array_result_label[] = str_replace("\n", "", str_replace("\r", "", $label));
		$this->array_result_value[] = str_replace("\n", "", str_replace("\r", "", $value));
		$this->array_result_icon[] = str_replace("\n", "", str_replace("\r", "", $icon));
		return $this;
	}
	
	/**
	 * Method render
	 * @access public
	 * @param boolean $ajax_render [default value: false]
	 * @return string html code of object AutoCompleteResult
	 * @since 1.0.35
	 */
	public function render($ajax_render=false) {
		$html = "[";
		for ($i=0; $i < sizeof($this->array_result_id); $i++) {
			if ($i > 0) { $html .= ", "; }
			$html .= '{ "id": "'.$this->array_result_id[$i].'", "label": "'.str_replace("\"", "\\\"", $this->array_result_label[$i]).'", "value": "'.str_replace("\"", "\\\"", $this->array_result_value[$i]).'", "icon": "'.$this->array_result_icon[$i].'" }';
		}
		if ($i == 0) { $html .= "{}"; }
		$html .= "]";
		
		$this->object_change = false;
		return $html;
	}
}
?>
