<?php
/* HotelsManager Fixture generated on: 2011-09-20 14:09:24 : 1316509104 */
class HotelsManagerFixture extends CakeTestFixture {
	var $name = 'HotelsManager';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'hotel_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'hotel_id' => array('column' => array('hotel_id', 'user_id'), 'unique' => 0), 'user_id' => array('column' => 'user_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'hotel_id' => 1,
			'user_id' => 1
		),
	);
}
?>