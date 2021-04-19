<?php

class UserController extends Controller {
	public function createHtmlOutput() {
		switch ($this->task) {
			case 'edit_password':
				$this->html_output = $this->editPassword();
				break;
			case 'edit_user':
				$this->html_output = $this->editUser();
				break;
		}
	}

	private function editPassword() {
		$obj = Creator::createObject('Validate');
		$tainted = $_POST;
		$validated['password'] = $obj->validateString('old_password', $tainted, 5, 50);
		$validated['new_password'] = $obj->validateString('new_password', $tainted, 5, 50);
		$validated['user_id'] = $tainted['user_id'];

		if ($validated['password'] === false || $validated['new_password'] === false) {
			return $this->fail('edit_password_fail');
		}

		$db_handle = Creator::createDatabaseConnection();
		$model = Creator::createObject('UserModel');
		$model->setDatabaseHandle($db_handle);
		$model->setValidatedInput($validated);

		$result = $model->getPasswordById();
		if (!$result) {
			return $this->fail('edit_password_fail');
		}

		if ($result['password'] === $validated['password']) {
			if (isset($_SESSION['student_id'])) {
				$controller = Creator::createObject('StudentController');
				$controller->set('edit_password_success');
			} else if (isset($_SESSION['teacher_id'])) {
				$controller = Creator::createObject('TeacherController');
				$controller->set('edit_password_success');
			} else if (isset($_SESSION['admin_id'])) {

			} else {
				die();
			}

			$model->updatePassword();
			$controller->createHtmlOutput();
			return $controller->getHtmlOutput();

		} else {
			return $this->fail('edit_password_fail');
		}
	}

	private function editUser() {
		$obj = Creator::createObject('Validate');
		$tainted = $_POST;
		$validated['user_fullname'] = $obj->validateString('user_fullname', $tainted, 5, 50);
		$validated['username'] = $obj->validateEmail($tainted, 'user_email');
		$validated['user_gender'] = $obj->validateString('user_gender', $tainted, 1, 8);
		$validated['user_dob'] = $obj->validateDate('user_dob', $tainted);
		$validated['user_birth_place'] = $obj->validateString('user_birth_place', $tainted, 3, 32);
		$validated['user_id'] = $tainted['user_id'];

		foreach ($validated as $item) {
			if ($item === false) {
				return $this->fail('edit_profile_fail');
			}
		}

		$db_handle = Creator::createDatabaseConnection();
		$model = Creator::createObject('UserModel');
		$model->setDatabaseHandle($db_handle);
		$model->setValidatedInput($validated);
		$data = $model->getUser();
		if ($data !== false) {
			if ($data['user_id'] !== $validated['user_id']) {
				return $this->fail('edit_profile_fail');
			}
		}

		$model->editUser();

		if (isset($_SESSION['student_id'])) {
			$controller = Creator::createObject('StudentController');
			$controller->set('edit_profile_success');
		} else if (isset($_SESSION['teacher_id'])) {
			$controller = Creator::createObject('TeacherController');
			$controller->set('edit_profile_success');
		} else if (isset($_SESSION['admin_id'])) {

		} else {
			die();
		}

		$controller->createHtmlOutput();
		return $controller->getHtmlOutput();	
	}

	private function fail($val) {
		if (isset($_SESSION['student_id'])) {
			$controller = Creator::createObject('StudentController');
			$controller->set($val);
		} else if (isset($_SESSION['teacher_id'])) {
			$controller = Creator::createObject('TeacherController');
			$controller->set($val);
		} else if (isset($_SESSION['admin_id'])) {

		} else {
			die();
		}

		$controller->createHtmlOutput();
		return $controller->getHtmlOutput();
	}
}