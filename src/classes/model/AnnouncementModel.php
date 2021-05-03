<?php

class AnnouncementModel extends Model {
	public function __construct() {
		parent::__construct();
	}

	public function getAnnouncementsFromGroup() {
		$query = SqlQuery::getAnnouncementsFromGroup();
		$params = [':group_code' => $this->validated_input['code']];
		$this->db_handle->executeQuery($query, $params);
		return $this->db_handle->fetch();
	}

	public function addAnnouncement() {
		$query = SqlQuery::addAnnouncement();
		$params = [':group_code' => $this->validated_input['code'],
	               ':announcement_title' => $this->validated_input['title'],
	               ':announcement_content' => $this->validated_input['content']];
	    $this->db_handle->executeQuery($query, $params);
	}

	public function editAnnouncement() {
		$query = SqlQuery::editAnnouncement();
		$params = [':announcement_id' => $this->validated_input['announcement_id'],
	               ':announcement_title' => $this->validated_input['title'],
	               ':announcement_content' => $this->validated_input['content']];
	    $this->db_handle->executeQuery($query, $params);
	}

	public function dropAnnouncement() {
		$query = SqlQuery::dropAnnouncement();
		$params = [':announcement_id' => $this->validated_input['announcement_id']];
		$this->db_handle->executeQuery($query, $params);
	}
}