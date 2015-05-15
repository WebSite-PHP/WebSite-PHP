<?php
/**
 * PHP file wsp\class\display\advanced_object\Accordion.class.php
 * @package display
 * @subpackage advanced_object
 */
/**
 * Class Accordion
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2015 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package display
 * @subpackage advanced_object
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 12/05/2015
 * @version     1.2.13
 * @access      public
 * @since       1.1.4
 */

class Accordion extends WebSitePhpObject {
	private $id = "";
	private $array_section_title = array();
	private $array_section_content = array();
	
	private $fill_space = false;
	private $fill_space_min_height = 140;
	private $no_auto_height = false;
	private $collapse_content = false;
	private $open_onmouseover = false;
	private $open_onmousehint = false;
	private $icon = "";
	private $icon_selected = "";
	
	/**
	 * Constructor Accordion
	 * @param string $id [default value: accordion]
	 */
	function __construct($id='accordion') {
		$this->id = str_replace("-", "_", $id);
	}
	
	/**
	 * Method addSection
	 * @access public
	 * @param mixed $title 
	 * @param object $content_or_url 
	 * @return Accordion
	 * @since 1.1.4
	 */
	public function addSection($title, $content_or_url) {
		$this->array_section_title[] = $title;
		$this->array_section_content[] = $content_or_url;
		
		return $this;
	}
	
	/**
	 * Method fillSpace
	 * @access public
	 * @param mixed $min_height 
	 * @return Accordion
	 * @since 1.1.4
	 */
	public function fillSpace($min_height) {
		$this->fill_space = true;
		$this->fill_space_min_height = $min_height;
		return $this;
	}
	
	/**
	 * Method noAutoHeight
	 * @access public
	 * @return Accordion
	 * @since 1.1.4
	 */
	public function noAutoHeight() {
		$this->no_auto_height = true;
		return $this;
	}
	
	/**
	 * Method collapseContent
	 * @access public
	 * @return Accordion
	 * @since 1.1.4
	 */
	public function collapseContent() {
		$this->collapse_content = true;
		return $this;
	}
	
	/**
	 * Method openOnMouseOver
	 * @access public
	 * @return Accordion
	 * @since 1.1.4
	 */
	public function openOnMouseOver() {
		$this->open_onmouseover = true;
		return $this;
	}
	
	/**
	 * Method openOnMouseHint
	 * @access public
	 * @return Accordion
	 * @since 1.1.4
	 */
	public function openOnMouseHint() {
		$this->open_onmousehint = true;
		return $this;
	}
	
	/**
	 * Method setIcon
	 * @access public
	 * @param mixed $icon_16px 
	 * @param mixed $icon_selected_16px 
	 * @return Accordion
	 * @since 1.1.4
	 */
	public function setIcon($icon_16px, $icon_selected_16px) {
		if (strtoupper(substr($icon_16px, 0, 7)) != "HTTP://" || strtoupper(substr($icon_16px, 0, 8)) != "HTTPS://") {
			$icon_16px = $this->getPage()->getBaseURL().$icon_16px;
		}
		$this->icon = $icon_16px;
		if (strtoupper(substr($icon_selected_16px, 0, 7)) != "HTTP://" || strtoupper(substr($icon_selected_16px, 0, 8)) != "HTTPS://") {
			$icon_selected_16px = $this->getPage()->getBaseURL().$icon_selected_16px;
		}
		$this->icon_selected = $icon_selected_16px;
		return $this;
	}
	
	/**
	 * Method render
	 * @access public
	 * @param boolean $ajax_render [default value: false]
	 * @return string html code of object Accordion
	 * @since 1.1.4
	 */
	public function render($ajax_render=false) {
		$html = "";
		
		// Icon Css
		if ($this->icon != "") {
			$html .= "<style type=\"text/css\" media=\"screen\">";
			$html .= " #".$this->id." .ui-button-icon-accordion { background-image: url(".$this->icon."); } ";
			if ($this->icon_selected != "") {
				$html .= " #".$this->id." .ui-button-icon-accordion-selected { background-image: url(".$this->icon_selected."); } ";
			}
			$html .= "</style>\n";
		}
		
		// Accordion content
		$html .= "<div>\n";
		$html .= "<div id=\"".$this->id."\">\n";
		for ($i=0; $i < sizeof($this->array_section_title); $i++) {
			$html .= "<h3 style=\"display:block;\"><a href=\"#\">".$this->array_section_title[$i]."</a></h3>\n";
			$html .= "<div>\n";
			if (gettype($this->array_section_content[$i]) == "object" && method_exists($this->array_section_content[$i], "render")) {
				$content = $this->array_section_content[$i]->render($ajax_render);
			} else {
				$content = $this->array_section_content[$i];
			} 
			$html .= $content."\n";
			$html .= "</div>\n";
			
			// Ajax loading
			if (gettype($object)=="object" && get_class($object)=="Url") {
				$html .= $this->getJavascriptTagOpen();
				$html .= "$('#".$this->id."_".$i."').load('".$loaded_url."', {}, ";
		        $html .= "function (response, status, xhr) { if (status == 'error' && response != '') { $('#".$this->id."_".$i."').html('<table><tr><td><img src=\'".$this->getPage()->getCDNServerURL()."wsp/img/warning.png\' height=\'24\' width=\'24\' border=\'0\' align=\'absmidlle\'/></td><td><b>Error</b></td></tr></table>' + response); } } );";
		        $html .= $this->getJavascriptTagClose();
			}
		}
		$html .= "</div>\n";
		$html .= "</div>\n";
		
		// Accordion Js
		$html .= $this->getJavascriptTagOpen();
		$html .= "$(function() { \n";
		if ($this->icon != "") {
			$html .= "icons_".$this->id." = {\n";
			$html .= "	header: 'ui-button-icon-accordion',\n";
			if ($this->icon_selected != "") {
				$html .= "	headerSelected: 'ui-button-icon-accordion-selected'\n";
			} else {
				$html .= "	headerSelected: 'ui-button-icon-accordion'\n";
			}
			$html .= "};\n";
		}
		$html .= "$(\"#".$this->id."\").accordion({";
		$param_exist = false;
		if ($this->fill_space) {
			if ($param_exist) { $html .= ", "; }
			$param_exist = true;
			$html .= "fillSpace: true";
		}
		if ($this->no_auto_height) {
			if ($param_exist) { $html .= ", "; }
			$param_exist = true;
			$html .= "autoHeight: false, navigation: true";
		}
		if ($this->collapse_content) {
			if ($param_exist) { $html .= ", "; }
			$param_exist = true;
			$html .= "collapsible: true";
		}
		if ($this->open_onmouseover) {
			if ($param_exist) { $html .= ", "; }
			$param_exist = true;
			$html .= "event: 'mouseover'";
		} else if ($this->open_onmousehint) {
			if ($param_exist) { $html .= ", "; }
			$param_exist = true;
			$html .= "event: 'click hoverintent'";
		}
		if ($this->icon != "") {
			if ($param_exist) { $html .= ", "; }
			$param_exist = true;
			$html .= "icons: icons_".$this->id;
		}
		$html .= "});\n";
		if ($this->fill_space) {
			$html .= "$(\"#".$this->id."Resizer\").resizable({
				minHeight: ".$this->fill_space_min_height.",
				resize: function() {
					$(\"#".$this->id."\").accordion(\"resize\");
				}
			});\n";
		}
		if ($this->icon != "") {
			$html .= "$('#toggle').button().toggle(function() {
					$(\"#".$this->id."\").accordion(\"option\", \"icons\", false );
				}, function() {
					$(\"#".$this->id."\").accordion(\"option\", \"icons\", icons_".$this->id.");
				});\n";
		}
		$html .= "});\n";
		if ($this->open_onmousehint) {
			$html .= "$.event.special.hoverintent = {
				setup: function() {
					$( this ).bind(\"mouseover\", jQuery.event.special.hoverintent.handler );
				},
				teardown: function() {
					$( this ).unbind(\"mouseover\", jQuery.event.special.hoverintent.handler );
				},
				handler: function( event ) {
					var self = this,
						args = arguments,
						target = $( event.target ),
						cX, cY, pX, pY;
					
					function track( event ) {
						cX = event.pageX;
						cY = event.pageY;
					};
					pX = event.pageX;
					pY = event.pageY;
					function clear() {
						target
							.unbind(\"mousemove\", track )
							.unbind(\"mouseout\", arguments.callee );
						clearTimeout( timeout );
					}
					function handler() {
						if ( ( Math.abs( pX - cX ) + Math.abs( pY - cY ) ) < cfg.sensitivity ) {
							clear();
							event.type = \"hoverintent\";
							// prevent accessing the original event since the new event
							// is fired asynchronously and the old event is no longer
							// usable (#6028)
							event.originalEvent = {};
							jQuery.event.handle.apply( self, args );
						} else {
							pX = cX;
							pY = cY;
							timeout = setTimeout( handler, cfg.interval );
						}
					}
					var timeout = setTimeout( handler, cfg.interval );
					target.mousemove( track ).mouseout( clear );
					return true;
				}
			};\n";
		}
		$html .= $this->getJavascriptTagClose();
		
		return $html;
	}
}
?>
