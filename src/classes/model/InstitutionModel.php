<?php

class InstitutionModel extends Model {
	public function __construct() {
		parent::__construct();
	}

	public function getInstitutionDetails() {
		$query = SqlQuery::getInstitution();
		$params = [];
		$this->db_handle->executeQuery($query, $params);
		return $this->db_handle->fetch();
	}

	public function edit() {
		$query = SqlQuery::editInstitution();
		$params = [':institution_address' => $this->validated_input['address'],
	               ':institution_phone' => $this->validated_input['phone'],
	               ':institution_email' => $this->validated_input['email'],
	               ':institution_time' => $this->validated_input['time']];
		$this->db_handle->executeQuery($query, $params);
	}
}