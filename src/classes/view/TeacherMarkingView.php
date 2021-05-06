<?php

class TeacherMarkingView extends TeacherView {
	public function __construct() {
		parent::__construct();
		$this->addStylesheet(CSS_PATH . 'teacher.css');
	}

	public function create() {
		$this->page_title = APP_NAME . ' Marking';
		$this->createPage();
	}

	public function addTeacherPageContent() {
		$target_file = ROOT_PATH;
		$assessment = $this->personal_details['assessment'][0];
		$title = $assessment['assessment_title'];
		$code = $assessment['group_code'];
		$assessment_id = $assessment['assessment_id'];
		$data_table = $this->buildTable();
		$this->html_output .= <<< HTML
			<div class='col-lg-12'>
				<div class='card-deck mb-3 mt-4'>
						<div class='card mb-4 box-shadow'>
							<div class='card-header'>
								<div class='row'>
									<div class='col-lg-2'>
										<button class='btn btn-info' 
										onclick="location.href='$target_file?route=view_assessments&code=$code'"><i class='icon-left'></i></button>
									</div>
									<div class='col-lg-8'>
										<h4 class="my-0 font-weight-normal text-center">$title - Results</h4>
									</div>
									<div class='col-lg-2'></div>
								</div>
							</div>
							<div class='card-body'>
								<div style='overflow-x: auto;'><table class='table'>
									<thead>
										<tr class='text-center'>
											<th scope='col'>Student ID</th>
											<th scope='col'>Student Name</th>
											<th scope='col'>Result</th>
											<th scope='col'>Feedback</th>
											<th scope='col'>Change</th>
											<th scope='col'>View Profile</th>
										</tr>
									</thead>
									<tbody>
										$data_table
									</tbody>
								</table>
								</div>
							</div>
						</div>
						</div>
			</div>
			<div class='modal fade' id='feedback-modal' tabindex='-1' role='dialog' aria-labelledby='See feedback' aria-hidden='true'>
					<div class='modal-dialog modal-dialog-centered' role='document'>
						<div class='modal-content'>
							<div class='modal-header border-bottom-0'>
								<b>Feedback</b>
								<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
									<span aria-hidden='true'>x</span>
								</button>
							</div>
							<div class='modal-body'>
								<div id='content' class='text-center'></div>
							</div>
						</div>
					</div>
				</div>
				<div class='modal fade' id='edit-modal' tabindex='-1' role='dialog' aria-labelledby='Change Grade' aria-hidden='true'>
					<div class='modal-dialog modal-dialog-centered' role='document'>
						<div class='modal-content'>
							<div class='modal-header border-bottom-0'>
								<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
									<span aria-hidden='true'>x</span>
								</button>
							</div>
							<div class='modal-body'>
								<div class='form-title text-center'>
									<h1 class="h3 mb-3 font-weight-normal">Change Grade</h1>
								</div>
								<form method='post' action='$target_file'>
									<label>Result:</label>
									<input type='number' name='grade' id='grade-input' required 
									class='form-control' min='0' max='100' placeholder="Result">
									<label class='mt-3'>Feedback:</label>
									<input tpye='text' name='feedback' id='feedback-input' required 
									class='form-control' placeholder="Feedback" minlength="4">
									<input type='hidden' name='assessment_id' value='$assessment_id'>
									<input type='hidden' id='student-input' name='student_id'>
									<div class='text-center'>
										<button type='submit' class='btn btn-info mt-3' name='route' value='change_grade'>Save</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				<div class='modal fade' id='view-profile' tabindex='-1' role='dialog' aria-labelledby='View Profile' aria-hidden='true'>
					<div class='modal-dialog modal-dialog-centered' role='document'>
						<div class='modal-content'>
							<div class='modal-body'>
								<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
									<span aria-hidden='true'>x</span>
								</button>
								<div class='form-title text-center'>
									<h1 class="h3 mb-3 font-weight-normal">Student Details</h1>
								</div>
								<div class='text-center'>
								<div class='row ml-2'>
									<div class='col-3'>
										<b>Name:</b>
									</div>
									<div class='col-9'>
										<div id='info-fullname' class='ml-2'></div>
									</div>
								</div>
								<div class='row ml-2'>
									<div class='col-3'>
										<b>Email:</b>
									</div>
									<div class='col-9'>
										<div id='info-email' class='ml-2'></div>
									</div>
								</div>
								<div class='row ml-2'>
									<div class='col-3'>
										<b>Gender:</b>
									</div>
									<div class='col-9'>
										<div id='info-gender' class='ml-2'></div>
									</div>
								</div>
								<div class='row ml-2'>
									<div class='col-3'>
										<b>Birth Date:</b>
									</div>
									<div class='col-9'>
										<div id='info-dob'></div>
									</div>
								</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<script type="text/javascript">
					function open() {
					$('#feedback-modal').modal('show');
					$('#edit-modal').modal('show');
					$('#view-profile').modal('show');
						$(function() {
							$('[data-toogle="tooltip"]').tooltip()
						})
					}
					function expand(id) {
						divId = 'feedback-' + id;
						document.getElementById('content').innerHTML = document.getElementById(divId).innerHTML;
					}
					function setValues(id) {
						divRes = 'result-' + id;
						divFeed = 'feedback-' + id;
						document.getElementById('feedback-input').value = document.getElementById(divFeed).innerHTML;
						document.getElementById('grade-input').value = document.getElementById(divRes).innerHTML;
						document.getElementById('student-input').value = id;
					}
					function setInfo(fullname, email, gender, dob) {
						document.getElementById('info-fullname').innerHTML = fullname;
						document.getElementById('info-email').innerHTML = email;
						document.getElementById('info-gender').innerHTML = gender;
						document.getElementById('info-dob').innerHTML = dob;
					}
				</script>
		HTML;
	}

	private function buildTable() {
		$output = '';
		foreach ($this->personal_details['students'] as $student) {
			$id = $student['student_id'];
			$fullname = $student['user']['user_fullname'];
			$email = $student['user']['user_email'];
			$gender = $student['user']['user_gender'];
			$dob = $student['user']['user_dob'];
			$address = $student['user']['user_address'];
			if (empty($student['result'])) {
				$result = '-';
				$feedback = '';
			} else {
				$result = $student['result'][0]['grade'];
				$feedback = $student['result'][0]['feedback'];
			}

			$output .= <<< HTML
				<tr class='text-center'>
					<th scope='row'>$id</th>
					<td>$fullname</td>
					<td>$result</td>
					<div hidden id='feedback-$id'>$feedback</div>
					<div hidden id='result-$id'>$result</div>
					<td><i class='icon-comment feedback' data-toggle='modal' data-target='#feedback-modal' onclick='expand($id)'></i></td>
					<td><button class='btn btn-info pl-4 pr-4' data-toggle='modal' data-target='#edit-modal' onclick='setValues($id)'>
					<i class='icon-pencil'></i></button></td>
					<td><button class='btn btn-info pl-4 pr-4' data-toggle='modal' 
					data-target='#view-profile' onclick="setInfo('$fullname', '$email', '$gender', '$dob')">
					<i class='icon-user'></i></button></td>
				</tr>
			HTML;
		}
		return $output;
	}
}