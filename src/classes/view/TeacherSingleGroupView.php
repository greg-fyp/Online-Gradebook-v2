<?php

class TeacherSingleGroupView extends TeacherView {
	public function __construct() {
		parent::__construct();
		$this->addStylesheet(CSS_PATH . 'teacher.css');
	}

	public function create() {
		$this->page_title = APP_NAME . ' Teacher Group View';
		$this->createPage();
	}

	public function addTeacherPageContent() {
		$data_table = $this->buildTable();
		$this->html_output .= <<< HTML
			<div class='row'>
				<div class='col-lg-1'></div>
				<div class='col-lg-10'>
					<div class='card-deck mb-3 mt-4'>
						<div class='card mb-4 box-shadow'>
							<div class='card-header'>
								<h4 class="my-0 font-weight-normal text-center">Students</h4>
							</div>
							<div class='card-body'>
								<div style='overflow-x: auto;'><table class='table'>
									<thead>
										<tr>
											<th scope='col'>#</th>
											<th scope='col'>Name</th>
											<th scope='col'>Grades</th>
											<th scope='col'>Details</th>
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
		$output = '';
		$c = 1;
		foreach ($this->personal_details['students'] as $item) {
			$fullname = $item['user']['user_fullname'];
			$student_id = $item['student_id'];
			$output .= <<< HTML
				<tr>
					<th scope='row'>$c</th>
					<td>$fullname</td>
					<td>
						<button class='btn btn-info'>View Grades</button>
					</td>
				</tr>
			HTML;
			$c++;
		}

		return $output;
	}
}