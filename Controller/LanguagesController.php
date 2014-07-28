<?php
App::uses('AppController', 'Controller');
/**
 * Languages Controller
 *
 * @property Language $Language
 */
class LanguagesController extends AppController {

    public $paginate = array(
        'order' => array(
                    'Language.active' => 'DESC'
                    ),
        'limit' => 10
    );
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Language->recursive = 0;
		$this->set('languages', $this->Language->find('all', array('order' => array('Language.active' => 'DESC'))));
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Language->id = $id;
		if (!$this->Language->exists()) {
			throw new NotFoundException(__('Invalid language'));
		}
		$this->set('language', $this->Language->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Language->create();
			if ($this->Language->save($this->request->data)) {
				$this->Session->setFlash(__('The language has been saved'),'flash/flash_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The language could not be saved. Please, try again.'),'flash/flash_error');
			}
		}
	}

    public function active($id = null) {
        $this->Language->id = $id;
        if (!$this->Language->exists()) {
            throw new NotFoundException(__('Invalid language'));
        }
        $l = $this->Language->read('active', $id);
        $l['Language']['active'] = $l['Language']['active'] == 1 ? 0 : 1;

        if ($this->Language->save($l))
            $this->Session->setFlash(__('Changes have been saved.'),'flash/flash_success');
        else
            $this->Session->setFlash(__('Changes could not been saved.'),'flash/flash_error');

        $this->redirect(array('action' => 'index'));
    }

    public function online($id = null) {
        $this->Language->id = $id;
        if (!$this->Language->exists()) {
            throw new NotFoundException(__('Invalid language'));
        }
        $l = $this->Language->read('online', $id);
        $l['Language']['online'] = $l['Language']['online'] == 1 ? 0 : 1;

        if ($this->Language->save($l))
            $this->Session->setFlash(__('Changes have been saved.'),'flash/flash_success');
        else
            $this->Session->setFlash(__('Changes could not been saved.'),'flash/flash_error');

        $this->redirect(array('action' => 'index'));
    }


	public function edit($id = null) {
		$this->Language->id = $id;
		if (!$this->Language->exists()) {
			throw new NotFoundException(__('Invalid language'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Language->save($this->request->data)) {
				$this->Session->setFlash(__('The language has been saved'),'flash/flash_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The language could not be saved. Please, try again.'),'flash/flash_error');
			}
		} else {
			$this->request->data = $this->Language->read(null, $id);
		}
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Language->id = $id;
		if (!$this->Language->exists()) {
			throw new NotFoundException(__('Invalid language'));
		}
		if ($this->Language->delete()) {
			$this->Session->setFlash(__('Language deleted'),'flash/flash_success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Language was not deleted'),'flash/flash_error');
		$this->redirect(array('action' => 'index'));
	}
}
