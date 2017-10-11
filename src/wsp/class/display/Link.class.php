<?php
/**
 * PHP file wsp\class\display\Link.class.php
 * @package display
 */
/**
 * Class Link
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2017 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package display
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 05/02/2017
 * @version     1.2.15
 * @access      public
 * @since       1.0.17
 */

global $is_label_link_already_converted;
$GLOBALS['is_label_link_already_converted'] = false;
class Link extends WebSitePhpObject {
	
	/**#@+
	* Target
	* @access public
	* @var string
	*/
	const TARGET_BLANK = "_blank";
	const TARGET_SELF = "_self";
	const TARGET_TOP = "_top";
	const TARGET_PARENT = "_parent";
	const TARGET_NONE = "";
	/**#@-*/
	
	private static $array_lightbox = array();
	
	/**#@+
	* @access private
	*/
	private $id = "";
	private $link = "";
	private $target = "";
	private $content = null;
	private $tagH = "";
	private $tagH_bold = false;
	private $nofollow = false;
	
	private $is_lightbox = false;
	private $lightbox_name = "";
	
	private $onclick = "";
	private $track_categ = "";
	private $track_action = "";
	private $track_label = "";
	
	private $rel = "";
	private $property = "";
	private $style = "";
	private $class = "";
	private $tooltip_obj = null;
	private $tooltip_title = "";
	private $itemprop = false;
	/**#@-*/
	
	/**
	 * Constructor Link
	 * @param mixed $link 
	 * @param string $target 
	 * @param object $content [default value: null]
	 */
	function __construct($link, $target='', $content=null) {
		parent::__construct();
		
		/*if (!isset($link)) {
			throw new NewException("1 argument for ".get_class($this)."::__construct() is mandatory", 0, getDebugBacktrace(1));
		}*/
		$this->link = $link;
		$this->target = $target;
		$this->content = $content;
		$this->tagH = "";
	}
	
	/**
	 * Method setLink
	 * @access public
	 * @param mixed $link 
	 * @return Link
	 * @since 1.2.3
	 */
	public function setLink($link) {
		$this->link = $link;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setId
	 * @access public
	 * @param mixed $id 
	 * @return Link
	 * @since 1.2.3
	 */
	public function setId($id) {
		$this->id = $id;
		return $this;
	}
	
	/**
	 * Method setContent
	 * @access public
	 * @param object $content 
	 * @return Link
	 * @since 1.0.35
	 */
	public function setContent($content) {
		$this->content = $content;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setTitleTagH1
	 * @access public
	 * @param boolean $bold [default value: true]
	 * @return Link
	 * @since 1.0.35
	 */
	public function setTitleTagH1($bold=true) {
		$this->tagH = "h1";
		$this->tagH_bold = $bold;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setTitleTagH2
	 * @access public
	 * @param boolean $bold [default value: false]
	 * @return Link
	 * @since 1.0.35
	 */
	public function setTitleTagH2($bold=false) {
		$this->tagH = "h2";
		$this->tagH_bold = $bold;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setTitleTagH
	 * @access public
	 * @param mixed $value 
	 * @param boolean $bold [default value: false]
	 * @return Link
	 * @since 1.0.35
	 */
	public function setTitleTagH($value, $bold=false) {
		$this->tagH = "h".$value;
		$this->tagH_bold = $bold;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setNofollowLink
	 * @access public
	 * @return Link
	 * @since 1.0.67
	 */
	public function setNofollowLink() {
		$this->nofollow = true;
		return $this;
	}
	
	/**
	 * Method setRel
	 * @access public
	 * @param mixed $rel 
	 * @return Link
	 * @since 1.2.0
	 */
	public function setRel($rel) {
		$this->rel = $rel;
		return $this;
	}
	
	/**
	 * Method setProperty
	 * @access public
	 * @param mixed $property 
	 * @return Link
	 * @since 1.2.0
	 */
	public function setProperty($property) {
		$this->property = $property;
		return $this;
	}
	
	/**
	 * Method setStyle
	 * @access public
	 * @param mixed $style 
	 * @return Link
	 * @since 1.2.3
	 */
	public function setStyle($style) {
		$this->style = $style;
		return $this;
	}
	
	/**
	 * Method setClass
	 * @access public
	 * @param mixed $class 
	 * @return Link
	 * @since 1.2.8
	 */
	public function setClass($class) {
		$this->class = $class;
		return $this;
	}
		
	/**
	 * Method addLightbox
	 * @access public
	 * @param string $lightbox_name 
	 * @return Link
	 * @since 1.0.35
	 */
	public function addLightbox($lightbox_name='') {
		$this->is_lightbox = true;
		$this->lightbox_name = $lightbox_name;
		
		if (!isset(self::$array_lightbox[$this->lightbox_name])) {
			self::$array_lightbox[$this->lightbox_name] = false;
		}
		
		$this->addCss(BASE_URL."wsp/css/jquery.lightbox-0.5.css", "", true);
		$this->addJavaScript(BASE_URL."wsp/js/jquery.lightbox-0.5.min.js", "", true);
		
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method getLink
	 * @access public
	 * @return mixed
	 * @since 1.0.35
	 */
	public function getLink() {
		return $this->link;
	}
	
	/**
	 * Method getTarget
	 * @access public
	 * @return mixed
	 * @since 1.0.35
	 */
	public function getTarget() {
		return $this->target;
	}
	
	/**
	 * Method getId
	 * @access public
	 * @return mixed
	 * @since 1.2.3
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * Method setTrackEvent
	 * @access public
	 * @param mixed $category 
	 * @param mixed $action 
	 * @param string $label 
	 * @return Link
	 * @since 1.0.96
	 */
	public function setTrackEvent($category, $action, $label='') {
		if (GOOGLE_CODE_TRACKER == "") {
			throw new NewException(get_class($this)."->setTrackEvent() error: please define google code tracker in the website configuration", 0, getDebugBacktrace(1));
		}
		$this->track_categ = $category;
		$this->track_action = $action;
		$this->track_label = $label;
		return $this;
	}
	
	/**
	 * Method onClickJs
	 * @access public
	 * @param mixed $js_function 
	 * @return Link
	 * @since 1.0.96
	 */
	public function onClickJs($js_function) {
		if (gettype($js_function) != "string" && get_class($js_function) != "JavaScript" && !is_subclass_of($js_function, "JavaScript")) {
			throw new NewException(get_class($this)."->onClickJs(): \$js_function must be a string or JavaScript object.", 0, getDebugBacktrace(1));
		}
		if (get_class($js_function) == "JavaScript" || is_subclass_of($js_function, "JavaScript")) {
			$js_function = $js_function->render();
		}
		$this->onclick = trim($js_function);
		return $this;
	}
	
	/**
	 * Method tooltip
	 * @access public
	 * @param mixed $tooltip_obj 
	 * @param mixed $title 
	 * @return Link
	 * @since 1.2.5
	 */
	public function tooltip($tooltip_obj, $title) {
		if (get_class($tooltip_obj) != "ToolTip") {
			throw new NewException("Error Picture->tooltip(): \$tooltip_obj is not a ToolTip object", 0, getDebugBacktrace(1));
		}
		if ($this->id == "") {
			throw new NewException(get_class($this)."->tooltip() error: You must define an id to the Link object.", 0, getDebugBacktrace(1));
		}
		
		$this->tooltip_obj = $tooltip_obj;
		
		if (gettype($title) == "object" && method_exists($title, "render")) {
			$title = $title->render();
		}
		$this->tooltip_title = $title;
		
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setItemProp
	 * @access public
	 * @return Link
	 * @since 1.2.7
	 */
	public function setItemProp() {
		$this->itemprop = true;
		return $this;
	}
	
	/**
	 * Method getOnClickJs
	 * @access public
	 * @return mixed
	 * @since 1.0.96
	 */
	public function getOnClickJs() {
		return $this->onclick;
	}
	
	/**
	 * Method getUserHaveRights
	 * @access public
	 * @return boolean
	 * @since 1.0.35
	 */
	public function getUserHaveRights() {
		// check user have right to view this local link
		if (gettype($this->link) == "object") {
			if (get_class($this->link) == "Link") {
				$tmp_link = $this->link->getLink();
			} else {
				if (get_class($this->link) != "DialogBox" && !is_subclass_of($this->link, "DialogBox") && get_class($this->link) != "JavaScript") {
					if (method_exists($this->link, "render")) {
						$tmp_link = $this->link->render();
					} else {
						$tmp_link = $this->link;
					}
				}
			}
		} else {
			$tmp_link = $this->link;
		}
		if (($tmp_link != null || empty($this->link)) && strtoupper(substr($tmp_link, 0, 11)) != "JAVASCRIPT:" && strtoupper(substr($tmp_link, 0, 7)) != "MAILTO:" &&
			strtoupper(substr($tmp_link, 0, 6)) != "FTP://" && strtoupper(substr($tmp_link, 0, 1)) != "#" &&
			get_class($this->link) != "DialogBox" && !is_subclass_of($this->link, "DialogBox") && get_class($this->link) != "JavaScript") {
				
			if (strtoupper(substr($tmp_link, 0, strlen(BASE_URL))) == strtoupper(BASE_URL)
				|| (strtoupper(substr($tmp_link, 0, 7)) != "HTTP://" && strtoupper(substr($tmp_link, 0, 8)) != "HTTPS://")) {
				
				$array_url = explode("?", $tmp_link);
				$temp_class_name = str_replace(".html", "", str_replace(BASE_URL, "", str_replace(BASE_URL.$_SESSION['lang']."/", "", $array_url[0])));
				if ($temp_class_name == "") {
					$temp_class_name = "home";
				}
				if (file_exists("pages/".$temp_class_name.".php")) {
					$page_obj = Page::getInstance($temp_class_name);
					if (!$page_obj->userHaveRights()) {
						$no_user_rights_redirect = $page_obj->getUserNoRightsRedirect();
						if ($no_user_rights_redirect != "") {
							$this->link = $no_user_rights_redirect;
						} else {
							return false;
						}
					}
				} else {
					$pos = find($tmp_link, "?p=", 1, 0);
					if ($pos == 0) {
						$pos = find($tmp_link, "&p=", 1, 0);
					}
					if ($pos > 0) {
						$pos2 = find($tmp_link, "&", 1, $pos)-1;
						if ($pos2 == -1) {
							$pos2 = strlen($tmp_link);
						}
						$page_name = substr($tmp_link, $pos, $pos2-$pos);
						if (file_exists("pages/".$page_name.".php")) {
							$page_obj = Page::getInstance($page_name);
							if (!$page_obj->userHaveRights()) {
								$no_user_rights_redirect = $page_obj->getUserNoRightsRedirect();
								if ($no_user_rights_redirect != "") {
									$this->link = $no_user_rights_redirect;
								} else {
									return false;
								}
							}
						}
					}
				}
			}
			if ((!defined('NO_ADD_AUTO_LINK_BASE_URL') || NO_ADD_AUTO_LINK_BASE_URL !== true) &&
				strtoupper(substr($tmp_link, 0, 7)) != "HTTP://" && strtoupper(substr($tmp_link, 0, 8)) != "HTTPS://") {
					// it's a local URL
					if (strtoupper(substr($tmp_link, 0, strlen(BASE_URL))) != strtoupper(BASE_URL)) {
						$this->link = BASE_URL.$_SESSION['lang']."/".$this->link;
					}
			}
		}
		return true;
	}
	
	/**
	 * Method render
	 * @access public
	 * @param boolean $ajax_render [default value: false]
	 * @return string html code of object Link
	 * @since 1.0.35
	 */
	public function render($ajax_render=false) {
		if (!$this->getUserHaveRights()) {
			return "";
		}
		
		// write link
		$html = "";
		if ($this->tagH != "") {
			$html .= "<".$this->tagH.">";
		}
		
		if ($this->track_categ != "") {
			if (get_class($this->link) == "Link") {
				$this->onclick .= "var link_url=$(this).attr('href');";
			}
			$this->onclick .= "if (isGoogleAnalyticsLoaded()) { ga('send', 'event', '".addslashes($this->track_categ)."', '".addslashes($this->track_action)."', '".addslashes($this->track_label)."'";
			if (get_class($this->link) == "Link" && $this->link->getUserHaveRights() && $this->link->getTarget() == Link::TARGET_NONE) {
				$this->onclick .= ", {'hitCallback': function(){window.location.href = link_url;}}); return false;";
			} else {
				$this->onclick .= ");";
			}
            $this->onclick .= "} else { window.location.href = link_url; }";
		}
		
		$html .= "<a";
		if ($this->link != null) {
			$html .= " href=\"".createHrefLink($this->link, $this->target, $this->onclick)."\"";
		}
		if ($this->id != "") {
			$html .= " id=\"".$this->id."\"";
		}
		if ($this->is_lightbox) {
			$html .= " rel=\"lightbox";
			if ($this->lightbox_name != "") {
				$html .= $this->lightbox_name;
			}
			$html .= "\"";
		}
		if ($this->tagH != "" || $this->style != "") {
			$html .= " style=\"";
			if ($this->tagH == "h1" && !$this->tagH_bold) {
				$html .= "font-weight:normal;";
			} else if ($this->tagH != "h1" && $this->tagH_bold) {
				$html .= "font-weight:bold;";
			}
			if ($this->style != "") {
				$html .= $this->style;
			}
			$html .= "\"";
		}
		if ($this->nofollow && !$this->is_lightbox && $this->rel == "") {
			$html .= " rel=\"nofollow\"";
		}
		if ($this->rel != "" && !$this->is_lightbox && !$this->nofollow) {
			$html .= " rel=\"".$this->rel."\"";
		}
		if ($this->property != "") {
			$html .= " property=\"".$this->property."\"";
		}
		
		if ($this->onclick != "" && find($html, "javascript:void(0);\" onClick=\"", 1) == 0) {
			$html .= " onClick=\"".$this->onclick."\"";
		}
		if ($this->tooltip_obj != null) {
			$html .= " oldtitle=\"".str_replace("'", "&#39;", str_replace("\"", "&quot;", str_replace("\n", "", str_replace("\r", "", $this->tooltip_title))))."\" data-hasqtip=\"true\"";
		}
		if ($this->itemprop) {
			$html .= " itemprop=\"url\"";
		}
		if ($this->class != "") {
			$html .= " class=\"".$this->class."\"";
		}
		$html .= ">";
		if (gettype($this->content) == "object" && method_exists($this->content, "render")) {
			$html_content = "";
			if (get_class($this->content) == "Object") {
				$html_content = str_replace(">\n <br/>", "><br/>", str_replace(">\n <BR/>", "><BR/>", str_replace(">\n <br />", "><br />", str_replace(">\n <BR />", "><BR />", $this->content->render()))));
			} else {
				if (get_class($this->content) == "Label" && !$GLOBALS['is_label_link_already_converted']) {
					$this->getPage()->addObject(new JavaScript("$('a label').bind('click', function() {location.href=$(this).closest('a').attr('href');});"), false, true);
                    $GLOBALS['is_label_link_already_converted'] = true;
				}
				$html_content = $this->content->render();
			}
			// Revove carriage return on the end of the string before writing </a> 
			$ind_security = 0;
			while ($html_content[strlen($html_content)-1] == "\n" || $html_content[strlen($html_content)-1] == "\r") {
				$html_content = substr($html_content, 0, strlen($html_content)-1);
				$ind_security++;
				if ($ind_security > 10) {
					break;
				}
			}
			$html .= $html_content;
		} else {
			$html .= $this->content;
		}
		$html .= "</a>";
		if ($this->tagH != "") {
			$html .= "</".$this->tagH.">";
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
		if ($this->tooltip_obj != null) {
			$this->tooltip_obj->setId($this->getId());
			$html .= $this->getJavascriptTagOpen();
			$html .= $this->tooltip_obj->render();
			$html .= $this->getJavascriptTagClose();
		}
		$this->object_change = false;
		return $html;
	}
	
	
	/**
	 * Method getAjaxRender
	 * @access public
	 * @return string javascript code to update initial html of object Link (call with AJAX)
	 * @since 1.2.3
	 */
	public function getAjaxRender() {
		$html = "";
		if ($this->object_change && !$this->is_new_object_after_init) {
			if ($this->id == "") {
				throw new NewException("Error Link: You must specified an id (setId())", 0, getDebugBacktrace(1));
			}
			
			$html .= "$('#".$this->getId()."').attr('href', \"".$this->link."\");\n";
			$html .= "$('#".$this->getId()."').attr('target', \"".$this->target."\");\n";
			
			$html_content = "";
			if (gettype($this->content) == "object" && method_exists($this->content, "render")) {
				if (get_class($this->content) == "Object") {
					$html_content = str_replace(">\n <br/>", "><br/>", str_replace(">\n <BR/>", "><BR/>", str_replace(">\n <br />", "><br />", str_replace(">\n <BR />", "><BR />", $this->content->render()))));
				} else {
					$html_content = $this->content->render();
				}
				// Revove carriage return on the end of the string before writing </a> 
				$ind_security = 0;
				while ($html_content[strlen($html_content)-1] == "\n" || $html_content[strlen($html_content)-1] == "\r") {
					$html_content = substr($html_content, 0, strlen($html_content)-1);
					$ind_security++;
					if ($ind_security > 10) {
						break;
					}
				}
			} else {
				$html_content = $this->content;
			}
			$html .= "$('#".$this->getId()."').html('".addslashes($html_content)."');\n";
			
			if ($this->style != "") {
				$html .= "$('#".$this->getId()."').attr('style', \"".$this->style."\");\n";
			}
			
			$this->object_change = false;
		}
		return $html;
	}
}
?>
