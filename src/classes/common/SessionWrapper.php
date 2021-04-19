<?php

/**
* SessionWrapper.php
*
* Provides a set of methods that helps to manage sessions.
*
* @author Greg
*/

class SessionWrapper {
	public function __construct() {}
	public function __destruct() {}

	public static function getSession($key) {
		$value = false;

		try {
			if (isset($_SESSION[$key])) {
				$value = $_SESSION[$key];
			}
		} catch (Exception $exception) {
			trigger_error('Cannot get session');
		}

		return $value;
	}

	public static function setSession($key, $value) {
		$result = false;

		try {
			$_SESSION[$key] = $value;
			if (isset($_SESSION[$key])) {
				if (strcmp($_SESSION[$key], $value) == 0) {
					$result = true;
				}
			}
		} catch (Exception $exception) {
			trigger_error('Cannot set session');
		}

		return $result;
	}

	public static function removeSession($key) {
		try {
			if (isset($_SESSION[$key])) {
				unset($_SESSION[$key]);
			}
		} catch (Exception $exception) {
			trigger_error('Removing session failed');
		}
	}

	public static function getAllSessions() {
		$result = false;
		try {
			if (!empty($_SESSION)) {
				$result = var_export($_SESSION, true);
			} 
		} catch (Exception $exception) {
				trigger_error('Getting sessions failed');
		}

		return $result;
	}

	public static function isLoggedIn($type) {
		$type .= '_id';
		if (SessionWrapper::getSession($type))
			return true;
		else
			return false;
	}
}