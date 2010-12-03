<?php
class DownloadButton extends WebSitePhpObject {
	/**#@+
	* Box style
	* @access public
	* @var string
	*/
	const IMAGE_BLACK_SRC = "wsp/img/download_button/download_button_black.png";
	const IMAGE_BLUE_SRC = "wsp/img/download_button/download_button_blue.png";
	const IMAGE_GREEN_SRC = "wsp/img/download_button/download_button_green.png";
	const IMAGE_ORANGE_SRC = "wsp/img/download_button/download_button_orange.png";
	const IMAGE_RED_SRC = "wsp/img/download_button/download_button_red.png";
	const IMAGE_VIOLET_SRC = "wsp/img/download_button/download_button_violet.png";
	const IMAGE_YELLOW_SRC = "wsp/img/download_button/download_button_yellow.png";
	/**#@-*/
	
	/**#@+
	* @access private
	*/
	private $link = "";
	private $download_text = "";
	private $download_sub_text = "";
	private $link_target = "";
	
	private $download_image = "wsp/img/download_button/download_button_blue.png";
	private $download_image_width = 200;
	private $download_image_height = 60;
	private $top_position_text = 2;
	private $left_position_text = 62;
	/**#@-*/
	
	function __construct($link, $download_text, $download_sub_text='', $link_target='') {
		parent::__construct();
		
		if (!isset($link) || !isset($download_text)) {
			throw new NewException("2 arguments for ".get_class($this)."::__construct() are mandatory", 0, 8, __FILE__, __LINE__);
		}
		
		$this->link = $link;
		$this->download_text = $download_text;
		$this->download_sub_text = $download_sub_text;
		$this->link_target = $link_target;
	}
	
	public function setImageSrc($image_src) {
		$this->download_image = $image_src;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function setImageWidth($width) {
		$this->download_image_width = $width;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function setImageHeight($height) {
		$this->download_image_height = $height;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function setTopPositionText($top) {
		$this->top_position_text = $top;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function setLeftPositionText($left) {
		$this->left_position_text = $left;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function render($ajax_render=false) {
		$html = "";
		
		$html .= "<a href=\"".$this->link."\">\n";
		$html .= "	<div style=\"width:".$this->download_image_width."px;height:".$this->download_image_height."px;background:url('".BASE_URL.$this->download_image."') no-repeat;position:relative;\">\n";
		$html .= "		<div style=\"position:absolute;top:".$this->top_position_text."px;left:".$this->left_position_text."px;text-align:left;width:".($this->download_image_width - $this->left_position_text)."px;\">\n";
		$html .= "			<div style=\"font-weight:bold;font-size:14pt;\">".$this->download_text."</div>\n";
		$html .= "			".$this->download_sub_text."\n";
		$html .= "		</div>\n";
		$html .= "	</div>\n";
		$html .= "</a>\n";
		$this->object_change = false;
		return $html;
	}
}
?>
