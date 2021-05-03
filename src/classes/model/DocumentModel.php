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

	public function getFilename() {
		$query = SqlQuery::getFilename();
		$params = [':document_id' => $this->validated_input['file_id'],
	               ':user_id' => $this->validated_input['user_id']];
		$this->db_handle->executeQuery($query, $params);
		return $this->db_handle->fetch();
	}

	public function getAllDocuments() {
		$query = SqlQuery::getAllDocuments();
		$params = [];
		$result = $this->db_handle->executeQuery($query, $params);
		return $this->db_handle->fetch();
	}

	public function dropDocument() {
		$query = SqlQuery::dropDocument();
		$params = [':document_id' => $this->validated_input['document_id']];
		$result = $this->db_handle->executeQuery($query, $params);
	}

	public function editDocument() {
		$query = SqlQuery::editDocument();
		$params = [':document_id' => $this->validated_input['document_id'],
	               ':document_title' => $this->validated_input['title'],
	               ':document_filename' => $this->validated_input['filename'],
	               ':document_description' => $this->validated_input['description']];
	    $result = $this->db_handle->executeQuery($query, $params);
	}

	public function uploadDocument() {
		$query = SqlQuery::uploadDocument();
		$model = Creator::createObject('UserModel');
		$model->setDatabaseHandle($this->db_handle);
		$model->setValidatedInput(['username' => $this->validated_input['username']]);
		$result = $model->getUser();

		if (empty($result)) {
			return false;
		}

		$user_id = $result['user_id'];

		$params = [':user_id' => $user_id,
				   ':document_title' => $this->validated_input['title'],
				   ':document_filename' => $this->validated_input['filename'],
				   ':document_description' =>$this->validated_input['description']];
		$result = $this->db_handle->executeQuery($query, $params);

		return true;
	}
}