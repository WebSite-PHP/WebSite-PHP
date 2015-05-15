<?php
/**
 * PHP file wsp\class\modules\GoogleSearch\GoogleSearchBar.class.php
 * @package modules
 * @subpackage GoogleSearch
 */
/**
 * Class GoogleSearchBar
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2015 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package modules
 * @subpackage GoogleSearch
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 12/05/2015
 * @version     1.2.13
 * @access      public
 * @since       1.0.99
 */

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
 * @version     1.0.79
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
	* Target
	* @access public
	* @var string
	*/
	const TARGET_BLANK = "google.search.Search.LINK_TARGET_BLANK";
	const TARGET_SELF = "google.search.Search.LINK_TARGET_SELF";
	const TARGET_TOP = "google.search.Search.LINK_TARGET_TOP";
	const TARGET_PARENT = "google.search.Search.LINK_TARGET_PARENT";
	const TARGET_NONE = "";
	/**#@-*/
	
	/**#@+
	* @access private
	*/
	private $search_control_code = "";
	private $search_label = "";
	private $search_style = "";
	private $adsense_code = "";
	private $autocomplete = false;
	private $web_tab = false;
	private $array_site_restriction = array();
	private $array_label = array();
	private $link_target = "";
	/**#@-*/
	
	/**
	 * Constructor GoogleSearchBar
	 * @param mixed $search_control_code 
	 * @param string $search_style [default value: default]
	 */
	function __construct($search_control_code, $search_style='default') {
		parent::__construct();
		
		if (!isset($search_control_code)) {
			throw new NewException("1 argument for ".get_class($this)."::__construct() is mandatory", 0, getDebugBacktrace(1));
		}
		
		$this->search_control_code = $search_control_code;
		$this->search_style = $search_style;
		
		$this->addCss("http://www.google.com/cse/style/look/".$this->search_style.".css");
		/* Already included in index.php
		if (JQUERY_LOAD_LOCAL == true) {
			$this->addJavaScript("http://www.google.com/jsapi");
		}*/
	}
	
	/**
	 * Method activeAutoComplete
	 * @access public
	 * @return GoogleSearchBar
	 * @since 1.0.99
	 */
	public function activeAutoComplete() {
		$this->autocomplete = true;
		return $this;
	}
	
	/**
	 * Method addSiteRestriction
	 * $site is an URL prefix or cse code
	 * @access public
	 */
	/**
	 * Method addCseResultTab
	 * @access public
	 * @param mixed $site 
	 * @param mixed $label 
	 * @return GoogleSearchBar
	 * @since 1.0.99
	 */
	public function addCseResultTab($site, $label) {
		$this->array_site_restriction[] = $site_restriction;
		$this->array_label[] = $label;
		
		return $this;
	}
	
	/**
	 * Method activateWebTab
	 * @access public
	 * @return GoogleSearchBar
	 * @since 1.0.99
	 */
	public function activateWebTab() {
		$this->web_tab = true;
		
		return $this;
	}
	
	/**
	 * Method setAdsenseCode
	 * @access public
	 * @param mixed $adsense_code 
	 * @return GoogleSearchBar
	 * @since 1.0.99
	 */
	public function setAdsenseCode($adsense_code) {
		$this->adsense_code = $adsense_code;
		
		return $this;
	}
	
	/**
	 * Method setLinkTarget
	 * @access public
	 * @param mixed $link_target 
	 * @return GoogleSearchBar
	 * @since 1.0.99
	 */
	public function setLinkTarget($link_target) {
		$this->link_target = $link_target;
		
		return $this;
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
				<script type=\"text/javascript\">\n";
				if (GOOGLE_CODE_TRACKER != "" && !isLocalDebug() && 
					!defined('GOOGLE_CODE_TRACKER_NOT_ACTIF')) {
						$html .= "	var _gaq = _gaq || []; _gaq.push(['_setAccount', '".GOOGLE_CODE_TRACKER."']);
							_trackCseQuery = function(control, searcher, query) {
						    var loc = document.location;
						    var url = [
						      loc.pathname,
						      loc.search,
						      loc.search ? '&' : '?',
						      encodeURIComponent('search'),
						      '=',
						      encodeURIComponent(query)
						    ];
						    _gaq.push(['_trackPageview', url.join('')]);
						  }\n";
					}
				  $html .= "	cse_search = function() {
					this.customSearchControl = new google.search.CustomSearchControl('".$this->search_control_code."');\n";
				  if ($this->adsense_code != "") {
					$html .= "		this.customSearchControl.enableAds('".$this->adsense_code."');\n";
				  }					
				  if ($this->link_target != "") {
				  	$html .= "		this.customSearchControl.setLinkTarget(".$this->link_target.");\n";
				  }
				    $html .= "		this.customSearchControl.setResultSetSize(google.search.Search.FILTERED_CSE_RESULTSET);\n";
				  	if (GOOGLE_CODE_TRACKER != "" && !isLocalDebug() && 
				  		!defined('GOOGLE_CODE_TRACKER_NOT_ACTIF')) {
				    		$html .= "            this.customSearchControl.setSearchStartingCallback(null, _trackCseQuery);\n";
				  	}
				  	if ($this->web_tab) {
					    $html .= "		var searcher_opt = new google.search.SearcherOptions();
					    searcher_opt.setExpandMode(google.search.SearchControl.EXPAND_MODE_OPEN);
					    this.customSearchControl.addSearcher(new google.search.WebSearch(), searcher_opt);\n";
				  	}
					for ($i=0; $i < sizeof($this->array_site_restriction); $i++) {
						$html .= "		var searcher = new google.search.WebSearch();
				    	searcher.setSiteRestriction(\"".$this->array_site_restriction[$i]."\");
			        	searcher.setUserDefinedLabel('".addslashes($this->array_label[$i])."');
			        	this.customSearchControl.addSearcher(searcher);\n";
					}
				    $html .= "		var options = new google.search.DrawOptions();\n";
					if ($this->autocomplete) {
			       		$html .= "            options.setAutoComplete(true);\n";
			        }
				    $html .= "		options.setSearchFormRoot('cse-search-form');
				    this.customSearchControl.setSearchStartingCallback(this, cseSearchSubmit);
				    this.customSearchControl.draw('cse-result', options);
				  }
				  
				  var last_query = '';
				  cseSearchSubmit = function(form) {
				  	var q = form.input.value;
			        if (q && q!= '' && q != last_query) {
			        	last_query = q;
			        	$('#cse-normal-content').css('display', 'none');
				  	 	$('#cse-result-div').css('display', 'block');
                                                document.getElementById('cse-result').firstChild.style.padding = 0;
				  	 	document.getElementById('cse-result').firstChild.style.width = '98%';
			        }
			        return false;
			      }
				  
				  	var cse_search_page_loaded = false;
				  	CseSearchPageLoaded = function() {
				  		cse_search_page_loaded = true;
				  	}
				  	CseSearchOnLoad = function() {
				  		if (cse_search_page_loaded) {
				        	CseSearchLoad();
				        } else {
				        	StkFunc(CseSearchLoad);
				        }
			     	}
			     	function CseSearchLoad() {
			        google.load('search', '1', {language : '".$_SESSION['lang']."', callback: function () { new cse_search(); } });
			     	}\n";
				$html .= "   \$(document).ready(function() { \$(window).load(function() {\n";
				$html .= "      if (typeof google != 'undefined') {\n";
				if ($this->getPage()->isThirdPartyCookiesFilterEnable()) {
                                        $html .= "      if (tarteaucitron.state['jsapi'] == true) {\n";
				}
			      $html .= "      CseSearchPageLoaded();
				CseSearchOnLoad();\n";
                                if ($this->getPage()->isThirdPartyCookiesFilterEnable()) {
                                        $html .= "      } else { $('#cse-search-form').html(''); }\n";
                                }
				$html .= "      } else { $('#cse-search-form').html(''); }\n";
				$html .= "   }); });\n";
				$html .= "</script>";
       	$this->object_change = false;
		return $html;
	}
}
?>
