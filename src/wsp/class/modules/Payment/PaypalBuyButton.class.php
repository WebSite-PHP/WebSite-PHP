<?php 
/**
 * PHP file wsp\class\modules\Payment\PaypalBuyButton.class.php
 * @package modules
 * @subpackage Payment
 */
/**
 * Class PaypalBuyButton
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2015 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package modules
 * @subpackage Payment
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 12/05/2015
 * @version     1.2.13
 * @access      public
 * @since       1.2.10
 */

/*
 * To use this object :
 * 1- Create a paypal developer account: https://developer.paypal.com/
 * 2- Create test accounts (business and personal): https://developer.paypal.com/webapps/developer/applications/accounts
 * 3- Configure business account: https://www.sandbox.paypal.com/fr/webapps/mpp/accueil-professionnel
 * 		* go to Profile>Website Payment Preferences
 * 		* Turn on Auto Return
 * 		* Set the return URL to http://<your website>/en/my-page.html
 */
class PaypalBuyButton extends WebSitePhpObject {
	const PAYPAL_SANDBOX_URL = "https://www.sandbox.paypal.com/cgi-bin/webscr";
	const PAYPAL_PROD_URL = "https://www.paypal.com/cgi-bin/webscr";

	private $amount = 0;
	private $vat_amount = 0;
	private $currency_code = "EUR";
	private $return_url = BASE_URL;
	private $cancel_url = BASE_URL;
	private $notify_url = BASE_URL;
	private $business_paypal_account = "@";
	private $command_number = 0;
	private $item_name = SITE_NAME;
	private $shipping = 0;
	
	private $form;
	private $buy_btn;
	private $buy_button_value = "";
	private $is_sandbox = false;
	
	/**
	 * Constructor PaypalBuyButton
	 * @param mixed $amount 
	 * @param mixed $vat_amount 
	 * @param mixed $currency_code 
	 * @param mixed $return_url 
	 * @param mixed $cancel_url 
	 * @param mixed $notify_url 
	 * @param mixed $business_paypal_account 
	 * @param mixed $command_number 
	 * @param mixed $item_name [default value: SITE_NAME]
	 * @param double $shipping [default value: 0]
	 */
	function __construct($amount, $vat_amount, $currency_code, $return_url, $cancel_url, $notify_url, $business_paypal_account, $command_number, $item_name=SITE_NAME, $shipping=0) {
		parent::__construct();
		
		if (!isset($amount) || !isset($vat_amount) || !isset($currency_code) || !isset($return_url) || !isset($cancel_url) || !isset($notify_url) || !isset($business_paypal_account) || !isset($command_number)) {
			throw new NewException("8 arguments for ".get_class($this)."::__construct() are mandatories", 0, getDebugBacktrace(1));
		}

		if (!is_numeric($amount)) {
			throw new NewException(get_class($this)." error: \$amount need to be numeric.", 0, getDebugBacktrace(1));
		}
		if (!is_numeric($vat_amount)) {
			throw new NewException(get_class($this)." error: \$vat_amount need to be numeric.", 0, getDebugBacktrace(1));
		}
		
		$this->amount = $amount;
		$this->vat_amount = $vat_amount;
		$this->currency_code = $currency_code;
		$this->return_url = (get_class($return_url) == "Url"?$return_url->render():$return_url);
		$this->cancel_url = (get_class($cancel_url) == "Url"?$cancel_url->render():$cancel_url);
		$this->notify_url = (get_class($notify_url) == "Url"?$notify_url->render():$notify_url);

		if (strtoupper(substr($this->return_url, 0, 7)) != "HTTP://" && strtoupper(substr($this->return_url, 0, 8)) != "HTTPS://") {
			throw new NewException(get_class($this)." error: \$return_url need to be a valid URL.", 0, getDebugBacktrace(1));
		}
		if (strtoupper(substr($this->cancel_url, 0, 7)) != "HTTP://" && strtoupper(substr($this->cancel_url, 0, 8)) != "HTTPS://") {
			throw new NewException(get_class($this)." error: \$cancel_url need to be a valid URL.", 0, getDebugBacktrace(1));
		}
		if (strtoupper(substr($this->notify_url, 0, 7)) != "HTTP://" && strtoupper(substr($this->notify_url, 0, 8)) != "HTTPS://") {
			throw new NewException(get_class($this)." error: \$notify_url need to be a valid URL.", 0, getDebugBacktrace(1));
		}
		
		$this->business_paypal_account = $business_paypal_account;
		$this->command_number = $command_number;
		$this->item_name = $item_name;
		$this->shipping = $shipping;
		
		$this->form = new Form($this->getPage(), "paypal_form");
		$this->buy_button_value = __(PAYPAL_BUY_BUTTON_VALUE);
		$this->buy_btn = new Button($this->form, "paypal_button");
		$this->buy_btn->setValue($this->buy_button_value);
		$this->buy_btn->onClickJs(new JavaScript("$('#".$this->buy_btn->getId()."');"));
	}
	
	/**
	 * Method setAmount
	 * @access public
	 * @param mixed $amount 
	 * @return PaypalBuyButton
	 * @since 1.2.10
	 */
	public function setAmount($amount) {
		if (!is_numeric($amount)) {
			throw new NewException(get_class($this)." error: \$amount need to be numeric.", 0, getDebugBacktrace(1));
		}
		$this->amount = $amount;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setVATAmount
	 * @access public
	 * @param mixed $vat_amount 
	 * @return PaypalBuyButton
	 * @since 1.2.10
	 */
	public function setVATAmount($vat_amount) {
		if (!is_numeric($vat_amount)) {
			throw new NewException(get_class($this)." error: \$vat_amount need to be numeric.", 0, getDebugBacktrace(1));
		}
		$this->vat_amount = $vat_amount;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setPaylpalBuyButtonValue
	 * @access public
	 * @param mixed $buy_button_value 
	 * @return PaypalBuyButton
	 * @since 1.2.10
	 */
	public function setPaylpalBuyButtonValue($buy_button_value) {
		$this->buy_button_value = $buy_button_value;
		$this->buy_btn->setValue($this->buy_button_value);
		return $this;
	}
	
	/**
	 * Method enableSandbox
	 * @access public
	 * @return PaypalBuyButton
	 * @since 1.2.10
	 */
	public function enableSandbox() {
		$this->is_sandbox = true;
		return $this;
	}
	
	/**
	 * Method getPaylpalBuyButton
	 * @access public
	 * @return mixed
	 * @since 1.2.10
	 */
	public function getPaylpalBuyButton() {
		return $this->buy_btn;
	}
	
	/**
	 * Method render
	 * @access public
	 * @return mixed
	 * @since 1.2.10
	 */
	public function render() {
		$paypal_obj = new Object();
		$this->form->setAction($this->is_sandbox?PaypalBuyButton::PAYPAL_SANDBOX_URL : PaypalBuyButton::PAYPAL_PROD_URL);
		$this->form->onSubmitJs("");
		$amount = new Hidden($this->form);
		$amount->setNotWspObjectName("amount")->setValue($this->amount); // HT amount
		$currency_code = new Hidden($this->form);
		$currency_code->setNotWspObjectName("currency_code")->setValue($this->currency_code); // Currency
		$shipping = new Hidden($this->form);
		$shipping->setNotWspObjectName("shipping")->setValue($this->shipping); // frais de transport
		$tax = new Hidden($this->form);
		if ($this->vat_amount > 0) {
			$tax->setNotWspObjectName("tax")->setValue($this->vat_amount);
		}
		$return = new Hidden($this->form);
		$return->setNotWspObjectName("return")->setValue($this->return_url);
		$cancel_return = new Hidden($this->form);
		$cancel_return->setNotWspObjectName("cancel_return")->setValue($this->cancel_url);
		$notify_url = new Hidden($this->form);
		$notify_url->setNotWspObjectName("notify_url")->setValue($this->notify_url);
		$cmd = new Hidden($this->form);
		$cmd->setNotWspObjectName("cmd")->setValue("_xclick");
		$business = new Hidden($this->form);
		$business->setNotWspObjectName("business")->setValue($this->business_paypal_account);
		$item_name = new Hidden($this->form);
		$item_name->setNotWspObjectName("item_name")->setValue($this->item_name);
		$no_note = new Hidden($this->form);
		$no_note->setNotWspObjectName("no_note")->setValue(1);
		$lc = new Hidden($this->form);
		$lc->setNotWspObjectName("lc")->setValue($this->getPage()->getLanguage());
		$bn = new Hidden($this->form);
		$bn->setNotWspObjectName("bn")->setValue("PP-BuyNowBF");
		$charset = new Hidden($this->form);
		$charset->setNotWspObjectName("charset")->setValue("utf-8");
		$custom = new Hidden($this->form);
		$custom->setNotWspObjectName("custom")->setValue($this->command_number);
		
		$paypal_obj->add($this->buy_btn);
		
		$paypal_obj->add($amount, $currency_code, $shipping, $tax, $return, $cancel_return, $notify_url, $cmd, $business, $item_name, $no_note, $lc, $bn, $charset, $custom);
		
		$this->form->setContent($paypal_obj);
		return $this->form->render();
	}
	
	/**
	 * Method getAjaxRender
	 * @access public
	 * @return string javascript code to update initial html of object PaypalBuyButton (call with AJAX)
	 * @since 1.2.10
	 */
	public function getAjaxRender() {
		$html = "";
		if ($this->object_change && !$this->is_new_object_after_init) {
			$this->getPage()->addObject(new JavaScript("$('#amount').val(".$this->amount.");"), false, true);
			$this->getPage()->addObject(new JavaScript("$('#tax').val(".$this->vat_amount.");"), false, true);
			$this->getPage()->addObject(new JavaScript("$('#".$this->getPaylpalBuyButton()->getId()."').click(function() { $('#".$this->form->getId()."').submit(); } );"), false, true);
			$this->object_change = false;
		}
		return $html;
	}
}
?>
