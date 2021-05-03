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

	public function getGroup() {
		$query = SqlQuery::getGroup();
		$params = [':group_code' => $this->validated_input['group_code']];
		$result = $this->db_handle->executeQuery($query, $params);
		return $this->db_handle->countRows() === 1 ? true : false;
	}

	public function addGroup() {
		$query = SqlQuery::addGroup();
		$params = [':group_code' => $this->validated_input['group_code'],
	               ':teacher_id' => $this->validated_input['teacher_id'],
	               ':group_name' => $this->validated_input['group_name']];
	    $result = $this->db_handle->executeQuery($query, $params);
	}

	public function getAllGroups() {
		$query = SqlQuery::getAllGroups();
		$params = [];
		$result = $this->db_handle->executeQuery($query, $params);
		return $this->db_handle->fetch();
	}

	public function getAllGroupsAndTeachers() {
		$query = SqlQuery::getTeacherFullname();
		$groups = $this->getAllGroups();
		foreach ($groups as &$group) {
			$params = [':teacher_id' => $group['teacher_id']];
			$this->db_handle->executeQuery($query, $params);
			$group['fullname'] = $this->db_handle->fetch()[0]['user_fullname'];
		}

		return $groups;
	}

	public function getStudents() {
		$query = SqlQuery::getStudentFullname();
		$this->validated_input['group_code'] = $this->validated_input['code'];
		$records = $this->getStudentsFromGroup();
		foreach ($records as &$item) {
			$params = [':student_id' => $item['student_id']];
			$this->db_handle->executeQuery($query, $params);
			$data = $this->db_handle->fetch();
			$item['fullname'] = $data[0]['user_fullname'];
			$item['email'] = $data[0]['user_email'];
		}

		return $records;
	}

	public function getStudentId() {
		$query = SqlQuery::getStudentByEmail();
		$params = [':username' => $this->validated_input['username']];
		$result = $this->db_handle->executeQuery($query, $params);
		$records = $this->db_handle->fetch();

		if (empty($records)) {
			return false;
		} else {
			return $records[0]['student_id'];
		}
	}

	public function checkAssign() {
		$query = SqlQuery::getKurwa();
		$params = [':student_id' => $this->validated_input['student_id'],
				   ':group_code' => $this->validated_input['code']];
		$result = $this->db_handle->executeQuery($query, $params);
		if ($this->db_handle->countRows() !== 0) {
			return false;
		} else {
			return true;
		}
	}

	public function assignStudent() {
		$query = SqlQuery::assignStudent();
		$params = [':student_id' => $this->validated_input['student_id'],
	               ':group_code' => $this->validated_input['code']];
	    $this->db_handle->executeQuery($query, $params);
	}

	public function dropAssignment() {
		$query = SqlQuery::dropRelation();
		$params = [':student_id' => $this->validated_input['student_id'],
	               ':group_code' => $this->validated_input['code']];
	    $this->db_handle->executeQuery($query, $params);
	}
}