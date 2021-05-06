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
			case 'timetable':
				$view = Creator::createObject('StudentTimetableView');
				if (!isset($_GET['date'])) {
					$view->setBeginDate(date('Y-m-d'));
				} else {
					$view->setBeginDate($_GET['date']);
				}
				
				$this->loadTimetable();
				break;
			case 'announcements':
				$view = Creator::createObject('StudentGroupsView');
				$view->setLink('student_view_announcements');
				$this->loadGroups();
				break;
			case 'view_announcements':
				if (!isset($_GET['code'])) {
					$view = Creator::createObject('IndexView');
					$view->create();
					$this->html_output = $view->getHtmlOutput();
					return;
				}

				$view = Creator::createObject('StudentAnnouncementsView');
				$this->loadAnnouncements($_GET['code']);
				break;
			case 'institution':
				$view = Creator::createObject('StudentInstitutionView');
				$this->getInstitutionDetails();
				break;
			case 'download':
				if (!isset($_GET['file']) || empty($_GET['file'])) {
					$view = Creator::createObject('IndexView');
					$view->create();
					$this->html_output = $view->getHtmlOutput();
					return;
				}
				$view = Creator::createObject('StudentDocumentsView');
				$this->download($_GET['file']);
				$this->loadDocuments();
				break;
			case 'request':
				$view = Creator::createObject('StudentSupportView');
				$this->addRequest();
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

	private function loadTimetable() {
		$db_handle = Creator::createDatabaseConnection();
		$model = Creator::createObject('TimetableModel');
		$model->setDatabaseHandle($db_handle);
		$model->setValidatedInput(['student_id' => SessionWrapper::getSession('student_id')]);
		$this->student_personal_details['sessions'] = $model->getStudentSessions();
	}

	private function loadAnnouncements($code) {
		$this->student_personal_details['code'] = $code;
		$db_handle = Creator::createDatabaseConnection();
		$model = Creator::createObject('AnnouncementModel');
		$model->setDatabaseHandle($db_handle);
		$model->setValidatedInput(['code' => $code]);
		$this->student_personal_details['announcements'] = $model->getAnnouncementsFromGroup();
	}

	private function download($id) {
		$db_handle = Creator::createDatabaseConnection();
		$model = Creator::createObject('DocumentModel');
		$model->setDatabaseHandle($db_handle);
		$model->setValidatedInput(['file_id' => $id,
								   'user_id' => SessionWrapper::getSession('user_id')]);

		$result = $model->getFilename();
		if (empty($result)) {
			$view = Creator::createObject('IndexView');
			$view->create();
			$this->html_output = $view->getHtmlOutput();
			return;
		}

		$name = $result[0]['document_filename'];
		$path = urldecode('documents/' . $name);	

		if (file_exists($path)) {
			header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($path).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($path));
            flush();
            readfile($path);
		} else {
			http_response_code(404);
	        die();
		}
	}

	private function getInstitutionDetails() {
		$db_handle = Creator::createDatabaseConnection();
		$model = Creator::createObject('InstitutionModel');
		$model->setDatabaseHandle($db_handle);
		$this->student_personal_details['institution'] = $model->getInstitutionDetails();
	}

	private function addRequest() {
		$db_handle = Creator::createDatabaseConnection();
		$obj = Creator::createObject('Validate');
		$tainted = $_POST;
		$validated['title'] = $obj->validateString('title', $tainted, 1, 40);
		$validated['content'] = $obj->validateString('content', $tainted, 1, 255);
		$validated['user_id'] = SessionWrapper::getSession('user_id');

		foreach ($validated as $item) {
			if ($validated === false) {
				$_SESSION['msg'] = 'Cannot add request.';
				return;
			}
		}

		$model = Creator::createObject('RequestModel');
		$model->setDatabaseHandle($db_handle);
		$model->setValidatedInput($validated);
		$model->addRequest();

		$_SESSION['msg'] = 'Success! Your support request has been sent.';
	}
}