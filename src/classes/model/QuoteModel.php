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
}