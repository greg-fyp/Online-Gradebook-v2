<?php

class StudentTimetableView extends StudentView {
	private $begin_date;

	public function __construct() {
		parent::__construct();
		$this->addStylesheet(CSS_PATH . 'student.css');
		$this->begin_date = date('Y-m-d');
		$this->week_array = [];
	}

	public function create() {
		$this->page_title = APP_NAME . ' Student Timetable';
		$this->createPage();
	}

	public function setBeginDate($date) {
		$this->begin_date = $date;
	}

	public function addStudentPageContent() {
		$target_file = ROOT_PATH;
		$this->buildArray();
		$next_monday = date('Y-m-d', strtotime('next monday', strtotime($this->week_array[4]['date'])));
		$last_monday = date('Y-m-d', strtotime('last monday', strtotime($this->week_array[0]['date'])));
		
		$view = $this->buildView();
		$this->html_output .= <<< HTML
			<div class='card-deck mb-3 mt-4'>
				<div class='card mb-4 box-shadow'>
					<div class='card-header'>
						<div class='row'>
							<div class='col-lg-3'>
								<button class='btn btn-info' 
								onclick="location.href='$target_file?route=student_main'"><i class='icon-left'></i></button>
							</div>
							<div class='col-lg-6'>
								<h4 class="my-0 font-weight-normal text-center">Your Timetable</h4>
							</div>
							<div class='col-lg-1'></div>
							<div class='col-lg-2'>
								<div class='row'>
									<div class='col-lg-6 col-sm-6'>
										<button class='btn btn-info' 
										onclick="location.href='$target_file?route=student_timetable&date=$last_monday'"><</button>
									</div>
									<div class='col-lg-6 col-sm-6'>
										<button class='btn btn-info'
										onclick="location.href='$target_file?route=student_timetable&date=$next_monday'">></button>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class='card-body container'>
							$view	
					</div>
				</div>
			</div>
		HTML; 
	}

	private function buildArray() {
		if (date('w', strtotime($this->begin_date)) == 6 || date('w', strtotime($this->begin_date)) == 7) {
			$monday = strtotime('next monday', strtotime($this->begin_date));
		} else if (date('w', strtotime($this->begin_date)) == 1) {
			$monday = strtotime($this->begin_date);
		} else  {
			$monday = strtotime("last monday", strtotime($this->begin_date));
		}
		
		$day1['name'] = 'Monday';
		$day1['date'] = date("Y-m-d",$monday);
		$day1['sessions'] = [];
		array_push($this->week_array, $day1);
		$tuesday['name'] = 'Tuesday';
		$tuesday['date'] = date('Y-m-d', strtotime(date("Y-m-d",$monday)." +1 day"));
		$tuesday['sessions'] = [];
		array_push($this->week_array, $tuesday);
		$wednesday['name'] = 'Wednesday';
		$wednesday['date'] = date('Y-m-d', strtotime(date("Y-m-d",$monday)." +2 day"));
		$wednesday['sessions'] = [];
		array_push($this->week_array, $wednesday);
		$thursday['name'] = 'Thursday';
		$thursday['date'] = date('Y-m-d', strtotime(date("Y-m-d",$monday)." +3 day"));
		$thursday['sessions'] = [];
		array_push($this->week_array, $thursday);
		$friday['name'] = 'Friday';
		$friday['date'] = date('Y-m-d', strtotime(date("Y-m-d",$monday)." +4 day"));
		$friday['sessions'] = [];
		array_push($this->week_array, $friday);


		foreach ($this->personal_details['sessions'] as $session) {
			foreach ($this->week_array as &$day) {
				if ($session['session_date'] === $day['date']) {
					array_push($day['sessions'], $session);
				}
			}
		}
	}

	private function buildView() {
		$output = <<< HTML
			<div class='row'>
				<div class='col-lg-1'></div>
		HTML;
		foreach ($this->week_array as $day) {
			$output .= '<div class="col-lg-2 text-center mt-1">';
			$output .= '<b>' . $day['name'] . ' ' . $this->getDate($day['date']) . '</b>';

			if (empty($day['sessions'])) {
				$header = '-';
				$body = 'No activities';
				$output .= <<< HTML
				<div class='card-deck mb-2'>
					<div class='card box-shadow ml-1 mr-1'>
						<div class='card-header text-white session-header p-0'>
							$header
						</div>
						<div class='card-body pt-0'>
							$body
						</div>
					</div>
				</div>
			HTML;
			} else {
				foreach ($day['sessions'] as $session) {
					$name = $session['group_name'];
					$code = $session['group_code'];
					$location = $session['session_location'];
					$body = <<< HTML
						<div id='session-code'>$code</div>
						<div id='session-name' class='pb-2'>$name</div>
						<div id='session-location'>$location</div>
					HTML;
					$header = $this->getTimeRange($session);
					$output .= <<< HTML
					<div class='card-deck mb-2'>
						<div class='card box-shadow ml-1 mr-1'>
							<div class='card-header text-white session-header p-0'>
								$header
							</div>
							<div class='card-body pt-0'>
								$body
							</div>
						</div>
					</div>
					HTML;
				}
			}

			$output .= '</div>';
		}

		return $output . '</dvi>';
	}

	private function getTimeRange($session) {
		if (is_null($session)) {
			return '-';
		}
		$tokens = explode(':', $session['session_start_time']);
		$val = intval($tokens[0]);
		$val2 = intval($session['session_duration']) + $val;
		return strval($val) . ':00 - ' . strval($val2) . ':00';
	}

	private function getDate($day) {
		$tokens = explode('-', $day);
		return $tokens[2] . '.' . $tokens[1];
	}
}