<?php

/**
* DBconnect.php
*
* Provides a database connection.
* Enables query execution.
*
* @author Greg
*/

class DBconnect {
	private $db_connect_details;
	private $db_handle;
	private $prepared_statement;

	public function __construct() {
		$db_connect_details = [];
		$db_connection_message = [];
		$db_handle = null;
		$prepared_statement = null;
	}

	public function __destruct() {
		$this->db_handle = null;
	}

	public function setConnectDetails($details) {
		$this->db_connect_details = $details;
	}

	// Main method that provides the database connection.
	public function connect() {
		$error_flag = false;

		try {
			$this->db_handle = new PDO($this->db_connect_details['pdo_dsn'],
									   $this->db_connect_details['pdo_username'],
									   $this->db_connect_details['pdo_password']);

		} catch (PDOException $exception) {
			$error_flag = true;
			trigger_error($exception);
		}
	}

	/**
	* Executes sql query.
	*
	* @param query - VALIDATED query to be executed
	* @param params - query parameters
	*
	* @return true if query execution OK,
	*         false otherwise
	*/
	public function executeQuery($query, $params=null) {
		$error_flag = false;

		try {
			$this->db_handle->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->prepared = $this->db_handle->prepare($query);
		} catch (PDOException $exception) {
			$error_flag = true;
            trigger_error($exception);
		}

		return $error_flag;
	}

	// Returns the result set as an array.
	public function fetch() {
		$row = $this->prepared->fetch(PDO::FETCH_ASSOC);
		if (is_array($row)) {
			$row = $this->escapeOutput($row);
		}

		return $row;
	}

	public function getRowCount() {
		return $this->prepared->rowCount();
	}

	// Converts special characters to HTML entities.
	public function escapeOutput(array $row) {
		$output_row = [];
        foreach ($row as $key => $item)
        {
            $output_row[$key] = htmlspecialchars($item);
        }
        return $output_row;
	}
}