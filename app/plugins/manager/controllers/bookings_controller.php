<?php

class BookingsController extends ManagerAppController{
    var $name = 'Bookings';
    var $uses = array('Bookings','HotelsRoomType','HotelsRoomCapacities','Hotel','Coupon');
   
    
    function beforeFilter(){
     
        $this->Auth->allow('test');
       /* $this->Auth->userScope = array('User.status' => 1,'User.role_id' => 2);
        $this->Auth->loginAction = "/manager/booking/stepone";
        $this->Auth->loginRedirect = array( 'controller' => 'bookings', 'action' => 'stepone', 'home');*/
        //$this->Auth->loginRedirect = array( 'controller' => 'Booking', 'action' => 'index');
    }
    function index(){
       
       //$this->Auth->user('id');
       $ses=$this -> Session -> read();
       $userid=$ses['Auth']['User']['id'];
       $getHotels=$this->getHotels($userid);
     //  $this->set(compact('getHotels'));
       
    }

	function logout(){
	    $this->Session->setFlash('Logout');
	    $this->redirect($this->Auth->logout());
	}
	
	function stepone() {
		$params=$this->params;
		$hotelId=$this->Session->read('hotelId');
		$noOfRooms=$params['url']['data']['bookings']['nsr'];
		$fromDate=$params['url']['data']['bookings']['dateFrom'];
		$toDate=$params['url']['data']['bookings']['dateT0'];
		$rtId=$params['url']['data']['bookings']['roomtype'];
		$roomDes=$this->getRoomTypeDetails($hotelId,$rtId);
		$this->set('fromDate',$fromDate);
		$this->set('toDate',$toDate);
		$this->set('nsr',$noOfRooms);
		$this->set(compact('roomDes'));
	
	}
	function steptwo(){
		$params=$this->params;
		
		$hotelId=$this->Session->read('hotelId');
		$rtId=$params['data']['bookings']['room_type'];
		$dateFrom=$params['data']['bookings']['fromdate'];
		$dateTo=$params['data']['bookings']['todate'];
		$noOfSelectedRooms=$params['data']['bookings']['nofselectedrooms'];
		$additionalAdults=$params['data']['bookings']['max_adults'];
		$additionalChildren=$params['data']['bookings']['max_children'];
		
		$this->set('dateFrom',$dateFrom);
		$this->set('dateTo',$dateTo);
		$this->set('noOfSelectedRooms',$noOfSelectedRooms);
		$this->set('additionalAdults',$additionalAdults);		
		$this->set('additionalChildren',$additionalChildren);	
		$roomDes=$this->getRoomTypeDetails($hotelId,$rtId);
		$this->set(compact('roomDes'));
	}
	function stepthree(){
		/*debug($this->params);
		*/
		debug($this->Bookings->save($this->data));
		if($this->Bookings->save($this->data)){
			$this->Session->setFlash("Bookings Saved!");
		}die('hi');
	}
	function getRoomTypeDetails($hotelId=NULL,$rtId=NULL){
		$roomdets=$this->HotelsRoomCapacities->find('all',array(
			'fields'=>array('HotelsRoomCapacities.id',
							'HotelsRoomCapacities.hotel_id',
							'HotelsRoomCapacities.room_type_id',
							'HotelsRoomCapacities.max_adults',
							'HotelsRoomCapacities.max_children',
							'HotelsRoomCapacities.additional_adult_charge',
							'HotelsRoomCapacities.additional_child_charge',
							'HotelsRoomCapacities.total_rooms',
							'HotelsRoomType.`id`',
							'HotelsRoomType.`name`',
							'HotelsRoomType.`price`',
							'Coupon.reduce_percentage',
							'Hotel.`name`'),
			'joins'=>array(
				   array(
                        'table' => 'hotels',
                        'alias' => 'Hotel',
                        'type'  => 'INNER',
                        'foreignKey'    => false,
                        'conditions'    => array('Hotel.id = HotelsRoomCapacities.hotel_id'),
                        ),
                   array(
                        'table' => 'hotels_room_types',
                        'alias' => 'HotelsRoomType',
                        'type'  => 'INNER',
                        'foreignKey'    => false,
                        'conditions'    => array('HotelsRoomCapacities.hotel_id = HotelsRoomType.hotel_id','HotelsRoomCapacities.room_type_id = HotelsRoomType.id'),
                        ),
					array(
                        'table' => 'coupons',
                        'alias' => 'Coupon',
                        'type'  => 'LEFT',
                        'foreignKey'    => false,
                        'conditions'    => array('HotelsRoomType.`coupon` = Coupon.id',"Coupon.status='ACTIVATE'"),
                        ),
					),
					 'conditions' =>array("HotelsRoomCapacities.hotel_id='$hotelId'","HotelsRoomCapacities.room_type_id='$rtId';" ),
			)
		);
		return $roomdets;
	}
}
?>
