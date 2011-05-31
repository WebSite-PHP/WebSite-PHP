<?php 
	if(!isset($_SESSION)) {
		include_once("../includes/utils_session.inc.php");
		session_name(formalize_to_variable(SITE_NAME));
		session_start();
	}
	
	if (isset($_GET['conf_file']) && file_exists("../config/".$_GET['conf_file'])) {
		include_once("../config/".$_GET['conf_file']);
	} else {
		include_once("../config/config_css.inc.php");
	}
	include_once("../config/config.inc.php"); 
	
	header("Content-type: text/css");
  
	$zlib_OC_is_set = preg_match('/On|(^[0-9]+$)/i', ini_get('zlib.output_compression'));
	if ($zlib_OC_is_set) { header("Content-Encoding: gzip"); }
	
	$expires = 60*60*24*7; // 7 days
	header("Pragma: public");
	header("Cache-Control: maxage=".$expires);
	header('Expires: ' . gmdate('D, d M Y H:i:s', time()+$expires) . ' GMT');
	
	$is_css_round_box = false;
	$is_pic_round_box = false;
	for ($i=1; $i <= NB_DEFINE_STYLE_BCK; $i++) { 
		if (constant("DEFINE_STYLE_BCK_PICTURE_".$i) == "") {
			$is_css_round_box = true;
		} else {
			$is_pic_round_box = true;
		}
	}
	
	if (!isset($is_config_theme_page)) { $is_config_theme_page = false; }
	if ($is_css_round_box || $is_config_theme_page) {
		for ($i=1; $i <= NB_DEFINE_STYLE_BCK; $i++) {
			if (constant("DEFINE_STYLE_BCK_PICTURE_".$i) == "" || $is_config_theme_page) {
?>
/* définition des pixels d'angles */
.AngleRond<?php echo $i; ?> {
	display:block;
	overflow:hidden;
	height:1px;
	border-left:1px solid <?php echo constant("DEFINE_STYLE_BORDER_TABLE_".$i); ?>;
	border-right:1px solid <?php echo constant("DEFINE_STYLE_BORDER_TABLE_".$i); ?>;
	background:<?php echo constant("DEFINE_STYLE_BCK_".$i."_HEADER"); ?>;
}

.AngleRond<?php echo $i; ?>Ombre {
	position:relative;
	display:block;
	overflow:hidden;
	height:1px;
	border-left:1px solid <?php echo constant("DEFINE_STYLE_BORDER_TABLE_".$i); ?>;
	border-right:1px solid <?php echo constant("DEFINE_STYLE_BORDER_TABLE_".$i); ?>;
	background:<?php echo constant("DEFINE_STYLE_BCK_".$i."_HEADER"); ?>;
}

.pix1<?php echo $i; ?> {margin:0 5px; background:<?php echo constant("DEFINE_STYLE_BORDER_TABLE_".$i); ?>;}

.pix1<?php echo $i; ?>Ombre {top:-5px; margin:0; margin-left:5px; margin-right:9px; background:<?php echo constant("DEFINE_STYLE_BORDER_TABLE_".$i); ?>;}

.ombre<?php echo $i; ?> {
  background-color: <?php echo(!defined("DEFINE_STYLE_OMBRE_COLOR_".$i))?DEFINE_STYLE_OMBRE_COLOR:constant("DEFINE_STYLE_OMBRE_COLOR_".$i); ?>;
  padding: 0px;
  margin-left:5px;
  clear:left;
}

.Css3RadiusBox<?php echo $i; ?> {
<?php
	$css = "";
	$radius = 8;
	$css .= "border-top:1px solid ".constant("DEFINE_STYLE_BORDER_TABLE_".$i).";";
	$css .= "border-top-left-radius:".$radius."px;-moz-border-radius-topleft:".$radius."px;-webkit-border-top-left-radius:".$radius."px;";
	$css .= "border-top-right-radius:".$radius."px;-moz-border-radius-topright:".$radius."px;-webkit-border-top-right-radius:".$radius."px;";
	echo $css;
?>
}
.Css3RadiusRoundBox<?php echo $i; ?> {
<?php 
	$css = "";
	$css .= "border-top:1px solid ".constant("DEFINE_STYLE_BORDER_TABLE_".$i).";";
	$css .= "border-bottom:1px solid ".constant("DEFINE_STYLE_BORDER_TABLE_".$i).";";
	$css .= "border-radius:10px;-moz-border-radius:10px;-webkit-border-radius:10px;";
	echo $css;
?>
}

.Css3ShadowBox<?php echo $i; ?> {
<?php
	$css = "";
	$shadow_color = (!defined("DEFINE_STYLE_OMBRE_COLOR_".$i))?DEFINE_STYLE_OMBRE_COLOR:constant("DEFINE_STYLE_OMBRE_COLOR_".$i);
	$css .= "box-shadow:5px 5px 5px ".$shadow_color.";-webkit-box-shadow:5px 5px 5px ".$shadow_color.";-moz-box-shadow:5px 5px 5px ".$shadow_color.";";
	echo $css;
?>
}

.Css3RadiusBoxTitle<?php echo $i; ?> {
<?php 
	$css = "";
	$radius = 8;
	$css .= "background: ".constant("DEFINE_STYLE_BCK_".$i."_HEADER").";";
	$css .= "border-top-left-radius:".$radius."px;-moz-border-radius-topleft:".$radius."px;-webkit-border-top-left-radius:".$radius."px;";
	$css .= "border-top-right-radius:".$radius."px;-moz-border-radius-topright:".$radius."px;-webkit-border-top-right-radius:".$radius."px;";
	$css .= "padding:4px 0px 4px 5px;";
	echo $css;
?>
}

.Css3GradientBoxTitle<?php echo $i; ?> {
<?php 
	$css = "";
	$css .= "background-image: url(../wsp/css/gradient.svg.php?start=".urlencode(constant("DEFINE_STYLE_BCK_".$i."_HEADER"))."&stop=".urlencode(constant("DEFINE_STYLE_BORDER_TABLE_".$i))."&i=".$i.");";
    $css .= "background-size: 100% 100%;";
    $css .= "background-repeat: repeat-x;";
    $css .= "background-position: 0 0;";
    $css .= "background-color: ".constant("DEFINE_STYLE_BCK_".$i."_HEADER")."; /* old browsers */";
	$css .= "background:-moz-linear-gradient(90deg, ".constant("DEFINE_STYLE_BCK_".$i."_HEADER")." 70%, ".constant("DEFINE_STYLE_BORDER_TABLE_".$i)." 100%);";
	$css .= "background:-webkit-gradient(linear, left top, left bottom, from(".constant("DEFINE_STYLE_BCK_".$i."_HEADER")."), to(".constant("DEFINE_STYLE_BORDER_TABLE_".$i)."));";
	$css .= "background-image:-webkit-gradient(linear, left bottom, left top, color-stop(0.7,".constant("DEFINE_STYLE_BCK_".$i."_HEADER")."), color-stop(1,".constant("DEFINE_STYLE_BORDER_TABLE_".$i)."));";
	$css .= "background-image:-ms-linear-gradient(top, ".constant("DEFINE_STYLE_BCK_".$i."_HEADER").", ".constant("DEFINE_STYLE_BORDER_TABLE_".$i)."); /* IE10 */";
	$css .= "background-image:-o-linear-gradient(top, ".constant("DEFINE_STYLE_BORDER_TABLE_".$i).", ".constant("DEFINE_STYLE_BCK_".$i."_HEADER")."); /* Opera 11.10+ */";
	$css .= "background-image:linear-gradient(top, ".constant("DEFINE_STYLE_BCK_".$i."_HEADER").", ".constant("DEFINE_STYLE_BORDER_TABLE_".$i).");";
	$css .= "filter: progid:DXImageTransform.Microsoft.gradient(enabled='true',startColorstr=".constant("DEFINE_STYLE_BORDER_TABLE_".$i).",endColorstr=".constant("DEFINE_STYLE_BCK_".$i."_HEADER").",GradientType=0); zoom: 1;";
	echo $css;
?>
}
<?php
			}
		} 
?>

.pix2 {margin:0 3px;}
.pix3 {margin:0 2px;}
.pix4 {margin:0 1px;}
.pix5 {margin:0 1px;}

.pix2Ombre {top:-5px; margin:0; margin-left:3px; margin-right:7px;}
.pix3Ombre {top:-5px; margin:0; margin-left:2px; margin-right:6px;}
.pix4Ombre {top:-5px; margin:0; margin-left:1px; margin-right:5px;}
.pix5Ombre {top:-5px; margin:0; margin-left:1px; margin-right:5px;}

.pix1Gradient { opacity:0.5;filter:alpha(opacity=50); }
.pix2Gradient { opacity:0.6;filter:alpha(opacity=60); }
.pix3Gradient { opacity:0.7;filter:alpha(opacity=70); }
.pix4Gradient { opacity:0.8;filter:alpha(opacity=80); }
.pix5Gradient { opacity:0.9;filter:alpha(opacity=90); }

.boiteTxt {
	padding-right:4px;
	margin-left:-5px;
	position:relative;
	bottom:5px;
}
<?php
	}
	if ($is_pic_round_box || $is_config_theme_page) {
		$my_site_base_url = substr($_SERVER['REQUEST_URI'], 0, strrpos($_SERVER['REQUEST_URI'], "angle.css.php"));
		$my_site_base_url = str_replace("css/", "", $my_site_base_url);
		
		for ($i=1; $i <= NB_DEFINE_STYLE_BCK; $i++) {
			if (constant("DEFINE_STYLE_BCK_PICTURE_".$i) != "" || $is_config_theme_page) {
?>
#top<?php echo $i; ?> {
	margin-left:-7px;
	padding:0;
	height:28px;
	text-align:left;
	background:<?php echo constant("DEFINE_STYLE_BCK_".$i."_HEADER"); ?> url('<?php echo $my_site_base_url.constant("DEFINE_STYLE_BCK_PICTURE_".$i); ?>') no-repeat top right;
}
#top<?php echo $i; ?> div {
	height:7px;
	width:7px;
	background:<?php echo constant("DEFINE_STYLE_BCK_".$i."_HEADER"); ?> url('<?php echo $my_site_base_url.constant("DEFINE_STYLE_BCK_PICTURE_".$i); ?>') no-repeat top left;
}
#left<?php echo $i; ?> {
	margin:auto;
	background:<?php echo constant("DEFINE_STYLE_BCK_".$i."_HEADER"); ?> url('<?php echo $my_site_base_url.constant("DEFINE_STYLE_BCK_PICTURE_".$i); ?>') no-repeat bottom left;
	max-width:2007px;
	color: <?php echo constant("DEFINE_STYLE_COLOR_".$i."_HEADER"); ?>;
}
#right<?php echo $i; ?> {
	margin-left:7px;
	background:<?php echo constant("DEFINE_STYLE_BCK_".$i."_HEADER"); ?> url('<?php echo $my_site_base_url.constant("DEFINE_STYLE_BCK_PICTURE_".$i); ?>') repeat bottom right;
	padding-bottom:10px;
}
<?php
			}
		} 
	} 
?>