<?php

class DocumentModel extends Model {
	public function __construct() {
		parent::__construct();
	}

	public function getUserDocuments() {
		$records = [];
		$query = SqlQuery::getUserDocuments();
		$params = [':user_id' => $this->validated_input['user_id']];
		$result = $this->db_handle->executeQuery($query, $params);
		$data = $this->db_handle->fetch();
		$row = [];

		foreach ($data as $item) {
			$row['document_id'] = $item['document_id'];
			$row['document_title'] = $item['document_title'];
			$row['document_filename'] = $item['document_filename'];
			$row['document_description'] = $item['document_description'];
			array_push($records, $row);
		}

		return $records;
	} 
}