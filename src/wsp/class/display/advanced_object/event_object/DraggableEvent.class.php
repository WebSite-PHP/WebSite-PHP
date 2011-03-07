<?php
/**
 * Description of PHP file wsp\class\display\advanced_object\event_object\DraggableEvent.class.php
 * Class DraggableEvent
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
 * @version     1.0.40
 * @access      public
 * @since       1.0.17
 */

class DraggableEvent extends WebSitePhpObject {
	/**#@+
	* @access private
	*/
	private $draggable_object = null;
	private $draggable_id = "";
	
	private $ondragstart = "";
	private $ondragend = "";
	/**#@-*/
	
	/**
	 * Constructor DraggableEvent
	 * @param mixed $page_object 
	 */
	function __construct($page_object) {
		parent::__construct();
		
		if (!isset($page_object) || gettype($page_object) != "object" || !is_subclass_of($page_object, "Page")) {
			throw new NewException("Argument page_object for ".get_class($this)."::__construct() error", 0, 8, __FILE__, __LINE__);
		}
		
		$this->page_object = $page_object;
		$this->name = $this->page_object->createObjectName($this);
		$this->id = $name;
	}
	
	/**
	 * Method getOnDragStartJs
	 * @access public
	 * @return mixed
	 * @since 1.0.35
	 */
	public function getOnDragStartJs() {
		return $this->ondragstart;
	}
	
	/**
	 * Method onDragStartJs
	 * @access public
	 * @param mixed $js_function 
	 * @return DraggableEvent
	 * @since 1.0.35
	 */
	public function onDragStartJs($js_function) {
		$this->ondragstart = trim($js_function);
		return $this;
	}
	
	/**
	 * Method getOnDragEndJs
	 * @access public
	 * @return mixed
	 * @since 1.0.35
	 */
	public function getOnDragEndJs() {
		return $this->ondragend;
	}
	
	/**
	 * Method onDragEndJs
	 * @access public
	 * @param mixed $js_function 
	 * @return DraggableEvent
	 * @since 1.0.35
	 */
	public function onDragEndJs($js_function) {
		$this->ondragend = trim($js_function);
		return $this;
	}
	
	/* Intern management of DraggableEvent */
	/**
	 * Method setDraggableId
	 * @access public
	 * @param mixed $id 
	 */
	public function setDraggableId($id) {
		$this->draggable_id = $id;
	}
	
	/**
	 * Method getDraggableId
	 * @access public
	 * @return mixed
	 * @since 1.0.35
	 */
	public function getDraggableId() {
		return $this->draggable_id;
	}
	
	/**
	 * Method render
	 * @access public
	 * @param boolean $ajax_render [default value: false]
	 * @return mixed
	 * @since 1.0.35
	 */
	public function render($ajax_render=false) {
		if (DialogBox::getCurrentDialogBoxLevel() > -1) {
			$this->ondragstart  = "wspDialogBox".DialogBox::getCurrentDialogBoxLevel().".dialog('widget').css('overflow', 'visible'); wspDialogBox".DialogBox::getCurrentDialogBoxLevel().".dialog('widget').find('.ui-dialog-content').css('overflow', 'visible');".$this->ondragstart;
			$this->ondragend  = "wspDialogBox".DialogBox::getCurrentDialogBoxLevel().".dialog('widget').css('overflow', 'hidden'); wspDialogBox".DialogBox::getCurrentDialogBoxLevel().".dialog('widget').find('.ui-dialog-content').css('overflow', 'hidden');".$this->ondragend;
		} else if (isset($_GET['tabs_object_id'])) {
			$this->ondragstart  = "$('#".$_GET['tabs_object_id']."').tabs().css('overflow', 'visible');$('#".$_GET['tabs_object_id']."').tabs().find('.ui-widget-content').css('overflow', 'visible');".$this->ondragstart;
			$this->ondragend  = "$('#".$_GET['tabs_object_id']."').tabs().css('overflow', 'hidden');$('#".$_GET['tabs_object_id']."').tabs().find('.ui-widget-content').css('overflow', 'hidden');".$this->ondragend;
		}
		
		if ($this->ondragstart != "") {
			$this->page_object->addObject(new JavaScript("$('#".$this->draggable_id."').bind('dragstart', function(event, ui) { ".$this->ondragstart." });"));
		}
		if ($this->ondragend != "") {
			$this->page_object->addObject(new JavaScript("$('#".$this->draggable_id."').bind('dragstop', function(event, ui) { ".$this->ondragend." });"));
		}
		$this->object_change = false;
		return "";
	}
}
?>
