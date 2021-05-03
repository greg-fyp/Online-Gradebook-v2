<?php

class AdministratorAnnouncementsView extends AdministratorView {
	public function __construct() {
		parent::__construct();
	}

	public function create() {
		$this->page_title = APP_NAME . ' Announcements View';
		$this->createPage();
	}

	public function addAdminPageContent() {
		$target_file = ROOT_PATH;
		$msg = '';
		if (isset($_SESSION['msg'])) {
			$msg = $_SESSION['msg'];
			unset($_SESSION['msg']);
		}

		$data_table = $this->buildTable();
		$code = $this->personal_details['code'];
		$this->html_output .=  <<< HTML
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
										onclick="location.href='$target_file?route=admin_view_announcements'"><i class='icon-left'></i></button>
									</div>
									<div class='col-lg-8'>
										<h4 class="my-0 font-weight-normal text-center">$code Announcement</h4>
									</div>
									<div class='col-lg-2'></div>
								</div>
							</div>
							<div class='card-body'>
								<button class='btn btn-info mb-2' data-toggle='modal' data-target='#add-modal'>Add Announcement</button>
								<div style='overflow-x: auto;'>
									<table style='width: 100%' class='text-center'>
										<tr>
											<th scope='col'>ID</th>
											<th scope='col'>Title</th>
											<th scope='col'>Content</th>
											<th scope='col'>Added</th>
											<th scope='col'><div class='text-center'>Edit</div></th>
											<th scope='col'><div class='text-center'>Delete</div></th>
										</tr>
										$data_table
									</table>
								</div>
							</div>
							</div>
						</div>
			</div>
			</div>
			<div class='modal fade' id='content-modal' tabindex='-1' role='dialog' aria-labelledby='See Content' aria-hidden='true'>
					<div class='modal-dialog modal-dialog-centered' role='document'>
						<div class='modal-content'>
							<div class='modal-body text-center'>
								<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
									<span aria-hidden='true'>x</span>
								</button>
								<div id='content' class='text-center'></div>
							</div>
						</div>
					</div>
				</div>
				<div class='modal fade' id='add-modal' tabindex='-1' role='dialog' aria-labelledby='Add Announcements' aria-hidden='true'>
					<div class='modal-dialog modal-dialog-centered' role='document'>
						<div class='modal-content'>
							<div class='modal-body text-center'>
								<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
									<span aria-hidden='true'>x</span>
								</button>
								<div class='form-title text-center'>
									<h1 class="h3 mb-3 font-weight-normal">New Announcement</h1>
									<form method='post' action='$target_file'>
										<input type='text' name='title' class='form-control mb-2' required placeholder="Title">
										<textarea name='content' rows='6' wrap='physical'
										class='col-lg-12 mb-2 form-control'></textarea>
										<input type='hidden' name='code' value='$code'>
										<button type='submit' name='route' value='add_announcement' class='btn btn-info'>Submit</button>
									</form>
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
									<h1 class="h3 mb-3 font-weight-normal">Edit Announcement</h1>
									<form method='post' action='$target_file'>
										<input id='title-input' type='text' name='title' class='form-control mb-2' required placeholder="Title">
										<textarea id='content-input' name='content' rows='6' wrap='physical'
										class='col-lg-12 mb-2 form-control'></textarea>
										<input type='hidden' name='announcement_id' id='announcement-input'>
										<input type='hidden' name='code' value='$code'>
										<button type='submit' name='route' value='edit_announcement' class='btn btn-info'>Submit</button>
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
				<script>
					function open() {
					$('#content-modal').modal('show');
					$('#edit-modal').modal('show');
					$('#add-modal').modal('show');
						$(function() {
							$('[data-toogle="tooltip"]').tooltip()
						})
					}
					function expand(id) {
						divId = 'content_' + id;
						document.getElementById('content').innerHTML = document.getElementById(divId).innerHTML;
					}
					function setValues(id) {
						var divTitle = 'title_' + id;
						var divContent = 'content_' + id;
						document.getElementById('title-input').value = document.getElementById(divTitle).innerHTML;
						document.getElementById('content-input').value = document.getElementById(divContent).innerHTML;
						document.getElementById('announcement-input').value = id;
					}
					function setDelete(id) {
						document.getElementById('div-id').innerHTML = id;
					}
					function continueDelete() {
						var x = document.getElementById('div-id').innerHTML;
						location.href = '$target_file?route=drop_announcement&id=' + x + '&code=$code';
					}
				</script>
		HTML;
	}

	private function buildTable() {
		$target_file = ROOT_PATH;
		$output = '';
		foreach ($this->personal_details['announcements'] as $item) {
			$id = $item['announcement_id'];
			$title = $item['announcement_title'];
			$content = $item['announcement_content'];
			$added = $item['announcement_timestamp'];
			$output .= <<< HTML
				<tr>
				<td>$id</td>
				<td>$title</td>
				<td><i class='icon-comment feedback' data-toggle='modal' data-target='#content-modal' onclick='expand($id)'></td>
				<td>$added</td>
				<div hidden id='div-id'></div>
				<div hidden id='title_$id'>$title</div>
				<div hidden id='content_$id'>$content</div>
				<div hidden id='announcement_$id'>$id</div>
				<td><button class='btn btn-success m-1' data-toggle='modal' data-target='#edit-modal' onclick='setValues($id)'>
				<i class='icon-pencil'></i></button></td>
				<td><button class='btn btn-danger m-1' data-toggle='modal' data-target='#confirm-modal'
					 onclick='setDelete($id)'><i class='icon-trash'></i></button></td>
				</tr>
			HTML;
		}

		return $output;
	}
}