<?php
/**
 * Description of PHP file wsp\class\display\advanced_object\treeview\TreeViewItem.class.php
 * Class TreeViewItem
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2011 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 22/10/2010
 *
 * @version     1.0.30
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
	
	private $parent_treeview_item = null;
	private $treeview_items = null;
	/**#@-*/
	
	function __construct($value, $link='', $is_file=true, $path='') {
		parent::__construct();
		
		if (!isset($value)) {
			throw new NewException("1 argument for ".get_class($this)."::__construct() is mandatory", 0, 8, __FILE__, __LINE__);
		}
		
		$this->id = "";
		$this->value = $value;
		$this->old_value = $value;
		$this->link = $link;
		$this->path = str_replace("\\", "/", $path);
		$this->is_file = $is_file;
	}
	
	public function addItem($treeview_item_object) {
		if (get_class($treeview_item_object) != "TreeViewItem" && get_class($treeview_item_object) != "TreeViewFolder" && 
			get_class($treeview_item_object) != "TreeViewFile"  && get_class($treeview_item_object) != "TreeView") {
			throw new NewException("Error TreeViewItem->addItem(): $treeview_items_object is not a TreeViewItem object", 0, 8, __FILE__, __LINE__);
		}
		if ($this->treeview_items == null) {
			$this->setTreeViewItems(new TreeViewItems($treeview_item_object));
		} else {
			$this->treeview_items->add($treeview_item_object);
		}
		return $this;
	}
	
	public function setTreeViewItems($treeview_items_object) {
		if (get_class($treeview_items_object) != "TreeViewItems") {
			throw new NewException("Error TreeViewItem->setTreeViewItems(): $treeview_items_object is not a TreeViewItems object", 0, 8, __FILE__, __LINE__);
		}
		$this->treeview_items = $treeview_items_object;
		$treeview_items_object->setTreeViewItemParent($this);
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/* Intern management of TreeView */
	public function setTreeViewItemParent($treeview_item_object) {
		if (get_class($treeview_item_object) != "TreeViewItem" && get_class($treeview_item_object) != "TreeViewFolder" && 
			get_class($treeview_item_object) != "TreeViewFile"  && get_class($treeview_item_object) != "TreeView") {
			throw new NewException("Error TreeViewItem->setTreeViewItemParent(): $treeview_items_object is not a TreeViewItem object", 0, 8, __FILE__, __LINE__);
		}
		$this->parent_treeview_item = $treeview_item_object;
		$this->id = $this->setPrefixId($treeview_item_object->getId());
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
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
	
	public function collapse() {
		$this->is_close = true;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
    	return $this;
	}
	
	public function expand() {
		$this->is_close = false;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
    	return $this;
	}
	
	public function setValue($value) {
		if (!$this->nodeValueAlreadyExists($value)) {
			$this->value = $value;
			TreeView::refreshAllIds();
			if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		}
    	return $this;
	}
	
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
	public function setPrefixId($prefix_id) {
		$this->id = $prefix_id."_".strtolower(str_replace(" ", "_", $this->value));
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function setPath($path) {
		$this->path = $path;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function getId() {
		return str_replace(".", "_", $this->id);
	}
	
	public function getValue() {
		return $this->value;
	}
	
	/* Intern management of TreeView */
	public function getTreeViewItemsObject() {
		return $this->treeview_items;
	}
	
	public function getChildsTreeViewItemArray() {
		return ($this->treeview_items == null)?array():$this->treeview_items->getTreeViewItemArray();
	}
	
	public function getParentTreeViewItem() {
		return $this->parent_treeview_item;
	}
	
	public function getTreeViewObject() {
		$treeview_object = $this->parent_treeview_item;
		while (get_class($treeview_object) != "TreeView") {
			$treeview_object = $treeview_object->getParentTreeViewItem();
		}
		return $treeview_object;
	}
	
	public function getPath() {
		$path = "";
		$parent_treeview_item = $this;
		while (get_class($parent_treeview_item) != "TreeView") {
			$path = $parent_treeview_item->getValue()."/".$path;
			$parent_treeview_item = $parent_treeview_item->getParentTreeViewItem();
		}
		return $path;
	}
	
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
	
				$html .= "<a href=\"".str_replace("{#file}", $this->path, createHrefLink($this->link))."\" id=\"".$this->getId()."_id\" style=\"white-space: nowrap;\">&nbsp;";
				$html .= $this->value."</a>";
				
				$html .= "</span>";
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
	 * function getAjaxRender
	 * @return string javascript code to update initial html with ajax call
	 */
	public function getAjaxRender() {
		$html = "";
		if ($this->object_change && !$this->is_new_object_after_init) {
			$treeview_object = $this->getTreeViewObject();
			$treeview_object->generateTreeViewIds();
			
			$id = $this->getId();
			if ($this->old_value != $this->value) {
				$tmp_node_id = substr($id, strlen($id)-strlen($this->value), strlen($id));
				$id = str_replace($tmp_node_id, strtolower(str_replace(" ", "_", $this->old_value)), $id);
			}
			$html .= "$('#".$id."_id').parent(\"span\").parent(\"li\").removeClass(\"closed\")";
			if ($this->is_close) {
				$html .= ".addClass(\"closed\")";
			}
			$html .= ";";
			
			if ($this->value != $this->old_value) {
				$html .= "$('#".$id."_id').html(\"&nbsp;".str_replace("\n", "", str_replace("\r", "", addslashes($this->value)))."\");";
				$html .= "$('#".$id."_id').attr(\"id\", \"".$this->getId()."_id\");";
				$html .= "$('#".$id."').attr(\"id\", \"".$this->getId()."\");";
				$html .= $this->generateHtmlChangeSubItemId($this, strlen($this->getId()), $id);
			}
		}
		return $html;
	}
	
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
