<?php

class AdministratorAssessmentsView extends AdministratorView {
	public function __construct() {
		parent::__construct();
	}

	public function create() {
		$this->page_title = APP_NAME . ' Administrator Assessments View';
		$this->createPage();
	}

	public function addAdminPageContent() {
		$target_file = ROOT_PATH;
		$code = $this->personal_details['code'];
		$data = $this->buildTable();
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
										onclick="location.href='$target_file?route=admin_view_assessments'"><i class='icon-left'></i></button>
									</div>
									<div class='col-lg-8'>
										<h4 class="my-0 font-weight-normal text-center">$code: Assessments</h4>
									</div>
									<div class='col-lg-2'></div>
								</div>
							</div>
							<div class='card-body'>
								<button class='btn btn-info mb-2' data-toggle='modal' data-target='#add-modal'>Add Assessment</button>
								<div style='overflow-x: auto;'>
								<table style='width: 100%;'>
									<tr class='text-center'>
										<th>ID</th>
										<th>Title</th>
										<th>Weight</th>
										<th>Deadline</th>
										<th>Edit</th>
										<th>Delete</th>
									</tr>
									$data
								</table>
							</div>
							</div>
							</div>
						</div>
						</div>
			</div>
			<div class='modal fade' id='edit-modal' tabindex='-1' role='dialog' aria-labelledby='Edit Announcements' aria-hidden='true'>
					<div class='modal-dialog modal-dialog-centered' role='document'>
						<div class='modal-content'>
							<div class='modal-body text-center'>
								<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
									<span aria-hidden='true'>x</span>
								</button>
								<div class='form-title text-center'>
									<h1 class="h3 mb-3 font-weight-normal">Edit Assessment</h1>
									<form method='post' action='$target_file'>
										<input type='text' name='title' id='title-input' required placeholder="Title" class='form-control mb-3'>
										<input type='text' name='weight' id='weight-input' required placeholder="Weight" class='form-control mb-3'>
									<div class='row'>
										<div class='col-lg-4 col-md-4'>
											<input type='text' name='day' id='day-input' placeholder="DD" 
											required pattern="[0-9]{2}" class='form-control mt-2'>
										</div>
										<div class='col-lg-4 col-md-4'>
											<input type='text' name='month' id='month-input' placeholder="MM" 
											required pattern="[0-9]{2}" class='form-control mt-2'>
										</div>
										<div class='col-lg-4 col-md-4'>
											<input type='text' name='year' id='year-input' placeholder="YYYY" 
											required pattern="[0-9]{4}" class='form-control mt-2'>
										</div>
									</div>
									<div class='text-center mt-2'>
										<input type='hidden' name='assessment_id' id='input-id'>
										<input type='hidden' name='code' value="$code">
										<button type='submit' class='btn btn-info' name='route' value='edit_assessment'>Save</button>
									</div>
								</form>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			<div class='modal fade' id='add-modal' tabindex='-1' role='dialog' aria-labelledby='Add Assessment' aria-hidden='true'>
					<div class='modal-dialog modal-dialog-centered' role='document'>
						<div class='modal-content'>
							<div class='modal-header border-bottom-0'>
								<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
									<span aria-hidden='true'>x</span>
								</button>
							</div>
							<div class='modal-body'>
								<div class='form-title text-center'>
									<h1 class="h3 mb-3 font-weight-normal">New Assessment</h1>
								</div>
								<div class='d-flex flex-column text-center'>
									<form method='post' action=$target_file>
										<input type='text' name='title' class='form-control' placeholder="Assessment Title" required>
										<select class='form-control mt-3' name='weight'>
											<option selected value='100.0'>Weight: 100%</option>
											<option value='0.25'>Weight: 25%</option>
											<option value='0.40'>Weight: 40%</option>
											<option value='0.50'>Weight: 50%</option>
											<option value='0.60'>Weight: 60%</option>
											<option value='0.75'>Weight: 75%</option>
										</select>
										<label class='mt-3'><h5>Assessment Date</h5></label>
										<div class='row'>
											<div class='col-lg-4'>
												<input type='text' name='day' class='form-control' placeholder='DD' required pattern='[0-9]{2}'>
											</div>
											<div class='col-lg-4'>
												<input type='text' name='month' class='form-control' placeholder='MM' required pattern='[0-9]{2}'>
											</div>
											<div class='col-lg-4'>
												<input type='text' name='year' class='form-control' placeholder='YYYY' required pattern='[0-9]{4}'>
											</div>
										</div>
										<input type='hidden' name='code' value='$code'>
										<button type='submit' class='btn btn-info mt-3'name='route' value='add_assessment'>Save</button>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class='modal' id='confirm-modal' tabindex='-1' role='dialog' aria-labelledby='Confirm' aria-hidden='true'>
					<div class='modal-dialog modal-dialog-centered' role='document'>
						<div class='modal-content'>
							<div class='modal-body'>
								<div class='form-title text-center'>
									<h1 class="h3 mb-3 font-weight-normal">Confirm</h1>
								</div>
								<p class='text-center'>Are you sure you want to delete this record?</p>
								<div class='row'>
									<div class='col-lg-4'></div>
									<div class='col-lg-2 text-center'>
										<button class='btn btn-info' 
										onclick="continueDelete()">Delete</button>
									</div>
									<div class='col-lg-2 text-center'>
										<button class='btn btn-info' data-dismiss='modal' aria-label='Close'>Cancel</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<script type="text/javascript">
					function open() {
					$('#confirm-modal').modal('show');
					$('#edit-modal').modal('show');
					$('#add-modal').modal('show');
						$(function() {
							$('[data-toogle="tooltip"]').tooltip()
						})
					}
					function setValues(id) {
						var divTitle = 'title_' + id;
						var divWeight = 'weight_' + id;
						var divDay = 'day_' + id;
						var divMonth = 'month_' + id;
						var divYear = 'year_' + id;
						document.getElementById('title-input').value = document.getElementById(divTitle).innerHTML;
						document.getElementById('weight-input').value = document.getElementById(divWeight).innerHTML;
						document.getElementById('day-input').value = document.getElementById(divDay).innerHTML;
						document.getElementById('month-input').value = document.getElementById(divMonth).innerHTML;
						document.getElementById('year-input').value = document.getElementById(divYear).innerHTML;
						document.getElementById('input-id').value = id;
					}
					function setDelete(id) {
					document.getElementById('div-id').innerHTML = id;
					}
					function continueDelete() {
						var x = document.getElementById('div-id').innerHTML;
						location.href = '$target_file?route=drop_assessment&id=' + x + '&code=$code';
					}
				</script>
		HTML;
	}

	private function buildTable() {
		$output = '';
		foreach ($this->personal_details['assessments'] as $item) {
			$id = $item['assessment_id'];
			$title = $item['assessment_title'];
			$weight = $item['assessment_weight'];
			$deadline = $item['assessment_deadline'];
			$tokens = explode('-', $deadline);
			$year = $tokens[0];
			$month = $tokens[1];
			$day = $tokens[2];

			$output .= <<< HTML
				<tr class='text-center'>
					<td>$id</td>
					<td>$title</td>
					<td>$weight</td>
					<td>$deadline</td>
					<div hidden id='title_$id'>$title</div>
					<div hidden id='weight_$id'>$weight</div>
					<div hidden id='day_$id'>$day</div>
					<div hidden id='month_$id'>$month</div>
					<div hidden id='year_$id'>$year</div>
					<div hidden id='div-id'></div>
					<td><button class='btn btn-success m-1' data-toggle='modal' data-target='#edit-modal'
					onclick='setValues($id)'><i class='icon-pencil'></i></button></td>
					<td><button class='btn btn-danger m-1' data-toggle='modal' data-target='#confirm-modal'
					 onclick='setDelete($id)'><i class='icon-trash'></i></button></td>
				</tr>
			HTML;
		}

		return $output;
	}
}