<?php

class AdministratorGroupsView extends AdministratorView {
	public function __construct() {
		parent::__construct();
	}

	public function create() {
		$this->page_title = APP_NAME . ' Administrator Assessments View';
		$this->createPage();
	}

	public function addAdminPageContent() {
		$target_file = ROOT_PATH;
		$teachers = $this->buildComboBox();
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
										onclick="location.href='$target_file?route=admin_main'"><i class='icon-left'></i></button>
									</div>
									<div class='col-lg-8'>
										<h4 class="my-0 font-weight-normal text-center">Groups</h4>
									</div>
									<div class='col-lg-2'></div>
								</div>
							</div>
							<div class='card-body'>
								<div style='overflow-x: auto;'>
								<table style='width: 100%;'>
									<tr class='text-center'>
										<th>Code</th>
										<th>Name</th>
										<th>Teacher ID</th>
										<th>Teacher Name</th>
										<th>Students</th>
										<th>Sessions</th>
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
				<div class='modal fade' id='edit-modal' tabindex='-1' role='dialog' aria-labelledby='Edit Session' aria-hidden='true'>
					<div class='modal-dialog modal-dialog-centered' role='document'>
						<div class='modal-content'>
							<div class='modal-body text-center'>
								<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
									<span aria-hidden='true'>x</span></button>
									<h3>Edit Group</h3>
									<form method='post' action='$target_file'>
										<select class='form-control mb-3' name='teacher_id' required id='input-id'>
											$teachers
										</select>
										<input type='text' name='name' class='form-control mb-3'
										required placeholder="Group Name" id='input-name'>
										<input type='hidden' name='group_code' id='id-code' value=''>
										<button type='submit' name='route' value='edit_group' class='btn btn-info'>Submit</button>
									</form>
							</div>
						</div>
					</div>
				</div>
				<script>
					function open() {
					$('#confirm-modal').modal('show');
					$('#edit-modal').modal('show');
						$(function() {
							$('[data-toogle="tooltip"]').tooltip()
						})
					}
					function setDelete(code) {
						document.getElementById('div-code').innerHTML = code;
					}
					function continueDelete() {
						var x = document.getElementById('div-code').innerHTML;
						location.href = '$target_file?route=drop_group&code=' + x;
					}
					function setValues(code, name, id) {
						document.getElementById('id-code').value = code;
						document.getElementById('input-id').value = id;
						document.getElementById('input-name').value = name;
					}
				</script>
		HTML;
	}

	private function buildTable() {
		$output = '';
		$target_file = ROOT_PATH;
		foreach ($this->personal_details['groups'] as $item) {
			$code = $item['group_code'];
			$group_name = $item['group_name'];
			$teacher_id = $item['teacher_id'];
			$teacher_name = $item['fullname'];
			$output .= <<< HTML
				<tr class='text-center'>
					<td>$code</td>
					<td>$group_name</td>
					<td>$teacher_id</td>
					<td>$teacher_name</td>
					<div hidden id='div-code'></div>
					<td><button class='btn btn-info m-1' 
					onclick="location.href='$target_file?route=group_students&code=$code'"><i class='icon-search'></i></button></td>
					<td><button class='btn btn-info m-1'
					onclick="location.href='$target_file?route=group_sessions&code=$code'"><i class='icon-search'></i></button></td>
					<td><button class='btn btn-success m-1' onclick='setValues("$code", "$group_name", $teacher_id)' data-toggle='modal' data-target='#edit-modal'><i class='icon-pencil'></i></button></td>
					<td><button class='btn btn-danger m-1' data-toggle='modal' data-target='#confirm-modal'
					 onclick='setDelete("$code")'><i class='icon-trash'></i></button></td>
				</tr>
			HTML;
		}

		return $output;
	}

	private function buildComboBox() {
		$output = '';

		foreach ($this->personal_details['teachers'] as $item) {
			$id = $item['teacher_id'];
			$name = $item['user_fullname'];
			$output .= <<< HTML
				<option value='$id'>$id: $name</option>
			HTML;
		}

		return $output;
	}
}