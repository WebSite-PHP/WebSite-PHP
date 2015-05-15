<?php
/**
 * PHP file wsp\class\modules\Slider\NivoSlider.class.php
 * @package modules
 * @subpackage Slider
 */
/**
 * Class NivoSlider
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2015 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package modules
 * @subpackage Slider
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 12/05/2015
 * @version     1.2.13
 * @access      public
 * @since       1.2.1
 */

class NivoSlider extends WebSitePhpObject {
	const TRANSITION_RANDOM = "random";
	const TRANSITION_SLICEDOWN = "sliceDown";
	const TRANSITION_SLICEDOWNLEFT = "sliceDownLeft";
	const TRANSITION_SLICEUP = "sliceUp";
	const TRANSITION_SLICEUPLEFT = "sliceUpLeft";
	const TRANSITION_SLICEUPDOWN = "sliceUpDown";
	const TRANSITION_SLICEUPDOWNLEFT = "sliceUpDownLeft";
	const TRANSITION_FOLD = "fold";
	const TRANSITION_FADE = "fade";
	const TRANSITION_SLIDEINRIGHT = "slideInRight";
	const TRANSITION_SLIDEINLEFT = "slideInLeft";
	const TRANSITION_BOXRANDOM = "boxRandom";
	const TRANSITION_BOXRAIN = "boxRain";
	const TRANSITION_BOXRAINREVERSE = "boxRainReverse";
	const TRANSITION_BOXRAINGROW = "boxRainGrow";
	const TRANSITION_BOXRAINGROWREVERSE = "boxRainGrowReverse";
	
	const THEME_DEFAULT = "default";
	const THEME_LIGHT = "light";
	const THEME_DARK = "dark";
	const THEME_BAR = "bar";
	
	/**#@+
	* @access private
	*/
	private $id = "";
	private $width = '';
	private $height = '';
	private $style = '';
	private $pic_list_height = '';
	
	private $rotate_time = '';
	private $transition = 'random';
	private $theme = 'default';
	
	private $array_img_src = array();
	private $array_img_thumbnail = array();
	private $array_img_title = array();
	private $array_img_link = array();
	/**#@-*/
	
	/**
	 * Constructor NivoSlider
	 * @param string $id [default value: nivo-1]
	 * @param string $width 
	 * @param string $height 
	 * @param string $transition [default value: random]
	 * @param string $rotate_time 
	 * @param string $theme [default value: default]
	 */
	function __construct($id='nivo-1', $width='', $height='', $transition='random', $rotate_time='', $theme='default') {
		if ($id == "") {
			throw new NewException("1 argument for ".get_class($this)."::__construct() is mandatory", 0, getDebugBacktrace(1));
		}
		
		$this->id = $id;
		$this->width = $width;
		$this->height = $height;
		$this->transition = $transition;
		$this->rotate_time = $rotate_time;
		$this->theme = $theme;
		
		$this->addCss(BASE_URL."wsp/css/nivo-slider/nivo-slider.css", "", true);
		$this->addCss(BASE_URL."wsp/css/nivo-slider/".$theme."/".$theme.".css", "", true);
		$this->addJavaScript(BASE_URL."wsp/js/jquery.nivo.slider.js", "", true);
		
		$jquery_version_array = explode('.', JQUERY_VERSION);
		if ($jquery_version_array[0] <= 1 && $jquery_version_array[1] < 7) {
			throw new NewException(get_class($this)." error: You need to use jQuery 1.7 or later (configure it on wsp-admin)", 0, getDebugBacktrace(1));
		}
	}
	
	/**
	 * Method addImage
	 * @access public
	 * @param mixed $src 
	 * @param string $src_thumbnail 
	 * @param string $title 
	 * @param string $link 
	 * @return NivoSlider
	 * @since 1.2.1
	 */
	public function addImage($src, $src_thumbnail='', $title='', $link='') {
		if (strtoupper(substr($src, 0, 7)) != "HTTP://" && strtoupper(substr($src, 0, 8)) != "HTTPS://") {
			$src = BASE_URL.$src;
		}
		$this->array_img_src[] = $src;
		if (strtoupper(substr($src_thumbnail, 0, 7)) != "HTTP://" && strtoupper(substr($$src_thumbnail, 0, 8)) != "HTTPS://") {
			$src_thumbnail = BASE_URL.$src_thumbnail;
		}
		$this->array_img_thumbnail[] = $src_thumbnail;
		$this->array_img_title[] = $title;
		$this->array_img_link[] = $link;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setWidth
	 * @access public
	 * @param integer $width 
	 * @return NivoSlider
	 * @since 1.2.7
	 */
	public function setWidth($width) {
		$this->width = $width;
		return $this;
	}
	
	/**
	 * Method setHeight
	 * @access public
	 * @param integer $height 
	 * @return NivoSlider
	 * @since 1.2.7
	 */
	public function setHeight($height) {
		$this->height = $height;
		return $this;
	}
	
	/**
	 * Method setStyle
	 * @access public
	 * @param mixed $style 
	 * @return NivoSlider
	 * @since 1.2.7
	 */
	public function setStyle($style) {
		$this->style = $style;
		return $this;
	}
	
	/**
	 * Method setPictureListHeight
	 * @access public
	 * @param integer $height 
	 * @return NivoSlider
	 * @since 1.2.7
	 */
	public function setPictureListHeight($height) {
		$this->pic_list_height = trim(str_replace("px", "", $height));
		return $this;
	}
	
	/**
	 * Method render
	 * @access public
	 * @param boolean $ajax_render [default value: false]
	 * @return string html code of object NivoSlider
	 * @since 1.2.1
	 */
	public function render($ajax_render=false) {
		$control_nav_thumbs = false;
		$html = "<div class=\"slider-wrapper theme-".$this->theme."\">\n";
        $html .= "<div id=\"slider-".$this->id."\" class=\"nivoSlider\"";
        if ($this->width != "" || $this->height != "" || $this->style != "") {
        	$html .= " style=\"";
        	if ($this->width != "") {
        		$html .= "width:".$this->width."px;";
        	}
        	if ($this->height != "") {
        		$html .= "height:".$this->height."px;";
        	}
        	if ($this->style != "") {
        		$html .= $this->style;
        	}
        	$html .= "\"";
        }
        $html .= ">\n";
		for ($i=0; $i < sizeof($this->array_img_src); $i++) {
			$item_link = createHrefLink($this->array_img_link[$i]);
			if ($item_link != "") {
				$html .= "<a href=\"".$item_link."\">";
			}
			$html .= "<img src=\"".$this->array_img_src[$i]."\" alt=\"\"";
			if ($this->array_img_thumbnail[$i] != "") {
				$html .= " data-thumb=\"".$this->array_img_thumbnail[$i]."\"";
				$control_nav_thumbs = true;
			}
			if ($this->array_img_title[$i] != "") {
				$html .= " title=\"#slider-".$this->id."_".$i."_htmlcaption\"";
			}
			$html .= "/>";
			if ($item_link != "") {
				$html .= "</a>";
			}
			$html .= "\n";
		}
		$html .= "</div>\n";
		$html .= "</div>\n";
		for ($i=0; $i < sizeof($this->array_img_title); $i++) {
			if ($this->array_img_title[$i] != "") {
				$html .= "<div id=\"slider-".$this->id."_".$i."_htmlcaption\" class=\"nivo-html-caption\">\n";
				if (gettype($this->array_img_title[$i])=="object" && method_exists($this->objects[$i], "render")) {
					$html .= $this->array_img_title[$i]->render();
				} else {
					$html .= $this->array_img_title[$i];
				}
				$html .= "\n</div>\n";
			}
		}
		$html .= $this->getJavascriptTagOpen();
		$html .= "$(window).load(function() {\n";
        $html .= "	$('#slider-".$this->id."').nivoSlider({ effect:\"".$this->transition."\"";
        if ($this->rotate_time > 0) {
        	$html .= ", animSpeed:".$this->rotate_time;
        }
        if ($control_nav_thumbs) {
        	$html .= ", controlNavThumbs:true";
        }
        $html .= " });\n";
		if ($this->pic_list_height != "") {
			$html .= " $('.nivo-thumbs-enabled').css('height', '".$this->pic_list_height."px').css('overflow', 'auto');\n";
		}
		$html .= "});\n";
		$html .= $this->getJavascriptTagClose();
		
		$this->object_change = false;
		return $html;
	}
}
?>
