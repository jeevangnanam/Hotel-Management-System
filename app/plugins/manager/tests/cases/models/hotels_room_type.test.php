<?php
/* HotelsRoomType Test cases generated on: 2011-09-23 10:09:19 : 1316755159*/
App::import('Model', 'manager.HotelsRoomType');

class HotelsRoomTypeTestCase extends CakeTestCase {
	function startTest() {
		$this->HotelsRoomType =& ClassRegistry::init('HotelsRoomType');
	}

	function endTest() {
		unset($this->HotelsRoomType);
		ClassRegistry::flush();
	}

}
?>