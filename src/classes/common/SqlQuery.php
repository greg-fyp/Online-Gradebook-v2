<?php

/**
* SqlQuery.php
*
*
* @author Greg
*/

class SqlQuery {
	public function __construct() {}
	public function __destruct() {}

	public static function authenticateUser() {
		$query = 'SELECT user_id, user_hashed_password FROM ';
		$query .= 'users WHERE user_email=:username LIMIT 1';
		return $query . ';';
	}

	public static function authenticateUserById() {
		$query = 'SELECT user_hashed_password FROM ';
		$query .= 'users WHERE user_id=:user_id LIMIT 1';
		return $query . ';';
	}

	public static function selectUserById() {
		$query = 'SELECT * FROM ';
		$query .= 'users WHERE user_id=:user_id LIMIT 1';
		return $query . ';';
	}

	public static function selectStudentByUserId() {
		$query = 'SELECT * FROM ';
		$query .= 'students WHERE user_id=:user_id LIMIT 1';
		return $query . ';';
	}

	public static function selectTeacherByUserId() {
		$query = 'SELECT * FROM ';
		$query .= 'teachers WHERE user_id=:user_id LIMIT 1';
		return $query . ';';
	}

	public static function selectAdminByUserId() {
		$query = 'SELECT * FROM ';
		$query .= 'administrators WHERE user_id=:user_id LIMIT 1';
		return $query . ';';
	}

	public static function selectQuotes() {
		$query = 'SELECT * FROM quotes;';
		return $query;
	}

	public static function updatePassword() {
		$query = 'UPDATE users ';
		$query .= 'SET user_hashed_password=:password ';
		$query .= 'WHERE user_id=:user_id';
		return $query . ';';
	}

	public static function updateUser() {
		$query = 'UPDATE users ';
		$query .= 'SET user_fullname=:user_fullname, ';
		$query .= 'user_email=:user_email, ';
		$query .= 'user_gender=:user_gender, ';
		$query .= 'user_dob=:user_dob, ';
		$query .= 'user_birth_place=:user_birth_place ';
		$query .= 'WHERE user_id=:user_id';
		return $query . ';';
	}

	public static function getUserDocuments() {
		$query = 'SELECT * FROM ';
		$query .= 'documents WHERE user_id=:user_id';
		return $query . ';';
	}

	public static function getStudentGrades() {
		$query = 'SELECT assessments.group_code, assessments.assessment_title, ';
		$query .= 'assessments.assessment_weight, assignments.grade, assignments.feedback, assignments.mark_date ';
		$query .= 'FROM assignments INNER JOIN assessments ON assessments.assessment_id=assignments.assessment_id
					WHERE student_id=:student_id AND assessments.group_code=:group_code';
		return $query . ';';			
	}

	public static function getGroupAssessments() {
		$query = 'SELECT * FROM ';
		$query .= 'assessments WHERE group_code=:group_code';
		return $query . ';';
	}

	public static function getStudentGroups() {
		$query = 'SELECT groups.group_code, groups.group_name FROM group_student ';
		$query .= 'INNER JOIN groups ON group_student.group_code=groups.group_code ';
		$query .= 'WHERE student_id=:student_id';
		return $query . ';';
	}

	public static function getTeacherGroups() {
		$query = 'SELECT group_code,group_name ';
		$query .= 'FROM groups WHERE teacher_id=:teacher_id';
		return $query . ';';
	}

	public static function getStudentsFromGroup() {
		$query = 'SELECT students.student_id, students.user_id FROM ';
		$query .= 'group_student INNER JOIN students ON ';
		$query .= 'students.student_id=group_student.student_id ';
		$query .= 'WHERE group_code=:group_code';
		return $query . ';';
	}

	public static function addAssessment() {
		$query = 'INSERT INTO assessments(group_code, assessment_title,
		 assessment_weight, assessment_deadline) ';
		$query .= 'VALUES (:code, :title, :weight, :date)';
		return $query . ';';
	}

	public static function deleteAllAssignments() {
		$query = 'DELETE FROM assignments WHERE assessment_id=:assessment_id';
		return $query . ';';
	}

	public static function deleteAssessment() {
		$query = 'DELETE FROM assessments WHERE assessment_id=:assessment_id';
		return $query . ';';
	}

	public static function getAssessment() {
		$query = 'SELECT * FROM assessments WHERE assessment_id=:assessment_id';
		return $query . ';';
	}

	public static function editAssessment() {
		$query = 'UPDATE assessments SET ';
		$query .= 'assessment_title=:title, assessment_weight=:weight, assessment_deadline=:date ';
		$query .= 'WHERE assessment_id=:id';
		return $query . ';';
	}
}