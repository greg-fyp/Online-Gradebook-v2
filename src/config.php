<?php

/**
* config.php
*
* Defines and sets all relevant global variables.
*
* @author Greg
*
*/

$app_path = realpath(dirname(__FILE__));
$class_path = $app_path . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR;
$root_path = dirname($_SERVER['PHP_SELF'], 1) . '/';
$document_root = $_SERVER['HTTP_HOST'];
$root_path = 'http://' . $document_root . $root_path;

$app_name = 'Online Gradebook for Teachers and Students';

$img_path = $root_path . 'img/';
$css_path = $root_path . 'css/';
$js_path = $root_path . 'js/';
$docs_path = $root_path . 'documents/';
 
define('ROOT_PATH', $root_path);
define('APP_NAME', $app_name);
define('IMG_PATH', $img_path);
define('CLASS_PATH', $class_path);
define('CSS_PATH', $css_path);
define('JS_PATH', $js_path);
define('DOC_PATH', $docs_path);

function getDatabaseDetails($database_name) {
	$rdbms = 'mysql';
	$host = 'localhost';
	$port = '3306';
	$charset = 'utf8mb4';
	$db_name = $database_name;
	$pdo_dsn = $rdbms . ':host=' . $host . ';port=' . $port . ';dbname=' . $db_name . ';charset=' . $charset;

	$username = 'gradebookuser';
	$password = 'gradebook';
	$db_connect_details['pdo_dsn'] = $pdo_dsn;
	$db_connect_details['pdo_username'] = $username;
	$db_connect_details['pdo_password'] = $password;

	return $db_connect_details;
}