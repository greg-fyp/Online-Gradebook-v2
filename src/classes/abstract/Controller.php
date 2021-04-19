<?php

/**
* Controller.php
*
* Provides an abstract class representing a controller.
*
*
* @author Greg
*/

abstract class Controller {
	protected $html_output;
	protected $task;

	public final function __construct() {
		$this->html_output = '';
		$this->task = '';
	}

	public final function __destruct() {}

	public function getHtmlOutput() {
		return $this->html_output;
	}

	public function set($task) {
		$this->task = $task;
	}

	abstract protected function createHtmlOutput();
}