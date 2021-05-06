<?php

class AdministratorInstitutionView extends AdministratorView {
	public function __construct() {
		parent::__construct();
	}

	public function create() {
		$this->page_title = APP_NAME . ' Institution View';
		$this->createPage();
	}

	public function addAdminPageContent() {
		$msg = '';
		if (isset($_SESSION['msg'])) {
			$msg = $_SESSION['msg'];
			unset($_SESSION['msg']);
		}

		$view = $this->generateView();

		$target_file = ROOT_PATH;
		$this->html_output .=  <<< HTML
			<div class='row'>
			<div class='col-lg-1'></div>
			<div class='col-lg-10'>
				<div class='card-deck mb-3 mt-4'>
						<div class='card mb-4 box-shadow'>
							<div class='card-header'>
								<div class='row'>
									<div class='col-lg-2'>
										<button class='btn btn-info' 
										onclick="location.href='$target_file?route=admin_main'"><i class='icon-left'></i></button>
									</div>
									<div class='col-lg-8'>
										<h4 class="my-0 font-weight-normal text-center">Institution Details</h4>
									</div>
									<div class='col-lg-2'></div>
								</div>
							</div>
							<div class='ml-3 mt-1'>$msg</div>
							<div class='card-body mt-4 text-center'>
								<div class='row'>
									<div class='col-lg-1'>
									</div>
									<div class='col-lg-8 text-center'>
								$view
								</div>
							</div>
								<button type='submit' name='route' value='edit_institution' class='btn btn-info mt-2'>Save</button>
							</form>
							</div>
						</div>
			</div>
			</div>
		</div>
		HTML;
	}

	private function generateView() {
		$target_file = ROOT_PATH;
		$address = $this->personal_details['institution'][0]['institution_address'];
		$phone = $this->personal_details['institution'][0]['institution_phone'];
		$email = $this->personal_details['institution'][0]['institution_email'];
		$time = $this->personal_details['institution'][0]['institution_time'];
		$output = <<< HTML
			<form method='post' action='$target_file'>
			<div class='row'>
				<div class='col-lg-1'></div>
				<div class='col-lg-3'>
					<div class='contact-icon'><i class='icon-bank'></i></div>
				</div>
				<div class='col-lg-7 text-center mt-3'>
					<input id='f0' size='40' class='edit_input' type='text' name='address' value='$address' required>
				</div>
				<div class='col-lg-1 text-center mt-3'>
					<i class='icon-btn icon-pencil' onclick='edit("f0")'></i>
				</div>
			</div>
			<div class='row'>
				<div class='col-lg-1'></div>
					<div class='col-lg-3'>
						<div class='contact-icon'><i class='icon-phone'></i></div>
					</div>
					<div class='col-lg-7 text-center mt-3'>
						<input id='f1' size='40' class='edit_input' type='text' name='phone' value='$phone' required>
					</div>
					<div class='col-lg-1 text-center mt-3'>
					<i class='icon-btn icon-pencil' onclick='edit("f1")'></i>
				</div>
			</div>
			<div class='row'>
				<div class='col-lg-1'></div>
					<div class='col-lg-3'>
						<div class='contact-icon'><i class='icon-mail'></i></div>
					</div>
					<div class='col-lg-7 mt-3'>
						<input id='f2' size='40' class='edit_input' type='text' name='email' value='$email' required>
					</div>
					<div class='col-lg-1 text-center mt-3'>
					<i class='icon-btn icon-pencil' onclick='edit("f2")'></i>
				</div>
			</div>
			<div class='row'>
				<div class='col-lg-1'></div>
					<div class='col-lg-3'>
						<div class='contact-icon'><i class='icon-calendar'></i></div>
					</div>
					<div class='col-lg-7 text-center mt-3'>
						<input id='f3' size='40' class='edit_input' type='text' name='time' value='$time' required>
					</div>
					<div class='col-lg-1 text-center mt-3'>
					<i class='icon-btn icon-pencil' onclick='edit("f3")'></i>
				</div>
			</div>
			<script type="text/javascript">
				function edit(id) {
					document.getElementById(id).select();
					flag = true;
				}
			</script>
		HTML;

		return $output;
	}
}