<?php

class HotelsRoomCapacitiesController extends ManagerAppController {

    var $name = 'HotelsRoomCapacities';

    function beforeFilter() {

        $this->Auth->allow('test');
    }

    function index() {
        $this->paginate = array('Hotel' => array('limit' => 10, 'joins' => array(
        array(
            'table' => 'hotels_managers',
            'alias' => 'HotelsManager',
            'type' => 'inner',
            'conditions'=> array('HotelsManager.hotel_id = Hotel.id', 'HotelsManager.user_id = '.$this->Auth->user('id'))
        )
        )));
        $this->HotelsRoomCapacity->recursive = 0;
        $this->set('hotelsRoomCapacities', $this->paginate());
    }

    function view($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid hotels room capacity', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->set('hotelsRoomCapacity', $this->HotelsRoomCapacity->read(null, $id));
    }

    function add() {
        if (!empty($this->data)) {
            $this->HotelsRoomCapacity->create();
            if ($this->HotelsRoomCapacity->save($this->data)) {
                $this->Session->setFlash(__('The hotels room capacity has been saved', true));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The hotels room capacity could not be saved. Please, try again.', true));
            }
        }
        $hotels = $this->HotelsRoomCapacity->Hotel->find('list',array('joins' => array(array('table' => 'hotels_managers' , 'alias' => 'HotelManager' , 'type' => 'INNER' , 'conditions' => array('Hotel.id = HotelManager.hotel_id','HotelManager.user_id' => $this->Auth->user('id'))))));

        $hotelRoomTypes = $this->HotelsRoomCapacity->HotelRoomType->find('list');

        $this->set(compact('hotels', 'hotelRoomTypes'));
    }

    function ajaxRoomTypeLoad($id=NULL) {
        $this->autoRender = false;

        if (isset($id)) {

            $hotelRoomTypes = $this->HotelsRoomCapacity->HotelRoomType->find('list', array('conditions' => array('hotel_id' => $id)));

            if (count($hotelRoomTypes) >= 1) {
                echo '<label for="HotelsRoomCapacityRoomTypeId">Room Type</label>';
                echo "<select id='HotelsRoomCapacityRoomTypeId' name='data[HotelsRoomCapacity][room_type_id]'>";
                foreach ($hotelRoomTypes as $roomTypesId => $roomTypesValue) {
                    echo "<option value=".$roomTypesId.">$roomTypesValue</option>";
                }
                echo "</select>";
            }
        }
    }

    function edit($id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid hotels room capacity', true));
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->data)) {
            if ($this->HotelsRoomCapacity->save($this->data)) {
                $this->Session->setFlash(__('The hotels room capacity has been saved', true));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The hotels room capacity could not be saved. Please, try again.', true));
            }
        }
        if (empty($this->data)) {
            $this->data = $this->HotelsRoomCapacity->read(null, $id);
        }
           $hotels = $this->HotelsRoomCapacity->Hotel->find('list',array('joins' => array(array('table' => 'hotels_managers' , 'alias' => 'HotelManager' , 'type' => 'INNER' , 'conditions' => array('Hotel.id = HotelManager.hotel_id','HotelManager.user_id' => $this->Auth->user('id'))))));

        $hotelRoomTypes = $this->HotelsRoomCapacity->HotelRoomType->find('list');
        $this->set(compact('hotels', 'hotelRoomTypes'));
    }

    function delete($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for hotels room capacity', true));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->HotelsRoomCapacity->delete($id)) {
            $this->Session->setFlash(__('Hotels room capacity deleted', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Hotels room capacity was not deleted', true));
        $this->redirect(array('action' => 'index'));
    }

}

?>