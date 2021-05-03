<?php

class TeacherSupportView extends TeacherView {
	public function __construct() {
		parent::__construct();
	}

	public function create() {
		$this->page_title = APP_NAME . ' Teacher Support';
		$this->createPage();
	}

	public function addTeacherPageContent() {
		$target_file = ROOT_PATH;
		$this->html_output .= <<< HTML
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
										<h4 class="my-0 font-weight-normal text-center">Support</h4>
									</div>
									<div class='col-lg-2'></div>
								</div>
							</div>
							<div class='card-body'>
								<div class='row'>
									<div class='col-lg-1'>
									</div>
									<div class='col-lg-8 text-center'>
										<div class='row'>
											<div class='col-lg-3'></div>
											<div class='col-lg-3'>
												<div class='contact-icon'><i class='icon-phone'></i></div>
											</div>
											<div class='col-lg-5'>
												<div class='contact-content'>+44 1122334455</div>
											</div>
										</div>
										<div class='row'>
											<div class='col-lg-3'></div>
											<div class='col-lg-3'>
												<div class='contact-icon'><i class='icon-mail'></i></div>
											</div>
											<div class='col-lg-6'>
												<div class='contact-content'>grade@example.com</div>
											</div>
										</div>
										<div class='row'>
											<div class='col-lg-3'></div>
											<div class='col-lg-3'>
												<div class='contact-icon'><i class='icon-calendar'></i></div>
											</div>
											<div class='col-lg-6'>
												<div class='contact-content'>Monday-Friday 9.00-17.00</div>
											</div>
										</div>
									</div>
									<div class='col-lg-3'>
									</div>
								</div>
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