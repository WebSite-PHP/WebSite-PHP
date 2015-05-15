<?php 
/**
 * PHP file wsp\class\modules\Payment\PaypalBuyCheck.class.php
 * @package modules
 * @subpackage Payment
 */
/**
 * Class PaypalBuyCheck
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

class PaypalBuyCheck {
	private $amount = 0;
	private $business_paypal_account = "@";
	
	private $is_sandbox = false;
	private $log_filepath = "";
	
	/**
	 * Constructor PaypalBuyCheck
	 * @param mixed $amount 
	 * @param mixed $business_paypal_account 
	 */
	function __construct($amount, $business_paypal_account) {
		if (!isset($amount) || !isset($business_paypal_account)) {
			throw new NewException("2 arguments for ".get_class($this)."::__construct() are mandatories", 0, getDebugBacktrace(1));
		}

		if (!is_numeric($amount)) {
			throw new NewException(get_class($this)." error: \$amount need to be numeric.", 0, getDebugBacktrace(1));
		}
		
		$this->amount = $amount;
		$this->business_paypal_account = $business_paypal_account;
		
		if (!extension_loaded("curl")) {
			throw new NewException("PaypalBuyCheck: You need to install PHP lib CURL.", 0, getDebugBacktrace(1));
		}
	}
	
	/**
	 * Method enableSandbox
	 * @access public
	 * @return PaypalBuyCheck
	 * @since 1.2.10
	 */
	public function enableSandbox() {
		$this->is_sandbox = true;
		return $this;
	}
	
	/**
	 * Method activateCheckLog
	 * @access public
	 * @param mixed $log_filepath 
	 * @return PaypalBuyCheck
	 * @since 1.2.10
	 */
	public function activateCheckLog($log_filepath) {
		$this->log_filepath = $log_filepath;
		return $this;
	}
	
	/**
	 * Method check
	 * @access public
	 * @return mixed
	 * @since 1.2.10
	 */
	public function check() {
		// Send Paypal information
		$req = "cmd=_notify-validate";
		foreach ($_POST as $key => $value) {
			$value = urlencode(stripslashes($value));
			$req.= "&$key=$value";
		}
		
		$url = $this->is_sandbox?PaypalBuyButton::PAYPAL_SANDBOX_URL : PaypalBuyButton::PAYPAL_PROD_URL;
		
		$fp = curl_init($url);
		curl_setopt($fp, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		curl_setopt($fp, CURLOPT_POST, 1);
		curl_setopt($fp, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($fp, CURLOPT_POSTFIELDS, $req);
		curl_setopt($fp, CURLOPT_SSL_VERIFYPEER, 1);
		curl_setopt($fp, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($fp, CURLOPT_FORBID_REUSE, 1);
		curl_setopt($fp, CURLOPT_HTTPHEADER, array('Connection: Close'));
		 
		if( !($res = curl_exec($fp)) ) {
			curl_close($fp);
			return false;
		}
		curl_close($fp);

		if ($this->log_filepath != "") {
			$debug = new File($this->log_filepath);
			$debug->write("*****".date("Y-m-d H:i:s")."*****\n");
			$debug->write($req."\n\n");
			$debug->write(print_r($res, true)."\n\n");
			$debug->write(print_r($_POST, true)."\n\n");
			$debug->close();
		}
		
		$status = false;
		$status_error = "";
		// Valid payment
		if (strcmp(trim($res), "VERIFIED") == 0) {
			// check if the status is completed
			if ($_POST['payment_status'] == "Completed") {
				// check business paypal account
				if ($this->business_paypal_account == $_POST['receiver_email']) {
					// Check the amount
					if ($_POST['mc_gross'] == $this->amount) {
						$status = true;
					} else {
						$status_error = "Incorrect amount";
					}
				} else {
					$status_error = "Incorrect business paypal account";
				}
			} else {
				$status_error = "Inavalid payment status";
			}
		} else {
			$status_error = "Inavalid payment";
		}
		
		if ($this->log_filepath != "") {
			$debug = new File($this->log_filepath);
			$debug->write("Status: ".($status?"OK":"ERROR").($status_error!=""?" (".$status_error.")":"")."\n\n");
			$debug->close();
		}
		return $status;
	}
}
?>
