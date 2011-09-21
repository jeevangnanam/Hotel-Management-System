<?php
/* HotelsManager Test cases generated on: 2011-09-20 14:09:24 : 1316509104*/
App::import('Model', 'manager.HotelsManager');

class HotelsManagerTestCase extends CakeTestCase {
	function startTest() {
		$this->HotelsManager =& ClassRegistry::init('HotelsManager');
	}

	function endTest() {
		unset($this->HotelsManager);
		ClassRegistry::flush();
	}

}
?>