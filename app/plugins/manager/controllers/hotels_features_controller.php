<?php

class HotelsFeaturesController extends ManagerAppController {

    var $name = 'HotelsFeatures';

    function beforeFilter() {

        $this->Auth->allow('test');
    }

    function index() {
        $this->HotelsFeature->recursive = 0;
        $this->set('hotelsFeatures', $this->paginate());
    }

    function view($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid hotels feature', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->set('hotelsFeature', $this->HotelsFeature->read(null, $id));
    }

    function add() {
        if (!empty($this->data)) {
            $this->HotelsFeature->create();
            if ($this->HotelsFeature->save($this->data)) {
                $this->Session->setFlash(__('The hotels feature has been saved', true));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The hotels feature could not be saved. Please, try again.', true));
            }
        }
        $hotels = $this->HotelsFeature->Hotel->find('list',array('joins' => array(array('table' => 'hotels_managers' , 'alias' => 'HotelManager' , 'type' => 'INNER' , 'conditions' => array('Hotel.id = HotelManager.hotel_id','HotelManager.user_id' => $this->Auth->user('id'))))));
        
        $this->set(compact('hotels'));
    }

    function edit($id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid hotels feature', true));
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->data)) {
            if ($this->HotelsFeature->save($this->data)) {
                $this->Session->setFlash(__('The hotels feature has been saved', true));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The hotels feature could not be saved. Please, try again.', true));
            }
        }
        if (empty($this->data)) {
            $this->data = $this->HotelsFeature->read(null, $id);
        }
        $hotels = $this->HotelsFeature->Hotel->find('list');
        $this->set(compact('hotels'));
    }

    function delete($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for hotels feature', true));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->HotelsFeature->delete($id)) {
            $this->Session->setFlash(__('Hotels feature deleted', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Hotels feature was not deleted', true));
        $this->redirect(array('action' => 'index'));
    }

}

?>