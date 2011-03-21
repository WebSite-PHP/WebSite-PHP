<?php
/**
 * PHP file wsp\class\utils\SmtpMail.class.php
 * @package utils
 */
/**
 * Class SmtpMail
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2011 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package utils
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 03/10/2010
 * @version     1.0.62
 * @access      public
 * @since       1.0.16
 */

class SmtpMail {
	/**#@+
	* @access private
	*/
	private $to = array();
	private $subject = "";
	private $message = "";
	private $from_mail = "";
	private $from_name = "";
	private $attachement = array();
	private $smtp_object = null;
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
			throw new NewException("4 arguments for ".get_class($this)."::__construct() are mandatory", 0, 8, __FILE__, __LINE__);
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
	 * Method addAttachment
	 * @access public
	 * @param mixed $file 
	 * @return SmtpMail
	 * @since 1.0.35
	 */
	public function addAttachment($file) {
		if (file_exists($file)) {
			$this->attachement[] = $file;
		} else {
			throw new NewException("SmtpMail Error: File not found ".$file, 0, 8, __FILE__, __LINE__);
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
	 * @return mixed
	 * @since 1.0.35
	 */
	public function send() {
		$this->smtp_object = new PHPMailer(true);
		
		$this->smtp_object->IsSMTP();  // telling the class to use SMTP
		$this->smtp_object->SMTPAuth = SMTP_AUTH; // turn on SMTP authentication
		$this->smtp_object->Host     = SMTP_HOST; // SMTP server
		$this->smtp_object->Port     = SMTP_PORT;
		
		$this->smtp_object->Username = SMTP_USER; // SMTP username
		$this->smtp_object->Password = SMTP_PASS; // SMTP password
		
		$this->smtp_object->From = $this->from_mail;
		$this->smtp_object->FromName = $this->from_name;
		$this->smtp_object->AddReplyTo($this->from_mail, $this->from_name);
		
		for ($i=0; $i < sizeof($this->to); $i++) {
			$this->smtp_object->AddAddress($this->to[$i]['mail'], $this->to[$i]['name']);
		}
		
		$this->smtp_object->WordWrap = 50; // set word wrap
		
		for ($i=0; $i < sizeof($attachement); $i++) {
			$this->smtp_object->AddAttachment($attachement[$i]); // attachment
		}
		
		$this->smtp_object->IsHTML(true); // send as HTML
		$this->smtp_object->Subject = $this->subject;
		
		$html_message = $this->message;
		$h2t =& new html2text($html_message);
		$text_message = $h2t->get_text();
		$this->smtp_object->AltBody = $text_message; //Text Body
		$this->smtp_object->Body = $html_message; //HTML Body
		
		return $this->smtp_object->Send();
	}
}
?>
