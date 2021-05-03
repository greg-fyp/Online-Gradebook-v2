<?php

class AdministratorGroupSessionsView extends AdministratorView {
	public function __construct() {
		parent::__construct();
	}

	public function create() {
		$this->page_title = APP_NAME . ' Group Sessions';
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
										<h4 class="my-0 font-weight-normal text-center">$code: Sessions</h4>
									</div>
									<div class='col-lg-2'></div>
								</div>
							</div>
							<div class='card-body'>
								<div class='row'>
									<div class='col-lg-1 mr-4 text-center'>
										<button class='btn btn-info mb-2' data-toggle='modal' data-target='#add-single-modal'>Add Single</button>
									</div>
									<div class='col-lg-1 text-center'>
										<button class='btn btn-info mb-2' data-toggle='modal' data-target='#add-regular-modal'>Add Regular</button>
									</div>
								</div>
								<div style='overflow-x: auto;'>
								<table style='width: 100%;'>
									<tr class='text-center'>
										<th>ID</th>
										<th>Date</th>
										<th>Start Time</th>
										<th>Duration</th>
										<th>Location</th>
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
			<div class='modal fade' id='edit-modal' tabindex='-1' role='dialog' aria-labelledby='Edit Session' aria-hidden='true'>
					<div class='modal-dialog modal-dialog-centered' role='document'>
						<div class='modal-content'>
							<div class='modal-body text-center'>
								<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
									<span aria-hidden='true'>x</span></button>
									<h3>Date</h3>
									<form method='post' action='$target_file'>
										<div class='row mt-3'>
											<div class='col-4'>
												<input type='text' id='input-day' name='day' placeholder="DD"
												class='form-control mb-3' required pattern='[0-9]{2}'>
											</div>
											<div class='col-4'>
												<input type='text' id='input-month' name='month' placeholder="MM"
												class='form-control mb-3' required pattern='[0-9]{2}'>
											</div>
											<div class='col-4'>
												<input type='text' id='input-year' name='year' placeholder="YYYY"
												class='form-control mb-3' required pattern='[0-9]{4}'>
											</div>
										</div>
										<h3 class='text-center mb-3'>Time</h3>
										<div class='row'>
											<div class='col-4'>
												<input type='number' name='hour' min="7" max="16" id='input-hour' required class='form-control mb-3' placeholder="hh">
											</div>
											<div class='col-4'>
												<input type='number' name='minute' min="0" max="59" id='input-minute' required class='form-control mb-3' placeholder="mm">
											</div>
											<div class='col-4'>
												<select class='form-control mb-3' required name='duration' id='input-duration'>
													<option value='0' disabled selected>Duration</option>
													<option value='1'>1</option>
													<option value='2'>2</option>
													<option value='3'>3</option>
													<option value='4'>4</option>
												</select>
											</div>
										</div>
										<input type='text' name='location' id='input-location' required class='form-control mb-3' 
										placeholder="Location">
										<input type='hidden' name='session_id' id='session-input'>
										<input type='hidden' name='code' value='$code'>
										<button type='submit' name='route' value='edit_session' class='btn btn-info'>Submit</button>
									</form>
								</button>
							</div>
						</div>
					</div>
				</div>
				<div class='modal fade' id='add-single-modal' tabindex='-1' role='dialog' aria-labelledby='Add Session' aria-hidden='true'>
					<div class='modal-dialog modal-dialog-centered' role='document'>
						<div class='modal-content'>
							<div class='modal-body text-center'>
								<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
									<span aria-hidden='true'>x</span></button>
									<h3>Date</h3>
									<form method='post' action='$target_file'>
										<div class='row mt-3'>
											<div class='col-4'>
												<input type='text' name='day' placeholder="DD"
												class='form-control mb-3' required pattern='[0-9]{2}'>
											</div>
											<div class='col-4'>
												<input type='text' name='month' placeholder="MM"
												class='form-control mb-3' required pattern='[0-9]{2}'>
											</div>
											<div class='col-4'>
												<input type='text' name='year' placeholder="YYYY"
												class='form-control mb-3' required pattern='[0-9]{4}'>
											</div>
										</div>
										<h3 class='text-center mb-3'>Time</h3>
										<div class='row'>
											<div class='col-4'>
												<input type='number' name='hour' min="7" max="16" required class='form-control mb-3' placeholder="hh">
											</div>
											<div class='col-4'>
												<input type='number' name='minute' min="0" max="59" required class='form-control mb-3' placeholder="mm">
											</div>
											<div class='col-4'>
												<select class='form-control mb-3' required name='duration'>
													<option value='0' disabled selected>Duration</option>
													<option value='1'>1</option>
													<option value='2'>2</option>
													<option value='3'>3</option>
													<option value='4'>4</option>
												</select>
											</div>
										</div>
										<input type='text' name='location' required class='form-control mb-3' 
										placeholder="Location">
										<input type='hidden' name='code' value='$code'>
										<button type='submit' name='route' value='add_session' class='btn btn-info'>Submit</button>
									</form>
								</button>
							</div>
						</div>
					</div>
				</div>
				<div class='modal fade' id='add-regular-modal' tabindex='-1' role='dialog' aria-labelledby='Add Session' aria-hidden='true'>
					<div class='modal-dialog modal-dialog-centered' role='document'>
						<div class='modal-content'>
							<div class='modal-body text-center'>
								<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
									<span aria-hidden='true'>x</span></button>
									<h3>Regular Sessions</h3>
									<form method='post' action='$target_file'>
										<div class='row'>
											<div class='col-2'><label>From:</label></div>
										</div>
										<input type='date' name='start' required class='form-control mb-1'>
										<div class='row'>
											<div class='col-2'><label>To:</label></div>
										</div>
										<input type='date' name='end' required class='form-control mb-3'>
										<div class='row'>
											<div class='col-2'><label>Day:</label></div>
										</div>
										<select class='form-control mb-1' name='day' required>
											<option value='0'>Monday</option>
											<option value='1'>Tuesday</option>
											<option value='2'>Wednesday</option>
											<option value='3'>Thursday</option>
											<option value='4'>Friday</option>
										</select>
										<h3 class='text-center mb-3'>Time</h3>
										<div class='row'>
											<div class='col-4'>
												<input type='number' name='hour' min="7" max="16" required class='form-control mb-3' placeholder="hh">
											</div>
											<div class='col-4'>
												<input type='number' name='minute' min="0" max="59" required class='form-control mb-3' placeholder="mm">
											</div>
											<div class='col-4'>
												<select class='form-control mb-3' required name='duration'>
													<option value='0' disabled selected>Duration</option>
													<option value='1'>1</option>
													<option value='2'>2</option>
													<option value='3'>3</option>
													<option value='4'>4</option>
												</select>
											</div>
										</div>
										<input type='text' name='location' required class='form-control mb-3' 
										placeholder="Location">
										<input type='hidden' name='code' value='$code'>
										<button type='submit' name='route' value='add_sessions' class='btn btn-info'>Submit</button>
									</form>
								</button>
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
					$('#edit-modal').modal('show');
					$('#confirm-modal').modal('show');
					$('#add-single-modal').modal('show');
					$('#add-regular-modal').modal('show');
						$(function() {
							$('[data-toogle="tooltip"]').tooltip()
						})
					}
				function setValues(id) {
					var divDay = 'day_' + id;
					var divMonth = 'month_' + id;
					var divYear = 'year_' + id;
					var divHour = 'hour_' + id;
					var divMinute = 'minute_' + id;
					var divDuration = 'duration_' + id;
					var divLocation = 'location_' + id;
					document.getElementById('input-day').value = document.getElementById(divDay).innerHTML;
					document.getElementById('input-month').value = document.getElementById(divMonth).innerHTML;
					document.getElementById('input-year').value = document.getElementById(divYear).innerHTML;
					document.getElementById('input-hour').value = document.getElementById(divHour).innerHTML;
					document.getElementById('input-minute').value = document.getElementById(divMinute).innerHTML;
					document.getElementById('input-duration').value = document.getElementById(divDuration).innerHTML;
					document.getElementById('input-location').value = document.getElementById(divLocation).innerHTML;
					document.getElementById('session-input').value = id;
				}
				function setDelete(id) {
					document.getElementById('div-id').innerHTML = id;
				}
				function continueDelete() {
					var x = document.getElementById('div-id').innerHTML;
					location.href = '$target_file?route=drop_session&id=' + x + '&code=$code';
				}
			</script>
		HTML;
	}

	private function buildTable() {
		$output = '';
		$target_file = ROOT_PATH;
		foreach ($this->personal_details['sessions'] as $item) {
			$id = $item['session_id'];
			$date = $item['session_date'];
			$start = $item['session_start_time'];
			$duration = $item['session_duration'];
			$location = $item['session_location'];

			$tokens = explode('-', $date);
			$year = $tokens[0];
			$month = $tokens[1];
			$day = $tokens[2];

			$tokens1 = explode(':', $start);
			$hour = $tokens1[0];
			$minute = $tokens1[1];

			$output .= <<< HTML
				<tr class='text-center'>
					<td>$id</td>
					<td>$date</td>
					<td>$start</td>
					<td id='duration_$id'>$duration</td>
					<td id='location_$id'>$location</td>
					<div hidden id='div-id'></div>
					<div hidden id='day_$id'>$day</div>
					<div hidden id='month_$id'>$month</div>
					<div hidden id='year_$id'>$year</div>
					<div hidden id='hour_$id'>$hour</div>
					<div hidden id='minute_$id'>$minute</div>
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