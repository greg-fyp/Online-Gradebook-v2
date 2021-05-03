<?php

class StudentGradesView extends StudentView {
	public function __construct() {
		parent::__construct();
		$this->addStylesheet(CSS_PATH . 'student.css');
	}

	public function create() {
		$this->page_title = APP_NAME . ' Student Support';
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
								<div class='row'>
									<div class='col-lg-2'>
										<button class='btn btn-info' 
										onclick="location.href='$target_file?route=student_view_grades'"><i class='icon-left'></i></button>
									</div>
									<div class='col-lg-8'>
										<h4 class="my-0 font-weight-normal text-center">Your Results</h4>
									</div>
									<div class='col-lg-2'></div>
								</div>
							</div>
							<div class='card-body'>
								<div style='overflow-x: auto;'><table class='table'>
									<thead>
										<tr class='text-center'>
											<th scope='col'>Title</th>
											<th scope='col'>Result</th>
											<th scope='col'>Weight</th>
											<th scope='col'>Marked</th>
											<th scope='col'>Feedback</th>
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
		if (count($this->personal_details['grades']) == 0) {
			$output = <<< HTML
				<tr>
					<th>-</th>
					<th>-</th>
					<th>-</th>
					<th>-</th>
					<th>-</th>
				</tr>
			HTML;
		}

		foreach ($this->personal_details['grades'] as $item) {
			$title = $item['assessment_title'];
			$result = $item['grade'];
			$weight = $item['assessment_weight'];
			$marked = $item['mark_date'];
			$feedback = $item['feedback'];

			$output .= <<< HTML
				<tr class='text-center'>
					<th scope='row'>$title</th>
					<td><b>$result</b></td>
					<td>$weight</td>
					<td>$marked</td>
					<td>$feedback</td>
				</tr>
			HTML;
		}

		return $output;
	}
}