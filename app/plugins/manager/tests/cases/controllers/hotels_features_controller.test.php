<?php
/* HotelsFeatures Test cases generated on: 2011-09-30 13:09:23 : 1317370463*/
App::import('Controller', 'manager.HotelsFeatures');

class TestHotelsFeaturesController extends HotelsFeaturesController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class HotelsFeaturesControllerTestCase extends CakeTestCase {
	function startTest() {
		$this->HotelsFeatures =& new TestHotelsFeaturesController();
		$this->HotelsFeatures->constructClasses();
	}

	function endTest() {
		unset($this->HotelsFeatures);
		ClassRegistry::flush();
	}

}
?>