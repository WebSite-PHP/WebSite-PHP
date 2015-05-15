<?php
/**
 * PHP file wsp\class\modules\RSS-Generator\RSSFeedItem.class.php
 * @package modules
 * @subpackage RSS-Generator
 */
/**
 * Class RSSFeedItem
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
 * @class : RSSFeedItem
 * @parent : RSSFeedBase
 * @abstract : no
 * @aim : create a new item instance for the feed
 * @author : Hugo 'Emacs' HAMON
 * @email : webmaster[at]apprendre-php[dot]com
 * @version : 1.0
 * @package modules
 * @changelog : 
 ***************************************************/
 
 class RSSFeedItem extends RSSFeedBase
 {
	// Attributes
	private $_itemAuthor = array();
	private $_itemEnclosure = array();
	private $_itemGuid = array();
	private $_itemSource = array();
	private $_comments = '';
	
	// Constructor
	
	/****************************************************
	* @function : __construct
	* @aim : create the instance of the class
	* @access : public
	* @static : no
	* @param : string $encoding
	* @return : void
	***************************************************/
	/**
	 * Constructor RSSFeedItem
	 */
	public function __construct() {}
	
	// Destructor
	
	/**
	 * Destructor RSSFeedItem
	 */
	public function __destruct() {}
	
	// SET methods
 	  
	/****************************************************
	* @function : setAuthor
	* @aim : set the item author element
	* @access : public
	* @static : no
	* @param : string $email
	*	@param : string $name
	* @return : void
	***************************************************/
	/**
	 * Method setAuthor
	 * @access public
	 * @param mixed $email 
	 * @param string $name 
	 * @return mixed
	 * @since 1.1.2
	 */
	public function setAuthor($email, $name='')
	{
		$this->_itemAuthor['email'] = RSSFeedTools::checkEmail($email);
		$this->_itemAuthor['name'] = $name;
	}
	
	/****************************************************
	* @function : setComments
	* @aim : set the item comments element
	* @access : public
	* @static : no
	* @param : string $url
	* @return : void
	***************************************************/
	public function setComments($url)
	{
		$this->_comments = RSSFeedTools::checkUrl($url);
	}
	
	/****************************************************
	* @function : setEnclosure
	* @aim : set the item enclosure element
	* @access : public
	* @static : no
	* @param : string $url
	* @param : int $length
	* @param : string $mimeType
	* @return : void
	***************************************************/
	public function setEnclosure($url, $length, $mimeType)
	{
		if(!empty($url) 
			&& !empty($length) 
			&& is_numeric($length) 
			&& ($length>0) 
			&& !empty($mimeType))
		{
			$this->_itemEnclosure['url'] = RSSFeedTools::checkUrl($url);
			$this->_itemEnclosure['length'] = intval($length);
			$this->_itemEnclosure['type'] = $mimeType;
		}
	}
 	  
	/****************************************************
	* @function : setGuid
	* @aim : set the item guid element
	* @access : public
	* @static : no
	* @param : string $guid
	* @param : bool $isPermaLink
	* @return : void
	***************************************************/
	public function setGuid($guid, $isPermaLink=false)
	{
		if(true === $isPermaLink)
		{
			$this->_itemGuid['isPermaLink'] = 'true';
		}
		else
		{
			$this->_itemGuid['isPermaLink'] = 'false';
		}
		
		$this->_itemGuid['content'] = $guid;
	}
 	  
	/****************************************************
	* @function : setSource
	* @aim : set the item source element
	* @access : public
	* @static : no
	* @param : string $url
	* @param : string $content
	* @return : void
	***************************************************/
	public function setSource($url, $content)
	{
		if(!empty($url) && !empty($content))
		{
			$this->_itemSource['url'] = RSSFeedTools::checkUrl($url);
			$this->_itemSource['content'] = $content;
		}
	}

 	  
	// GET methods
	
	/****************************************************
	* @function : getAuthor
	* @aim : get the item author element
	* @access : public
	* @static : no
	* @param : void
	* @return : array $this->_itemAuthor
	***************************************************/
	public function getAuthor()
	{
		return $this->_itemAuthor;
	}
	
	/****************************************************
	* @function : getComments
	* @aim : get the item comments element
	* @access : public
	* @static : no
	* @param : void
	* @return : string $this->_comments
	***************************************************/
	public function getComments()
	{
		return $this->_comments;
	}
 	  
	/****************************************************
	* @function : getEnclosure
	* @aim : get the item enclosure element
	* @access : public
	* @static : no
	* @param : void
	* @return : array $this->_itemEnclosure
	***************************************************/
	public function getEnclosure()
	{
		return $this->_itemEnclosure;
	}
	
	/****************************************************
	* @function : getGuid
	* @aim : get the item guid element
	* @access : public
	* @static : no
	* @param : void
	* @return : array $this->_itemGuid
	***************************************************/
	public function getGuid()
	{
		return $this->_itemGuid;
	}
 	  
	/****************************************************
	* @function : getSource
	* @aim : get the item source element
	* @access : public
	* @static : no
	* @param : void
	* @return : array $this->_itemSource
	***************************************************/
	public function getSource()
	{
		return $this->_itemSource;
	}
	
	// Other methods
	
	
	// END CLASS
}	
 ?>
