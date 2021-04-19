<?php

abstract class AdministratorView extends TemplateView {
	protected $personal_details;

	public function __construct() {
		parent::__construct();
		$this->addStylesheet(CSS_PATH . 'admin.css');
		$this->addScript('admin.js');
	}

	public function __destruct() {}

	public function setPersonal($details) {
		$this->personal_details = $details;
	}

	public function addPageContent() {
		$target_file = ROOT_PATH;
		$first_name = strtok($this->personal_details['user_id']['user_fullname'], ' ');
		$this->html_output .= <<< HTML
		<header>
		<nav class="navbar navbar-dark bg-primary fixed-top">
			<div class='navbar-brand ml-1'>Administrator Panel</div>
			<button class="btn btn-primary order-first" type="button" data-toggle="collapse" data-target="#mainmenu" aria-controls="mainmenu" aria-expanded="false" aria-label="navbar switch" onclick="switchNav();">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class='dropdown ml-auto'>
				<button class='btn btn-primary dropdown-toggle' type='button' id='submenu' data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class='icon-user'></i>$first_name </button>
				<div class='dropdown-menu dropdown-menu-right' aria-labelledby='submenu'>
					<a class='dropdown-item' href='#'><i class='icon-pencil'></i> Edit Profile</a>
					<a class='dropdown-item' href='#'><i class='icon-key'></i> Change Password</a>
					<div class="dropdown-divider"></div>
					<a class='dropdown-item' href='$target_file?route=user_logout'><i class='icon-logout'></i> Logout</a>
				</div>
			</div>
		</nav>
		</header>
		<nav class='collapse show col-md-4' id='mainmenu'>
		<a href='#'><i class='icon-home'></i>  Home</a>
		<div class='menu-sep'></div>
		<a href='$target_file?route=admins'><i class='icon-wrench'></i> Administrators</a>
		<a href='$target_file?route=institutions'><i class='icon-bank'></i> Institutions</a>
		<a href='#'><i class='icon-user-plus'></i>  Registration Requests</a>
		<a href='#'><i class='icon-question-circle-o'></i>  Support Requests</a>
		<a href='#'><i class='icon-quote-right'></i> Quotes</a>
		<a href='#'><i class='icon-database'></i> Databases</a>
		<div class='menu-sep'></div>
		<a href='#'><i class='icon-user'></i> My Details</a>
		<a href="#"><i class='icon-cog-alt'></i>  Settings</a>
		</nav>
		<main>
		HTML;
		$this->html_output .= $this->addAdminPageContent() . '</main>';
	}

	abstract protected function addAdminPageContent();
}