<?php
class Map extends WebSitePhpObject {
	/**#@+
	* @access private
	*/
	private $id = "";
	private $width = 400;
	private $height = 300;
	private $default_latitude = -1;
	private $default_longitude = -1;
	private $zoom = 13;
	
	private $location = array();
	private $location_text = array();
	private $location_is_center = array();
	private $location_icon_id = array();
	private $location_icon = array();
	/**#@-*/
	
	function __construct($id='map_canvas', $zoom=13, $width=400, $height=300, $default_latitude=48.85667, $default_longitude=2.35099) {
		parent::__construct();
		
		$this->id = $id;
		$this->width = $width;
		$this->height = $height;
		$this->zoom = $zoom;
		$this->default_latitude = $default_latitude;
		$this->default_longitude = $default_longitude;
		
		if ($GLOBALS['__AJAX_LOAD_PAGE__'] == false) {
			$this->addJavaScript("http://maps.google.com/maps?file=api&amp;v=2.x&amp;key=".GOOGLE_MAP_KEY);
		}
	}
	
	public function addMarker($address, $text='', $icon_url_32='', $define_as_center=false) {
		$this->location[] = $address;
		$this->location_text[] = $text;
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
	}
	
	public function render($ajax_render=false) {
		$html = "<div id=\"".$this->id."\" style=\"width:".$this->width."px;height:".$this->height."px\"></div>";
		
		$html .= $this->getJavascriptTagOpen();
		$html .= "	if ('function' == typeof(GIcon)) {\n";
		$html .= "	var map_".$this->id.";
			var geocoder_".$this->id.";
			var TimerIDArray_".$this->id." = new Array()
			var TimerIDCount_".$this->id." = 0;
			
			var arrayMarkerLocation_".$this->id." = null;
			initArrays_".$this->id." = function() {
				arrayMarkerLocation_".$this->id." = new Array();
			};\n";
		if (sizeof($this->location_icon) > 0) {
			$html .= "	initIcon = function(img) {
					var baseIcon = new GIcon();
			    	baseIcon.image = img;
			    	baseIcon.shadow = \"http://www.google.com/mapfiles/shadow50.png\";
					baseIcon.iconSize = new GSize(32, 32);
					baseIcon.shadowSize = new GSize(32, 32);
					baseIcon.iconAnchor = new GPoint(9, 32);
					baseIcon.infoWindowAnchor = new GPoint(9, 2);
					return baseIcon;
				};\n";
				
			for ($i=0; $i < sizeof($this->location_icon); $i++) {
				$html .= "	var icon_".$this->id."_".$i." = initIcon(\"".$this->location_icon[$i]."\");\n";
			}
		}
		
		$html .= "	initializeGMap_".$this->id." = function() {
				initArrays_".$this->id."();
				if (GBrowserIsCompatible()) { 
					var mapOptions = {
						googleBarOptions : {
							style : \"new\"
						}
					}
				    map_".$this->id." = new GMap2(document.getElementById(\"".$this->id."\"), mapOptions);
				    map_".$this->id.".setCenter(new GLatLng(".$this->default_latitude.", ".$this->default_longitude."), ".$this->zoom.");
				    map_".$this->id.".setUIToDefault();
				    
				    geocoder_".$this->id." = new GClientGeocoder();
				    loadAllMarkers_".$this->id."();
			  	}
			};\n";
			
		$html .= "	loadAllMarkers_".$this->id." = function() {
				clearAllTimeout_".$this->id."();\n";
			for ($i=0; $i < sizeof($this->location); $i++) {
				$icon = "";
				if ($this->location_icon_id[$i] != -1) {
					$icon = "icon_".$this->id."_".$this->location_icon_id[$i];
				}
				$html .= "		showMarker_".$this->id."(".$i.", '".addslashes($this->location[$i])."', '".addslashes($this->location_text[$i])."', '".$icon."', ".(($this->location_is_center[$i])?"true":"false").");\n";
			}
		$html .= "	};\n";
		$html .= "showMarker_".$this->id." = function(ind, address, text, icon, is_center) {
					if (arrayMarkerLocation_".$this->id."[ind] == null) {
						TimerIDArray_".$this->id."[TimerIDCount_".$this->id."++] = setTimeout(\"markLocation_".$this->id."(\" + ind + \", '\" + addslashes(address) + \"', '\" + addslashes(text) + \"', '\" + icon + \"', \" + is_center + \")\", ind*200);
					} else {
						map_".$this->id.".addOverlay(arrayMarkerLocation_".$this->id."[ind]);
					}
				};
				clearAllTimeout_".$this->id." = function() {
					for (i=0; i < TimerIDCount_".$this->id."; i++) {
	    				clearTimeout(TimerIDArray_".$this->id."[i]);
					}
					TimerIDArray_".$this->id." = new Array()
					TimerIDCount_".$this->id." = 0;
				};\n";
		$html .= "	markLocation_".$this->id." = function(ind, address, text, icon, is_center) {
				    geocoder_".$this->id.".getLocations(address, function(response) {
					    if (!response || response.Status.code != 200) {
					    	//alert(\"Unable to match address: \" + address + \" !\");
					    } else {
					    	var place = response.Placemark[0];
					    	var point = new GLatLng(place.Point.coordinates[1], place.Point.coordinates[0]);
					    	if (is_center == true) {
					    		map_".$this->id.".setCenter(point, ".$this->zoom.");
					    	}
					    	var markerOptions = null;
					    	if (icon != '') {
					    		eval(\"markerOptions = { icon:\" + icon + \" };\");
					    	}
					    	var marker = null;if (markerOptions != null) {
					    		marker = new GMarker(point, markerOptions);
					    	} else {
					    		marker = new GMarker(point);
					    	}
					    	GEvent.addListener(marker, \"click\", function() {
					    		if (text == '') {
					    			marker.openInfoWindowHtml(address);
					    		} else {
					    			marker.openInfoWindowHtml(text);
					    		}
					    	});
					    	arrayMarkerLocation_".$this->id."[ind]=marker;
					    	map_".$this->id.".addOverlay(marker);
					    }
					});
				};\n";
		$html .= "	initializeGMap_".$this->id."();\n";
		$html .= "	} else {\n";
		$html .= "		alert(\"".__(INCLUDE_OBJECT_TO_MAIN_PAGE, get_class($this), get_class($this))."\");\n";
		$html .= "	}\n";
		$html .= $this->getJavascriptTagClose();
		$this->object_change = false;
		return $html;
	}
}
?>
