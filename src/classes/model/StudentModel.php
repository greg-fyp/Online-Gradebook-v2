<?php

class StudentModel extends Model {
	public function __construct() {
		parent::__construct();
	}

	public function getStudent() {
		$records = [];
		$query = SqlQuery::selectStudentByUserId();
		$params = [':user_id' => $this->validated_input['user_id']];
		$result = $this->db_handle->executeQuery($query, $params);

		if ($this->db_handle->countRows() != 1) {
			return false;
		}

		$item = $this->db_handle->fetch()[0];
		$records['student_id'] = $item['student_id'];
		$records['user_id'] = $item['user_id'];
		$records['added_timestamp'] = $item['student_added_timestamp'];
		return $records;
	}

	public function getAllStudents() {
		$query = SqlQuery::getAllStudents();
		$params = [];
		$this->db_handle->executeQuery($query, $params);
		return $this->db_handle->fetch();
	}

	public function addRecord() {
		$query = SqlQuery::addStudent();
		$params = [':user_id' => $this->validated_input['user_id']];
		$this->db_handle->executeQuery($query, $params);
	}
}