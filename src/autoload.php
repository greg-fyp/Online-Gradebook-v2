<?php

/**
* autoload.php
* 
* Iterates through directories and searches for the called script.
* Automatically loads classes if they are currently not defined.
*
* @author Greg
*/

spl_autoload_register(function ($class_name) {
	$fname = '';
	$dirs = [];

	$resource = $class_name . '.php';

	$dirs = array_diff(scandir(CLASS_PATH), array('..', '.'));

	foreach ($dirs as $dir) {
		$fname = CLASS_PATH . $dir . DIRECTORY_SEPARATOR . $resource;
		
		if (file_exists($fname)) {
			require_once $fname;
			break;
		}
	}
});