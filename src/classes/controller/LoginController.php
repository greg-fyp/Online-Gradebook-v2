<?php

class LoginController extends Controller {
	public function createHtmlOutput() {
		$validated_input = $this->validate();

		if ($validated_input['error']) {
			$this->html_output = $this->loginUser($validated_input);
		} else {
			$this->html_output = $this->fail();
		}
	}

	private function validate() {
		$obj = Creator::createObject('Validate');
		$tainted = $_POST;

		$validated['username'] = $obj->validateEmail($tainted, 'user-email');
		$validated['password'] = $obj->validateString('password', $tainted, 5, 50);
		$validated['type']     = $obj->validateString('login_type', $tainted, 5, 7);
		$validated['error']    = $obj->check($validated);

		return $validated;
	}

	private function loginUser($validated_input) {
		$db_handle = Creator::createDatabaseConnection();
		$model = Creator::createObject('UserModel');
		$model->setDatabaseHandle($db_handle);
		$model->setValidatedInput($validated_input);
		$results = $model->getUser();

		if (!$results) {
			return $this->fail();
		}

		if ($validated_input['password'] !== $results['password']) {
			return $this->fail();
		}

		switch ($validated_input['type']) {
			case 'student':
				return $this->loginStudent($db_handle, $results);
			case 'teacher':
				return $this->loginTeacher($db_handle, $results);
			case 'admin':
				return $this->loginAdmin($db_handle, $results);
			default:
				return $this->fail();
		}
	}

	private function loginStudent($db_handle, $results) {
		$model = Creator::createObject('StudentModel');
		$model->setDatabaseHandle($db_handle);
		$model->setValidatedInput($results);
		$record = $model->getStudent();

		if (!$record) {
			return $this->fail();
		} else {
			SessionWrapper::setSession('student_id', $record['student_id']);
			SessionWrapper::SetSession('user_id', $results['user_id']);
			$controller = Creator::createObject('StudentController');
			$controller->set('home');
			$controller->createHtmlOutput();
			return $controller->getHtmlOutput();
		}
	}

	private function loginTeacher($db_handle, $results) {
		$model = Creator::createObject('TeacherModel');
		$model->setDatabaseHandle($db_handle);
		$model->setValidatedInput($results);
		$record = $model->getTeacher();

		if (!$record) {
			return $this->fail();
		} else {
			SessionWrapper::setSession('teacher_id', $record['teacher_id']);
			SessionWrapper::SetSession('user_id', $results['user_id']);
			$controller = Creator::createObject('TeacherController');
			$controller->set('home');
			$controller->createHtmlOutput();
			return $controller->getHtmlOutput();
		}
	}

	private function loginAdmin($db_handle, $results) {
		$model = Creator::createObject('AdministratorModel');
		$model->setDatabaseHandle($db_handle);
		$model->setValidatedInput($results);
		$record = $model->getAdmin();

		if (!$record) {
			return $this->fail();
		} else {
			SessionWrapper::setSession('admin_id', $record['admin_id']);
			SessionWrapper::SetSession('user_id', $results['user_id']);
			$controller = Creator::createObject('AdministratorController');
			$controller->set('home');
			$controller->setPersonalDetails($record);
			$controller->createHtmlOutput();
			return $controller->getHtmlOutput();
		}
	}

	private function fail() {
		$view = Creator::createObject('LoginView');
		$view->addStylesheet(CSS_PATH . 'login.css');
		$view->addErrorMsg();
		$view->create();
		return $view->getHtmlOutput();
	}
}