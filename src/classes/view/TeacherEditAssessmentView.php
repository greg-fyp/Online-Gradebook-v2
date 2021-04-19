<?php

class TeacherEditAssessmentView extends TeacherView {
	private $result;

	public function __construct() {
		parent::__construct();
		$this->addStylesheet(CSS_PATH . 'teacher.css');
		$this->result = true;
	}

	public function addFailMsg() {
		$this->result = false;
	}

	public function create() {
		$this->page_title = APP_NAME . ' Assessments';
		$this->createPage();
	}

	public function addTeacherPageContent() {
		$msg = '';
		if (!$this->result) {
			$msg = <<< HTML
				<div class="alert alert-danger" role="alert">
					Cannot edit assessment. Incorrect data has been provided.
				</div>
			HTML;
		}
		$target_file = ROOT_PATH;
		$details = $this->personal_details['assessment'][0];
		$title = $details['assessment_title'];
		$weight = $details['assessment_weight'];
		$date = $details['assessment_deadline'];
		$id = $details['assessment_id'];

		$tokens = explode('-', $date);
		$year = $tokens[0];
		$month = $tokens[1];
		$day = $tokens[2];

		$code = $details['group_code'];

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
										onclick="location.href='$target_file?route=view_assessments&code=$code'"><i class='icon-left'></i></button>
									</div>
									<div class='col-lg-8'>
										<h4 class="my-0 font-weight-normal text-center">Edit Assessment</h4>
									</div>
									<div class='col-lg-2'></div>
								</div>
							</div>
							<div class='card-body'>
								<form method='post' action='$target_file'>
									<div class='row'>
										<div class='col-lg-2 col-md-2 text-center'>
											Title:
										</div>
										<div class='col-lg-10 col-md-10'>
											<input type='text' name='title' value='$title' required placeholder="Title" class='form-control'>
										</div>
									</div>
									<div class='row'>
										<div class='col-lg-2 col-md-2 text-center mt-2'>
											Weight:
										</div>
										<div class='col-lg-10 col-md-10 mt-2'>
											<input type='text' name='weight' value='$weight' required placeholder="Weight" class='form-control'>
										</div>
									</div>
									<div class='row'>
										<div class='col-lg-2 col-md-2 text-center mt-2'>
											Date:
										</div>
										<div class='col-lg-3 col-md-3'>
											<input type='text' name='day' value='$day' placeholder="DD" 
											required pattern="[0-9]{2}" class='form-control mt-2'>
										</div>
										<div class='col-lg-3 col-md-3'>
											<input type='text' name='month' value='$month' placeholder="MM" 
											required pattern="[0-9]{2}" class='form-control mt-2'>
										</div>
										<div class='col-lg-4 col-md-4'>
											<input type='text' name='year' value='$year' placeholder="YYYY" 
											required pattern="[0-9]{4}" class='form-control mt-2'>
										</div>
									</div>
									<div class='text-center mt-2'>
										<input type="hidden" name="assessment_id" value='$id'>
										<input type='hidden' name='code' value="$code">
										<button type='submit' class='btn btn-info' name='route' value='edit_assessment'>Save</button>
									</div>
								</form>
							</div>
						</div>
						</div>
					</div>	
				<div class='col-lg-2'></div>
			</div>
			HTML;
	}
}