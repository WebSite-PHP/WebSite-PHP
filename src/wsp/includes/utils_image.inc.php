<?php
/**
 * PHP file wsp\includes\utils_image.inc.php
 */
/**
 * WebSite-PHP file utils_image.inc.php
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2015 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 12/05/2015
 * @version     1.2.13
 * @access      public
 * @since       1.0.19
 */

	function gif2jpeg($InFile, $OutFile='', $bgcolor=false) {
		list($wd, $ht, $tp, $at)=getimagesize($InFile);
		$img_src=imagecreatefromgif($InFile);
		$img_dst=imagecreatetruecolor($wd,$ht);
		$rgb = array();
		$rgb['red']=255;
		$rgb['green']=255;
		$rgb['blue']=255;
		if (is_array($bgcolor)) $rgb=$bgcolor;
		$kek=imagecolorallocate($img_dst,$rgb['red'],$rgb['green'],$rgb['blue']);
		imagefill($img_dst,0,0,$kek);
		imagecopyresampled($img_dst, $img_src, 0, 0, 0, 0, $wd, $ht, $wd, $ht);
		imagedestroy($img_src);
		  
		$draw=true;
		if (strlen($OutFile)>0) {
			if ($hnd=fopen($OutFile,'w')) {
				$draw=false;
				fclose($hnd);
			}
		}
		if (true==$draw) {
			header("Content-type: image/jpeg");
			imagejpeg($img_dst);
		} else {
			imagejpeg($img_dst, $OutFile);
		}
		imagedestroy($img_dst);
	}
	
	function png2jpeg($InFile, $OutFile='', $bgcolor=false) {
		list($wd, $ht, $tp, $at)=getimagesize($InFile);
		$img_src=imagecreatefrompng($InFile);
		$img_dst=imagecreatetruecolor($wd,$ht);
		$rgb = array();
		$rgb['red']=255;
		$rgb['green']=255;
		$rgb['blue']=255;
		if (is_array($bgcolor)) $rgb=$bgcolor;
		$kek=imagecolorallocate($img_dst,$rgb['red'],$rgb['green'],$rgb['blue']);
		imagefill($img_dst,0,0,$kek);
		imagecopyresampled($img_dst, $img_src, 0, 0, 0, 0, $wd, $ht, $wd, $ht);
		imagedestroy($img_src);
		
		$draw=true;
		if (strlen($OutFile)>0) {
			if ($hnd=fopen($OutFile,'w')) {
				$draw=false;
				fclose($hnd);
			}
		}
		if (true==$draw) {
			header("Content-type: image/jpeg");
			imagejpeg($img_dst);
		} else {
			imagejpeg($img_dst, $OutFile);
		}
		imagedestroy($img_dst);
	}
	
	function gif2png($InFile, $OutFile='', $bgcolor=false) {
		list($wd, $ht, $tp, $at)=getimagesize($InFile);
		$img_src=imagecreatefromgif($InFile);
		$img_dst=imagecreatetruecolor($wd,$ht);
		if ($bgcolor != false) {
			$rgb = array();
			$rgb['red']=255;
			$rgb['green']=255;
			$rgb['blue']=255;
			if (is_array($bgcolor)) $rgb=$bgcolor;
			$kek=imagecolorallocate($img_dst,$rgb['red'],$rgb['green'],$rgb['blue']);
			imagefill($img_dst,0,0,$kek);
		} else {
			imagecolortransparent($img_dst, imagecolorallocate($img_dst, 0, 0, 0));
		}
		imagecopyresampled($img_dst, $img_src, 0, 0, 0, 0, $wd, $ht, $wd, $ht);
		imagedestroy($img_src);
		
		$draw=true;
		if (strlen($OutFile)>0) {
			if ($hnd=fopen($OutFile,'w')) {
				$draw=false;
				fclose($hnd);
			}
		}
		if (true==$draw) {
			header("Content-type: image/png");
			imagepng($img_dst);
		} else {
			imagepng($img_dst, $OutFile);
		}
		imagedestroy($img_dst);
	}
	
	function jpeg2png($InFile, $OutFile='', $bgcolor=false) {
		list($wd, $ht, $tp, $at)=getimagesize($InFile);
		$img_src=imagecreatefromjpeg($InFile);
		$img_dst=imagecreatetruecolor($wd,$ht);
		if ($bgcolor != false) {
			$rgb = array();
			$rgb['red']=255;
			$rgb['green']=255;
			$rgb['blue']=255;
			if (is_array($bgcolor)) $rgb=$bgcolor;
			$kek=imagecolorallocate($img_dst,$rgb['red'],$rgb['green'],$rgb['blue']);
			imagefill($img_dst,0,0,$kek);
		} else {
			imagecolortransparent($img_dst, imagecolorallocate($img_dst, 0, 0, 0));
		}
		imagecopyresampled($img_dst, $img_src, 0, 0, 0, 0, $wd, $ht, $wd, $ht);
		imagedestroy($img_src);
		
		$draw=true;
		if (strlen($OutFile)>0) {
			if ($hnd=fopen($OutFile,'w')) {
				$draw=false;
				fclose($hnd);
			}
		}
		if (true==$draw) {
			header("Content-type: image/png");
			imagepng($img_dst);
		} else {
			imagepng($img_dst, $OutFile);
		}
		imagedestroy($img_dst);
	}

	function jpegReduction($InFile, $OutFile, $Width) {
		$dim=getimagesize($InFile);
		$image = ImageCreateFromJPEG($InFile);
		$pixmaxi=$Width; //on fixe ici la taille maximum souhaitée.
	
		$haut=$dim[1];
		$larg=$dim[0];
	
		$reduire=$pixmaxi/$larg;
		$larg2=$pixmaxi;
		$haut2=round($haut*$reduire);
	
		$thumb = ImageCreateTrueColor($larg2,$haut2);
		ImageCopyreSampled($thumb, $image, 0, 0, 0, 0,$larg2, $haut2, $larg, $haut);
	
		if (file_exists($OutFile)) {
			unlink($OutFile);
		}
		touch($OutFile);
		ImageJpeg($thumb, $OutFile);
	}
	
	function jpegReductionHeight($InFile, $OutFile, $Height) {
		$dim=getimagesize($InFile);
		$image = ImageCreateFromJPEG($InFile);
		$pixmaxi=$Height; //on fixe ici la taille maximum souhaitée.
	
		$haut=$dim[1];
		$larg=$dim[0];
		
		$reduire=$pixmaxi/$haut;
		$larg2=round($larg*$reduire);
		$haut2=$pixmaxi;
	
		$thumb = ImageCreateTrueColor($larg2,$haut2);
		ImageCopyreSampled($thumb, $image, 0, 0, 0, 0,$larg2, $haut2, $larg, $haut);
	
		if (file_exists($OutFile)) {
			unlink($OutFile);
		}
		touch($OutFile);
		ImageJpeg($thumb, $OutFile);
	}
	
	function jpegReductionFixe($InFile, $OutFile, $Width, $Height, $bgcolor=false) {
		$dim=getimagesize($InFile);
		$image = ImageCreateFromJPEG($InFile);
		
		$haut=$dim[1];
		$larg=$dim[0];
	
		$diffHeight=0;
		$diffWidth=0;
		if ($larg > $haut) {
			$reduire=$Width/$larg;
			$larg2=$Width;
			$haut2=round($haut*$reduire);
			$diffHeight=($Height-$haut2)/2;
		} else {
			$reduire=$Height/$haut;
			$larg2=round($larg*$reduire);
			$haut2=$Height;
			$diffWidth=($Width-$larg2)/2;
		}
	
		$thumb = ImageCreateTrueColor($Width, $Height);
		$rgb = array();
		$rgb['red']=255;
		$rgb['green']=255;
		$rgb['blue']=255;
		if (is_array($bgcolor)) $rgb=$bgcolor;
		$kek=imagecolorallocate($thumb,$rgb['red'],$rgb['green'],$rgb['blue']);
		imagefill($thumb,0,0,$kek);
	  	ImageCopyreSampled($thumb, $image, $diffWidth, $diffHeight, 0, 0, $larg2, $haut2, $larg, $haut);
		imagedestroy($image);
	
		if (file_exists($OutFile)) {
			unlink($OutFile);
		}
		touch($OutFile);
		ImageJpeg($thumb, $OutFile);
	  	imagedestroy($thumb);
	}
	
	
	function pngReduction($InFile, $OutFile, $Width) {
		$dim=getimagesize($InFile);
		$image = imagecreatefrompng($InFile);
		$pixmaxi=$Width; //on fixe ici la taille maximum souhaitée.
	
		$haut=$dim[1];
		$larg=$dim[0];
	
		$reduire=$pixmaxi/$larg;
		$larg2=$pixmaxi;
		$haut2=round($haut*$reduire);
	
		$thumb = ImageCreateTrueColor($larg2,$haut2);
		ImageCopyreSampled($thumb, $image, 0, 0, 0, 0,$larg2, $haut2, $larg, $haut);
	
		if (file_exists($OutFile)) {
			unlink($OutFile);
		}
		touch($OutFile);
		imagepng($thumb, $OutFile);
	}
	
	function pngReductionHeight($InFile, $OutFile, $Height) {
		$dim=getimagesize($InFile);
		$image = imagecreatefrompng($InFile);
		$pixmaxi=$Height; //on fixe ici la taille maximum souhaitée.
	
		$haut=$dim[1];
		$larg=$dim[0];
		
		$reduire=$pixmaxi/$haut;
		$larg2=round($larg*$reduire);
		$haut2=$pixmaxi;
	
		$thumb = ImageCreateTrueColor($larg2,$haut2);
		ImageCopyreSampled($thumb, $image, 0, 0, 0, 0,$larg2, $haut2, $larg, $haut);
	
		if (file_exists($OutFile)) {
			unlink($OutFile);
		}
		touch($OutFile);
		imagepng($thumb, $OutFile);
	}
	
	function pngReductionFixe($InFile, $OutFile, $Width, $Height, $bgcolor=false) {
		$dim=getimagesize($InFile);
		$image = imagecreatefrompng($InFile);
		
		$haut=$dim[1];
		$larg=$dim[0];
	
		$diffHeight=0;
		$diffWidth=0;
		if ($larg > $haut) {
			$reduire=$Width/$larg;
			$larg2=$Width;
			$haut2=round($haut*$reduire);
			$diffHeight=($Height-$haut2)/2;
		} else {
			$reduire=$Height/$haut;
			$larg2=round($larg*$reduire);
			$haut2=$Height;
			$diffWidth=($Width-$larg2)/2;
		}
	
		$thumb = ImageCreateTrueColor($Width, $Height);
		if ($bgcolor != false) {
			$rgb = array();
			$rgb['red']=255;
			$rgb['green']=255;
			$rgb['blue']=255;
			if (is_array($bgcolor)) $rgb=$bgcolor;
			$kek=imagecolorallocate($thumb,$rgb['red'],$rgb['green'],$rgb['blue']);
			imagefill($thumb,0,0,$kek);
		} else {
			imagecolortransparent($thumb, imagecolorallocate($thumb, 0, 0, 0));
		}
		ImageCopyreSampled($thumb, $image, $diffWidth, $diffHeight, 0, 0, $larg2, $haut2, $larg, $haut);
	  	imagedestroy($image);
		
		if (file_exists($OutFile)) {
			unlink($OutFile);
		}
		touch($OutFile);
		imagepng($thumb, $OutFile);
	  	imagedestroy($thumb);
	}
	
	function makePngColorTransparentBackground($InFile, $OutFile, $bgcolor=array('red'=>255, 'green'=>255, 'blue'=>255)) {
		$dim=getimagesize($InFile);
		$haut=$dim[1];
		$larg=$dim[0];
		
		$image_source = imagecreatefrompng($InFile); 
		
		$transparencyIndex = imagecolortransparent($image_source); 
		$bgcolor = array('red' => 255, 'green' => 255, 'blue' => 255); 
             
		if ($bgcolor >= 0) { 
			$bgcolor = imagecolorsforindex($image_source, $transparencyIndex);    
		}
            
		$transparencyIndex = imagecolorallocate($image_source, $bgcolor['red'], $bgcolor['green'], $bgcolor['blue']); 
		imagefill($image_source, 0, 0, $transparencyIndex); 
		imagecolortransparent($image_source, $transparencyIndex);
		
		if (file_exists($OutFile)) {
			unlink($OutFile);
		}
		touch($OutFile);
		imagepng($image_source, $OutFile);
		imagedestroy($image_source);
	}
	
	function makePngIphoneIcon($InFile, $OutFile, $Width=100, $Height=100) {
		$dim=getimagesize($InFile);
		$haut=$dim[1];
		$larg=$dim[0];
		
		if ($haut != 100 && $larg != 100) {
			pngReductionFixe($InFile, $OutFile, 100, 100, true);
			$InFile = $OutFile;
		}
		
	   // Load the image where the logo will be embeded into
	   $image = imagecreatefrompng($InFile);
	
	   // Load the overlay image
	   $overlayImage = imagecreatefrompng(dirname(__FILE__)."/../img/mask_icon_iphone.png");
	   //imagealphablending($overlayImage, true);
	
	   // Get dimensions
	   $imageWidth=imagesx($image);
	   $imageHeight=imagesy($image);
	
	   $overlayImageWidth=imagesx($overlayImage);
	   $overlayImageHeight=imagesy($overlayImage);	 
		
	   imagelayereffect($overlayImage, IMG_EFFECT_OVERLAY);
	
	    // Paste the logo
	    imagecopy(
	        // destination
	        $overlayImage,
	        // source
	        $image,
	        // destination x and y, centered
	         ($overlayImageWidth-$imageWidth)/2, ($overlayImageHeight-$imageHeight)/2,
	        // source x and y
	        0, 0,
	        // width and height of the area of the source to copy
	        $imageWidth, $imageHeight);
		
        if ($Width != 100 && $Height != 100) {
	        $diffHeight=0;
			$diffWidth=0;
			if ($imageWidth > $imageHeight) {
				$reduire=$Width/$imageWidth;
				$larg2=$Width;
				$haut2=round($imageHeight*$reduire);
				$diffHeight=($Height-$haut2)/2;
			} else {
				$reduire=$Height/$imageHeight;
				$larg2=round($imageWidth*$reduire);
				$haut2=$Height;
				$diffWidth=($Width-$larg2)/2;
			}
        	ImageCopyreSampled($overlayImage, $overlayImage, $diffWidth, $diffHeight, 0, 0, $larg2, $haut2, $imageWidth, $imageHeight);
        }
        
	   	if (file_exists($OutFile)) {
			unlink($OutFile);
		}
		touch($OutFile);
		imagepng($overlayImage, $OutFile);
	
	   // Release memory
	   imageDestroy($image);
	   imageDestroy($overlayImage);
	   
	   makePngColorTransparentBackground($OutFile, $OutFile, array('red'=>255, 'green'=>0, 'blue'=>255));
	}
	
	function makeImageTransparent($InFile, $OutFile, $tranparentPercent=50) {
		$info = GetImageSize($InFile);
		$width = $info[0];
		$height = $info[1];
		
		$mime = $info['mime'];
		
		// What sort of image?
		
		$type = substr(strrchr($mime, '/'), 1);
		
		switch ($type)
		{
		case 'jpeg':
		    $image_create_func = 'ImageCreateFromJPEG';
		    $image_save_func = 'ImageJPEG';
			$new_image_ext = 'jpg';
		    break;
		
		case 'png':
		    $image_create_func = 'ImageCreateFromPNG';
		    $image_save_func = 'ImagePNG';
			$new_image_ext = 'png';
		    break;
		
		case 'bmp':
		    $image_create_func = 'ImageCreateFromBMP';
		    $image_save_func = 'ImageBMP';
			$new_image_ext = 'bmp';
		    break;
		
		case 'gif':
		    $image_create_func = 'ImageCreateFromGIF';
		    $image_save_func = 'ImageGIF';
			$new_image_ext = 'gif';
		    break;
		
		case 'vnd.wap.wbmp':
		    $image_create_func = 'ImageCreateFromWBMP';
		    $image_save_func = 'ImageWBMP';
			$new_image_ext = 'bmp';
		    break;
		
		case 'xbm':
		    $image_create_func = 'ImageCreateFromXBM';
		    $image_save_func = 'ImageXBM';
			$new_image_ext = 'xbm';
		    break;
		
		default:
			$image_create_func = 'ImageCreateFromJPEG';
		    $image_save_func = 'ImageJPEG';
			$new_image_ext = 'jpg';
		}
		
		// Source Image
		$image = $image_create_func($InFile);
		
		$new_image = ImageCreateTruecolor($width, $height);
		
		// Set a White & Transparent Background Color
		$bg = ImageColorAllocateAlpha($new_image, 255, 255, 255, 127); // (PHP 4 >= 4.3.2, PHP 5)
		ImageFill($new_image, 0, 0 , $bg);
		
		// Copy and merge
		ImageCopyMerge($new_image, $image, 0, 0, 0, 0, $width, $height, $tranparentPercent);
		
		// Save image 
		$image_save_func($new_image, $OutFile) or die("There was a problem in saving the new file.");
	  	imagedestroy($new_image);
	}
	
	function gradientColorGenerator($startcol,$endcol,$graduations=10) {
		$graduations--;
        if ($endcol == null) {
            $r = hexdec("FF")-(hexdec(substr($endcol,0,2))/$graduations);
            $g = hexdec("FF")-(hexdec(substr($endcol,2,2))/$graduations);
            $b = hexdec("FF")-(hexdec(substr($endcol,4,2))/$graduations);
            $endcol = $startcol;
            $startcol = dechex(intval($r)).dechex(intval($g)).dechex(intval($b));
        }
	 
		$startcoln['r'] = hexdec(substr($startcol,0,2));
		$startcoln['g'] = hexdec(substr($startcol,2,2));
		$startcoln['b'] = hexdec(substr($startcol,4,2));
	 
		$GSize['r'] = (hexdec(substr($endcol,0,2))-$startcoln['r'])/$graduations; //Graduation Size Red
		$GSize['g'] = (hexdec(substr($endcol,2,2))-$startcoln['g'])/$graduations;
		$GSize['b'] = (hexdec(substr($endcol,4,2))-$startcoln['b'])/$graduations;
	 
		for($i=0;$i<=$graduations;$i++)
			{
			$HexR = dechex(intval($startcoln['r']+($GSize['r']*$i)));
			$HexG = dechex(intval($startcoln['g']+($GSize['g']*$i)));
			$HexB = dechex(intval($startcoln['b']+($GSize['b']*$i)));
	 
			//Make HTML Happy
			if (strlen($HexR)==1) $HexR = "0$HexR";
			if (strlen($HexG)==1) $HexG = "0$HexG";
			if (strlen($HexB)==1) $HexB = "0$HexB";
			$HexCol[] = "$HexR$HexG$HexB";
		}
		
		return $HexCol;
	}

    function isDarkHexaColor($hex) {
        $hex = str_replace('#', '', $hex);

        $c_r = hexdec(substr($hex, 0, 2));
        $c_g = hexdec(substr($hex, 2, 2));
        $c_b = hexdec(substr($hex, 4, 2));

        $brightness = (($c_r * 299) + ($c_g * 587) + ($c_b * 114)) / 1000;
        return $brightness > 175;
    }

	function jpegRotate($InFile, $OutFile, $degrees) {
		$image = ImageCreateFromJPEG($InFile);
		$rotate = imagerotate($image, $degrees, 0);
	
		if (file_exists($OutFile)) {
			unlink($OutFile);
		}
		touch($OutFile);
		ImageJpeg($rotate, $OutFile);

		imagedestroy($image);
		imagedestroy($rotate);
	}
?>
