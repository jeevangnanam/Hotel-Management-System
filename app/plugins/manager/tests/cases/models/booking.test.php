<?php
/* Booking Test cases generated on: 2011-10-16 17:10:28 : 1318766308*/
App::import('Model', 'manager.Booking');

class BookingTestCase extends CakeTestCase {
	function startTest() {
		$this->Booking =& ClassRegistry::init('Booking');
	}

	function endTest() {
		unset($this->Booking);
		ClassRegistry::flush();
	}

}
?>