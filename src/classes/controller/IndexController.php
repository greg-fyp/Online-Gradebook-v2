<?php

class IndexController extends Controller {
	public function createHtmlOutput() {
		switch ($this->task) {
			case 'information':
				$view = Creator::createObject('InformationView');
				break;
			case 'terms':
				$view = Creator::createObject('TermsView');
				break;
			case 'login':
				$view = Creator::createObject('LoginView');
				break;
			default:
				$view = Creator::createObject('IndexView');
		}

		$view->create();
		$this->html_output = $view->getHtmlOutput();
	}
}