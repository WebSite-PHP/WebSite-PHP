<?php 
/**
 * PHP file wsp\class\modules\Graphic\Chart.class.php
 * @package modules
 * @subpackage Graphic
 */
/**
 * Class Chart
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2017 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package modules
 * @subpackage Graphic
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 11/10/2017
 * @version     1.2.15
 * @access      public
 * @since       1.0.91
 */

class Chart extends WebSitePhpObject {
	/**#@+
	* Chart line design
	* @access public
	* @var string
	*/
	const DESIGN_BARS = "bars";
	const DESIGN_LINES = "lines";
	const DESIGN_LINES_WITH_STEPS = "lines_with_steps";
	const DESIGN_POINTS = "points";
	const DESIGN_LINES_POINTS = "lines_points";
	const DESIGN_LINES_POINTS_WITH_STEPS = "lines_points_with_steps";
	/**#@-*/
	
	/**#@+
	* Chart stack style
	* @access public
	* @var string
	*/
	const STYLE_STACKING = "stack";
	const STYLE_NO_STACKING = "no_stack";
	/**#@-*/
	
	/**#@+
	* Chart tracking mode
	* @access public
	* @var string
	*/
	const TRACKING_MODE_X = "x";
	const TRACKING_MODE_Y = "y";
	/**#@-*/
	
	/**#@+
	* Chart data type
	* @access public
	* @var string
	*/
	const DATA_TYPE_NUMERIC = "";
	const DATA_TYPE_DATE = "time_date";
	const DATA_TYPE_TIME = "time_time";
	const DATA_TYPE_DATETIME = "time_datetime";
	const DATA_TYPE_DAY = "time_day";
	const DATA_TYPE_MONTH = "time_month";
	const DATA_TYPE_DAYMONTH = "time_daymonth";
	const DATA_TYPE_YEAR = "time_year";
	/**#@-*/
	
	/**#@+
	* @access private
	*/
	private $id = "";
	private $width = 500;
	private $height = 300;
	private $legend = false;
	private $grid = false;
	private $bar_width = "";
	private $tracking_mode = "";
	private $tracking_text = false;
	private $x_data_type = "";
	private $x_data_type_detail = "";
	private $y_data_type = "";
	private $y_data_type_detail = "";
	private $x_min = "";
	private $x_max = "";
	private $y_min = "";
	private $y_max = "";
	private $is_bar_line = false;
	
	private $array_stack = array();
	private $array_title = array();
	private $array_data = array();
	private $array_bar = array();
	private $array_line = array();
	private $array_step = array();
	private $array_point = array();
	private $array_fill = array();
	/**#@-*/
	
	/**
	 * Constructor Chart
	 * @param string $id [default value: graphic_chart_id]
	 * @param double $width [default value: 500]
	 * @param double $height [default value: 300]
	 * @param boolean $legend [default value: false]
	 * @param string $bar_width 
	 */
	function __construct($id="graphic_chart_id", $width=500, $height=300, $legend=false, $bar_width="") {
		parent::__construct();
		
		$this->id = $id;
		$this->width = $width;
		$this->height = $height;
		$this->legend = $legend;
		$this->grid = $grid;
		$this->bar_width = $bar_width;
		
		if ($this->getPage()->getBrowserName() == "IE" && $this->getPage()->getBrowserVersion() <= 8) {
			JavaScriptInclude::getInstance()->addToEnd(BASE_URL."wsp/js/jquery/flot/excanvas.min.js", "", true);
		}
		JavaScriptInclude::getInstance()->addToEnd(BASE_URL."wsp/js/jquery/flot/jquery.flot.js", "", true);
	}
	
	/**
	 * Method addPoints
	 * @access public
	 * @param mixed $title 
	 * @param mixed $array_data 
	 * @param string $chart_design [default value: lines]
	 * @param string $stack [default value: no_stack]
	 * @param boolean $fill [default value: false]
	 * @return Chart
	 * @since 1.0.91
	 */
	public function addPoints($title, $array_data, $chart_design="lines", $stack="no_stack", $fill=false) {
		if ($chart_design != Chart::DESIGN_BARS && $chart_design != Chart::DESIGN_LINES && $chart_design != Chart::DESIGN_LINES_WITH_STEPS &&
			$chart_design != Chart::DESIGN_LINES_POINTS && $chart_design != Chart::DESIGN_POINTS && $chart_design != Chart::DESIGN_LINES_POINTS_WITH_STEPS) {
			throw new NewException(get_class($this)."->addLine() error: \$chart_design is not recognized.", 0, getDebugBacktrace(1));
		}
		if ($stack != Chart::STYLE_STACKING && $stack != Chart::STYLE_NO_STACKING) {
			throw new NewException(get_class($this)."->addLine() error: \$chart_design is not recognized.", 0, getDebugBacktrace(1));
		}
		if (!is_array($array_data)) {
			throw new NewException(get_class($this)."->addLine() error: \$array_data must be an array of 2 dimensions.", 0, getDebugBacktrace(1));
		}
		
		$ind = sizeof($this->array_data);
		if ($stack == Chart::STYLE_STACKING) {
			JavaScriptInclude::getInstance()->addToEnd(BASE_URL."wsp/js/jquery/flot/jquery.flot.stack.js", "", true);
			$this->array_stack[$ind] = true;
		} else {
			$this->array_stack[$ind] = false;
		}
		
		$bar = false;
		$line = false;
		$step = false;
		$point = false;
		if ($chart_design == Chart::DESIGN_BARS) {
			$bar = true;
		} else if ($chart_design == Chart::DESIGN_LINES) {
			$line = true;
		} else if ($chart_design == Chart::DESIGN_LINES_WITH_STEPS) {
			$line = true;
			$step = true;
		} else if ($chart_design == Chart::DESIGN_LINES_POINTS) {
			$line = true;
			$point = true;
		} else if ($chart_design == Chart::DESIGN_POINTS) {
			$point = true;
		} else if ($chart_design == Chart::DESIGN_LINES_POINTS_WITH_STEPS) {
			$line = true;
			$point = true;
			$step = true;
		}
		
		$this->array_title[$ind] = $title;
		$this->array_data[$ind] = $array_data;
		$this->array_bar[$ind] = $bar;
		$this->array_line[$ind] = $line;
		$this->array_step[$ind] = $step;
		$this->array_point[$ind] = $point;
		$this->array_fill[$ind] = $fill;
		
		if ($this->array_bar[$ind] || $this->array_step[$ind]) {
			$this->is_bar_line = true;
		}
		
		return $this;
	}
	
	/**
	 * Method trackingWithMouse
	 * @access public
	 * @param string $tracking_mode [default value: x]
	 * @param boolean $tracking_text [default value: true]
	 * @return Chart
	 * @since 1.0.91
	 */
	public function trackingWithMouse($tracking_mode="x", $tracking_text=true) {
		$this->tracking_text = $tracking_text;
		if ($this->tracking_text) {
			$this->legend = true;
		}
		$this->tracking_mode = $tracking_mode;
		JavaScriptInclude::getInstance()->addToEnd(BASE_URL."wsp/js/jquery/flot/jquery.flot.crosshair.js", "", true);
		return $this;
	}
	
	/**
	 * Method setLegend
	 * @access public
	 * @param boolean $bool [default value: true]
	 * @return Chart
	 * @since 1.0.91
	 */
	public function setLegend($bool=true) {
		$this->legend = $bool;
		return $this;
	}
	
	/**
	 * Method setXAxisDataType
	 * @access public
	 * @param string $x_data_type 
	 * @return Chart
	 * @since 1.0.91
	 */
	public function setXAxisDataType($x_data_type="") {
		$array_data_type = explode("_", $x_data_type);
		$this->x_data_type = $array_data_type[0];
		$this->x_data_type_detail = $array_data_type[1];
		return $this;
	}
	
	/**
	 * Method setYAxisDataType
	 * @access public
	 * @param string $y_data_type 
	 * @return Chart
	 * @since 1.0.91
	 */
	public function setYAxisDataType($y_data_type="") {
		$array_data_type = explode("_", $y_data_type);
		$this->y_data_type = $array_data_type[0];
		$this->y_data_type_detail = $array_data_type[1];
		return $this;
	}
	
	/**
	 * Method setXAxisMin
	 * @access public
	 * @param mixed $x_min 
	 * @return Chart
	 * @since 1.0.91
	 */
	public function setXAxisMin($x_min) {
		$this->x_min = $x_min;
		return $this;
	}
	
	/**
	 * Method setXAxisMax
	 * @access public
	 * @param mixed $x_max 
	 * @return Chart
	 * @since 1.0.91
	 */
	public function setXAxisMax($x_max) {
		$this->x_max = $x_max;
		return $this;
	}
	
	/**
	 * Method setYAxisMin
	 * @access public
	 * @param mixed $y_min 
	 * @return Chart
	 * @since 1.0.91
	 */
	public function setYAxisMin($y_min) {
		$this->y_min = $y_min;
		return $this;
	}
	
	/**
	 * Method setYAxisMax
	 * @access public
	 * @param mixed $y_max 
	 * @return Chart
	 * @since 1.0.91
	 */
	public function setYAxisMax($y_max) {
		$this->y_max = $y_max;
		return $this;
	}
	
	/**
	 * Method render
	 * @access public
	 * @param boolean $ajax_render [default value: false]
	 * @return string html code of object Chart
	 * @since 1.0.91
	 */
	public function render($ajax_render=false) {
		$html .= "<div id=\"".$this->id."\" align=\"center\" style=\"width:".$this->width."px;height:".$this->height."px;";
		$html .= "#position:absolute;#top:50%;display:table-cell;vertical-align:middle;\"><img src=\"".BASE_URL."wsp/img/loading.gif\" width=\"32\" height=\"32\"/>";
		$html .= "</div>\n";
		$html .= $this->getJavascriptTagOpen();
		$html .= "$(function () {\n";
		for ($i=0; $i < sizeof($this->array_data); $i++) {
			$html .= "var d".($i+1)." = [";
			if (!is_array($this->array_data[$i])) {
				throw new NewException(get_class($this)."->addLine() error: \$array_data must be an array of 2 dimensions.", 0, getDebugBacktrace(1));
			}
			for ($j=0; $j < sizeof($this->array_data[$i]); $j++) {
				if (!is_array($this->array_data[$i][$j]) && sizeof($this->array_data[$i][$j]) != 2) {
					throw new NewException(get_class($this)."->addLine() error: \$array_data must be an array of 2 dimensions.", 0, getDebugBacktrace(1));
				}
				if ($j > 0) { $html .= ", "; }
				$x = $this->array_data[$i][$j][0];
				if ($this->x_data_type == "time" && strlen($x) < 13) {
					for ($k=strlen($x); $k < 13; $k++) { $x .= "0"; }
				}
				$y = $this->array_data[$i][$j][1];
				if ($this->y_data_type == "time" && strlen($y) < 13) {
					for ($k=strlen($y); $k < 13; $k++) { $y .= "0"; }
				}
				$html .= "[".(is_string($x)?"'".$x."'":$x).", ".(is_string($y)?"'".$y."'":$y)."]";
			}
			$html .= "];\n";
		}

		$html .= "var plot = $.plot($(\"#".$this->id."\"), [\n";
		for ($i=0; $i < sizeof($this->array_data); $i++) {
			if ($i > 0) { $html .= ", "; }
			$html .= "{ data: d".($i+1).",\n";
			if ($this->legend) {
				$html .= "  label: \"".html_entity_decode(str_replace("\"", " ", $this->array_title[$i]));
				if ($this->tracking_text) {
					$html .= " = 0";
					if ($this->tracking_mode == "y") {
						if ($this->x_data_type != "time") {
							$html .= $this->x_data_type;
						}
					} else {
						if ($this->y_data_type != "time") {
							$html .= $this->y_data_type;
						}
					}
				}
				$html .= "\",\n";
			}
			$chart_param = false;
			if ($this->array_stack[$i]) {
				$html .= "stack: true";
				$chart_param = true;
			}
			if ($this->array_line[$i]) {
				if ($chart_param) { $html .= ", "; }
				$html .= "lines: { show: true";
				if ($this->array_fill[$i]) {
					$html .= ", fill: true";
				}
				if ($this->array_step[$i]) {
					$html .= ", steps: true";
				}
				$html .= " }\n";
				$chart_param = true;
			}
			if ($this->array_point[$i]) {
				if ($chart_param) { $html .= ", "; }
				$html .= "points: { show: true }\n";
				$chart_param = true;
			}
			if ($this->array_bar[$i]) {
				if ($chart_param) { $html .= ", "; }
				$html .= "bars: { show: true";
				if ($this->bar_width != "") {
					$html .= ", barWidth: ".$this->bar_width."\n";
					$html .= ", order: ".($i+1)."\n";
				}
				$html .= " }\n";
				$chart_param = true;
			}
			$html .= " }\n";
		}
		$html .= " ], { \n";
		$chart_param = false;
		if ($this->legend) {
			$html .= "legend: { show: true }\n";
			$chart_param = true;
		}
		if ($this->tracking_mode != "") {
			if ($chart_param) { $html .= ", "; }
        	$html .= "crosshair: { mode: \"".$this->tracking_mode."\" }\n";
            $html .= ", grid: { hoverable: true, autoHighlight: false }\n";
			$chart_param = true;
		}
		if ($this->x_data_type != Chart::DATA_TYPE_NUMERIC || $this->x_min != "" || $this->x_max != "") {
			$chart_param2 = false;
			if ($chart_param) { $html .= ", "; }
        	$html .= "xaxes: [ { ";
        	if ($this->x_data_type != Chart::DATA_TYPE_NUMERIC) {
	        	$html .= "tickFormatter: xAxisFormatter";
	        	$chart_param2 = true;
        	}
        	if ($this->x_min != "") {
				if ($chart_param2) { $html .= ", "; }
				$html .= "min: ".$this->x_min;
	        	$chart_param2 = true;
        	}
        	if ($this->x_max != "") {
				if ($chart_param2) { $html .= ", "; }
				$html .= "max: ".$this->x_max;
	        	$chart_param2 = true;
        	}
			$html .= " } ]\n";
			$chart_param = true;
		}
		if ($this->y_data_type != Chart::DATA_TYPE_NUMERIC || $this->y_min != "" || $this->y_max != "") {
			$chart_param2 = false;
			if ($chart_param) { $html .= ", "; }
        	$html .= "yaxes: [ { ";
        	if ($this->y_data_type != Chart::DATA_TYPE_NUMERIC) {
        		$html .= "tickFormatter: yAxisFormatter";
	        	$chart_param2 = true;
        	}
        	if ($this->y_min != "") {
				if ($chart_param2) { $html .= ", "; }
				$html .= "min: ".$this->y_min;
	        	$chart_param2 = true;
        	}
			if ($this->y_max != "") {
				if ($chart_param2) { $html .= ", "; }
				$html .= "max: ".$this->y_max;
	        	$chart_param2 = true;
        	}
			$html .= " } ]\n";
			$chart_param = true;
		}
		$html .= "});\n";
	
		if ($this->x_data_type != Chart::DATA_TYPE_NUMERIC) {
			if ($this->x_data_type == "time") {
				$html .= "function xAxisFormatter(v, axis) { var d = new Date(v); return ";
      	if ($this->x_data_type_detail == "time") {
      		$html .= "(d.getHours()<10?'0'+d.getHours():d.getHours()) + ':' + (d.getMinutes()<10?'0'+d.getMinutes():d.getMinutes())";
      	} else if ($this->x_data_type_detail == "date") {
      		$html .= "$.datepicker.formatDate('yy-mm-dd', d)";
      	} else if ($this->x_data_type_detail == "day") {
      		$html .= "$.datepicker.formatDate('D', d)";
      	} else if ($this->x_data_type_detail == "month") {
      		$html .= "$.datepicker.formatDate('M', d)";
      	} else if ($this->x_data_type_detail == "daymonth") {
      		$html .= "$.datepicker.formatDate('d M', d)";
      	} else if ($this->x_data_type_detail == "year") {
      		$html .= "$.datepicker.formatDate('yy', d)";
      	} else {
      		$html .= "$.datepicker.formatDate('yy-mm-dd', d) + ' ' + (d.getHours()<10?'0'+d.getHours():d.getHours()) + ':' + (d.getMinutes()<10?'0'+d.getMinutes():d.getMinutes())";
      	}
      	$html .= "; }\n";
			} else if (find($this->x_data_type, "%s") > 0) {
				$html .= "function xAxisFormatter(v, axis) { return myReplace('".addslashes($this->x_data_type)."', '%s', v.toFixed(axis.tickDecimals)); }\n";
			} else {
				$html .= "function xAxisFormatter(v, axis) { return v.toFixed(axis.tickDecimals) + '".addslashes($this->x_data_type)."'; }\n";
			}
		}
		if ($this->y_data_type != Chart::DATA_TYPE_NUMERIC) {
			if ($this->y_data_type == "time") {
				$html .= "function yAxisFormatter(v, axis) { var d = new Date(v); return ";
      	if ($this->y_data_type_detail == "time") {
      		$html .= "(d.getHours()<10?'0'+d.getHours():d.getHours()) + ':' + (d.getMinutes()<10?'0'+d.getMinutes():d.getMinutes())";
      	} else if ($this->y_data_type_detail == "date") {
      		$html .= "$.datepicker.formatDate('yy-mm-dd', d)";
      	} else if ($this->y_data_type_detail == "day") {
      		$html .= "$.datepicker.formatDate('D', d)";
      	} else if ($this->y_data_type_detail == "month") {
      		$html .= "$.datepicker.formatDate('M', d)";
      	} else if ($this->y_data_type_detail == "daymonth") {
      		$html .= "$.datepicker.formatDate('d M', d)";
      	} else if ($this->y_data_type_detail == "year") {
      		$html .= "$.datepicker.formatDate('yy', d)";
      	} else {
      		$html .= "$.datepicker.formatDate('yy-mm-dd', d) + ' ' + (d.getHours()<10?'0'+d.getHours():d.getHours()) + ':' + (d.getMinutes()<10?'0'+d.getMinutes():d.getMinutes())";
      	}
      	$html .= "; }\n";
			} else if (find($this->y_data_type, "%s") > 0) {
				$html .= "function yAxisFormatter(v, axis) { return myReplace('".addslashes($this->y_data_type)."', '%s', v.toFixed(axis.tickDecimals)); }\n";
			} else {
				$html .= "function yAxisFormatter(v, axis) { return v.toFixed(axis.tickDecimals) + '".addslashes($this->y_data_type)."'; }\n";
			}
		}
		
		if ($this->tracking_mode != "" && $this->tracking_text) {
			$html .= "var legends = $(\"#".$this->id." .legendLabel\");
		    legends.each(function () {
		        // fix the widths so they don't jump around
		        $(this).attr('nowrap', 'true');
		    });
		 
		    var updateLegendTimeout = null;
		    var latestPosition = null;
		    
		    function updateLegend() {
		        updateLegendTimeout = null;
		        
		        var pos = latestPosition;
		        
		        var axes = plot.getAxes();
		        if (pos.x < axes.xaxis.min || pos.x > axes.xaxis.max ||
		            pos.y < axes.yaxis.min || pos.y > axes.yaxis.max)
		            return;
		 
		        var i, j, dataset = plot.getData();
		        for (i = 0; i < dataset.length; ++i) {
		            var series = dataset[i];
		 
		            // find the nearest points, x-wise
		            for (j = 0; j < series.data.length; ++j)
		                if (series.data[j][0] > pos.".$this->tracking_mode.")
		                    break;
		            
		            // now interpolate\n";
					if ($this->tracking_mode == "y") {
						if ($this->is_bar_line) {
							$html .= "var p = series.data[j-1];
							if (p != null)
								y = parseFloat(p[1]);
							\n";
						} else {
					            $html .= "var y, p1 = series.data[j - 1], p2 = series.data[j];
					            if (p1 == null)
			        		        y = parseFloat(p2[1]);
					            else if (p2 == null)
					                y = parseFloat(p1[1]);
			        		    else
					                y = parseFloat(p1[1]) + (parseFloat(p2[1]) - parseFloat(p1[1])) * (parseFloat(pos.y) - parseFloat(p1[0])) / (parseFloat(p2[0]) - parseFloat(p1[0]));
						 \n";
						}
			            if ($this->x_data_type == "time") {
			            	$html .= "var d = new Date(y);\n";
			            	$html .= "legends.eq(i).text(series.label.replace(/=.*/, \"= \" + ";
			            	if ($this->x_data_type_detail == "time") {
			            		$html .= "(d.getHours()<10?'0'+d.getHours():d.getHours()) + ':' + (d.getMinutes()<10?'0'+d.getMinutes():d.getMinutes()) + ':' + (d.getSeconds()<10?'0'+d.getSeconds():d.getSeconds())";
			            	} else if ($this->x_data_type_detail == "date") {
			            		$html .= "$.datepicker.formatDate('yy-mm-dd', d)";
						      	} else if ($this->x_data_type_detail == "day") {
						      		$html .= "$.datepicker.formatDate('D', d)";
						      	} else if ($this->x_data_type_detail == "month") {
						      		$html .= "$.datepicker.formatDate('M', d)";
						      	} else if ($this->x_data_type_detail == "daymonth") {
						      		$html .= "$.datepicker.formatDate('d M', d)";
						      	} else if ($this->x_data_type_detail == "year") {
						      		$html .= "$.datepicker.formatDate('yy', d)";
			            	} else {
			            		$html .= "$.datepicker.formatDate('yy-mm-dd', d) + ' ' + (d.getHours()<10?'0'+d.getHours():d.getHours()) + ':' + (d.getMinutes()<10?'0'+d.getMinutes():d.getMinutes()) + ':' + (d.getSeconds()<10?'0'+d.getSeconds():d.getSeconds())";
			            	}
			            	$html .= "));\n";
			            } else {
			            	$html .= "legends.eq(i).text(series.label.replace(/=.*/, \"= \" + y.toFixed(2) + \"".$this->x_data_type."\"));\n";
			            }
					} else {
						if ($this->is_bar_line) {
							$html .= "var p = series.data[j-1];
							if (p != null)
								x = parseFloat(p[1]);
							\n";
						} else {
					            $html .= "var x, p2 = series.data[j - 1], p1 = series.data[j];
					            if (p1 == null)
			        		        x = parseFloat(p2[1]);
					            else if (p2 == null)
					                x = parseFloat(p1[1]);
			        		    else
					                x = parseFloat(p1[1]) + (parseFloat(p2[1]) - parseFloat(p1[1])) * (parseFloat(pos.x) - parseFloat(p1[0])) / (parseFloat(p2[0]) - parseFloat(p1[0]));
						 \n";
						}
			            if ($this->y_data_type == "time") {
			            	$html .= "var d = new Date(x);\n";
			            	$html .= "legends.eq(i).text(series.label.replace(/=.*/, \"= \" + ";
			            	if ($this->y_data_type_detail == "time") {
			            		$html .= "(d.getHours()<10?'0'+d.getHours():d.getHours()) + ':' + (d.getMinutes()<10?'0'+d.getMinutes():d.getMinutes()) + ':' + (d.getSeconds()<10?'0'+d.getSeconds():d.getSeconds())";
			            	} else if ($this->y_data_type_detail == "date") {
			            		$html .= "$.datepicker.formatDate('yy-mm-dd', d)";
						      	} else if ($this->y_data_type_detail == "day") {
						      		$html .= "$.datepicker.formatDate('D', d)";
						      	} else if ($this->y_data_type_detail == "month") {
						      		$html .= "$.datepicker.formatDate('M', d)";
						      	} else if ($this->y_data_type_detail == "daymonth") {
						      		$html .= "$.datepicker.formatDate('d M', d)";
						      	} else if ($this->y_data_type_detail == "year") {
						      		$html .= "$.datepicker.formatDate('yy', d)";
			            	} else {
			            		$html .= "$.datepicker.formatDate('yy-mm-dd', d) + ' ' + (d.getHours()<10?'0'+d.getHours():d.getHours()) + ':' + (d.getMinutes()<10?'0'+d.getMinutes():d.getMinutes()) + ':' + (d.getSeconds()<10?'0'+d.getSeconds():d.getSeconds())";
			            	}
			            	$html .= "));\n";
			            } else {
				            $html .= "legends.eq(i).text(series.label.replace(/=.*/, \"= \" + x.toFixed(2) + \"".$this->y_data_type."\"));\n";
			            }
				   }
				$html .= "$($('.legend').find('div')[0]).css('width', $('.legendLabel').parent().parent().width()).css('opacity', 0.65);
				}
		    }
		    
		    $(\"#".$this->id."\").bind(\"plothover\",  function (event, pos, item) {
		        latestPosition = pos;
		        if (!updateLegendTimeout)
		            updateLegendTimeout = setTimeout(updateLegend, 50);
		    });\n";
		}
		
		$html .= "	$(\"#".$this->id."\").css('display', 'block');\n";
   		$html .= " });\n";
		$html .= $this->getJavascriptTagClose();
		return $html;
	}
}
?>
