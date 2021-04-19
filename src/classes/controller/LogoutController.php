<?php

class LogoutController extends Controller {
	public function createHtmlOutput() {
		$this->logout();
		$controller = Creator::createObject('IndexController');
		$controller->set('login');
		$controller->createHtmlOutput();
		$this->html_output = $controller->getHtmlOutput();
	}

	private function logout() {
		$session = session_id();
		if ($session != '') {
			setcookie ($session, "", time() - 3600);
        	unset($_SESSION);
        	unset($_POST);
        	session_destroy();
        	session_unset();
		}
        
	}
}