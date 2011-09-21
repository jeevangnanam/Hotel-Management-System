<?php
class HotelsController extends ManagerAppController {

	var $name = 'Hotels';

            
        function beforeFilter() {
            
        $this->Auth->allow('test');
        
        }
        
	function index() {
		$this->Hotel->recursive = 0;
		$this->set('hotels', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid hotel', true));
			$this->redirect(array('action' => 'index'));
		}
               // $conditions =  array('id' )
		$this->set('hotel', $this->Hotel->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Hotel->create();
			if ($this->Hotel->save($this->data)) {
				$this->Session->setFlash(__('The hotel has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The hotel could not be saved. Please, try again.', true));
			}
		}
		$categories = $this->Hotel->Category->find('list');
		$categoryLists = $this->Hotel->CategoryList->find('list');
		$features = $this->Hotel->Feature->find('list');
		$managers = $this->Hotel->Manager->find('list');
		$meta = $this->Hotel->Metum->find('list');
		$pictures = $this->Hotel->Picture->find('list');
		$roomCapacities = $this->Hotel->RoomCapacity->find('list');
		$roomTypes = $this->Hotel->RoomType->find('list');
		$this->set(compact('categories', 'categoryLists', 'features', 'managers', 'meta', 'pictures', 'roomCapacities', 'roomTypes'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid hotel', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Hotel->save($this->data)) {
				$this->Session->setFlash(__('The hotel has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The hotel could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Hotel->read(null, $id);
		}
		$categories = $this->Hotel->Category->find('list');
		$categoryLists = $this->Hotel->CategoryList->find('list');
		$features = $this->Hotel->Feature->find('list');
		$managers = $this->Hotel->Manager->find('list');
		$meta = $this->Hotel->Metum->find('list');
		$pictures = $this->Hotel->Picture->find('list');
		$roomCapacities = $this->Hotel->RoomCapacity->find('list');
		$roomTypes = $this->Hotel->RoomType->find('list');
		$this->set(compact('categories', 'categoryLists', 'features', 'managers', 'meta', 'pictures', 'roomCapacities', 'roomTypes'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for hotel', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Hotel->delete($id)) {
			$this->Session->setFlash(__('Hotel deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Hotel was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>