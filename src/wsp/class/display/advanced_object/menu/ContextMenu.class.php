<?php
/**
 * PHP file wsp\class\display\advanced_object\menu\ContextMenu.class.php
 * @package display
 * @subpackage advanced_object.menu
 */
/**
 * Class ContextMenu
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2015 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package display
 * @subpackage advanced_object.menu
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 12/05/2015
 * @version     1.2.13
 * @access      public
 * @since       1.0.17
 */

class ContextMenu extends WebSitePhpObject {
	const CONTEXTMENU_ICON_EDIT = "edit";
	const CONTEXTMENU_ICON_CUT = "cut";
	const CONTEXTMENU_ICON_COPY = "copy";
	const CONTEXTMENU_ICON_PASTE = "paste";
	const CONTEXTMENU_ICON_PAGE = "page";
	const CONTEXTMENU_ICON_PAGE_ADD = "page_add";
	const CONTEXTMENU_ICON_PAGE_DELETE = "page_delete";
	const CONTEXTMENU_ICON_PAGE_RENAME = "page_rename";
	const CONTEXTMENU_ICON_FOLDER = "folder";
	const CONTEXTMENU_ICON_FOLDER_ADD = "folder_add";
	const CONTEXTMENU_ICON_FOLDER_DELETE = "folder_delete";
	const CONTEXTMENU_ICON_FOLDER_RENAME = "folder_rename";
	const CONTEXTMENU_ICON_DELETE = "delete";
	const CONTEXTMENU_ICON_RENAME = "rename";
	const CONTEXTMENU_ICON_QUIT = "quit";
	const CONTEXTMENU_ICON_PICTURE = "picture";
	const CONTEXTMENU_ICON_PICTURE_ADD = "picture_add";
	const CONTEXTMENU_ICON_PICTURE_DELETE = "picture_delete";
	const CONTEXTMENU_ICON_PICTURE_EDIT = "picture_edit";
	const CONTEXTMENU_ICON_LINK = "link";
	const CONTEXTMENU_ICON_FAIL = "fail";
	const CONTEXTMENU_ICON_SUCCESS = "success";
	const CONTEXTMENU_ICON_REDO = "redo";
	
	/**#@+
	* @access private
	*/
	private $id = "";
	private $array_item = array();
	private $array_item_fct = array();
	private $array_item_icon = array();
	private $array_item_sep = array();
	private $attach_object_id = array();
	
	private $dialogbox_level = -1;
	/**#@-*/
	
	/**
	 * Constructor ContextMenu
	 * @param mixed $id 
	 */
	function __construct($id) {
		parent::__construct();
		
		if (!isset($id)) {
			throw new NewException("1 argument for ".get_class($this)."::__construct() is mandatory", 0, getDebugBacktrace(1));
		}
		
		$this->id = $id;
		
		$this->addCss(BASE_URL."wsp/css/jquery.contextMenu.css", "", true);
		$this->addJavaScript(BASE_URL."wsp/js/jquery.contextMenu.js", "", true);
	}
	
	/**
	 * Method addItem
	 * @access public
	 * @param mixed $text 
	 * @param string $contextmenu_icon 
	 * @param string $event_js_or_object 
	 * @param boolean $separator [default value: false]
	 * @return ContextMenu
	 * @since 1.0.35
	 */
	public function addItem($text, $contextmenu_icon='', $event_js_or_object='', $separator=false) {
		if (gettype($event_js_or_object) == "object") {
			if (get_class($event_js_or_object) != "ContextMenuEvent" && get_class($event_js_or_object) != "DialogBox" && !is_subclass_of($event_js_or_object, "DialogBox")) {
				throw new NewException("Error ContextMenu->addItem(): $event_js_or_object is not a string or ContextMenuEvent or DialogBox object", 0, getDebugBacktrace(1));
			}
		}
		$this->array_item[] = $text;
		$this->array_item_fct[] = $event_js_or_object;
		$this->array_item_icon[] = $contextmenu_icon;
		$this->array_item_sep[] = $separator;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method attachContextMenuToObjectId
	 * @access public
	 * @param mixed $object_id 
	 * @return ContextMenu
	 * @since 1.0.35
	 */
	public function attachContextMenuToObjectId($object_id) {
		$this->attach_object_id[] = $object_id;
		if (DialogBox::getCurrentDialogBoxLevel() > 0) {
			$this->isInDialogBoxLevel(DialogBox::getCurrentDialogBoxLevel());
		}
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method isInDialogBoxLevel
	 * @access private
	 * @param mixed $dialogbox_level 
	 * @return ContextMenu
	 * @since 1.0.35
	 */
	private function isInDialogBoxLevel($dialogbox_level) {
		$this->dialogbox_level = $dialogbox_level;
		return $this;
	}
	
	/**
	 * Method render
	 * @access public
	 * @param boolean $ajax_render [default value: false]
	 * @return string html code of object ContextMenu
	 * @since 1.0.35
	 */
	public function render($ajax_render=false) {
		$html = "";
		if (!$ajax_render) {
			$menu_html = "<ul id=\"".$this->id."\" class=\"contextMenu\">\n";
			for ($i=0; $i < sizeof($this->array_item); $i++) {
				$menu_html .= "	<li";
				if ($this->array_item_icon[$i]!="" || $this->array_item_sep[$i]!=false) {
					$menu_html .= " class=\"";
					if ($this->array_item_icon[$i]!="") {
						$menu_html .= $this->array_item_icon[$i];
					}
					if ($this->array_item_sep[$i]!=false) {
						if ($this->array_item_icon[$i]!="") {
							$menu_html .= " ";
						}
						$menu_html .= "separator";
					}
					$menu_html .= "\"";
				}
				$menu_html .= "><a href=\"#".$i;
				$menu_html .= "\">".$this->array_item[$i]."</a></li>\n";
			}
			$menu_html .= "</ul>\n";
			if ($this->getPage()->isAjaxLoadPage()) {
				$html .= $menu_html;
			}
			
			$array_context_menu_displayed = array();
			for ($i=0; $i < sizeof($this->array_item_fct); $i++) {
				if ($this->array_item_fct[$i] != "") {
					if (gettype($this->array_item_fct[$i]) == "object") {
						if (get_class($this->array_item_fct[$i]) == "ContextMenuEvent") {
							if (!in_array($this->array_item_fct[$i]->getName(), $array_context_menu_displayed)) {
								$html .= "	".$this->array_item_fct[$i]->render()."\n";
								$array_context_menu_displayed[] = $this->array_item_fct[$i]->getName();
							}
						}
					}
				}
			}
			$html .= $this->getJavascriptTagOpen();
			$html .= "$(document).ready( function() {\n";
			if (!$this->getPage()->isAjaxLoadPage()) {
				$html .= "$('body').append('".addslashes(str_replace("\r", "", str_replace("\n", "", $menu_html)))."');\n";
			}
			for ($i=0; $i < sizeof($this->array_item_fct); $i++) {
				$html .= "contextMenuFct_".$this->id."_".$i." = function(el, pos) {\n";
				if ($this->array_item_fct[$i] != "") {
					if (gettype($this->array_item_fct[$i]) == "object") {
						if (get_class($this->array_item_fct[$i]) == "ContextMenuEvent") {
							$html .= "	onClickContextMenu_".$this->array_item_fct[$i]->getEventObjectName()."($(el).attr('id'));\n";
						} else {
							$html .= "	".$this->array_item_fct[$i]->render()."\n";
						}
					} else {
						$html .= "	".$this->array_item_fct[$i]."\n";
					}
				} else {
					$html .= "	alert(
					'Element ID: ' + $(el).attr('id') + '\\n\\n' + 
					'Element HTML: ' + $(el).html() + '\\n\\n' + 
					'X: ' + pos.x + '  Y: ' + pos.y + ' (relative to element)\\n\\n' + 
					'X: ' + pos.docX + '  Y: ' + pos.docY+ ' (relative to document)'
					);\n";
				}
				$html .= "};\n";
			}
		}
		
		for ($i=0; $i < sizeof($this->attach_object_id); $i++) {
			$html .= "	";
			if (find($this->attach_object_id[$i], "$(", 0, 0) > 0) {
				$object = $this->attach_object_id[$i];
			} else {
				$object .= "$(\"#".$this->attach_object_id[$i]."\")";
			}
			$html .= "if (".$object." != null) { ".$object.".destroyContextMenu();".$object.".contextMenu({\n";
			$html .= "		menu: '".$this->id."'\n";
			if ($this->dialogbox_level > -1) {
				$html .= "		,offsetObject: wspDialogBox".$this->dialogbox_level.".dialog('widget').find('.ui-dialog-content')\n";
			} else if (isset($_GET['tabs_object_id'])) {
				$html .= "		,offsetObject: $('#".$_GET['tabs_object_id']."').tabs()\n";
			}
			$html .= "		},\n";
			$html .= "		function(action, el, pos) {\n";
			$html .= "			eval('contextMenuFct_".$this->id."_' + action + '(el, pos)');\n";
			$html .= "		});\n	}\n";
		}
		
		if (!$ajax_render) {
			$html .= "});\n";
			$html .= $this->getJavascriptTagClose();
		}
		$this->object_change = false;
		return $html;
	}
}
?>
