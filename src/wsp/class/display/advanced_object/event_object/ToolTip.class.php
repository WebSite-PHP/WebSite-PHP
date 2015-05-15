<?php
/**
 * PHP file wsp\class\display\advanced_object\event_object\ToolTip.class.php
 * @package display
 * @subpackage advanced_object.event_object
 */
/**
 * Class ToolTip
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2015 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package display
 * @subpackage advanced_object.event_object
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 14/05/2015
 * @version     1.2.13
 * @access      public
 * @since       1.0.77
 */

/* Thanks Alban Langloy for his help */

class ToolTip extends WebSitePhpObject {
    /**#@+
     * @access private
     */
    private $id = "";
    private $content = "";
    private $title = "";

    private $params = "";

    private $style = "widget";
    private $add_css = false;
    private $shadow = false;
    private $rounded = false;

    private $follow_cursor = false;
    private $show_slide = false;
    private $show_click = false;
    private $show_fade = false;
    /**#@-*/

	/**
	 * Constructor ToolTip
	 * @param string $content of the tooltip
	 * @param string $params 
	 * @param boolean $follow_cursor [default value: false]
	 * @param string $title title tooltip
	 */
    function __construct($content='', $params='', $follow_cursor=false ,$title='') {
        $this->setId("tooltips_".rand(0, 999999999));
        $this->setContent($content);
        $this->setTitle($title);
        $this->params = $params;
        $this->follow_cursor = $follow_cursor;

        $this->addJavaScript(BASE_URL."wsp/js/jquery.qtip.min.js", "", true);
        $this->addCss(BASE_URL."wsp/css/jquery.qtip.css");
    }

	/**
	 * Method setId
	 * @access public
	 * @param string $id 
	 * @return ToolTip
	 * @since 1.0.77
	 */
    public function setId($id) {
        if (!isset($id) || $id == "") {
            throw new NewException("Error ".get_class($this).": Please set an id", 0, getDebugBacktrace(1));
        }
        $this->id = $id;
        return $this;
    }

	/**
	 * Method setParams
	 * @access public
	 * @param string $params 
	 * @return ToolTip
	 * @since 1.0.77
	 */
    public function setParams($params) {
        $this->params = $params;
        return $this;
    }

	/**
	 * Method setTitle
	 * @access public
	 * @param string $title 
	 * @return ToolTip
	 * @since 1.0.77
	 */
    public function setTitle($title) {
        $this->title = str_replace("'", "&#39;",$title);
        return $this;
    }

	/**
	 * Method setContent
	 * @access public
	 * @param string|WebSitePhpObject $content 
	 * @return ToolTip
	 * @since 1.0.77
	 */
    public function setContent($content) {
        if (gettype($content) == "object")
        {
            $content = $content->render();
        }
        $this->content = ($content=="")?"$('#".$this->id."').title":"'".str_replace("'", "&#39;",$content)."'";
        return $this;
    }

	/**
	 * Method setStyle
	 * @access public
	 * @param string $style or [default|dark|cream|red|green|blue|youtube|youtube-red|youtube-green|jtools|cluetip|tipsy|tipped] [default value: widget]
	 * @return ToolTip
	 * @since 1.0.77
	 */
    public function setStyle($style) {
        if(!preg_match("/^(default|dark|cream|red|green|blue|youtube|youtube-red|youtube-green|jtools|cluetip|tipsy|tipped|widget)$/",$style)) {
            throw new NewException("Error ".get_class($this).": The style \"".$style."\" do not exist.", 0, getDebugBacktrace(1));
        }
        $this->style = $style;
        return $this;
    }

    /*GETTER*/

	/**
	 * Method getParams
	 * @access public
	 * @return mixed
	 * @since 1.0.91
	 */
    public function getParams() {
        return $this->params;
    }

	/**
	 * Method followCursor
	 * @access public
	 * @return ToolTip
	 * @since 1.1.0
	 */
    public function followCursor() {
        $this->follow_cursor = true;
        return $this;
    }

	/**
	 * Method shadow
	 * @access public
	 * @return ToolTip
	 * @since 1.1.0
	 */
    public function shadow() {
        if(preg_match("/^(youtube|youtube-red|youtube-green|jtools|cluetip)$/",$this->style)) {
            throw new NewException("Error ".get_class($this).": The style \"".$this->style."\" is already shadowed.", 0, getDebugBacktrace(1));
        }
        $this->add_css = true;
        $this->shadow = true;
        return $this;
    }

	/**
	 * Method rounded
	 * @access public
	 * @return ToolTip
	 * @since 1.1.0
	 */
    public function rounded() {
        if(preg_match("/^(jtools|tipped)$/",$this->style)) {
            throw new NewException("Error ".get_class($this).": The style \"".$this->style."\" is already rounded.", 0, getDebugBacktrace(1));
        }
        $this->add_css = true;
        $this->rounded = true;
        return $this;
    }

	/**
	 * Method showClick
	 * @access public
	 * @return ToolTip
	 * @since 1.1.0
	 */
    public function showClick() {
        $this->show_click = true;
        return $this;
    }

	/**
	 * Method showSlide
	 * @access public
	 * @return ToolTip
	 * @since 1.1.0
	 */
    public function showSlide() {
        $this->show_slide = true;
        return $this;
    }

	/**
	 * Method showFade
	 * @access public
	 * @return ToolTip
	 * @since 1.1.0
	 */
    public function showFade() {
        $this->show_fade = true;
        return $this;
    }


	/**
	 * Method render
	 * @access public
	 * @param boolean $ajax_render [default value: false]
	 * @since 1.0.77
	 */
    public function render($ajax_render=false) {
        $html = "$(document).ready(function() {\n";
        $html .= "	$('#".$this->id."').qtip({ content: { text:".$this->content;
        if ($this->title != "") {
            $html .= " ,title: '".$this->title."'";
        }
        $html .="}, style: {";
        if($this->style=="widget") {
            $html.="widget: true";
            if($this->add_css)
            {
                $html.=", classes: '";
            }
        } else {
            $html.= "classes: 'ui-tooltip-".$this->style;
        }
        if($this->shadow) {
            $html.=" ui-tooltip-shadow ";
        }
        if($this->rounded)	{
            $html.=" ui-tooltip-rounded ";
        }
        if($this->style!="widget"||$this->add_css==true) {
            $html.="'";
        }
        $html.= "}";
        if($this->params != "") {
            $html .= ", ".$this->params;
        }
        if($this->show_slide) {
            $html .= ", show: {effect: function() { $(this).slideDown();}},hide: {effect: function() { $(this).slideUp();}}";
        }
        if($this->show_click) {
            $html .= ", show: 'click', hide: 'click'";
        }
        if($this->show_fade) {
            $html .= ", show: { effect: function() { $(this).fadeIn();}},hide: {effect: function() { $(this).fadeOut();}}";
        }
        if($this->follow_cursor) {
            $html .= ", position: { my: 'top left', target: 'mouse', viewport: $(window), adjust: { x: 10,  y: 10 } }";
        }
        $html .= " });\n";
        $html .= "});\n";
        return $html;
    }
}
?>
