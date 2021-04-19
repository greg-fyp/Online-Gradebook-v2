<?php

class TermsView extends WelcomeTemplateView {
	public function __construct() {
		parent::__construct();
	}

	public function create() {
		$this->page_title = APP_NAME . ' Contact Us';
		$this->createPage();
	}

	public function addWelcomePageContent() {
		$this->html_output .= <<< HTML
		<div id='content-wrap' style='padding-top: 100px; padding-bottom: 40px; text-align: center;'>
			<div class='card-deck mb-3'>
					<div class='card mb-4 box-shadow'>
						<div class='card-header'>
							<h4 class="my-0 font-weight-normal">Terms & Conditions</h4>
						</div>
						<div class='card-body'>
							Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque laoreet suscipit neque, sit amet porta est laoreet et. Aenean finibus, enim in euismod pulvinar, orci enim porta turpis, et porttitor arcu enim sit amet neque. Nullam lobortis, nisl at fermentum ullamcorper, dui felis sollicitudin lacus, at placerat diam neque sed ex. Duis eget tellus ut metus cursus aliquet. Vivamus interdum, diam ut convallis facilisis, ligula tellus pellentesque nisi, eget luctus nibh arcu quis arcu. Morbi ac blandit urna, vehicula hendrerit odio. Morbi in tellus libero. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sed mi ligula. Donec cursus sed erat et aliquet. Curabitur tempor turpis arcu, vitae faucibus nisi placerat hendrerit. Integer porta convallis nulla, non porta tortor. Integer porta faucibus elementum. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Nam urna nisl, tincidunt vel imperdiet id, iaculis ac magna. Praesent eget porttitor lacus.
								Etiam euismod dui nec libero rhoncus, eu fermentum massa pellentesque. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Nullam dapibus est at dui bibendum hendrerit. Vivamus ante ante, rutrum at dolor in, ullamcorper accumsan sem. Aenean feugiat aliquam urna, in posuere odio ultrices ut. Fusce fringilla laoreet turpis, at blandit diam faucibus at. Phasellus ac elit fermentum massa placerat molestie vel nec libero. Aliquam tempor arcu nec nulla ultricies interdum. Phasellus id pellentesque tortor. Nam elementum, massa viverra dapibus congue, nisi justo venenatis orci, vitae imperdiet dui ipsum et libero. Quisque sed justo eget est pretium ornare. Praesent iaculis nulla sit amet leo scelerisque dapibus.
								Nunc eget augue commodo, mollis odio a, consectetur sem. Nulla pellentesque velit id nulla tincidunt dictum. Praesent in augue nec libero interdum scelerisque vitae vel tellus. Aliquam vitae eleifend lacus. Sed non tempus libero, sit amet facilisis massa. Donec augue odio, dapibus quis est eget, pellentesque pretium tortor. Morbi vel placerat diam. Praesent eleifend quis ex nec tempor. Pellentesque laoreet eu augue sit amet malesuada. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Proin iaculis felis quis nunc elementum euismod. Suspendisse tortor erat, lobortis non porta consectetur, tempor in turpis. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Nunc urna leo, iaculis in massa a, auctor convallis neque. Proin id commodo tortor. Donec eget augue feugiat, feugiat ex vitae, tincidunt nunc.
						</div>
					</div>
				</div>
			</div>
		HTML;
	}
}