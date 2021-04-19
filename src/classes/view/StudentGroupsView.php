<?php

class StudentGroupsView extends StudentView {
	private $link;

	public function __construct() {
		parent::__construct();
		$this->addStylesheet(CSS_PATH . 'student.css');
		$this->link = '';
	}

	public function create() {
		$this->page_title = APP_NAME . ' Student Grades';
		$this->createPage();
	}

	public function setLink($link) {
		$this->link = $link;
	}

	public function addStudentPageContent() {
		$target_file = ROOT_PATH;
		$data_table = $this->buildTable();
		$this->html_output .= <<< HTML
			<div class='row'>
				<div class='col-lg-1'></div>
				<div class='col-lg-10'>
					<div class='card-deck mb-3 mt-4'>
						<div class='card mb-4 box-shadow'>
							<div class='card-header'>
								<div class='row'>
									<div class='col-lg-2'>
										<button class='btn btn-info' 
										onclick="location.href='$target_file?route=student_main'"><i class='icon-left'></i></button>
									</div>
									<div class='col-lg-8'>
										<h4 class="my-0 font-weight-normal text-center">Groups</h4>
									</div>
									<div class='col-lg-2'></div>
								</div>
							</div>
							<div class='card-body'>
								<div style='overflow-x: auto;'><table class='table'>
									<thead>
										<tr>
											<th scope='col'>#</th>
											<th scope='col'>Group Code</th>
											<th scope='col'>Group Name</th>
											<th scope='col'><div class='text-center'>View</div></th>
										</tr>
									</thead>
									<tbody>
										$data_table
									</tbody>
								</table>
								</div>
							</div>
						</div>
						</div>
					</div>	
				<div class='col-lg-1'></div>
			</div>
		HTML;
	}

	private function buildTable() {
		$target_file = ROOT_PATH;
		$link = $this->link;
		$c = 1;
		$scope = 'row';
		$output = '';
		foreach ($this->personal_details['groups'] as $item) {
			$output .= '<tr>';
			$output .= '<th scope="$scope">' . $c . '</th>';
			$output .= '<td>' . $item['group_code'] .'</td>';
			$output .= '<td>' . $item['group_name'] .'</td>';
			$var = $item['group_code'];
			$output .= <<< HTML
				<td>
					<div class='text-center'>
						<button class='btn btn-info' onclick="location.href='$target_file?route=$link&code=$var'">View</button>
					</div>
				</td>
			HTML;
			$output .= '</tr>';
			$c++;
		}

		return $output;
	}

}