<?php
class Label extends WebSitePhpObject {
	/**#@+
	* @access private
	*/
	private $label = "";
	private $bold = false;
	private $italic = false;
	private $underline = false;
	private $id = "";
	/**#@-*/

	function __construct($label='', $bold=false, $italic=false, $underline=false) {
		parent::__construct();
		
		$this->label = $label;
		$this->bold = $bold;
		$this->italic = $italic;
		$this->underline = $underline;
	}
	
	public function setBold() {
		$this->bold = true;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function setItalic() {
		$this->italic = true;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function setUnderline() {
		$this->underline = true;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function setId($id) {
		$this->id = $id;
		return $this;
	}
	
	public function setLabel($label) {
		$this->label = $label;
		return $this;
	}
	
	public function getId() {
		return $this->id;
	}
	
	public function render($ajax_render=false) {
		$html = "";
		
		if ($this->id != "") {
			$html .= "<label id=\"".$this->id."\">";
		}
		
		if ($this->bold) {
			$html .= "<b>";
		}
		if ($this->italic) {
			$html .= "<i>";
		}
		if ($this->underline) {
			$html .= "<u>";
		}
		
		$html .= $this->label;
		
		if ($this->italic) {
			$html .= "</i>";
		}
		if ($this->underline) {
			$html .= "</u>";
		}
		if ($this->bold) {
			$html .= "</b>";
		}
		
		if ($this->id != "") {
			$html .= "</label>";
		}
		
		$this->object_change = false;
		return $html;
	}
	
}
?>
