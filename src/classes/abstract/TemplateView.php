<?php

/**
*
* TemplateView.php
*
* Provides a template of web page. Adds a footer and metaheadings.
*
* @author Greg
*/

abstract class TemplateView {
	protected $page_title;
	protected $html_output;
	protected $css_fname;
	protected $js_fname;

	public function __construct() {
		$this->page_title = '';
		$this->html_output = '';
		$this->css_fname = '';
		$this->js_fname = '';
	}

	public function __destruct() {}

	public function createPage() {
		$this->addMetaHeadings();
		$this->addPageContent();
		$this->addPageFooter();
	}

	public function addMetaHeadings() {
		$fontello_path = CSS_PATH . 'fontello-8a2aae18/css/fontello.css';
		$bootstrap_css = CSS_PATH . 'bootstrap.min.css';
		$bootstrap_js = JS_PATH . 'bootstrap.min.js';

		$html = <<< HTML
		<!DOCTYPE html>
		<html lang='en' style='position: relative; min-height: 100%;'>
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<meta http-equiv="Content-Language" content="en-gb" />
			<meta name="author" content="Greg" />
			<link rel="stylesheet" href="$this->css_fname" type="text/css" />
			<link rel="preconnect" href="https://fonts.gstatic.com">
			<link href=$fontello_path type='text/css' rel='stylesheet'/>
			<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700&amp;subset=latin-ext" rel="stylesheet">
			<link rel='stylesheet' href='$bootstrap_css' type='text/css' />
			<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
			<script src='$bootstrap_js' type="text/javascript"></script>
			<script src='$this->js_fname' type='text/javascript'></script>
			<title>$this->page_title</title>
		</head>
		HTML;

		$this->html_output .= $html;
	}

	abstract protected function addPageContent();

	private function addPageFooter() {
		$this->html_output .= <<< HTML
		</body>
		</html>
		HTML;
	}

	public function getHtmlOutput() {
		return $this->html_output;
	}

	public function addStylesheet($path) {
		$this->css_fname = $path;
	}

	public function addScript($path) {
		$this->js_fname = $path;
	}
}