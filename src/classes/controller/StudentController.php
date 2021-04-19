<?php

class StudentController extends Controller {
	private $student_personal_details;

	public function createHtmlOutput() {
		if (!SessionWrapper::isLoggedIn('student')) {
			$view = Creator::createObject('LoginView');
			$view->create();
			$this->html_output = $view->getHtmlOutput();
			return;
		}

		$this->getPersonalDetails();

		switch ($this->task) {
			case 'edit':
				$view = Creator::createObject('StudentUpdateProfileView');
				break;
			case 'edit_password':
				$view = Creator::createObject('StudentEditPasswordView');
				break;
			case 'edit_password_success':
				$view = Creator::createObject('StudentEditPasswordView');
				$view->addSuccessMsg();
				break;
			case 'edit_password_fail':
				$view = Creator::createObject('StudentEditPasswordView');
				$view->addFailMsg();
				break;
			case 'support':
				$view = Creator::createObject('StudentSupportView');
				break;
			case 'edit_profile_fail':
				$view = Creator::createObject('StudentUpdateProfileView');
				$view->addFailMsg();
				break;
			case 'edit_profile_success':
				$view = Creator::createObject('StudentUpdateProfileView');
				$view->addSuccessMsg();
				break;
			case 'view_documents':
				$view = Creator::createObject('StudentDocumentsView');
				$this->loadDocuments();
				break;
			case 'view_grades':
				$view = Creator::createObject('StudentGroupsView');
				$view->setLink('see_grades');
				$this->loadGroups();
				break;
			case 'show_grades':
				$view = Creator::createObject('StudentGradesView');
				if (!isset($_GET['code'])) {
					$view = Creator::createObject('IndexView');
					$view->create();
					$this->html_output = $view->getHtmlOutput();
					return;
				}
				$this->loadGrades();
				$this->loadGroups();
				break;
			case 'view_assessments':
				$view = Creator::createObject('StudentGroupsView');
				$view->setLink('see_assessments');
				$this->loadGroups();
				break;
			case 'view_upcoming':
				$view = Creator::createObject('StudentAssessmentsView');
				$this->loadAssessments();
				break;
			default:
				$view = Creator::createObject('StudentHomeView');
				break;
		}

		$view->setPersonal($this->student_personal_details);
		$view->create();
		$this->html_output = $view->getHtmlOutput();
	}

	private function getPersonalDetails() {
		$db_handle = Creator::createDatabaseConnection();

		$model = Creator::createObject('StudentModel');
		$model->setDatabaseHandle($db_handle);
		$model->setValidatedInput(['user_id' => SessionWrapper::getSession('user_id')]);
		$this->student_personal_details = $model->getStudent();

		$model = Creator::createObject('UserModel');
		$model->setDatabaseHandle($db_handle);
		$model->setValidatedInput($this->student_personal_details);
		$this->student_personal_details['user_id'] = $model->getUserById();

		$model = Creator::createObject('QuoteModel');
		$model->setDatabaseHandle($db_handle);
		$this->student_personal_details['quote'] = $model->getQuote();
	}

	private function loadDocuments() {
		$db_handle = Creator::createDatabaseConnection();
		$model = Creator::createObject('DocumentModel');
		$model->setDatabaseHandle($db_handle);
		$model->setValidatedInput(['user_id' => SessionWrapper::getSession('user_id')]);
		$this->student_personal_details['documents'] = $model->getUserDocuments();
	}

	private function loadGroups() {
		$db_handle = Creator::createDatabaseConnection();
		$model = Creator::createObject('GroupModel');
		$model->setDatabaseHandle($db_handle);
		$model->setValidatedInput(['student_id' => SessionWrapper::getSession('student_id')]);
		$this->student_personal_details['groups'] = $model->getStudentGroups();
	}

	private function loadGrades() {
		$db_handle = Creator::createDatabaseConnection();
		$model = Creator::createObject('GradeModel');
		$model->setDatabaseHandle($db_handle);
		$model->setValidatedInput(['student_id' => SessionWrapper::getSession('student_id'),
								   'group_code' => $_GET['code']]);
		$this->student_personal_details['grades'] = $model->getStudentGrades();
	}

	private function loadAssessments() {
		$db_handle = Creator::createDatabaseConnection();
		$model = Creator::createObject('GradeModel');
		$model->setDatabaseHandle($db_handle);
		$model->setValidatedInput(['student_id' => SessionWrapper::getSession('student_id'),
								   'group_code' => $_GET['code']]);
		$this->student_personal_details['assessments'] = $model->getGroupAssessments();
	}
}