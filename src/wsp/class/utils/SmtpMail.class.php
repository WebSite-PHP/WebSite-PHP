<?php
/**
 * PHP file wsp\class\utils\SmtpMail.class.php
 * @package utils
 */
/**
 * Class SmtpMail
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2015 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package utils
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 12/05/2015
 * @version     1.2.13
 * @access      public
 * @since       1.0.16
 */

// PHP Mailer
require("wsp/includes/PHP-Mailer/class.phpmailer.php"); 

class SmtpMail {
	/**#@+
	* Priority level
	* @access public
	* @var string
	*/
	const PRIORITY_LOW = "5";
	const PRIORITY_NORMAL = "3";
	const PRIORITY_HIGH = "1";
	/**#@-*/
	
	/**#@+
	* @access private
	*/
	private $to = array();
	private $subject = "";
	private $message = "";
	private $from_mail = "";
	private $from_name = "";
	private $attachement = array();
	private $attachement_name = array();
	private $smtp_object = null;
	private $priority_level = 3;
	/**#@-*/
	
	/**
	 * Constructor SmtpMail
	 * @param mixed $to_mail 
	 * @param mixed $to_name 
	 * @param mixed $subject 
	 * @param mixed $message 
	 * @param string $from_mail 
	 * @param string $from_name 
	 */
	function __construct($to_mail, $to_name, $subject, $message, $from_mail='', $from_name='') {
		if (!isset($to_mail) || !isset($to_name) || !isset($subject) || !isset($message)) {
			throw new NewException("4 arguments for ".get_class($this)."::__construct() are mandatory", 0, getDebugBacktrace(1));
		}
		
		$this->addAddress($to_mail, $to_name);
		$this->subject = $subject;
		$this->message = $message;
		if ($from_mail == "") {
			$this->from_mail = SMTP_MAIL;
		} else {
			$this->from_mail = $from_mail;
		}
		if ($from_name == "") {
			$this->from_name = SMTP_NAME;
		} else {
			$this->from_name = $from_name;
		}
	}
	
	/**
	 * Method setPriority
	 * @access public
	 * @param mixed $priority_level 
	 * @return SmtpMail
	 * @since 1.0.100
	 */
	public function setPriority($priority_level) {
		$this->priority_level = $priority_level;
		return $this;
	}
	
	/**
	 * Method addAttachment
	 * @access public
	 * @param mixed $file_path 
	 * @param string $file_name 
	 * @return SmtpMail
	 * @since 1.0.35
	 */
	public function addAttachment($file_path, $file_name="") {
		if (file_exists($file_path)) {
			$this->attachement[] = $file_path;
			if ($file_name == "") {
				$this->attachement_name[] = basename($file_path);
			} else {
				$this->attachement_name[] = $file_name;
			}
		} else {
			throw new NewException("SmtpMail Error: File not found ".$file_path, 0, getDebugBacktrace(1));
		}
		return $this;
	}
	
	/**
	 * Method addAddress
	 * @access public
	 * @param mixed $to_mail 
	 * @param mixed $to_name 
	 * @return SmtpMail
	 * @since 1.0.35
	 */
	public function addAddress($to_mail, $to_name) {
		$ind = sizeof($this->to);
		$this->to[$ind] = array();
		$this->to[$ind]['mail'] = $to_mail;
		$this->to[$ind]['name'] = $to_name;
		return $this;
	}
	
	/**
	 * Method getErrorInfo
	 * @access public
	 * @return mixed
	 * @since 1.0.35
	 */
	public function getErrorInfo() {
		if ($this->smtp_object != null) {
			return $this->smtp_object->ErrorInfo;
		} else {
			return "";
		}
	}
	
	/**
	 * Method send
	 * @access public
	 * @return boolean
	 * @since 1.0.35
	 */
	public function send() {
		$this->smtp_object = new PHPMailer();
		
		$this->smtp_object->IsSMTP();  // telling the class to use SMTP
		$this->smtp_object->SMTPAuth = SMTP_AUTH; // turn on SMTP authentication
		$this->smtp_object->Host     = SMTP_HOST; // SMTP server
		$this->smtp_object->Port     = SMTP_PORT;
		$this->smtp_object->CharSet  = 'UTF-8';
		
		$this->smtp_object->Username = SMTP_USER; // SMTP username
		$this->smtp_object->Password = SMTP_PASS; // SMTP password
		
		$this->smtp_object->From = $this->from_mail;
		$this->smtp_object->FromName = $this->from_name;
		$this->smtp_object->AddReplyTo($this->from_mail, $this->from_name);
		
		for ($i=0; $i < sizeof($this->to); $i++) {
			$this->smtp_object->AddAddress($this->to[$i]['mail'], $this->to[$i]['name']);
		}
		
		$this->smtp_object->WordWrap = 50; // set word wrap
		
		for ($i=0; $i < sizeof($this->attachement); $i++) {
			$this->smtp_object->AddAttachment($this->attachement[$i], $this->attachement_name[$i]); // attachment
		}
		$this->smtp_object->Priority = $this->priority_level;
		$this->smtp_object->IsHTML(true); // send as HTML
		$this->smtp_object->Subject = $this->subject;
		
		$html_message = $this->message;
		$h2t =& new html2text($html_message);
		$text_message = $h2t->get_text();
		$this->smtp_object->AltBody = $text_message; //Text Body
		$this->smtp_object->Body = $html_message; //HTML Body
		
		if (!$this->smtp_object->Send()) {
			return $this->smtp_object->ErrorInfo;
		} else {
			return true;
		}
	}
}
?>
