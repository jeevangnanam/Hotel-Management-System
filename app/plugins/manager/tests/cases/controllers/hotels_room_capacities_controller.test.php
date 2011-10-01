<?php
/* HotelsRoomCapacities Test cases generated on: 2011-09-29 23:09:18 : 1317320898*/
App::import('Controller', 'manager.HotelsRoomCapacities');

class TestHotelsRoomCapacitiesController extends HotelsRoomCapacitiesController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class HotelsRoomCapacitiesControllerTestCase extends CakeTestCase {
	function startTest() {
		$this->HotelsRoomCapacities =& new TestHotelsRoomCapacitiesController();
		$this->HotelsRoomCapacities->constructClasses();
	}

	function endTest() {
		unset($this->HotelsRoomCapacities);
		ClassRegistry::flush();
	}

}
?>