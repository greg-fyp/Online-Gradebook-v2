<?php

abstract class Model {
	protected $db_handle;
	protected $validated_input;

	public function __construct() {
		$this->db_handle = null;
		$this->validated_input = [];
	}

	public function setDatabaseHandle($db_handle) {
		$this->db_handle = $db_handle;
	}

	public function setValidatedInput($validated_input) {
		$this->validated_input = $validated_input;
	}
}