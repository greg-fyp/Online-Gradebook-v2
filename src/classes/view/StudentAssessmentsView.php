<?php

class StudentAssessmentsView extends StudentView {
	public function __construct() {
		parent::__construct();
		$this->addStylesheet(CSS_PATH . 'student.css');
	}

	public function create() {
		$this->page_title = APP_NAME . ' Student Assessments';
		$this->createPage();
	}

	public function addStudentPageContent() {
		$data_table = $this->buildTable();
		$target_file = ROOT_PATH;
		$this->html_output .= <<< HTML
			<div class='row'>
				<div class='col-lg-12'>
					<div class='card-deck mb-3 mt-4'>
						<div class='card mb-4 box-shadow'>
							<div class='card-header'>
								<h4 class="my-0 font-weight-normal text-center">Upcoming Assessments</h4>
							</div>
							<div class='card-body'>
								<div style='overflow-x: auto;'><table class='table'>
									<thead>
										<tr>
											<th scope='col'>#</th>
											<th scope='col'>Title</th>
											<th scope='col'>Weight</th>
											<th scope='col'>Date</th>
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
			</div>
		HTML;
	}

	private function buildTable() {
		$output = '';
		$c = 1;
		if (count($this->personal_details['assessments']) == 0) {
			$output = <<< HTML
				<tr>
					<th>$c</th>
					<th>-</th>
					<th>-</th>
					<th>-</th>
					<th>-</th>
				</tr>
			HTML;
			$c++;
		}

		foreach ($this->personal_details['assessments'] as $item) {
			$title = $item['assessment_title'];
			$weight = $item['assessment_weight'];
			$date = $item['assessment_deadline'];

			$output .= <<< HTML
				<tr>
					<th scope='row'>$c</th>
					<td>$title</td>
					<td>$weight</td>
					<td><b>$date</b></td>
				</tr>
			HTML;
			$c++;
		}

		return $output;
	}
}