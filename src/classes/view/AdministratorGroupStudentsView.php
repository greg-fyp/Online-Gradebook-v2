<?php

class AdministratorGroupStudentsView extends AdministratorView {
	public function __construct() {
		parent::__construct();
	}

	public function create() {
		$this->page_title = APP_NAME . ' Students From Group';
		$this->createPage();
	}

	public function addAdminPageContent() {
		$target_file = ROOT_PATH;
		$code = $this->personal_details['code'];
		$data = $this->buildTable();
		$msg = '';
		if (isset($_SESSION['msg'])) {
			$msg = $_SESSION['msg'];
			unset($_SESSION['msg']);
		}
		$this->html_output .=  <<< HTML
			$msg
			<div class='col-lg-12'>
				<div class='card-deck mb-3 mt-4'>
						<div class='card mb-4 box-shadow'>
							<div class='card-header'>
								<div class='row'>
									<div class='col-lg-2'>
										<button class='btn btn-info' 
										onclick="location.href='$target_file?route=admin_view_groups'"><i class='icon-left'></i></button>
									</div>
									<div class='col-lg-8'>
										<h4 class="my-0 font-weight-normal text-center">$code: Students</h4>
									</div>
									<div class='col-lg-2'></div>
								</div>
							</div>
							<div class='card-body'>
								<button class='btn btn-info mb-2' data-toggle='modal' data-target='#add-modal'>Add Student</button>
								<div style='overflow-x: auto;'>
								<table style='width: 100%;'>
									<tr class='text-center'>
										<th>ID</th>
										<th>Full Name</th>
										<th>Username</th>
										<th>Remove</th>
									</tr>
									$data
								</table>
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
									<h1 class="h3 mb-3 font-weight-normal">Add Student</h1>
								</div>
								<div class='d-flex flex-column text-center'>
									<form method='post' action=$target_file>
										<input type='email' name='username' required class='form-control mb-3' placeholder="Enter Username*">
										<input type='hidden' name='code' value='$code'>
										<div class='text-center'>
											<button type='submit' name='route' value='assign_student' class='btn btn-info'>Submit</button>
										</div>
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
								<p class='text-center'>Are you sure you want to remove this student from the group?</p>
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
					function setDelete(id) {
					document.getElementById('div-id').innerHTML = id;
					}
					function continueDelete() {
						var x = document.getElementById('div-id').innerHTML;
						location.href = '$target_file?route=drop_relation&id=' + x + '&code=$code';
					}
				</script>
		HTML;
	}

	private function buildTable() {
		$output = '';
		foreach ($this->personal_details['students'] as $item) {
			$student_id = $item['student_id'];
			$fullname = $item['fullname'];
			$email = $item['email'];
			$output .= <<< HTML
				<tr class='text-center'>
					<td>$student_id</td>
					<td>$fullname</td>
					<td>$email</td>
					<div hidden id='div-id'></div>
					<td><button class='btn btn-info m-1' data-toggle='modal' data-target='#confirm-modal'
					 onclick='setDelete($student_id)'>Remove</button></td>
				</tr>
			HTML;
		}

		return $output;
	}
}