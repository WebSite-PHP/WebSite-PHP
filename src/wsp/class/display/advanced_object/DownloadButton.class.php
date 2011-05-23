<?php
/**
 * PHP file wsp\class\display\advanced_object\DownloadButton.class.php
 * @package display
 * @subpackage advanced_object
 */
/**
 * Class DownloadButton
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2011 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package display
 * @subpackage advanced_object
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 22/10/2010
 * @version     1.0.79
 * @access      public
 * @since       1.0.17
 */

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
	
	/**
	 * Constructor DownloadButton
	 * @param mixed $link 
	 * @param mixed $download_text 
	 * @param string $download_sub_text 
	 * @param string $link_target 
	 */
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
	
	/**
	 * Method setImageSrc
	 * @access public
	 * @param mixed $image_src 
	 * @return DownloadButton
	 * @since 1.0.55
	 */
	public function setImageSrc($image_src) {
		$this->download_image = $image_src;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setImageWidth
	 * @access public
	 * @param integer $width 
	 * @return DownloadButton
	 * @since 1.0.55
	 */
	public function setImageWidth($width) {
		$this->download_image_width = $width;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setImageHeight
	 * @access public
	 * @param integer $height 
	 * @return DownloadButton
	 * @since 1.0.55
	 */
	public function setImageHeight($height) {
		$this->download_image_height = $height;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setTopPositionText
	 * @access public
	 * @param mixed $top 
	 * @return DownloadButton
	 * @since 1.0.55
	 */
	public function setTopPositionText($top) {
		$this->top_position_text = $top;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setLeftPositionText
	 * @access public
	 * @param mixed $left 
	 * @return DownloadButton
	 * @since 1.0.55
	 */
	public function setLeftPositionText($left) {
		$this->left_position_text = $left;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method render
	 * @access public
	 * @param boolean $ajax_render [default value: false]
	 * @return string html code of object DownloadButton
	 * @since 1.0.55
	 */
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
