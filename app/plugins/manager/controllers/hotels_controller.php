<?php

class HotelsController extends ManagerAppController {

    var $name = 'Hotels';

    function beforeFilter() {

        $this->Auth->allow('test');
    }

    function index() {

        $this->layout = 'manager';
        $this->Hotel->recursive = 0;

       



        $this->paginate = array('Hotel' => array('limit' => 10, 'joins' => array(
        array(
            'table' => 'hotels_managers',
            'alias' => 'HotelsManager',
            'type' => 'inner',
            'conditions'=> array('HotelsManager.hotel_id = Hotel.id', 'HotelsManager.user_id = '.$this->Auth->user('id'))
        )
        )));

      
        $this->set('hotels', $this->paginate('Hotel'));
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

            //debug($this->Hotel);
            if ($this->Hotel->save($this->data)) {
                
                $this->Session->setFlash(__('The hotel has been saved', true));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The hotel could not be saved. Please, try again.', true));
            }
        }
      //  $categories = $this->Hotel->Category->find('list',array('joins' => array(array('table' => 'hotels_category_lists' , 'alias' => 'CategoryList' , 'type' => 'LEFT' , 'conditions' => array('CategoryList.id = Category.category_id'))),'fields' =>array('CategoryList.name'),'group' => 'CategoryList.id'));
        
       $categories =  $this->Hotel->CategoryList->find('list');
       
        
   
       
        $this->set(compact('categories'));
      
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
 
        $features = $this->Hotel->Feature->find('list');
        $managers = $this->Hotel->Manager->find('list');
        $meta = $this->Hotel->Meta->find('list');
        $pictures = $this->Hotel->Picture->find('list');
        $roomCapacities = $this->Hotel->RoomCapacity->find('list');
        $roomTypes = $this->Hotel->RoomType->find('list');
        $this->set(compact('categories', 'categoryLists', 'features', 'managers', 'meta', 'pictures', 'roomCapacities', 'roomTypes'));
    }

    function delete($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for hotel', true));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->Hotel->delete($id)) {
            $this->Session->setFlash(__('Hotel deleted', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Hotel was not deleted', true));
        $this->redirect(array('action' => 'index'));
    }

}

?>