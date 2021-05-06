<?php

class TeacherUpdateProfileView extends TeacherView {
	private $result;

	public function __construct() {
		parent::__construct();
		$this->result = 0;
	}

	public function create() {
		$this->page_title = APP_NAME . ' Teacher Update Profile';
		$this->createPage();
	}

	public function addSuccessMsg() {
		$this->result = 1;
	}

	public function addFailMsg() {
		$this->result = 2;
	}

	public function addTeacherPageContent() {
		$target_file = ROOT_PATH;
		$fullname = $this->personal_details['user_id']['user_fullname'];
		$email = $this->personal_details['user_id']['user_email'];
		$gender = $this->personal_details['user_id']['user_gender'];
		$dob = $this->personal_details['user_id']['user_dob'];
		$address = $this->personal_details['user_id']['user_address'];
		$user_id = $this->personal_details['user_id']['user_id'];
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
										onclick="location.href='$target_file?route=teacher_main'"><i class='icon-left'></i></button>
									</div>
									<div class='col-lg-8'>
										<h4 class="my-0 font-weight-normal text-center">Teacher Profile</h4>
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
										<div class='col-lg-4 col-md-4'>
											<input type='hidden' name='user_fullname' value='$fullname'>
											<label class='pl-3'>$fullname</label>
										</div>
									</div>
								</div>
								<div class='field mt-4'>
									<div class='row'>
										<div class='col-lg-4 col-md-4'>
											<div class='field_name'>Gender</div>
											<input type='hidden' name='user_gender' value='$gender'>
										</div>
										<div class='col-lg-4 col-md-4'>
											<label class='pl-3'>$gender</label>
										</div>
									</div>
								</div>
								<div class='field mt-4'>
									<div class='row'>
										<div class='col-lg-4 col-md-4'>
											<div class='field_name'>Date Of Birth</div>
											<input type='hidden' name='user_dob' value='$dob'>
										</div>
										<div class='col-lg-4 col-md-4'>
											<label class='pl-3'>$dob</label>
										</div>
									</div>
								</div>
								<div style='border-bottom: 1px solid lightgray;'></div>
								<div class='field mt-4'>
									
									<div class='row'>
										<div class='col-lg-4 col-md-4'>
											<div class='field_name'>Email Address</div>
										</div>
										<div class='col-lg-4 col-md-4 text-left'>
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
											<div class='field_name'>Address</div>
										</div>
										<div class='col-lg-4 col-md-4 text-left'>
											<input id='f4' size='40' class='edit_input' type='text' name='user_address' value='$address' required>
										</div>
										<div class='col-lg-4 col-md-4 text-center'>
											<i class='icon-btn icon-pencil' onclick='editFullname("f4")'></i>
										</div>
									</div>
								</div>
								<input type='hidden' name='user_id' value='$user_id'>
								<div class='text-center mt-4'>
									<button type='submit' class='btn btn-info' name='route' value='edit_user' onsubmit="return checkFlag()">Save Profile</button>
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