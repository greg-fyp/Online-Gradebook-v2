<?php

class AdministratorUploadDocumentView extends AdministratorView {
	public function __construct() {
		parent::__construct();
	}

	public function create() {
		$this->page_title = APP_NAME . ' Document Upload';
		$this->createPage();
	}

	public function addAdminPageContent() {
		$target_file = ROOT_PATH;
		$msg = '';
		if (isset($_SESSION['msg'])) {
			$msg = $_SESSION['msg'];
			unset($_SESSION['msg']);
		}
		$this->html_output .=  <<< HTML
			<div class='row'>
			<div class='col-lg-2'></div>
			<div class='col-lg-8'>
				<div class='card-deck mb-3 mt-4'>
						<div class='card mb-4 box-shadow'>
							<div class='card-header'>
								<div class='row'>
									<div class='col-lg-2'>
										<button class='btn btn-info' 
										onclick="location.href='$target_file?route=admin_main'"><i class='icon-left'></i></button>
									</div>
									<div class='col-lg-8'>
										<h4 class="my-0 font-weight-normal text-center">Upload Document</h4>
									</div>
									<div class='col-lg-2'></div>
								</div>
							</div>
							<div class='card-body mt-4'>
								<form method='post' action='$target_file' enctype="multipart/form-data">
								<input type='email'name='username' required placeholder="Enter Username*" class='form-control mb-3'>
								<input type='text'name='title' required placeholder="Document Title*" class='form-control mb-3'>
								<input type='text'name='description' required placeholder="Document Description*" class='form-control mb-3'>
								<div class='row'>
									<div class='col-lg-4'></div>
									<div class='col-lg-4'>
										<div class='text-center'>
											<input type="file" name='userfile' id="fileToUpload" class='form-control-file mb-4' required>
											</div>
									</div>
								</div>
								$msg
								<div class='text-center'>
									<button class='btn btn-info' type='submit' name='route' value='upload_document_process'>Submit</button>
								</div>
								</form>
							</div>
							</div>
						</div>
			</div>
			</div>
		HTML;
	}
}