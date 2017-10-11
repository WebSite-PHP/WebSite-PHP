<?php
/**
 * PHP file wsp\class\display\advanced_object\map\MapLeafLet.class.php
 * @package display
 * @subpackage advanced_object.map
 */
/**
 * Class MapLeafLet
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2017 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package display
 * @subpackage advanced_object.map
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 20/07/2016
 * @version     1.2.15
 * @access      public
 * @since       1.2.7
 */

class MapLeafLet extends WebSitePhpObject {
    /**#@+
     * GeoSearch
     * @access public
     * @var string
     */
    const GEOSEARCH_OPENSTREETMAP = "OPENSTREETMAP";
    const GEOSEARCH_BING = "BING";
    const GEOSEARCH_ESRI = "ESRI";
    const GEOSEARCH_GOOGLE = "GOOGLE";
    const GEOSEARCH_NOKIA = "NOKIA";
    /**#@-*/

    /**#@+
     * Legend position
     * @access public
     * @var string
     */
    const LEGEND_POS_TOP_LEFT = "topleft";
    const LEGEND_POS_TOP_RIGHT = "topright";
    const LEGEND_POS_BOTTOM_LEFT = "bottomleft";
    const LEGEND_POS_BOTTOM_RIGHT = "bottomright";
    /**#@-*/

    /**#@+
     * Tile layer Control type
     * @access public
     * @var string
     */
    const TILE_LAYER_CTRL_RADIO = "radio";
    const TILE_LAYER_CTRL_CHECKBOX = "checkbox";
    /**#@-*/

    /**#@+
     * @access private
     */
    private $id = "";
    private $width = 400;
    private $height = 300;
    private $default_latitude = -1;
    private $default_longitude = -1;
    private $zoom = 13;
    private $max_zoom = -1;
    private $min_zoom = -1;
    private $display_searchbar = false;
    private $geosearch_tool = MapLeafLet::GEOSEARCH_OPENSTREETMAP;
    // Example list of layers: http://leaflet-extras.github.io/leaflet-providers/preview/
    private $tile_layer = array("http://{s}.tile.thunderforest.com/landscape/{z}/{x}/{y}.png");
    private $tile_layer_attribution = array("&copy; <a href=\"http://www.thunderforest.com/\">Thunderforest</a>, &copy; <a href=\"http://www.openstreetmap.org/copyright\">OpenStreetMap</a>");
    private $tile_layer_control_name = array("");
    private $tile_layer_control_type = array("");
    private $tile_layer_display = array(true);
    private $init_onload = true;

    private $location = array();
    private $location_text = array();
    private $location_is_center = array();
    private $location_icon_id = array();
    private $location_icon = array();

    private $marker_longitude = array();
    private $marker_latitude = array();
    private $marker_text = array();
    private $marker_is_center = array();
    private $marker_icon_id = array();
    private $marker_link = array();

    private $legend = array();
    private $legend_position = array();
    /**#@-*/

	/**
	 * Constructor MapLeafLet
	 * * Constructor MapLeafLet
	 * * @param string $id [default value: map_canvas]
	 * * @param double $zoom [default value: 13]
	 * * @param double $width [default value: 400]
	 * * @param double $height [default value: 300]
	 * * @param double $default_latitude [default value: 48.85667]
	 * @param string $id [default value: map_canvas]
	 * @param double $zoom [default value: 13]
	 * @param double $width [default value: 400]
	 * @param double $height [default value: 300]
	 * @param double $default_latitude [default value: 48.85667]
	 * @param double $default_longitude [default value: 2.35099]
	 */
    function __construct($id='map_canvas', $zoom=13, $width=400, $height=300, $default_latitude=48.85667, $default_longitude=2.35099) {
        parent::__construct();

        $this->id = $id;
        $this->width = $width;
        $this->height = $height;
        $this->zoom = $zoom;
        $this->default_latitude = $default_latitude;
        $this->default_longitude = $default_longitude;

        $this->addJavaScript(BASE_URL."wsp/js/leaflet.js", "", true);
        JavaScriptInclude::getInstance()->addToEnd(BASE_URL."wsp/js/geosearch/l.control.geosearch.js", "", true);
        JavaScriptInclude::getInstance()->addToEnd(BASE_URL."wsp/js/geosearch/l.geosearch.provider.openstreetmap.js", "", true);
        $this->addCss(BASE_URL."wsp/css/leaflet.css", "", true);
        $this->addCss(BASE_URL."wsp/css/l.geosearch.css", "", true);
    }

	/**
	 * Method addMarker
	 * * Method addMarker
	 * * @access public
	 * * @param mixed $address
	 * * @param string $text
	 * * @param string $icon_url_32
	 * * @param boolean $define_as_center [default value: true]
	 * * @param string $marker_link
	 * * @return MapLeafLet
	 * @access public
	 * @param mixed $address 
	 * @param string $text 
	 * @param string $icon_url_32 
	 * @param boolean $define_as_center [default value: true]
	 * @param string $marker_link 
	 * @return MapLeafLet
	 * @since 1.2.7
	 */
    public function addMarker($address, $text='', $icon_url_32='', $define_as_center=true, $marker_link='') {
        if (gettype($address) == "object" && method_exists($address, "render")) {
            $address = $address->render();
        }
        $this->location[] = str_replace("\n", "", str_replace("\r", "", $address));
        if (gettype($text) == "object" && method_exists($text, "render")) {
            $text = $text->render();
        }
        $this->location_text[] = str_replace("\n", "", str_replace("\r", "", $text));
        $this->location_is_center[] = $define_as_center;
        if ($icon_url_32 != "") {
            $icon_id = array_search($icon_url_32, $this->location_icon);
            if ($icon_id == false) {
                $this->location_icon[] = $icon_url_32;
                $icon_id = sizeof($this->location_icon) - 1;
            }
            $this->location_icon_id[] = $icon_id;
        } else {
            $this->location_icon_id[] = -1;
        }
        $this->marker_link[] = $marker_link;
        return $this;
    }

	/**
	 * Method addLatitudeLongitudeMarker
	 * * Method addLatitudeLongitudeMarker
	 * * @access public
	 * * @param mixed $latitude
	 * * @param mixed $longitude
	 * * @param string $text
	 * * @param string $icon_url_32
	 * * @param boolean $define_as_center [default value: true]
	 * * @param string $marker_link
	 * * @return MapLeafLet
	 * @access public
	 * @param mixed $latitude 
	 * @param mixed $longitude 
	 * @param string $text 
	 * @param string $icon_url_32 
	 * @param boolean $define_as_center [default value: true]
	 * @param string $marker_link 
	 * @return MapLeafLet
	 * @since 1.2.7
	 */
    public function addLatitudeLongitudeMarker($latitude, $longitude, $text='', $icon_url_32='', $define_as_center=true, $marker_link='') {
        $this->marker_latitude[] = $latitude;
        $this->marker_longitude[] = $longitude;
        if (gettype($text) == "object" && method_exists($text, "render")) {
            $text = $text->render();
        }
        $this->marker_text[] = str_replace("\n", "", str_replace("\r", "", $text));
        $this->marker_is_center[] = $define_as_center;
        if ($icon_url_32 != "") {
            $icon_id = array_search($icon_url_32, $this->location_icon);
            if ($icon_id == false) {
                $this->location_icon[] = $icon_url_32;
                $icon_id = sizeof($this->location_icon) - 1;
            }
            $this->marker_icon_id[] = $icon_id;
        } else {
            $this->marker_icon_id[] = -1;
        }
        $this->marker_link[] = $marker_link;
        return $this;
    }

	/**
	 * Method setWidth
	 * * Method setWidth
	 * * @access public
	 * * @param integer $width
	 * * @return MapLeafLet
	 * @access public
	 * @param integer $width 
	 * @return MapLeafLet
	 * @since 1.2.7
	 */
    public function setWidth($width) {
        $this->width = $width;
        return $this;
    }

	/**
	 * Method setHeight
	 * * Method setHeight
	 * * @access public
	 * * @param integer $height
	 * * @return MapLeafLet
	 * @access public
	 * @param integer $height 
	 * @return MapLeafLet
	 * @since 1.2.7
	 */
    public function setHeight($height) {
        $this->height = $height;
        return $this;
    }

	/**
	 * Method setZoom
	 * * Method setZoom
	 * * @access public
	 * * @param mixed $zoom
	 * * @return MapLeafLet
	 * @access public
	 * @param mixed $zoom 
	 * @return MapLeafLet
	 * @since 1.2.7
	 */
    public function setZoom($zoom) {
        $this->zoom = $zoom;
        return $this;
    }

	/**
	 * Method setDefaultLatitude
	 * * Method setDefaultLatitude
	 * * @access public
	 * * @param mixed $default_latitude
	 * * @return MapLeafLet
	 * @access public
	 * @param mixed $default_latitude 
	 * @return MapLeafLet
	 * @since 1.2.7
	 */
    public function setDefaultLatitude($default_latitude) {
        $this->default_latitude = $default_latitude;
        return $this;
    }

	/**
	 * Method setDefaultLongitude
	 * * Method setDefaultLongitude
	 * * @access public
	 * * @param mixed $default_longitude
	 * * @return MapLeafLet
	 * @access public
	 * @param mixed $default_longitude 
	 * @return MapLeafLet
	 * @since 1.2.7
	 */
    public function setDefaultLongitude($default_longitude) {
        $this->default_longitude = $default_longitude;
        return $this;
    }

	/**
	 * Method displaySearchBar
	 * * Method displaySearchBar
	 * * @access public
	 * * @return MapLeafLet
	 * @access public
	 * @return MapLeafLet
	 * @since 1.2.7
	 */
    public function displaySearchBar() {
        $this->display_searchbar = true;
        return $this;
    }

	/**
	 * Method setTileLayer
	 * * Method setTileLayer
	 * * @access public
	 * * @param mixed $tile_layer
	 * * @return MapLeafLet
	 * @access public
	 * @param mixed $tile_layer 
	 * @param string $tile_layer_attribution 
	 * @param string $layer_control_name 
	 * @param string $layer_control_type 
	 * @param boolean $is_displayed_at_start [default value: true]
	 * @return MapLeafLet
	 * @since 1.2.7
	 */
    public function setTileLayer($tile_layer, $tile_layer_attribution='', $layer_control_name='', $layer_control_type='', $is_displayed_at_start=true) {
        $this->tile_layer[0] = $tile_layer;
        if ($tile_layer_attribution != '') {
            $this->tile_layer_attribution[0] = $tile_layer_attribution;
        } else {
            $this->tile_layer_attribution[0] = "&copy; <a href=\"http://osm.org/copyright\" target=\"_blank\" rel=\"nofollow\">OpenStreetMap</a> contributors";
        }
        $this->tile_layer_control_name[0] = $layer_control_name;
        $this->tile_layer_control_type[0] = $layer_control_type;
        $this->tile_layer_display[0] = $is_displayed_at_start;
        return $this;
    }

	/**
	 * Method addTileLayer
	 * @access public
	 * @param mixed $tile_layer 
	 * @param string $tile_layer_attribution 
	 * @param string $layer_control_name 
	 * @param string $layer_control_type 
	 * @param boolean $is_displayed_at_start [default value: true]
	 * @return MapLeafLet
	 * @since 1.2.15
	 */
    public function addTileLayer($tile_layer, $tile_layer_attribution='', $layer_control_name='', $layer_control_type='', $is_displayed_at_start=true) {
        $this->tile_layer[] = $tile_layer;
        if ($tile_layer_attribution != '') {
            $this->tile_layer_attribution[] = $tile_layer_attribution;
        } else {
            $this->tile_layer_attribution[] = "&copy; <a href=\"http://osm.org/copyright\" target=\"_blank\" rel=\"nofollow\">OpenStreetMap</a> contributors";
        }
        $this->tile_layer_control_name[] = $layer_control_name;
        $this->tile_layer_control_type[] = $layer_control_type;
        $this->tile_layer_display[] = $is_displayed_at_start;
        return $this;
    }

	/**
	 * Method setGeoSearchTool
	 * * Method setGeoSearchTool
	 * * @access public
	 * * @param mixed $tool
	 * * @return MapLeafLet
	 * @access public
	 * @param mixed $tool 
	 * @return MapLeafLet
	 * @since 1.2.7
	 */
    public function setGeoSearchTool($tool) {
        $this->geosearch_tool = $tool;
        if ($this->geosearch_tool == MapLeafLet::GEOSEARCH_GOOGLE) {
            JavaScriptInclude::getInstance()->addToEnd(BASE_URL."wsp/js/geosearch/l.geosearch.provider.google.js", "", true);
        } else if ($this->geosearch_tool == MapLeafLet::GEOSEARCH_BING) {
            JavaScriptInclude::getInstance()->addToEnd(BASE_URL."wsp/js/geosearch/l.geosearch.provider.bing.js", "", true);
        } else if ($this->geosearch_tool == MapLeafLet::GEOSEARCH_ESRI) {
            JavaScriptInclude::getInstance()->addToEnd(BASE_URL."wsp/js/geosearch/l.geosearch.provider.esri.js", "", true);
        } else if ($this->geosearch_tool == MapLeafLet::GEOSEARCH_NOKIA) {
            JavaScriptInclude::getInstance()->addToEnd(BASE_URL."wsp/js/geosearch/l.geosearch.provider.nokia.js", "", true);
        }
        return $this;
    }

	/**
	 * Method addLegend
	 * * Method addLegend
	 * * @access public
	 * * @param mixed $position
	 * * @param object $content
	 * * @return MapLeafLet
	 * @access public
	 * @param mixed $position 
	 * @param object $content 
	 * @return MapLeafLet
	 * @since 1.2.7
	 */
    public function addLegend($position, $content) {
        $this->legend[] = $content;
        $this->legend_position[] = $position;
        return $this;
    }

	/**
	 * Method setMaxZoom
	 * * Method setMaxZoom
	 * * @access public
	 * * @param mixed $max_zoom
	 * * @return MapLeafLet
	 * @access public
	 * @param mixed $max_zoom 
	 * @return MapLeafLet
	 * @since 1.2.7
	 */
    public function setMaxZoom($max_zoom) {
        $this->max_zoom = (is_int($max_zoom)?$max_zoom:-1);
        return $this;
    }

	/**
	 * Method setMinZoom
	 * * Method setMinZoom
	 * * @access public
	 * * @param mixed $min_zoom
	 * * @return MapLeafLet
	 * @access public
	 * @param mixed $min_zoom 
	 * @return MapLeafLet
	 * @since 1.2.7
	 */
    public function setMinZoom($min_zoom) {
        $this->min_zoom = (is_int($min_zoom)?$min_zoom:-1);
        return $this;
    }

	/**
	 * Method setAutoZoom
	 * * Method setAutoZoom
	 * * @access public
	 * * @param mixed $min_latitude
	 * * @param mixed $max_latitude
	 * * @param mixed $min_longitude
	 * * @param mixed $max_longitude
	 * * @return MapLeafLet
	 * @access public
	 * @param mixed $min_latitude 
	 * @param mixed $max_latitude 
	 * @param mixed $min_longitude 
	 * @param mixed $max_longitude 
	 * @return MapLeafLet
	 * @since 1.2.7
	 */
    public function setAutoZoom($min_latitude, $max_latitude, $min_longitude, $max_longitude) {
        $this->zoom = intval($this->getZoomLevel($min_latitude, $max_latitude, $min_longitude, $max_longitude, $this->width, $this->height));
        return $this;
    }

	/**
	 * Method getZoomLevel
	 * * Method getZoomLevel
	 * * @access private
	 * * @param mixed $min_latitude
	 * * @param mixed $max_latitude
	 * * @param mixed $min_longitude
	 * * @param mixed $max_longitude
	 * * @param mixed $map_width
	 * * @param mixed $map_height
	 * * @return mixed
	 * @access private
	 * @param mixed $min_latitude 
	 * @param mixed $max_latitude 
	 * @param mixed $min_longitude 
	 * @param mixed $max_longitude 
	 * @param mixed $map_width 
	 * @param mixed $map_height 
	 * @return mixed
	 * @since 1.2.7
	 */
    private function getZoomLevel($min_latitude, $max_latitude, $min_longitude, $max_longitude, $map_width, $map_height) {
        $WORLD_DIM = array("height" => 256, "width" => 256);
        $ZOOM_MAX = 21;
        function latRad($lat) {
            $sin = sin($lat * pi() / 180);
            $radX2 = log((1 + $sin) / (1 - $sin)) / 2;
            return max(min($radX2, pi()), -pi()) / 2;
        }

        function zoom($mapPx, $worldPx, $fraction) {
            return floor(log($mapPx / $worldPx / $fraction) / 0.6931471805599453);
        }

        $latFraction = (latRad($max_latitude) - latRad($min_latitude)) / pi();

        $lngDiff = $max_longitude - $min_longitude;
        $lngFraction = (($lngDiff < 0) ? ($lngDiff + 360) : $lngDiff) / 360;

        $latZoom = zoom($map_height, $WORLD_DIM["height"], $latFraction);
        $lngZoom = zoom($map_width, $WORLD_DIM["width"], $lngFraction);

        return min($latZoom, $lngZoom, $ZOOM_MAX);
    }

	/**
	 * Method getZoom
	 * * Method getZoom
	 * * @access public
	 * * @return mixed
	 * @access public
	 * @return mixed
	 * @since 1.2.7
	 */
    public function getZoom() {
        return $this->zoom;
    }

	/**
	 * Method getId
	 * * Method getId
	 * * @access public
	 * * @return mixed
	 * @access public
	 * @return mixed
	 * @since 1.2.7
	 */
    public function getId() {
        return $this->id;
    }

	/**
	 * Method disableInitOnLoad
	 * * Method disableInitOnLoad
	 * * @access public
	 * * @return MapLeafLet
	 * @access public
	 * @return MapLeafLet
	 * @since 1.2.7
	 */
    public function disableInitOnLoad() {
        $this->init_onload = false;
        return $this;
    }

	/**
	 * Method render
	 * * Method render
	 * * @access public
	 * * @param boolean $ajax_render [default value: false]
	 * * @return mixed
	 * @access public
	 * @param boolean $ajax_render [default value: false]
	 * @return mixed
	 * @since 1.2.7
	 */
    public function render($ajax_render=false) {
        $map_div = "<div id=\"".$this->id."\" style=\"width:".$this->width."px;height:".$this->height."px\"></div>";
        $html = $map_div;

        $html .= $this->getJavascriptTagOpen();
        $html .= "	if ('function' == typeof(L.map)) {\n";
        $html .= "	var map_".$this->id." = null;\n";
        $html .= "	var geocoder_".$this->id." = null;
			var TimerIDArray_".$this->id." = new Array();
			var TimerIDCount_".$this->id." = 0;
			
			if (arrayLoadedMap == null) {
				var arrayLoadedMap = new Array();
			}
					
			var arrayMarkerLocation_".$this->id." = null;
			initArrays_".$this->id." = function() {
				arrayMarkerLocation_".$this->id." = new Array();
			};\n";
        $html .= "	initIcon = function(img) {
				var mapIcon = L.icon({
					iconUrl: img,
					iconRetinaUrl: img,
					iconSize: [32, 32],
					iconAnchor: [15, 32],
					popupAnchor: [0, -33],
					shadowUrl: '',
					shadowRetinaUrl: '',
					shadowSize: [40, 63],
					shadowAnchor: [15, 62]
				});
				return mapIcon;
			};\n";

        for ($i=0; $i < sizeof($this->location_icon); $i++) {
            $html .= "	var icon_".$this->id."_".$i." = \"".$this->location_icon[$i]."\";\n";
        }
        $html .= "	var icon_".$this->id."_default = \"".$this->getPage()->getCDNServerURL()."wsp/img/leaflet/marker-icon-32.png\";\n";
        $html .= "	L.Icon.Default.imagePath = \"".$this->getPage()->getCDNServerURL()."wsp/img/leaflet\";\n";

        $html .= "$(document).ready(function() {\n";
        $html .= "	initializeMap_".$this->id." = function(center_latitude, center_longitude, zoom) {\n";
        if ($this->geosearch_tool == MapLeafLet::GEOSEARCH_GOOGLE) {
            $html .= "		var geoprovider = new L.GeoSearch.Provider.Google;\n";
        } else if ($this->geosearch_tool == MapLeafLet::GEOSEARCH_BING) {
            $html .= "		var geoprovider = new L.GeoSearch.Provider.Bing;\n";
        } else if ($this->geosearch_tool == MapLeafLet::GEOSEARCH_ESRI) {
            $html .= "		var geoprovider = new L.GeoSearch.Provider.Esri;\n";
        } else if ($this->geosearch_tool == MapLeafLet::GEOSEARCH_NOKIA) {
            $html .= "		var geoprovider = new L.GeoSearch.Provider.Nokia;\n";
        } else {
            $html .= "		var geoprovider = new L.GeoSearch.Provider.OpenStreetMap;\n";
        }
        $html .= "		initArrays_".$this->id."();
				if (map_".$this->id." != null) { var parent=$('#".$this->id."').parent(); $('#".$this->id."').remove(); $('".addslashes($map_div)."').prependTo(parent); };
				map_".$this->id." = L.map(\"".$this->id."\").setView((center_latitude==null&&center_longitude==null?[".$this->default_latitude.", ".$this->default_longitude."]:new L.LatLng(center_latitude, center_longitude)), (zoom==null?".$this->zoom.":zoom));\n";
        for ($i=0; $i < sizeof($this->tile_layer); $i++) {
            $html .= "		var tileLayer_" . $this->id . "_".$i." = L.tileLayer('" . $this->tile_layer[$i] . "', {
                        attribution: '".addslashes($this->tile_layer_attribution[$i])."'\n";
            if ($this->max_zoom != -1) {
                $html .= "		, maxZoom: " . $this->max_zoom . "\n";
            }
            if ($this->min_zoom != -1) {
                $html .= "		, minZoom: " . $this->min_zoom . "\n";
            }
            $html .= "		})";
            if ($this->tile_layer_display[$i] !== false) {
                $html .= ".addTo(map_" . $this->id.")";
            }
            $html .= ";\n";
        }
        $ctrl_radio_html = "";
        $ctrl_check_html = "";
        for ($i=0; $i < sizeof($this->tile_layer_control_name); $i++) {
            if (trim($this->tile_layer_control_name[$i]) != "") {
                if ($this->tile_layer_control_type[$i] == MapLeafLet::TILE_LAYER_CTRL_RADIO) {
                    if ($ctrl_radio_html == "") {
                        $ctrl_radio_html .= "		var radioLayers_" . $this->id . " = {\n";
                    } else {
                        $ctrl_radio_html .= "		,";
                    }
                    $ctrl_radio_html .= "\"" . $this->tile_layer_control_name[$i] . "\" : tileLayer_" . $this->id . "_" . $i;
                } else {
                    if ($ctrl_check_html == "") {
                        $ctrl_check_html .= "		var checkLayers_" . $this->id . " = {\n";
                    } else {
                        $ctrl_check_html .= "		,";
                    }
                    $ctrl_check_html .= "\"" . $this->tile_layer_control_name[$i] . "\" : tileLayer_" . $this->id . "_" . $i;
                }
            }
        }
        if ($ctrl_radio_html != "" || $ctrl_check_html != "") {
            if ($ctrl_radio_html != "") {
                $html .= $ctrl_radio_html;
                $html .= "		};\n";
            }
            if ($ctrl_check_html != "") {
                $html .= $ctrl_check_html;
                $html .= "		};\n";
            }
            $html .= "		L.control.layers(";
            $html .= ($ctrl_radio_html != "" ? "radioLayers_" . $this->id : "null").", ";
            $html .= ($ctrl_check_html != "" ? "checkLayers_" . $this->id : "null");
            $html .= ").addTo(map_" . $this->id . ");\n";
        }
        $html .= "		geocoder_".$this->id." = new L.Control.GeoSearch({
					provider: geoprovider
				});\n";
        if ($this->display_searchbar) {
            $html .= "		geocoder_".$this->id.".addTo(map_".$this->id.");\n";
        }
        if ($this->geosearch_tool != MapLeafLet::GEOSEARCH_GOOGLE) {
            $html .= "		loadMap_".$this->id."();\n";
        }
        $html .= "	arrayLoadedMap[arrayLoadedMap.length] = '".$this->id."';\n";
        for ($i=0; $i < sizeof($this->legend); $i++) {
            $html .= "	var legend".$i." = L.control({position: '".$this->legend_position[$i]."'});\n";
            $html .= "	legend".$i.".onAdd = function(map_".$this->id.") {\n";
            if (gettype($this->legend[$i]) == "object" && method_exists($this->legend[$i], "render")) {
                $content = $this->legend[$i]->render();
            } else {
                $content = $this->legend[$i];
            }
            // Extract JavaScript from HTML
            include_once(dirname(__FILE__)."/../../../../includes/utils_ajax.inc.php");
            $array_ajax_render = extract_javascript($content);
            for ($j=1; $j < sizeof($array_ajax_render); $j++) {
                new JavaScript($array_ajax_render[$j], true);
            }
            $html .= "		var div = L.DomUtil.create('div');\n";
            $html .= "		div.innerHTML = \"".str_replace("\n", "", str_replace("\r", "", addslashes($array_ajax_render[0])))."\";\n";
            $html .= "		return div;\n";
            $html .= "	};\n";
            $html .= "	legend".$i.".addTo(map_".$this->id.");\n";
        }
        $html .= "};\n";
        $html .= "	loadMap_".$this->id." = function() {\n";
        $html .= "		loadAllMarkers_".$this->id."();
				loadAllAddressMarkers_".$this->id."();
			};\n";
        $html .= "	loadAllLoadedMaps = function() {
				for (i=0; i < arrayLoadedMap.length; i++) {
					eval('loadMap_'+arrayLoadedMap[i]+'()');
				}
			};\n";

        $html .= "	loadAllMarkers_".$this->id." = function() {\n";
        $is_already_center = false;
        for ($i=sizeof($this->marker_latitude)-1; $i >= 0; $i--) {
            $icon = "icon_".$this->id."_default";
            if ($this->marker_icon_id[$i] != -1) {
                $icon = "icon_".$this->id."_".$this->marker_icon_id[$i];
            }
            $is_center = "false";
            if (!$is_already_center && $this->marker_is_center[$i]) {
                $is_center = "true";
                $is_already_center = true;
            }
            $html .= "		addMarker_".$this->id."(".$i.", ".$this->marker_latitude[$i].", ".$this->marker_longitude[$i].", '".addslashes($this->marker_text[$i])."', ".$icon.", ".$is_center.", '".addslashes($this->marker_link[$i])."');\n";
        }
        $html .= "	};\n";
        $html .= "	loadAllAddressMarkers_".$this->id." = function() {
				clearAllTimeout_".$this->id."();\n";
        $is_already_center = false;
        for ($i=sizeof($this->location)-1; $i >= 0; $i--) {
            $icon = "icon_".$this->id."_default";
            if ($this->location_icon_id[$i] != -1) {
                $icon = "icon_".$this->id."_".$this->location_icon_id[$i];
            }
            $is_center = "false";
            if (!$is_already_center && $this->location_is_center[$i]) {
                $is_center = "true";
                $is_already_center = true;
            }
            $html .= "		showMarker_".$this->id."(".$i.", '".addslashes($this->location[$i])."', '".addslashes($this->location_text[$i])."', ".$icon.", ".$is_center.", '".addslashes($this->marker_link[$i])."');\n";
        }
        $html .= "	};\n";
        $html .= "showMarker_".$this->id." = function(ind, address, text, icon, is_center, marker_link) {
					if (arrayMarkerLocation_".$this->id."[ind] == null) {
						TimerIDArray_".$this->id."[TimerIDCount_".$this->id."++] = setTimeout(\"markLocation_".$this->id."(\" + ind + \", '\" + addslashes(address) + \"', '\" + addslashes(text) + \"', '\" + icon + \"', \" + is_center + \", '\" + marker_link + \"')\", ind*200);
					} else {
						displayMarker_".$this->id."(ind, text, (marker_link!=''?true:false));
					}
				};
				clearAllTimeout_".$this->id." = function() {
					for (i=0; i < TimerIDCount_".$this->id."; i++) {
	    				clearTimeout(TimerIDArray_".$this->id."[i]);
					}
					TimerIDArray_".$this->id." = new Array();
					TimerIDCount_".$this->id." = 0;
				};\n";
        $html .= "	markLocation_".$this->id." = function(ind, address, text, icon, is_center, marker_link) {
				    geocoder_".$this->id.".geosearch(address, function(response) {
			    		if (response != null) {
				    		addMarker_".$this->id."(ind, response['Y'], response['X'], text, icon, is_center, marker_link);
						}
					});
				};\n";
        $html .= "	addMarker_".$this->id." = function(ind, latitude, longitude, text, icon, is_center, marker_link) {
				    var marker = L.marker([latitude, longitude]);
					if (marker_link != '') {
						marker.on('click', function() { window.location = marker_link; }).on('mouseover', function(e){ marker.openPopup(); });
					}
					if (icon != '') {
						var mapIcon = initIcon(icon);
						marker.setIcon(mapIcon);
					}
		    		arrayMarkerLocation_".$this->id."[ind]=marker;
		    		displayMarker_".$this->id."(ind, text, (marker_link!=''?true:false));
		    		if (is_center == true) {
		    			map_".$this->id.".setView([latitude, longitude], ".$this->zoom.");
					}
				};\n";
        $html .= "	displayMarker_".$this->id." = function(ind, text, is_marker_link) {
				    if (text == null || text == '') {
						arrayMarkerLocation_".$this->id."[ind].addTo(map_".$this->id.");
					} else if (is_marker_link) {
						arrayMarkerLocation_".$this->id."[ind].addTo(map_".$this->id.").bindPopup(text);
					} else {
						arrayMarkerLocation_".$this->id."[ind].addTo(map_".$this->id.").bindPopup(text).openPopup();
					}
				};\n";
        if ($this->init_onload) {
            $html .= "	initializeMap_".$this->id."();\n";
        }
        $html .= "});\n";
        if (DEBUG) {
            $html .= "	} else {\n";
            $html .= "		alert(\"".__(INCLUDE_OBJECT_TO_MAIN_PAGE, get_class($this), get_class($this))."\");\n";
            $html .= "	}\n";
        } else {
            $html .= "	}\n";
        }
        $html .= $this->getJavascriptTagClose();
        $this->object_change = false;
        return $html;
    }
}
?>
