<?php

class InformationView extends WelcomeTemplateView {
	public function __construct() {
		parent::__construct();
	}

	public function __destruct() {}

	public function create() {
		$this->page_title = APP_NAME . ' Information Page';
		$this->createPage();
	}

	public function addWelcomePageContent() {
		$this->html_output .= <<< HTML
			asdf
		HTML;
	}
}