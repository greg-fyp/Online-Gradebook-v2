<?php

class GroupModel extends Model {
	public function __construct() {
		parent::__construct();
	}

	public function getStudentGroups() {
		$records = [];
		$query = SqlQuery::getStudentGroups();
		$params = [':student_id' => $this->validated_input['student_id']];
		$result = $this->db_handle->executeQuery($query, $params);
		$data = $this->db_handle->fetch();
		$row = [];

		foreach ($data as $item) {
			$row['group_code'] = $item['group_code'];
			$row['group_name'] = $item['group_name'];
			array_push($records, $item);
		}

		return $records;
	}

	public function getTeacherGroups() {
		$records = [];
		$query = SqlQuery::getTeacherGroups();
		$params = [':teacher_id' => $this->validated_input['teacher_id']];
		$result = $this->db_handle->executeQuery($query, $params);
		$data = $this->db_handle->fetch();
		$row = [];

		foreach ($data as $item) {
			$row['group_code'] = $item['group_code'];
			$row['group_name'] = $item['group_name'];
			array_push($records, $item);
		}

		return $records;
	}

	public function getStudentsFromGroup() {
		$records = [];
		$query = SqlQuery::getStudentsFromGroup();
		$params = [':group_code' => $this->validated_input['group_code']];
		$result = $this->db_handle->executeQuery($query, $params);
		$data = $this->db_handle->fetch();
		$row = [];

		foreach ($data as $item) {
			$row['student_id'] = $item['student_id'];
			$row['user_id'] = $item['user_id'];
			array_push($records, $item);
		}

		return $records;
	}
}