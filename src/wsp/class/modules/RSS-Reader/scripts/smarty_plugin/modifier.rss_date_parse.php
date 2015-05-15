<?php
/**
 * PHP file wsp\class\modules\RSS-Reader\scripts\smarty_plugin\modifier.rss_date_parse.php
 */
/**
 * Class 
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
 * @since       1.1.5
 */


/*
 * Smarty plugin
 * -------------------------------------------------------------
 * Type:     modifier
 * Name:     rss_date_parse
 * Purpose:  parse rss date into unix epoch
 * Input:    string: rss date
 *			 default_date:  default date if $rss_date is empty
 *
 * NOTE!!!  parse_w3cdtf provided by MagpieRSS's rss_utils.inc
 *          this file needs to be included somewhere in your script
 * -------------------------------------------------------------
 */
 
function smarty_modifier_rss_date_parse ($rss_date, $default_date=null)
{
	if($rss_date != '') {
    	return parse_w3cdtf( $rss_date );
	} elseif (isset($default_date) && $default_date != '') {		
    	return parse_w3cdtf( $default_date );
	} else {
		return;
	}
}




?>
