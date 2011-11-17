<?php
/* Hotel Test cases generated on: 2011-10-26 13:10:59 : 1319615099*/
App::import('Model', 'manager.Hotel');

class HotelTestCase extends CakeTestCase {
	function startTest() {
		$this->Hotel =& ClassRegistry::init('Hotel');
	}

	function endTest() {
		unset($this->Hotel);
		ClassRegistry::flush();
	}

}
?>