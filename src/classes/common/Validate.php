<?php

/**
* Validate.php
*
* This class provides methods which are used to check whether the user input contains malicious content.
*
* @author Greg
*/ 

class Validate {
	public function __construct() {}
	public function __destruct() {}

	public function validateString($name, $tainted, $min_length, $max_length) {

		$validated = false;
		if (!isset($tainted[$name])) {
			return false;
		}

		if (!empty($tainted[$name])) {
			$sanitised = filter_var($tainted[$name], FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

			if ($min_length <= strlen($sanitised) && strlen($sanitised) <= $max_length) {
				$validated = $sanitised;
			}
		}
		

		return $validated;
	}

	public function validateNumber($tainted, $name, $max) {
        $validated = false;
        if (!isset($tainted[$name])) {
			return false;
		}

        if (!empty($tainted[$name])) {
        	$value = $tainted[$name];
        	if (ctype_digit($value) && strlen($value) <= $max) {
            	$validated = filter_var($value, FILTER_SANITIZE_NUMBER_INT);
        	}
        }
        
        return $validated;
    }

    public function validateEmail($tainted, $name) {
    	$validated = false;
    	if (!isset($tainted[$name])) {
			return false;
		}

    	if (!empty($tainted[$name])) {
    		$sanitised = filter_var($tainted[$name], FILTER_SANITIZE_EMAIL);
    		$validated = filter_var($sanitised, FILTER_VALIDATE_EMAIL);
    	}

    	return $validated; 
    }

    public function validateDate($name, $tainted) {
    	$validated = false;
    	if (!isset($tainted[$name])) {
			return false;
		}

		$val = $tainted[$name];

		if (!empty($val)) {
			if (strlen($val) != 10 || substr_count($val, '-') != 2) {
				return false;
			}
			
			$tokens = explode('-', $val);
			$year = intval($tokens[0]);
			$month = intval($tokens[1]);
			$day = intval($tokens[2]);

			if ($month == 0 || $day == 0 || $year == 0) {
				return false;
			}
		}
		
		if (!checkdate($month, $day, $year)) {
			return false;
		} else {
			return $val;
		}
    }

    public function validateWeight($name, $tainted) {
    	if (!isset($tainted[$name])) {
    		return false;
    	}

    	if (empty($tainted[$name])) {
    		return false;
    	}

    	$data = $tainted[$name];
    	for ($i = 0; $i < strlen($data); $i++){
    		if (!is_numeric($data[$i]) && $data[$i] !== '.') {
    			return false;
    		}
    	}

    	$val = floatval($data);
    	if ($val < 0 || $val > 100) {
    		return false;
    	}

    	return $val;
    }

	public function check($clean) {
		foreach ($clean as $item) {
			if ($item === false) {
				return false;
			}
		}

		return true;
	}
}