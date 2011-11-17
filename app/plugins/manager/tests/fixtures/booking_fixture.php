<?php
/* Booking Fixture generated on: 2011-10-16 17:10:28 : 1318766308 */
class BookingFixture extends CakeTestFixture {
	var $name = 'Booking';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'hotel_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'room_type_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'number_of_rooms' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'from_date' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 30),
		'end_date' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 30),
		'estimated_price' => array('type' => 'float', 'null' => false, 'default' => NULL),
		'coupon_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'notes' => array('type' => 'text', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'hotel_id' => array('column' => array('hotel_id', 'room_type_id'), 'unique' => 0), 'user_id' => array('column' => 'user_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'user_id' => 1,
			'hotel_id' => 1,
			'room_type_id' => 1,
			'number_of_rooms' => 1,
			'from_date' => 'Lorem ipsum dolor sit amet',
			'end_date' => 'Lorem ipsum dolor sit amet',
			'estimated_price' => 1,
			'coupon_id' => 1,
			'notes' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.'
		),
	);
}
?>