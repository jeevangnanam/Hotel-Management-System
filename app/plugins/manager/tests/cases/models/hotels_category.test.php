<?php
/* HotelsCategory Test cases generated on: 2011-09-23 15:09:08 : 1316773148*/
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