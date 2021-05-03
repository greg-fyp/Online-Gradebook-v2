<?php

class AdministratorResetPasswordView extends AdministratorView {
	public function __construct() {
		parent::__construct();
	}

	public function create() {
		$this->page_title = APP_NAME . ' Reset Password';
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
										<h4 class="my-0 font-weight-normal text-center">Reset Password</h4>
									</div>
									<div class='col-lg-2'></div>
								</div>
							</div>
							<div class='card-body mt-4'>
								<form method='post' action='$target_file' onsubmit='return check()'>
								<input type='email' name='username' required class='form-control mb-3' placeholder="Enter Username">
								<input type='password' id='inp0' name='password_one' 
								required class='form-control mb-3' placeholder="Create New Password">
								<input type='password' id='inp1' name='password_two' 
								required class='form-control mb-3' placeholder="Repeat Password">
								<label class='text-danger' id='msg' style='display: none;'>Passwords don't match.</label>
								<div class='text-center'>
									<button class='btn btn-info' type='submit' name='route' 
									value='reset_password_process'>Submit</button>
								</div>
								</form>
							</div>
							</div>
						</div>
			</div>
			</div>
			<script>
				function check() {
					if (document.getElementById('inp0').value !== document.getElementById('inp1').value) {
						document.getElementById('msg').style.display = 'block';
						return false;
					} else {
						return true;
					}
				}
			</script>
		HTML;
	}
}