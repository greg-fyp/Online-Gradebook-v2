<?php

class DatabaseConnector {
	private $db_details;
	private $db_handle;
	private $prepared;

	public function __construct() {
		$this->db_details = [];
		$this->db_handle = null;
		$this->prepared = null;
	}

	public function __destruct() {
		$this->db_handle = null;
	}

	public function setDbDetails($details) {
		$this->db_details = $details;
	}

	public function connect() {
		$flag = true;
		$pdo_dsn = $this->db_details['pdo_dsn'];
		$pdo_username = $this->db_details['pdo_username'];
		$pdo_password = $this->db_details['pdo_password'];

		try {
			$this->db_handle = new PDO($pdo_dsn, $pdo_username, $pdo_password);
		} catch (PDOException $ex) {
			$flag = false;
			echo 'Internal Error. Try again later.';
			die();
		}

		return $flag;
	}

	public function executeQuery($query, $params) {
		$result = false;

		try {
			$this->db_handle->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->prepared = $this->db_handle->prepare($query);
			$result = $this->prepared->execute($params);
		} catch (PDOException $ex) {
			echo 'Internal Error. Try again later.';
			die();
		}
		return $result;
	}

	public function countRows() {
		return $this->prepared->rowCount();
	}

	public function fetch() {
		$row = $this->prepared->fetchAll();
        return $row;
	}

}