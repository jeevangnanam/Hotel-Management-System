<?php
/* Hotels Test cases generated on: 2011-09-20 15:09:08 : 1316511848*/
App::import('Controller', 'manager.Hotels');

class TestHotelsController extends HotelsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class HotelsControllerTestCase extends CakeTestCase {
	function startTest() {
		$this->Hotels =& new TestHotelsController();
		$this->Hotels->constructClasses();
	}

	function endTest() {
		unset($this->Hotels);
		ClassRegistry::flush();
	}

}
?>