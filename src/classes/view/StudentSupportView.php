<?php

class StudentSupportView extends StudentView {
	public function __construct() {
		parent::__construct();
	}

	public function create() {
		$this->page_title = APP_NAME . ' Student Support';
		$this->createPage();
	}

	public function addStudentPageContent() {
		$msg = '';

		if (isset($_SESSION['msg'])) {
			$msg = $_SESSION['msg'];
			unset($_SESSION['msg']);
		}
		$target_file = ROOT_PATH;
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
										onclick="location.href='$target_file?route=student_main'"><i class='icon-left'></i></button>
									</div>
									<div class='col-lg-8'>
										<h4 class="my-0 font-weight-normal text-center">Support</h4>
									</div>
									<div class='col-lg-2'></div>
								</div>
							</div>
							<div class='card-body text-center'>
								<h5>Please provide information about your issue:</h5>
								<form method='post' action='$target_file'>
									<input type='text' name='title' required class='form-control mb-3' placeholder="Title" maxlength="40">
									<textarea maxlength="255" id='content-input' name='content' rows='6' wrap='physical'
										class='col-lg-12 mb-2 form-control'>Content here...</textarea>
									<button type='submit' name='route' value='add_request_student' class='btn btn-info'>Submit</button>
								</form>
							</div>
							</div>
						</div>
					</div>
				</div>	
				</div>
				<div class='col-lg-2'></div>
			</div>
		HTML;
	}
}