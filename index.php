<?php
/**
* index.php
* 
* Web application created for ctec3451 - Development Project
* Final Year Project - Online Gradebook for Teachers and Students.
* 
* 
* @author Greg
*
*/

// Set to true in order to create the xdebug trace files.
$debug = false;

ini_set('xdebug.trace_output_name', 'gradebook.%t');
ini_set('display_errors', '1');
ini_set('html_errors', '1');

if ($debug == true && function_exists(xdebug_start_trace())) {
	xdebug_start_trace();
}

// Calls the startup sequence.
include_once 'src/startup.php';

if ($debug == true && function_exists(xdebug_stop_trace())) {
	xdebug_stop_trace();
}