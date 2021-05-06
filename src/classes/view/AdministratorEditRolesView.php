<?php

class AdministratorEditRolesView extends AdministratorView {
	public function __construct() {
		parent::__construct();
	}

	public function create() {
		$this->page_title = APP_NAME . ' Document Upload';
		$this->createPage();
	}

	public function addAdminPageContent() {
		$msg = '';
		if (isset($_SESSION['msg'])) {
			$msg = $_SESSION['msg'];
			unset($_SESSION['msg']);
		}
		$target_file = ROOT_PATH;
		if (!isset($this->personal_details['searched_user'])) {
			$view = $this->generateDisabled();
		} else {
			$view = $this->generateView();
		}
		$this->html_output .=  <<< HTML
			<div class='row'>
			<div class='col-lg-2'></div>
			<div class='col-lg-8'>
				<div class='card-deck mb-3 mt-4'>
						<div class='card mb-4 box-shadow'>
							<div class='card-header'>
								<div class='row'>
									<div class='col-lg-2'>
										<button class='btn btn-info' 
										onclick="location.href='$target_file?route=admin_main'"><i class='icon-left'></i></button>
									</div>
									<div class='col-lg-8'>
										<h4 class="my-0 font-weight-normal text-center">Edit Roles</h4>
									</div>
									<div class='col-lg-2'></div>
								</div>
							</div>
							<div class='ml-3 mt-1'>$msg</div>
							<div class='card-body mt-4 text-center'>
								$view
							</div>
							</div>
						</div>
			</div>
			</div>
			<script>
				function search() {
					if (document.getElementById('username-input').value === '') {
						document.getElementById('error').style.display = 'block';
						return;
					}
					location.href = '$target_file?route=search_user&u=' + document.getElementById('username-input').value;
				}
			</script>
		HTML;
	}

	private function generateDisabled() {
		$output = <<< HTML
			<div class='row mb-2'>
				<div class='col-lg-1'></div>
				<div class='col-lg-8'>
					<input type='text' name='username' class='form-control mb-3' required placeholder='Enter Username' id='username-input'>
				</div>
				<div class='col-lg-2'>
					<button class='btn btn-info' onclick="search()">Search</button>
				</div>
				</div>
				<div id='error' style='color: red; display: none;'>Please enter username.</div>
				<h4 class='mb-3 mt-2'>Roles</h4>
				<div id='disabled-roles'>
					<div class='row'>
						<div class='col-lg-4'>
							<div class="form-check">
								<input class="form-check-input" type="checkbox" value="" id="studentCheck" disabled>
								<label class="form-check-label" for="studentCheck">
									Student
								</label>
							</div>	
							</div>
								<div class='col-lg-4'>
									<div class="form-check">
										<input class="form-check-input" type="checkbox" value="" id="teacherCheck" disabled>
										<label class="form-check-label" for="teacherCheck">
											Teacher
										</label>
									</div>	
								</div>
								<div class='col-lg-4'>
								<div class="form-check">
									<input class="form-check-input" type="checkbox" value="" id="adminCheck" disabled>
									<label class="form-check-label" for="adminCheck">
										Administrator
									</label>
								</div>	
							</div>
					</div>
					<button type='submit' name='route' value='edit_roles_process' disabled class='btn btn-info mt-3'>Submit</button>
				</div>
		HTML;
		return $output;
	}

	private function generateView() {
		$target_file = ROOT_PATH;
		$username = $this->personal_details['searched_user'];
		$role = $this->personal_details['role'];

		if (strpos($role, 's') !== false) {
			$input_student = "<input class='form-check-input' type='checkbox' value='' name='student' id='studentCheck' checked>";
		} else {
			$input_student = "<input class='form-check-input' type='checkbox' value='' name='student' id='studentCheck'>";
		}

		if (strpos($role, 't') !== false) {
			$input_teacher = "<input class='form-check-input' type='checkbox' value='' name='teacher' id='teacherCheck' checked>";
		} else {
			$input_teacher = "<input class='form-check-input' type='checkbox' value='' name='teacher' id='teacherCheck'>";
		}

		if (strpos($role, 'a') !== false) {
			$input_admin = "<input class='form-check-input' type='checkbox' value='' name='admin' id='adminCheck' checked>";
		} else {
			$input_admin = "<input class='form-check-input' type='checkbox' value='' name='admin' id='adminCheck'>";
		}

		$output = <<< HTML
			<form method='post' action='$target_file'>
			<div class='row mb-2'>
				<div class='col-lg-1'></div>
				<div class='col-lg-8'>
					<input type='text' name='username' class='form-control mb-3' required placeholder='Enter Username' id='username-input' value='$username'>
				</div>
				<div class='col-lg-2'>
					<button class='btn btn-info' onclick="search()">Search</button>
				</div>
				</div>
				<div id='error' style='color: red; display: none;'>Please enter username.</div>
				<h4 class='mb-3 mt-2'>Roles</h4>
				<div id='disabled-roles'>
					<div class='row'>
						<div class='col-lg-4'>
							<div class="form-check">
								$input_student
								<label class="form-check-label" for="studentCheck">
									Student
								</label>
							</div>	
							</div>
								<div class='col-lg-4'>
									<div class="form-check">
										$input_teacher
										<label class="form-check-label" for="teacherCheck">
											Teacher
										</label>
									</div>	
								</div>
								<div class='col-lg-4'>
								<div class="form-check">
									$input_admin
									<label class="form-check-label" for="adminCheck">
										Administrator
									</label>
								</div>	
							</div>
					</div>
					<button type='submit' name='route' value='edit_roles_process' class='btn btn-info mt-3'>Submit</button>
					</form>
				</div>
		HTML;

		return $output;
	}
}