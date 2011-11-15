<?php
/* Hotel Fixture generated on: 2011-10-26 13:10:59 : 1319615099 */
class HotelFixture extends CakeTestFixture {
	var $name = 'Hotel';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 250),
		'address' => array('type' => 'text', 'null' => false, 'default' => NULL),
		'phone' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'email' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 50),
		'web' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 50),
		'contactperson' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'starclass' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'status' => array('type' => 'boolean', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'contactperson' => array('column' => 'contactperson', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'name' => 'Lorem ipsum dolor sit amet',
			'address' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'phone' => 1,
			'email' => 'Lorem ipsum dolor sit amet',
			'web' => 'Lorem ipsum dolor sit amet',
			'contactperson' => 1,
			'starclass' => 1,
			'status' => 1
		),
	);
}
?>