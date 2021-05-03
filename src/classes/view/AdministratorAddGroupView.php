<?php

class AdministratorAddGroupView extends AdministratorView {
	public function __construct() {
		parent::__construct();
	}

	public function create() {
		$this->page_title = APP_NAME . ' Add Group';
		$this->createPage();
	}

	public function addAdminPageContent() {
		$target_file = ROOT_PATH;
		$msg = '';

		if (isset($_SESSION['msg'])) {
			$msg = $_SESSION['msg'];
			unset($_SESSION['msg']);
		}
		$data = $this->buildComboBox();
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
										<h4 class='text-center'>Add Group</h4>
									</div>
									<div class='col-lg-2'></div>
								</div>
					</div>
					<div class='card-body container'>
							<form method='post'>
							<select name='teacher_select' required class='form-control'>
								<option selected disabled value='-'>Select Teacher*</option>
								$data
							</select>
							<div class='row mt-3'>
								<div class='col-lg-6 mb-3'>
									<input type='text' name='group_code' required pattern='[A-Z0-9]{8}' 
									class='form-control' placeholder="Group Code*">
								</div>
								<div class='col-lg-6 mb-3'>
									<input type='text' name='group_name' 
									required class='form-control' placeholder="Group Name*">
								</div>
							</div>
							$msg
							<div class='text-center'>
								<button type='submit' name='route' value='add_group_process' class='btn btn-info'>Submit</button>
							</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			</div>
		HTML;
	}

	private function buildComboBox() {
		$output = '';
		foreach ($this->personal_details['teachers'] as $item) {
			$teacher_id = $item['teacher_id'];
			$fullname = $item['user_fullname'];

			$output .= <<< HTML
				<option value='$teacher_id'>$teacher_id: $fullname</option>
			HTML;
		}

		return $output;
	}
}