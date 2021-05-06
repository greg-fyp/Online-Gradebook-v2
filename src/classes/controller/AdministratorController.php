<?php

class AdministratorController extends Controller {
	private $administrator_personal_details;

	public function createHtmlOutput() {
		if (!SessionWrapper::isLoggedIn('admin')) {
			$view = Creator::createObject('LoginView');
			$view->create();
			$this->html_output = $view->getHtmlOutput();
			return;
		}

		$this->getPersonalDetails();

		switch ($this->task) {
			case 'change_password':
				$view = Creator::createObject('AdministratorChangePasswordView');
				break;
			case 'edit_password_success':
				$view = Creator::createObject('AdministratorChangePasswordView');
				$view->addSuccessMsg();
				break;
			case 'edit_password_fail':
				$view = Creator::createObject('AdministratorChangePasswordView');
				$view->addFailMsg();
				break;
			case 'edit_profile':
				$view = Creator::createObject('AdministratorEditProfileView');
				break;
			case 'edit_profile_success':
				$view = Creator::createObject('AdministratorEditProfileView');
				$view->addSuccessMsg();
				break;
			case 'edit_profile_fail':
				$view = Creator::createObject('AdministratorEditProfileView');
				$view->addFailMsg();
				break;
			case 'add_user_view':
				$view = Creator::createObject('AdministratorAddUserView');
				break;
			case 'view_students':
				$view = Creator::createObject('AdministratorStudentsTableView');
				$this->loadStudents();
				break;
			case 'view_teachers':
				$view = Creator::createObject('AdministratorTeachersTableView');
				$this->loadTeachers();
				break;
			case 'view_admins':
				$view = Creator::createObject('AdministratorAdminsTableView');
				$this->loadAdmins();
				break;
			case 'add_user_view':
				$view = Creator::createObject('AdministratorAddUserView');
				break;
			case 'view_quotes':
				$view = Creator::createObject('AdministratorQuotesTableView');
				$this->loadQuotes();
				break;
			case 'add_quote':
				$view = Creator::createObject('AdministratorQuotesTableView');
				$this->addQuote();
				$this->loadQuotes();
				break;
			case 'edit_quote':
				$view = Creator::createObject('AdministratorQuotesTableView');
				$this->editQuote();
				$this->loadQuotes();
				break;
			case 'drop_quote':
				$view = Creator::createObject('AdministratorQuotesTableView');
				$this->dropQuote();
				$this->loadQuotes();
				break;
			case 'reset_password_view':
				$view = Creator::createObject('AdministratorResetPasswordView');
				$this->loadUsers();
				break;
			case 'reset_password_process':
				$view = Creator::createObject('AdministratorResetPasswordView');
				$this->resetPassword();
				break;
			case 'add_group_view':
				$view = Creator::createObject('AdministratorAddGroupView');
				$this->loadTeachers();
				break;
			case 'add_group_process':
				$view = Creator::createObject('AdministratorAddGroupView');
				$this->loadTeachers();
				$this->addGroup();
				break;
			case 'admin_view_documents':
				$view = Creator::createObject('AdministratorDocumentsView');
				$this->loadDocuments();
				break;
			case 'drop_document':
				$view = Creator::createObject('AdministratorDocumentsView');
				$this->dropDocument();
				$this->loadDocuments();
				break;
			case 'edit_document_process':
				$view = Creator::createObject('AdministratorDocumentsView');
				$this->editDocument();
				$this->loadDocuments();
				break;
			case 'upload_document':
				$view = Creator::createObject('AdministratorUploadDocumentView');
				break;
			case 'upload_document_process':
				$view = Creator::createObject('AdministratorUploadDocumentView');
				$this->uploadDocument();
				break;
			case 'admin_view_announcements':
				$view = Creator::createObject('AdministratorGroupListView');
				$view->setAction('view_admin_announcements');
				$this->loadGroups();
				break;
			case 'view_admin_announcements':
				$view = Creator::createObject('AdministratorAnnouncementsView');
				$this->loadAnnouncements();
				break;
			case 'admin_view_assessments':
				$view = Creator::createObject('AdministratorGroupListView');
				$view->setAction('view_admin_assessments');
				$this->loadGroups();
				break;
			case 'view_admin_assessments':
				$view = Creator::createObject('AdministratorAssessmentsView');
				$this->loadAssessments();
				break;
			case 'admin_view_groups':
				$view = Creator::createObject('AdministratorGroupsView');
				$this->loadGroupsAndTeachers();
				$this->loadTeachers();
				break;
			case 'group_students':
				if (!isset($_GET['code'])) {
					$view = Creator::createObject('AdministratorHomeView');
					break;
				}
				$view = Creator::createObject('AdministratorGroupStudentsView');
				$this->loadStudentsFromGroup();
				break;
			case 'group_sessions':
				if (!isset($_GET['code'])) {
					$view = Creator::createObject('AdministratorHomeView');
					break;
				}
				$view = Creator::createObject('AdministratorGroupSessionsView');
				$this->loadSessionsFromGroup();
				break;
			case 'edit_user_admin':
				$view = Creator::createObject('AdministratorEditUserView');
				$this->loadUserDetails();
				break;
			case 'edit_roles':
				$view = Creator::createObject('AdministratorEditRolesView');
				break;
			case 'search_user':
				$view = Creator::createObject('AdministratorEditRolesView');
				$this->search();
				break;
			case 'edit_roles_process':
				$view = Creator::createObject('AdministratorEditRolesView');
				$this->editRoles();
				break;
			case 'admin_institution':
				$view = Creator::createObject('AdministratorInstitutionView');
				$this->getInstitutionDetails();
				break;
			case 'edit_institution':
				$view = Creator::createObject('AdministratorInstitutionView');
				$this->editInstitution();
				$this->getInstitutionDetails();
				break;
			case 'support_requests':
				$view = Creator::createObject('AdministratorSupportView');
				$this->loadRequests();
				break;
			case 'drop_request':
				$view = Creator::createObject('AdministratorSupportView');
				$this->dropRequest();
				$this->loadRequests();
				break;
			default:
				$view = Creator::createObject('AdministratorHomeView');
				break;
		}

		$view->setPersonal($this->administrator_personal_details);
		$view->create();
		$this->html_output = $view->getHtmlOutput();
	}

	public function setPersonalDetails($details) {
		$this->administrator_personal_details = $details;
	}

	private function getPersonalDetails() {
		$db_handle = Creator::createDatabaseConnection();

		$model = Creator::createObject('AdministratorModel');
		$model->setDatabaseHandle($db_handle);
		$model->setValidatedInput(['user_id' => SessionWrapper::getSession('user_id')]);
		$this->administrator_personal_details = $model->getAdmin();

		$model = Creator::createObject('UserModel');
		$model->setDatabaseHandle($db_handle);
		$model->setValidatedInput($this->administrator_personal_details);
		$this->administrator_personal_details['user_id'] = $model->getUserById();
	}

	private function loadStudents() {
		$db_handle = Creator::createDatabaseConnection();
		$model = Creator::createObject('StudentModel');
		$model->setDatabaseHandle($db_handle);
		$this->administrator_personal_details['students'] = $model->getAllStudents();
	}

	private function loadTeachers() {
		$db_handle = Creator::createDatabaseConnection();
		$model = Creator::createObject('TeacherModel');
		$model->setDatabaseHandle($db_handle);
		$this->administrator_personal_details['teachers'] = $model->getAllTeachers();
	}

	private function loadAdmins() {
		$db_handle = Creator::createDatabaseConnection();
		$model = Creator::createObject('AdministratorModel');
		$model->setDatabaseHandle($db_handle);
		$this->administrator_personal_details['admins'] = $model->getAllAdmins();
	}

	private function loadQuotes() {
		$db_handle = Creator::createDatabaseConnection();
		$model = Creator::createObject('QuoteModel');
		$model->setDatabaseHandle($db_handle);
		$this->administrator_personal_details['quotes'] = $model->getAllQuotes();
	}

	private function addQuote() {
		$db_handle = Creator::createDatabaseConnection();
		$model = Creator::createObject('QuoteModel');
		$model->setDatabaseHandle($db_handle);
		
		$obj = Creator::createObject('Validate');
		$tainted = $_POST;
		$author = $obj->validateString('author', $tainted, 1, 32);
		$content = $obj->validateString('content', $tainted, 1, 255);

		if ($author === false || $content === false) {
			return;
		}

		$model->setValidatedInput(['author' => $author, 'content' => $content]);
		$model->addQuote();
	}

	private function editQuote() {
		$db_handle = Creator::createDatabaseConnection();
		$model = Creator::createObject('QuoteModel');
		$model->setDatabaseHandle($db_handle);
		
		$obj = Creator::createObject('Validate');
		$tainted = $_POST;
		$author = $obj->validateString('author', $tainted, 1, 32);
		$content = $obj->validateString('content', $tainted, 1, 255);
		$id = $obj->validateNumber($tainted, 'quote_id', 10);


		if ($author === false || $content === false || $id === false) {
			return;
		}

		$model->setValidatedInput(['author' => $author, 'content' => $content, 'quote_id' => $id]);
		$model->editQuote();
	}

	private function dropQuote() {
		$db_handle = Creator::createDatabaseConnection();
		$model = Creator::createObject('QuoteModel');
		$model->setDatabaseHandle($db_handle);
		
		$obj = Creator::createObject('Validate');
		$tainted = $_GET;
		$id = $obj->validateNumber($tainted, 'id', 10);
		if ($id === false) {
			return;
		}

		$model->setValidatedInput(['quote_id' => $id]);
		$model->dropQuote();
	}

	private function loadUsers() {
		$db_handle = Creator::createDatabaseConnection();
		$model = Creator::createObject('UserModel');
		$model->setDatabaseHandle($db_handle);
		$this->administrator_personal_details['users'] = $model->getAllUsers();
	}

	private function resetPassword() {
		$db_handle = Creator::createDatabaseConnection();
		$obj = Creator::createObject('Validate');
		$tainted = $_POST;
		$validated['username'] = $obj->validateEmail($tainted, 'username');
		$validated['password'] = $obj->validateString('password_one', $tainted, 4, 30);
		$validated['password'] = BcryptWrapper::hashPassword($validated['password']);
		$model = Creator::createObject('UserModel');
		$model->setDatabaseHandle($db_handle);
		$model->setValidatedInput($validated);
		$model->updateUserPassword();
		$_SESSION['msg'] = 'Success! Password has been reset';
	}

	private function addGroup() {
		$db_handle = Creator::createDatabaseConnection();
		$obj = Creator::createObject('Validate');
		$tainted = $_POST;
		$validated['teacher_id'] = $obj->validateNumber($tainted, 'teacher_select', 10);
		$validated['group_code'] = $obj->validateString('group_code', $tainted, 8, 8);
		$validated['group_name'] = $obj->validateString('group_name', $tainted, 1, 32);

		$model = Creator::createObject('GroupModel');
		$model->setDatabaseHandle($db_handle);
		$model->setValidatedInput($validated);

		$result = $model->getGroup();
		if ($result) {
			$_SESSION['msg'] = 'Group with provided code already exists.';
			return;
		}

		$model->addGroup();
		$_SESSION['msg'] = 'Success! group has been added!';
	}

	private function loadDocuments() {
		$db_handle = Creator::createDatabaseConnection();
		$model = Creator::createObject('DocumentModel');
		$model->setDatabaseHandle($db_handle);
		$this->administrator_personal_details['documents'] = $model->getAllDocuments();
	}

	private function dropDocument() {
		if (!isset($_GET['id']) || empty($_GET['id'])) {
			return;
		}
		$db_handle = Creator::createDatabaseConnection();
		$model = Creator::createObject('DocumentModel');
		$model->setDatabaseHandle($db_handle);
		$model->setValidatedInput(['document_id' => $_GET['id']]);
		$model->dropDocument();
	}

	private function editDocument() {
		$db_handle = Creator::createDatabaseConnection();
		if (!isset($_POST['document_id'])) {
			return;
		}

		$model = Creator::createObject('DocumentModel');
		$model->setDatabaseHandle($db_handle);
		$model->setValidatedInput(['document_id' => $_POST['document_id'],
								   'title' => $_POST['title'],
								   'filename' => $_POST['filename'],
								   'description' => $_POST['description']]);
		$model->editDocument();
	}

	private function uploadDocument() {
		// Comes from admin, thorough validation is not needed.
		$db_handle = Creator::createDatabaseConnection();
		if (!isset($_POST['username'])) {
			return;
		}

		$path = 'documents/' . basename($_FILES["userfile"]["name"]);
		if (file_exists($path)) {
			$_SESSION['msg'] = 'File already exists!';
			return;
		}

    	$model = Creator::createObject('DocumentModel');
		$model->setDatabaseHandle($db_handle);
		$model->setValidatedInput(['username' => $_POST['username'],
	                               'title' => $_POST['title'],
	                               'description' => $_POST['description'],
	                               'filename' => $_FILES["userfile"]["name"]]);
		$result = $model->uploadDocument();
		if (!$result) {
			$_SESSION['msg'] = 'Cannot upload file!';
			return;
		} else {
			$_SESSION['msg'] = 'Success! file has been uploaded!';
		}

		if (!move_uploaded_file($_FILES["userfile"]["tmp_name"], $path)) {
			$_SESSION['msg'] = 'Cannot upload file!';
			return;
    	}
	}

	private function loadGroups() {
		$db_handle = Creator::createDatabaseConnection();
		$model = Creator::createObject('GroupModel');
		$model->setDatabaseHandle($db_handle);
		$this->administrator_personal_details['groups'] = $model->getAllGroups();
	}

	public function loadAnnouncements() {
		if (!isset($_GET['code'])) {
			return;
		}

		$db_handle = Creator::createDatabaseConnection();
		$model = Creator::createObject('AnnouncementModel');
		$model->setDatabaseHandle($db_handle);
		$model->setValidatedInput(['code' => $_GET['code']]);
		$this->administrator_personal_details['announcements'] = $model->getAnnouncementsFromGroup();
		$this->administrator_personal_details['code'] = $_GET['code'];
	}

	private function loadAssessments() {
		if (!isset($_GET['code'])) {
			return;
		}

		$db_handle = Creator::createDatabaseConnection();
		$model = Creator::createObject('GradeModel');
		$model->setDatabaseHandle($db_handle);
		$model->setValidatedInput(['group_code' => $_GET['code']]);
		$this->administrator_personal_details['assessments'] = $model->getGroupAssessments();
		$this->administrator_personal_details['code'] = $_GET['code'];
	}

	private function loadGroupsAndTeachers() {
		$db_handle = Creator::createDatabaseConnection();
		$model = Creator::createObject('GroupModel');
		$model->setDatabaseHandle($db_handle);
		$this->administrator_personal_details['groups'] = $model->getAllGroupsAndTeachers();
	}

	private function loadStudentsFromGroup() {
		$db_handle = Creator::createDatabaseConnection();
		$model = Creator::createObject('GroupModel');
		$model->setDatabaseHandle($db_handle);
		$model->setValidatedInput(['code' => $_GET['code']]);
		$this->administrator_personal_details['students'] = $model->getStudents();
		$this->administrator_personal_details['code'] = $_GET['code'];
	}

	private function loadSessionsFromGroup() {
		$db_handle = Creator::createDatabaseConnection();
		$model = Creator::createObject('TimetableModel');
		$model->setDatabaseHandle($db_handle);
		$model->setValidatedInput(['code' => $_GET['code']]);
		$this->administrator_personal_details['sessions'] = $model->getGroupSessions();
		$this->administrator_personal_details['code'] = $_GET['code'];
	}

	private function loadUserDetails() {
		if (!isset($_GET['id'])) {
			$view = Creator::createObject('LoginView');
			return;
		}
		$db_handle = Creator::createDatabaseConnection();
		$model = Creator::createObject('UserModel');
		$model->setDatabaseHandle($db_handle);
		$model->setValidatedInput(['user_id' => $_GET['id']]);
		$this->administrator_personal_details['user'] = $model->getUserById();
	}

	private function search() {
		if (!isset($_GET['u']) || empty($_GET['u'])) {
			return;
		}

		$db_handle = Creator::createDatabaseConnection();
		$model = Creator::createObject('UserModel');
		$model->setDatabaseHandle($db_handle);
		$model->setValidatedInput(['username' => $_GET['u']]);
		$res = $model->getUser();

		if (!$res) {
			$_SESSION['msg'] = 'User Not found.';
			return;
		}

		$foo = '';
		$model->setValidatedInput(['user_id' => $res['user_id']]);
		if ($model->isStudent()) {
			$foo .= 's';
		}

		if ($model->isTeacher()) {
			$foo .= 't';
		}

		if ($model->isAdmin()) {
			$foo .= 'a';
		}

		$this->administrator_personal_details['role'] = $foo;
		$this->administrator_personal_details['searched_user'] = $_GET['u'];
	}

	private function editRoles() {
		$db_handle = Creator::createDatabaseConnection();
		$obj = Creator::createObject('Validate');
		$tainted = $_POST;
		$validated['username'] = $obj->validateEmail($tainted, 'username');
		$model = Creator::createObject('UserModel');
		$model->setDatabaseHandle($db_handle);
		$model->setValidatedInput(['username' => $validated['username']]);

		$user = $model->getUser();
		if (!$user) {
			$_SESSION['msg'] = 'Cannot edit roles.';
			return;
		} 

		if (!isset($_POST['student']) && !isset($_POST['teacher']) && !isset($_POST['admin'])) {
			$_SESSION['msg'] = 'Cannot edit roles.';
			return;
		}

		if (isset($_POST['student'])) {
			$model->setValidatedInput(['user_id' => $user['user_id']]);
			if (!$model->isStudent()) {
				$model->addRoleStudent();
			}
		} else {
			$model->setValidatedInput(['user_id' => $user['user_id']]);
			if ($model->isStudent()) {
				$model->dropRoleStudent();
			}
		}

		if (isset($_POST['teacher'])) {
			$model->setValidatedInput(['user_id' => $user['user_id']]);
			if (!$model->isTeacher()) {
				$model->addRoleTeacher();
			}
		} else {
			$model->setValidatedInput(['user_id' => $user['user_id']]);
			if ($model->isTeacher()) {
				$model->dropRoleTeacher();
			}
		}

		if (isset($_POST['admin'])) {
			$model->setValidatedInput(['user_id' => $user['user_id']]);
			if (!$model->isAdmin()) {
				$model->addRoleAdmin();
			}
		} else {
			$model->setValidatedInput(['user_id' => $user['user_id']]);
			if ($model->isAdmin()) {
				$model->dropRoleAdmin();
			}
		}

		$_SESSION['msg'] = 'Success! Roles have been edited.';
	}

	private function getInstitutionDetails() {
		$db_handle = Creator::createDatabaseConnection();
		$model = Creator::createObject('InstitutionModel');
		$model->setDatabaseHandle($db_handle);
		$this->administrator_personal_details['institution'] = $model->getInstitutionDetails();
	}

	private function editInstitution() {
		$db_handle = Creator::createDatabaseConnection();
		$obj = Creator::createObject('Validate');
		$tainted = $_POST;
		$validated['address'] = $obj->validateString('address', $tainted, 3, 40);
		$validated['phone'] = $obj->validateString('phone', $tainted, 3, 20);
		$validated['email'] = $obj->validateEmail($tainted, 'email');
		$validated['time'] = $obj->validateString('time', $tainted, 1, 50);

		foreach ($validated as $item) {
			if ($item === false) {
				$_SESSION['msg'] = 'Cannot edit details.';
				return;
			}
		}

		$model = Creator::createObject('InstitutionModel');
		$model->setDatabaseHandle($db_handle);
		$model->setValidatedInput($validated);
		$model->edit();
		$_SESSION['msg'] = 'Succes! Data has been edited.';
	}

	private function loadRequests() {
		$db_handle = Creator::createDatabaseConnection();
		$model = Creator::createObject('RequestModel');
		$model->setDatabaseHandle($db_handle);
		$this->administrator_personal_details['requests'] = $model->getRequests();
	}

	private function dropRequest() {
		if (!isset($_GET['id']) || empty($_GET['id'])) {
			return;
		}

		$db_handle = Creator::createDatabaseConnection();
		$model = Creator::createObject('RequestModel');
		$model->setDatabaseHandle($db_handle);
		$model->setValidatedInput(['request_id' => $_GET['id']]);
		$model->dropRequest();
	}
}