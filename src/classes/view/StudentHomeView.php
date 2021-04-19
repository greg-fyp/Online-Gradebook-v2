<?php

class StudentHomeView extends StudentView {
	public function __construct() {
		parent::__construct();
	}

	public function create() {
		$this->page_title = APP_NAME . ' Student Home';
		$this->createPage();
	}

	public function addStudentPageContent() {
		$target_file = ROOT_PATH;
		$quote_content = $this->personal_details['quote']['content'];
		$quote_author = $this->personal_details['quote']['author'];
		$this->html_output .= <<< HTML
			<div class='row mt-5'>
				<div class='col-lg-6'>
					<div id='quote' class='p-1 pt-2 pb-2 text-center mt-1'>
						<div class='row'>
							<div class='col-4'>
								<div id='bulb'><i class='icon-lightbulb'></i></div>
							</div>
							<div class='col-8 pt-2'>
								<div id='quote_content'>$quote_content</div>
								<div id='quote_author'>~$quote_author</div>
							</div>
						</div>
					</div>
				</div>
				<div class='col-lg-6'>
					<div id='current_date' class='p-1 pt-2 pb-2 text-center mt-1'>
						<script>
							var dt = new Date();
							document.getElementById('current_date').innerHTML = (("0"+dt.getDate()).slice(-2)) +"."+ (("0"+(dt.getMonth()+1)).slice(-2)) +"."+ (dt.getFullYear());
						</script>
					</div>
				</div>
			</div>
			<div class='row mt-2'>
				<div class='col-lg-2 col-md-4 col-sm-6'>
					<div class='p-1 text-center tile blue mt-1' onclick="location.href='$target_file?route=student_view_grades'">
						<div class='icon'><i class='icon-graduation-cap'></i></div>
						Grades
					</div>
				</div>
				<div class='col-lg-2 col-md-4 col-sm-6'>
					<div class='p-1 text-center tile green mt-1' onclick="location.href='$target_file?route=student_view_assessments'">
						<div class='icon'><i class='icon-pencil'></i></div>
						Assessments
					</div>
				</div>
				<div class='col-lg-2 col-md-4 col-sm-6'>
					<div class='p-1 text-center tile azure mt-1'>
						<div class='icon'><i class='icon-calendar'></i></div>
						Timetable
					</div>
				</div>
				<div class='col-lg-2 col-md-4 col-sm-6'>
					<div class='p-1 text-center tile blue mt-1'>
						<div class='icon'><i class='icon-megaphone'></i></div>
						Announcements
					</div>
				</div>
				<div class='col-lg-2 col-md-4 col-sm-6'>
					<div class='p-1 text-center tile orange mt-1' onclick="location.href='$target_file?route=student_documents'">
						<div class='icon'><i class='icon-doc-text-inv'></i></div>
						Documents
					</div>
				</div>
				<div class='col-lg-2 col-md-4 col-sm-6'>
					<div class='p-1 text-center tile green mt-1'>
						<div class='icon'><i class='icon-bank'></i></div>
						Institution Details
					</div>
				</div>
			</div>
			<div class='row mt-2'>
				<div class='col-lg-2 col-md-4 col-sm-6'>
					<div class='p-1 text-center tile red mt-1' onclick="location.href='$target_file?route=edit_student'">
						<div class='icon'><i class='icon-user'></i></div>
						Edit Profile
					</div>
				</div>
				<div class='col-lg-2 col-md-4 col-sm-6'>
					<div class='p-1 text-center tile azure mt-1' onclick='location.href="$target_file?route=edit_student_password"'>
						<div class='icon'><i class='icon-key'></i></div>
						Change Password
					</div>
				</div>
				<div class='col-lg-2 col-md-4 col-sm-6'>
					<div class='p-1 text-center tile orange mt-1' onclick='location.href="$target_file?route=support_student"'>
						<div class='icon'><i class='icon-cog-alt'></i></div>
						Support
					</div>
				</div>
				<div class='col-lg-2 col-md-4 col-sm-6'>
					<div class='p-1 text-center tile green mt-1' onclick="location.href='$target_file?route=user_logout'">
						<div class='icon'><i class='icon-logout'></i></div>
						Logout
					</div>
				</div>
			</div>
		HTML;
	}
}