<?php

class AdministratorQuotesTableView extends AdministratorView {
	public function __construct() {
		parent::__construct();
	}

	public function create() {
		$this->page_title = APP_NAME . ' Administrator Quotes View';
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
										<h4 class="my-0 font-weight-normal text-center">Quotes</h4>
									</div>
									<div class='col-lg-2'></div>
								</div>
							</div>
							<div class='card-body'>
								<button class='btn btn-info mb-2' data-toggle='modal' data-target='#add-modal'>Add Quote</button>
								<div style='overflow-x: auto;'>
								<table style='width: 100%;'>
									<tr class='text-center'>
										<th>Quote ID</th>
										<th>Author</th>
										<th>Content</th>
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
			<div class='modal fade' id='add-modal' tabindex='-1' role='dialog' aria-labelledby='Add Quote' aria-hidden='true'>
					<div class='modal-dialog modal-dialog-centered' role='document'>
						<div class='modal-content'>
							<div class='modal-body text-center'>
								<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
									<span aria-hidden='true'>x</span></button>
									<h2>New Quote</h2>
									<form method='post' action='$target_file'>
										<input type='text' name='author' class='form-control mb-2' required placeholder="Author">
										<textarea id='content' name='content' rows='6' wrap='physical'
										class='col-lg-12 mb-2 form-control'>Content...</textarea>
										<button type='submit' name='route' value='add_quote_process' class='btn btn-info'>Submit</button>
									</form>
								</button>
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
									<h2>Edit Quote</h2>
									<form method='post' action='$target_file'>
										<input id='author-input' type='text' name='author' class='form-control mb-2' required placeholder="Author">
										<textarea id='content-input' name='content' rows='6' wrap='physical'
										class='col-lg-12 mb-2 form-control'></textarea>
										<input type='hidden' name='quote_id' id='quote-input'>
										<button type='submit' name='route' value='edit_quote_process' class='btn btn-info'>Submit</button>
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
					$('#add-modal').modal('show');
					$('#edit-modal').modal('show');
					$('#confirm-modal').modal('show');
						$(function() {
							$('[data-toogle="tooltip"]').tooltip()
						})
					}
					function setValues(id) {
						divAuth = 'author-' + id;
						divCon = 'content-' + id;
						document.getElementById('author-input').value = document.getElementById(divAuth).innerHTML;
						document.getElementById('content-input').value = document.getElementById(divCon).innerHTML;
						document.getElementById('quote-input').value = id;
					}
					function setDelete(id) {
					document.getElementById('div-id').innerHTML = id;
					}
					function continueDelete() {
						var x = document.getElementById('div-id').innerHTML;
						location.href = '$target_file?route=drop_quote&id=' + x;
					}
				</script>
		HTML;
	}

	private function buildTable() {
		$output = '';
		foreach ($this->personal_details['quotes'] as $item) {
			$quote_id = $item['quote_id'];
			$author = $item['quote_author'];
			$content = $item['quote_content'];

			$output .= <<< HTML
				<tr class='text-center'>
					<td>$quote_id</td>
					<td>$author</td>
					<td>$content</td>
					<div hidden id='div-id'></div>
					<div hidden id='author-$quote_id'>$author</div>
					<div hidden id='content-$quote_id'>$content</div>
					<td><button class='btn btn-success m-1' data-toggle='modal' data-target='#edit-modal'
					onclick='setValues($quote_id)'><i class='icon-pencil'></i></button></td>
					<td><button class='btn btn-danger m-1' data-toggle='modal' data-target='#confirm-modal'
					 onclick='setDelete($quote_id)'><i class='icon-trash'></i></button></td>
				</tr>
			HTML;
		}

		return $output;
	}
}