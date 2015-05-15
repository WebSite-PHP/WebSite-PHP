<?php 
/**
 * PHP file wsp\class\modules\ContactForm\ContactForm.class.php
 * @package modules
 * @subpackage ContactForm
 */
/**
 * Class ContactForm
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2015 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package modules
 * @subpackage ContactForm
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 12/05/2015
 * @version     1.2.13
 * @access      public
 * @since       1.0.84
 */

class ContactForm extends WebSitePhpObject {
	/**#@+
	* @access private
	*/
	private $page_object = null;
	private $captcha = null;
	private $send_button = null;
	private $render = null;
	
	private $mail_to = "";
	private $mail_to_name = "";
	private $send_wait_mail = false;
	private $send_wait_mail_message = "";
	/**#@-*/
	
	/**
	 * Constructor ContactForm
	 * @param Page $page_object 
	 * @param string $send_method 
	 * @param string $table_style 
	 */
	function __construct($page_object, $send_method, $table_style='') {
		parent::__construct();
		
		if (!isset($page_object) || !isset($send_method)) {
			throw new NewException("2 arguments for ".get_class($this)."::__construct() are mandatory", 0, getDebugBacktrace(1));
		}
		
		if (gettype($page_object) != "object" || !is_subclass_of($page_object, "Page")) {
			throw new NewException("Argument page_object for ".get_class($this)."::__construct() error", 0, getDebugBacktrace(1));
		}
		
		$this->page_object = $page_object;
		$this->mail_to = SMTP_MAIL;
		$this->mail_to_name = SMTP_NAME;
		
		$table_main = new Table();
		$table_main->setClass($table_style);
		
		$form = new Form($this->page_object);
		
		$name = new TextBox($form, "contact_name");
		$name_validation = new LiveValidation();
		$name->setLiveValidation($name_validation->addValidatePresence()->setFieldName(__(CONTACTFORM_NAME)));
		$table_main->addRowColumns(__(CONTACTFORM_NAME).":&nbsp;", $name->setFocus())->setColumnWidth(2, "100%");
		
		$email = new TextBox($form, "contact_email");
		$email_validation = new LiveValidation();
		$email->setLiveValidation($email_validation->addValidateEmail()->addValidatePresence()->setFieldName(__(CONTACTFORM_EMAIL)));
		$table_main->addRowColumns(__(CONTACTFORM_EMAIL).":&nbsp;", $email);
		
		$subject = new TextBox($form, "contact_subject");
		$subject_validation = new LiveValidation();
		$subject->setLiveValidation($subject_validation->addValidatePresence()->setFieldName(__(CONTACTFORM_SUBJECT)));
		$table_main->addRowColumns(__(CONTACTFORM_SUBJECT).":&nbsp;", $subject);
		
		$table_main->addRow();
		$editor = new Editor($form, "contact_message");
		$editor_validation = new LiveValidation();
		$editor->setLiveValidation($editor_validation->addValidatePresence()->setFieldName(__(CONTACTFORM_MESSAGE)));
		$editor->setToolbar(Editor::TOOLBAR_SIMPLE);
		$table_main->addRow(new Object(__(CONTACTFORM_MESSAGE).": ", "<br/>", $editor))->setColspan(3)->setAlign(RowTable::ALIGN_LEFT);
		$table_main->addRow();
		$this->captcha = new Captcha($form, "contact_captcha");
		$table_main->addRow($this->captcha)->setColspan(3);
		$table_main->addRow();
		
		$this->send_button = new Button($form, "contact_send", "", __(CONTACTFORM_SEND));
		$this->send_button->assignEnterKey()->onClick($send_method)->setAjaxEvent();
		$table_main->addRow($this->send_button)->setColspan(3);
		$table_main->addRow();
		
		$form->setContent($table_main);
		$this->render = $form;
	}
	
	/**
	 * Method getContactName
	 * @access public
	 * @return string
	 * @since 1.0.35
	 */
	public function getContactName() {
		return $this->page_object->getObjectValue("contact_name");
	}
	
	/**
	 * Method getContactEmail
	 * @access public
	 * @return string
	 * @since 1.0.35
	 */
	public function getContactEmail() {
		return $this->page_object->getObjectValue("contact_email");
	}
	
	/**
	 * Method getContactSubject
	 * @access public
	 * @return string
	 * @since 1.0.35
	 */
	public function getContactSubject() {
		return $this->page_object->getObjectValue("contact_subject");
	}
	
	/**
	 * Method getContactMessage
	 * @access public
	 * @return string
	 * @since 1.0.35
	 */
	public function getContactMessage() {
		return $this->page_object->getObjectValue("contact_message");
	}
	
	/**
	 * Method setMailTo
	 * @access public
	 * @param string $mail_to 
	 * @param string $mail_to_name 
	 * @return ContactForm
	 * @since 1.0.71
	 */
	public function setMailTo($mail_to, $mail_to_name='') {
		$this->mail_to = $mail_to;
		if ($mail_to_name != '') {
			$this->mail_to_name = $mail_to_name;
		}
		return $this;
	}
	
	/**
	 * Method activateSendWaitMail
	 * @access public
	 * @param string $message 
	 * @return ContactForm
	 * @since 1.0.71
	 */
	public function activateSendWaitMail($message='') {
		$this->send_wait_mail = true;
		$this->send_wait_mail_message = $message;
		return $this;
	}
	
	/**
	 * Method sendMail
	 * @access public
	 * @since 1.0.59
	 */
	public function sendMail() {
		if (!$this->captcha->check()) {
			$this->captcha->forceObjectChange();
			$dialog = new DialogBox(__(ERROR), __(ERROR_CAPTCHA));
			$this->page_object->addObject($dialog->activateCloseButton());
		} else {
			try {
				$message = __(CONTACTFORM_NAME).": ".utf8encode($this->getContactName())."<br/>".__(CONTACTFORM_EMAIL).": ".$this->getContactEmail()."<br/>".__(CONTACTFORM_SUBJECT).": ".utf8encode($this->getContactSubject())."<br/><br/>".__(CONTACTFORM_MESSAGE).": <br/>".utf8encode($this->getContactMessage());
				$mail = new SmtpMail($this->mail_to, __($this->mail_to_name), __(SITE_NAME)." : ".utf8encode($this->getContactSubject()), $message, $this->getContactEmail(), utf8encode($this->getContactName()));
				if(!$mail->Send()) {
					$dialog = new DialogBox(__(CONTACTFORM_MAIL)." ".__(ERROR), $mail->getErrorInfo());
					$this->page_object->addObject($dialog->activateCloseButton());
				} else {
					if ($this->send_wait_mail) {
						if ($this->send_wait_mail_message == "") {
							$this->send_wait_mail_message = __(CONTACTFORM_SEND_WAIT_MAIL_MESSAGE, $this->getContactName(), __(SITE_NAME), $this->mail_to_name);
						}
						$wait_mail = new SmtpMail($this->getContactEmail(), utf8encode($this->getContactName()), __(SITE_NAME), utf8encode($this->send_wait_mail_message), $this->mail_to, utf8encode($this->mail_to_name));
						$wait_mail->Send();
					}
					$dialog = new DialogBox(__(CONTACTFORM_MAIL), __(CONTACTFORM_MAIL_SENT));
					$this->page_object->addObject($dialog->activateCloseButton());
					$this->page_object->forceObjectsDefaultValues();
				}
			} catch (Exception $ex) {
				$dialog = new DialogBox(__(ERROR), __(ERROR).": ".$ex->getMessage());
				$this->page_object->addObject($dialog->activateCloseButton());
			}
		}
	}
	
	/**
	 * Method render
	 * @access public
	 * @param boolean $ajax_render [default value: false]
	 * @return string html code of object ContactForm
	 * @since 1.0.35
	 */
	public function render($ajax_render=false) {
		return $this->render->render();
	}
}
?>
