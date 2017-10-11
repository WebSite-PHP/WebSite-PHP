<?php
/**
 * PHP file wsp\class\display\advanced_object\autocomplete\AutoComplete.class.php
 * @package display
 * @subpackage advanced_object.autocomplete
 */
/**
 * Class AutoComplete
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2017 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package display
 * @subpackage advanced_object.autocomplete
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 11/10/2017
 * @version     1.2.15
 * @access      public
 * @since       1.0.17
 */

class AutoComplete extends WebSitePhpObject {
	/**#@+
	* @access private
	*/
	private $autocomplete_url = null;
	private $autocomplete_min_length = 4;
	private $autocomplete_event = null;
	private $indicator_id = "";
	
	private $track_categ = "";
	private $track_action = "";
	private $track_label = "";
	private $track_use_search_value = false;
	private $track_pageview = false;
	/**#@-*/
	
	/**
	 * Constructor AutoComplete
	 * @param Url $url_object 
	 * @param double $min_lenght [default value: 4]
	 * @param AutoCompleteEvent $autocomplete_event [default value: null]
	 * @param string $indicator_id id of object to display when searching
	 */
	function __construct($url_object, $min_lenght=4, $autocomplete_event=null, $indicator_id="") {
		parent::__construct();
		
		if (gettype($url_object) != "object" && get_class($url_object) != "Url") {
			throw new NewException("AutoComplete: \$url_object must be a Url object", 0, getDebugBacktrace(1));
		}
		if ($autocomplete_event != null) {
			if (gettype($autocomplete_event) != "object" && get_class($autocomplete_event) != "AutoCompleteEvent") {
				throw new NewException("AutoComplete: \$autocomplete_event must be a AutoCompleteEvent object", 0, getDebugBacktrace(1));
			}
		}
		$this->autocomplete_url = $url_object;
		$this->autocomplete_min_length = $min_lenght;
		$this->autocomplete_event = $autocomplete_event;
		$this->indicator_id = $indicator_id;
	}
	
	/* Intern management of AutoComplete */
	/**
	 * Method setLinkObjectId
	 * @access public
	 * @param string $id 
	 * @since 1.0.59
	 */
	public function setLinkObjectId($id) {
		$this->link_object_id = $id;
	}
	
	/**
	 * Method setTrackEvent
	 * @access public
	 * @param mixed $category 
	 * @param mixed $action 
	 * @param string $label 
	 * @param boolean $use_search_value [default value: true]
	 * @return AutoComplete
	 * @since 1.0.95
	 */
	public function setTrackEvent($category, $action, $label='', $use_search_value=true) {
		if (GOOGLE_CODE_TRACKER == "") {
			throw new NewException(get_class($this)."->setTrackEvent() error: please define google code tracker in the website configuration", 0, getDebugBacktrace(1));
		}
		$this->track_categ = $category;
		$this->track_action = $action;
		$this->track_label = $label;
		$this->track_use_search_value = $use_search_value;
		return $this;
	}
	
	/**
	 * Method setTrackPageView
	 * @access public
	 * @return AutoComplete
	 * @since 1.0.95
	 */
	public function setTrackPageView() {
		if (GOOGLE_CODE_TRACKER == "") {
			throw new NewException(get_class($this)."->setTrackEvent() error: please define google code tracker in the website configuration", 0, getDebugBacktrace(1));
		}
		$this->track_pageview = true;
		return $this;
	}
	
	/**
	 * Method render
	 * @access public
	 * @param boolean $ajax_render [default value: false]
	 * @return string html code of object AutoComplete
	 * @since 1.0.35
	 */
	public function render($ajax_render=false) {
		$html = "";
		$html .= $this->getJavascriptTagOpen();
		$html .= "$(document).ready( function() {\n";
		$html .= "\$('#".$this->link_object_id."').autocomplete({ source: function(request, response) {
	        $.ajax({
	            url: '".$this->autocomplete_url->render()."',
	            dataType: 'json',
	            data: { term : request.term },
	            success: response /* response is a callable accepting data parameter. no reason to wrap in anonymous function. */
	        });
        }, minLength: ".$this->autocomplete_min_length.", ";
		$html .= "search: function( event, ui ) { ";
		if (GOOGLE_CODE_TRACKER != "" && !isLocalDebug() && 
			!defined('GOOGLE_CODE_TRACKER_NOT_ACTIF')) {
				if ($this->track_categ != "") {
					$html .= "if (isGoogleAnalyticsLoaded()) { ga('send', 'event', '".addslashes($this->track_categ)."', '".addslashes($this->track_action)."', '".addslashes($this->track_label)."'";
					if ($this->track_use_search_value) {
						$html .= ", trim(\$('#".$this->link_object_id."').val())";
					}
					//$html .= ", {'hitCallback': function() {alert('analytics.js done sending data');}}";
					$html .= "); }";
				}
				if ($this->track_pageview) {
					$html .= "if (isGoogleAnalyticsLoaded()) { ga('send', 'pageview', {'page': '/".str_replace($this->getPage()->getBaseURL(), "", $this->autocomplete_url->render())."?term='+urlencode(trim(\$('#".$this->link_object_id."').val()))}); }";
				}
		}
		if ($this->indicator_id != "") {
			$html .= "$('#".$this->indicator_id."').css('display', 'block');$('#".$this->indicator_id."').css('visibility', 'visible');";
		}
		$html .= " }, ";
		$html .= "open: function( event, ui ) { ";
		$html .= "	$('.ui-resizable').css('z-index', '0');";
		$html .= "	var dialog = $(this).closest('.ui-dialog');";
		$html .= "	if(dialog.length > 0) {";
		$html .= "		dialog.zIndex($('.ui-widget-overlay').zIndex()+1);";
		$html .= "	}";
		if ($this->indicator_id != "") {
			$html .= "$('#".$this->indicator_id."').css('visibility', 'hidden');";
		}
		$html .= " }, ";
		$html .= "select: function( event, ui ) { ";
		if ($this->autocomplete_event != null) {
			$html .= $this->autocomplete_event->render();
		}
		$html .= " }, ";
		$html .= "close: function( event, ui ) { ";
		$html .= "	$('.ui-resizable').css('z-index', '2');";
		$html .= "	var dialog = $(this).closest('.ui-dialog');";
		$html .= "	if(dialog.length > 0) {";
		$html .= "		dialog.zIndex($('.ui-widget-overlay').zIndex()+1);";
		$html .= "	}";
		$html .= " }";
		$html .= " })\n";
		$html .= ".data(\"autocomplete\")._renderItem = function(ul, item) {\n";
		$html .= "	if (item.icon == '') {
				return $(\"<li></li>\").data(\"item.autocomplete\", item).append(\"<a>\" + item.label + \"</a>\" ).appendTo(ul);
			} else {
				return $(\"<li></li>\").data(\"item.autocomplete\", item).append(\"<a><img src='\" + item.icon + \"' border='0' height='20' align='absmiddle'/> \" + item.label + \"</a>\" ).appendTo(ul);
			}
		}";
		$html .= ";\n";
		$html .= "});\n";
		$html .= $this->getJavascriptTagClose();
		$this->object_change = false;
		return $html;
	}
}
?>
