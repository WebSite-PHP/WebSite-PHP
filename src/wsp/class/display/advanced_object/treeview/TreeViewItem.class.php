<?php
/**
 * PHP file wsp\class\display\advanced_object\treeview\TreeViewItem.class.php
 * @package display
 * @subpackage advanced_object.treeview
 */
/**
 * Class TreeViewItem
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2015 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package display
 * @subpackage advanced_object.treeview
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 12/05/2015
 * @version     1.2.13
 * @access      public
 * @since       1.0.17
 */

class TreeViewItem extends WebSitePhpObject {
	/**#@+
	* @access private
	*/
	private $id = "";
	private $value = "";
	private $old_value = "";
	private $link = "";
	private $path = "";
	private $is_file = true;
	private $is_close = false;
	private $tooltip_obj = null;
	
	private $parent_treeview_item = null;
	private $treeview_items = null;
	private $array_object_ok = array("Button", "Link");
	/**#@-*/
	
	/**
	 * Constructor TreeViewItem
	 * @param string $value node text
	 * @param string $link node link
	 * @param boolean $is_file is the node a file [default value: true]
	 * @param string $path path to the file (if $is_file is true)
	 */
	function __construct($value, $link='', $is_file=true, $path='') {
		parent::__construct();
		
		if (!isset($value)) {
			throw new NewException("1 argument for ".get_class($this)."::__construct() is mandatory", 0, getDebugBacktrace(1));
		}
		
		$this->id = "";
		$this->value = $value;
		$this->old_value = $value;
		$this->link = $link;
		$this->path = str_replace("\\", "/", $path);
		$this->is_file = $is_file;
	}
	
	/**
	 * Method addItem
	 * @access public
	 * @param TreeViewItem|TreeViewFolder|TreeViewFile|TreeView $treeview_item_object 
	 * @return TreeViewItem
	 * @since 1.0.35
	 */
	public function addItem($treeview_item_object) {
		if (get_class($treeview_item_object) != "TreeViewItem" && get_class($treeview_item_object) != "TreeViewFolder" && 
			get_class($treeview_item_object) != "TreeViewFile"  && get_class($treeview_item_object) != "TreeView") {
			throw new NewException("Error TreeViewItem->addItem(): $treeview_items_object is not a TreeViewItem object", 0, getDebugBacktrace(1));
		}
		if ($this->treeview_items == null) {
			$this->setTreeViewItems(new TreeViewItems($treeview_item_object));
		} else {
			$this->treeview_items->add($treeview_item_object);
		}
		return $this;
	}
	
	/**
	 * Method setTreeViewItems
	 * @access public
	 * @param TreeViewItems $treeview_items_object 
	 * @return TreeViewItem
	 * @since 1.0.35
	 */
	public function setTreeViewItems($treeview_items_object) {
		if (get_class($treeview_items_object) != "TreeViewItems") {
			throw new NewException("Error TreeViewItem->setTreeViewItems(): $treeview_items_object is not a TreeViewItems object", 0, getDebugBacktrace(1));
		}
		$this->treeview_items = $treeview_items_object;
		$treeview_items_object->setTreeViewItemParent($this);
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/* Intern management of TreeView */
	/**
	 * Method setTreeViewItemParent
	 * @access public
	 * @param TreeViewItem|TreeViewFolder|TreeViewFile|TreeView $treeview_item_object 
	 * @return TreeViewItem
	 * @since 1.0.35
	 */
	public function setTreeViewItemParent($treeview_item_object) {
		if (get_class($treeview_item_object) != "TreeViewItem" && get_class($treeview_item_object) != "TreeViewFolder" && 
			get_class($treeview_item_object) != "TreeViewFile"  && get_class($treeview_item_object) != "TreeView") {
			throw new NewException("Error TreeViewItem->setTreeViewItemParent(): $treeview_items_object is not a TreeViewItem object", 0, getDebugBacktrace(1));
		}
		$this->parent_treeview_item = $treeview_item_object;
		$this->id = $this->setPrefixId($treeview_item_object->getId());
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method removeItem
	 * @access public
	 * @return TreeViewItem
	 * @since 1.0.35
	 */
	public function removeItem() {
		$parent_treeview_items = $this->parent_treeview_item->getTreeViewItemsObject();
		if ($parent_treeview_items != null) {
			$treeview_items_array = $parent_treeview_items->getTreeViewItemArray();
			for ($i=0; $i < sizeof($treeview_items_array); $i++) {
				if ($treeview_items_array[$i] != null) {
					if ($treeview_items_array[$i]->getId() == $this->id) {
						$parent_treeview_items->remove($i);
						break;
					}
				}
			}
		}
		return $this;
	}
	
	/**
	 * Method collapse
	 * @access public
	 * @return TreeViewItem
	 * @since 1.0.35
	 */
	public function collapse() {
		$this->is_close = true;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
    	return $this;
	}
	
	/**
	 * Method expand
	 * @access public
	 * @return TreeViewItem
	 * @since 1.0.35
	 */
	public function expand() {
		$this->is_close = false;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
    	return $this;
	}
	
	/**
	 * Method isCollapse
	 * @access public
	 * @return mixed
	 * @since 1.2.3
	 */
	public function isCollapse() {
		return $this->is_close;
	}
	
	/**
	 * Method isExpand
	 * @access public
	 * @return mixed
	 * @since 1.2.3
	 */
	public function isExpand() {
		return !$this->is_close;
	}
	
	/**
	 * Method setValue
	 * @access public
	 * @param mixed $value 
	 * @return TreeViewItem
	 * @since 1.0.35
	 */
	public function setValue($value) {
		if (!$this->nodeValueAlreadyExists($value)) {
			$this->value = $value;
			TreeView::refreshAllIds();
			if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		}
    	return $this;
	}
	
	/**
	 * Method nodeValueAlreadyExists
	 * @access protected
	 * @param string $value 
	 * @return boolean
	 * @since 1.0.35
	 */
	protected function nodeValueAlreadyExists($value) {
		$treeview_items = $this->parent_treeview_item->getChildsTreeViewItemArray();
		for ($i=0; $i < sizeof($treeview_items); $i++) {
			if ($treeview_items[$i]->getValue() == $value) {
				return true;
			}
		}
		return false;
	}
	
	/* Intern management of TreeView */
	/**
	 * Method setPrefixId
	 * @access public
	 * @param string $prefix_id 
	 * @return TreeViewItem
	 * @since 1.0.35
	 */
	public function setPrefixId($prefix_id) {
		$value_id = $this->value;
		if (gettype($this->value) == "object") {
			if (in_array(get_class($this->value), $this->array_object_ok)) {
				$value_id = $this->value->getValue();
			} else {
				throw new NewException("Error TreeViewItem: value need to be a string, ".implode(", ", $array_object_ok), 0, getDebugBacktrace(1));
			}
		}
		
		$this->id = $prefix_id."_".strtolower(str_replace(" ", "_", str_replace("-", "_", url_rewrite_format($value_id))));
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setPath
	 * @access public
	 * @param string $path 
	 * @return TreeViewItem
	 * @since 1.0.35
	 */
	public function setPath($path) {
		$this->path = $path;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method getId
	 * @access public
	 * @return string
	 * @since 1.0.35
	 */
	public function getId() {
		return str_replace(".", "_", $this->id);
	}
	
	/**
	 * Method getValue
	 * @access public
	 * @return string
	 * @since 1.0.35
	 */
	public function getValue() {
		return $this->value;
	}
	
	/* Intern management of TreeView */
	/**
	 * Method getTreeViewItemsObject
	 * @access public
	 * @return mixed
	 * @since 1.0.35
	 */
	public function getTreeViewItemsObject() {
		return $this->treeview_items;
	}
	
	/**
	 * Method getChildsTreeViewItemArray
	 * @access public
	 * @return array
	 * @since 1.0.35
	 */
	public function getChildsTreeViewItemArray() {
		return ($this->treeview_items == null)?array():$this->treeview_items->getTreeViewItemArray();
	}
	
	/**
	 * Method getParentTreeViewItem
	 * @access public
	 * @return TreeViewItem
	 * @since 1.0.35
	 */
	public function getParentTreeViewItem() {
		return $this->parent_treeview_item;
	}
	
	/**
	 * Method getTreeViewObject
	 * @access public
	 * @return TreeView
	 * @since 1.0.35
	 */
	public function getTreeViewObject() {
		$treeview_object = $this->parent_treeview_item;
		while (get_class($treeview_object) != "TreeView") {
			$treeview_object = $treeview_object->getParentTreeViewItem();
		}
		return $treeview_object;
	}
	
	/**
	 * Method getPath
	 * @access public
	 * @return string
	 * @since 1.0.35
	 */
	public function getPath() {
		$path = "";
		$parent_treeview_item = $this;
		while (get_class($parent_treeview_item) != "TreeView") {
			$path = $parent_treeview_item->getValue()."/".$path;
			$parent_treeview_item = $parent_treeview_item->getParentTreeViewItem();
		}
		return $path;
	}
	
	/**
	 * Method tooltip
	 * @access public
	 * @param mixed $tooltip_obj 
	 * @return TreeViewItem
	 * @since 1.0.77
	 */
	public function tooltip($tooltip_obj) {
		if (get_class($tooltip_obj) != "ToolTip") {
			throw new NewException("Error TreeViewItem->tooltip(): \$tooltip_obj is not a ToolTip object", 0, getDebugBacktrace(1));
		}
		$this->tooltip_obj = $tooltip_obj;
		
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method render
	 * @access public
	 * @param boolean $ajax_render [default value: false]
	 * @return string html code of object TreeViewItem
	 * @since 1.0.35
	 */
	public function render($ajax_render=false) {
		$html = "";
		if ($this->parent_treeview_item != null) {
			if (!$ajax_render) {
				$html .= "\t<li";
				if (!$this->is_file && $this->is_close) {
					$html .= " class=\"closed\"";
				}
				$html .= ">";
			
				$html .= "<span class=\"";
				if ($this->is_file) {
					$html .= "file";
				} else {
					$html .= "folder";
				}
				$html .= "\">";
				
				if (gettype($this->value) != "object") {
					$html .= "<a href=\"".str_replace("{#file}", $this->path, str_replace("{#filename}", basename($this->path), createHrefLink($this->link)))."\" id=\"".$this->getId()."_id\" style=\"white-space: nowrap;\">&nbsp;";
					$html .= $this->value."</a>";
				} else if (in_array(get_class($this->value), $this->array_object_ok)) {
					if (get_class($this->value) == "Button") {
						$this->value->forceSpanTag();
					}
					$html .= "<span id=\"".$this->getId()."_id\" style=\"white-space: nowrap;\">&nbsp;";
					$html .= $this->value->render($ajax_render);
					$html .= "</span>";
				} else {
					throw new NewException("Error TreeViewItem: value need to be a string, ".implode(", ", $array_object_ok), 0, getDebugBacktrace(1));
				}
				
				$html .= "</span>";
				
				if ($this->tooltip_obj != null) {
					$this->tooltip_obj->setId($this->getId()."_id");
					$html .= $this->getJavascriptTagOpen();
					$html .= $this->tooltip_obj->render();
					$html .= $this->getJavascriptTagClose();
				}
			}
			
			if ($this->treeview_items != null && sizeof($this->treeview_items) > 0) {
				$html .= "\n".$this->treeview_items->render(false);
			}
			
			if (!$ajax_render) {
				$html .= "</li>\n";
			}
			$this->object_change = false;
		}
		return $html;
	}
	
	/**
	 * Method getAjaxRender
	 * @access public
	 * @return string javascript code to update initial html of object TreeViewItem (call with AJAX)
	 * @since 1.0.35
	 */
	public function getAjaxRender() {
		$html = "";
		if ($this->object_change && !$this->is_new_object_after_init) {
			$treeview_object = $this->getTreeViewObject();
			$treeview_object->generateTreeViewIds();
			
			$old_value = $this->old_value;
			$old_value_id = $this->old_value;
			if (gettype($this->old_value) == "object") {
				if (in_array(get_class($this->old_value), $this->array_object_ok)) {
					if (get_class($this->old_value) == "Button") {
						$this->old_value->forceSpanTag();
					}
					$old_value = $this->old_value->render($ajax_render);
					$old_value_id = $this->old_value->getValue();
				} else {
					throw new NewException("Error TreeViewItem: value need to be a string, ".implode(", ", $array_object_ok), 0, getDebugBacktrace(1));
				}
			}
			$value = $this->value;
			$value_id = $this->value;
			if (gettype($this->value) == "object") {
				if (in_array(get_class($this->value), $this->array_object_ok)) {
					if (get_class($this->value) == "Button") {
						$this->value->forceSpanTag();
					}
					$value = $this->value->render($ajax_render);
					$value_id = $this->value->getValue();
				} else {
					throw new NewException("Error TreeViewItem: value need to be a string, ".implode(", ", $array_object_ok), 0, getDebugBacktrace(1));
				}
			}
			
			$id = $this->getId();
			if ($old_value_id != $value_id) {
				$tmp_node_id = substr($id, strlen($id)-strlen($value_id), strlen($id));
				$id = str_replace($tmp_node_id, strtolower(str_replace(" ", "_", str_replace("-", "_", url_rewrite_format($old_value_id)))), $id);
			}
			$html .= "$('#".$id."_id').parent(\"span\").parent(\"li\").removeClass(\"closed\")";
			if ($this->is_close) {
				$html .= ".addClass(\"closed\")";
			}
			$html .= ";";
			
			if ($value != $old_value) {
				$html .= "$('#".$id."_id').html(\"&nbsp;".str_replace("\n", "", str_replace("\r", "", str_replace('"', '\"', addslashes($value))))."\");";
				$html .= "$('#".$id."_id').attr(\"id\", \"".$this->getId()."_id\");";
				$html .= "$('#".$id."').attr(\"id\", \"".$this->getId()."\");";
				$html .= $this->generateHtmlChangeSubItemId($this, strlen($this->getId()), $id);
			}
		}
		return $html;
	}
	
	/**
	 * Method generateHtmlChangeSubItemId
	 * @access private
	 * @param TreeViewItem $treeview_item 
	 * @param string $new_prefix_id_length 
	 * @param string $old_prefix_id 
	 * @return string javascript code to update node id value
	 * @since 1.0.35
	 */
	private function generateHtmlChangeSubItemId($treeview_item, $new_prefix_id_length, $old_prefix_id) {
		$html = "";
		$treeview_items = $treeview_item->getChildsTreeViewItemArray();
		for ($i=0; $i < sizeof($treeview_items); $i++) {
			if ($treeview_items[$i] != null) {
				$sub_id = $treeview_items[$i]->getId();
				$old_sub_id = $old_prefix_id.substr($sub_id, $new_prefix_id_length, strlen($sub_id));
				$html .= "$('#".$old_sub_id."_id').attr(\"id\", \"".$sub_id."_id\");";
				$html .= "$('#".$old_sub_id."').attr(\"id\", \"".$sub_id."\");";
				$html .= $this->generateHtmlChangeSubItemId($treeview_items[$i], $new_prefix_id_length, $old_prefix_id);
			}
		}
		return $html;
	}
}
?>
