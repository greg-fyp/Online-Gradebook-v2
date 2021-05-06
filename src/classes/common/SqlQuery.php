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

	public static function updateUserPassword() {
		$query = 'UPDATE users SET user_hashed_password=:password WHERE user_email=:username';
		return $query . ';';
	}

	public static function updateUser() {
		$query = 'UPDATE users ';
		$query .= 'SET user_fullname=:user_fullname, ';
		$query .= 'user_email=:user_email, ';
		$query .= 'user_gender=:user_gender, ';
		$query .= 'user_dob=:user_dob, ';
		$query .= 'user_address=:user_address ';
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

	public static function getStudentResult() {
		$query = 'SELECT * FROM assignments ';
		$query .= 'WHERE student_id=:student_id AND assessment_id=:assessment_id ';
		$query .= 'LIMIT 1';
		return $query . ';';
	}

	public static function addGrade() {
		$query = 'INSERT INTO assignments (assessment_id, student_id, grade, feedback) ';
		$query .= 'VALUES (:assessment_id, :student_id, :grade, :feedback)';
		return $query . ';';
	}

	public static function editGrade() {
		$query = 'UPDATE assignments SET ';
		$query .= 'grade=:grade, feedback=:feedback ';
		$query .= 'WHERE assessment_id=:assessment_id AND student_id=:student_id';
		return $query . ';';
	}

	public static function getTeacherSessions(){
		$query = 'SELECT groups.group_code, groups.group_name, ';
		$query .= 'sessions.session_date, sessions.session_start_time, sessions.session_duration, ';
		$query .= 'sessions.session_date, sessions.session_start_time, sessions.session_duration, ';
		$query .= 'sessions.session_location FROM sessions ';
		$query .= 'INNER JOIN groups ON groups.group_code=sessions.group_code WHERE groups.teacher_id=:teacher_id ';
		$query .= 'ORDER BY sessions.session_start_time';
		return $query . ';';
	}

	public static function getStudentSessions(){
		$query = 'SELECT groups.group_code, groups.group_name, ';
		$query .= 'sessions.session_date, sessions.session_start_time, sessions.session_duration, ';
		$query .= 'sessions.session_date, sessions.session_start_time, sessions.session_duration, ';
		$query .= 'sessions.session_location FROM group_student ';
		$query .= 'INNER JOIN groups ON groups.group_code=group_student.group_code ';
		$query .= 'INNER JOIN sessions ON sessions.group_code=group_student.group_code ';
		$query .= 'WHERE student_id=:student_id ';
		$query .= 'ORDER BY sessions.session_start_time';
		return $query . ';';
	}

	public static function getAnnouncementsFromGroup() {
		$query = 'SELECT * FROM announcements ';
		$query .= 'WHERE group_code=:group_code ';
		$query .= 'ORDER BY announcement_timestamp DESC';
		return $query . ';';
	}

	public static function addAnnouncement() {
		$query = 'INSERT INTO announcements (group_code, announcement_title, announcement_content) ';
		$query .= 'VALUES (:group_code, :announcement_title, :announcement_content)';
		return $query . ';';
	}

	public static function getFilename() {
		$query = 'SELECT document_filename FROM documents ';
		$query .= 'WHERE document_id=:document_id AND user_id=:user_id';
		return $query . ';';
	}

	public static function getAllStudents() {
		$query = 'SELECT users.user_id, students.student_id, users.user_fullname, users.user_email, ';
		$query .= 'users.user_hashed_password, users.user_gender, users.user_dob, users.user_address, students.student_added_timestamp ';
		$query .= 'FROM users INNER JOIN students ON students.user_id=users.user_id';
		return $query . ';';
	}

	public static function getAllTeachers() {
		$query = 'SELECT users.user_id, teachers.teacher_id, users.user_fullname, users.user_email, ';
		$query .= 'users.user_hashed_password, users.user_gender, users.user_dob, users.user_address, teachers.teacher_added_timestamp ';
		$query .= 'FROM users INNER JOIN teachers ON teachers.user_id=users.user_id';
		return $query . ';';
	}

	public static function getAllAdmins() {
		$query = 'SELECT users.user_id, administrators.admin_id, users.user_fullname, users.user_email, ';
		$query .= 'users.user_hashed_password, users.user_gender, users.user_dob, users.user_address, administrators.admin_added_timestamp ';
		$query .= 'FROM users INNER JOIN administrators ON administrators.user_id=users.user_id';
		return $query . ';';
	}

	public static function addUser() {
		$query = 'INSERT INTO users (user_email, user_fullname, user_hashed_password, user_gender, user_dob, user_address) ';
		$query .= 'VALUES (:user_email, :user_fullname, :user_password, :user_gender, :user_dob, :user_address)';
		return $query . ';';
	}

	public static function addStudent() {
		$query = 'INSERT INTO students (user_id) VALUES (:user_id)';
		return $query . ';';
	}

	public static function addTeacher() {
		$query = 'INSERT INTO teachers (user_id) VALUES (:user_id)';
		return $query . ';';
	}

	public static function addAdmin() {
		$query = 'INSERT INTO administrators (user_id) VALUES (:user_id)';
		return $query . ';';
	}

	public static function addQuote() {
		$query = 'INSERT INTO quotes (quote_author, quote_content) VALUES (:author, :content)';
		return $query . ';';
	}

	public static function editQuote() {
		$query = 'UPDATE quotes SET quote_author=:author, quote_content=:content WHERE quote_id=:quote_id';
		return $query . ';';
	}

	public static function dropQuote() {
		$query = 'DELETE FROM quotes WHERE quote_id=:quote_id';
		return $query . ';';
	}

	public static function getAllUsers() {
		$query = 'SELECT * FROM users';
		return $query . ';';
	}

	public static function getGroup() {
		$query = 'SELECT * FROM groups WHERE group_code=:group_code LIMIT 1';
		return $query . ';';
	}

	public static function addGroup() {
		$query = 'INSERT INTO groups (group_code, teacher_id, group_name) VALUES ';
		$query .= '(:group_code, :teacher_id, :group_name)';
		return $query . ';';
	}

	public static function getAllDocuments() {
		$query = 'SELECT * FROM documents';
		return $query . ';';
	}

	public static function dropDocument() {
		$query = 'DELETE FROM documents WHERE document_id=:document_id';
		return $query . ';';
	}

	public static function editDocument() {
		$query = 'UPDATE documents SET document_title=:document_title, document_filename=:document_filename, ';
		$query .= 'document_description=:document_description WHERE document_id=:document_id';
		return $query . ';';
	}

	public static function uploadDocument() {
		$query = 'INSERT INTO documents (user_id, document_title, document_filename, document_description) VALUES ';
		$query .= '(:user_id, :document_title, :document_filename, :document_description)';
		return $query . ';';
	}

	public static function getAllGroups() {
		$query = 'SELECT * FROM groups';
		return $query . ';';
	}

	public static function editAnnouncement() {
		$query = 'UPDATE announcements SET ';
		$query .= 'announcement_title=:announcement_title, announcement_content=:announcement_content ';
		$query .= 'WHERE announcement_id=:announcement_id';
		return $query . ';';
	}

	public static function dropAnnouncement() {
		$query = 'DELETE FROM announcements WHERE announcement_id=:announcement_id';
		return $query . ';';
	}

	public static function getTeacherFullname() {
		$query = 'SELECT users.user_fullname FROM teachers INNER JOIN users ON teachers.user_id=users.user_id ';
		$query .= 'WHERE teacher_id=:teacher_id LIMIT 1';
		return $query . ';';
	}

	public static function getStudentFullname() {
		$query = 'SELECT users.user_fullname, users.user_email FROM students INNER JOIN users ON students.user_id=users.user_id ';
		$query .= 'WHERE student_id=:student_id LIMIT 1';
		return $query . ';';
	}

	public static function getKurwa() {
		$query = 'SELECT * FROM group_student WHERE student_id=:student_id AND group_code=:group_code';
		return $query . ';';
	}

	public static function assignStudent() {
		$query = 'INSERT INTO group_student(group_code, student_id) VALUES (:group_code, :student_id)';
		return $query . ';';
	}

	public static function getStudentByEmail() {
		$query = 'SELECT students.student_id FROM users INNER JOIN students ON students.user_id=users.user_id ';
		$query .= 'WHERE user_email=:username';
		return $query . ';';
	}

	public static function dropRelation() {
		$query = 'DELETE FROM group_student WHERE student_id=:student_id AND group_code=:group_code';
		return $query . ';';
	}

	public static function getGroupSessions() {
		$query = 'SELECT * FROM sessions WHERE group_code=:group_code';
		return $query .';';
	}

	public static function editSession() {
		$query = 'UPDATE sessions SET session_date=:session_date, session_start_time=:session_start_time, ';
		$query .= 'session_duration=:session_duration, session_location=:session_location WHERE session_id=:session_id';
		return $query . ';';
	}

	public static function dropSession() {
		$query = 'DELETE FROM sessions WHERE session_id=:session_id';
		return $query . ';';
	}

	public static function addSession() {
		$query = 'INSERT INTO sessions (group_code, session_date, session_start_time, session_duration, session_location) ';
		$query .= 'VALUES (:group_code, :session_date, :session_start_time, :session_duration, :session_location)';
		return $query . ';';
	}

	public static function dropGroup() {
		$query = 'DELETE FROM groups WHERE group_code=:group_code';
		return $query . ';';
	}

	public static function editGroup() {
		$query = 'UPDATE groups SET group_name=:group_name, teacher_id=:teacher_id ';
		$query .= 'WHERE group_code=:group_code';
		return $query . ';';
	}

	public static function dropUser() {
		$query = 'DELETE FROM users WHERE user_id=:user_id';
		return $query . ';';
	}

	public static function checkStudent() {
		$query = 'SELECT * FROM students WHERE user_id=:user_id LIMIT 1';
		return $query . ';';
	}

	public static function checkTeacher() {
		$query = 'SELECT * FROM teachers WHERE user_id=:user_id LIMIT 1';
		return $query . ';';
	}

	public static function checkAdmin() {
		$query = 'SELECT * FROM administrators WHERE user_id=:user_id LIMIT 1';
		return $query . ';';
	}

	public static function addRoleStudent() {
		$query = 'INSERT INTO students (user_id) VALUES (:user_id)';
		return $query . ';';
	}

	public static function addRoleTeacher() {
		$query = 'INSERT INTO teachers (user_id) VALUES (:user_id)';
		return $query . ';';
	}

	public static function addRoleAdmin() {
		$query = 'INSERT INTO administrators (user_id) VALUES (:user_id)';
		return $query . ';';
	}

	public function dropRoleStudent() {
		$query = 'DELETE FROM students WHERE user_id=:user_id';
		return $query . ';';
	}

	public function dropRoleTeacher() {
		$query = 'DELETE FROM teachers WHERE user_id=:user_id';
		return $query . ';';
	}

	public function dropRoleAdmin() {
		$query = 'DELETE FROM administrators WHERE user_id=:user_id';
		return $query . ';';
	}

	public static function getInstitution() {
		$query = 'SELECT * FROM institution LIMIT 1';
		return $query . ';';
	}

	public static function editInstitution() {
		$query = 'UPDATE institution SET institution_address=:institution_address, institution_phone=:institution_phone, ';
		$query .= 'institution_email=:institution_email, institution_time=:institution_time WHERE 1=1';
		return $query . ';';
	}

	public static function addRequest() {
		$query = 'INSERT INTO support_requests (user_id, request_title, request_content) VALUES ';
		$query .= '(:user_id, :request_title, :request_content)';
		return $query . ';';
	}

	public static function getRequests() {
		$query = 'SELECT * FROM support_requests';
		return $query . ';';
	}

	public static function dropRequest() {
		$query = 'DELETE FROM support_requests WHERE request_id=:request_id';
		return $query . ';';
	}
}