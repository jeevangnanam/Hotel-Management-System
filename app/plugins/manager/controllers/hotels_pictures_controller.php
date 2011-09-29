<?php
class HotelsPicturesController extends ManagerAppController {

	var $name = 'HotelsPictures';
 function beforeFilter() {

        $this->Auth->allow('test');
    }
	function index() {
		$this->HotelsPicture->recursive = 0;
		$this->set('hotelsPictures', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid hotels picture', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('hotelsPicture', $this->HotelsPicture->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->HotelsPicture->create();
			if ($this->HotelsPicture->save($this->data)) {
				$this->Session->setFlash(__('The hotels picture has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The hotels picture could not be saved. Please, try again.', true));
			}
		}
		$hotels = $this->HotelsPicture->Hotel->find('list');
		$this->set(compact('hotels'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid hotels picture', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->HotelsPicture->save($this->data)) {
				$this->Session->setFlash(__('The hotels picture has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The hotels picture could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->HotelsPicture->read(null, $id);
		}
		$hotels = $this->HotelsPicture->Hotel->find('list');
		$this->set(compact('hotels'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for hotels picture', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->HotelsPicture->delete($id)) {
			$this->Session->setFlash(__('Hotels picture deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Hotels picture was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>