<?php
/**
 * PHP file wsp\class\modules\RSS-Generator\RSSFeedException.class.php
 * @package modules
 * @subpackage RSS-Generator
 */
/**
 * Class RSSFeedException
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2015 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package modules
 * @subpackage RSS-Generator
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 12/05/2015
 * @version     1.2.13
 * @access      public
 * @since       1.1.2
 */

/**
 * @package modules
 * @subpackage RSS-Generator
 */
/****************************************************
 * @class : RSSFeedException
 * @parent : Exception
 * @abstract : no
 * @aim : manage exceptions
 * @author : Hugo 'Emacs' HAMON
 * @email : webmaster[at]apprendre-php[dot]com
 * @version : 1.0
 * @package modules
 * @changelog : see the changelog file
 ***************************************************/
 class RSSFeedException extends Exception
 {
 	// Attributes
	private $_method = '';
	private $_class = '';

	// Constructor
	
	/****************************************************
	* @function : __construct
	* @aim : create the new instance
	* @access : public
	* @static : no
	* @param :  string $message
	* @param : string $class
	* @param : string $method
	* @return : void
	***************************************************/
	/**
	 * Constructor RSSFeedException
	 * @param mixed $message 
	 * @param mixed $class 
	 * @param mixed $method 
	 */
	public function __construct($message, $class, $method) 
	{
		$this->_class = $class;
		$this->_method = $method;
		parent::__construct($message);
	}
	
	// __toString
	
	/****************************************************
	* @function : __toString
	* @aim : display the exception
	* @access : public
	* @static : no
	* @param :  void
	* @return : void
	***************************************************/
	/**
	 * Method __toString
	 * @access public
	 * @return mixed
	 * @since 1.1.2
	 */
	public function __toString()
	{
		echo $this->getErrorMessage();	
	}
	
	// Get methods
	
	/****************************************************
	* @function : getErrorMessage
	* @aim : display the exception
	* @access : public
	* @static : no
	* @param :  void
	* @return : string $return
	***************************************************/
	public function getErrorMessage() 
	{
		$str .= "<b>Error</b><br/>";
		$str .= "<br/><b>Message:</b> ".$this->getMessage()."<br/>";
        $str .= "<b>File:</b> ".$this->getFile()."<br/>";
        $str .= "<b>Line:</b> ".$this->getLine()."<br/>";
        $str .= "<b>Class :</b> ".$this->_class."<br/>\n";
		$str .= "<b>Method :</b> ".$this->_method."<br/><br/>\n";
		if ($this->getTraceAsString() != "") {
        	$str .= "<b>Trace:</b><br/>".str_replace("\n", "<br/>", $this->getTraceAsString())."<br/>";
        }
		
		return $str;
	}
	
 	public function getException() {
        return $this->getErrorMessage(); // This will print the return from the above method __toString()
    }
 }
 
 ?>
