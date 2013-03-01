<?php
/**
 * PHP file wsp\class\modules\PDF\info\tutoriel\makefont.php
 */
/**
 * Class 
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2013 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 18/02/2013
 * @version     1.2.2
 * @access      public
 * @since       1.2.0
 */

//Génération du fichier de définition de police pour le tutoriel 7
require('../font/makefont/makefont.php');

MakeFont('calligra.ttf','calligra.afm');
?>
