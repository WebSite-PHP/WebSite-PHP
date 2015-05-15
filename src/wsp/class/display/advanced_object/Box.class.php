<?php
/**
 * PHP file wsp\class\display\advanced_object\Box.class.php
 * @package display
 * @subpackage advanced_object
 */
/**
 * Class Box
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
 * @copyright   WebSite-PHP.com 14/05/2015
 * @version     1.2.13
 * @access      public
 * @since       1.0.17
 */

class Box extends WebSitePhpObject {
    /**#@+
     * Box style
     * @access public
     * @var string
     */
    const STYLE_MAIN = "1";
    const STYLE_SECOND = "2";
    /**#@-*/

    /**#@+
     * Box alignment
     * @access public
     * @var string
     */
    const ALIGN_LEFT = "left";
    const ALIGN_CENTER = "center";
    const ALIGN_RIGHT = "right";
    const ALIGN_JUSTIFY = "justify";
    /**#@-*/

    /**#@+
     * Box vertical alignment
     * @access public
     * @var string
     */
    const VALIGN_TOP = "top";
    const VALIGN_CENTER = "center";
    const VALIGN_BOTTOM = "bottom";
    /**#@-*/

    /**#@+
     * @access private
     */
    private $title = "";
    private $style_header = "1";
    private $style_content = "1";
    private $shadow = false;
    private $link = "";
    private $id = "";
    private $content = null;
    private $width = "100%";
    private $height = "";
    private $valign = "top";
    private $align = "center";
    private $is_browser_ie_6 = false;
    private $browser_ie_version = false;
    private $browser_name = "";
    private $browser_version = 0;
    private $css3=false;
    private $tagH = "";
    private $icon_16_pixels = "";
    private $icon_16_pixels_text = "";
    private $icon_48_pixels = "";
    private $icon_48_pixels_text = "";

    private $move = false;
    private $move_revert = false;
    private $resizable = true;

    private $force_box_with_picture = true;
    private $box_border_color = "";
    private $box_gradient = false;
    private $shadow_color = "";
    /**#@-*/

	/**
	 * Constructor Box
	 * @param object|string $title title in the header the box
	 * @param boolean $shadow if box has shadow [default value: false]
	 * @param string $style_header style of the header (Box::STYLE_MAIN or Box::STYLE_SECOND) [default value: 1]
	 * @param string $style_content style of the content (Box::STYLE_MAIN or Box::STYLE_SECOND) [default value: 1]
	 * @param string $link heander title link
	 * @param string $id unique id of the box [default value: main_box]
	 * @param string $width width of the box [default value: 100%]
	 * @param string $height height of the box
	 * @param string $move if box can be move [default value: false]
	 */
    function __construct($title, $shadow=false, $style_header='1', $style_content='1', $link='', $id='main_box', $width='100%', $height="", $move=false) {
        parent::__construct();

        if (!isset($title)) {
            throw new NewException("1 argument for ".get_class($this)."::__construct() is mandatory", 0, getDebugBacktrace(1));
        }

        $this->is_browser_ie_6 = is_browser_ie_6();
        $this->browser_ie_version = get_browser_ie_version();

        $this->title = $title;
        if ($this->is_browser_ie_6) {
            $this->shadow = false;
        } else {
            $this->shadow = $shadow;
        }
        $this->style_header = $style_header;
        $this->style_content = $style_content;
        $this->link = $link;
        $this->id = $id;
        $this->move = $move;
        $this->width = $width;
        $this->height = $height;
        $this->tagH = "";

        $this->css3 = $this->getPage()->isCss3Browser();
        $this->browser_name = strtolower($browser['browser']);
        $this->browser_version = $browser['version'];

        CssInclude::getInstance()->loadCssConfigFileInMemory(false);
        if (constant("DEFINE_STYLE_BCK_PICTURE_".strtoupper($this->style_header)) == "") {
            $this->force_box_with_picture = false;
        }
        $this->box_border_color = constant("DEFINE_STYLE_BORDER_TABLE_".strtoupper($this->style_header));

        if (!defined('DEFINE_STYLE_GRADIENT_'.strtoupper($this->style_header))) {
            define("DEFINE_STYLE_GRADIENT_".strtoupper($this->style_header), false);
        }
        $this->box_gradient = constant("DEFINE_STYLE_GRADIENT_".strtoupper($this->style_header));

        if (!defined('DEFINE_STYLE_OMBRE_COLOR_'.strtoupper($this->style_header))) {
            define("DEFINE_STYLE_OMBRE_COLOR_".strtoupper($this->style_header), DEFINE_STYLE_OMBRE_COLOR);
        }
        $this->shadow_color = constant("DEFINE_STYLE_OMBRE_COLOR_".strtoupper($this->style_header));

        if (!$this->getPage()->isAjaxPage() && !$this->getPage()->isAjaxLoadPage()) {
            $this->addCss(BASE_URL."wsp/css/angle.css.php", "", true);
        }
    }

	/**
	 * Method setId
	 * @access public
	 * @param mixed $id 
	 * @return Box
	 * @since 1.2.13
	 */
    public function setId($id) {
        $this->id = $id;
        if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
        return $this;
    }

	/**
	 * Method setSmallIcon
	 * @access public
	 * @param string $icon_16_pixels path to icon 16px x 16px
	 * @param string $text 
	 * @return Box
	 * @since 1.0.35
	 */
    public function setSmallIcon($icon_16_pixels, $text='') {
        $this->icon_16_pixels = $icon_16_pixels;
        $this->icon_16_pixels_text = $text;
        if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
        return $this;
    }

	/**
	 * Method setBigIcon
	 * @access public
	 * @param string $icon_48_pixels 
	 * @param string $text 
	 * @return Box
	 * @since 1.0.35
	 */
    public function setBigIcon($icon_48_pixels, $text='') {
        $this->icon_48_pixels = $icon_48_pixels;
        $this->icon_48_pixels_text = $text;
        if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
        return $this;
    }

	/**
	 * Method setDraggable
	 * @access public
	 * @param boolean $bool if box can be move [default value: true]
	 * @param boolean $revert if box revert first place when dropped [default value: false]
	 * @return Box
	 * @since 1.0.35
	 */
    public function setDraggable($bool=true, $revert=false) {
        $this->move = $bool;
        $this->move_revert = $revert;
        if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
        return $this;
    }

	/**
	 * Method setResizable
	 * @access public
	 * @param boolean $bool [default value: true]
	 * @return Box
	 * @since 1.2.13
	 */
    public function setResizable($bool=true) {
        $this->resizable = $bool;
        if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
        return $this;
    }

	/**
	 * Method setHeight
	 * @access public
	 * @param integer $height 
	 * @return Box
	 * @since 1.0.35
	 */
    public function setHeight($height) {
        $this->height = $height;
        if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
        return $this;
    }

	/**
	 * Method setWidth
	 * @access public
	 * @param integer $width 
	 * @return Box
	 * @since 1.0.35
	 */
    public function setWidth($width) {
        $this->width = $width;
        if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
        return $this;
    }

	/**
	 * Method setValign
	 * @access public
	 * @param string $valign 
	 * @return Box
	 * @since 1.0.35
	 */
    public function setValign($valign) {
        $this->valign = $valign;
        if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
        return $this;
    }

	/**
	 * Method setAlign
	 * @access public
	 * @param string $align 
	 * @return Box
	 * @since 1.0.35
	 */
    public function setAlign($align) {
        $this->align = $align;
        if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
        return $this;
    }

	/**
	 * Method setShadow
	 * @access public
	 * @param boolean $shadow 
	 * @return Box
	 * @since 1.0.35
	 */
    public function setShadow($shadow) {
        $this->shadow = $shadow;
        if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
        return $this;
    }

	/**
	 * Method setTitle
	 * @access public
	 * @param string $title 
	 * @return Box
	 * @since 1.0.75
	 */
    public function setTitle($title) {
        $this->title = $title;
        if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
        return $this;
    }

	/**
	 * Method setTitleTagH1
	 * @access public
	 * @return Box
	 * @since 1.0.35
	 */
    public function setTitleTagH1() {
        $this->tagH = "h1";
        if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
        return $this;
    }

	/**
	 * Method setTitleTagH2
	 * @access public
	 * @return Box
	 * @since 1.0.35
	 */
    public function setTitleTagH2() {
        $this->tagH = "h2";
        if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
        return $this;
    }

	/**
	 * Method setTitleTagH3
	 * @access public
	 * @return Box
	 * @since 1.0.35
	 */
    public function setTitleTagH3() {
        $this->tagH = "h3";
        if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
        return $this;
    }

	/**
	 * Method setTitleTagH4
	 * @access public
	 * @return Box
	 * @since 1.0.35
	 */
    public function setTitleTagH4() {
        $this->tagH = "h4";
        if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
        return $this;
    }

	/**
	 * Method setContent
	 * @access public
	 * @param object|string $content content of the box
	 * @return Box
	 * @since 1.0.35
	 */
    public function setContent($content) {
        if (gettype($content) == "object" && get_class($content) == "DateTime") {
            throw new NewException(get_class($this)."->setContent() error: Please format your DateTime object (\$my_date->format(\"Y-m-d H:i:s\"))", 0, getDebugBacktrace(1));
        }
        $this->content = $content;
        if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
        return $this;
    }

	/**
	 * Method getTitle
	 * @access public
	 * @return mixed
	 * @since 1.2.13
	 */
    public function getTitle(){
        if (gettype($this->title) != "object") {
            $title = $this->title;
        } else if (gettype($this->title) == "object" && method_exists($this->title, "render")) {
            $title = $this->title->render();
        } else {
            $title = $this->title;
        }
        return $title;
    }

	/**
	 * Method getContent
	 * @access public
	 * @param boolean $ajax_render [default value: false]
	 * @return mixed
	 * @since 1.2.13
	 */
    public function getContent($ajax_render=false){
        if ($this->content != null) {
            if (gettype($this->content) == "object" && method_exists($this->content,"render")) {
                return $this->content->render($ajax_render);
            } else {
                return $this->content;
            }
        } else {
            return "&nbsp;";
        }
    }

	/**
	 * Method getMove
	 * @access public
	 * @return mixed
	 * @since 1.2.13
	 */
    public function getMove(){
        return $this->move;
    }

	/**
	 * Method getMoveRevert
	 * @access public
	 * @return mixed
	 * @since 1.2.13
	 */
    public function getMoveRevert(){
        return $this->move_revert;
    }

	/**
	 * Method getId
	 * @access public
	 * @return mixed
	 * @since 1.2.13
	 */
    public function getId(){
        return $this->id;
    }

	/**
	 * Method getShadow
	 * @access public
	 * @return mixed
	 * @since 1.2.13
	 */
    public function getShadow(){
        // Browser Execpt
        if ($this->browser_ie_version != false && $this->browser_ie_version <= 7) {
            return false;
        }
        if ($this->force_box_with_picture) {
            return true;
        }
        return $this->shadow;
    }

	/**
	 * Method getWidth
	 * @access public
	 * @return mixed
	 * @since 1.2.13
	 */
    public function getWidth(){
        if($this->width=="") {
            return false;
        } else {
            if (is_integer($this->width)) {
                $width = $this->width."px";
            } else {
                $width = $this->width;
            }
            return $width;
        }
    }

	/**
	 * Method getHeight
	 * @access public
	 * @return mixed
	 * @since 1.2.13
	 */
    public function getHeight(){
        if($this->height=="") {
            return false;
        } else {
            if (is_integer($this->height)) {
                $height = $this->height."px";
            } else {
                $height = $this->height;
            }
            return $height;
        }
    }

	/**
	 * Method getAlign
	 * @access public
	 * @return mixed
	 * @since 1.2.13
	 */
    public function getAlign(){
        return $this->align;
    }

	/**
	 * Method getResizable
	 * @access public
	 * @return mixed
	 * @since 1.2.13
	 */
    public function getResizable(){
        return $this->resizable;
    }

	/**
	 * Method forceBoxWithPicture
	 * @access public
	 * @param boolean $bool 
	 * @param string $border_color 
	 * @return Box
	 * @since 1.0.35
	 */
    public function forceBoxWithPicture($bool, $border_color="") {
        $this->force_box_with_picture = $bool;
        if ($border_color != "") {
            $this->box_border_color = $border_color;
        }
        if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
        return $this;
    }

	/**
	 * Method render
	 * @access public
	 * @param boolean $ajax_render [default value: false]
	 * @return string html code of object Box
	 * @since 1.0.35
	 */
    public function render($ajax_render=false) {
        $html = "";
        if ($this->browser_ie_version != false && $this->browser_ie_version <= 7) {
            $this->shadow = false;
        }
        if ($this->force_box_with_picture) {
            $this->shadow = true;
        }

        if (!$ajax_render) {
            $html .= "<div id=\"wsp_box_".$this->id."\" class=\"\">\n";
        }
        $html .= "<div id=\"drag_box_".$this->id."\" align=\"left\" class=\"";
        if ($this->move) {
            $html .= "draggable";
        }
        $html .= "\"";

        if ($this->width != "" || $this->height != "") {
            $html .= " style=\"";
            if ($this->width != "") {
                if (is_integer($this->width)) {
                    $html .= "width:".$this->width."px;";
                } else {
                    $html .= "width:".$this->width.";";
                }
            }
            if ($this->height != "") {
                if (is_integer($this->height)) {
                    $html .= "height:".$this->height."px;";
                } else {
                    $html .= "height:".$this->height.";";
                }
            }
            $html .= "\"";
        }
        $html .= ">\n";

        if (!$this->force_box_with_picture) {
            if (!$this->css3) {
                if ($this->browser_ie_version != false && $this->browser_ie_version <= 7) {
                    // do nothing
                } else {
                    $angle_class = "AngleRond".ucfirst($this->style_header);
                    $shadow_class = "";
                    $html .= "<div style=\"height:5px;";
                    if ($this->shadow) {
                        $shadow_class = "Ombre";
                        $html .= "position: relative; top: -5px;";
                    }
                    $html .= "\">\n";
                    $html .= "	<b class=\"".$angle_class." pix1".ucfirst($this->style_header).$shadow_class.($this->box_gradient?" pix1Gradient":"")."\"></b>\n";
                    $html .= "	<b class=\"".$angle_class." pix2".$shadow_class.($this->box_gradient?" pix2Gradient":"")."\"></b>\n";
                    $html .= "	<b class=\"".$angle_class." pix3".$shadow_class.($this->box_gradient?" pix3Gradient":"")."\"></b>\n";
                    $html .= "	<b class=\"".$angle_class." pix4".$shadow_class.($this->box_gradient?" pix4Gradient":"")."\"></b>\n";
                    $html .= "	<b class=\"".$angle_class." pix5".$shadow_class.($this->box_gradient?" pix5Gradient":"")."\"></b>\n";
                    $html .= "</div>\n";
                }

                if ($this->shadow) {
                    $html .= "	<div class=\"ombre".ucfirst($this->style_header)."\">\n";
                }
                $html .= "		<div";
                if ($this->shadow) {
                    $html .= " class=\"boiteTxt\"";
                }
                $html .= " >\n";
            }
            $html .= "			<table class=\"table_".$this->style_header."_angle BoxOverFlowHidden";
            if ($this->css3) {
                $html .= " Css3RadiusBox".$this->style_header;
                if ($this->shadow) {
                    $html .= " Css3ShadowBox".$this->style_header;
                }
            }
            $html .= "\" cellpadding=\"0\" cellspacing=\"0\"";
            if ($this->height != "") {
                $html .= " height=\"".$this->height."\"";
            }
            $html .= " style=\"table-layout:fixed;".(($this->browser_ie_version != false && $this->browser_ie_version <= 7) ? "border-top:1px solid ".$this->box_border_color.";":"")."\">\n";
            $html .= "				<tr>\n";
            $html .= "					<td class=\"header_".$this->style_header."_bckg header_".$this->style_header."_bckg_a";
            if ($this->css3) {
                $html .= " Css3RadiusBoxTitle".$this->style_header;
                if ($this->box_gradient) {
                    $html .= " Css3GradientBoxTitle".$this->style_header;
                }
            }
            $html .= "\"";
            if (!$this->css3) {
                $html .= " style=\"padding: ".($this->browser_ie_version!=false?($this->browser_ie_version!=false&&$this->browser_ie_version<=7?4:0):2)."px 0px 4px 5px;\"";
            }
            $html .= ">";
            if ($this->icon_48_pixels != "") {
                $html .= "<table cellpadding=\"0\" cellspacing=\"0\"><tr><td style=\"width:48px;\"><span style=\"position:absolute;margin-top:-24px;margin-left:-2px;\">";
                $html .= "<img src=\"".$this->icon_48_pixels."\" height=\"48\" width=\"48\"";
                if ($this->icon_48_pixels_text != ""){
                    $html .= " title=\"".str_replace("\"", " ", $this->icon_48_pixels_text)."\" alt=\"".str_replace("\"", " ", $this->icon_48_pixels_text)."\"";
                }
                $html .= "></span></td><td>";
            }
            if ($this->icon_16_pixels != ""){
                $html .= "<img src=\"".$this->icon_16_pixels."\" height=\"16\" width=\"16\" style=\"vertical-align: middle;\"";
                if ($this->icon_16_pixels_text != ""){
                    $html .= " title=\"".str_replace("\"", " ", $this->icon_16_pixels_text)."\" alt=\"".str_replace("\"", " ", $this->icon_16_pixels_text)."\"";
                }
                $html .= "> ";
            }
            if ($this->tagH != "") {
                $html .= "<".$this->tagH." style=\"font-weight:bold;\">";
            }
            if ($this->link != "") {
                $html .= "<a href=\"".$this->link."\">";
            }
            if (gettype($this->title) != "object") {
                $html .= $this->title;
            } else if (gettype($this->title) == "object" && method_exists($this->title, "render")) {
                $html .= $this->title->render();
            } else {
                $html .= $this->title;
            }
            if ($this->link != "") {
                $html .= "</a>";
            }
            if ($this->tagH != "") {
                $html .= "</".$this->tagH.">";
            }
            if ($this->icon_48_pixels != "") {
                $html .= "</td></tr></table>";
            }
            $html .= "</td>\n";
            $html .= "				</tr>\n";
            $html .= "				<tr id=\"".$this->id."\">\n";
            $html .= "					<td class=\"table_".$this->style_content."_bckg\" width=\"9999\" valign=\"".$this->valign."\" style=\"height:100%;padding:4px;border-top:1px solid ".$this->box_border_color.";\">\n";
            $html .= "						<div ";
            if ($this->align == Box::ALIGN_JUSTIFY) {
                $html .= "style=\"text-align:justify;\" ";
            } else {
                $html .= "align=\"".$this->align."\" ";
            }
            $html .= ">\n";
            if ($this->content != null) {
                if (gettype($this->content) == "object" && method_exists($this->content, "render")) {
                    $html_content = $this->content->render($ajax_render);
                } else {
                    $html_content = $this->content;
                }
                /*if (find($html_content, "<a href=") > 0) {
                    $html .= "						".str_replace("<a href=\"", "<a class=\"box_style_".$this->style_content."\" href=\"", str_replace("<a href='", "<a class='box_style_".$this->style_content."' href='", $html_content))."\n";
                    $html .= $this->getJavascriptTagOpen();
                    $html .= "$('.box_style_".$this->style_content."').each(function() { if ($(this).parent().hasClass('ui-state-default') || (!$(this).parent().hasClass('ui-state-default') && $(this).parent().parent().hasClass('ui-state-default'))) { $(this).removeClass('box_style_".$this->style_content."'); } });\n";
                    $html .= $this->getJavascriptTagClose();
                } else {*/
                $html .= "						".$html_content."\n";
                //}
            }
            $html .= "						</div>\n";
            $html .= "					</td>\n";
            $html .= "				</tr>\n";
            $html .= "			</table>\n";

            if (!$this->css3) {
                $html .= "		</div>\n";
                if ($this->shadow) {
                    $html .= "	</div>\n";
                }
            }
        } else {
            $html .= "		<div id=\"left".ucfirst($this->style_header)."\">\n";
            $html .= "			<div id=\"right".ucfirst($this->style_header)."\" style=\"padding-bottom:".(($this->browser_ie_version <= 7) ? 5 : 3)."px;";
            if ($this->height != "") {
                $html .= "height:100%;";
            }
            $html .= "\">\n";
            $html .= "				<div id=\"top".ucfirst($this->style_header)."\">\n";
            $html .= "					<div style=\"height:30px;\"></div>\n";
            $html .= "				</div>\n";

            $html .= "				<div class=\"header_".$this->style_header."_bckg header_".$this->style_header."_bckg_a\" style=\"background:none;padding-bottom:3px;position:relative;top:-20px;height:0px;\">";
            if ($this->icon_48_pixels != ""){
                $html .= "<img src=\"".$this->icon_48_pixels."\" height=\"48\" width=\"48\" style=\"position:absolute;top:-16px;left:-4px;\"";
                if ($this->icon_48_pixels_text != ""){
                    $html .= " title=\"".str_replace("\"", " ", $this->icon_48_pixels_text)."\" alt=\"".str_replace("\"", " ", $this->icon_48_pixels_text)."\"";
                }
                $html .= "><span style=\"width:40px;display:block;float:left;height:1px;\">&nbsp;</span>";
            }
            if ($this->icon_16_pixels != ""){
                $html .= "<img src=\"".$this->icon_16_pixels."\" height=\"16\" width=\"16\" style=\"vertical-align: middle;\"";
                if ($this->icon_16_pixels_text != ""){
                    $html .= " title=\"".str_replace("\"", " ", $this->icon_16_pixels_text)."\" alt=\"".str_replace("\"", " ", $this->icon_16_pixels_text)."\"";
                }
                $html .= "> ";
            }
            if ($this->tagH != "") {
                $html .= "<".$this->tagH." style=\"font-weight:bold;\">";
            }
            if ($this->link != "") {
                $html .= "<a href=\"".$this->link."\">";
            }
            if (gettype($this->title) != "object") {
                $html .= $this->title;
            } else if (gettype($this->title) == "object" && method_exists($this->title, "render")) {
                $html .= $this->title->render();
            } else {
                $html .= $this->title;
            }
            if ($this->link != "") {
                $html .= "</a>";
            }
            if ($this->tagH != "") {
                $html .= "</".$this->tagH.">";
            }
            $html .= "				</div>\n";

            $html .= "				<div style=\"clear:both;margin-left:".(($this->browser_ie_version!=false && $this->browser_ie_version > 7) ? -9 : -7)."px;\">\n";
            $html .= "				<div id=\"wsp_box_content_".$this->id."\" class=\"table_".$this->style_content."_bckg\" style=\"padding-left:0px;border:1px solid ".$this->box_border_color.";";
            $html .= "display:table-cell;";
            if (is_integer($this->width)) {
                $html .= "width:".($this->width - 12)."px;";
            } else {
                throw new NewException("width attribute in ".get_class($this)." must be an integer", 0, getDebugBacktrace(1));
            }
            if ($this->valign == Box::VALIGN_CENTER) {
                $html .= "vertical-align:middle;";
            } else {
                $html .= "vertical-align:".$this->valign.";";
            }
            if ($this->height != "") {
                if (is_integer($this->height)) {
                    $html .= "height:".($this->height-20)."px;";
                } else {
                    $html .= "height:".$this->height.";";
                }
            }
            $html .= "\">\n";

            if ($this->height != "" && is_integer($this->height) && $this->valign == RoundBox::VALIGN_CENTER) {
                $html .= "<div style=\"display:table;height:100%;#position:relative;width:100%;\" class=\"BoxOverFlowHidden\">\n";
                $html .= "	<div style=\"#position:absolute;#top:50%;display:table-cell;vertical-align:middle;width:100%;\">\n";
                $html .= "		<div style=\"#position:relative;#top:-50%;\">\n";
            }

            $html .= "					<div";
            if ($this->align == Box::ALIGN_JUSTIFY) {
                $html .= " style=\"width:98%;text-align:justify;";
            } else {
                $html .= " align=\"".$this->align."\" style=\"width:98%;";
            }
            $html .= "margin:5px;padding-right:5px;\">\n";
            if ($this->content != null) {
                if (gettype($this->content) == "object" && method_exists($this->content, "render")) {
                    $html_content = $this->content->render($ajax_render);
                } else {
                    $html_content = $this->content;
                }
                /*if (find($html_content, "<a href=") > 0) {
                    $html .= "						".str_replace("<a href=\"", "<a class=\"box_style_".$this->style_content."\" href=\"", str_replace("<a href='", "<a class='box_style_".$this->style_content."' href='", $html_content))."\n";
                    $html .= $this->getJavascriptTagOpen();
                    $html .= "$('.box_style_".$this->style_content."').each(function() { if ($(this).parent().hasClass('ui-state-default') || (!$(this).parent().hasClass('ui-state-default') && $(this).parent().parent().hasClass('ui-state-default'))) { $(this).removeClass('box_style_".$this->style_content."'); } });\n";
                    $html .= $this->getJavascriptTagClose();
                } else {*/
                $html .= "						".$html_content."\n";
                //}
            }
            $html .= "				</div>\n";

            if ($this->height != "" && is_integer($this->height) && $this->valign == RoundBox::VALIGN_CENTER) {
                $html .= "		</div>\n";
                $html .= "	</div>\n";
                $html .= "</div>\n";
            }

            $html .= "				</div>\n";
            $html .= "				</div>\n";
            $html .= "			</div>\n";
            $html .= "		</div>\n";
        }

        $html .= "</div>\n";
        if (!$ajax_render) {
            $html .= "</div>\n";
        }
        $html .= "<br/>\n";

        if ($this->move) {
            $html .= $this->getJavascriptTagOpen();
            $html .= "$(\"#wsp_box_".$this->id."\").draggable({opacity: 0.8, scroll: true";
            if ($this->move_revert) {
                $html .= ", revert: true";
            }
            $html .= "});\n";
            if($this->resizable) {
                $html .= "$(\"#drag_box_".$this->id."\").resizable();\n";
                $html .= "$(\"#drag_box_".$this->id."\").find('.ui-resizable-e').remove();\n";
                $html .= "$(\"#drag_box_".$this->id."\").find('.ui-resizable-s').remove();\n";
                $html .= "$(\"#drag_box_".$this->id."\").find('.ui-resizable-se').remove();\n";
            }
            $html .= $this->getJavascriptTagClose();
        }
        $this->object_change = false;

        return $html;
    }

	/**
	 * Method getAjaxRender
	 * @access public
	 * @return string javascript code to update initial html of object Box (call with AJAX)
	 * @since 1.0.35
	 */
    public function getAjaxRender() {
        $html = "";
        if ($this->object_change && !$this->is_new_object_after_init) {
            // Extract JavaScript from HTML
            $array_ajax_render = extract_javascript($this->render(true));
            for ($i=1; $i < sizeof($array_ajax_render); $i++) {
                new JavaScript($array_ajax_render[$i], true);
            }

            $html .= "$('#wsp_box_".$this->id."').innerHTML = \"".str_replace('"', '\"', str_replace("\n", "", str_replace("\r", "", $array_ajax_render[0])))."\";\n";
        }
        return $html;
    }
}
?>
