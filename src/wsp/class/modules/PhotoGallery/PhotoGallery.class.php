<?php 
/**
 * PHP file wsp\class\modules\PhotoGallery\PhotoGallery.class.php
 * @package modules
 * @subpackage PhotoGallery
 */
/**
 * Class PhotoGallery
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2015 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package modules
 * @subpackage PhotoGallery
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 12/05/2015
 * @version     1.2.13
 * @access      public
 * @since       1.1.9
 */

class PhotoGallery extends WebSitePhpObject {
	/**#@+
	* @access private
	*/
	private $path = "";
	private $original_path = "";
	private $picture_ext = array();
	private $folder_pic = "wsp/img/folder_image_128x128.png";
	private $thumbnail_folder = "";
	private $subfolder = true;
	private $nb_col = 4;
	/**#@-*/
	
	/**
	 * Constructor PhotoGallery
	 * @param mixed $path 
	 * @param string $picture_ext [default value: jpg,jpeg,png,gif]
	 * @param string $folder_pic [default value: wsp/img/folder_image_128x128.png]
	 */
	function __construct($path, $picture_ext='jpg,jpeg,png,gif', $folder_pic='wsp/img/folder_image_128x128.png') {
		parent::__construct();
		
		if (!isset($path)) {
			throw new NewException("1 argument for ".get_class($this)."::__construct() is mandatory", 0, getDebugBacktrace(1));
		}
		$this->original_path = $path;
		if (isset($_GET['gallery_event'])) {
			$path = $path.$_GET['gallery_event'];
		}
		if (!is_dir($path)) {
			throw new NewException("Unable to find the path ".$path, 0, getDebugBacktrace(1));
		}
		
		$this->path = $path;
		$this->picture_ext = explode(',', $picture_ext);
		$this->folder_pic = $folder_pic;
		
		$this->addCss(BASE_URL."wsp/css/jquery.lightbox-0.5.css", "", true);
		$this->addCss(BASE_URL."wsp/css/jquery.dataTables.css", "", true);
		$this->addJavaScript(BASE_URL."wsp/js/jquery.lightbox-0.5.min.js", "", true);
		$this->addJavaScript(BASE_URL."wsp/js/jquery.dataTables.min.js", "", true);
	}
	
	/**
	 * Method setPictureExt
	 * @access public
	 * @param mixed $picture_ext 
	 * @return PhotoGallery
	 * @since 1.1.9
	 */
	public function setPictureExt($picture_ext) {
		$this->picture_ext = explode(',', $picture_ext);
		return $this;
	}
	
	/**
	 * Method setFolderPic
	 * @access public
	 * @param mixed $folder_pic 
	 * @return PhotoGallery
	 * @since 1.1.9
	 */
	public function setFolderPic($folder_pic) {
		$this->folder_pic = $folder_pic;
		return $this;
	}
	
	/**
	 * Method setThumbnailFolder
	 * @access public
	 * @param mixed $thumbnail_folder 
	 * @return PhotoGallery
	 * @since 1.1.9
	 */
	public function setThumbnailFolder($thumbnail_folder) {
		$this->thumbnail_folder = $thumbnail_folder;
		return $this;
	}

	/**
	 * Method disableSubFolder
	 * @access public
	 * @return PhotoGallery
	 * @since 1.2.3
	 */
	public function disableSubFolder() {
		$this->subfolder = false;
		return $this;
	}
	
	/**
	 * Method setTableNbColumns
	 * @access public
	 * @param mixed $nb_columns 
	 * @return PhotoGallery
	 * @since 1.2.3
	 */
	public function setTableNbColumns($nb_columns) {
		$this->nb_col = $nb_columns;
		return $this;
	}
	
	/**
	 * Method render
	 * @access public
	 * @param boolean $ajax_render [default value: false]
	 * @return mixed
	 * @since 1.1.9
	 */
	public function render($ajax_render=false) {
		$gallery_table = new Table();
		$gallery_table->setId("PhotoGalleryTable".rand(0, 999999))->activatePagination();
		$header = new RowTable();
		for ($i=0; $i < $this->nb_col; $i++) {
			$header->add();
		}
        $gallery_table->addRow($header->setHeaderClass(0));
        
		$ind = 0;
		$last_ind = -1;
		$gallery_row = null;
		$files = scandir($this->path, 1);
		for($i=0; $i < sizeof($files); $i++) {
			$file = $files[$i];
			if (($file != ".") && ($file != "..")) {
				$getExt = explode(".", $file); 
				$countExt = count($getExt); 
				$fExt = $countExt - 1; 
				$myExt = $getExt[$fExt]; 
				             
				if ((is_dir($this->path.$file) || $this->in_arrayi($myExt, $this->picture_ext)) && $file != $this->thumbnail_folder) {
					if ($ind != $last_ind && $ind % $this->nb_col == 0) {
						if ($gallery_row != null) {
							$gallery_table->addRow($gallery_row);
						}
						$gallery_row = new RowTable();
						$gallery_row->setWidth("25%");
						$last_ind = $ind;
					}
					if (is_dir($this->path.$file)) {
						if ($this->subfolder) {
							$folder_pic = new Picture($this->folder_pic, 128, 128, 0, Picture::ALIGN_ABSMIDDLE, $file);
							$url = $this->getPage()->getCurrentURL();
							if (($pos = find($url, "gallery_event=")) > 0) {
								$pos2 = find($url, "&", 0, $pos);
								if ($pos2 == 0) {
									$url = substr($url, 0, $pos-1);
								} else {
									$url1 = substr($url, 0, $pos-1);
									$url2 = substr($url, $pos2, strlen($url));
									$url = $url1.$url2;
								}
							}
							if (find($url, "?") > 0) {
								$url = $url."&";
							} else {
								$url = $url."?";
							}
							$url = $url."gallery_event=".urlencode(str_replace($this->original_path, "", $this->path.$file));
							$folder_link = new Link($url, Link::TARGET_NONE, new Object($folder_pic, "<br/>", $file));
							$gallery_row->add($folder_link);
							$ind++;
						}
					} else {
						if ($this->in_arrayi($myExt, $this->picture_ext)) {
							$pic_file = str_replace(str_replace("\\", "/", realpath(SITE_DIRECTORY))."/", "", str_replace("\\", "/", realpath($this->path))."/".$file);
							$pic_file_lower_ext = str_replace(".".$myExt, strtolower(".".$myExt), $pic_file);
							if ($pic_file_lower_ext != $pic_file) {
								$path_file_lower_ext = str_replace($pic_file, $pic_file_lower_ext, str_replace("\\", "/", realpath(SITE_DIRECTORY."/".$pic_file)));
								if (!rename(realpath(SITE_DIRECTORY."/".$pic_file), $path_file_lower_ext)) {
									$pic_file_lower_ext = $pic_file;
								}
							}
							$pic_name = str_replace(".".$myExt, "", $file);
							
							$pic_thumbnail = $pic_file_lower_ext;
							if (trim($this->thumbnail_folder) != "") {
								if (in_array(strtolower($myExt), array("jpg", "jpeg", "gif", "png"))) {
									if (!is_dir(realpath($this->path)."/".$this->thumbnail_folder)) {
										mkdir(realpath($this->path)."/".$this->thumbnail_folder);
									}
									$pic_thumbnail_path = realpath($this->path."/".$this->thumbnail_folder)."/".str_replace(".".$myExt, strtolower(".".$myExt), $file);
									$pic_thumbnail = str_replace(str_replace("\\", "/", realpath(SITE_DIRECTORY))."/", "", str_replace("\\", "/", realpath($this->path."/".$this->thumbnail_folder))."/".str_replace(".".$myExt, strtolower(".".$myExt), $file));
									if (strtolower($myExt) == "gif") { // convert to jpg
										$pic_thumbnail_path = str_replace(".gif", ".jpg", $pic_thumbnail_path);
										$pic_thumbnail = str_replace(".gif", ".jpg", $pic_thumbnail);
									}
									if (!file_exists($pic_thumbnail_path)) {
										if (strtolower($myExt) == "jpg" || strtolower($myExt) == "jpeg") {
											jpegReductionFixe($pic_file_lower_ext, $pic_thumbnail_path, 128, 128);
										} else if (strtolower($myExt) == "png") {
											pngReductionFixe($pic_file_lower_ext, $pic_thumbnail_path, 128, 128);
										} else {
											$tmp_file = realpath($this->path."/".$this->thumbnail_folder)."/temp.jpg";
											gif2jpeg($pic_file_lower_ext, $tmp_file);
											jpegReductionFixe($tmp_file, $pic_thumbnail_path, 128, 128);
											unlink($tmp_file);
										}
									}
								}
							}
							$pic = new Picture($pic_thumbnail, 128, 128, 0, Picture::ALIGN_ABSMIDDLE, $pic_name);
							$pic->addLightbox("Lightbox".$gallery_table->getId(), $pic_file_lower_ext, "$(window).width()-($(window).width()*0.2)", "$(window).height()-($(window).height()*0.2)");
							$gallery_row->add(new Object($pic, "<br/>", $pic_name));
							$ind++;
						}
					}
				}
			}
		}
		if ($gallery_row != null) {
			while ($ind % $this->nb_col != 0) {
				$gallery_row->add();
				$ind++;
			}
			$gallery_table->addRow($gallery_row);
		}
		
		return $gallery_table->render($ajax_render);
	}
	
	/**
	 * Method in_arrayi
	 * @access private
	 * @param mixed $needle 
	 * @param mixed $haystack 
	 * @return mixed
	 * @since 1.1.9
	 */
	private function in_arrayi($needle, $haystack) { 
        $found = false; 
        foreach( $haystack as $value ) { 
            if( strtolower( $value ) == strtolower( $needle ) ) { 
                $found = true; 
            } 
        }    
        return $found; 
    } 
}
?>
