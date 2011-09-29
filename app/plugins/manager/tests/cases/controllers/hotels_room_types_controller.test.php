<?php
/* HotelsRoomTypes Test cases generated on: 2011-09-29 16:09:11 : 1317294551*/
App::import('Controller', 'manager.HotelsRoomTypes');

class TestHotelsRoomTypesController extends HotelsRoomTypesController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class HotelsRoomTypesControllerTestCase extends CakeTestCase {
	function startTest() {
		$this->HotelsRoomTypes =& new TestHotelsRoomTypesController();
		$this->HotelsRoomTypes->constructClasses();
	}

	function endTest() {
		unset($this->HotelsRoomTypes);
		ClassRegistry::flush();
	}

}
?>