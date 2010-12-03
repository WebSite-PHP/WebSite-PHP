<?php
class ContextSession {
	
	public static function add($key, $string_or_object) {
		if (!is_array($_SESSION['wsp_context_session'])) {
			$_SESSION['wsp_context_session'] = array();
		}
		if (gettype($string_or_object) == "object" || gettype($string_or_object) == "array") {
			$_SESSION['wsp_context_session'][$key] = array('serialize' => true, 'value' => serialize($string_or_object));
		} else {
			$_SESSION['wsp_context_session'][$key] = array('serialize' => false, 'value' => $string_or_object);
		}
	}
	
	public static function get($key) {
		if (!is_array($_SESSION['wsp_context_session'])) {
			$_SESSION['wsp_context_session'] = array();
		}
		if (isset($_SESSION['wsp_context_session'][$key])) {
			if ($_SESSION['wsp_context_session'][$key]['serialize']) {
				return unserialize($_SESSION['wsp_context_session'][$key]['value']);
			} else {
				return $_SESSION['wsp_context_session'][$key]['value'];
			}
		} else {
			return null;
		}
	}
}
?>
