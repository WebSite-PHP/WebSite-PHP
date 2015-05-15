<?php
/**
 * PHP file wsp\class\modules\ShareButton\ShareButton.class.php
 * @package modules
 * @subpackage ShareButton
 */
/**
 * Class ShareButton
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2015 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package modules
 * @subpackage ShareButton
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 12/05/2015
 * @version     1.2.13
 * @access      public
 * @since       1.0.79
 */

class ShareButton extends WebSitePhpObject {
	/**#@+
	* Button style
	* @access public
	* @var string
	*/
	const BUTTON_SMALL = "small";
	const BUTTON_MEDIUM = "medium";
	const BUTTON_BIG = "big";
	const BUTTON_ICONS_TEXT = "icons_text";
	const BUTTON_ICON = "icon";
	const BUTTON_TEXT = "text";
	/**#@-*/
	
	/**#@+
	* Share services
	* @access public
	* @var string
	*/
	const SHARE_BY_AIM = "aim";
	const SHARE_BY_AOL_MAIL = "aol_mail";
	const SHARE_BY_ALLVOICES = "allvoices";
	const SHARE_BY_AMAZON_WISH_LIST = "amazon_wish_list";
	const SHARE_BY_ARTO = "arto";
	const SHARE_BY_ASK_COM_MYSTUFF = "ask_com_mystuff";
	const SHARE_BY_BACKFLIP = "backflip";
	const SHARE_BY_BEBO = "bebo";
	const SHARE_BY_BIBSONOMY = "bibsonomy";
	const SHARE_BY_BITTY_BROWSER = "bitty_browser";
	const SHARE_BY_BLINKLIST = "blinklist";
	const SHARE_BY_BLOGMARKS = "blogmarks";
	const SHARE_BY_BLOGGER_POST = "blogger_post";
	const SHARE_BY_BOOKMARKS_FR = "bookmarks_fr";
	const SHARE_BY_BOX_NET = "box_net";
	const SHARE_BY_BUDDYMARKS = "buddymarks";
	const SHARE_BY_BUSINESS_EXCHANGE = "business_exchange";
	const SHARE_BY_CARE2_NEWS = "care2_news";
	const SHARE_BY_CITEULIKE = "citeulike";
	const SHARE_BY_CONNOTEA = "connotea";
	const SHARE_BY_CURRENT = "current";
	const SHARE_BY_DZONE = "dzone";
	const SHARE_BY_DAILYME = "dailyme";
	const SHARE_BY_DELICIOUS = "delicious";
	const SHARE_BY_DIGG = "digg";
	const SHARE_BY_DIGLOG = "diglog";
	const SHARE_BY_DIIGO = "diigo";
	const SHARE_BY_EMAIL = "email";
	const SHARE_BY_EVERNOTE = "evernote";
	const SHARE_BY_EXPRESSION = "expression";
	const SHARE_BY_FACEBOOK = "facebook";
	const SHARE_BY_FARK = "fark";
	const SHARE_BY_FAVES = "faves";
	const SHARE_BY_FOLKD = "folkd";
	const SHARE_BY_FRIENDFEED = "friendfeed";
	const SHARE_BY_FUNP = "funp";
	const SHARE_BY_GABBR = "gabbr";
	const SHARE_BY_GOOGLE_BOOKMARKS = "google_bookmarks";
	const SHARE_BY_GOOGLE_BUZZ = "google_buzz";
	const SHARE_BY_GOOGLE_GMAIL = "google_gmail";
	const SHARE_BY_GOOGLE_READER = "google_reader";
	const SHARE_BY_HELLOTXT = "hellotxt";
	const SHARE_BY_HEMIDEMI = "hemidemi";
	const SHARE_BY_HOTMAIL = "hotmail";
	const SHARE_BY_HUGG = "hugg";
	const SHARE_BY_HYVES = "hyves";
	const SHARE_BY_IDENTI_CA = "identi_ca";
	const SHARE_BY_IMERA_BRAZIL = "imera_brazil";
	const SHARE_BY_INSTAPAPER = "instapaper";
	const SHARE_BY_JAMESPOT = "jamespot";
	const SHARE_BY_JUMPTAGS = "jumptags";
	const SHARE_BY_KHABBR = "khabbr";
	const SHARE_BY_KLEDY = "kledy";
	const SHARE_BY_LINKAGOGO = "linkagogo";
	const SHARE_BY_LINKATOPIA = "linkatopia";
	const SHARE_BY_LINKEDIN = "linkedin";
	const SHARE_BY_LIVEJOURNAL = "livejournal";
	const SHARE_BY_MSDN = "msdn";
	const SHARE_BY_MAPLE = "maple";
	const SHARE_BY_MENEAME = "meneame";
	const SHARE_BY_LIVE = "live";
	const SHARE_BY_MINDBODYGREEN = "mindbodygreen";
	const SHARE_BY_MISTER_WONG = "mister_wong";
	const SHARE_BY_MIXX = "mixx";
	const SHARE_BY_MOZILLACA = "mozillaca";
	const SHARE_BY_MULTIPLY = "multiply";
	const SHARE_BY_MYLINKVAULT = "mylinkvault";
	const SHARE_BY_MYSPACE = "myspace";
	const SHARE_BY_NETLOG = "netlog";
	const SHARE_BY_NETVIBES_SHARE = "netvibes_share";
	const SHARE_BY_NETVOUZ = "netvouz";
	const SHARE_BY_NEWSTRUST = "newstrust";
	const SHARE_BY_NEWSVINE = "newsvine";
	const SHARE_BY_NOWPUBLIC = "nowpublic";
	const SHARE_BY_ONEVIEW = "oneview";
	const SHARE_BY_ORKUT = "orkut";
	const SHARE_BY_PHONEFAVS = "phonefavs";
	const SHARE_BY_PING = "ping";
	const SHARE_BY_PLAXO_PULSE = "plaxo_pulse";
	const SHARE_BY_PLURK = "plurk";
	const SHARE_BY_POSTEROUS = "posterous";
	const SHARE_BY_PRINTFRIENDLY = "printfriendly";
	const SHARE_BY_PROTOPAGE_BOOKMARKS = "protopage_bookmarks";
	const SHARE_BY_PUSHA = "pusha";
	const SHARE_BY_READ_IT_LATER = "read_it_later";
	const SHARE_BY_REDDIT = "reddit";
	const SHARE_BY_REDIFF = "rediff";
	const SHARE_BY_SEGNALO = "segnalo";
	const SHARE_BY_SHOUTWIRE = "shoutwire";
	const SHARE_BY_SIMPY = "simpy";
	const SHARE_BY_SITEJOT = "sitejot";
	const SHARE_BY_SLASHDOT = "slashdot";
	const SHARE_BY_SMAKNEWS = "smaknews";
	const SHARE_BY_SPHERE = "sphere";
	const SHARE_BY_SPHINN = "sphinn";
	const SHARE_BY_SPURL = "spurl";
	const SHARE_BY_SQUIDOO = "squidoo";
	const SHARE_BY_STARTAID = "startaid";
	const SHARE_BY_STRANDS = "strands";
	const SHARE_BY_STUMBLEUPON = "stumbleupon";
	const SHARE_BY_SYMBALOO_FEEDS = "symbaloo_feeds";
	const SHARE_BY_TAGZA = "tagza";
	const SHARE_BY_TAILRANK = "tailrank";
	const SHARE_BY_TECHNET = "technet";
	const SHARE_BY_TECHNORATI_FAVORITES = "technorati_favorites";
	const SHARE_BY_TECHNOTIZIE = "technotizie";
	const SHARE_BY_TIPD = "tipd";
	const SHARE_BY_TUENTI = "tuenti";
	const SHARE_BY_TUMBLR = "tumblr";
	const SHARE_BY_TWIDDLA = "twiddla";
	const SHARE_BY_TWITTER = "twitter";
	const SHARE_BY_TYPEPAD_POST = "typepad_post";
	const SHARE_BY_VIADEO = "viadeo";
	const SHARE_BY_VODPOD = "vodpod";
	const SHARE_BY_WEBNEWS = "webnews";
	const SHARE_BY_WINK = "wink";
	const SHARE_BY_WISTS = "wists";
	const SHARE_BY_WORDPRESS = "wordpress";
	const SHARE_BY_XING = "xing";
	const SHARE_BY_XERPI = "xerpi";
	const SHARE_BY_YAHOO_BOOKMARKS = "yahoo_bookmarks";
	const SHARE_BY_YAHOO_MAIL = "yahoo_mail";
	const SHARE_BY_YAHOO_MESSENGER = "yahoo_messenger";
	const SHARE_BY_YAMPLE = "yample";
	const SHARE_BY_YIGG = "yigg";
	const SHARE_BY_YOOLINK = "yoolink";
	const SHARE_BY_YOUMOB = "youmob";
	const SHARE_BY_UNALOG = "unalog";
	/**#@-*/
	
	/**#@+
	* @access private
	*/
	private $type_button = "medium";
	private $page_name = "";
	private $page_url = "";
	private $show_menu_onclick = false;
	
	private $main_color = "";
	private $border = "";
	private $link_text = "";
	private $link_text_hover = "";
	private $background = "";
	
	private $array_share_services = array();
	/**#@-*/
	
	/**
	 * Constructor ShareButton
	 * @param string $type_button [default value: medium]
	 * @param string $page_name 
	 * @param string $page_url 
	 */
	function __construct($type_button='medium', $page_name='', $page_url='') {
		parent::__construct();
		
		$this->page_name = $page_name;
		$this->page_url = $page_url;
		$this->type_button = $type_button;
	}
	
	/**
	 * Method setColor
	 * @access public
	 * @param mixed $main_color 
	 * @param mixed $border 
	 * @param mixed $link_text 
	 * @param mixed $link_text_hover 
	 * @param mixed $background 
	 * @return ShareButton
	 * @since 1.0.79
	 */
	public function setColor($main_color, $border, $link_text, $link_text_hover, $background) {
		$this->main_color = $main_color;
		$this->border = $border;
		$this->link_text = $link_text;
		$this->link_text_hover = $link_text_hover;
		$this->background = $background;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method showMenuOnlyWhenButtonClicked
	 * @access public
	 * @return ShareButton
	 * @since 1.0.79
	 */
	public function showMenuOnlyWhenButtonClicked() {
		$this->show_menu_onclick = true;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method addShareServices
	 * @access public
	 * @param mixed $share_service 
	 * @return ShareButton
	 * @since 1.0.79
	 */
	public function addShareServices($share_service) {
		$this->array_share_services[] = $share_service;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method render
	 * @access public
	 * @param boolean $ajax_render [default value: false]
	 * @return string html code of object ShareButton
	 * @since 1.0.79
	 */
	public function render($ajax_render=false) {
		$html = "";
		
		$share_save_url = "http://www.addtoany.com/share_save";
		if ($this->page_url != "" || $this->page_name != "") {
			$share_save_url .= "?linkurl=".urlencode($this->page_url)."&amp;linkname=".urlencode($this->page_name);
		}
		if ($this->type_button == ShareButton::BUTTON_SMALL) {
			$html .= "<a class=\"a2a_dd\" href=\"".$share_save_url."\">";
			$html .= "<img src=\"http://static.addtoany.com/buttons/share_save_120_16.gif\" width=\"120\" height=\"16\" border=\"0\" alt=\"Share\"/></a>";
		} else if ($this->type_button == ShareButton::BUTTON_MEDIUM) {
			$html .= "<a class=\"a2a_dd\" href=\"".$share_save_url."\">";
			$html .= "<img src=\"http://static.addtoany.com/buttons/share_save_171_16.png\" width=\"171\" height=\"16\" border=\"0\" alt=\"Share\"/></a>";
		} else if ($this->type_button == ShareButton::BUTTON_BIG) {
			$html .= "<a class=\"a2a_dd\" href=\"".$share_save_url."\">";
			$html .= "<img src=\"http://static.addtoany.com/buttons/share_save_256_24.png\" width=\"256\" height=\"24\" border=\"0\" alt=\"Share\"/></a>";
		} else if ($this->type_button == ShareButton::BUTTON_ICONS_TEXT) {
			$html .= "<div class=\"a2a_kit a2a_default_style\">";
			$html .= "<a class=\"a2a_dd\" href=\"".$share_save_url."\">Share</a>";
			$html .= "<span class=\"a2a_divider\"></span>";
			$html .= "<a class=\"a2a_button_facebook\"></a>";
			$html .= "<a class=\"a2a_button_twitter\"></a>";
			$html .= "<a class=\"a2a_button_email\"></a>";
			$html .= "</div>";
		} else if ($this->type_button == ShareButton::BUTTON_ICON) {
			$html .= "<a class=\"a2a_dd\" href=\"".$share_save_url."\">";
			$html .= "<img src=\"http://static.addtoany.com/buttons/favicon.png\" width=\"16\" height=\"16\" border=\"0\" alt=\"Share\"/></a>";
		} else if ($this->type_button == ShareButton::BUTTON_TEXT) {
			$html .= "<a class=\"a2a_dd\" href=\"".$share_save_url."\">Share</a>";
		}
		
		$html .= "<script type=\"text/javascript\">";
		$html .= "var a2a_config = a2a_config || {};";
		$html .= "a2a_config.linkname = \"".$this->page_name."\";";
		$html .= "a2a_config.linkurl = \"".$this->page_url."\";";
		$html .= "a2a_config.locale = \"".$_SESSION['lang']."\";";
		if ($this->show_menu_onclick) {
			$html .= "a2a_config.onclick = 1;";
		}
		if (sizeof($this->array_share_services) > 0) {
			$html .= "a2a_config.prioritize = [";
			for ($i=0; $i < sizeof($this->array_share_services); $i++) {
				if ($i != 0) { $html .= ","; }
				$html .= "\"".$this->array_share_services[$i]."\"";
			}
			$html .= "];";
		}
		if ($this->main_color != "") {
			$html .= "a2a_config.color_main = \"".$this->main_color."\";";
		}
		if ($this->border != "") {
			$html .= "a2a_config.color_border = \"".$this->border."\";";
		}
		if ($this->link_text != "") {
			$html .= "a2a_config.color_link_text = \"".$this->link_text."\";";
		}
		if ($this->link_text_hover != "") {
			$html .= "a2a_config.color_link_text_hover = \"".$this->link_text_hover."\";";
		}
		if ($this->background != "") {
			$html .= "a2a_config.color_bg = \"".$this->background."\";";
		}
		$html .= "</script>";
        if ($this->getPage()->isThirdPartyCookiesFilterEnable()) {
            $html .= "<script type=\"text/javascript\">(tarteaucitron.job = tarteaucitron.job || []).push('addtoanyshare');</script>";
        } else {
            $html .= "<script type=\"text/javascript\" src=\"http://static.addtoany.com/menu/page.js\" defer=\"defer\"></script>";
        }

		return $html;
	}
}
?>
