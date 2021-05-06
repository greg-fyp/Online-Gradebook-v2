<?php

class UserController extends Controller {
	public function createHtmlOutput() {
		if (!SessionWrapper::isLoggedIn('user')) {
			$view = Creator::createObject('LoginView');
			$view->create();
			$this->html_output = $view->getHtmlOutput();
			return;
		}
		
		switch ($this->task) {
			case 'edit_password':
				$this->html_output = $this->editPassword();
				break;
			case 'edit_user':
				$this->html_output = $this->editUser();
				break;
			case 'admin_edit_user':
				$this->html_output = $this->adminEditUser();
				break;
			case 'add_user':
				if (!SessionWrapper::isLoggedIn('admin')) {
					$view = Creator::createObject('IndexView');
					$view->create();
					$this->html_output = $view->getHtmlOutput();
					return;
				}
				$this->html_output = $this->addUser();
				break;
			case 'drop_admin':
				if (!SessionWrapper::isLoggedIn('admin') || !isset($_GET['id'])) {
					$view = Creator::createObject('IndexView');
					$view->create();
					$this->html_output = $view->getHtmlOutput();
					return;
				}
				$this->html_output = $this->dropAdmin();
				break;
			case 'drop_student':
				if (!SessionWrapper::isLoggedIn('admin') || !isset($_GET['id'])) {
					$view = Creator::createObject('IndexView');
					$view->create();
					$this->html_output = $view->getHtmlOutput();
					return;
				}
				$this->html_output = $this->dropStudent();
				break;
			case 'drop_teacher':
				if (!SessionWrapper::isLoggedIn('admin') || !isset($_GET['id'])) {
					$view = Creator::createObject('IndexView');
					$view->create();
					$this->html_output = $view->getHtmlOutput();
					return;
				}
				$this->html_output = $this->dropTeacher();
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

		if (BcryptWrapper::authenticate($validated['password'], $result['password'])) {
			if (isset($_SESSION['student_id'])) {
				$controller = Creator::createObject('StudentController');
				$controller->set('edit_password_success');
			} else if (isset($_SESSION['teacher_id'])) {
				$controller = Creator::createObject('TeacherController');
				$controller->set('edit_password_success');
			} else if (isset($_SESSION['admin_id'])) {
				$controller = Creator::createObject('AdministratorController');
				$controller->set('edit_password_success');
			} else {
				die();
			}

			$validated['new_password'] = BcryptWrapper::hashPassword($validated['new_password']);
			$model->setValidatedInput($validated);
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
		$validated['user_address'] = $obj->validateString('user_address', $tainted, 3, 80);
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
			$controller = Creator::createObject('AdministratorController');
			$controller->set('edit_profile_success');
		} else {
			die();
		}

		$controller->createHtmlOutput();
		return $controller->getHtmlOutput();	
	}

	private function adminEditUser() {
		$obj = Creator::createObject('Validate');
		$tainted = $_POST;
		$validated['user_fullname'] = $obj->validateString('user_fullname', $tainted, 5, 50);
		$validated['username'] = $obj->validateEmail($tainted, 'user_email');
		$validated['user_gender'] = $obj->validateString('user_gender', $tainted, 1, 8);
		$validated['user_dob'] = $obj->validateDate('user_dob', $tainted);
		$validated['user_address'] = $obj->validateString('user_address', $tainted, 3, 80);
		$validated['user_id'] = $tainted['user_id'];

		$controller = Creator::createObject('AdministratorController');
		$controller->set('edit_user_admin');

		foreach ($validated as $item) {
			if ($item === false) {
				$_SESSION['msg'] = 'Cannot edit user.';
				$_GET['id'] = $validated['user_id'];
				$controller->createHtmlOutput();
				return $controller->getHtmlOutput();
			}
		}

		$db_handle = Creator::createDatabaseConnection();
		$model = Creator::createObject('UserModel');
		$model->setDatabaseHandle($db_handle);
		$model->setValidatedInput($validated);
		$data = $model->getUser();
		if ($data !== false) {
			if ($data['user_id'] !== $validated['user_id']) {
				$_SESSION['msg'] = 'Cannot edit User.';
				$_GET['id'] = $validated['user_id'];
				$controller->createHtmlOutput();
				return $controller->getHtmlOutput();
			}
		}

		$model->editUser();
		$_GET['id'] = $validated['user_id'];
		$_SESSION['msg'] = 'Success! Details updated.';
		$controller->createHtmlOutput();
		return $controller->getHtmlOutput();
	}

	private function addUser() {
		$db_handle = Creator::createDatabaseConnection();
		$tainted = $_POST;

		if (!isset($_POST['type'])) {
			$view = Creator::createObject('IndexView');
			$view->create();
			return $view->getHtmlOutput();
		}

		$validated = $this->validateUser($tainted);

		if (!$validated) {
			$_SESSION['msg'] = 'Cannot add new user.';
			$controller = Creator::createObject('AdministratorController');
			$controller->set('add_user_view');
			$controller->createHtmlOutput();
			return $controller->getHtmlOutput();
		}

		$model = Creator::createObject('UserModel');
		$model->setDatabaseHandle($db_handle);
		$model->setValidatedInput($validated);

		if ($model->getUser() !== false) {
			$_SESSION['msg'] = 'Cannot add new user.';
			$controller = Creator::createObject('AdministratorController');
			$controller->set('add_user_view');
			$controller->createHtmlOutput();
			return $controller->getHtmlOutput();
		}

		$model->addUser();
		$res = $model->getUser();
		$validated['user_id'] = $res['user_id'];

		switch ($_POST['type']) {
			case '0':
				$model = Creator::createObject('StudentModel');
				break;
			case '1':
				$model = Creator::createObject('TeacherModel');
				break;
			case '2':
				$model = Creator::createObject('AdministratorModel');
				break;
			default:
				$view = Creator::createObject('IndexView');
				$view->create();
				return $view->getHtmlOutput();
		}

		$model->setDatabaseHandle($db_handle);
		$model->setValidatedInput($validated);
		$model->addRecord();
		$_SESSION['msg'] = 'Success! User has been added';
		$controller = Creator::createObject('AdministratorController');
		$controller->set('add_user_view');
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
			$controller = Creator::createObject('AdministratorController');
			$controller->set($val);
		} else {
			die();
		}

		$controller->createHtmlOutput();
		return $controller->getHtmlOutput();
	}

	private function validateUser($tainted) {
		$obj = Creator::createObject('Validate');
		$validated['firstname'] = $obj->validateString('firstname', $tainted, 2, 25);
		$validated['lastname'] = $obj->validateString('lastname', $tainted, 2, 25);
		$validated['username'] = $obj->validateEmail($tainted, 'email');
		$validated['password'] = $obj->validateString('password', $tainted, 4, 50);
		$day = $obj->validateNumber($tainted, 'day', 2);
		$month = $obj->validateNumber($tainted, 'month', 2);
		$year = $obj->validateNumber($tainted, 'year', 4);
		if ($day === false || $month === false || $year === false) {
			return false;
		} 

		if (checkdate($month, $day, $year) !== false) {
			$validated['date'] = $year . '-' . $month . '-' . $day;
		} else {
			$validated['date'] = false;
		}

		$validated['gender'] = $obj->validateGender($tainted, 'gender');
		$validated['user_address'] = $obj->validateString('addr1', $tainted, 3, 40) . ' ' . $obj->validateString('addr2', $tainted, 0, 40); 

		if (!$obj->check($validated)) {
			return false;
		} else {
			$validated['password'] = BcryptWrapper::hashPassword($validated['password']);
			return $validated;
		}
	}

	private function dropAdmin() {
		$id = $_GET['id'];
		$db_handle = Creator::createDatabaseConnection();
		$model = Creator::createObject('UserModel');
		$model->setDatabaseHandle($db_handle);
		$model->setValidatedInput(['user_id' => $id]);
		$model->dropUser();

		$controller = Creator::createObject('AdministratorController');
		$controller->set('view_admins');
		$controller->createHtmlOutput();
		return $controller->getHtmlOutput();
	}

	private function dropStudent() {
		$id = $_GET['id'];
		$db_handle = Creator::createDatabaseConnection();
		$model = Creator::createObject('UserModel');
		$model->setDatabaseHandle($db_handle);
		$model->setValidatedInput(['user_id' => $id]);
		$model->dropUser();

		$controller = Creator::createObject('AdministratorController');
		$controller->set('view_students');
		$controller->createHtmlOutput();
		return $controller->getHtmlOutput();
	}

	private function dropTeacher() {
		$id = $_GET['id'];
		$db_handle = Creator::createDatabaseConnection();
		$model = Creator::createObject('UserModel');
		$model->setDatabaseHandle($db_handle);
		$model->setValidatedInput(['user_id' => $id]);
		$model->dropUser();

		$controller = Creator::createObject('AdministratorController');
		$controller->set('view_teachers');
		$controller->createHtmlOutput();
		return $controller->getHtmlOutput();
	}
}