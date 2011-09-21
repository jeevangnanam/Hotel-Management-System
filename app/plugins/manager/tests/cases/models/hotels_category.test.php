<?php
/* HotelsCategory Test cases generated on: 2011-09-20 14:09:06 : 1316508546*/
App::import('Model', 'manager.HotelsCategory');

class HotelsCategoryTestCase extends CakeTestCase {
	function startTest() {
		$this->HotelsCategory =& ClassRegistry::init('HotelsCategory');
	}

	function endTest() {
		unset($this->HotelsCategory);
		ClassRegistry::flush();
	}

}
?>