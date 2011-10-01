<?php
/* HotelsFeature Test cases generated on: 2011-09-30 13:09:16 : 1317370396*/
App::import('Model', 'manager.HotelsFeature');

class HotelsFeatureTestCase extends CakeTestCase {
	function startTest() {
		$this->HotelsFeature =& ClassRegistry::init('HotelsFeature');
	}

	function endTest() {
		unset($this->HotelsFeature);
		ClassRegistry::flush();
	}

}
?>