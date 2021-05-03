<?php

class AdministratorGroupListView extends AdministratorView {
	public function __construct() {
		parent::__construct();
		$this->action = '';
	}

	public function create() {
		$this->page_title = APP_NAME . ' Group List';
		$this->createPage();
	}

	public function setAction($target) {
		$this->action = $target;
	}

	public function addAdminPageContent() {
		$target_file = ROOT_PATH;
		$msg = '';
		if (isset($_SESSION['msg'])) {
			$msg = $_SESSION['msg'];
			unset($_SESSION['msg']);
		}

		$data_table = $this->buildTable();
		$this->html_output .=  <<< HTML
			<div class='row'>
			<div class='col-lg-1'></div>
			<div class='col-lg-10'>
				<div class='card-deck mb-3 mt-4'>
						<div class='card mb-4 box-shadow'>
							<div class='card-header'>
								<div class='row'>
									<div class='col-lg-2'>
										<button class='btn btn-info' 
										onclick="location.href='$target_file?route=admin_main'"><i class='icon-left'></i></button>
									</div>
									<div class='col-lg-8'>
										<h4 class="my-0 font-weight-normal text-center">Select Group</h4>
									</div>
									<div class='col-lg-2'></div>
								</div>
							</div>
							<div class='card-body'>
								<div style='overflow-x: auto;'>
									<table style='width: 100%' class='text-center'>
										<tr>
											<th scope='col'>#</th>
											<th scope='col'>Group Code</th>
											<th scope='col'>Group Name</th>
											<th scope='col'><div class='text-center'>View</div></th>
										</tr>
										$data_table
									</table>
								</div>
							</div>
							</div>
						</div>
			</div>
			</div>
		HTML;
	}

	private function buildTable() {
		$target_file = ROOT_PATH;
		$action = $this->action;
		$output = '';
		$c = 1;
		foreach ($this->personal_details['groups'] as $item) {
			$code = $item['group_code'];
			$name = $item['group_name'];
			$output .= <<< HTML
				<tr>
				<th scope='row'>$c</th>
				<td>$code</td>
				<td>$name</td>
				<td><button class='btn btn-info m-1' 
				onclick="location.href='$target_file?route=$action&code=$code'">View</button></td>
				</tr>
			HTML;
			$c++;
		}

		return $output;
	}
}