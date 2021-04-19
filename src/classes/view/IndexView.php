<?php

/**
* IndexView.php
*
* Creates a view of the index file.
* 
*
* @author Greg
*/

class IndexView extends WelcomeTemplateView {
	public function __construct() {
		parent::__construct();
		$this->addStylesheet(CSS_PATH . 'main.css');
	}

	public function __destruct() {}

	public function create() {
		$this->page_title = APP_NAME . ' Index Page';
		$this->createPage();
	}

	public function addWelcomePageContent() {
		$assign = IMG_PATH . 'exam.png';
		$grade = IMG_PATH . 'grade.png';
		$attend = IMG_PATH . 'attend.png';
		$calendar = IMG_PATH . 'calendar.png';
		$photo = IMG_PATH . 'photo.png';
		$shield = IMG_PATH . 'shield.png';

		$this->html_output .= <<< HTML
			<div id='content-wrap'>
			<h1>About</h1>
			<div id='description'>Online Gradebook for Teachers and Students is a mobile-friendly web application that could be used
			by schools and educational institutions across the United Kingdom. It provides teachers with an
			opportunity to assess students’ performance remotely. Achieved results can be viewed by students
			at any time and at anywhere in the World.</div>
			<div id='line'></div>
			<div class='row'>
				<div class='col-sm-6 col-md-4 col-xl-3'>
					<figure>
						<img src='$assign' class='img-fluid'>
					</figure>
					<figcaption>
						View information on your upcoming assignments.
					</figcaption>
				</div>
				<div class='col-sm-6 col-md-4 col-xl-3'>
					<figure>
						<img src='$grade' class='img-fluid'>
					</figure>
					<figcaption>
						Students get an easey access to received grades.
					</figcaption>
				</div>
				<div class='col-sm-6 col-md-4 col-xl-3'>
					<figure>
						<img src='$attend' class='img-fluid'>
					</figure>
					<figcaption>
						Gradebook makes it easy to monitor attendance.
					</figcaption>
				</div>
				<div class='col-sm-6 col-md-4 col-xl-3'>
					<figure>
						<img src='$calendar' class='img-fluid'>
					</figure>
					<figcaption>
						View your timetable to plan your activities.
					</figcaption>
				</div>
				<div class='col-sm-6 col-md-4 col-xl-3'>
					<figure>
						<img src='$photo' class='img-fluid'>
					</figure>
					<figcaption>
						Mobile-friendly.
					</figcaption>
				</div>
				<div class='col-sm-6 col-md-4 col-xl-3'>
					<figure>
						<img src='$shield' class='img-fluid'>
					</figure>
					<figcaption>
						Your sensitive data is stored securely. Only authorized users have access to the system.
					</figcaption>
				</div>
			</div>
			</div>
		HTML;
	}
}