<?php
class LinkPage extends WebSitePhpObject {
	/**#@+
		* @access private
		*/
	private $page = "";
	private $picture_16 = "";
	private $object = null;
	private $get = "";
	private $tagH = "";
	/**#@-*/
	
	function __construct($page, $object, $picture_16='') {
		parent::__construct();
		
		if (!isset($page) || !isset($object)) {
			throw new NewException("2 argument for ".get_class($this)."::__construct() are mandatory", 0, 8, __FILE__, __LINE__);
		}
		
		$this->page = $page;
		$this->object = $object;
		$this->picture_16 = $picture_16;
		$this->tagH = "";
	}
	
	public function setGetParameters($get) {
		$this->get = $get;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function setTitleTagH1() {
		$this->tagH = "1";
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function setTitleTagH2() {
		$this->tagH = "2";
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function setTitleTagH($value) {
		$this->tagH = $value;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function getUserHaveRights() {
		$tmp_link = new Link($this->page, Link::TARGET_NONE);
		return $tmp_link->getUserHaveRights();
	}
	
	public function render($ajax_render=false) {
		$link_obj = new Object($this->object);
		if ($this->picture_16 != "") {
			$link_obj = new Object(new Picture($this->picture_16, 16, 16, 0, Picture::ALIGN_ABSMIDDLE, $this->object), $this->object);
		} 
		if (strtoupper($this->page) == "HOME") {
			$link_url = BASE_URL.$_SESSION['lang']."/";
		} else {
			$link_url = $this->page.".html";
		}
		if ($this->get != "") {
			if ($this->get[0] == "?") {
				$link_url .= $this->get;
			} else {
				$link_url .= "?".$this->get;
			} 
		}
		$html = new Link($link_url, Link::TARGET_NONE, $link_obj);
		if ($this->tagH != "") {
			$html->setTitleTagH($this->tagH);
		}
		$this->object_change = false;
		return $html->render();
	}
}
?>
