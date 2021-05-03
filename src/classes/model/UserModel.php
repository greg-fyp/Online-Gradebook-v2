<?php

class UserModel extends Model {

	public function __construct() {
		parent::__construct();
	}

	public function getUser() {
		$records = [];
		$query = SqlQuery::authenticateUser();
		$params = [':username' => $this->validated_input['username']];
		$result = $this->db_handle->executeQuery($query, $params);

		if ($this->db_handle->countRows() != 1) {
			return false;
		}

		$item = $this->db_handle->fetch()[0];
		$records['user_id'] = $item['user_id'];
		$records['password'] = $item['user_hashed_password'];

		return $records;
	}

	public function getPasswordById() {
		$records = [];
		$query = SqlQuery::authenticateUserById();
		$params = [':user_id' => $this->validated_input['user_id']];
		$result = $this->db_handle->executeQuery($query, $params);

		if ($this->db_handle->countRows() != 1) {
			return false;
		}

		$item = $this->db_handle->fetch()[0];
		$records['password'] = $item['user_hashed_password'];
		return $records;
	}

	public function getUserById() {
		$records = [];
		$query = SqlQuery::selectUserById();
		$params = [':user_id' => $this->validated_input['user_id']];
		$result = $this->db_handle->executeQuery($query, $params);

		if ($this->db_handle->countRows() != 1) {
			return false;
		}

		$item = $this->db_handle->fetch()[0];
		$records['user_id'] = $item['user_id'];
		$records['user_email'] = $item['user_email'];
		$records['user_fullname'] = $item['user_fullname'];
		$records['user_password'] = $item['user_hashed_password'];
		$records['user_gender'] = $item['user_gender'];
		$records['user_dob'] = $item['user_dob'];
		$records['user_address'] = $item['user_address'];

		return $records;
	}

	public function updatePassword() {
		$query = SqlQuery::updatePassword();
		$params = [':user_id' => $this->validated_input['user_id'],
				   ':password' => $this->validated_input['new_password']];
		$this->db_handle->executeQuery($query, $params);
	}

	public function updateUserPassword() {
		$query = SqlQuery::updateUserPassword();
		$params = [':username' => $this->validated_input['username'],
	               ':password' => $this->validated_input['password']];
	    $this->db_handle->executeQuery($query, $params);
	}

	public function editUser() {
		$query = SqlQuery::updateUser();
		$params = [':user_id' => $this->validated_input['user_id'],
				   ':user_fullname' => $this->validated_input['user_fullname'],
				   ':user_email' => $this->validated_input['username'],
				   ':user_gender' => $this->validated_input['user_gender'],
				   ':user_dob' => $this->validated_input['user_dob'],
				   ':user_address' => $this->validated_input['user_address']];
		$this->db_handle->executeQuery($query, $params);
	}

	public function addUser() {
		$query = SqlQuery::addUser();
		$params = [':user_fullname' => $this->validated_input['firstname'] . ' ' . $this->validated_input['lastname'],
				   ':user_email' => $this->validated_input['username'],
				   ':user_password' => $this->validated_input['password'],
				   ':user_gender' => $this->validated_input['gender'],
				   ':user_dob' => $this->validated_input['date'],
				   ':user_address' => $this->validated_input['user_address']];
		$this->db_handle->executeQuery($query, $params);
	}

	public function getAllUsers() {
		$query = SqlQuery::getAllUsers();
		$params = [];
		$this->db_handle->executeQuery($query, $params);
	}
}