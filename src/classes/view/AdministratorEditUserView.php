<?php

class AdministratorEditUserView extends AdministratorView {
	private $result;

	public function __construct() {
		parent::__construct();
		$this->result = 0;
	}

	public function create() {
		$this->page_title = APP_NAME . ' Admin Edit User';
		$this->createPage();
	}

	public function addSuccessMsg() {
		$this->result = 1;
	}

	public function addFailMsg() {
		$this->result = 2;
	}

	public function addAdminPageContent() {
		$target_file = ROOT_PATH;
		$fullname = $this->personal_details['user']['user_fullname'];
		$email = $this->personal_details['user']['user_email'];
		$gender = $this->personal_details['user']['user_gender'];
		$dob = $this->personal_details['user']['user_dob'];
		$address = $this->personal_details['user']['user_address'];
		$user_id = $this->personal_details['user']['user_id'];
		$msg = '';

		if ($this->result == 1) {
			$msg = <<< HTML
				<div class="alert alert-success" role="alert">
					Success! Your details have been saved!
				</div>
			HTML;
		} else if ($this->result == 2) {
			$msg = <<< HTML
				<div class="alert alert-danger" role="alert">
					Information change failed! Try once again.
				</div>
			HTML;
		}
		$msg = '';
		if (isset($_SESSION['msg'])) {
			$msg = $_SESSION['msg'];
			unset($_SESSION['msg']);
		}
		$this->html_output .= <<< HTML
			$msg
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
										<h4 class="my-0 font-weight-normal text-center">Edit User</h4>
									</div>
									<div class='col-lg-2'></div>
								</div>
							</div>
							<div class='card-body'>
								<form method='post' action='$target_file'>
								<div class='field'>
									<div class='row'>
										<div class='col-lg-4 col-md-4'>
											<div class='field_name'>Fullname</div>
										</div>
										<div class='col-lg-4 col-md-4 text-center'>
											<input id='f0' class='edit_input' type='text' name='user_fullname' value='$fullname' required>
										</div>
										<div class='col-lg-4 col-md-4 text-center'>
											<i class='icon-btn icon-pencil' onclick='editFullname("f0")'></i>
										</div>
									</div>
								</div>
								<div class='field mt-4'>
									<div class='row'>
										<div class='col-lg-4 col-md-4'>
											<div class='field_name'>Email Address</div>
										</div>
										<div class='col-lg-4 col-md-4 text-center'>
											<input id='f1' class='edit_input' type='email' name='user_email' value='$email' required>
										</div>
										<div class='col-lg-4 col-md-4 text-center'>
											<i class='icon-btn icon-pencil' onclick='editFullname("f1")'></i>
										</div>
									</div>
								</div>
								<div class='field mt-4'>
									<div class='row'>
										<div class='col-lg-4 col-md-4'>
											<div class='field_name'>Gender</div>
										</div>
										<div class='col-lg-4 col-md-4 text-center'>
											<input id='f2' class='edit_input' type='text' name='user_gender' value='$gender' required>
										</div>
										<div class='col-lg-4 col-md-4 text-center'>
											<i class='icon-btn icon-pencil' onclick='editFullname("f2")'></i>
										</div>
									</div>
								</div>
								<div class='field mt-4'>
									<div class='row'>
										<div class='col-lg-4 col-md-4'>
											<div class='field_name'>Date Of Birth</div>
										</div>
										<div class='col-lg-4 col-md-4 text-center'>
											<input id='f3' class='edit_input' type='text' name='user_dob' value='$dob' required>
										</div>
										<div class='col-lg-4 col-md-4 text-center'>
											<i class='icon-btn icon-pencil' onclick='editFullname("f3")'></i>
										</div>
									</div>
								</div>
									<div class='field mt-4'>
									<div class='row'>
										<div class='col-lg-4 col-md-4'>
											<div class='field_name'>Address</div>
										</div>
										<div class='col-lg-4 col-md-4 text-center'>
											<input id='f4' class='edit_input col-12' type='text' name='user_address' value='$address' required>
										</div>
										<div class='col-lg-4 col-md-4 text-center'>
											<i class='icon-btn icon-pencil' onclick='editFullname("f4")'></i>
										</div>
									</div>
								</div>
								<input type='hidden' name='user_id' value='$user_id'>
								<div class='text-center mt-4'>
									<button type='submit' class='btn btn-info' name='route' value='admin_edit_user' onsubmit="return checkFlag()">Save Profile</button>
								</div>
								</form>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class='col-lg-2'></div>
			</div>
			<script type="text/javascript">
				var flag = false;
				function editFullname(id) {
					document.getElementById(id).select();
					flag = true;
				}
				function checkFlag() {
					if (flag) {
						return true;
					} else {
						return false;
					}
				}
			</script>
		HTML;
	}
}