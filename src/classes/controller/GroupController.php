<?php

class GroupController extends Controller {
	private $administrator_personal_details;

	public function createHtmlOutput() {
		if (!SessionWrapper::isLoggedIn('admin')) {
			$view = Creator::createObject('LoginView');
			$view->create();
			$this->html_output = $view->getHtmlOutput();
			return;
		}

		switch ($this->task) {
			case 'assign_student':
				$this->html_output = $this->assignStudent();
				break;
			case 'drop_relation':
				$this->html_output = $this->dropAssignment();
				break;
			case 'drop_group':
				$this->html_output = $this->dropGroup();
				break;
			case 'edit_group':
				$this->html_output = $this->editGroup();
				break;
		}
	}

	private function assignStudent() {
		$obj = Creator::createObject('Validate');
		$tainted = $_POST;
		$validated['code'] = $obj->validateString('code', $tainted, 8, 8);
		$validated['username'] = $obj->validateEmail($tainted, 'username');

		if (!$validated['code'] || !$validated['username']) {
			die();
			$_SESSION['msg'] = 'Invalid data provided.';
			$_GET['code'] = $validated['code'];
			$controller = Creator::createObject('AdministratorController');
			$controller->set('group_students');
			$controller->createHtmlOutput();
			return $controller->getHtmlOutput();
		}

		$db_handle = Creator::createDatabaseConnection();
		$model = Creator::createObject('GroupModel');
		$model->setDatabaseHandle($db_handle);
		$model->setValidatedInput($validated);

		$result = $model->getStudentId();

		if (!$result) {
			$_GET['code'] = $validated['code'];
			$controller = Creator::createObject('AdministratorController');
			$_SESSION['msg'] = 'No such student';
			$controller->set('group_students');
			$controller->createHtmlOutput();
			return $controller->getHtmlOutput();
		}

		$validated['student_id'] = $result;
		$model->setValidatedInput($validated);
		if (!$model->checkAssign()) {
			$_GET['code'] = $validated['code'];
			$controller = Creator::createObject('AdministratorController');
			$controller->set('group_students');
			$_SESSION['msg'] = 'This student is already assigned to this group.';
			$controller->createHtmlOutput();
			return $controller->getHtmlOutput();
		}

		$model->assignStudent();

		$controller = Creator::createObject('AdministratorController');
		$_GET['code'] = $validated['code'];
		$controller->set('group_students');
		$controller->createHtmlOutput();
		return $controller->getHtmlOutput();
	}

	private function dropAssignment() {
		$db_handle = Creator::createDatabaseConnection();
		if (!isset($_GET['code']) || !isset($_GET['id'])) {
			$view = Creator::createObject('LoginView');
			$view->create();
			$this->html_output = $view->getHtmlOutput();
			return;
		}

		$validated['code'] = $_GET['code'];
		$validated['student_id'] = $_GET['id'];

		$model = Creator::createObject('GroupModel');
		$model->setDatabaseHandle($db_handle);
		$model->setValidatedInput($validated);
		$model->dropAssignment();

		$controller = Creator::createObject('AdministratorController');
		$_GET['code'] = $validated['code'];
		$controller->set('group_students');
		$controller->createHtmlOutput();
		return $controller->getHtmlOutput();
	}

	private function dropGroup() {
		if (!isset($_GET['code'])) {
			$controller = Creator::createObject('AdministratorController');
			$controller->set('main');
			$controller->createHtmlOutput();
			return $controller->getHtmlOutput();
		}

		$controller = Creator::createObject('AdministratorController');
		$controller->set('admin_view_groups');

		$db_handle = Creator::createDatabaseConnection();
		$model = Creator::createObject('GroupModel');
		$model->setDatabaseHandle($db_handle);
		$model->setValidatedInput(['code' => $_GET['code']]);
		$model->dropGroup();

		$controller->createHtmlOutput();
		return $controller->getHtmlOutput();
	}

	private function editGroup() {
		$controller = Creator::createObject('AdministratorController');
		$controller->set('admin_view_groups');

		$obj = Creator::createObject('Validate');
		$tainted = $_POST;
		$validated['group_code'] = $obj->validateString('group_code', $tainted, 8, 8);
		$validated['group_name'] = $obj->validateString('name', $tainted, 3, 32);
		$validated['teacher_id'] = $_POST['teacher_id'];

		foreach ($validated as $item) {
			if ($item === false) {
				$_SESSION['msg'] = 'Invalid data provided.';
				$controller->createHtmlOutput();
				return $controller->getHtmlOutput();
			}
		}

		$db_handle = Creator::createDatabaseConnection();
		$model = Creator::createObject('GroupModel');
		$model->setDatabaseHandle($db_handle);
		$model->setValidatedInput($validated);
		$model->editGroup();

		$controller->createHtmlOutput();
		return $controller->getHtmlOutput();
	}
}