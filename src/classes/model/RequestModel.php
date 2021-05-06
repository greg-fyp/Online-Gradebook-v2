<?php

class RequestModel extends Model {
	public function __construct() {
		parent::__construct();
	}

	public function addRequest() {
		$query = SqlQuery::addRequest();
		$params = [':user_id' => $this->validated_input['user_id'],
	               ':request_title' => $this->validated_input['title'],
	               ':request_content' => $this->validated_input['content']];
	    $this->db_handle->executeQuery($query, $params);
	}

	public function getRequests() {
		$query = SqlQuery::getRequests();
		$params = [];
		$this->db_handle->executeQuery($query, $params);
		return $this->db_handle->fetch();
	}

	public function dropRequest() {
		$query = SqlQuery::dropRequest();
		$params = [':request_id' => $this->validated_input['request_id']];
		$this->db_handle->executeQuery($query, $params);
	}
}