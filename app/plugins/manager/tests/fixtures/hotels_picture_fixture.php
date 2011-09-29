<?php
/* HotelsPicture Fixture generated on: 2011-09-23 15:09:44 : 1316773064 */
class HotelsPictureFixture extends CakeTestFixture {
	var $name = 'HotelsPicture';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'hotel_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'picture' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 250),
		'caption' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 250),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'hotel_id' => array('column' => 'hotel_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'hotel_id' => 1,
			'picture' => 'Lorem ipsum dolor sit amet',
			'caption' => 'Lorem ipsum dolor sit amet'
		),
	);
}
?>