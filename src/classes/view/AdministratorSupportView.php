<?php

class AdministratorSupportView extends AdministratorView {
	public function __construct() {
		parent::__construct();
	}

	public function create() {
		$this->page_title = APP_NAME . ' Support';
		$this->createPage();
	}

	public function addAdminPageContent() {
		$target_file = ROOT_PATH;
		
		$data = $this->buildTable();
		$this->html_output .=  <<< HTML
			<div class='row'>
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
										<h4 class='text-center'>Support Requests</h4>
									</div>
									<div class='col-lg-2'></div>
								</div>
					</div>
					<div class='card-body'>
							<div style='overflow-x: auto;'>
									<table style='width: 100%' class='text-center'>
										<tr>
											<th scope='col'>ID</th>
											<th scope='col'>User ID</th>
											<th scope='col'>Title</th>
											<th scope='col'>Content</th>
											<th scope='col'><div class='text-center'>Delete</div></th>
										</tr>
										$data
									</table>
								</div>
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
						$(function() {
							$('[data-toogle="tooltip"]').tooltip()
						})
					}
					function setDelete(id) {
					document.getElementById('div-id').innerHTML = id;
					}
					function continueDelete() {
						var x = document.getElementById('div-id').innerHTML;
						location.href = '$target_file?route=drop_request&id=' + x;
					}
				</script>
		HTML;
	}

	private function buildTable() {
		$target_file = ROOT_PATH;
		$output = '';
		foreach ($this->personal_details['requests'] as $item) {
			$id = $item['request_id'];
			$user_id = $item['user_id'];
			$title = $item['request_title'];
			$content = $item['request_content'];
			$output .= <<< HTML
				<tr>
					<td>$id</td>
					<td>$user_id</td>
					<td>$title</td>
					<td>$content</td>
					<div hidden id='div-id'></div>
					<td><button class='btn btn-danger m-1' data-toggle='modal' data-target='#confirm-modal'
					 onclick='setDelete($id)'><i class='icon-trash'></i></button></td>
				</tr>
			HTML;
		}

		return $output;
	}
}