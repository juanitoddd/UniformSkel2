<?php  
class P28nController extends AppController {

    public $name = 'P28n';
    public $uses = array(); 
    public $components = array('P28n'); 
    
    public function beforeFilter() {
        parent::beforeFilter();
        //$this->Auth->allow('change');
    }
    
    function change($lang = null) { 
        $this->P28n->change($lang);
        $this->redirect($this->referer(null, true));
    } 
    
    function login($lang = null) { 
        $this->P28n->change($lang);        
        $this->redirect($this->Auth->redirect()); 
    } 
    
    function locale($lang = null) { 
        $this->P28n->change($lang);         
        $this->redirect(array('controller'=>'settings','action'=>'locale')); 
    }

    function shuntRequest() { 
        $this->P28n->change($this->params['lang']); 
        $args = func_get_args(); 
        $this->redirect("/" . implode("/", $args)); 
    } 
} 
?>