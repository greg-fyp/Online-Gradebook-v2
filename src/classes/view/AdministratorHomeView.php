<?php

class AdministratorHomeView extends AdministratorView {
	public function __construct() {
		parent::__construct();
	}

	public function create() {
		$this->page_title = APP_NAME . ' Administrator Home';
		$this->createPage();
	}

	public function addAdminPageContent() {
		$target_file = ROOT_PATH;
		$this->html_output .=  <<< HTML
			<div class='row mt-5'>
				<div class='col-lg-6'>
					<div class='title-tile col-lg-12 text-center'><i class='icon-wrench'></i> Tools</div>
					<div class='row mt-2'>
						<div class='col-lg-4 col-md-8 col-sm-12'>
							<div class='p-1 text-center tile orange mt-1' onclick="location.href='$target_file?route=add_user_view'">
								<div class='icon'><i class='icon-user-plus'></i></div>
								Add User
							</div>
						</div>
						<div class='col-lg-4 col-md-8 col-sm-12' onclick="location.href='$target_file?route=add_group_view'">
							<div class='p-1 text-center tile orange mt-1'>
								<div class='icon'><i class='icon-group'>+</i></div>
								Add Group
							</div>
						</div>
						<div class='col-lg-4 col-md-8 col-sm-12'>
							<div class='p-1 text-center tile orange mt-1' onclick="location.href='$target_file?route=edit_roles'">
								<div class='icon'><i class='icon-user'></i></div>
								Edit Roles
							</div>
						</div>
					</div>
					<div class='row mt-2'>
						<div class='col-lg-4 col-md-8 col-sm-12'>
							<div class='p-1 text-center tile orange mt-1' onclick="location.href='$target_file?route=reset_password_view'">
								<div class='icon'><i class='icon-key'></i></div>
								Reset Password
							</div>
						</div>
						<div class='col-lg-4 col-md-8 col-sm-12'>
							<div class='p-1 text-center tile orange mt-1' onclick="location.href='$target_file?route=upload_document'">
								<div class='icon'><i class='icon-doc-text-inv'></i></div>
								Upload Document
							</div>
						</div>
						<div class='col-lg-4 col-md-8 col-sm-12'>
							<div class='p-1 text-center tile orange mt-1' onclick="location.href='$target_file?route=admin_institution'">
								<div class='icon'><i class='icon-bank'></i></div>
								Institution Details
							</div>
						</div>
					</div>
					<div class='row mt-2'>
						<div class='col-lg-4 col-md-8 col-sm-12'></div>
						<div class='col-lg-4 col-md-8 col-sm-12'></div>
						<div class='col-lg-4 col-md-8 col-sm-12'>
							<div class='p-1 text-center tile orange' onclick="location.href='$target_file?route=support_requests'">
								<div class='icon'><i class='icon-question-circle-o'></i></div>
								Support Requests
							</div>
						</div>
						</div>
				</div>
				<div class='col-lg-6'>
					<div class='title-tile col-lg-12 text-center'><i class='icon-database'></i> Records</div>
					<div class='row mt-2'>
						<div class='col-lg-4 col-md-8 col-sm-12'>
							<div class='p-1 text-center tile orange mt-1' onclick="location.href='$target_file?route=view_students'">
								<div class='icon'><i class='icon-table'></i></div>
								Students
							</div>
						</div>
						<div class='col-lg-4 col-md-8 col-sm-12'>
							<div class='p-1 text-center tile orange mt-1' onclick="location.href='$target_file?route=view_teachers'">
								<div class='icon'><i class='icon-table'></i></div>
								Teachers
							</div>
						</div>
						<div class='col-lg-4 col-md-8 col-sm-12'>
							<div class='p-1 text-center tile orange mt-1' onclick="location.href='$target_file?route=view_admins'">
								<div class='icon'><i class='icon-table'></i></div>
								Administrators
							</div>
						</div>
					</div>
					<div class='row mt-2'>
						<div class='col-lg-4 col-md-8 col-sm-12'>
							<div class='p-1 text-center tile orange mt-1' onclick="location.href='$target_file?route=admin_view_groups'">
								<div class='icon'><i class='icon-table'></i></div>
								Groups
							</div>
						</div>
						<div class='col-lg-4 col-md-8 col-sm-12'>
							<div class='p-1 text-center tile orange mt-1' onclick="location.href='$target_file?route=admin_view_announcements'">
								<div class='icon'><i class='icon-table'></i></div>
								Announcements
							</div>
						</div>
						<div class='col-lg-4 col-md-8 col-sm-12'>
							<div class='p-1 text-center tile orange mt-1' onclick="location.href='$target_file?route=admin_view_assessments'">
								<div class='icon'><i class='icon-table'></i></div>
								Assessments
							</div>
						</div>
					</div>
					<div class='row mt-2'>
						<div class='col-lg-4 col-md-8 col-sm-12'>
							<div class='p-1 text-center tile orange mt-1' onclick="location.href='$target_file?route=admin_view_documents'">
								<div class='icon'><i class='icon-table'></i></div>
								Documents
							</div>
						</div>
						<div class='col-lg-4 col-md-8 col-sm-12'>
							<div class='p-1 text-center tile orange mt-1' onclick="location.href='$target_file?route=view_quotes'">
								<div class='icon'><i class='icon-table'></i></div>
								Quotes
							</div>
						</div>
					</div>
				</div>
			</div>
		HTML;
	}
}