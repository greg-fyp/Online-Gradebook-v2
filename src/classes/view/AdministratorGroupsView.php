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
					<td><button class='btn btn-info m-1' 
					onclick="location.href='$target_file?route=group_students&code=$code'"><i class='icon-search'></i></button></td>
					<td><button class='btn btn-info m-1'
					onclick="location.href='$target_file?route=group_sessions&code=$code'"><i class='icon-search'></i></button></td>
					<td><button class='btn btn-success m-1'><i class='icon-pencil'></i></button></td>
					<td><button class='btn btn-danger m-1'><i class='icon-trash'></i></button></td>
				</tr>
			HTML;
		}

		return $output;
	}
}