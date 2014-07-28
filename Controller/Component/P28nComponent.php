<?php  
App::uses('Component', 'Controller');
class P28nComponent extends Component {

    public $components = array('Session', 'Cookie');

    function __construct(ComponentCollection $collection, $settings = array()) {
        parent::__construct($collection, $settings);
    }

    function startup() { 
        if (!$this->Session->check('Config.language')) { 
            $this->change(($this->Cookie->read('lang') ? $this->Cookie->read('lang') : DEFAULT_LANGUAGE)); 
            
        } 
    } 
    function change($lang = null) {
        if (!empty($lang)) { 
            $this->Session->write('Config.language', $lang); 
            $this->Cookie->write('lang', $lang, null, '+350 day');  
            Configure::write('Config.language', $lang);
        } 
    } 
} 
?>