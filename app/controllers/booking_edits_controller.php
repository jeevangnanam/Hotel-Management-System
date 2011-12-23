<?php
class BookingEditsController extends AppController {

	var $name = 'BookingEdits';

	function index() {
		$this->BookingEdit->recursive = 0;
		$this->set('bookingEdits', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid booking edit', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('bookingEdit', $this->BookingEdit->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->BookingEdit->create();
			if ($this->BookingEdit->save($this->data)) {
				$this->Session->setFlash(__('The booking edit has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The booking edit could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid booking edit', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->BookingEdit->save($this->data)) {
				$this->Session->setFlash(__('The booking edit has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The booking edit could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->BookingEdit->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for booking edit', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->BookingEdit->delete($id)) {
			$this->Session->setFlash(__('Booking edit deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Booking edit was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
