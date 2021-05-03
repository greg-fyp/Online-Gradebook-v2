<?php

class AdministratorTeachersTableView extends AdministratorView {
	public function __construct() {
		parent::__construct();
	}

	public function create() {
		$this->page_title = APP_NAME . ' Administrator Teachers View';
		$this->createPage();
	}

	public function addAdminPageContent() {
		$target_file = ROOT_PATH;
		$data = $this->buildTable();
		$this->html_output .=  <<< HTML
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
										<h4 class="my-0 font-weight-normal text-center">Teachers</h4>
									</div>
									<div class='col-lg-2'></div>
								</div>
							</div>
							<div class='card-body mt-4'>
								<div style='overflow-x: auto;'>
								<table style='width: 100%;'>
									<tr class='text-center'>
										<th>User ID</th>
										<th>Teacher ID</th>
										<th>Name</th>
										<th>Email</th>
										<th>More</th>
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
			<div class='modal fade' id='more-modal' tabindex='-1' role='dialog' aria-labelledby='More information' aria-hidden='true'>
					<div class='modal-dialog modal-dialog-centered' role='document'>
						<div class='modal-content'>
							<div class='modal-body'>
								<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
									<span aria-hidden='true'>x</span>
								</button>
								<div>
								<div class='row ml-2'>
									<div class='col-3'>
										<b>Gender:</b>
									</div>
									<div class='col-9'>
										<div id='more-gender' class='ml-2'></div>
									</div>
								</div>
								<div class='row ml-2'>
									<div class='col-3'>
										<b>Birth Date:</b>
									</div>
									<div class='col-9'>
										<div id='more-dob'></div>
									</div>
								</div>
								<div class='row ml-2'>
									<div class='col-3'>
										<b>Address:</b>
									</div>
									<div class='col-9'>
										<div id='more-bp'></div>
									</div>
								</div>
								<div class='row ml-2'>
									<div class='col-3'>
										<b>Added:</b>
									</div>
									<div class='col-9'>
										<div id='more-added'></div>
									</div>
								</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<script>
				function open() {
					$('#more-modal').modal('show');
						$(function() {
							$('[data-toogle="tooltip"]').tooltip()
						})
				}
				function setValues(id) {
					var x = 'gender_' + id;
					var y = 'dob_' + id;
					var q = 'address_' + id;
					var z = 'added_' + id;
					document.getElementById('more-gender').innerHTML = document.getElementById(x).innerHTML;
					document.getElementById('more-dob').innerHTML = document.getElementById(y).innerHTML;
					document.getElementById('more-bp').innerHTML = document.getElementById(q).innerHTML;
					document.getElementById('more-added').innerHTML = document.getElementById(z).innerHTML;
				}
			</script>
		HTML;
	}

	private function buildTable() {
		$output = '';
		foreach ($this->personal_details['teachers'] as $item) {
			$user_id = $item['user_id'];
			$student_id = $item['teacher_id'];
			$fullname = $item['user_fullname'];
			$email = $item['user_email'];
			$gender = $item['user_gender'];
			$dob = $item['user_dob'];
			$address = $item['user_address'];
			$added = $item['teacher_added_timestamp'];

			$output .= <<< HTML
				<div hidden id='gender_$user_id'>$gender</div>
				<div hidden id='dob_$user_id'>$dob</div>
				<div hidden id='address_$user_id'>$address</div>
				<div hidden id='added_$user_id'>$added</div>
				<tr class='text-center'>
					<td>$user_id</td>
					<td>$student_id</td>
					<td>$fullname</td>
					<td>$email</td>
					<td><button class='btn btn-info' data-toggle='modal' data-target='#more-modal' onclick='setValues($user_id)'>...</button></td>
					<td><button class='btn btn-success m-1'><i class='icon-pencil'></i></button></td>
					<td><button class='btn btn-danger m-1'><i class='icon-trash'></i></button></td>
				</tr>
			HTML;
		}

		return $output;
	}
}