<?php
/**
 * PHP file wsp\class\display\advanced_object\google\googlesearch\GoogleSearchBar.class.php
 * @package display
 * @subpackage advanced_object.google.googlesearch
 */
/**
 * Class GoogleSearchBar
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2011 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package display
 * @subpackage advanced_object.google.googlesearch
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 22/10/2010
 * @version     1.0.57
 * @access      public
 * @since       1.0.17
 */

class GoogleSearchBar extends WebSitePhpObject {
	/**#@+
	* GoogleSearchBar style
	* @access public
	* @var string
	*/
	const STYLE_DEFAULT = "default";
	const STYLE_BUBBLEGUM = "bubblegum";
	const STYLE_GREENSKY = "greensky";
	const STYLE_ESPRESSO = "espresso";
	const STYLE_SHINY = "shiny";
	const STYLE_MINIMALIST = "minimalist";
	/**#@-*/
	
	/**#@+
	* @access private
	*/
	private $search_control_code = "";
	private $search_label = "";
	private $search_style = "";
	/**#@-*/
	
	/**
	 * Constructor GoogleSearchBar
	 * @param mixed $search_control_code 
	 * @param string $search_label 
	 * @param string $search_style [default value: default]
	 */
	function __construct($search_control_code, $search_label='', $search_style='default') {
		parent::__construct();
		
		if (!isset($search_control_code)) {
			throw new NewException("1 argument for ".get_class($this)."::__construct() is mandatory", 0, 8, __FILE__, __LINE__);
		}
		
		$this->search_control_code = $search_control_code;
		$this->search_label = $search_label;
		$this->search_style = $search_style;
		
		$this->addCss("http://www.google.com/cse/style/look/".$this->search_style.".css");
		if (JQUERY_LOAD_LOCAL == true) {
			$this->addJavaScript("http://www.google.com/jsapi");
		}
	}
	
	/**
	 * Method render
	 * @access public
	 * @param boolean $ajax_render [default value: false]
	 * @return string html code of object GoogleSearchBar
	 * @since 1.0.35
	 */
	public function render($ajax_render=false) {
		$html = "<div id=\"cse-search-form\" style=\"width: 100%;\">Loading</div>
				<script type=\"text/javascript\">
				  function cse_search() {
				    var sFormDiv = document.getElementById('cse-search-form');
				    this.searchForm = new google.search.SearchForm(true, sFormDiv);
				      
				    this.searchControl = new google.search.SearchControl();
				    this.searchControl.setResultSetSize(GSearch.LARGE_RESULTSET);
				    this.searchForm.setOnSubmitCallback(this, cse_search.prototype.onSubmit);
				    
				    var searcher = new google.search.WebSearch();
				    //searcher.setOnSubmitCallback(this, cse_search.prototype.onSubmit);
				    var options = new google.search.SearcherOptions();
				    searcher.setSiteRestriction(\"".$this->search_control_code."\");\n";
		if ($this->search_label != "") {
        	$html .= "            searcher.setUserDefinedLabel(\"".$this->search_label."\");\n";
		}
        $html .= "            options.setExpandMode(GSearchControl.EXPAND_MODE_OPEN);
                    this.searchControl.addSearcher(searcher, options);
                    this.searchControl.draw(document.getElementById('cse-result'));
				  }
				  
				  cse_search.prototype.onSubmit = function(form) {
			        var q = form.input.value;
			        if (q && q!= \"\") {
			        	$('#cse-normal-content').css('display', 'none');
				  	 	$('#cse-result-div').css('display', 'block');
				  	 	document.getElementById('cse-result').firstChild.style.width = '100%';
				  	 	this.searchControl.execute(q);
			        }
			        return false;
			      }
				  
				  	var cse_search_page_loaded = false;
				  	function CseSearchPageLoaded() {
				  		cse_search_page_loaded = true;
				  	}
				  	function CseSearchOnLoad() {
				  		if (cse_search_page_loaded) {
			        	CseSearchLoad();
			        } else {
			        	StkFunc(CseSearchLoad);
			        }
			     	}
			     	function CseSearchLoad() {
			        google.load('search', '1', {language : '".$_SESSION['lang']."', callback: function () { new cse_search(); } });
			     	}
			      StkFunc(CseSearchPageLoaded);
			      google.setOnLoadCallback(CseSearchOnLoad, true);
				</script>";
       	$this->object_change = false;
		return $html;
	}
}
?>
