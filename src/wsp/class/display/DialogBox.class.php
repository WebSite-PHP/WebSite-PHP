<?php
/**
 * PHP file wsp\class\display\DialogBox.class.php
 * @package display
 */
/**
 * Class DialogBox
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2011 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package display
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 26/05/2011
 * @version     1.0.98
 * @access      public
 * @since       1.0.17
 */

class DialogBox extends WebSitePhpObject {
	/**#@+
	* DialogBox alignment
	* @access public
	* @var string
	*/
	const ALIGN_LEFT = "left";
	const ALIGN_CENTER = "center";
	const ALIGN_RIGHT = "right";
	/**#@-*/
	
	private static $array_dialog_indices = array();
	
	/**#@+
	* @access private
	*/
	private $title = "";
	private $content = null;
	private $width = "";
	private $height = "";
	private $align = "center";
	private $desactivate = false;
	private $display_from_url = false;
	private $close_button = false;
	private $close_button_js = "";
	
	private $position = "";
	private $position_x = -1;
	private $position_y = -1;
	
	private $dialogbox_indice = "";
	private $one_instance = false;
	private $close_if_instance_exists = false;
	/**#@-*/
	
	/**
	 * Constructor DialogBox
	 * @param string $title 
	 * @param string|object|Url $content_or_url_object 
	 * @param string $width 
	 */
	function __construct($title, $content_or_url_object, $width='') {
		parent::__construct();
		
		if (!isset($title) || !isset($content_or_url_object)) {
			throw new NewException("2 arguments for ".get_class($this)."::__construct() are mandatory", 0, 8, __FILE__, __LINE__);
		}
		
		$this->title = $title;
		$this->content = $content_or_url_object;
		$this->width = $width;
		$this->is_javascript_object = true;
		$this->setDialogBoxLevel(DialogBox::getFirstAvailableDialogBoxLevel());
	}
	
	/**
	 * Method displayFormURL
	 * @access public
	 * @return DialogBox
	 * @since 1.0.35
	 */
	public function displayFormURL() {
		$this->display_from_url = true;
		return $this;
	}
	
	/**
	 * Method setContent
	 * @access public
	 * @param string|object|Url $content_or_url 
	 * @return DialogBox
	 * @since 1.0.35
	 */
	public function setContent($content_or_url) {
		if (gettype($content_or_url) == "object" && get_class($content_or_url) == "DateTime") {
			throw new NewException(get_class($this)."->setContent() error: Please format your DateTime object (\$my_date->format(\"Y-m-d H:i:s\"))", 0, 8, __FILE__, __LINE__);
		}
		$this->content = $content_or_url;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setAlign
	 * @access public
	 * @param string $align 
	 * @return DialogBox
	 * @since 1.0.35
	 */
	public function setAlign($align) {
		$this->align = $align;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setWidth
	 * @access public
	 * @param integer $width 
	 * @return DialogBox
	 * @since 1.0.35
	 */
	public function setWidth($width) {
		$this->width = $width;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setHeight
	 * @access public
	 * @param integer $height 
	 * @return DialogBox
	 * @since 1.0.35
	 */
	public function setHeight($height) {
		$this->height = $height;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setPosition
	 * @access public
	 * @param mixed $position 
	 * @return DialogBox
	 * @since 1.0.35
	 */
	public function setPosition($position) {
		$this->position = $position;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setPositionX
	 * @access public
	 * @param mixed $position_x 
	 * @return DialogBox
	 * @since 1.0.35
	 */
	public function setPositionX($position_x) {
		$this->position_x = $position_x;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setPositionY
	 * @access public
	 * @param mixed $position_y 
	 * @return DialogBox
	 * @since 1.0.35
	 */
	public function setPositionY($position_y) {
		$this->position_y = $position_y;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method activateOneInstance
	 * @access public
	 * @param boolean $close_if_exists [default value: false]
	 * @return DialogBox
	 * @since 1.0.35
	 */
	public function activateOneInstance($close_if_exists=false) {
		$this->one_instance = true;
		$this->close_if_instance_exists = $close_if_exists;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method modal
	 * @access public
	 * @return DialogBox
	 * @since 1.0.35
	 */
	public function modal() {
		$this->desactivate = true;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method close
	 * @access public
	 * @return JavaScript
	 * @since 1.0.35
	 */
	public function close() {
		$js = "";
		$js .= "if (typeof(wspDialogBox".$this->dialogbox_indice.") !== 'undefined') { if (wspDialogBox".$this->dialogbox_indice.".dialog('widget').css('display') == 'block') { ";
		$js .= "wspDialogBox".$this->dialogbox_indice.".dialog('close');";
		$js .= " } } ";
		return new JavaScript($js);
	}
	
	/**
	 * Method activateCloseButton
	 * @access public
	 * @param string $close_button_js 
	 * @return DialogBox
	 * @since 1.0.35
	 */
	public function activateCloseButton($close_button_js="") {
		$this->close_button = true;
		$this->close_button_js = $close_button_js;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method closeAll
	 * @access static
	 * @return JavaScript
	 * @since 1.0.35
	 */
	public static function closeAll() {
		$js = "";
		$array_dialogbox = DialogBox::getArrayDialogBoxLevels();
		$nb_dialogbox = sizeof($array_dialogbox);
		if ($nb_dialogbox == 0) {
			for ($i=0; $i < 5; $i++) {
				$js .= DialogBox::closeLevel($i)->render();
			}
		} else {
			for ($i=0; $i < $nb_dialogbox; $i++) {
				if ($array_dialogbox[$i] != null) {
					$js .= $array_dialogbox[$i]->close()->render();
				}
			}
		}
		return new JavaScript($js);
	}
	
	/**
	 * Method closeLevel
	 * @access static
	 * @param mixed $level 
	 * @return JavaScript
	 * @since 1.0.35
	 */
	public static function closeLevel($level) {
		$js = "";
		$js .= "if (typeof(wspDialogBox".$level.") !== 'undefined') { if (wspDialogBox".$level.".dialog('widget').css('display') == 'block') { ";
		$js .= "wspDialogBox".$level.".dialog('close');";
		$js .= " } } ";
		return new JavaScript($js);
	}
	
	/* Intern management of DialogBox level */
	/**
	 * Method addLevelToInitDialogBox
	 * @access static
	 * @param integer $level 
	 * @param DialogBox $dialog_box_object 
	 * @since 1.0.59
	 */
	private static function addLevelToInitDialogBox($level, $dialog_box_object) {
		self::$array_dialog_indices[$level] = $dialog_box_object;
	}
	
	/**
	 * Method setDialogBoxLevel
	 * @access public
	 * @param mixed $level 
	 * @return DialogBox
	 * @since 1.0.35
	 */
	public function setDialogBoxLevel($level) {
		if ($level > 1) {
			$this->dialogbox_indice = $level;
			DialogBox::addLevelToInitDialogBox($level, $this);
		} else {
			$this->dialogbox_indice = "";
			DialogBox::addLevelToInitDialogBox(1, $this);
		}
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method getFirstAvailableDialogBoxLevel
	 * @access static
	 * @return integer
	 * @since 1.0.35
	 */
	private static function getFirstAvailableDialogBoxLevel() {
		if (isset($_GET['dialogbox_level']) && $_GET['dialogbox_level'] >= 2) {
			$indice = $_GET['dialogbox_level']+1;
		} else {
			$indice = 2;
		}
		while (isset(self::$array_dialog_indices[$indice])) {
			$indice++;
		}
		return $indice;
	}
	
	/**
	 * Method getArrayDialogBoxLevels
	 * @access static
	 * @return array
	 * @since 1.0.35
	 */
	public static function getArrayDialogBoxLevels() {
		if (isset($_GET['dialogbox_level'])) {
			$page_is_init_var = $GLOBALS['__PAGE_IS_INIT__'];
			$GLOBALS['__PAGE_IS_INIT__'] = false; // create object for intern DialogBox management
			$i = 1;
			while ($i <= $_GET['dialogbox_level']) {
				if (self::$array_dialog_indices[$i] == null) {
					$dialog = new DialogBox('', '');
					$dialog->setDialogBoxLevel($i);
				}
				$i++;
			}
			$GLOBALS['__PAGE_IS_INIT__'] = $page_is_init_var;
		}
		return self::$array_dialog_indices;
	}
	
	/**
	 * Method getCurrentDialogBoxLevel
	 * @access static
	 * @return integer
	 * @since 1.0.35
	 */
	public static function getCurrentDialogBoxLevel() {
		if (isset($_GET['dialogbox_level'])) {
			return $_GET['dialogbox_level'];
		} else {
			return -1;
		}
	}
	
	/**
	 * Method getDialogBoxLevel
	 * @access public
	 * @return integer
	 * @since 1.0.35
	 */
	public function getDialogBoxLevel() {
		return $this->dialogbox_indice;
	}
	
	/**
	 * Method getWidth
	 * @access public
	 * @return integer
	 * @since 1.0.35
	 */
	public function getWidth() {
		return $this->width;
	}
	
	/**
	 * Method getHeight
	 * @access public
	 * @return integer
	 * @since 1.0.35
	 */
	public function getHeight() {
		return $this->height;
	}
	
	/**
	 * Method render
	 * @access public
	 * @param boolean $ajax_render [default value: false]
	 * @return string html code of object DialogBox
	 * @since 1.0.35
	 */
	public function render($ajax_render=false) {
		$html = "";
		$html_content = "";
		if (gettype($this->content) == "object" && method_exists($this->content, "render")) {
			$html_content = $this->content->render();
			// Extract JavaScript from HTML
			include_once(dirname(__FILE__)."/../../includes/utils_ajax.inc.php");
			$array_extract_js = extract_javascript($html_content);
			for ($i=1; $i < sizeof($array_extract_js); $i++) {
				new JavaScript("$(document).ready( function() {".$array_extract_js[$i]." } );", true);
			}
			$html_content = $array_extract_js[0];
		} else {
			$html_content = $this->content;
		}
		if (get_class($this->content) != "Url") {
			$html_content = "<div align=\'".$this->align."\'>".addslashes(str_replace("\r", "", str_replace("\n", "", $html_content)))."</div>";
		} else {
			if (find($html_content, "?", 0, 0) > 0) {
				$html_content .= "&dialogbox_level=".($this->dialogbox_indice==""?1:$this->dialogbox_indice);
			} else {
				$html_content .= "?dialogbox_level=".($this->dialogbox_indice==""?1:$this->dialogbox_indice);
			}
		}
		
		if ($this->display_from_url) {
			$html .= "javascript:";
		} else {
			$html .= "jQuery(document).ready(function(){ ";
		}
		$html .= "var create_div = true;";
		if ($this->one_instance) {
			if (!$this->close_if_instance_exists) {
				$html .= "if (typeof(wspDialogBox".$this->dialogbox_indice.") !== 'undefined') { if (wspDialogBox".$this->dialogbox_indice.".dialog('widget').css('display') == 'block') { ";
				if (get_class($this->content) == "Url") {
					$html .= "create_div = false;";
				} else {
					$html .= "wspDialogBox".$this->dialogbox_indice.".dialog('widget').find('.ui-widget-content').html('".$html_content."');";
					$html .= "return false;";
				}
				$html .= " } } ";
			} else {
				$html .= $this->close()->render();
			}
		}
		$html .= "if (create_div) {";
		$html .= "wspDialogBox".$this->dialogbox_indice." = $('";
		$html_div = "<div style=\'display:hidden;z-index:99999".$this->dialogbox_indice.";\'>";
		if (get_class($this->content) != "Url") {
			$html_div .= $html_content;
		}
		if ($this->display_from_url && $GLOBALS['__AJAX_PAGE__'] && !$GLOBALS['__AJAX_LOAD_PAGE__']) {
			$html_div = str_replace("\'", "\\\'", $html_div);
		}
		$html .= $html_div;
		$html .= "</div>').appendTo('body');";
		$html .= " } ";
		
		if (get_class($this->content) == "Url") {
			$html .= "wspDialogBox".$this->dialogbox_indice.".load('".$html_content."', {}, ";
            $html .= "function (responseText, textStatus, XMLHttpRequest) {";
		}
		$html .= "wspDialogBox".$this->dialogbox_indice.".dialog({ title: '".addslashes(str_replace("\r", "", str_replace("\n", "", $this->title)))."'";
		$html .= ", close: function() { wspDialogBox".$this->dialogbox_indice.".dialog('widget').find('.ui-dialog-content').html(''); wspDialogBox".$this->dialogbox_indice.".dialog('widget').remove(); }";
		if ($this->desactivate) {
			$html .= ", modal: true, closeOnEscape: false";
		} else {
			$html .= ", modal: false, closeOnEscape: true";
		}
		if ($this->close_button) {
			$html .= ", buttons: { '".addslashes(__(CLOSE))."': function() { $(this).dialog('close');".$this->close_button_js." } }";
		}
	 	$html .= "});";
	 	if (!is_browser_ie_6()) {
			$html .= "if (create_div) {";
				if ($this->width != "") {
					$html .= "wspDialogBox".$this->dialogbox_indice.".dialog('option', 'width', ".$this->width.");";
				} else {
					$html .= "wspDialogBox".$this->dialogbox_indice.".dialog('option', 'minWidth', 350);";
				}
				if ($this->height != "") {
					$html .= "wspDialogBox".$this->dialogbox_indice.".dialog('option', 'height', ".$this->height.");";
				}
				if ($this->position != "") {
					if (find($this->position, "[", 0, 0) > 0) {
						$html .= "wspDialogBox".$this->dialogbox_indice.".dialog('option', 'position', ".$this->position.");";
					} else {
						$html .= "wspDialogBox".$this->dialogbox_indice.".dialog('option', 'position', '".$this->position."');";
					}
				} else if ($this->position_x > -1 || $this->position_y > -1) {
					$html .= "wspDialogBox".$this->dialogbox_indice.".dialog('option', 'position', [".$this->position_x.",".$this->position_y."]);";
				}
			$html .= "}";
	 	}
	 	if ($this->desactivate) {
	 		$html .= "wspDialogBox".$this->dialogbox_indice.".dialog('widget').find('.ui-dialog-titlebar-close').hide();";
	 	}
		$html .= "setTimeout('LoadPngPicture();', 1);";
		if (get_class($this->content) == "Url") {
            $html .= "});";
		}
		if (!$this->display_from_url) {
			 $html .= "});";
		} else {
			$html .= "return false;";
		}
		$this->object_change = false;
		return $html;
	}
	
	/**
	 * Method getAjaxRender
	 * @access public
	 * @return string javascript code to update initial html of object DialogBox (call with AJAX)
	 * @since 1.0.35
	 */
	public function getAjaxRender() {
		$html = "";
		$save_display_javascript_tag = $this->display_javascript_tag;
		$this->display_javascript_tag = false;
		$html = $this->render(true);
		$this->display_javascript_tag = $save_display_javascript_tag;
		return $html;
	}
}
?>
