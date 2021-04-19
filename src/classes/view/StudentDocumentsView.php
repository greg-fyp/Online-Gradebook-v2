<?php

class StudentDocumentsView extends StudentView {
	public function __construct() {
		parent::__construct();
		$this->addStylesheet(CSS_PATH . 'student.css');
	}

	public function create() {
		$this->page_title = APP_NAME . ' Student Documents';
		$this->createPage();
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
										<h4 class="my-0 font-weight-normal text-center">Available Documents</h4>
									</div>
									<div class='col-lg-2'></div>
								</div>
							</div>
							<div class='card-body'>
								<div style='overflow-x: auto;'><table class='table'>
									<thead>
										<tr>
											<th scope='col'>#</th>
											<th scope='col'>Title</th>
											<th scope='col'>Name</th>
											<th scope='col'>Description</th>
											<th scope='col'>Download</th>
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
		$c = 1;
		$scope = 'row';
		$div = '<div class="text-center"><div class="down-icon"><i class="icon-download"></i></div></div>';
		$output = '';
		foreach ($this->personal_details['documents'] as $item) {
			$output .= '<tr>';
			$output .= '<th scope="$scope">' . $c . '</th>';
			$output .= '<td>' . $item['document_title'] .'</td>';
			$output .= '<td>' . $item['document_filename'] .'</td>';
			$output .= '<td>' . $item['document_description'] .'</td>';
			$output .= <<< HTML
			 	<td><div class="text-center"><div class="down-icon"><i class="icon-download"></i></div></div></td>
			HTML;
			$output .= '</tr>';
			$c++;
		}

		return $output;
	}
}