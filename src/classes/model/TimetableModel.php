<?php

class TimetableModel extends Model {
	public function __construct() {
		parent::__construct();
	}

	public function getTeacherSessions() {
		$query = SqlQuery::getTeacherSessions();
		$params = [':teacher_id' => $this->validated_input['teacher_id']];
		$this->db_handle->executeQuery($query, $params);
		return $this->db_handle->fetch();
	}

	public function getStudentSessions() {
		$query = SqlQuery::getStudentSessions();
		$params = [':student_id' => $this->validated_input['student_id']];
		$this->db_handle->executeQuery($query, $params);
		return $this->db_handle->fetch();
	}

	public function getGroupSessions() {
		$query = SqlQuery::getGroupSessions();
		$params = [':group_code' => $this->validated_input['code']];
		$this->db_handle->executeQuery($query, $params);
		return $this->db_handle->fetch();
	}

	public function editSession() {
		$query = SqlQuery::editSession();
		$params = [':session_id' => $this->validated_input['session_id'],
                   ':session_date' => $this->validated_input['date'],
                   ':session_start_time' => $this->validated_input['start_time'],
                   ':session_duration' => $this->validated_input['duration'],
                   ':session_location' => $this->validated_input['location']];
        $this->db_handle->executeQuery($query, $params);
	}

	public function dropSession() {
		$query = SqlQuery::dropSession();
		$params = [':session_id' => $this->validated_input['session_id']];
		$this->db_handle->executeQuery($query, $params);
	}

	public function addSession() {
		$query = SqlQuery::addSession();
		$params = [':group_code' => $this->validated_input['code'],
				   ':session_date' => $this->validated_input['date'],
                   ':session_start_time' => $this->validated_input['start_time'],
                   ':session_duration' => $this->validated_input['duration'],
                   ':session_location' => $this->validated_input['location']];
        $this->db_handle->executeQuery($query, $params);
	}
}