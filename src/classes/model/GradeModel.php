<?php

class GradeModel extends Model {
	public function __construct() {
		parent::__construct();
	}

	public function getStudentGrades() {
		$query = SqlQuery::getStudentGrades();
		$params = [':student_id' => $this->validated_input['student_id'],
				   ':group_code' => $this->validated_input['group_code']];
		$result = $this->db_handle->executeQuery($query, $params);
		$data = $this->db_handle->fetch();

		return $data;
	}

	public function getGroupAssessments() {
		$records = [];
		$query = SqlQuery::getGroupAssessments();
		$params = [':group_code' => $this->validated_input['group_code']];
		$result = $this->db_handle->executeQuery($query, $params);
		$data = $this->db_handle->fetch();

		return $data;
	}

	public function dropAssignments() {
		$query = SqlQuery::deleteAllAssignments();
		$params = ['assessment_id' => $this->validated_input['assessment_id']];
		$this->db_handle->executeQuery($query, $params);
	}

	public function addAssessment() {
		$query = SqlQuery::addAssessment();
		$params = [':code' => $this->validated_input['code'],
				   ':title' => $this->validated_input['title'],
				   ':weight' => $this->validated_input['weight'],
				   ':date' => $this->validated_input['date']];

		$this->db_handle->executeQuery($query, $params);
	}

	public function dropAssessment() {
		$query = SqlQuery::deleteAssessment();
		$params = [':assessment_id' => $this->validated_input['assessment_id']];
		$this->db_handle->executeQuery($query, $params);
	}

	public function getAssessment() {
		$query = SqlQuery::getAssessment();
		$params = [':assessment_id' => $this->validated_input['assessment_id']];
		$this->db_handle->executeQuery($query, $params);
		return $this->db_handle->fetch();
	}

	public function editAssessment() {
		$query = SqlQuery::editAssessment();
		$params = [':title' => $this->validated_input['title'],
				   ':weight' => $this->validated_input['weight'],
				   ':date' => $this->validated_input['date'],
				   ':id' => $this->validated_input['assessment_id']];
		$this->db_handle->executeQuery($query, $params);
	}

	public function getStudentResult() {
		$query = SqlQuery::getStudentResult();
		$params = [':student_id' => $this->validated_input['student_id'],
				   ':assessment_id' => $this->validated_input['assessment_id']];
		$this->db_handle->executeQuery($query, $params);
		if ($this->db_handle->countRows() === 0) {
			return [];
		} else {
			return $this->db_handle->fetch();
		}
	}

	public function addGrade() {
		$query = SqlQuery::addGrade();
		$params = [':student_id' => $this->validated_input['student_id'],
				   ':assessment_id' => $this->validated_input['assessment_id'],
				   ':grade' => $this->validated_input['grade'],
				   ':feedback' => $this->validated_input['feedback']];
		$this->db_handle->executeQuery($query, $params);
	}

	public function editGrade() {
		$query = SqlQuery::editGrade();
		$params = [':student_id' => $this->validated_input['student_id'],
				   ':assessment_id' => $this->validated_input['assessment_id'],
				   ':grade' => $this->validated_input['grade'],
				   ':feedback' => $this->validated_input['feedback']];
		$this->db_handle->executeQuery($query, $params);
	}
}