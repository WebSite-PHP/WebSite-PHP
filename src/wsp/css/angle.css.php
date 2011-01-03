<?php 
	header("Content-type: text/css");
  
	$zlib_OC_is_set = preg_match('/On|(^[0-9]+$)/i', ini_get('zlib.output_compression'));
	if ($zlib_OC_is_set) { header("Content-Encoding: gzip"); }
	
	$expires = 60*60*24; // 24 hours
	header("Pragma: public");
	header("Cache-Control: maxage=".$expires);
	header('Expires: ' . gmdate('D, d M Y H:i:s', time()+$expires) . ' GMT');
  
	include("../config/config_css.inc.php"); 
	include("../config/config.inc.php"); 
	
	$is_css_round_box = false;
	$is_pic_round_box = false;
	for ($i=1; $i <= NB_DEFINE_STYLE_BCK; $i++) { 
		if (constant("DEFINE_STYLE_BCK_PICTURE_".$i) == "") {
			$is_css_round_box = true;
		} else {
			$is_pic_round_box = true;
		}
	}
	
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