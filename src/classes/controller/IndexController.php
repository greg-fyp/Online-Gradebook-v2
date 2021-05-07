<?php

class IndexController extends Controller {
	public function createHtmlOutput() {
		switch ($this->task) {
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