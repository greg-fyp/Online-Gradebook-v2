<?php

class QuoteModel extends Model {
	public function __construct() {
		parent::__construct();
	}

	public function getQuote() {
		$record = [];
		$query = SqlQuery::selectQuotes();
		$params = [];
		$result = $this->db_handle->executeQuery($query, $params);

		$num = $this->db_handle->countRows();
		if ($num == 0) {
			return false;
		}

		$data = $this->db_handle->fetch();
		$row = $data[rand(0, $num-1)];

		$record['content'] = $row['quote_content'];
		$record['author'] = $row['quote_author'];

		return $record;
	}

	public function getAllQuotes() {
		$query = SqlQuery::selectQuotes();
		$params = [];
		$result = $this->db_handle->executeQuery($query, $params);
		return $this->db_handle->fetch();
	}

	public function addQuote() {
		$query = SqlQuery::addQuote();
		$params = [':author' => $this->validated_input['author'],
				   ':content' => $this->validated_input['content']];
		$result = $this->db_handle->executeQuery($query, $params);
	}

	public function editQuote() {
		$query = SqlQuery::editQuote();
		$params = [':author' => $this->validated_input['author'],
				   ':content' => $this->validated_input['content'],
				   ':quote_id' => $this->validated_input['quote_id']];
		$result = $this->db_handle->executeQuery($query, $params);
	}

	public function dropQuote() {
		$query = SqlQuery::dropQuote();
		$params = [':quote_id' => $this->validated_input['quote_id']];
		$result = $this->db_handle->executeQuery($query, $params);
	}
}