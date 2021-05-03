<?php

class AnnouncementController extends Controller {
	public function createHtmlOutput() {
		if (!SessionWrapper::isLoggedIn('teacher') && !SessionWrapper::isLoggedIn('admin')) {
			$view = Creator::createObject('LoginView');
			$view->create();
			$this->html_output = $view->getHtmlOutput();
			return;
		}
		switch ($this->task) {
			case 'add':
				$this->html_output = $this->addAnnouncement();
				break;
			case 'edit_announcement':
				$this->html_output = $this->editAnnouncement();
				break;
			case 'drop_announcement':
				$this->html_output = $this->dropAnnouncement();
				break;
		}
	}

		private function addAnnouncement() {
			$obj = Creator::createObject('Validate');
			$tainted = $_POST;
			if (!isset($_POST['code'])) {
				return $this->fail('add_announcement_fail');
			}

			$validated['code'] = $_POST['code'];
			$validated['title'] = $obj->validateString('title', $tainted, 3, 64);
			$validated['content'] = $obj->validateString('content', $tainted, 6, 1024);

			if ($validated['title'] === false || $validated['content'] === false) {
				return $this->fail('add_announcement_fail');
			}

			$db_handle = Creator::createDatabaseConnection();
			$model = Creator::createObject('AnnouncementModel');
			$model->setDatabaseHandle($db_handle);
			$model->setValidatedInput($validated);
			$model->addAnnouncement();

			if (SessionWrapper::isLoggedIn('teacher')) {
				$_GET['code'] = $validated['code'];
				$controller = Creator::createObject('TeacherController');
				$controller->set('view_announcements');
				$controller->createHtmlOutput();
				return $controller->getHtmlOutput();
			} else if (SessionWrapper::isLoggedIn('admin')) {
				$_GET['code'] = $validated['code'];
				$controller = Creator::createObject('AdministratorController');
				$controller->set('view_admin_announcements');
				$controller->createHtmlOutput();
				return $controller->getHtmlOutput();
			} else {
				die();
			}
		}

		private function editAnnouncement() {
			if (!SessionWrapper::isLoggedIn('admin') || !isset($_POST['code'])) {
				$view = Creator::createObject('LoginView');
				$view->create();
				return $view->getHtmlOutput();
			}

			$controller = Creator::createObject('AdministratorController');
			$controller->set('view_admin_announcements');

			$db_handle = Creator::createDatabaseConnection();
			$obj = Creator::createObject('Validate');
			$tainted = $_POST;
			$validated['announcement_id'] = $obj->validateNumber($tainted, 'announcement_id', 10);
			$validated['title'] = $obj->validateString('title', $tainted, 3, 64);
			$validated['content'] = $obj->validateString('content', $tainted, 1, 1024);

			foreach ($validated as $item) {
				if ($item === false) {
					$_SESSION['msg'] = 'Cannot Edit this Announcement! Invalid Data provided.';
					$_GET['code'] = $_POST['code'];
					$controller->createHtmlOutput();
					return $controller->getHtmlOutput();
				}
			}

			$model = Creator::createObject('AnnouncementModel');
			$model->setDatabaseHandle($db_handle);
			$model->setValidatedInput($validated);
			$model->editAnnouncement();

			$_GET['code'] = $_POST['code'];
			$controller->createHtmlOutput();
			return $controller->getHtmlOutput();
		}

		private function dropAnnouncement() {
			if (!SessionWrapper::isLoggedIn('admin') || !isset($_GET['code'])) {
				$view = Creator::createObject('LoginView');
				$view->create();
				return $view->getHtmlOutput();
			}

			$controller = Creator::createObject('AdministratorController');
			$controller->set('view_admin_announcements');

			$code = $_GET['code'];
			$obj = Creator::createObject('Validate');
			$tainted = $_GET;
			$validated['announcement_id'] = $obj->validateNumber($tainted, 'id', 10);

			if (!$validated['announcement_id']) {
				$_SESSION['msg'] = 'Cannot Edit this Announcement! Invalid Data provided.';
				$_GET['code'] = $code;
				$controller->createHtmlOutput();
				return $controller->getHtmlOutput();
			}

			$db_handle = Creator::createDatabaseConnection();
			$model = Creator::createObject('AnnouncementModel');
			$model->setDatabaseHandle($db_handle);
			$model->setValidatedInput($validated);
			$model->dropAnnouncement();

			$_GET['code'] = $code;
			$controller->createHtmlOutput();
			return $controller->getHtmlOutput();
		}

		private function fail($val) {
			if (SessionWrapper::isLoggedIn('teacher')) {
				if (isset($_POST['code'])) {
					$_GET['code'] = $_POST['code'];
				}
				$controller = Creator::createObject('TeacherController');
				$controller->set($val);
				$controller->createHtmlOutput();
				return $controller->getHtmlOutput();
			} else if (SessionWrapper::isLoggedIn('admin')) {

			} else {
				die();
			}
		}
}