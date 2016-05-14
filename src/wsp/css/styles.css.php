<?php 
	if(!isset($_SESSION)) {
		include_once("../config/config.inc.php");
        include_once("../includes/utils_session.inc.php");
        @session_set_cookie_params(0, "/", $_SERVER['SERVER_NAME'], false, true);
		@session_name(formalize_to_variable(SITE_NAME));
		@session_start();
	}
	
	if (isset($_GET['conf_file']) && file_exists("../config/".$_GET['conf_file'])) {
		include_once("../config/".$_GET['conf_file']);
	} else {
		include_once("../config/config_css.inc.php");
	}
	
	header("Content-type: text/css");
	header("Cache-control: public");
  
	/*$zlib_OC_is_set = preg_match('/On|(^[0-9]+$)/i', ini_get('zlib.output_compression'));
	if ($zlib_OC_is_set) {
		if (@strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') !== FALSE) {
			header("Content-Encoding: gzip"); 
		}
	}*/
	
	$expires = 60*60*24*7; // 7 days
	header("Pragma: public");
	header("Cache-Control: maxage=".$expires);
	header('Expires: ' . gmdate('D, d M Y H:i:s', time()+$expires) . ' GMT');

	if (!defined('DEFINE_STYLE_COLOR_2_HEADER_LINK')) {
		define("DEFINE_STYLE_COLOR_2_HEADER_LINK", "");
	}
	if (!defined('DEFINE_STYLE_COLOR_2_HEADER_LINK_HOVER')) {
		define("DEFINE_STYLE_COLOR_2_HEADER_LINK_HOVER", "");
	}
	
	if (!defined('DEFINE_STYLE_FONT')) {
		define("DEFINE_STYLE_FONT", "Arial");
	}
	$style_font_value = DEFINE_STYLE_FONT;
	if ($style_font_value == "") {
		$style_font_value = "\"Arial\"";
	}
	if ($style_font_value != "\"Arial\"") {
		$style_font_value .= ", \"Arial\"";
	}
	if (!defined('DEFINE_STYLE_FONT_SIZE')) {
		define("DEFINE_STYLE_FONT_SIZE", "10pt");
	}
	$style_font_size_value = DEFINE_STYLE_FONT_SIZE;
	if ($style_font_size_value == "") {
		$style_font_size_value = "10pt";
	}
	if (!defined('DEFINE_STYLE_FONT_SERIF')) {
		define("DEFINE_STYLE_FONT_SERIF", "sans serif");
	}
	$style_font_serif_value = DEFINE_STYLE_FONT_SERIF;
	if ($style_font_serif_value == "") {
		$style_font_serif_value = "sans serif";
	}
	
	$background_body = DEFINE_STYLE_BCK_BODY;
	if (defined('DEFINE_STYLE_BCK_BODY_PIC_POSITION') && strtoupper(DEFINE_STYLE_BCK_BODY_PIC_POSITION) != "STRETCH") {
		if (defined('DEFINE_STYLE_BCK_BODY_PIC') && DEFINE_STYLE_BCK_BODY_PIC != "") {
			$background_body .= " url('".DEFINE_STYLE_BCK_BODY_PIC."')";
			if (defined('DEFINE_STYLE_BCK_BODY_PIC_REPEAT') && DEFINE_STYLE_BCK_BODY_PIC_REPEAT != "") {
				$background_body .= " ".DEFINE_STYLE_BCK_BODY_PIC_REPEAT;
			}
			if (defined('DEFINE_STYLE_BCK_BODY_PIC_POSITION') && DEFINE_STYLE_BCK_BODY_PIC_POSITION != "") {
				$background_body .= " ".DEFINE_STYLE_BCK_BODY_PIC_POSITION;
			}
		}
	}
?>
/*** Global ***/
body {
	font-size: <?php echo $style_font_size_value; ?>;
	font-family: <?php echo $style_font_value; ?>, <?php echo $style_font_serif_value; ?>;
	background:<?php echo $background_body; ?>;
	color: <?php echo DEFINE_STYLE_COLOR_BODY; ?>;
	margin:0px;
	padding:3px;
	height:100%;
}

form {
	display: block;
	margin: 0 0 0 0;
	font-size: <?php echo $style_font_size_value; ?>;
	font-family: <?php echo $style_font_value; ?>, <?php echo $style_font_serif_value; ?>;
}
.dd {
	font-size: <?php echo $style_font_size_value; ?> !important;
	font-family: <?php echo $style_font_value; ?>, <?php echo $style_font_serif_value; ?> !important;
}
blockquote {
	display: block;
	margin-top: 0px;
	margin-bottom: 0px;
	margin-left: 20px;
	font-size: <?php echo $style_font_size_value; ?>;
	font-family: <?php echo $style_font_value; ?>, <?php echo $style_font_serif_value; ?>;
}
p {
	margin-top: 2px;
	margin-bottom: 2px;
	font-size: <?php echo $style_font_size_value; ?>;
	font-family: <?php echo $style_font_value; ?>, <?php echo $style_font_serif_value; ?>;
}

h1 {
	font-weight:bold;
	margin:0;
	padding:0;
	font-size:<?php echo $style_font_size_value; ?>;
	font-family: <?php echo $style_font_value; ?>, <?php echo $style_font_serif_value; ?>;
	display: inline;
}

h2, h3, h4, h5, h6 {
	font-weight:normal;
	margin:0;
	padding:0;
	font-size:<?php echo $style_font_size_value; ?>;
	font-family: <?php echo $style_font_value; ?>, <?php echo $style_font_serif_value; ?>;
	display: inline;
}

/*** Liens ***/
a,.link {
	color:<?php echo DEFINE_STYLE_LINK_COLOR; ?>;
	text-decoration: none;
	font-size:<?php echo $style_font_size_value; ?>;
	font-family:<?php echo $style_font_value; ?>, <?php echo $style_font_serif_value; ?>;
}

a:hover,.link:hover {
	color: <?php echo DEFINE_STYLE_LINK_HOVER_COLOR; ?>;
	font-size:<?php echo $style_font_size_value; ?>;
	font-family:<?php echo $style_font_value; ?>, <?php echo $style_font_serif_value; ?>;
}

<?php
$nb_def_style = NB_DEFINE_STYLE_BCK;
if ($is_config_theme_page && isset($_GET['wspadmin_nb_define_style'])) { // Wsp-Admin real-time configuration
	$nb_def_style = $_GET['wspadmin_nb_define_style'];
}
for ($i=1; $i <= $nb_def_style; $i++) {
	$ind = $i;
	if ($ind > NB_DEFINE_STYLE_BCK) {
		$ind = 1;
	}
	if (!defined('DEFINE_STYLE_COLOR_'.$ind.'_HEADER_LINK')) {
		define("DEFINE_STYLE_COLOR_".$ind."_HEADER_LINK", "");
	}
	if (!defined('DEFINE_STYLE_COLOR_'.$ind.'_HEADER_LINK_HOVER')) {
		define("DEFINE_STYLE_COLOR_".$ind."_HEADER_LINK_HOVER", "");
	}
	if (!defined('DEFINE_STYLE_COLOR_'.$ind.'_LINK')) {
		define("DEFINE_STYLE_COLOR_".$ind."_LINK", "");
	}
	if (!defined('DEFINE_STYLE_COLOR_'.$ind.'_LINK_HOVER')) {
		define("DEFINE_STYLE_COLOR_".$ind."_LINK_HOVER", "");
	}
?>
/*** Tableau <?php echo $i; ?> Header ***/
.header_<?php echo $i; ?>_bckg {
	background: <?php echo constant("DEFINE_STYLE_BCK_".$ind."_HEADER"); ?>;
	color: <?php echo constant("DEFINE_STYLE_COLOR_".$ind."_HEADER"); ?>;
	font-size: <?php echo $style_font_size_value; ?>;
	font-family: <?php echo $style_font_value; ?>, <?php echo $style_font_serif_value; ?>;
	font-weight: bold;
	height: 21px;
	padding-left: 5px;
	padding-right: 5px;
	vertical-align: middle;
	text-align: left;
}
.header_<?php echo $i; ?>_bckg a {
	color:<?php if (constant("DEFINE_STYLE_COLOR_".$ind."_HEADER_LINK") == "") { echo constant("DEFINE_STYLE_COLOR_".$ind."_HEADER"); } else { echo constant("DEFINE_STYLE_COLOR_".$ind."_HEADER_LINK"); } ?>;
	text-decoration: none;
	font-size:<?php echo $style_font_size_value; ?>;
	font-family:<?php echo $style_font_value; ?>, <?php echo $style_font_serif_value; ?>;
}
.header_<?php echo $i; ?>_bckg a:hover {
	color: <?php if (constant("DEFINE_STYLE_COLOR_".$ind."_HEADER_LINK_HOVER") == "") { if (constant("DEFINE_STYLE_COLOR_".$ind."_HEADER_LINK") == "") { echo constant("DEFINE_STYLE_COLOR_".$ind."_HEADER"); } else { echo constant("DEFINE_STYLE_COLOR_".$ind."_HEADER_LINK"); } } else { echo constant("DEFINE_STYLE_COLOR_".$ind."_HEADER_LINK_HOVER"); } ?>;
	font-size:<?php echo $style_font_size_value; ?>;
	font-family:<?php echo $style_font_value; ?>, <?php echo $style_font_serif_value; ?>;
}

/*** Tableau <?php echo $i; ?> ***/
.table_<?php echo $i; ?>_angle {
	border-left: 1px solid <?php echo constant("DEFINE_STYLE_BORDER_TABLE_".$ind); ?>;
	border-right: 1px solid <?php echo constant("DEFINE_STYLE_BORDER_TABLE_".$ind); ?>;
	border-bottom: 1px solid <?php echo constant("DEFINE_STYLE_BORDER_TABLE_".$ind); ?>;
	background: <?php echo constant("DEFINE_STYLE_BCK_".$ind."_HEADER"); ?>;
	color: <?php echo constant("DEFINE_STYLE_COLOR_".$ind); ?>;
	padding-right:-10px;
}
.table_<?php echo $i; ?> {
	background: <?php echo constant("DEFINE_STYLE_BCK_".$ind); ?>;
	color: <?php echo constant("DEFINE_STYLE_COLOR_".$ind); ?>;
	font-size: <?php echo $style_font_size_value; ?>;
	font-family: <?php echo $style_font_value; ?>, <?php echo $style_font_serif_value; ?>;
	text-align: left;
}
.table_<?php echo $i; ?>_bckg {
	border: 0px;
	background: <?php echo constant("DEFINE_STYLE_BCK_".$ind); ?>;
	color: <?php echo constant("DEFINE_STYLE_COLOR_".$ind); ?>;
	padding-left: 5px;
	padding-right: 5px;
	text-align: left;
	font-size: <?php echo $style_font_size_value; ?>;
	font-family: <?php echo $style_font_value; ?>, <?php echo $style_font_serif_value; ?>;
}
.table_<?php echo $i; ?>_bckg a,a.box_style_<?php echo $i; ?>:link,.table_<?php echo $i; ?>_bckg .ui-widget-content a {
	color: <?php if (constant("DEFINE_STYLE_COLOR_".$ind."_LINK") != "") { echo constant("DEFINE_STYLE_COLOR_".$ind."_LINK"); } else { echo DEFINE_STYLE_LINK_COLOR; } ?>;
	text-decoration: none;
	font-size:<?php echo $style_font_size_value; ?>;
	font-family:<?php echo $style_font_value; ?>, <?php echo $style_font_serif_value; ?>;
	cursor: pointer;
}

.table_<?php echo $i; ?>_bckg a:hover,a.box_style_<?php echo $i; ?>:hover {
	color: <?php if (constant("DEFINE_STYLE_COLOR_".$ind."_LINK_HOVER") != "") { echo constant("DEFINE_STYLE_COLOR_".$ind."_LINK_HOVER"); } else { echo DEFINE_STYLE_LINK_HOVER_COLOR; } ?>;
	font-size:<?php echo $style_font_size_value; ?>;
	font-family:<?php echo $style_font_value; ?>, <?php echo $style_font_serif_value; ?>;
}

.bckg_<?php echo $i; ?> {
	background: <?php echo constant("DEFINE_STYLE_BCK_".$ind); ?>;
	color: <?php echo constant("DEFINE_STYLE_COLOR_".$ind); ?>;
	font-size: <?php echo $style_font_size_value; ?>;
	font-family: <?php echo $style_font_value; ?>, <?php echo $style_font_serif_value; ?>;
	text-align: left;
}

.table_<?php echo $i; ?>_round {
	background: <?php echo constant("DEFINE_STYLE_BCK_".$ind."_HEADER"); ?>;
}
<?php
}

for ($i=1; $i <= $nb_def_style; $i++) {
	$ind = $i;
	if ($ind > NB_DEFINE_STYLE_BCK) {
		$ind = 1;
	}
?>
/*** Box Header <?php echo $i; ?> ***/
.header_<?php echo $i; ?>_bckg_a a {
	color:<?php if (constant("DEFINE_STYLE_COLOR_".$ind."_HEADER_LINK") == "") { echo constant("DEFINE_STYLE_COLOR_".$ind."_HEADER"); } else { echo constant("DEFINE_STYLE_COLOR_".$ind."_HEADER_LINK"); } ?>;
	text-decoration: none;
	font-size:<?php echo $style_font_size_value; ?>;
	font-family:<?php echo $style_font_value; ?>, <?php echo $style_font_serif_value; ?>;
}
.header_<?php echo $i; ?>_bckg_a a:hover {
	color: <?php if (constant("DEFINE_STYLE_COLOR_".$ind."_HEADER_LINK_HOVER") == "") { if (constant("DEFINE_STYLE_COLOR_".$ind."_HEADER_LINK") == "") { echo constant("DEFINE_STYLE_COLOR_".$ind."_HEADER"); } else { echo constant("DEFINE_STYLE_COLOR_".$ind."_HEADER_LINK"); } } else { echo constant("DEFINE_STYLE_COLOR_".$ind."_HEADER_LINK_HOVER"); } ?>;
	font-size:<?php echo $style_font_size_value; ?>;
	font-family:<?php echo $style_font_value; ?>, <?php echo $style_font_serif_value; ?>;
}
<?php
}
?>

td {
	font-size: <?php echo $style_font_size_value; ?>;
	font-family: <?php echo $style_font_value; ?>, <?php echo $style_font_serif_value; ?>;
	text-align: left;
}

.draggable {
  cursor: move;
  z-index:2;
}
.droppablehover {
  border: 2px dashed #aaa; 
}

.info, .success, .warning, .error, .validation {
border: 1px solid;
margin: 10px 0px;
padding:15px 10px 15px 50px;
background-repeat: no-repeat;
background-position: 10px center;
}
.info {
color: #00529B;
background-color: #BDE5F8;
background-image: url('../wsp/img/msg/info.png');
}
.success {
color: #4F8A10;
background-color: #DFF2BF;
background-image:url('../wsp/img/msg/success.png');
}
.warning {
color: #9F6000;
background-color: #FEEFB3;
background-image: url('../wsp/img/msg/warning.png');
}
.error {
color: #D8000C;
background-color: #FFBABA;
background-image: url('../wsp/img/msg/error.png');
}

button,
input,
select,
textarea {
  margin: 0;
  font-size: 100%;
  vertical-align: middle;
}

input[type="checkbox"] {
  vertical-align: top;
}

.ui-button {
  margin-bottom: 6px;
}

button,
input {
  *overflow: visible;
  line-height: normal;
}

button::-moz-focus-inner,
input::-moz-focus-inner {
  padding: 0;
  border: 0;
}

button,
html input[type="button"],
input[type="reset"],
input[type="submit"] {
  cursor: pointer;
  -webkit-appearance: button;
}

label[id],
select,
button,
input[type="button"],
input[type="reset"],
input[type="submit"],
input[type="radio"],
input[type="checkbox"] {
  cursor: pointer;
}

input[type="search"] {
  -webkit-box-sizing: content-box;
     -moz-box-sizing: content-box;
          box-sizing: content-box;
  -webkit-appearance: textfield;
}

input[type="search"]::-webkit-search-decoration,
input[type="search"]::-webkit-search-cancel-button {
  -webkit-appearance: none;
}

textarea {
  overflow: auto;
  vertical-align: top;
}

label,
input,
button,
select,
textarea {
  font-size: <?php echo $style_font_size_value; ?>;
  font-weight: normal;
  line-height: 20px;
}

input,
button,
select,
textarea {
  font-family: <?php echo $style_font_value; ?>, <?php echo $style_font_serif_value; ?>;
}

input[type="button"] {
  display: inline-block;
  height: 30px;
  margin-bottom: 6px;
  font-size: <?php echo $style_font_size_value; ?>;
  line-height: 20px;
  vertical-align: middle;
  -webkit-border-radius: 4px;
     -moz-border-radius: 4px;
          border-radius: 4px;
}

select,
textarea,
input[type="text"],
input[type="password"],
input[type="datetime"],
input[type="datetime-local"],
input[type="date"],
input[type="month"],
input[type="time"],
input[type="week"],
input[type="number"],
input[type="email"],
input[type="url"],
input[type="search"],
input[type="tel"],
input[type="color"],
input[class~="color"],
.uneditable-input{
  display: inline-block;
  height: 20px;
  padding: 4px 6px;
  margin-bottom: 6px;
  font-size: <?php echo $style_font_size_value; ?>;
  line-height: 20px;
  color: #555555;
  vertical-align: middle;
  -webkit-border-radius: 4px;
     -moz-border-radius: 4px;
          border-radius: 4px;
}

.divclearable {
  -webkit-border-radius: 4px;
     -moz-border-radius: 4px;
          border-radius: 4px;
  margin-bottom:6px;
}

.divclearable input[type="text"]:focus,
.divclearable input[class~="color"]:focus {
  border-color: transparent;
  -webkit-box-shadow: none;
     -moz-box-shadow: none;
          box-shadow: none;
}

.divclearable input[type="text"],
.divclearable input[class~="color"] {
  margin-bottom:0px;
}

textarea,
input[type="text"],
input[type="password"],
input[type="datetime"],
input[type="datetime-local"],
input[type="date"],
input[type="month"],
input[type="time"],
input[type="week"],
input[type="number"],
input[type="email"],
input[type="url"],
input[type="search"],
input[type="tel"],
input[type="color"],
input[class~="color"],
.uneditable-input {
  background-color: #ffffff;
  border: 1px solid #cccccc;
  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
     -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
          box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
  -webkit-transition: border linear 0.2s, box-shadow linear 0.2s;
     -moz-transition: border linear 0.2s, box-shadow linear 0.2s;
       -o-transition: border linear 0.2s, box-shadow linear 0.2s;
          transition: border linear 0.2s, box-shadow linear 0.2s;
}

textarea:focus,
input[type="text"]:focus,
input[type="password"]:focus,
input[type="datetime"]:focus,
input[type="datetime-local"]:focus,
input[type="date"]:focus,
input[type="month"]:focus,
input[type="time"]:focus,
input[type="week"]:focus,
input[type="number"]:focus,
input[type="email"]:focus,
input[type="url"]:focus,
input[type="search"]:focus,
input[type="tel"]:focus,
input[type="color"]:focus,
input[class~="color"]:focus,
.uneditable-input:focus {
  border-color: rgba(82, 168, 236, 0.8);
  outline: 0;
  outline: thin dotted \9;
  /* IE6-9 */

  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(82, 168, 236, 0.6);
     -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(82, 168, 236, 0.6);
          box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(82, 168, 236, 0.6);
}

input[type="checkbox"] {
  margin: 5px 3px 0px 10px;
  margin-top: 1px \9;
  *margin-top: 0;
  line-height: normal;
}

input[type="radio"] {
  margin: 0px 3px 0px 10px;
  margin-top: 1px \9;
  *margin-top: 0;
  line-height: normal;
}

input[type="file"],
input[type="image"],
input[type="submit"],
input[type="reset"],
input[type="button"],
input[type="radio"],
input[type="checkbox"] {
  width: auto;
}

select,
input[type="file"] {
  height: 30px;
  /* In IE7, the height of the select element cannot be changed by height, only font-size */

  *margin-top: 4px;
  /* For IE7, add top margin to align select with labels */

  line-height: 30px;
}

select {
  background-color: #ffffff;
  border: 1px solid #cccccc;
}

select[multiple],
select[size] {
  height: auto;
}

select:focus,
input[type="file"]:focus,
input[type="radio"]:focus,
input[type="checkbox"]:focus {
  outline: thin dotted #333;
  outline: 5px auto -webkit-focus-ring-color;
  outline-offset: -2px;
}

input:-moz-placeholder,
textarea:-moz-placeholder {
  color: #999999;
}

input:-ms-input-placeholder,
textarea:-ms-input-placeholder {
  color: #999999;
}

input::-webkit-input-placeholder,
textarea::-webkit-input-placeholder {
  color: #999999;
}

.UploadFileInput {
    display: none;
}

.UploadFile .button {
	display: inline-block;
    text-align:center;
    color:#000;
    font-weight: bold;
    background-color: #CECECE;
	border: 1px solid #666;
    height: 24px;
	padding: 4px 4px 0px 4px;
    margin-bottom:5px;
	margin-left: 6px;
	cursor: pointer;
	vertical-align: top;
  font-size: <?php echo $style_font_size_value; ?>;
  -webkit-border-radius: 4px;
     -moz-border-radius: 4px;
          border-radius: 4px;
}

.ui-widget div {
	font-family: <?php echo $style_font_value; ?>, <?php echo $style_font_serif_value; ?>;
	font-size: <?php echo $style_font_size_value; ?>;
}

#cookieChoiceInfo {
	background-color: #666766;
	color: #fff;
}
#cookieChoiceInfo a {
	background-color: #464847;
	border: 1px solid rgba(0,0,0,.1);
	-moz-border-radius: 2px;
	-webkit-border-radius: 2px;
	border-radius: 2px;
	color: #fff;
	cursor: pointer;
	line-height: 19px;
	padding: 4px 8px;
	text-decoration: none;
	white-space: nowrap;
}
#cookieChoiceInfo span {
	width: 70%;
	display: inline-block;
}

<?php
include_once("../includes/utils_image.inc.php");
if (!defined('DEFINE_STYLE_COLOR_UPLOAD_PROGRESS_BAR')) {
    define("DEFINE_STYLE_COLOR_UPLOAD_PROGRESS_BAR", "#448ebb");
}
$gradient = gradientColorGenerator(str_replace("#", "", DEFINE_STYLE_COLOR_UPLOAD_PROGRESS_BAR), null);
define("DEFINE_STYLE_COLOR_UPLOAD_PROGRESS_BAR_BACKGROUND", "#".$gradient[3]);
?>
.wsp-progress-bar-container{ text-align:center; top:40%; display:none; padding:20px; }
.wsp-progress-bar-container .wsp-progress-bar .wsp-progress-bar-1 { position:relative; top: 2px; color:<?php echo isDarkHexaColor(DEFINE_STYLE_COLOR_UPLOAD_PROGRESS_BAR)?"white":"black"; ?> }
.wsp-progress-bar-container .wsp-progress-bar .wsp-progress-bar-2 { position:relative; top: 2px; color:<?php echo isDarkHexaColor(DEFINE_STYLE_COLOR_UPLOAD_PROGRESS_BAR_BACKGROUND)?"white":"black"; ?> }
.wsp-progress-bar-container .wsp-progress-bar { position:relative;  height:<?php echo str_replace("pt", "", $style_font_size_value) + 8; ?>px; background-color:<?php echo DEFINE_STYLE_COLOR_UPLOAD_PROGRESS_BAR_BACKGROUND; ?>; }
.wsp-progress-bar-container .wsp-progress-bar>div{ position:absolute; left:0; top:0; bottom:0; width:0.5%; background-color:<?php echo DEFINE_STYLE_COLOR_UPLOAD_PROGRESS_BAR; ?>;  }

<?php
if (!defined('DEFINE_STYLE_BACKCOLOR_SCROLL_TO_TOP')) {
    define("DEFINE_STYLE_BACKCOLOR_SCROLL_TO_TOP", "#F00001");
}
?>
.backtotopinstance{
    position: fixed;
    right: 50px;
    bottom: 50px;
    background: #eee;
    border: 1px solid rgba(0, 0, 0, 0.1);
    border-radius: 3px 3px 3px 3px;
    padding: 15px 25px;
    background: url("../wsp/img/arrow-top.png") no-repeat scroll -2px -2px <?php echo DEFINE_STYLE_BACKCOLOR_SCROLL_TO_TOP; ?>;
    height: 30px;
	width: 10px;
}

a label {
	cursor: pointer;
}

.dataTables_wrapper .ui-buttonset .ui-button {
	min-width: 1.5em;
    padding: 0.15em;
}
.dataTables_wrapper .dataTables_paginate {
	min-height: 2.3em;
}