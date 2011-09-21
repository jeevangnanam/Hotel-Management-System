<?php
/* HotelsRoomCapacity Fixture generated on: 2011-09-20 15:09:34 : 1316511694 */
class HotelsRoomCapacityFixture extends CakeTestFixture {
	var $name = 'HotelsRoomCapacity';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'hotel_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'room_type_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'max_adults' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 20),
		'max_children' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 20),
		'additional_adult_charge' => array('type' => 'float', 'null' => false, 'default' => NULL),
		'additional_child_charge' => array('type' => 'float', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'hotel_id' => array('column' => array('hotel_id', 'room_type_id'), 'unique' => 0), 'room_type_id' => array('column' => 'room_type_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'hotel_id' => 1,
			'room_type_id' => 1,
			'max_adults' => 1,
			'max_children' => 1,
			'additional_adult_charge' => 1,
			'additional_child_charge' => 1
		),
	);
}
?>