<?php
/* HotelsPictures Test cases generated on: 2011-09-25 03:09:51 : 1316900691*/
App::import('Controller', 'manager.HotelsPictures');

class TestHotelsPicturesController extends HotelsPicturesController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class HotelsPicturesControllerTestCase extends CakeTestCase {
	function startTest() {
		$this->HotelsPictures =& new TestHotelsPicturesController();
		$this->HotelsPictures->constructClasses();
	}

	function endTest() {
		unset($this->HotelsPictures);
		ClassRegistry::flush();
	}

}
?>