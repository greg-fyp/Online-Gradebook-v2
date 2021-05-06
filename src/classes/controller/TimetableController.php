<?php

class TimetableController extends Controller {
	public function createHtmlOutput() {
		if (!SessionWrapper::isLoggedIn('admin')) {
			$view = Creator::createObject('LoginView');
			$view->create();
			$this->html_output = $view->getHtmlOutput();
			return;
		}

		switch ($this->task) {
			case 'edit_session':
				$this->html_output = $this->editSession();
				break;
			case 'drop_session':
				$this->html_output = $this->dropSession();
				break;
			case 'add_session':
				$this->html_output = $this->addSession();
				break;
			case 'add_sessions':
				$this->html_output = $this->addRegular();
				break;
		}
	}

	private function editSession() {
		if (!isset($_POST['code']) || !isset($_POST['session_id'])) {
			$controller = Creator::createObject('AdministratorController');
			$controller->set('main');
			$controller->createHtmlOutput();
			return $controller->getHtmlOutput();
		}

		$controller = Creator::createObject('AdministratorController');
		$controller->set('group_sessions');
		$_GET['code'] = $_POST['code'];

		$obj = Creator::createObject('Validate');
		$tainted = $_POST;
		$validated['session_id'] = $_POST['session_id'];
		$d = $obj->validateNumber($tainted, 'day', 2);
		$m = $obj->validateNumber($tainted, 'month', 3);
		$y = $obj->validateNumber($tainted, 'year', 4);
		if (!checkdate($m, $d, $y)) {
			$_SESSION['msg'] = 'Invalid data provided.';
			$controller->createHtmlOutput();
			return $controller->getHtmlOutput();
		}

		$validated['date'] = $y . '-' . $m . '-' . $d;
		$h = $obj->validateNumber($tainted, 'hour', 2);
		$minute = $obj->validateNumber($tainted, 'minute', 2);
		$validated['start_time'] = $h . ':' . $minute;
		$validated['duration'] = $obj->validateNumber($tainted, 'duration', 1);
		$validated['location'] = $obj->validateString('location', $tainted, 2, 32);

		foreach ($validated as $item) {
			if ($item === false) {
				$_SESSION['msg'] = 'Invalid data provided.';
				$controller->createHtmlOutput();
				return $controller->getHtmlOutput();
			}
		}

		$db_handle = Creator::createDatabaseConnection();
		$model = Creator::createObject('TimetableModel');
		$model->setDatabaseHandle($db_handle);
		$model->setValidatedInput($validated);
		$model->editSession();

		$controller->createHtmlOutput();
		return $controller->getHtmlOutput();
	}
	
	private function dropSession() {
		if (!isset($_GET['code']) || !isset($_GET['id'])) {
			$controller = Creator::createObject('AdministratorController');
			$controller->set('main');
			$controller->createHtmlOutput();
			return $controller->getHtmlOutput();
		}

		$code = $_GET['code'];
		$controller = Creator::createObject('AdministratorController');
		$controller->set('group_sessions');
		$_GET['code'] = $code;
		$validated['session_id'] = $_GET['id'];

		$db_handle = Creator::createDatabaseConnection();
		$model = Creator::createObject('TimetableModel');
		$model->setDatabaseHandle($db_handle);
		$model->setValidatedInput($validated);
		$model->dropSession();

		$controller->createHtmlOutput();
		return $controller->getHtmlOutput();
	}

	private function addSession() {
		if (!isset($_POST['code'])) {
			$controller = Creator::createObject('AdministratorController');
			$controller->set('main');
			$controller->createHtmlOutput();
			return $controller->getHtmlOutput();
		}

		$controller = Creator::createObject('AdministratorController');
		$controller->set('group_sessions');
		$_GET['code'] = $_POST['code'];

		$obj = Creator::createObject('Validate');
		$tainted = $_POST;
		$d = $obj->validateNumber($tainted, 'day', 2);
		$m = $obj->validateNumber($tainted, 'month', 3);
		$y = $obj->validateNumber($tainted, 'year', 4);
		if (!checkdate($m, $d, $y)) {
			$_SESSION['msg'] = 'Invalid data provided.';
			$controller->createHtmlOutput();
			return $controller->getHtmlOutput();
		}

		$validated['date'] = $y . '-' . $m . '-' . $d;
		$h = $obj->validateNumber($tainted, 'hour', 2);
		$minute = $obj->validateNumber($tainted, 'minute', 2);
		$validated['start_time'] = $h . ':' . $minute;
		$validated['duration'] = $obj->validateNumber($tainted, 'duration', 1);
		$validated['location'] = $obj->validateString('location', $tainted, 2, 32);
		$validated['code'] = $_POST['code'];

		foreach ($validated as $item) {
			if ($item === false) {
				$_SESSION['msg'] = 'Invalid data provided.';
				$controller->createHtmlOutput();
				return $controller->getHtmlOutput();
			}
		}

		$db_handle = Creator::createDatabaseConnection();
		$model = Creator::createObject('TimetableModel');
		$model->setDatabaseHandle($db_handle);
		$model->setValidatedInput($validated);
		$model->addSession();

		$controller->createHtmlOutput();
		return $controller->getHtmlOutput();
	}

	private function addRegular() {
		if (!isset($_POST['code'])) {
			$controller = Creator::createObject('AdministratorController');
			$controller->set('main');
			$controller->createHtmlOutput();
			return $controller->getHtmlOutput();
		}

		$controller = Creator::createObject('AdministratorController');
		$controller->set('group_sessions');
		$_GET['code'] = $_POST['code'];
		$obj = Creator::createObject('Validate');
		$tainted = $_POST;

		$start = $obj->validateDate('start', $tainted);
		$end = $obj->validateDate('end', $tainted);

		if ($start > $end) {
			$_SESSION['msg'] = 'Invalid dates provided.';
			$controller->createHtmlOutput();
			return $controller->getHtmlOutput();
		}

		$h = $obj->validateNumber($tainted, 'hour', 2);
		$minute = $obj->validateNumber($tainted, 'minute', 2);
		$validated['start_time'] = $h . ':' . $minute;
		$validated['duration'] = $obj->validateNumber($tainted, 'duration', 1);
		$validated['location'] = $obj->validateString('location', $tainted, 2, 32);
		$validated['code'] = $_POST['code'];
		$validated['day'] = $obj->validateNumber($tainted, 'day', 1);

		$dates = $this->getDatesBetween($start, $end, $validated['day']);
		$db_handle = Creator::createDatabaseConnection();
		$model = Creator::createObject('TimetableModel');
		$model->setDatabaseHandle($db_handle);
		
		foreach ($dates as $item) {
			$validated['date'] = $item;
			$model->setValidatedInput($validated);
			$model->addSession();
		}


		$controller->createHtmlOutput();
		return $controller->getHtmlOutput();
	}

	private function getDatesBetween($start, $end, $day) {
		$endDate = strtotime($end);
		$days=array('0'=>'Monday','1' => 'Tuesday','2' => 'Wednesday','3'=>'Thursday','4' =>'Friday');
		for($i = strtotime($days[$day], strtotime($start)); $i <= $endDate; $i = strtotime('+1 week', $i))
		$date_array[]=date('Y-m-d',$i);

		return $date_array;
	}
}