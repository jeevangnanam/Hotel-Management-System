<?php
/* HotelsRoomCapacity Test cases generated on: 2011-09-20 15:09:34 : 1316511694*/
App::import('Model', 'manager.HotelsRoomCapacity');

class HotelsRoomCapacityTestCase extends CakeTestCase {
	function startTest() {
		$this->HotelsRoomCapacity =& ClassRegistry::init('HotelsRoomCapacity');
	}

	function endTest() {
		unset($this->HotelsRoomCapacity);
		ClassRegistry::flush();
	}

}
?>