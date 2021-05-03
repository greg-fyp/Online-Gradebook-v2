<?php

class AdministratorDocumentsView extends AdministratorView {
	public function __construct() {
		parent::__construct();
	}

	public function create() {
		$this->page_title = APP_NAME . ' Administrator Documents View';
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
										<h4 class="my-0 font-weight-normal text-center">Documents</h4>
									</div>
									<div class='col-lg-2'></div>
								</div>
							</div>
							<div class='card-body mt-2'>
								<div style='overflow-x: auto;'>
								<table style='width: 100%;'>
									<tr class='text-center'>
										<th>Document ID</th>
										<th>User ID</th>
										<th>Title</th>
										<th>Filename</th>
										<th>Description</th>
										<th>Added</th>
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
				<div class='modal fade' id='edit-modal' tabindex='-1' role='dialog' aria-labelledby='Edit Quote' aria-hidden='true'>
					<div class='modal-dialog modal-dialog-centered' role='document'>
						<div class='modal-content'>
							<div class='modal-body text-center'>
								<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
									<span aria-hidden='true'>x</span></button>
									<h2>Edit Document</h2>
									<form method='post' action='$target_file'>
										<input id='title-input' type='text' name='title' class='form-control mb-2' required placeholder="Title">
										<input id='fname-input' type='text' name='filename' class='form-control mb-2' 
										required placeholder="Filename">
										<input id='description-input' type='text' name='description' class='form-control mb-2' 
										required placeholder="Description">
										<input type='hidden' name='document_id' id='document-input'>
										<button type='submit' name='route' value='edit_document_process' class='btn btn-info'>Submit</button>
									</form>
								</button>
							</div>
						</div>
					</div>
				</div>
				<div class='modal fade' id='confirm-modal' tabindex='-1' role='dialog' aria-labelledby='Confirm' aria-hidden='true'>
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
						$(function() {
							$('[data-toogle="tooltip"]').tooltip()
						})
					}
					function setValues(id) {
						divTitle = 'title-' + id;
						divFname = 'fname-' + id;
						divDesc = 'description-' + id;
						document.getElementById('title-input').value = document.getElementById(divTitle).innerHTML;
						document.getElementById('fname-input').value = document.getElementById(divFname).innerHTML;
						document.getElementById('description-input').value = document.getElementById(divDesc).innerHTML;
						document.getElementById('document-input').value = id;
					}
					function setDelete(id) {
					document.getElementById('div-id').innerHTML = id;
					}
					function continueDelete() {
						var x = document.getElementById('div-id').innerHTML;
						location.href = '$target_file?route=drop_document&id=' + x;
					}
				</script>
		HTML;
	}

	private function buildTable() {
		$output = '';
		foreach ($this->personal_details['documents'] as $item) {
			$document_id = $item['document_id'];
			$user_id = $item['user_id'];
			$title = $item['document_title'];
			$fname = $item['document_filename'];
			$description = $item['document_description'];
			$added = $item['document_added_timestamp'];
			$output .= <<< HTML
				<tr class='text-center'>
					<td>$document_id</td>
					<td>$user_id</td>
					<td>$title</td>
					<td>$fname</td>
					<td>$description</td>
					<td>$added</td>
					<div hidden id='div-id'></div>
					<div hidden id='title-$document_id'>$title</div>
					<div hidden id='fname-$document_id'>$fname</div>
					<div hidden id='description-$document_id'>$description</div>
					<td><button class='btn btn-success m-1' data-toggle='modal' data-target='#edit-modal'
					onclick='setValues($document_id)'><i class='icon-pencil'></i></button></td>
					<td><button class='btn btn-danger m-1' data-toggle='modal' data-target='#confirm-modal'
					 onclick='setDelete($document_id)'><i class='icon-trash'></i></button></td>
				</tr>
			HTML;
		}

		return $output;
	}
}