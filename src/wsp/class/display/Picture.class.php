<?php
class Picture extends WebSitePhpObject {
	/**#@+
	* Align
	* @access public
	* @var string
	*/
	const ALIGN_LEFT = "left";
	const ALIGN_MIDDLE = "middle";
	const ALIGN_ABSMIDDLE = "absmiddle";
	const ALIGN_RIGHT = "right";
	const ALIGN_CENTER = "center";
	/**#@-*/
	
	private static $array_lightbox = array();
	
	/**#@+
	* @access private
	*/
	private $src = "";
	private $height = 0;
	private $width = 0;
	private $border = 0;
	private $align = "";
	private $title = "";
	private $alt = "";
	private $hspace = 0;
	private $vspace = 0;
	private $id = "";
	private $tooltip = false;
	private $tooltip_content = "";
	private $tooltip_params = "";
	private $picture_map = "";
	
	private $is_lightbox = false;
	private $lightbox_name = "";
	private $pic_link = "";
	/**#@-*/
	
	function __construct($src, $height=0, $width=0, $border=0, $align='', $title='') {
		parent::__construct();
		
		if (!isset($src)) {
			throw new NewException("1 argument for ".get_class($this)."::__construct() is mandatory", 0, 8, __FILE__, __LINE__);
		}
		
		$this->src = $src;
		$this->height = $height;
		$this->width = $width;
		$this->border = $border;
		$this->align = $align;
		$this->title = $title;
	}
	
	public function setId($id) {
		$this->id = $id;
		return $this;
	}
	
	public function setHeight($height) {
		$this->height = $height;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function setWidth($width) {
		$this->width = $width;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function setBorder($border) {
		$this->border = $border;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function setAlign($align) {
		$this->align = $align;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function setTitle($title) {
		$this->title = $title;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function setAlt($alt) {
		$this->alt = $alt;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function setHspace($hspace) {
		$this->hspace = $hspace;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function setVspace($vspace) {
		$this->vspace = $vspace;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function addLightbox($lightbox_name='', $pic_link='') {
		$this->is_lightbox = true;
		$this->lightbox_name = $lightbox_name;
		$this->pic_link = $pic_link;
		
		if (!isset(self::$array_lightbox[$this->lightbox_name])) {
			self::$array_lightbox[$this->lightbox_name] = false;
		}
		
		$this->addCss(BASE_URL."wsp/css/jquery.lightbox-0.5.css", "", true);
		$this->addJavaScript(BASE_URL."wsp/js/jquery.lightbox-0.5.min.js", "", true);
		
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function tooltip($params='', $content='') {
		if ($this->id == "") {
			throw new NewException(get_class($this)."->tooltip() error: Please set an id", 0, 8, __FILE__, __LINE__);
		}
		
		$this->tooltip = true;
		$this->tooltip_params = $params;
		$this->tooltip_content = $content;
		$this->addJavaScript(BASE_URL."wsp/js/jquery.qtip-1.0.0-rc3.min.js", "", true);
		
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function setPictureMap($picture_map) {
		if (gettype($picture_map) != "object" && get_class($picture_map) != "PictureMap") {
			throw new NewException(get_class($this)."->setPictureMap() error: \$picture_map must be a PictureMap object", 0, 8, __FILE__, __LINE__);
		}
		
		$this->picture_map = $picture_map;
		
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function getSrc() {
		return $this->src;
	}
	
	public function getHeight() {
		return $this->height;
	}

	public function getWidth() {
		return $this->width;
	}
	
	public function getId() {
		return $this->id;
	}
	
	public function render($ajax_render=false) {
		$html = "";
		$align_center = false;
		if ($this->align == Picture::ALIGN_CENTER) {
			$html .= "<div align=\"center\">\n\t";
			$align_center = true;
			$this->align = "";
		}
		if ($this->is_lightbox) {
			$html .= "<a href=\"";
			if ($this->pic_link != "") {
				$html .= $this->pic_link;
			} else {
				$html .= $this->src;
			}
			$html .= "\" rel=\"lightbox";
			if ($this->lightbox_name != "") {
				$html .= $this->lightbox_name;
			}
			$html .= "\"";
			if ($this->title != "") {
				$html .= " title=\"".str_replace("\"", "&quot;", strip_tags($this->title))."\"";
			}
			$html .= ">";
		}
		if (strtoupper(substr($this->src, 0, 7)) != "HTTP://") {
			$this->src = BASE_URL.$this->src;
		}
		$html .= "<img src=\"".$this->src."\"";
		if ($this->id != "") {
			$html .= " id=\"".$this->id."\"";
		}
		if ($this->height != 0) {
			$html .= " height=\"".$this->height."\"";
		}
		if ($this->width != 0) {
			$html .= " width=\"".$this->width."\"";
		}
		$html .= " border=\"".$this->border."\"";
		if ($this->align != "") {
			if ($this->align == Picture::ALIGN_ABSMIDDLE) {
				$html .= " style=\"vertical-align:middle;\"";
			} else {
				$html .= " align=\"".$this->align."\"";
			}
		}
		if (gettype($this->title) == "object" && method_exists($this->title, "render")) {
			$this->title = $this->title->render();
		}
		if ($this->title != "") {
			$html .= " title=\"".str_replace("\"", "&quot;", strip_tags($this->title))."\"";
			if ($this->alt == "") {
				$html .= " alt=\"".str_replace("\"", "&quot;", strip_tags($this->title))."\"";
			}
		}
		if (gettype($this->alt) == "object" && method_exists($this->alt, "render")) {
			$this->alt = $this->alt->render();
		}
		if ($this->alt != "") {
			$html .= " alt=\"".str_replace("\"", "&quot;", strip_tags($this->alt))."\"";
		}
		if ($this->hspace > 0) {
			$html .= " hspace=\"".$this->hspace."\"";
		}
		if ($this->vspace > 0) {
			$html .= " vspace=\"".$this->vspace."\"";
		}
		if ($this->picture_map != "") {
			$html .= " usemap=\"#".$this->picture_map->getId()."\"";
		}
		$html .= "/>\n";
		
		if ($this->is_lightbox) {
			$html .= "</a>";
		}
		if ($align_center) {
			$html .= "</div>\n";
		}
		if ($this->picture_map != "") {
			$html .= $this->picture_map->render();
		}
		
		if ($this->is_lightbox) {
			if (!self::$array_lightbox[$this->lightbox_name]) {
				$html .= $this->getJavascriptTagOpen();
				$html .= "$(function() { $('a[rel=lightbox";
				if ($this->lightbox_name != "") {
					$html .= $this->lightbox_name;
				}
				$html .= "]').lightBox(); });\n";
				$html .= $this->getJavascriptTagClose();
				self::$array_lightbox[$this->lightbox_name] = true;
			}
		}
		if ($this->tooltip) {
			$html .= $this->getJavascriptTagOpen();
			$html .= "$(document).ready(function() {\n";
			$html .= "	$('#".$this->getId()."').qtip({ content: ".(($this->tooltip_content=="")?"$('#".$this->getId()."').title":"'".addslashes($this->tooltip_content)."'");
			if ($this->tooltip_params != "") {
				$html .= ", ".$this->tooltip_params;
			}
			$html .= " });\n";
			$html .= "});\n";
			$html .= $this->getJavascriptTagClose();
		}
		$this->object_change = false;
		return $html;
	}
}
?>
