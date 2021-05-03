<?php

class AdministratorAddUserView extends AdministratorView {
	public function __construct() {
		parent::__construct();
	}

	public function create() {
		$this->page_title = APP_NAME . ' Add User';
		$this->createPage();
	}

	public function addAdminPageContent() {
		$target_file = ROOT_PATH;
		$msg = '';

		if (isset($_SESSION['msg'])) {
			$msg = $_SESSION['msg'];
			unset($_SESSION['msg']);
		}

		$this->html_output .=  <<< HTML
			$msg
			<div class='col-lg-12'>
				<div class='card-deck mb-3 mt-4'>
				<div class='card mb-4 box-shadow'>
					<div class='card-header'>
						<div class='row'>
									<div class='col-lg-2'>
										<button class='btn btn-info' 
										onclick="location.href='$target_file?route=admin_main'"><i class='icon-left'></i></button>
									</div>
									<div class='col-lg-8'>
										<h4 class='text-center'>Add User</h4>
									</div>
									<div class='col-lg-2'></div>
								</div>
					</div>
					<div class='card-body container'>
						<div class='row mt-3'>
							<div class='col-lg-1'></div>
							<div class='col-lg-10'>
							<form method='post' action='$target_file'>
									<div class='row'>
										<div class='col-lg-6'>
											<select class='form-control mb-3' name='type' required>
												<option value='-' selected disabled>User Type*</option>
												<option value='0'>Student</option>
												<option value='1'>Teacher</option>
												<option value='2'>Administrator</option>
											</select>
										</div>
										<div class='col-lg-6'>
											<select name='gender' class='form-control mb-3' required>
												<option value='-' selected disabled>Gender*</option>
												<option value='M'>M</option>
												<option value='F'>F</option>
												<option value='X'>Other</option>
											</select>
										</div>
									</div>
									<div class='row'>
										<div class='col-lg-6'>
											<input type='text' name='firstname' placeholder="First Name*" required class='form-control mb-3'>
										</div>
										<div class='col-lg-6'>
											<input type='text' name='lastname' placeholder="Last Name*" required class='form-control mb-3'>
										</div>
									</div>
									<input type='text' name='email' placeholder="Email Address*" required class='form-control mb-3'>
									<div class='row'>
										<div class='col-lg-9'>
											<input type='text' id='field' name='password' 
											placeholder="User Password*" required class='form-control mb-3'>
										</div>
										<div class='col-lg-3'>
											<button class='btn btn-info' type='button' onclick='generatePassword()'>Random</button>
										</div>
									</div>
									<h5 class='text-center'>Date of Birth</h5>
										<div class='row'>
											<div class='col-lg-4'>
												<input type='text' name='day' placeholder="DD*" required pattern='[0-9]+' class='form-control mb-3'>
											</div>
											<div class='col-lg-4'>
												<input type='text' name='month' placeholder="MM*" required pattern='[0-9]+' class='form-control mb-3'>
											</div>
											<div class='col-lg-4'>
												<input type='text' name='year' placeholder="YYYY*" required pattern='[0-9]+' class='form-control mb-3'>
											</div>
										</div>
										<h5 class='text-center'>Address</h5>
										<input type='text' name='addr1' placeholder="Address Line 1*" required class='form-control mb-3'>
										<input type='text' name='addr2' placeholder="Address Line 2*" required class='form-control mb-3'>	
								<div class='text-center'><button type='submit' name='route' value='add_user_process' class='btn btn-info'>Submit</button></div>
							</form>
							</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<script>
				function generatePassword() {
					const charset = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
					var len = charset.length;
					var result = '';
					for (var i=0; i<10; i++) {
						result += charset.charAt(Math.floor(Math.random() * len));
					}
					document.getElementById('field').value = result;
				}
			</script>
		HTML;
	}
}