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
		$this->html_output .=  <<< HTML
			asdf
		HTML;
	}
}