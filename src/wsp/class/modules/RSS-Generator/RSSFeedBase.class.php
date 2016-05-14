<?php
/**
 * PHP file wsp\class\modules\RSS-Generator\RSSFeedBase.class.php
 * @package modules
 * @subpackage RSS-Generator
 */
/**
 * Class RSSFeedBase
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2016 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package modules
 * @subpackage RSS-Generator
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 10/05/2016
 * @version     1.2.14
 * @access      public
 * @since       1.1.2
 */

/**
 * @package modules
 * @subpackage RSS-Generator
 */
/****************************************************
 * @class : RSSFeedBase
 * @parent : Object
 * @abstract : yes
 * @aim : create a new RSS Feed for your site
 * @author : Hugo 'Emacs' HAMON
 * @email : webmaster[at]apprendre-php[dot]com
 * @version : 1.0
 * @package modules
 * @changelog : see the changelog file
 ***************************************************/
 abstract class RSSFeedBase
 {
	// Attributes	
	protected $_description = '';
	protected $_title = '';
	protected $_link = '';
	protected $_pubDate = '';
	protected $_categories = array();
	
	// GET Methods
	
	/****************************************************
	* @function : getCategories
	* @aim : get categories of the feed / item
	* @access : public
	* @static : no
	* @param :  void
	* @return : array $this->_categories
	***************************************************/
	public function getCategories()
	{
		return $this->_categories;
	}
 			
	/****************************************************
	* @function : getDescription
	* @aim : get the description element of the feed / item
	* @access : public
	* @static : no
	* @param :  void
	* @return : string $this->_description
	***************************************************/
	public function getDescription()
	{
		return $this->_description;
	}

	/****************************************************
	* @function : getLink
	* @aim : get the link element of the feed / item
	* @access : public
	* @static : no
	* @param : void
	* @return : string $this->_link
	***************************************************/
	public function getLink()
	{
		return $this->_link;
	}
 			
	/****************************************************
	* @function : getPubDate
	* @aim : get the pubDate element of the feed / item
	* @access : public
	* @static : no
	* @param : void
	* @return : string $this->_pubDate
	***************************************************/
	public function getPubDate()
	{
		return $this->_pubDate;
	}
 			
	/****************************************************
	* @function : getTitle
	* @aim : get the title element of the feed / item
	* @access : public
	* @static : no
	* @param : void
	* @return : string $this->_title
	***************************************************/
	public function getTitle()
	{
		return $this->_title;
	} 			
	

 	// SET Methods
	
	/****************************************************
	* @function : setCategory
	* @aim : set a new category element for the feed / item
	* @access : public
	* @static : no
	* @param : string $domain
	* @param : string $content
	* @return : void
	***************************************************/
	public function setCategory($domain, $content)
	{
		$this->_categories[] = array('domain'=>$domain,'content'=>$content);
	}
	
	/****************************************************
	* @function : setDescription
	* @aim : set the description element of the feed / item
	* @access : public
	* @static : no
	* @param : string $description
	* @return : void
	***************************************************/
	public function setDescription($description)
	{
		$this->_description = utf8_encode($description);
	}
 			
 			
	/****************************************************
	* @function : setLink
	* @aim : set the link element of the feed / item
	* @access : public
	* @static : no
	* @param : string $link
	* @return : void
	***************************************************/
	public function setLink($link)
	{
		$this->_link = RSSFeedTools::checkUrl($link);
	}

	/****************************************************
	* @function : setPubDate
	* @aim : set the pubDate element of the feed / item
	* @access : public
	* @static : no
	* @param : string $pubDate
	* @return : void
	***************************************************/
	public function setPubDate($pubDate)
	{
		$this->_pubDate = RSSFeedTools::prepareFeedDate($pubDate);
	}
 			
	/****************************************************
	* @function : setTitle
	* @aim : set the title element of the feed / item
	* @access : public
	* @static : no
	* @param : string $title
	* @return : void
	***************************************************/
	 public function setTitle($title, $auto_encode=true)
	 {
		 if ($auto_encode) {
			 $this->_title = utf8_encode($title);
		 } else {
			 $this->_title = $title;
		 }
	 }
	
	
} // END CLASS

?>
