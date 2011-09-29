<?php
/* HotelPictures Test cases generated on: 2011-09-25 03:09:06 : 1316899806*/
App::import('Controller', 'manager.HotelPictures');

class TestHotelPicturesController extends HotelPicturesController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class HotelPicturesControllerTestCase extends CakeTestCase {
	function startTest() {
		$this->HotelPictures =& new TestHotelPicturesController();
		$this->HotelPictures->constructClasses();
	}

	function endTest() {
		unset($this->HotelPictures);
		ClassRegistry::flush();
	}

}
?>