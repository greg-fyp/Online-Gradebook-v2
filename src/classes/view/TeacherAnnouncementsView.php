<?php

class TeacherAnnouncementsView extends TeacherView {
	private $flag;

	public function __construct() {
		parent::__construct();
		$this->addStylesheet(CSS_PATH . 'teacher.css');
		$this->flag = false;
	}

	public function create() {
		$this->page_title = APP_NAME . ' Teacher Announcements';
		$this->createPage();
	}

	public function addFailMsg() {
		$this->flag = true;
	}

	public function addTeacherPageContent() {
		$target_file = ROOT_PATH;
		$code = $this->personal_details['code'];
		$msg = '';

		if ($this->flag) {
			$msg = <<< HTML
				<div class="alert alert-danger" role="alert">
					Cannot add a new announcemnt.
				</div>
			HTML;
		}

		$view = $this->buildView();
		$this->html_output .= <<< HTML
			$msg
			<div class='row'>
				<div class='col-lg-2'>
					<button class='btn btn-info' 
					onclick="location.href='$target_file?route=teacher_announcements'"><i class='icon-left'></i></button>
				</div>
				<div class='col-lg-8 text-center'>
					<button class='btn btn-info' 
					onclick='showNew()'>New Announcement <b>+</b></button>
				</div>			
			</div>
			<div class='col-lg-12'>
					<div class='card-deck mb-3 mt-4' id='new-post'>
						<div class='card mb-4 box-shadow border-0'>
							<div class='card-header text-center text-white post-header'>
							<form method='post' action='$target_file'>
								<div style='font-size: 20px;'>
									<input type='hidden' name='code' value='$code'>
									<input id='title' type='text' class='form-control' name='title' placeholder="Announcement Title" required>
								</div>
							</div>
							<div class='card-body'>
								<textarea id='content' name='content' rows='6' wrap='physical' class='col-lg-12 mb-0 form-control'>Content here...</textarea>
							</div>
							<div class='row mt-0 mb-0'>
								<div class='col-lg-4'>
								</div>
								<div class='col-lg-4 text-center'>
									<button type='submit' name='route' value='add_announcement' 
									class='btn btn-success'><i class='icon-ok'></i>Post Announcement</button>
									</form>
									<button class='btn btn-danger' onclick='hideNew()'><i class='icon-cancel'></i>Cancel</button>
								</div>
							</div>
							<div class="card-footer mt-4 pt-1"></div>
						</div>
						</div>
				</div>
			<div>$view</div>
			<script type="text/javascript">
				function showNew() {
					var x = document.getElementById('new-post');
					x.style.display = 'block';
				}
				function hideNew() {
					var x = document.getElementById('new-post');
					x.style.display = 'none';
				}
			</script>
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