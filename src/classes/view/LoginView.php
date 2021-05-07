<?php

class LoginView extends WelcomeTemplateView {
	private $error_flag;

	public function __construct() {
		parent::__construct();
		$this->addStylesheet(CSS_PATH . 'login.css');
		$this->error_flag = false;
	}

	public function __destruct() {}

	public function create() {
		$this->page_title = APP_NAME . 'Login Page';
		$this->createPage();
	}

	public function addErrorMsg() {
		$this->error_flag = true;
	}

	public function addWelcomePageContent() {
		$target_file = ROOT_PATH;
		$error_msg = '';

		if ($this->error_flag) {
			$error_msg = <<< HTML
				<div class="alert alert-danger" role="alert">
					Login Failed. Try once again.
				</div>
			HTML;
		}

		$this->html_output .= <<< HTML
		<div id='error'>$error_msg</div>
		<div id='content-wrap'>
				<div class='row'>
					<div class='col-sm-6 col-md-4'>
						<button class='btn btn-info btn-lg btn-block btn-tile' data-toggle='modal' data-target='#login-modal'
						onclick="setValue('student')">
						<div style='font-size: 50px;'><i class='icon-user'></i></div>
						<br />Student Login</button>
					</div>
					<div class='col-sm-6 col-md-4'>
						<button class='btn btn-info btn-lg btn-block btn-tile' id='inst-btn' data-toggle='modal' data-target='#login-modal'
						onclick="setValue('teacher')">
						<div style='font-size: 50px;'><i class='icon-bank'></i></div>
						<br />Teacher Login</button>
					</div>
					<div class='col-sm-6 col-md-4'>
						<button class='btn btn-primary btn-lg btn-block btn-tile' data-toggle='modal' data-target='#login-modal'
						onclick="setValue('admin')">
						<div style='font-size: 50px;'><i class='icon-cog-alt'></i></div>
						<br />Administrator Login</button>
					</div>
				<div class='modal fade' id='login-modal' tabindex='-2' role='dialog' aria-labelledby='Login User' aria-hidden='true'>
					<div class='modal-dialog modal-dialog-centered' role='document'>
						<div class='modal-content'>
							<div class='modal-header border-bottom-0'>
								<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
									<span aria-hidden='true'>x</span>
								</button>
							</div>
							<div class='modal-body'>
								<div class='form-title text-center'>
									<h1 class="h3 mb-3 font-weight-normal">Gradebook Login</h1>
								</div>
								<div class='d-flex flex-column text-center'>
									<form class='login-form' method='post' action=$target_file>
										<label for="inputEmail" class="sr-only">Email address</label>
											<div class='input-group'>
												<div class="input-group-prepend">
													<span class="input-group-text" style='font-size: 24px;'>@</span>
												</div>
												<input type="email" id="inputEmail" name='user-email' class="form-control" placeholder="Email address" required autofocus>
											</div>
										<label for="inputPassword" class="sr-only">Password</label>
										<div class='input-group mt-3 mb-4'>
											<div class="input-group-prepend">
												<span class="input-group-text"><i class='icon-key'></i></span>
											</div>
											<input type="password" id="inputPassword" name='password' class="form-control" placeholder="Password" required>
											<input type='hidden' name='login_type' value='' id='type'>
										</div>
										<button class="btn btn-lg btn-info btn-block" type="submit" name='route' value='process_login'>
										Login</button>
										<button type="button" class="btn btn-link mt-3">Forgot Password?</button>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			</div>
			<script>
				function open() {
					$('#login-modal').modal('show');
						$(function() {
							$('[data-toogle="tooltip"]').tooltip()
						})
				}
				function setValue(val) {
					document.getElementById('type').value = val;
				}
			</script>
		HTML;
	}
}