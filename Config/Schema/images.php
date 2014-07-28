<?php
/**
 * CakePHP Tags Plugin
 *
 * Copyright 2009 - 2010, Cake Development Corporation
 *                        1785 E. Sahara Avenue, Suite 490-423
 *                        Las Vegas, Nevada 89104
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright 2009 - 2010, Cake Development Corporation (http://cakedc.com)
 * @link      http://github.com/CakeDC/Tags
 * @package   plugins.tags
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * Short description for class.
 *
 * @package		plugins.tags
 * @subpackage	plugins.tags.config
 */

class ImagesSchema extends CakeSchema {


/**
 * Before callback
 *
 * @param array Event
 * @return boolean
 */
	public function before($event = array()) {
		return true;
	}

/**
 * After callback
 *
 * @param array Event
 * @return boolean
 */
	public function after($event = array()) {
		return true;
	}

/**
 * Schema for taggeds table
 *
 * @var array
 * @access public
 */
	public $tagged = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary'),
		'file' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 125),
		'info' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 255),
        'sequence' => array('type' => 'integer', 'null' => false),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
		)
	);
}
