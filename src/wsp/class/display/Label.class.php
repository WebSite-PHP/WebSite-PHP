<?php
class Label extends WebSitePhpObject {
	/**#@+
	* Font family
	* @access public
	* @var string
	*/
	const FONT_ARIAL = "Arial";
	const FONT_TIMES = "Times New Roman";
	/**#@-*/
	
	/**#@+
	* @access private
	*/
	private $label = "";
	private $bold = false;
	private $italic = false;
	private $underline = false;
	
	private $font_size = "";
	private $font_family = "";
	
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
	
	public function setFont($font_size, $font_family) {
		$this->font_size = $font_size;
		$this->font_family = $font_family;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function getId() {
		return $this->id;
	}
	
	public function render($ajax_render=false) {
		$html = "";
		
		if ($this->id != "" || $this->font_size != "" || $this->font_family != "") {
			$html .= "<label id=\"".$this->id."\"";
			if ($this->font_size != "" || $this->font_family != "") {
				$html .= " style=\"";
				if ($this->font_size != "") {
					if (is_integer($this->font_size)) {
						$html .= "font-size:".$this->font_size."pt;";
					} else {
						$html .= "font-size:".$this->font_size.";";
					}
				}
				if ($this->font_family != "") {
					$html .= "font-family:".$this->font_family.";";
				}
				$html .= "\"";
			}
			$html .= ">";
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
		
		if ($this->id != "" || $this->font_size != "" || $this->font_family != "") {
			$html .= "</label>";
		}
		
		$this->object_change = false;
		return $html;
	}
	
}
?>
