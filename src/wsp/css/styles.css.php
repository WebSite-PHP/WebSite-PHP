<?php 
	header("Content-type: text/css");
  header("Cache-control: public");
  
  $zlib_OC_is_set = eregi('On|(^[0-9]+$)', ini_get('zlib.output_compression'));
  if (!$zlib_OC_is_set) { ini_set('zlib.output_compression','On'); }
	$zlib_OC_is_set = eregi('On|(^[0-9]+$)', ini_get('zlib.output_compression'));
	if ($zlib_OC_is_set) { header("Content-Encoding: gzip"); }
	
	$expires = 60*60*24; // 24 hours
	header("Pragma: public");
	header("Cache-Control: maxage=".$expires);
	header('Expires: ' . gmdate('D, d M Y H:i:s', time()+$expires) . ' GMT');
  
	include("../config/config_css.inc.php");

	if (!defined('DEFINE_STYLE_COLOR_MAIN_HEADER_LINK')) {
		define("DEFINE_STYLE_COLOR_MAIN_HEADER_LINK", "");
	}
	if (!defined('DEFINE_STYLE_COLOR_MAIN_HEADER_LINK_HOVER')) {
		define("DEFINE_STYLE_COLOR_MAIN_HEADER_LINK_HOVER", "");
	}
	
	if (!defined('DEFINE_STYLE_COLOR_SECOND_HEADER_LINK')) {
		define("DEFINE_STYLE_COLOR_SECOND_HEADER_LINK", "");
	}
	if (!defined('DEFINE_STYLE_COLOR_SECOND_HEADER_LINK_HOVER')) {
		define("DEFINE_STYLE_COLOR_SECOND_HEADER_LINK_HOVER", "");
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
?>
/*** Global ***/
body {
	font-size: <?php echo $style_font_size_value; ?>;
	font-family: <?php echo $style_font_value; ?>, <?php echo $style_font_serif_value; ?>;
	background:<?php echo DEFINE_STYLE_BCK_BODY; ?>;
	color: <?php echo DEFINE_STYLE_COLOR_BODY; ?>;
	margin:0px;
	padding:3px;
	height:100%;
	overflow-y:auto;
}

form {
	display: block;
	margin: 0 0 0 0;
	font-size: <?php echo $style_font_size_value; ?>;
	font-family: <?php echo $style_font_value; ?>, <?php echo $style_font_serif_value; ?>;
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

a:hover {
	color: <?php echo DEFINE_STYLE_LINK_HOVER_COLOR; ?>;
	font-size:<?php echo $style_font_size_value; ?>;
	font-family:<?php echo $style_font_value; ?>, <?php echo $style_font_serif_value; ?>;
}

/*** Tableau Main ***/
.table_main_angle {
	border-left: 1px solid <?php echo DEFINE_STYLE_BORDER_TABLE_MAIN; ?>;
	border-right: 1px solid <?php echo DEFINE_STYLE_BORDER_TABLE_MAIN; ?>;
	border-bottom: 1px solid <?php echo DEFINE_STYLE_BORDER_TABLE_MAIN; ?>;
	background: <?php echo DEFINE_STYLE_BCK_MAIN; ?>;
	color: <?php echo DEFINE_STYLE_COLOR_MAIN; ?>;
	padding-right:-10px;
}
.table_main {
	background: <?php echo DEFINE_STYLE_BCK_MAIN; ?>;
	color: <?php echo DEFINE_STYLE_COLOR_MAIN; ?>;
	font-size: <?php echo $style_font_size_value; ?>;
	font-family: <?php echo $style_font_value; ?>, <?php echo $style_font_serif_value; ?>;
	text-align: left;
}
.table_main_bckg {
	border: 0px;
	background: <?php echo DEFINE_STYLE_BCK_MAIN; ?>;
	color: <?php echo DEFINE_STYLE_COLOR_MAIN; ?>;
	padding-left: 5px;
	padding-right: 5px;
	text-align: left;
	font-size: <?php echo $style_font_size_value; ?>;
	font-family: <?php echo $style_font_value; ?>, <?php echo $style_font_serif_value; ?>;
}
.main_bckg {
	background: <?php echo DEFINE_STYLE_BCK_MAIN; ?>;
	color: <?php echo DEFINE_STYLE_COLOR_MAIN; ?>;
	font-size: <?php echo $style_font_size_value; ?>;
	font-family: <?php echo $style_font_value; ?>, <?php echo $style_font_serif_value; ?>;
	text-align: left;
}
.header_main_bckg {
	background: <?php echo DEFINE_STYLE_BCK_MAIN_HEADER; ?>;
	color: <?php echo DEFINE_STYLE_COLOR_MAIN_HEADER; ?>;
	font-size: <?php echo $style_font_size_value; ?>;
	font-family: <?php echo $style_font_value; ?>, <?php echo $style_font_serif_value; ?>;
	font-weight: bold;
	height: 21px;
	padding-left: 5px;
	vertical-align: middle;
	text-align: left;
}
.table_main_round {
	background: <?php echo DEFINE_STYLE_BCK_MAIN_HEADER; ?>;
}

.header_main_bckg a {
	color:<?php if (DEFINE_STYLE_COLOR_MAIN_HEADER_LINK == "") { echo DEFINE_STYLE_COLOR_MAIN_HEADER; } else { echo DEFINE_STYLE_COLOR_MAIN_HEADER_LINK; } ?>;
	text-decoration: none;
	font-size:<?php echo $style_font_size_value; ?>;
	font-family:<?php echo $style_font_value; ?>, <?php echo $style_font_serif_value; ?>;
}

.header_main_bckg a:hover {
	color: <?php if (DEFINE_STYLE_COLOR_MAIN_HEADER_LINK_HOVER == "") { if (DEFINE_STYLE_COLOR_MAIN_HEADER_LINK == "") { echo DEFINE_STYLE_COLOR_MAIN_HEADER; } else { echo DEFINE_STYLE_COLOR_MAIN_HEADER_LINK; } } else { echo DEFINE_STYLE_COLOR_MAIN_HEADER_LINK_HOVER; } ?>;
	font-size:<?php echo $style_font_size_value; ?>;
	font-family:<?php echo $style_font_value; ?>, <?php echo $style_font_serif_value; ?>;
}

/*** Tableau second ***/
.table_second_angle {
	border-left: 1px solid <?php echo DEFINE_STYLE_BORDER_TABLE_SECOND; ?>;
	border-right: 1px solid <?php echo DEFINE_STYLE_BORDER_TABLE_SECOND; ?>;
	border-bottom: 1px solid <?php echo DEFINE_STYLE_BORDER_TABLE_SECOND; ?>;
	background: <?php echo DEFINE_STYLE_BCK_SECOND; ?>;
	color: <?php echo DEFINE_STYLE_COLOR_SECOND; ?>;
	padding-right:-10px;
}
.table_second {
	background: <?php echo DEFINE_STYLE_BCK_SECOND; ?>;
	color: <?php echo DEFINE_STYLE_COLOR_SECOND; ?>;
	font-size: <?php echo $style_font_size_value; ?>;
	font-family: <?php echo $style_font_value; ?>, <?php echo $style_font_serif_value; ?>;
	text-align: left;
}
.table_second_bckg {
	border: 0px;
	background: <?php echo DEFINE_STYLE_BCK_SECOND; ?>;
	color: <?php echo DEFINE_STYLE_COLOR_SECOND; ?>;
	text-align: left;
	padding-left: 5px;
	font-size: <?php echo $style_font_size_value; ?>;
	font-family: <?php echo $style_font_value; ?>, <?php echo $style_font_serif_value; ?>;
}
.second_bckg {
	background: <?php echo DEFINE_STYLE_BCK_SECOND; ?>;
	color: <?php echo DEFINE_STYLE_COLOR_SECOND; ?>;
	font-size: <?php echo $style_font_size_value; ?>;
	font-family: <?php echo $style_font_value; ?>, <?php echo $style_font_serif_value; ?>;
	text-align: left;
}
.header_second_bckg {
	background: <?php echo DEFINE_STYLE_BCK_SECOND_HEADER; ?>;
	color: <?php echo DEFINE_STYLE_COLOR_SECOND_HEADER; ?>;
	font-size: <?php echo $style_font_size_value; ?>;
	font-family: <?php echo $style_font_value; ?>, <?php echo $style_font_serif_value; ?>;
	font-weight: bold;
	height: 21px;
	text-align: left;
	border: 0px;
}
.table_second_round {
	background: <?php echo DEFINE_STYLE_BCK_SECOND_HEADER; ?>;
}

.header_second_bckg a {
	color:<?php if (DEFINE_STYLE_COLOR_SECOND_HEADER_LINK == "") { echo DEFINE_STYLE_COLOR_SECOND_HEADER; } else { echo DEFINE_STYLE_COLOR_SECOND_HEADER_LINK; } ?>;
	text-decoration: none;
	font-size:<?php echo $style_font_size_value; ?>;
	font-family:<?php echo $style_font_value; ?>, <?php echo $style_font_serif_value; ?>;
}

.header_second_bckg a:hover {
	color: <?php if (DEFINE_STYLE_COLOR_SECOND_HEADER_LINK_HOVER == "") { if (DEFINE_STYLE_COLOR_SECOND_HEADER_LINK == "") { echo DEFINE_STYLE_COLOR_SECOND_HEADER; } else { echo DEFINE_STYLE_COLOR_SECOND_HEADER_LINK; } } else { echo DEFINE_STYLE_COLOR_SECOND_HEADER_LINK_HOVER; } ?>;
	font-size: <?php echo $style_font_size_value; ?>;
	font-family:<?php echo $style_font_value; ?>, <?php echo $style_font_serif_value; ?>;
}

td {
	font-size: <?php echo $style_font_size_value; ?>;
	font-family: <?php echo $style_font_value; ?>, <?php echo $style_font_serif_value; ?>;
	text-align: left;
}

.draggable {
  cursor: move;
  position: absolute;
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
