<?php
/**
 * PHP file wsp\includes\utils_regexp.inc.php
 */
/**
 * WebSite-PHP file utils_regexp.inc.php
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
 * @since       1.1.1
 */

/**
 * Checks if a given regular expression is valid.
 * It changes the error_handler and restores it.
 *
 * @param string the regular expression to test
 * @param boolean does the regular expression includes delimiters (and optionally modifiers)?
 * @return boolean 
 */
function is_regexp( $reg_exp, $includes_delim = false )
{
    $sPREVIOUSHANDLER = set_error_handler( '_trapIsRegExpError' );
    if( ! $includes_delim )
    {
        $reg_exp = '#'.str_replace( '#', '\#', $reg_exp ).'#';
    }
    preg_match( $reg_exp, '' );
    restore_error_handler( $sPREVIOUSHANDLER );
 
    return !_trapIsRegExpError();
}
 
 
/**
 * Meant to replace error handler temporarily.
 *
 * @return integer number of errors
 */
function _trapIsRegExpError( $reset = 1 )
{
    static $iERRORES;
 
    if( !func_num_args() )
    {
        $iRETORNO = $iERRORES;
        $iERRORES = 0;
        return $iRETORNO;
    }
    else
    {
        $iERRORES++;
    }
}
?>
