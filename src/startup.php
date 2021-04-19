<?php

/**
* startup.php
* 
* Provides a startup sequence.
* 
* 
* @author Greg
*
*/

// To avoid type mismatch.
declare(strict_types=1);

$session = session_start();

if ($session) {

	// Sets all relevant global variables.
	include_once 'config.php';

	// Provides autoloading classes.
	include_once 'autoload.php';

	// Provides routing.
	$router = Creator::createObject('Router');
	$router->route();
	echo $router->getHtmlOutput();
}