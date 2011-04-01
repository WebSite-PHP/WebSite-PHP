<?php 
/**
 * PHP file wsp\class\display\advanced_object\ContactForm.class.php
 * @package display
 * @subpackage advanced_object
 */
/**
 * Class ContactForm
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2011 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package display
 * @subpackage advanced_object
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 22/10/2010
 * @version     1.0.68
 * @access      public
 * @since       1.0.17
 */

class ContactForm extends WebSitePhpObject {
	/**#@+
	* @access private
	*/
	private $page_object = null;
	private $captcha = null;
	private $send_button = null;
	private $render = null;
	/**#@-*/
	
	/**
	 * Constructor ContactForm
	 * @param mixed $page_object 
	 * @param mixed $send_method 
	 * @param mixed $table_style 
	 * @param mixed $button_class 
	 */
	function __construct($page_object, $send_method, $table_style, $button_class) {
		parent::__construct();
		
		if (!isset($page_object) || !isset($send_method) || !isset($table_style)) {
			throw new NewException("3 arguments for ".get_class($this)."::__construct() are mandatory", 0, 8, __FILE__, __LINE__);
		}
		
		if (gettype($page_object) != "object" || !is_subclass_of($page_object, "Page")) {
			throw new NewException("Argument page_object for ".get_class($this)."::__construct() error", 0, 8, __FILE__, __LINE__);
		}
		
		$this->page_object = $page_object;
		
		$table_main = new Table();
		$table_main->setClass($table_style);
		
		$form = new Form($this->page_object);
		
		$name = new TextBox($form, "contact_name");
		$name_validation = new LiveValidation();
		$name->setLiveValidation($name_validation->addValidatePresence()->setFieldName(__(CONTACT_NAME)));
		$table_main->addRowColumns(__(CONTACT_NAME).":&nbsp;", $name->setFocus())->setColumnWidth(2, "100%");
		
		$email = new TextBox($form, "contact_email");
		$email_validation = new LiveValidation();
		$email->setLiveValidation($email_validation->addValidateEmail()->addValidatePresence()->setFieldName(__(CONTACT_EMAIL)));
		$table_main->addRowColumns(__(CONTACT_EMAIL).":&nbsp;", $email);
		
		$subject = new TextBox($form, "contact_subject");
		$subject_validation = new LiveValidation();
		$subject->setLiveValidation($subject_validation->addValidatePresence()->setFieldName(__(CONTACT_SUBJECT)));
		$table_main->addRowColumns(__(CONTACT_SUBJECT).":&nbsp;", $subject);
		
		$table_main->addRow();
		$editor = new Editor($form, "contact_message");
		$editor_validation = new LiveValidation();
		$editor->setLiveValidation($editor_validation->addValidatePresence()->setFieldName(__(CONTACT_MESSAGE)));
		$editor->setToolbar(Editor::TOOLBAR_SIMPLE);
		$table_main->addRow(new Object(__(CONTACT_MESSAGE).": ", "<br/>", $editor))->setColspan(3)->setAlign(RowTable::ALIGN_LEFT);
		$table_main->addRow();
		$this->captcha = new Captcha($form, "contact_captcha");
		$table_main->addRow($this->captcha)->setColspan(3);
		$table_main->addRow();
		
		$this->send_button = new Button($form, "contact_send", "", __(CONTACT_SEND));
		if ($button_class != '') {
			$this->send_button->setClass($button_class);
		}
		$this->send_button->assignEnterKey()->onClick($send_method)->setAjaxEvent();
		$table_main->addRow($this->send_button)->setColspan(3);
		$table_main->addRow();
		
		$form->setContent($table_main);
		$this->render = $form;
	}
	
	/**
	 * Method getContactName
	 * @access public
	 * @return mixed
	 * @since 1.0.35
	 */
	public function getContactName() {
		return $this->page_object->getObjectValue("contact_name");
	}
	
	/**
	 * Method getContactEmail
	 * @access public
	 * @return mixed
	 * @since 1.0.35
	 */
	public function getContactEmail() {
		return $this->page_object->getObjectValue("contact_email");
	}
	
	/**
	 * Method getContactSubject
	 * @access public
	 * @return mixed
	 * @since 1.0.35
	 */
	public function getContactSubject() {
		return $this->page_object->getObjectValue("contact_subject");
	}
	
	/**
	 * Method getContactMessage
	 * @access public
	 * @return mixed
	 * @since 1.0.35
	 */
	public function getContactMessage() {
		return $this->page_object->getObjectValue("contact_message");
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
			$message = "Email: ".$this->getContactEmail()."<br/><br/>".$this->getContactMessage();
			$mail = new SmtpMail(SMTP_MAIL, SMTP_NAME, SITE_NAME." : ".$this->getContactSubject(), $message, $this->getContactEmail(), $this->getContactName());
			if(!$mail->Send()) {
				$dialog = new DialogBox(__(MAIL)." ".__(ERROR), $mail->getErrorInfo());
				$this->page_object->addObject($dialog->activateCloseButton());
			} else {
				$dialog = new DialogBox(__(MAIL), __(MAIL_SENT));
				$this->page_object->addObject($dialog->activateCloseButton());
				$this->page_object->forceObjectsDefaultValues();
			}
		}
	}
	
	/**
	 * Method render
	 * @access public
	 * @param boolean $ajax_render [default value: false]
	 * @return mixed
	 * @since 1.0.35
	 */
	public function render($ajax_render=false) {
		return $this->render->render();
	}
}
?>
