<?php
class HotelsRoomTypesController extends ManagerAppController {

	var $name = 'HotelsRoomTypes';

        function beforeFilter() {

        $this->Auth->allow('test');
        $this->layout = "manager";
      
       
        }
	function index() {
            
		$this->HotelsRoomType->recursive = 0;
		$this->set('hotelsRoomTypes', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid hotels room type', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('hotelsRoomType', $this->HotelsRoomType->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->HotelsRoomType->create();
			if ($this->HotelsRoomType->save($this->data)) {
				$this->Session->setFlash(__('The hotels room type has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The hotels room type could not be saved. Please, try again.', true));
			}
		}
		$hotels = $this->HotelsRoomType->Hotel->find('list',array('joins' => array(array('table' => 'hotels_managers' , 'alias' => 'HotelManager' , 'type' => 'INNER' , 'conditions' => array('Hotel.id = HotelManager.hotel_id','HotelManager.user_id' => $this->Auth->user('id'))))));
                debug($hotels);
		$this->set(compact('hotels'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid hotels room type', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->HotelsRoomType->save($this->data)) {
				$this->Session->setFlash(__('The hotels room type has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The hotels room type could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->HotelsRoomType->read(null, $id);
		}
		$hotels = $this->HotelsRoomType->Hotel->find('list');
		$this->set(compact('hotels'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for hotels room type', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->HotelsRoomType->delete($id)) {
			$this->Session->setFlash(__('Hotels room type deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Hotels room type was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>