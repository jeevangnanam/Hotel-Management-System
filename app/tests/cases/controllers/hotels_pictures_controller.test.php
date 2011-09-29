<?php
/* HotelsPictures Test cases generated on: 2011-09-25 03:09:45 : 1316900445*/
App::import('Controller', 'HotelsPictures');

class TestHotelsPicturesController extends HotelsPicturesController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class HotelsPicturesControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.hotels_picture', 'app.block', 'app.region', 'app.link', 'app.menu', 'app.setting', 'app.node', 'app.user', 'app.role', 'app.comment', 'app.meta', 'app.taxonomy', 'app.term', 'app.vocabulary', 'app.type', 'app.types_vocabulary', 'app.nodes_taxonomy');

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