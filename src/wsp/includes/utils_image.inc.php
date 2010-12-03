<?php
	function gif2jpeg($p_fl, $p_new_fl='', $bgcolor=false) {
	  list($wd, $ht, $tp, $at)=getimagesize($p_fl);
	  $img_src=imagecreatefromgif($p_fl);
	  $img_dst=imagecreatetruecolor($wd,$ht);
	  $clr['red']=255;
	  $clr['green']=255;
	  $clr['blue']=255;
	  if (is_array($bgcolor)) $clr=$bgcolor;
	  $kek=imagecolorallocate($img_dst,$clr['red'],$clr['green'],$clr['blue']);
	  imagefill($img_dst,0,0,$kek);
	  imagecopyresampled($img_dst, $img_src, 0, 0, 0, 0, $wd, $ht, $wd, $ht);
	  imagedestroy($img_src);
	  
	  $draw=true;
	  if (strlen($p_new_fl)>0) {
	    if ($hnd=fopen($p_new_fl,'w')) {
	      $draw=false;
	      fclose($hnd);
	    }
	  }
	  if (true==$draw) {
	    header("Content-type: image/jpeg");
	    imagejpeg($img_dst);
	  } else {
	  	imagejpeg($img_dst, $p_new_fl);
	  }
	  imagedestroy($img_dst);
	}
	
	function png2jpeg($p_fl, $p_new_fl='', $bgcolor=false) {
	  list($wd, $ht, $tp, $at)=getimagesize($p_fl);
	  $img_src=imagecreatefrompng($p_fl);
	  $img_dst=imagecreatetruecolor($wd,$ht);
	  $clr['red']=255;
	  $clr['green']=255;
	  $clr['blue']=255;
	  if (is_array($bgcolor)) $clr=$bgcolor;
	  $kek=imagecolorallocate($img_dst,$clr['red'],$clr['green'],$clr['blue']);
	  imagefill($img_dst,0,0,$kek);
	  imagecopyresampled($img_dst, $img_src, 0, 0, 0, 0, $wd, $ht, $wd, $ht);
	  imagedestroy($img_src);
	  
	  $draw=true;
	  if (strlen($p_new_fl)>0) {
	    if ($hnd=fopen($p_new_fl,'w')) {
	      $draw=false;
	      fclose($hnd);
	    }
	  }
	  if (true==$draw) {
	    header("Content-type: image/jpeg");
	    imagejpeg($img_dst);
	  } else {
	  	imagejpeg($img_dst, $p_new_fl);
	  }
	  imagedestroy($img_dst);
	}

	function reduction($InFile, $OutFile, $Width) {
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
	
	function reductionHeight($InFile, $OutFile, $Height) {
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
	
	function reductionFixe($InFile, $OutFile, $Width, $Height) {
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
		//ImageAlphaBlending($thumb, false);
		$black = imagecolorallocate($thumb,0,0,0);
		imagefill($thumb,0,0,$black);
		//imagecolortransparent($thumb,$black);
	
	  ImageCopyreSampled($thumb, $image, $diffWidth, $diffHeight, 0, 0, $larg2, $haut2, $larg, $haut);
	
		if (file_exists($OutFile)) {
			unlink($OutFile);
		}
		touch($OutFile);
		ImageJpeg($thumb, $OutFile);
	}
?>