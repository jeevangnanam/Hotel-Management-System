<?php
/* HotelsFeature Fixture generated on: 2011-09-30 13:09:16 : 1317370396 */
class HotelsFeatureFixture extends CakeTestFixture {
	var $name = 'HotelsFeature';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'hotel_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'feature' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 250),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'hotel_id' => array('column' => 'hotel_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'hotel_id' => 1,
			'feature' => 'Lorem ipsum dolor sit amet'
		),
	);
}
?>