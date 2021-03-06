<?php

class AssessmentController extends Controller {
	private $x;

	public function createHtmlOutput() {
		if (!SessionWrapper::isLoggedIn('teacher') && !SessionWrapper::isLoggedIn('admin')) {
			$view = Creator::createObject('LoginView');
			$view->create();
			$this->html_output = $view->getHtmlOutput();
			return;
		}
		switch ($this->task) {
			case 'add_assessment':
				$this->html_output = $this->addAssessment();
				break;
			case 'drop_assessment':
				$this->html_output = $this->dropAssessment();
				break;
			case 'change_grade':
				$this->html_output = $this->changeGrade();
				break;
			case 'edit_assessment':
				$this->html_output = $this->editAssessment();
				break;
		}
	}

	private function addAssessment() {
		$obj = Creator::createObject('Validate');
		$tainted = $_POST;
		$validated_input['title'] = $obj->validateString('title', $tainted, 3, 64);
		$validated_input['weight'] = $obj->validateString('weight', $tainted, 1, 5);
		$this->x = $_POST['code'];
		$d = $obj->validateNumber($tainted, 'day', 2);
		$m = $obj->validateNumber($tainted, 'month', 3);
		$y = $obj->validateNumber($tainted, 'year', 4);
		if (!checkdate($m, $d, $y)) {
			return $this->fail('add_assessment_fail');
		}

		$validated_input['date'] = $y . '-' . $m . '-' . $d;
		$validated_input['code'] = $_POST['code'];

		foreach ($validated_input as $item) {
			if ($item === false) {
				return $this->fail('add_assessment_fail');
			}
		}
		$db_handle = Creator::createDatabaseConnection();

		$model = Creator::createObject('GradeModel');
		$model->setDatabaseHandle($db_handle);
		$model->setValidatedInput($validated_input);
		$model->addAssessment();

		if (isset($_SESSION['teacher_id'])) {
			$controller = Creator::createObject('TeacherController');
			$controller->set('assessments');
			$_GET['code'] = $validated_input['code'];
			$controller->createHtmlOutput();
			return $controller->getHtmlOutput();
		} else if (isset($_SESSION['admin_id'])) {
			$_GET['code'] = $validated_input['code'];
			$controller = Creator::createObject('AdministratorController');
			$controller->set('view_admin_assessments');
			$controller->createHtmlOutput();
			return $controller->getHtmlOutput();
		} else {
			die();
		}
	}

	private function dropAssessment() {
		if (!isset($_GET['id'])) {
			$index = Creator::createObject('IndexView');
			$index->create();
			return $index->getHtmlOutput();
		}

		$obj = Creator::createObject('Validate');
		$validated['assessment_id'] = $obj->validateNumber($_GET, 'id', 7);
		$code = $_GET['code'];

		$db_handle = Creator::createDatabaseConnection();
		$model = Creator::createObject('GradeModel');
		$model->setDatabaseHandle($db_handle);
		$model->setValidatedInput($validated);
		$model->dropAssignments();
		$model->dropAssessment();

		if (isset($_SESSION['teacher_id'])) {
			$controller = Creator::createObject('TeacherController');
			$controller->set('assessments');
			$controller->createHtmlOutput();
			return $controller->getHtmlOutput();
		} else if (isset($_SESSION['admin_id'])) {
			$_GET['code'] = $code;
			$controller = Creator::createObject('AdministratorController');
			$controller->set('view_admin_assessments');
			$controller->createHtmlOutput();
			return $controller->getHtmlOutput();
		} else {
			die();
		}
	}

	private function editAssessment() {
		if (!isset($_POST['code']) || !isset($_POST['assessment_id'])) {
			return $this->fail('edit_assessment_fail');
		}

		$obj = Creator::createObject('Validate');
		$tainted = $_POST;
		$validated_input['assessment_id'] = $_POST['assessment_id'];
		$validated_input['title'] = $obj->validateString('title', $tainted, 3, 64);
		$validated_input['weight'] = $obj->validateWeight('weight', $tainted);
		$this->x = $_POST['code'];
		$d = $obj->validateNumber($tainted, 'day', 2);
		$m = $obj->validateNumber($tainted, 'month', 2);
		$y = $obj->validateNumber($tainted, 'year', 4);
		if (!checkdate($m, $d, $y)) {
			return $this->fail('edit_assessment_fail', $validated_input['assessment_id']);
		}

		$validated_input['date'] = $y . '-' . $m . '-' . $d;

		foreach ($validated_input as $item) {
			if ($item === false) {
				return $this->fail('edit_assessment_fail', $validated_input['assessment_id']);
			}
		}

		$db_handle = Creator::createDatabaseConnection();
		$model = Creator::createObject('GradeModel');
		$model->setDatabaseHandle($db_handle);
		$model->setValidatedInput($validated_input);
		$model->editAssessment();

		if (isset($_SESSION['teacher_id'])) {
			$_GET['code'] = $this->x;
			$controller = Creator::createObject('TeacherController');
			$controller->set('assessments');
			$controller->createHtmlOutput();
			return $controller->getHtmlOutput();
		} else if (isset($_SESSION['admin_id'])) {
			$controller = Creator::createObject('AdministratorController');
			$_GET['code'] = $_POST['code'];
			$controller->set('view_admin_assessments');
			$controller->createHtmlOutput();
			return $controller->getHtmlOutput();
		} else {
			die();
		}

	}

	private function changeGrade() {
		$obj = Creator::createObject('Validate');
		$tainted = $_POST;
		$validated['assessment_id'] = $obj->validateNumber($tainted, 'assessment_id', 6);
		$validated['student_id'] = $obj->validateNumber($tainted, 'student_id', 6);
		$validated['grade'] = $obj->validateNumber($tainted, 'grade', 3);
		$validated['feedback'] = $obj->validateString('feedback', $tainted, 3, 128);

		foreach ($validated as $item) {
			if ($item === false) {
				return $this->fail('change_grade_fail');
			}
		}

		$db_handle = Creator::createDatabaseConnection();
		$model = Creator::createObject('GradeModel');
		$model->setDatabaseHandle($db_handle);
		$model->setValidatedInput($validated);
		$result = $model->getStudentResult();

		if (empty($result)) {
			$model->addGrade();
		} else {
			$model->editGrade();
		}

		if (isset($_SESSION['teacher_id'])) {
			$_GET['id'] = $validated['assessment_id'];
			$controller = Creator::createObject('TeacherController');
			$controller->set('marking_view');
			$controller->createHtmlOutput();
			return $controller->getHtmlOutput();
		} else if (isset($_SESSION['admin_id'])) {

		} else {
			die();
		}


	}

	private function fail($val, $id=0) {
		$controller = Creator::createObject('TeacherController');
		$_GET['code'] = $this->x;
		$_GET['id'] = $id;
		$controller->set($val);
		$controller->loadAssessments();
		$controller->createHtmlOutput();
		return $controller->getHtmlOutput();
	}
}