<?php
class GoogleSearchResult extends WebSitePhpObject {
	private $content_page = "";
	private $content_result = "";
	
	function __construct($content_page="", $content_result="") {
		parent::__construct();
		$this->content_page = $content_page;
		$this->content_result = $content_result;
	}
	
	public function setContentPage($content_page) {
		$this->content_page = $content_page;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function setContentResult($content_result) {
		$this->content_result = $content_result;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function render($ajax_render=false) {
		$html = "<div id=\"cse-result-div\" style=\"text-align:left;display:none;padding-right:10px;padding-left:10px;\">";
		if ($this->content_result != "" && method_exists($this->content_result, "setContent")) {
			$this->content_result->setContent("<div id=\"cse-result\"></div>");
			$html .= $this->content_result->render();
		} else {
			$html .= "<div id=\"cse-result\"></div>";
		}
		$html .= "</div>\n";
		$html .= "<div id=\"cse-normal-content\">";
		if ($this->content_page != "") {
			if (gettype($this->content_page) == "object") {
				$html .= "\n".$this->content_page->render($ajax_render)."\n";
			} else {
				$html .= "\n".$this->content_page."\n";
			}
		}
		$html .= "</div>";
		$this->object_change = false;
		return $html;
	}
}
?>
