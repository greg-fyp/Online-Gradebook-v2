DROP DATABASE IF EXISTS db_gradebook;
CREATE DATABASE db_gradebook;
USE db_gradebook;

GRANT SELECT, INSERT, UPDATE, DELETE on db_gradebook.* TO gradebookuser@localhost IDENTIFIED BY 'gradebook';

DROP TABLE IF EXISTS users;
CREATE TABLE users (
	user_id int(10) unsigned NOT NULL AUTO_INCREMENT,
	user_email VARCHAR(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
	user_fullname VARCHAR(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
	user_hashed_password VARCHAR(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
	user_gender VARCHAR(8) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
	user_dob DATE DEFAULT NULL,
	user_address VARCHAR(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
	PRIMARY KEY(user_id)
);

DROP TABLE IF EXISTS administrators;
CREATE TABLE administrators(
	admin_id int(10) unsigned NOT NULL AUTO_INCREMENT,
	user_id int(10) unsigned NOT NULL,
	admin_added_timestamp timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY(admin_id),
	CONSTRAINT fk_user_id FOREIGN KEY(user_id) REFERENCES users(user_id)
);

DROP TABLE IF EXISTS teachers;
CREATE TABLE teachers(
	teacher_id int(10) unsigned NOT NULL AUTO_INCREMENT,
	user_id int(10) unsigned NOT NULL,
	teacher_added_timestamp timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY(teacher_id),
	CONSTRAINT fk_user_id2 FOREIGN KEY(user_id) REFERENCES users(user_id)
);

DROP TABLE IF EXISTS students;
CREATE TABLE students (
	student_id int(10) unsigned NOT NULL AUTO_INCREMENT,
	user_id int(10) unsigned NOT NULL,
	student_added_timestamp timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY(student_id),
	CONSTRAINT fk_user_id3 FOREIGN KEY(user_id) REFERENCES users(user_id)
);

DROP TABLE IF EXISTS groups;
CREATE TABLE groups(
	group_code VARCHAR(8) COLLATE utf8mb4_unicode_ci NOT NULL,
	teacher_id int(10) unsigned NOT NULL,
	group_name VARCHAR(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
	PRIMARY KEY(group_code),
	CONSTRAINT fk_teacher_id FOREIGN KEY(teacher_id) REFERENCES teachers(teacher_id)
);

DROP TABLE IF EXISTS group_student;
CREATE TABLE group_student(
	group_code VARCHAR(8) COLLATE utf8mb4_unicode_ci NOT NULL,
	student_id int(10) unsigned NOT NULL,
	CONSTRAINT fk_group_code FOREIGN KEY(group_code) REFERENCES groups(group_code),
	CONSTRAINT fk_student_id FOREIGN KEY(student_id) REFERENCES students(student_id)
);

DROP TABLE IF EXISTS assessments;
CREATE TABLE assessments(
	assessment_id int(10) unsigned NOT NULL AUTO_INCREMENT,
	group_code VARCHAR(8) COLLATE utf8mb4_unicode_ci NOT NULL,
	assessment_title VARCHAR(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
	assessment_weight FLOAT(5,2) DEFAULT 100.00,
	assessment_deadline DATE DEFAULT NULL,
	PRIMARY KEY(assessment_id),
	CONSTRAINT fk_group_code1 FOREIGN KEY(group_code) REFERENCES groups(group_code)
);

DROP TABLE IF EXISTS assignments;
CREATE TABLE assignments(
	assignment_id int(10) unsigned NOT NULL AUTO_INCREMENT,
	assessment_id int(10) unsigned NOT NULL,
	student_id int(10) unsigned NOT NULL,
	grade int DEFAULT NULL,
	feedback VARCHAR(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
	mark_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY(assignment_id),
	CONSTRAINT fk_assessment_id FOREIGN KEY(assessment_id) REFERENCES assessments(assessment_id),
	CONSTRAINT fk_student_id1 FOREIGN KEY(student_id) REFERENCES students(student_id)
);

DROP TABLE IF EXISTS sessions;
CREATE TABLE sessions(
	session_id int(10) unsigned NOT NULL AUTO_INCREMENT,
	group_code VARCHAR(8) COLLATE utf8mb4_unicode_ci NOT NULL,
	session_date DATE DEFAULT NULL,
	session_start_time TIME DEFAULT NULL,
	session_duration int(1) unsigned DEFAULT NULL,
	session_location VARCHAR(32) DEFAULT NULL,
	PRIMARY KEY(session_id),
	CONSTRAINT fk_group_code2 FOREIGN KEY(group_code) REFERENCES groups(group_code)
);

DROP TABLE IF EXISTS announcements;
CREATE TABLE announcements(
	announcement_id int(10) unsigned NOT NULL AUTO_INCREMENT,
	group_code VARCHAR(8) COLLATE utf8mb4_unicode_ci NOT NULL,
	announcement_title VARCHAR(64) DEFAULT NULL,
	announcement_content VARCHAR(1024) DEFAULT NULL,
	announcements_edited BOOL DEFAULT 0,
	announcement_timestamp timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY(announcement_id),
	CONSTRAINT fk_group_code3 FOREIGN KEY(group_code) REFERENCES groups(group_code)
);

DROP TABLE IF EXISTS documents;
CREATE TABLE documents(
	document_id int(10) unsigned NOT NULL AUTO_INCREMENT,
	user_id int(10) unsigned NOT NULL,
	document_title VARCHAR(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
	document_filename VARCHAR(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
	document_description VARCHAR(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
	document_added_timestamp timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY(document_id),
	CONSTRAINT fk_user_id4 FOREIGN KEY(user_id) REFERENCES users(user_id)
); 

DROP TABLE IF EXISTS quotes;
CREATE TABLE quotes(
	quote_id int(10) unsigned NOT NULL AUTO_INCREMENT,
	quote_content VARCHAR(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
	quote_author VARCHAR(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
	PRIMARY KEY(quote_id)
);