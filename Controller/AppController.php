<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
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
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
    
    public $helpers = array('Form', 'Html','Session','Js','Uniform');
    
    public $components = array(
        'DebugKit.Toolbar',
        'Session',
        'Cookie'
    );
    
    public function beforeFilter() {
        /*
        $this->auth = $this->Session->read('Admin');
        if($this->auth){
            $this->set('auth',$this->Session->read('Admin'));
        }else{
            $c1 = ( $this->params->params['controller'] == 'admins' && $this->params->params['action'] == 'login' );
            $c2 = $this->params->params['controller'] == 'system';
            $c3 = $this->params->params['controller'] == 'images';

            if( $c1 || $c2 || $c3 ){

            }else
                $this->redirect(array('controller'=>'admins','action'=>'login'));
        }
        */
        //Secure Url
        //if(!$this->security())
            //$this->redirect('/');
    }

    function security(){
        $out = true;
        foreach($_GET as $param)
            $out = $this->match($param);
        foreach($_POST as $param)
            $out = $this->match($param);
        $out = $this->match($this->here);
        return $out;
    }

    function match($string){
        $out = true;
        if(preg_match('/\s/', $string))
            $out = false; // no whitespaces
        if(preg_match('/[\'"]/', $string))
            $out = false; // no quotes
        //if(preg_match('/[\/\\\\]/', $string))
        //$out = false;; // no slashes
        //if(preg_match('/(and|or|null|not)/i', $string))
        //$out = false; // no sqli boolean keywords
        if(preg_match('/(union|select|from|where)/i', $string))
            $out = false; // no sqli select keywords
        if(preg_match('/(group|order|having|limit)/i', $string))
            $out = false; //  no sqli select keywords
        if(preg_match('/(into|file|case)/i', $string))
            $out = false; // no sqli operators
        if(preg_match('/(--|#|\/\*)/', $string))
            $out = false; // no sqli comments
        if(preg_match('/(=|&|\|)/', $string))
            $out = false; // no boolean operators
        return $out;
        /*
        if(preg_match('/\s/', $string))
            exit('attack1'); // no whitespaces
        if(preg_match('/[\'"]/', $string))
            exit('attack2'); // no quotes
        //if(preg_match('/[\/\\\\]/', $string))
            //exit('attack3'); // no slashes
        if(preg_match('/(and|or|null|not)/i', $string))
            exit('attack4'); // no sqli boolean keywords
        if(preg_match('/(union|select|from|where)/i', $string))
            exit('attack5'); // no sqli select keywords
        if(preg_match('/(group|order|having|limit)/i', $string))
            exit('attack6'); //  no sqli select keywords
        if(preg_match('/(into|file|case)/i', $string))
            exit('attack7'); // no sqli operators
        if(preg_match('/(--|#|\/\*)/', $string))
            exit('attack8'); // no sqli comments
        if(preg_match('/(=|&|\|)/', $string))
            exit('attack9'); // no boolean operators
        return $out;
        */
    }

    public function import() {
        $modelClass = $this->modelClass;
        if ( $this->request->is('POST') ) {
            $records_count = $this->$modelClass->find( 'count' );
            try {
                $this->$modelClass->importCSV( $this->request->data[$modelClass]['CsvFile']['tmp_name']  );
            } catch (Exception $e) {
                $import_errors = $this->$modelClass->getImportErrors();
                $this->set( 'import_errors', $import_errors );
                $this->Session->setFlash( __('Error Importing') . ' ' . $this->request->data[$modelClass]['CsvFile']['name'] . ', ' . __('column name mismatch.') , 'flash/flash_error' );
                $this->redirect( array('action'=>'import') );
            }

            $new_records_count = $this->$modelClass->find( 'count' ) - $records_count;
            $this->Session->setFlash(__('Successfully imported') . ' ' . $new_records_count .  ' records from ' . $this->request->data[$modelClass]['CsvFile']['name'] , 'flash/flash_success');
            $this->redirect( array('action'=>'index') );
        }
        $this->set('modelClass', $modelClass );
        $this->render('../Common/import');
    }

    //Online Toggle
    public function toggle($id){
        $modelClass = $this->modelClass;

        $this->$modelClass->id = $id;
        if (!$this->$modelClass->exists()) {
            throw new NotFoundException(__('Invalid '.$modelClass));
        }
        $l = $this->$modelClass->read('online', $id);
        $l[$modelClass]['online'] = !$l[$modelClass]['online'];

        if ($this->$modelClass->save($l))
            $this->Session->setFlash($modelClass . ' #'.$id. ' '.  __('ONLINE.'),'flash/flash_success');
        else
            $this->Session->setFlash($modelClass . ' #'.$id. ' '.  __('OFFLINE.'),'flash/flash_success');
        $this->redirect(array('action' => 'index'));
    }

    //Online Toggle Ajax
    public function toggleAjax($id){
        $this->layout = 'ajax';
        $modelClass = $this->modelClass;
        $this->$modelClass->id = $id;
        if (!$this->$modelClass->exists()) {
            throw new NotFoundException(__('Invalid '.$modelClass));
        }
        $l = $this->$modelClass->read('online', $id);
        $l[$modelClass]['online'] = !$l[$modelClass]['online'];
        $result = false;
        if ($this->$modelClass->save($l))
            $result = true;
        $this->set('out', $result);
        $this->render('../Common/json/response');
    }

    //Online Boolean Attribute Toggle function. Ajax-based
    public function toggleAttr(){
        $this->layout = 'ajax';
        $modelClass = $this->modelClass;
        if ($this->request->is('post') || $this->request->is('put')) {//edit
            $this->$modelClass->id = $this->request->data['id'];
            if (!$this->$modelClass->exists()) {
                throw new NotFoundException(__('Invalid '.$modelClass));
            }
            $l = $this->$modelClass->read($this->request->data['attr'], $this->request->data['id']);
            $l[$modelClass][$this->request->data['attr']] = !$l[$modelClass][$this->request->data['attr']];
            $result = false;
            if ($this->$modelClass->save($l))
                $result = true;
            $this->set('result', $result);
            $this->render('../Common/json/response');
        }
    }

    public function api($id = null){
        $this->layout = 'ajax';
        $modelClass = $this->modelClass;
        $this->$modelClass->recursive = -1;
        if($id){
            $this->$modelClass->id = $id;
            if (!$this->$modelClass->exists()) {
                throw new NotFoundException(__('Invalid '.$modelClass));
            }
            if ($this->request->is('post') || $this->request->is('put')) {//edit
                if ($this->$modelClass->save($this->request->data)) {
                    $this->$modelClass->recursive = -1;
                    $response = $this->$modelClass->find('first', array('conditions'=>array($modelClass.'.id' => $id)));
                    $response = $response[$modelClass];
                } else {
                    $response = 'error';
                }
            }else{ //view
                $response = $this->$modelClass->find('first', array('conditions'=>array($modelClass.'.id' => $id),'recursive'=>1));
                $response = $response[$modelClass];
            }
        }else{
            if ($this->request->is('post')) {  //add
                $this->$modelClass->create();
                if($this->$modelClass->save($this->request->data)){
                    $response = $this->$modelClass->find('first', array('conditions'=>array($modelClass.'.id' => $this->$modelClass->getLastInsertId())));
                }else{
                    $response = 'error';
                }
            }else{ //index
                $this->$modelClass->recursive = 1;
                $response = $this->$modelClass->find('all');
            }
        }
        $this->set('out', $response);
        $this->render('../Common/json/response');
    }

    public function beforeRender(){
        if($this->name == 'CakeError'){
            $this->layout = 'error';
        }
    }

    //Array to XML
    public function print_r_xml($arr,$wrapper = 'data',$cycle = 1)
    {
        $new_line = "\n";
        if($cycle == 1) { $output = '<?xml version="1.0" encoding="UTF-8" ?>'.$new_line; }
        $output.= tabify($cycle - 1).'<'.$wrapper.'>'.$new_line;
        foreach($arr as $key => $val) {
            if(!is_array($val))
                $output.= tabify($cycle).'<'.htmlspecialchars($key).'>'.$val.'</'.htmlspecialchars($key).'>'.$new_line;
            else
                $output.= print_r_xml($val,$key,$cycle + 1).$new_line;
        }
        $output.= tabify($cycle - 1).'</'.$wrapper.'>';
        return $output;
    }

    public function tabify($num_tabs){
        $return = '';
        for($x = 1; $x <= $num_tabs; $x++) { $return.= "\t"; }
        return $return;
    }

    /* USE TO PHOTO CONTROLLER
    function remove(){
        Configure::write('debug',0);
        $this->layout = 'ajax';
        $response = false;
        if($this->request->is('post')){
            $response = $this->Photo->delete($this->request->data['id']);
        }
        $this->set('result', $response);
        $this->render('../Common/json/response');
    }
    */
}
