<?php
/**
 * PHP file wsp\class\utils\EncryptDataWspObject.class.php
 * @package utils
 */
/**
 * Class EncryptDataWspObject
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
 * @since       1.0.67
 */

class EncryptDataWspObject {
	/**#@+
	* @access private
	*/
	private $object = null;
	private $passphrase = "passphrase";
	private $private_key_bits = 1024;
	private $private_key_type = OPENSSL_KEYTYPE_RSA;
	private $encrypte_key = true;
	/**#@-*/
	
	/**
	 * Constructor EncryptDataWspObject
	 * @param string $passphrase [default value: passphrase]
	 * @param integer $private_key_bits [default value: 1024]
	 * @param mixed $private_key_type [default value: OPENSSL_KEYTYPE_RSA]
	 * @param boolean $encrypte_key [default value: true]
	 */
	function __construct($passphrase='passphrase', $private_key_bits=1024, $private_key_type=OPENSSL_KEYTYPE_RSA, $encrypte_key=true) {
		if (!extension_loaded('openssl')) {
			throw new NewException("Please activate openssl php lib, to use ".get_class($this)." object.", 0, getDebugBacktrace(1));
		}
		
		$this->passphrase = url_rewrite_format($passphrase);
		$this->private_key_bits = $private_key_bits;
		$this->private_key_type = $private_key_type;
		$this->encrypte_key = $encrypte_key;
		
	}
	
	/* Intern management of EncryptDataWspObject */
	/**
	 * Method setObject
	 * @access public
	 * @param WebSitePhpObject|WebSitePhpEventObject $object 
	 * @since 1.0.67
	 */
	public function setObject($object) {
		if (!is_subclass_of($object, "WebSitePhpObject") && !is_subclass_of($object, "WebSitePhpEventObject")) {
			throw new NewException(get_class($this)."->setObject() error: \$object must be a WebSitePhpObject object", 0, getDebugBacktrace(1));
		}
		$this->object = $object;
		
		if ($this->getPublicKey() == null) {
			if (($keys = createKeys($this->passphrase, $this->private_key_bits, $this->private_key_type, $this->encrypte_key)) != null) {
				ContextSession::add($this->object->getId()."_".$this->passphrase."_privatekey".$this->private_key_bits, $keys['private']);
				ContextSession::add($this->object->getId()."_".$this->passphrase."_publickey".$this->private_key_bits, $keys['public']);
			}
		}
	}
	
	/**
	 * Method getPublicKey
	 * @access public
	 * @return string
	 * @since 1.0.67
	 */
	public function getPublicKey() {
		if ($this->object == null) {
			throw new NewException(get_class($this)."->getPublicKey() error: unknow object", 0, getDebugBacktrace(1));
		}
		$public_key = ContextSession::get($this->object->getId()."_".$this->passphrase."_publickey".$this->private_key_bits);
		return ($public_key==""?null:$public_key);
	}
	
	/**
	 * Method getPrivateKey
	 * @access private
	 * @return string
	 * @since 1.0.67
	 */
	private function getPrivateKey() {
		if ($this->object == null) {
			throw new NewException(get_class($this)."->getPrivateKey() error: unknow object", 0, getDebugBacktrace(1));
		}
		$private_key = ContextSession::get($this->object->getId()."_".$this->passphrase."_privatekey".$this->private_key_bits);
		return ($private_key==""?null:$private_key);
	}
	
	/**
	 * Method getPublicKeyBits
	 * @access public
	 * @return mixed
	 * @since 1.0.102
	 */
	public function getPublicKeyBits() {
		return $this->private_key_bits;
	}
	
	/**
	 * Method decrypt
	 * @access public
	 * @param mixed $data 
	 * @return string
	 * @since 1.0.67
	 */
	public function decrypt($data) {
		if ($this->object == null) {
			throw new NewException(get_class($this)."->decrypt() error: unknow object", 0, getDebugBacktrace(1));
		}
		return decryptMessage($data, $this->getPrivateKey(), $this->passphrase);
	}
}
?>
