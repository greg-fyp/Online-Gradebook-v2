<?php

abstract class AdministratorView extends TemplateView {
	protected $personal_details;

	public function __construct() {
		parent::__construct();
		$this->addStylesheet(CSS_PATH . 'admin.css');
		$this->addScript(JS_PATH . 'admin.js');
	}

	public function __destruct() {}

	public function setPersonal($details) {
		$this->personal_details = $details;
	}

	public function addPageContent() {
		$target_file = ROOT_PATH;
		$first_name = strtok($this->personal_details['user_id']['user_fullname'], ' ');
		$this->html_output .= <<< HTML
		<body>
				<header>
					<nav style='min-height: 60px;' class='navbar navbar-dark bg-info fixed-top navbar-expand-md'>
					<div class='navbar-brand ml-1'>Administrator Panel</div>
					<button class='navbar-toggler order-first' type='button' data-toggle='collapse' data-target='#menubar' aria-controls='menubar'
						aria-expanded='false' aria-label='toggler'>
						<span class='navbar-toggler-icon'></span>
					</button>
					<div class='collapse navbar-collapse' id='menubar'>
						<ul class='navbar-nav'>
							<li class='nav-item'>
								<a class='nav-link' href='$target_file?route=admin_main'>Home</a>
							</li>
						</ul>
						<div class='dropdown ml-auto'>
							<button class='btn btn-info dropdown-toggle' type='button' id='submenu' data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class='icon-user'></i>$first_name </button>
							<div class='dropdown-menu dropdown-menu-right' aria-labelledby='submenu'>
								<a class='dropdown-item' href='$target_file?route=edit_admin'><i class='icon-pencil'></i> Edit Profile</a>
								<a class='dropdown-item' href='$target_file?route=admin_change_password'><i class='icon-key'></i>
								Change Password</a>
								<div class="dropdown-divider"></div>
								<a class='dropdown-item' href='$target_file?route=user_logout'><i class='icon-logout'></i> Logout</a>
							</div>
						</div>
					</div>
				</nav>
				</header>
			<main role='main' class='container'>
		HTML;
		$this->html_output .= $this->addAdminPageContent() . '</div></main>';
		$this->html_output .= $this->buildFooter();
	}

	abstract protected function addAdminPageContent();

	public function buildFooter() {
		$this->html_output .= <<< HTML
			</main>
			<footer>
				<div class='container' style='text-align: center;'>
					<div class='text-muted'>De Montfort University, Leicester, UK
					<a href='https://www.facebook.com/dmuleicester/' target='_blank'><i class='icon-facebook'></i></a>
					<a href='https://twitter.com/dmuleicester' target='_blank'><i class='icon-twitter'></i></a>
					<a href='https://www.linkedin.com/school/de-montfort-university/' target='_blank'><i class='icon-linkedin-squared'></i></a>
				</div>
				</div>
			</footer>
		HTML;
	}
}