<?php

abstract class WelcomeTemplateView extends TemplateView {
	public function __construct() {
		parent::__construct();
	}

	public function __destruct() {}

	public function addPageContent() {
		$target_file = ROOT_PATH;
		$this->html_output .= <<< HTML
		<body>
			<header>
				<nav style='min-height: 60px;' class='navbar navbar-dark bg-dark fixed-top navbar-expand-md'>
					<div class='navbar-brand ml-1'>Online Gradebook</div>
					<button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#menubar' aria-controls='menubar'
						aria-expanded='false' aria-label='toggler'>
						<span class='navbar-toggler-icon'></span>
					</button>
					<div class='collapse navbar-collapse' id='menubar'>
						<ul class='navbar-nav'>
							<li class='nav-item'>
								<a class='nav-link' href='$target_file'>About</a>
							</li>
							<li class='nav-item'>
								<a class='nav-link' href='$target_file?route=information'>Information</a>
							</li>
							<li class='nav-item'>
								<a class='nav-link' href='$target_file?route=terms'>Terms & Conditions</a>
							</li>
						</ul>
						<div class='ml-auto'>
							<button class='btn btn-info' onclick="location.href='$target_file?route=user_login'">Login</button>
						</div>
					</div>
				</nav>
			</header>
			<main role='main' class='container'>
		HTML;
		$this->html_output .= $this->addWelcomePageContent();
		$this->html_output .= $this->buildFooter();
	}

	public function buildFooter() {
		$this->html_output .= <<< HTML
			</main>
			<footer style='
			position: absolute;
			font-size: 20px;
			width: 100%;
			bottom: 0;
			height: 60px;
			line-height: 60px;
			background-color: #f5f5f5;'>
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

	abstract protected function addWelcomePageContent();
}