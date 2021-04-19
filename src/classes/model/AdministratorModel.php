<?php

class AdministratorModel extends Model {
	public function __construct() {
		parent::__construct();
	}

	public function getAdmin() {
		$records = [];
		$query = SqlQuery::selectAdminByUserId();
		$params = [':user_id' => $this->validated_input['user_id']];
		$result = $this->db_handle->executeQuery($query, $params);

		if ($this->db_handle->countRows() != 1) {
			return false;
		}

		$item = $this->db_handle->fetch()[0];
		$records['admin_id'] = $item['admin_id'];
		$records['user_id'] = $item['user_id'];
		$records['added_timestamp'] = $item['admin_added_timestamp'];
		return $records;
	}
}