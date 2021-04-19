<?php

class TeacherController extends Controller {
	private $teacher_personal_details;

	public function createHtmlOutput() {
		if (!SessionWrapper::isLoggedIn('teacher')) {
			$view = Creator::createObject('LoginView');
			$view->create();
			$this->html_output = $view->getHtmlOutput();
			return;
		}

		$this->getPersonalDetails();

		switch ($this->task) {
			case 'support':
				$view = Creator::createObject('TeacherSupportView');
				break;
			case 'edit':
				$view = Creator::createObject('TeacherUpdateProfileView');
				break;
			case 'edit_profile_fail':
				$view = Creator::createObject('TeacherUpdateProfileView');
				$view->addFailMsg();
				break;
			case 'edit_profile_success':
				$view = Creator::createObject('TeacherUpdateProfileView');
				$view->addSuccessMsg();
				break;
			case 'edit_password':
				$view = Creator::createObject('TeacherEditPasswordView');
				break;
			case 'edit_password_success':
				$view = Creator::createObject('TeacherEditPasswordView');
				$view->addSuccessMsg();
				break;
			case 'edit_password_fail':
				$view = Creator::createObject('TeacherEditPasswordView');
				$view->addFailMsg();
				break;
			case 'edit_assessment_fail':
				$view = Creator::createObject('TeacherEditAssessmentView');
				$view->addFailMsg();
				$this->getAssessment($_GET['id']);
				break;
			case 'assessments':
				if (!isset($_GET['code'])) {
					$view = Creator::createObject('IndexView');
					$view->create();
					$this->html_output = $view->getHtmlOutput();
					return;
				}

				$view = Creator::createObject('TeacherAssessmentsView');
				$this->loadAssessments();
				break;
			case 'add_assessment_fail':
				$view = Creator::createObject('TeacherAssessmentsView');
				$view->addFailMsg();
				$this->loadAssessments();
				break;
			case 'groups':
				$view = Creator::createObject('TeacherGroupsView');
				$this->loadGroups();
				break;
			case 'view_group':
				if (!isset($_GET['code'])) {
					$view = Creator::createObject('IndexView');
					$view->create();
					$this->html_output = $view->getHtmlOutput();
					return;
				}

				$view = Creator::createObject('TeacherSingleGroupView');
				$this->loadStudents();
				break;
			case 'edit_assessment':
				if (!isset($_GET['code'])) {
					$view = Creator::createObject('IndexView');
					$view->create();
					$this->html_output = $view->getHtmlOutput();
					return;
				}

				$view = Creator::createObject('TeacherEditAssessmentView');
				$this->getAssessment($_GET['id']);
				break;
			default:
				$view = Creator::createObject('TeacherHomeView');
				break;
		}

		$view->setPersonal($this->teacher_personal_details);
		$view->create();
		$this->html_output = $view->getHtmlOutput();
	}

	private function loadGroups() {
		$db_handle = Creator::createDatabaseConnection();
		$model = Creator::createObject('GroupModel');
		$model->setDatabaseHandle($db_handle);
		$model->setValidatedInput(['teacher_id' => SessionWrapper::getSession('teacher_id')]);
		$this->teacher_personal_details['groups'] = $model->getTeacherGroups();
	}

	private function getPersonalDetails() {
		$db_handle = Creator::createDatabaseConnection();

		$model = Creator::createObject('TeacherModel');
		$model->setDatabaseHandle($db_handle);
		$model->setValidatedInput(['user_id' => SessionWrapper::getSession('user_id')]);
		$this->teacher_personal_details = $model->getTeacher();

		$model = Creator::createObject('UserModel');
		$model->setDatabaseHandle($db_handle);
		$model->setValidatedInput($this->teacher_personal_details);
		$this->teacher_personal_details['user_id'] = $model->getUserById();

		$model = Creator::createObject('QuoteModel');
		$model->setDatabaseHandle($db_handle);
		$this->teacher_personal_details['quote'] = $model->getQuote();
	}

	private function loadStudents() {
		$db_handle = Creator::createDatabaseConnection();

		$model = Creator::createObject('GroupModel');
		$model->setDatabaseHandle($db_handle);
		$model->setValidatedInput(['group_code' => $_GET['code']]);
		$details = $model->getStudentsFromGroup();
		$students = [];

		$obj = Creator::createObject('UserModel');
		$obj->setDatabaseHandle($db_handle);
		foreach ($details as $item) {
			$obj->setValidatedInput(['user_id' => $item['user_id']]);
			$d = $obj->getUserById();
			$item['user'] = $d;
			array_push($students, $item);
		}

		$this->teacher_personal_details['students'] = $students;
	}

	public function loadAssessments() {
		$db_handle = Creator::createDatabaseConnection();
		$model = Creator::createObject('GradeModel');
		$model->setDatabaseHandle($db_handle);
		$model->setValidatedInput(['group_code' => $_GET['code']]);
		$this->teacher_personal_details['assessments'] = $model->getGroupAssessments();
		$this->teacher_personal_details['group_code'] = $_GET['code'];
	}

	private function getAssessment($id) {
		$db_handle = Creator::createDatabaseConnection();
		$model = Creator::createObject('GradeModel');
		$model->setDatabaseHandle($db_handle);
		$model->setValidatedInput(['assessment_id' => $id]);
		$this->teacher_personal_details['assessment'] = $model->getAssessment();
	}
}