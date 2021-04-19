<?php

/**
* Creator.php
*
* Provides a factory class which is used to create instances of classes.
*
* @author Greg
*
*/

class Creator {
	public function __construct() {}
	public function __destruct() {}

	public static function createObject($class_name) {
		$obj = new $class_name();
		return $obj;
	}

	public static function createDatabaseConnection($db_name='db_gradebook') {
		$obj = Creator::createObject('DatabaseConnector');
		$params = getDatabaseDetails($db_name);
		$obj->setDbDetails($params);
		$obj->connect();
		return $obj;
	}
}