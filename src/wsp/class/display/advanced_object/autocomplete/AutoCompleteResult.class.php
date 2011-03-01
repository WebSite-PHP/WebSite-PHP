<?php
/**
 * Description of PHP file wsp\class\display\advanced_object\autocomplete\AutoCompleteResult.class.php
 * Class AutoCompleteResult
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
 * @copyright   WebSite-PHP.com 05/01/2011
 *
 * @version     1.0.30
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
	/**#@-*/
	
	function __construct() {
		parent::__construct();
	}
	
	/* Intern management of ContextMenuEvent */
	public function add($id, $label, $value) {
		$this->array_result_id[] = $id;
		$this->array_result_label[] = $label;
		$this->array_result_value[] = $value;
		return $this;
	}
	
	public function render($ajax_render=false) {
		$html = "[";
		for ($i=0; $i < sizeof($this->array_result_id); $i++) {
			if ($i > 0) { $html .= ", "; }
			$html .= '{ "id": "'.$this->array_result_id[$i].'", "label": "'.$this->array_result_label[$i].'", "value": "'.$this->array_result_value[$i].'" }';
		}
		$html .= "]";
		
		$this->object_change = false;
		return $html;
	}
}
?>
