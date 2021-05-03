<?php

class StudentAnnouncementsView extends StudentView {
	public function __construct() {
		parent::__construct();
		$this->addStylesheet(CSS_PATH . 'student.css');
	}

	public function create() {
		$this->page_title = APP_NAME . ' Student Announcements';
		$this->createPage();
	}

	public function addStudentPageContent() {
		$target_file = ROOT_PATH;
		$code = $this->personal_details['code'];

		$view = $this->buildView();
		$this->html_output .= <<< HTML
			<div class='row'>
				<div class='col-lg-2'>
					<button class='btn btn-info' 
					onclick="location.href='$target_file?route=student_announcements'"><i class='icon-left'></i></button>
				</div>		
			</div>
			<div>$view</div>
		HTML;
	}

	private function buildView() {
		$output = '';
		if (empty($this->personal_details['announcements'])) {
			return '<div class="text-center mt-4">No announcements yet.</div>';
		}
		foreach ($this->personal_details['announcements'] as $item) {
			$title = $item['announcement_title'];
			$date = $item['announcement_timestamp'];
			$content = $item['announcement_content'];
			
			$output .= <<< HTML
				<div class='col-lg-12'>
					<div class='card-deck mb-3 mt-4'>
						<div class='card mb-4 box-shadow border-0'>
							<div class='card-header text-center text-white post-header'>
								<div style='font-size: 20px;'><b>$title</b></div>
							</div>
							<div class='card-body'>
								$content
							</div>
							<div class="card-footer mt-4 pt-1">$date</div>
						</div>
						</div>
				</div>
			HTML;
		}

		return $output;
	}
}