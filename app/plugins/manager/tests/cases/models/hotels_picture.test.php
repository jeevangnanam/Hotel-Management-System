<?php
/* HotelsPicture Test cases generated on: 2011-09-23 15:09:44 : 1316773064*/
App::import('Model', 'manager.HotelsPicture');

class HotelsPictureTestCase extends CakeTestCase {
	function startTest() {
		$this->HotelsPicture =& ClassRegistry::init('HotelsPicture');
	}

	function endTest() {
		unset($this->HotelsPicture);
		ClassRegistry::flush();
	}

}
?>