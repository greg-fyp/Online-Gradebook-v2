<?php

class AdministratorChangePasswordView extends AdministratorView {
	private $result;

	public function __construct() {
		parent::__construct();
		$this->result = 0;
	}

	public function create() {
		$this->page_title = APP_NAME . ' Administrator Home';
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
		$user_id = $this->personal_details['user_id']['user_id'];
		$msg = '';

		if ($this->result == 1) {
			$msg = <<< HTML
				<div class="alert alert-success" role="alert">
					Success! Password has been changed!
				</div>
			HTML;
		} else if ($this->result == 2) {
			$msg = <<< HTML
				<div class="alert alert-danger" role="alert">
					Password change failed! Try once again.
				</div>
			HTML;
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
										<h4 class="my-0 font-weight-normal text-center">Change Password</h4>
									</div>
									<div class='col-lg-2'></div>
								</div>
							</div>
							<div class='card-body mt-4'>
								<div class='row'>
									<div class='col-lg-2'></div>
									<div class='col-lg-8'>
										<form method='post' action=$target_file onsubmit='return check()'>
											<input type='password' name='old_password' placeholder="Old Password" 
											required class='form-control mb-3'>
											<input type='password' id='inp0' name='new_password' placeholder="New Password" 
											required class='form-control mb-3'>
											<input type='password' id='inp1' name='repeat_password' placeholder="Repeat Password" required class='form-control mb-3'>
											<div class='text-center'>
											<input type='hidden' name='user_id' value='$user_id'>
												<label class='text-danger' id='msg' style='display: none;'>Passwords don't match.</label>
												<button type='submit' class='btn btn-info m-1' name='route' value='edit_password'>Confirm</button>
											</div>
										</form>
									</div>
								</div>
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