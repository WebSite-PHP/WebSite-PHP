<?php
/**
 * PHP file wsp\class\NewException.class.php
 */
/**
 * Class NewException
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2017 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 05/02/2017
 * @version     1.2.15
 * @access      public
 * @since       1.0.15
 */

function getDebugBacktrace($remove_nb_level=0) {
	$output = "";
    $backtrace = debug_backtrace();
	$ind = 0;
    foreach ($backtrace as $bt) {
		if ($ind >= $remove_nb_level) {
	        $args = '';
	        if (isset($bt['args'])) {
		        foreach ($bt['args'] as $a) {
		            if (!empty($args)) {
		                $args .= ', ';
		            }
		            switch (gettype($a)) {
		            case 'integer':
		            case 'double':
		                $args .= $a;
		                break;
		            case 'string':
		                $a = htmlspecialchars(substr($a, 0, 64)).((strlen($a) > 64) ? '...' : '');
		                $args .= "\"$a\"";
		                break;
		            case 'array':
		                $args .= 'Array('.count($a).')';
		                break;
		            case 'object':
		                $args .= 'Object('.get_class($a).')';
		                break;
		            case 'resource':
		                $args .= 'Resource('.strstr($a, '#').')';
		                break;
		            case 'boolean':
		                $args .= $a ? 'True' : 'False';
		                break;
		            case 'NULL':
		                $args .= 'Null';
		                break;
		            default:
		                $args .= 'Unknown';
		            }
		        }
	        }
	        $output .= "\n";
	        if (isset($bt['file'])) { $output .= "file: {$bt['line']} - {$bt['file']}\n"; }
	        $output .= "call: ";
	        if (isset($bt['class'])) { $output .= $bt['class']; }
	        if (isset($bt['type'])) { $output .= $bt['type']; }
	        if (isset($bt['function'])) { $output .= $bt['function']."(".$args.")"; }
	        $output .= "\n";
    	}
        $ind++;
    }
    return $output;
}

class NewException extends Exception
{
	private static $trace = "";
	
	/**
	 * Constructor NewException
	 * @param string $message 
	 * @param mixed $code [default value: NULL]
	 * @param string $trace 
	 */
    public function __construct($message, $code=NULL, $trace='') {
        parent::__construct($message, $code);
        self::$trace = $trace;
    }
   
	/**
	 * Method __toString
	 * @access public
	 * @return string
	 * @since 1.0.35
	 */
    public function __toString() {
    	try {
			return NewException::generateErrorMessage($this->getCode(), $this->getMessage(), $this->getFile(), $this->getLine(), (isset($this->_class)?$this->_class:""), (isset($this->_method)?$this->_method:""), (self::$trace==""?$this->getTraceAsString():self::$trace));
		} catch (Exception $e) {
			echo $e->getMessage();
			exit;
		}
    }
    
	/**
	 * Method generateErrorMessage
	 * @access static
	 * @param string $code 
	 * @param string $message 
	 * @param string $file 
	 * @param string $line 
	 * @param string $class_name 
	 * @param string $method 
	 * @param string $trace 
	 * @return string
	 * @since 1.0.35
	 */
    public static function generateErrorMessage($code, $message, $file, $line, $class_name='', $method='', $trace='') {
    	if ($message == "Class 'WebSitePhpSoapClient' not found") {
    		$message = "You must activate PHP extension php_soap in php.ini";
    	}
    	
    	$str = "";
		$str .= "<b>Message:</b> ".$message."<br/>";
		if (self::$trace !== false) {
	        $str .= "<b>File:</b> ".$file."<br/>";
	        $str .= "<b>Line:</b> ".$line."<br/>";
	        $str .= "<b>Class :</b> ".$class_name."<br/>\n";
			$str .= "<b>Method :</b> ".$method."<br/><br/>\n";
		}
		if ($trace == "" && self::$trace !== false) {
			if (self::$trace != "") {
				$trace = self::$trace;
			} else {
				$trace = getDebugBacktrace(2);
			}
		}
		if ($trace != "") {
        	$str .= "<b>Trace:</b><br/>".str_replace("\n", "<br/>", $trace)."<br/>";
        }
        
        return $str;
    }

	/**
	 * Method getException
	 * @access public
	 * @return NewException
	 * @since 1.0.35
	 */
    public function getException() {
        return $this; // This will print the return from the above method __toString()
    }
   
	/**
	 * Method getStaticException
	 * @access static
	 * @param string|Exception $exception 
	 * @since 1.0.59
	 */
	public static function getStaticException($exception) {
		if (method_exists($exception, "getException")) {
         	print $exception->getException(); // $exception is an instance of this class
        } else {
        	print $exception;
        }
    }
    
	/**
	 * Method printStaticException
	 * @access static
	 * @param string|Exception $exception 
	 * @since 1.0.59
	 */
	public static function printStaticException($exception) {
		if (method_exists($exception, "getException")) {
			NewException::printStaticDebugMessage($exception->getException());
		} else {
			NewException::printStaticDebugMessage($exception);
		}
    }
    
	/**
	 * Method redirectOnError
	 * @access static
	 * @param string $buffer 
	 * @return mixed
	 * @since 1.0.35
	 */
    public static function redirectOnError($buffer) {  
		$lastError = error_get_last();  
		if(!is_null($lastError) && ($lastError['type'] === E_ERROR || $lastError['type'] === E_PARSE)) {
			$debug_msg = NewException::generateErrorMessage($lastError['type'], $lastError['message'], $lastError['file'], $lastError['line']);
			NewException::printStaticDebugMessage($debug_msg);
		}  
		return $buffer;  
	}
	
	/**
	 * Method printStaticDebugMessage
	 * @access static
	 * @param string|object $debug_msg 
	 * @since 1.0.59
	 */
	public static function printStaticDebugMessage($debug_msg) {
		// print the debug
		$GLOBALS['__ERROR_DEBUG_PAGE__'] = true;
		if ($GLOBALS['__DEBUG_PAGE_IS_PRINTING__'] == false) {
			$GLOBALS['__DEBUG_PAGE_IS_PRINTING__'] = true;
			if (gettype($debug_msg) == "object") {
				if (get_class($debug_msg) == "NewException") {
					$debug_msg = NewException::generateErrorMessage($debug_msg->code, $debug_msg->message, $debug_msg->file, $debug_msg->line);
				} else {
					$debug_msg = echo_r($debug_msg);
				}
			}
			
			if ($GLOBALS['__AJAX_PAGE__'] == false || ($GLOBALS['__AJAX_LOAD_PAGE__'] == true && $_GET['mime'] == "text/html")) {
				$_POST['debug'] = $debug_msg;
				$_GET['p'] = "error-debug";
				
				try {
					if (!defined('FORCE_SERVER_NAME') || FORCE_SERVER_NAME == "") {
						if ($_SERVER['SERVER_PORT'] == 443) {
							$from_url = "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
						} else {
							$port = "";
							if ($_SERVER['SERVER_PORT'] != 80 &&  $_SERVER['SERVER_PORT'] != "") {
								$port = ":".$_SERVER['SERVER_PORT'];
							}
							$from_url = "http://".$_SERVER['SERVER_NAME'].$port.$_SERVER['REQUEST_URI'];
						}
					} else {
						$from_url = "http://".FORCE_SERVER_NAME.$_SERVER['REQUEST_URI'];
					}
					$_GET['from_url'] = $from_url;
					
					require_once(dirname(__FILE__)."/../../pages/error/error-debug.php");
					$debug_page = new ErrorDebug(self::$trace !== false?true:false);
					if (method_exists($debug_page, "InitializeComponent")) {
						$debug_page->InitializeComponent();
					}
					if (method_exists($debug_page, "Load")) {
						$debug_page->Load();
					}
					
					$debug_page->loadAllVariables();
					$__PAGE_IS_INIT__ = true;
					$debug_page->executeCallback();
					
					if (method_exists($debug_page, "Loaded")) {
						$debug_page->Loaded();
					}
					
					$http_type = "";
					$split_request_uri = explode("\?", $_SERVER['REQUEST_URI']);
					if (!defined('FORCE_SERVER_NAME') || FORCE_SERVER_NAME == "") {
						if ($_SERVER['SERVER_PORT'] == 443) {
							$http_type = "https://";
							$current_url = str_replace("//", "/", $_SERVER['SERVER_NAME'].substr($split_request_uri[0], 0, strrpos($split_request_uri[0], "/"))."/");
						} else {
							$port = "";
							if ($_SERVER['SERVER_PORT'] != 80 &&  $_SERVER['SERVER_PORT'] != "") {
								$port = ":".$_SERVER['SERVER_PORT'];
							}
							$http_type = "http://";
							$current_url = str_replace("//", "/", $_SERVER['SERVER_NAME'].$port.substr($split_request_uri[0], 0, strrpos($split_request_uri[0], "/"))."/");
						}
					} else {
						$http_type = "http://";
						$current_url = str_replace("//", "/", FORCE_SERVER_NAME.substr($split_request_uri[0], 0, strrpos($split_request_uri[0], "/"))."/");
					}
					
					// define the base URL of the website
					$my_base_url = "";
					$array_cwd = explode('/',  str_replace('\\', '/', getcwd()));
					$wsp_folder_name = $array_cwd[sizeof($array_cwd)-1];
					
					// Detect base URL with the root folder of wsp
					$array_current_url = explode('/', $current_url);
					for ($i=sizeof($array_current_url)-2; $i >= 0; $i--) {
						if ($array_current_url[$i] == $wsp_folder_name) {
							$my_base_url = $http_type;
							for ($j=0; $j <= $i; $j++) {
								$my_base_url .= $array_current_url[$j]."/";
							}
							break;
						}
					}
					if ($my_base_url == "") {
						if (!defined('FORCE_SERVER_NAME') || FORCE_SERVER_NAME == "") {
							// If not find root folder then test if there is an alias
							$array_script_name = explode('/', $_SERVER['SCRIPT_NAME']);
							unset($array_script_name[sizeof($array_script_name)-1]);
							$alias_path = implode('/', $array_script_name);
							if ($alias_path != "") { // Alias detected
								$my_base_url = $http_type.$array_current_url[0].$alias_path."/";
							} else { // No Alias detected
								$my_base_url = $http_type.$array_current_url[0]."/";
							}
						} else {
							if (strtoupper(substr(FORCE_SERVER_NAME, 0, 7)) == "HTTP://" || strtoupper(substr(FORCE_SERVER_NAME, 0, 8)) == "HTTPS://") {
								$my_base_url = FORCE_SERVER_NAME."/";
							} else {
								$my_base_url = $http_type.FORCE_SERVER_NAME."/";
							}
						}
					}
					$my_site_base_url = $my_base_url;
					
					header("Content-Type: text/html");
					
					echo "<html><head><title>Debug Error - ".utf8encode(SITE_NAME)."</title>\n";
					$jquery_style = "";
					if (DEFINE_STYLE_JQUERY != "") {
						$jquery_style = DEFINE_STYLE_JQUERY;
					}
					echo "<link type=\"text/css\" rel=\"StyleSheet\" href=\"".$my_site_base_url."combine-css/styles.php.css,angle.php.css,jquery".JQUERY_UI_VERSION."|".$jquery_style."|jquery-ui-".JQUERY_UI_VERSION.".custom.css";
					if (trim(CssInclude::getInstance()->getCssConfigFile()) != "") {
						echo "?conf_file=".CssInclude::getInstance()->getCssConfigFile();
					}
					echo "\" media=\"screen\" />\n";
					echo "<script type=\"text/javascript\" src=\"".$my_site_base_url."combine-js/jquery|jquery-".JQUERY_VERSION.".min.js,jquery|jquery-ui-".JQUERY_UI_VERSION.".custom.min.js,jquery.cookie.js,pngfix.js,utils.js\"></script>\n";
					echo "<script type=\"text/javascript\" src=\"".$my_site_base_url."combine-js/jquery.backstretch.min.js,jquery.cookie.js\"></script>\n";
					echo "<meta name=\"Robots\" content=\"noindex, nofollow\" />\n";
					echo "<base href=\"".$my_site_base_url."\" />\n";
					echo "</head><body>\n";
					echo $debug_page->render();
					if ($GLOBALS['__AJAX_LOAD_PAGE__'] == true && $GLOBALS['__AJAX_LOAD_PAGE_ID__'] != "") {
						echo "<script type=\"text/javascript\">\n";
						echo "launchJavascriptPage_".$GLOBALS['__AJAX_LOAD_PAGE_ID__']." = function() {\n";
						echo "	$('#idLoadPageLoadingPicture".$GLOBALS['__AJAX_LOAD_PAGE_ID__']."').attr('style', 'display:none;');\n";
						echo "	$('#idLoadPageContent".$GLOBALS['__AJAX_LOAD_PAGE_ID__']."').attr('style', 'display:block;');\n";
						echo "};\n";
						echo "	waitForJsScripts(".$GLOBALS['__AJAX_LOAD_PAGE_ID__'].");\n";
						echo "	LoadPngPicture();\n";
						echo "</script>\n";
					}
					echo "</body></html>\n";
				} catch (Exception $e) {
					echo $e->getMessage();
					NewException::sendErrorByMail($debug_msg);
				}
			} else {
				header('HTTP/1.1 500 Internal Server Error');
				if (defined('SEND_ERROR_BY_MAIL') && SEND_ERROR_BY_MAIL == true && !isLocalDebug()) {
						if (self::$trace !== false) { // standard msg "administrator is notified"
							echo __(ERROR_DEBUG_MAIL_SENT);
						} else { // no trace in the debug information
							echo utf8encode($debug_msg);
						}
				} else {
					echo utf8encode($debug_msg);
				}
				NewException::sendErrorByMail($debug_msg);
				exit;
			}
		}
    }
    
	/**
	 * Method sendErrorByMail
	 * @access static
	 * @param mixed $debug_msg 
	 * @param string $attachment_file 
	 * @param string $error_log_file [default value: error_send_by_mail.log]
	 * @param mixed $cache_time [default value: CacheFile::CACHE_TIME_2MIN]
	 * @since 1.0.100
	 */
    public static function sendErrorByMail($debug_msg, $attachment_file="", $error_log_file="error_send_by_mail.log", $cache_time=CacheFile::CACHE_TIME_2MIN) {
    	if (defined('SEND_ERROR_BY_MAIL') && SEND_ERROR_BY_MAIL == true && !isLocalDebug()) {
    			$caching_file = new CacheFile(dirname(__FILE__)."/../cache/".$error_log_file, $cache_time);
				if (($caching_file->readCache()) == false) {
					$debug_mail = $debug_msg;
					$page_object = Page::getInstance($_GET['p']);
					$debug_mail .= "<br/><b>General information:</b><br/>";
					$debug_mail .= "URL : ".$page_object->getCurrentUrl()."<br/>";
					$debug_mail .= "Referer : ".$page_object->getRefererURL()."<br/>";
					$debug_mail .= "IP : <a href='http://www.infosniper.net/index.php?ip_address=".$page_object->getRemoteIP()."' target='_blank'>".$page_object->getRemoteIP()."</a><br/>";
					$debug_mail .= "Browser : ";
					if (!isset($_SESSION['browser_info']) || $page_object->getBrowserName() == "Default Browser" || $page_object->getBrowserName() == "") {
						$debug_mail .= $page_object->getBrowserUserAgent();
					} else {
						$debug_mail .= $page_object->getBrowserName()." (version: ".$page_object->getBrowserVersion().")";
					}
					$debug_mail .= "<br/>";
					if (isset($_SESSION['browser_info'])) {
						$debug_mail .= "Crawler : ".($page_object->isCrawlerBot()?"true":"false")."<br/>";
					}
					
					$caching_file->writeCache($debug_mail);
					
					try {
						$mail = new SmtpMail(SEND_ERROR_BY_MAIL_TO, __(SEND_ERROR_BY_MAIL_TO), "ERROR on ".__(SITE_NAME)." !!!", __($debug_mail), SMTP_MAIL, __(SMTP_NAME));
						$mail->setPriority(SmtpMail::PRIORITY_HIGH);
						if ($attachment_file != "" && is_file($attachment_file)) {
							$mail->addAttachment($attachment_file, basename(str_replace(".cache", ".txt", $attachment_file)));
						}
						if (($send_result = $mail->send()) != true) {
							$caching_file->writeCache("Error when sent mail: ".$send_result."\nMail: ".$debug_mail);
							//echo $send_result;
						}
					} catch (Exception $e) {
						$caching_file->writeCache("\n\nMail sending error:\n".$e);
					}
					$caching_file->close();
				}
		}
    }
} 
?>
