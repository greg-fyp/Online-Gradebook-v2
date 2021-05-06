<?php

class StudentInstitutionView extends StudentView {
	public function __construct() {
		parent::__construct();
	}

	public function create() {
		$this->page_title = APP_NAME . ' Institution View';
		$this->createPage();
	}

	public function addStudentPageContent() {

		$view = $this->generateView();

		$target_file = ROOT_PATH;
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
										onclick="location.href='$target_file?route=student_main'"><i class='icon-left'></i></button>
									</div>
									<div class='col-lg-8'>
										<h4 class="my-0 font-weight-normal text-center">Institution Details</h4>
									</div>
									<div class='col-lg-2'></div>
								</div>
							</div>
							<div class='card-body mt-4 text-center'>
								<div class='row'>
									<div class='col-lg-1'>
									</div>
									<div class='col-lg-8 text-center'>
								$view
								</div>
							</div>
							</div>
						</div>
			</div>
			</div>
		</div>
		HTML;
	}

	private function generateView() {
		$address = $this->personal_details['institution'][0]['institution_address'];
		$phone = $this->personal_details['institution'][0]['institution_phone'];
		$email = $this->personal_details['institution'][0]['institution_email'];
		$time = $this->personal_details['institution'][0]['institution_time'];
		$output = <<< HTML
			<div class='row'>
				<div class='col-lg-3'></div>
				<div class='col-lg-3'>
					<div class='contact-icon'><i class='icon-bank'></i></div>
				</div>
				<div class='col-lg-6 text-center'>
					<div class='contact-content'>$address</div>
				</div>
			</div>
			<div class='row'>
				<div class='col-lg-3'></div>
					<div class='col-lg-3'>
						<div class='contact-icon'><i class='icon-phone'></i></div>
					</div>
					<div class='col-lg-5 text-center'>
						<div class='contact-content'>$phone</div>
					</div>
			</div>
			<div class='row'>
				<div class='col-lg-3'></div>
					<div class='col-lg-3'>
						<div class='contact-icon'><i class='icon-mail'></i></div>
					</div>
					<div class='col-lg-6'>
						<div class='contact-content'>$email</div>
				</div>
			</div>
			<div class='row'>
				<div class='col-lg-3'></div>
					<div class='col-lg-3'>
						<div class='contact-icon'><i class='icon-calendar'></i></div>
					</div>
					<div class='col-lg-6 text-center'>
						<div class='contact-content'>$time</div>
					</div>
			</div>
		HTML;

		return $output;
	}
}