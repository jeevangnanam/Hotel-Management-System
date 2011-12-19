<?php

class BookingsController extends ManagerAppController{
    var $name = 'Bookings';
    var $uses = array('Booking','HotelsRoomType','HotelsRoomCapacities','Hotel','Coupon');
   
    
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
		$coupon=$params['data']['bookings']['coupon'];
		$cuopondet=$this->Hotel->find('all',array(
			'fields'=>array('Coupon.reduce_percentage','Coupon.id'),
			'joins'=>array(
				   array(
                        'table' => 'coupons',
                        'alias' => 'Coupon',
                        'type'  => 'INNER',
                        'foreignKey'    => false,
                        'conditions'    => array('Hotel.id = Coupon.hotel_id'),
                        ),
                        ),
			'conditions' =>array("Coupon.hotel_id='$hotelId' AND Coupon.start_date >='$dateFrom' AND Coupon.start_date <= '$dateFrom' AND Coupon.coupon='$coupon'" ),
			)
		);
		if(count($cuopondet) <> 0){
			$cid=$cuopondet[0]['Coupon']['id'];
			$cd=$cuopondet[0]['Coupon']['reduce_percentage'];
		}
		else{
			$cid=0;
			$cd=0;
		}
		$this->set('cd',$cd);	
		$this->set('cid',$cid);	
		
		$this->set('dateFrom',$dateFrom);
		$this->set('dateTo',$dateTo);
		$this->set('noOfSelectedRooms',$noOfSelectedRooms);
		$this->set('additionalAdults',$additionalAdults);		
		$this->set('additionalChildren',$additionalChildren);	
		$roomDes=$this->getRoomTypeDetails($hotelId,$rtId);
		$this->set(compact('roomDes'));
	}
	function stepthree(){
		
		if (!($this->Auth->isAuthorized())){
			$this->Auth->allow('login');
		}
		
		
		$nofr=$this->params['data']['Booking']['nofselectedrooms'];
		$noofdays=$this->params['data']['Booking']['nofselecteddays'];
		$dFrom=$this->params['data']['Booking']['dateFrom'];
		$dTo=$this->params['data']['Booking']['dateTo'];
		$cd=$this->params['data']['Booking']['coupondeduction']; 
		
		$rt=$this->params['data']['Booking']['room_type'];
		$hotel=$this->Session->read('hotelId');
		$det=$this->HotelsRoomType->find('all',array(
			'fields'=>array('HotelsRoomType.price','HotelsRoomCapacities.additional_adult_charge','HotelsRoomCapacities.additional_child_charge'
							),
			'joins'=>array(
        					array(
			                        'table' => 'hotels_room_capacities',
			                        'alias' => 'HotelsRoomCapacities',
			                        'type'  => 'INNER',
			                        'foreignKey'    => false,
			                        'conditions'    => array('HotelsRoomType.hotel_id = HotelsRoomCapacities.hotel_id AND HotelsRoomType.id=HotelsRoomCapacities.room_type_id'),
			                  ),
			                  ),
					 'conditions' =>array("HotelsRoomType.hotel_id='$hotel'","HotelsRoomType.id='$rt';" ),
			)
		);
		$aac=$det[0]['HotelsRoomCapacities']['additional_adult_charge']; 
		$acc=$det[0]['HotelsRoomCapacities']['additional_child_charge'];
		$p=$det[0]['HotelsRoomType']['price'];
		
		$estimated_price=((($nofr * $det[0]['HotelsRoomType']['price'])+$aac+$acc)*$noofdays)*((100-$cd)/100);
		$this->data['Booking']['user_id'] = $this->Auth->user('id');
		$this->data['Booking']['hotel_id'] = $this->Session->read('hotelId');
		$rtype=$this->params['data']['Booking']['room_type'];
        $this->data['Booking']['room_type_id'] = $rtype;
        $this->data['Booking']['from_date'] = $dFrom; 
        $this->data['Booking']['end_date'] = $dTo;
        $this->data['Booking']['number_of_rooms'] = $this->params['data']['Booking']['nofselectedrooms'];
        $this->data['Booking']['estimated_price'] = $estimated_price;
        $this->data['Booking']['coupon_id'] = $this->params['data']['Booking']['couponid']; 
        $this->data['Booking']['notes'] = 'n';
        $this->data['Booking']['status'] = "APPROVED";


        $ticket=$this->Session->read('ticket');
        $ticketavl='';
       // echo $hotel.$ticket;
        if(!empty($ticket)){
        	$ticketavl=$this->Booking->find('all',array(
        	'fields'=>array('count(*) as c'),
        	'conditions'=>array("Booking.id=$ticket"),
        	));
        	
        	if($ticketavl[0][0]['c'] > 0){
        	 	$dets=$this->getticketdet($hotel,$rtype);	
        	 	$this->set('rID',$ticket);	   
	        	$this->set(compact('dets','dFrom','dTo','noofdays','estimated_price','rtype'));
	        	$this->Session->setFlash(__( 'Your already have a ticket.', true)); 
        	}
        }
        else{
        	if($this->Booking->save($this->data)){
	        	$bID=$this->Booking->getInsertID();
	        	$this->Session->write('ticket',$bID);
	        	$dets=$this->getticketdet($hotel,$rtype);		   
	        	$this->set(compact('dets','dFrom','dTo','noofdays','estimated_price','rtype'));
	        }
	        else{
	        	
	        }
        }        
        
	}
	
	function stepfour(){
		
	}
	function getticketdet($hotel=NULL,$rtype=NULL){
		$dets=$this->Hotel->find('all', array(
        			   		'fields'=>array('DISTINCT Hotel.`name`','HotelsRoomType.`name`','User.first_name','User.last_name'),
        					'joins'=>array(
        					array(
			                        'table' => 'bookings',
			                        'alias' => 'Booking',
			                        'type'  => 'INNER',
			                        'foreignKey'    => false,
			                        'conditions'    => array('Hotel.id = Booking.hotel_id'),
			                  ),
			                  array(
			                        'table' => 'hotels_room_types',
			                        'alias' => 'HotelsRoomType',
			                        'type'  => 'INNER',
			                        'foreignKey'    => false,
			                        'conditions'    => array('HotelsRoomType.hotel_id = Booking.hotel_id AND HotelsRoomType.id=Booking.room_type_id'),
			                        ),
        					array(
			                        'table' => 'users',
			                        'alias' => 'User',
			                        'type'  => 'INNER',
			                        'foreignKey'    => false,
			                        'conditions'    => array('User.id = Booking.user_id'),
			                        ),
        					),
        					'conditions'=>array("Booking.hotel_id=$hotel AND HotelsRoomType.id=$rtype"),
        			   )
        		);
        		
        		return $dets;
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
	
	//edit option
	function edit(){
		
		if($this->data['Booking']['ticket']==$this->Session->read('ticket')){
			debug($this->data['Booking']['ticket']);
		}	
		$ticket= $this->Session->read('ticket');
		$user  = $this->Auth->user('id');
		$hotel = $this->Session->read('hotelId');
	
	}
}
?>
