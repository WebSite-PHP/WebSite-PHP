<?php 
	header("Content-type: text/css");
  
  $zlib_OC_is_set = eregi('On|(^[0-9]+$)', ini_get('zlib.output_compression'));
  if (!$zlib_OC_is_set) { ini_set('zlib.output_compression','On'); }
	$zlib_OC_is_set = eregi('On|(^[0-9]+$)', ini_get('zlib.output_compression'));
	if ($zlib_OC_is_set) { header("Content-Encoding: gzip"); }
	
	$expires = 60*60*24; // 24 hours
	header("Pragma: public");
	header("Cache-Control: maxage=".$expires);
	header('Expires: ' . gmdate('D, d M Y H:i:s', time()+$expires) . ' GMT');
  
	include("../config/config_css.inc.php"); 
	include("../config/config.inc.php"); 
	
	if (DEFINE_STYLE_BCK_PICTURE_MAIN == "" || DEFINE_STYLE_BCK_PICTURE_SECOND == "" || $is_config_theme_page) {
		if (DEFINE_STYLE_BCK_PICTURE_MAIN == "" || $is_config_theme_page) {
?>
/* définition des pixels d'angles */
.AngleRondMain {
	display:block;
	overflow:hidden;
	height:1px;
	border-left:1px solid <?php echo DEFINE_STYLE_BORDER_TABLE_MAIN; ?>;
	border-right:1px solid <?php echo DEFINE_STYLE_BORDER_TABLE_MAIN; ?>;
	background:<?php echo DEFINE_STYLE_BCK_MAIN_HEADER; ?>;
}

.AngleRondMainOmbre {
	position:relative;
	display:block;
	overflow:hidden;
	height:1px;
	border-left:1px solid <?php echo DEFINE_STYLE_BORDER_TABLE_MAIN; ?>;
	border-right:1px solid <?php echo DEFINE_STYLE_BORDER_TABLE_MAIN; ?>;
	background:<?php echo DEFINE_STYLE_BCK_MAIN_HEADER; ?>;
}

.pix1Main {margin:0 5px; background:<?php echo DEFINE_STYLE_BORDER_TABLE_MAIN; ?>;}

.pix1MainOmbre {top:-5px; margin:0; margin-left:5px; margin-right:9px; background:<?php echo DEFINE_STYLE_BORDER_TABLE_MAIN; ?>;}


<?php 
		}
		if (DEFINE_STYLE_BCK_PICTURE_SECOND == "" || $is_config_theme_page) {
?>

.AngleRondSecond {
	display:block;
	overflow:hidden;
	height:1px;
	border-left:1px solid <?php echo DEFINE_STYLE_BORDER_TABLE_SECOND; ?>;
	border-right:1px solid <?php echo DEFINE_STYLE_BORDER_TABLE_SECOND; ?>;
	background:<?php echo DEFINE_STYLE_BCK_SECOND_HEADER; ?>;
}

.AngleRondSecondOmbre {
	position:relative;
	display:block;
	height:1px;
	border-left:1px solid <?php echo DEFINE_STYLE_BORDER_TABLE_SECOND; ?>;
	border-right:1px solid <?php echo DEFINE_STYLE_BORDER_TABLE_SECOND; ?>;
	background:<?php echo DEFINE_STYLE_BCK_SECOND_HEADER; ?>;
}

.pix1Second {margin:0 5px; background:<?php echo DEFINE_STYLE_BORDER_TABLE_SECOND; ?>;}

.pix1SecondOmbre {top:-5px; margin:0; margin-left:5px; margin-right:9px; background:<?php echo DEFINE_STYLE_BORDER_TABLE_SECOND; ?>;}


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

<?php
		} 
?>

.ombre {
  background-color: <?php echo DEFINE_STYLE_OMBRE_COLOR; ?>;
  padding: 0px;
  margin-left:5px;
  clear:left;
}

.boiteTxt {
	padding-right:4px;
	margin-left:-5px;
	position:relative;
	bottom:5px;
}
<?php
	}
	if (DEFINE_STYLE_BCK_PICTURE_MAIN != "" || DEFINE_STYLE_BCK_PICTURE_SECOND != "" || $is_config_theme_page) {
		$my_site_base_url = substr($_SERVER['REQUEST_URI'], 0, strrpos($_SERVER['REQUEST_URI'], "angle.css.php"));
		$my_site_base_url = str_replace("css/", "", $my_site_base_url);
?>
#topMain {
	margin-left:-7px;
	padding:0;
	height:28px;
	text-align:left;
	background:<?php echo DEFINE_STYLE_BCK_MAIN_HEADER; ?> url('<?php echo $my_site_base_url.DEFINE_STYLE_BCK_PICTURE_MAIN; ?>') no-repeat top right;
}
#topMain div {
	height:7px;
	width:7px;
	background:<?php echo DEFINE_STYLE_BCK_MAIN_HEADER; ?> url('<?php echo $my_site_base_url.DEFINE_STYLE_BCK_PICTURE_MAIN; ?>') no-repeat top left;
}
#leftMain {
	margin:auto;
	background:<?php echo DEFINE_STYLE_BCK_MAIN_HEADER; ?> url('<?php echo $my_site_base_url.DEFINE_STYLE_BCK_PICTURE_MAIN; ?>') no-repeat bottom left;
	max-width:2007px;
	color: <?php echo DEFINE_STYLE_COLOR_MAIN_HEADER; ?>;
}
#rightMain {
	margin-left:7px;
	background:<?php echo DEFINE_STYLE_BCK_MAIN_HEADER; ?> url('<?php echo $my_site_base_url.DEFINE_STYLE_BCK_PICTURE_MAIN; ?>') repeat bottom right;
	padding-bottom:10px;
}

#topSecond {
	margin-left:-7px;
	padding:0;
	height:28px;
	text-align:left;
	background:<?php echo DEFINE_STYLE_BCK_SECOND_HEADER; ?> url('<?php echo $my_site_base_url.DEFINE_STYLE_BCK_PICTURE_SECOND; ?>') no-repeat top right;
}
#topSecond div {
	height:7px;
	width:7px;
	background:<?php echo DEFINE_STYLE_BCK_SECOND_HEADER; ?> url('<?php echo $my_site_base_url.DEFINE_STYLE_BCK_PICTURE_SECOND; ?>') no-repeat top left;
}
#leftSecond {
	margin:auto;
	background:<?php echo DEFINE_STYLE_BCK_SECOND_HEADER; ?> url('<?php echo $my_site_base_url.DEFINE_STYLE_BCK_PICTURE_SECOND; ?>') no-repeat bottom left;
	max-width:2007px;
	color: <?php echo DEFINE_STYLE_COLOR_SECOND_HEADER; ?>;
}
#rightSecond {
	margin-left:7px;
	background:<?php echo DEFINE_STYLE_BCK_SECOND_HEADER; ?> url('<?php echo $my_site_base_url.DEFINE_STYLE_BCK_PICTURE_SECOND; ?>') repeat bottom right;
	padding-bottom:10px;
}
<?php
	} 
?>