<?php
/* HotelsPicture Test cases generated on: 2011-09-20 14:09:29 : 1316509169*/
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