<?php

class TeacherAssessmentsView extends TeacherView {
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
					Cannot add new assessment.
				</div>
			HTML;
		}
		$target_file = ROOT_PATH;
		$table_data = $this->buildTable();
		$code = $this->personal_details['group_code'];
		$this->html_output .= <<< HTML
			$msg
			<div class='row'>
				<div class='col-lg-1'></div>
				<div class='col-lg-10'>
					<div class='card-deck mb-3 mt-4'>
						<div class='card mb-4 box-shadow'>
							<div class='card-header'>
								<div class='row'>
									<div class='col-lg-2'>
										<button class='btn btn-info' 
										onclick="location.href='$target_file?route=teacher_groups'">
										<i class='icon-left'></i></button>
									</div>
									<div class='col-lg-8'>
										<h4 class="my-0 font-weight-normal text-center">Assessments</h4>
									</div>
									<div class='col-lg-2'></div>
								</div>
							</div>
							<div class='card-body'>
								<button class=' btn btn-info mb-2'  data-toggle='modal' data-target='#add-modal'>Add Assessment</button>
								<div style='overflow-x: auto;'><table class='table'>
									<thead>
										<tr>
											<th scope='col'>#</th>
											<th scope='col' class='text-center'>Assessment Title</th>
											<th scope='col' class='text-center'>Assessment Weight</th>
											<th scope='col' class='text-center'>View</th>
											<th scope='col' class='text-center'>Edit</th>
											<th scope='col' class='text-center'>Delete</th>
										</tr>
									</thead>
									<tbody>
										$table_data
									</tbody>
								</table>
								</div>
							</div>
						</div>
						</div>
					</div>	
				<div class='col-lg-1'></div>
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
				<script>
				function open() {
					$('#add-modal').modal('show');
						$(function() {
							$('[data-toogle="tooltip"]').tooltip()
						})
				}
				function deleteButton(id) {
					if (confirm('Are you sure you want to delete this Assessment?')) {
						location.href='$target_file?route=drop_assessment&id=' + id + '&code=$code';
					}
				}
			</script>
		HTML;
	}

	private function buildTable() {
		$output = '';
		$c = 1;
		$code = $this->personal_details['group_code'];
		foreach ($this->personal_details['assessments'] as $item) {
			$target_file = ROOT_PATH;
			$title = $item['assessment_title'];
			$weight = $item['assessment_weight'];
			$id = $item['assessment_id'];
			$output .= <<< HTML
				<tr>
					<th scope='row'>$c</th>
					<td class='text-center'>$title</td>
					<td class='text-center'>$weight</td>
					<td class='text-center'><button class='btn btn-info'><i class='icon-search'></i></button></td>
					<td class='text-center'><button class='btn btn-success' onclick="location.href='$target_file?route=teacher_edit_assessment&id=$id&code=$code'"><i class='icon-pencil'></i></button></td>
					<td class='text-center'><button class='btn btn-danger' onclick="deleteButton($id)"><i class='icon-trash'></i></button></td>
				</tr>
			HTML;
			$c++;
		}

		return $output;
	}
}