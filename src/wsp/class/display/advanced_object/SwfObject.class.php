<?php
class SwfObject extends WebSitePhpObject {
	/**#@+
	* @access private
	*/
	private $id = "";
	private $swf_file = "";
	private $width = 0;
	private $height = 0;
	private $text = "";
	
	private $params = array();
	private $variables = array();
	/**#@-*/
	
	function __construct($id, $swf_file, $width, $height, $optional_text='') {
		parent::__construct();
		
		if (!isset($id) || !isset($swf_file) || !isset($width) || !isset($height)) {
			throw new NewException("4 arguments for ".get_class($this)."::__construct() are mandatory", 0, 8, __FILE__, __LINE__);
		}
		
		$this->id = $id;
		$this->swf_file = $swf_file;
		$this->width = $width;
		$this->height = $height;
		$this->text = $optional_text;
		
		$this->addJavaScript(BASE_URL."wsp/js/swfobject.js", "", true);
	}
	
	public function addParam($name, $value) {
		$this->params[$name] = $value;
	}
	
	public function addVariable($name, $value) {
		$this->variables[$name] = $value;
	}
	
	public function setOptionalText($text) {
		$this->text = $text;
		return $this;
	}
	
	public function render($ajax_render=false) {
		$html = "";
		$html .= "<div id=\"".$this->id."\" align=\"center\">\n";
		$html .= "	<br/>".__(DOWNLOAD_FLASH_PLAYER)."<br/>\n";
		if ($this->text != "") {
			$html .= "	".$this->text."<br/>\n";
		}
		$html .= "</div>\n";
		$html .= $this->getJavascriptTagOpen();
		$html .= "	var ".$this->id." = new SWFObject(\"".$this->swf_file."\", \"SWFObject_".$this->id."\", ".$this->width.", ".$this->height.", \"9\");\n";
		
		foreach ($this->params as $name => $value) {
			$html .= "	".$this->id.".addParam(\"".$name."\",\"".$value."\");\n";
		}
		
		foreach ($this->variables as $name => $value) {
			$html .= "	".$this->id.".addVariable(\"".$name."\",\"".$value."\");\n";
		}
		
		$html .= "	".$this->id.".addParam(\"wmode\",\"transparent\");\n";
		$html .= "	".$this->id.".write(\"".$this->id."\");\n";
		$html .= $this->getJavascriptTagClose();
		$this->object_change = false;
		return $html;
	}
}
?>