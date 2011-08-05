<?php

/****************************************************
 * @class : RSSFeedException
 * @parent : Exception
 * @abstract : no
 * @aim : manage exceptions
 * @author : Hugo 'Emacs' HAMON
 * @email : webmaster[at]apprendre-php[dot]com
 * @version : 1.0
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
		$str .= "<br/><b>Message:</b> ".htmlentities($this->getMessage())."<br/>";
        $str .= "<b>File:</b> ".$this->getFile()."<br/>";
        $str .= "<b>Line:</b> ".$this->getLine()."<br/>";
        $str .= "<b>Class :</b> ".$this->_class."<br/>\n";
		$str .= "<b>Method :</b> ".$this->_method."<br/><br/>\n";
		if ($this->getTraceAsString() != "") {
        	$str .= "<b>Trace:</b><br/>".str_replace("\n", "<br/>", htmlentities($this->getTraceAsString()))."<br/>";
        }
		
		return $str;
	}
	
 	public function getException() {
        return $this->getErrorMessage(); // This will print the return from the above method __toString()
    }
 }
 
 ?>
