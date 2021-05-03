<?php

class TeacherDocumentsView extends TeacherView {
	public function __construct() {
		parent::__construct();
		$this->addStylesheet(CSS_PATH . 'teacher.css');
	}

	public function create() {
		$this->page_title = APP_NAME . ' Teacher Documents';
		$this->createPage();
	}

	public function addTeacherPageContent() {
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
										onclick="location.href='$target_file?route=teacher_main'"><i class='icon-left'></i></button>
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
											<th scope='col' class='text-center'>#</th>
											<th scope='col' class='text-center'>Title</th>
											<th scope='col' class='text-center'>Name</th>
											<th scope='col' class='text-center'>Description</th>
											<th scope='col' class='text-center'>Download</th>
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
		$target_file = ROOT_PATH;
		$scope = 'row';
		$div = '<div class="text-center"><div class="down-icon"><i class="icon-download"></i></div></div>';
		$output = '';
		foreach ($this->personal_details['documents'] as $item) {
			$id = $item['document_id'];
			$output .= '<tr>';
			$output .= '<th scope="$scope" class="text-center">' . $c . '</th>';
			$output .= '<td class="text-center">' . $item['document_title'] .'</td>';
			$output .= '<td class="text-center">' . $item['document_filename'] .'</td>';
			$output .= '<td class="text-center">' . $item['document_description'] .'</td>';
			$output .= <<< HTML
			 	<td><div class="text-center"><div class="down-icon"><i class="icon-download" onclick="location.href='$target_file?route=teacher_download&file=$id'">
			 	</i></div></div></td>
			HTML;
			$output .= '</tr>';
			$c++;
		}

		return $output;
	}
}