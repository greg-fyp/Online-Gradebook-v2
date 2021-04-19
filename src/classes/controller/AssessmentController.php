<?php

class AssessmentController extends Controller {
	private $x;

	public function createHtmlOutput() {
		switch ($this->task) {
			case 'add_assessment':
				$this->html_output = $this->addAssessment();
				break;
			case 'drop_assessment':
				$this->html_output = $this->dropAssessment();
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

		$controller = Creator::createObject('TeacherController');
		$controller->set('assessments');
		$_GET['code'] = $validated_input['code'];
		$controller->createHtmlOutput();
		return $controller->getHtmlOutput();
	}

	private function dropAssessment() {
		if (!isset($_GET['id'])) {
			$index = Creator::createObject('IndexView');
			$index->create();
			return $index->getHtmlOutput();
		}

		$obj = Creator::createObject('Validate');
		$validated['assessment_id'] = $obj->validateNumber($_GET, 'id', 7);

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