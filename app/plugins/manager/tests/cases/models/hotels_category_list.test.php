<?php
/* HotelsCategoryList Test cases generated on: 2011-09-20 14:09:38 : 1316508998*/
App::import('Model', 'manager.HotelsCategoryList');

class HotelsCategoryListTestCase extends CakeTestCase {
	function startTest() {
		$this->HotelsCategoryList =& ClassRegistry::init('HotelsCategoryList');
	}

	function endTest() {
		unset($this->HotelsCategoryList);
		ClassRegistry::flush();
	}

}
?>