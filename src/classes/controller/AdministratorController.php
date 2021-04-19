<?php

class AdministratorController extends Controller {
	private $administrator_personal_details;

	public function createHtmlOutput() {
		if (!SessionWrapper::isLoggedIn('admin')) {
			$view = Creator::createObject('LoginView');
			$view->create();
			$this->html_output = $view->getHtmlOutput();
			return;
		}

		$this->getPersonalDetails();

		switch ($this->task) {
			default:
				$view = Creator::createObject('AdministratorHomeView');
				break;
		}

		$view->setPersonal($this->administrator_personal_details);
		$view->create();
		$this->html_output = $view->getHtmlOutput();
	}

	public function setPersonalDetails($details) {
		$this->administrator_personal_details = $details;
	}

	private function getPersonalDetails() {
		$db_handle = Creator::createDatabaseConnection();

		$model = Creator::createObject('AdministratorModel');
		$model->setDatabaseHandle($db_handle);
		$model->setValidatedInput(['user_id' => SessionWrapper::getSession('user_id')]);
		$this->administrator_personal_details = $model->getAdmin();

		$model = Creator::createObject('UserModel');
		$model->setDatabaseHandle($db_handle);
		$model->setValidatedInput($this->administrator_personal_details);
		$this->administrator_personal_details['user_id'] = $model->getUserById();
	}
}