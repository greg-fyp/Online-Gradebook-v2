<?php

class TeacherModel extends Model {
	public function __construct() {
		parent::__construct();
	}

	public function getTeacher() {
		$records = [];
		$query = SqlQuery::selectTeacherByUserId();
		$params = [':user_id' => $this->validated_input['user_id']];
		$result = $this->db_handle->executeQuery($query, $params);

		if ($this->db_handle->countRows() != 1) {
			return false;
		}

		$item = $this->db_handle->fetch()[0];
		$records['teacher_id'] = $item['teacher_id'];
		$records['user_id'] = $item['user_id'];
		$records['added_timestamp'] = $item['teacher_added_timestamp'];
		return $records;
	}
}