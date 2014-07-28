<?php
/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {

    public $actsAs = array(
        'CsvImport' => array(
            'delimiter'  => ';',
            'hasHeader' => true
            //'enclosure' => '',
        ),
        'CsvExport' => array(
            'delimiter'  => ';', //The delimiter for the values, default is ;
            'enclosure' => '"', //The enclosure, default is "
            'max_execution_time' => 360, //Increase for Models with lots of data, has no effect is php safemode is enabled.
            'encoding' => 'utf8' //Prefixes the return file with a BOM and attempts to utf_encode() data
        )
    );

    public function datetimeCondition($data = array(), $field){
        $b = $data[$field['name']].' 00:00:00';
        $e = $data[$field['name']].' 23:59:59';
        $cond = array(
            array($this->alias.'.'.$field['name'].' BETWEEN ? AND ?' => array($b, $e))
        );
        return $cond;
    }

    public function beforeSave($options = array()) {
        //$apply = array('Item','ItemCategory','Apartment','Place','Site','City','Photo','Inquiry','Partner','User','District','Template','Admin');
        //if(in_array($this->alias, $apply))
            //$this->data[$this->alias]['created_by'] = CakeSession::read("Auth.Admin.id");
        return true;
    }
}
