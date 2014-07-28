<?php
App::uses('AppController', 'Controller');

class SitemapsController extends AppController {

    public $helpers = array('Time');

    //public $uses = array('Garage');

    public $components = array('RequestHandler');

	public function index() {
        //$this->layout="empty";
        //$this->set('sites', $this->Garage->find('all',array('recursive' => -1)));
        //$this->set('garages', $this->Garage->find('all',array('recursive' => -1)));
	}
}
