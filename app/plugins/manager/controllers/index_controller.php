<?php

class IndexController extends ManagerAppController{
    
    var $uses = array('Hotel','HotelsRoomType','HotelsRoomCapacities','Booking','HotelsManager','Rooms');
    var $helpers = array('Lightbox');
    
    function beforeFilter(){
        
        $this->Auth->allow('index','login','add');
        $this->Auth->userScope = array('User.status' => 1,'User.role_id' => 2);
        $this->Auth->loginAction = "/manager/index/login";
        //$this->Auth->loginRedirect = array( 'controller' => 'index', 'action' => 'dashboard', 'home');
        $this->Auth->loginRedirect = array( 'controller' => 'index', 'action' => 'index');
    }
    function index(){
        $hotelId='';
       //$this->Auth->user('id');
       $ses=$this -> Session -> read();
       $userid=$ses['Auth']['User']['id'];
       $getHotels=$this->getHotels($userid,$hotelId);
       $this->set(compact('getHotels'));
       
    }
    
    function bookingindex($hotel=NULL){
       $hotelId=$this->params['pass'][0];
       $this->Session->write('hotelId',$hotelId);
       $ses=$this -> Session -> read();
       $userid=$ses['Auth']['User']['id'];
       
      
	       if(empty($hotel))     
	        	$hotelId=$this->Session->read('hotelId');
	       

      
       $getHotels=$this->getHotels($userid,$hotelId);
       $this->set('hotelid',$hotelId);
       $this->set(compact('getHotels'));
       $roomtypes=$this->getroomtypes($hotelId);
       /*$rtyp='';
       $x=$y='';$noofrooms=0;*/
       foreach ($roomtypes as $key=>$value){
       	$rtyp[$value['HotelsRoomType']['id']]=$value['HotelsRoomType']['name'];
       }
       $rt=$dfrom=$dto=$roomavl='';
    	if(isset($this->data['Hotel']['tag']) && $this->data['Hotel']['tag']==1){  		
		    		$rt=$this->data['Hotel']['roomtype'];
		    		$dfrom=$this->data['Hotel']['dateFrom'];
		    		$dto=$this->data['Hotel']['dateTo'];
		    		
			    		$rooms=$this->HotelsRoomCapacities->find('all',array(			
						 	'fields' => array(
			     				'HotelsRoomCapacities.id',
			                    'HotelsRoomCapacities.room_type_id',
								'HotelsRoomCapacities.total_rooms'),
					  		'conditions' =>array("HotelsRoomCapacities.room_type_id=$rt AND HotelsRoomCapacities.hotel_id=$hotelId" ),
					  		)
						);
				$rTypestatusApp=$this->roomstatus($hotelId,$rt,$dfrom,$dto,'APPROVED');
				$rTypestatusAproved=$this->room_status_wise_roomnumbers($hotelId,$rt,$dfrom,$dto,'APPROVED');
				
				$rTypestatusPro=$this->roomstatus($hotelId,$rt,$dfrom,$dto,'PROCESSING');
				$rTypestatusProcessed=$this->room_status_wise_roomnumbers($hotelId,$rt,$dfrom,$dto,'PROCESSING');
				
				$appRoomNumbs=$proRoomNumbs='';
				$appRoomNumbsSet=$proRoomNumbsSet=array();
				
				foreach ($rTypestatusAproved as $key=>$value){
					
					$appRoomNumbs.=$value['Booking']['rooms'].',';
					
				}
					$appRoomNumbsSet= explode(',',$appRoomNumbs);
					$this->set(compact('rTypestatusApp'));
					$this->set(compact('appRoomNumbsSet'));
				
					foreach ($rTypestatusProcessed as $key=>$value){
						
						$proRoomNumbs.=$value['Booking']['rooms'].',';
						
					}
				$proRoomNumbsSet= explode(',',$proRoomNumbs);
				$this->set(compact('rTypestatusPro'));
				$this->set(compact('proRoomNumbsSet'));
				
				$noofroomsset=0;
				if(count($rooms) > 0){
					$noofroomsset=$rooms[0]['HotelsRoomCapacities']['total_rooms'];
				}
				
					$this->set(compact('noofroomsset'));
					$data_in_booking_tblApp=$this->getbookingdetails($hotelId,$rt,$dfrom,$dto,'APPROVED');
					$data_in_booking_tblPro=$this->getbookingdetails($hotelId,$rt,$dfrom,$dto,'PROCESSING');
			        $hotel_room_numbs=$this->getroomnumbers($hotelId,$rt);
			        $this->set(compact('data_in_booking_tblApp'));
			        $this->set(compact('data_in_booking_tblPro'));
			        $this->set(compact('hotel_room_numbs'));
    	}
    	else{
    		$this->set('rTypestatusPro',0);
    		$this->set('rTypestatusApp',0);
    		$this->set('noofroomsset',0);
    		$this->set('data_in_booking_tbl',0);
	        $this->set('hotel_room_numbs',0);
    	}
        
       $this->set(compact('rtyp'));
       $this->set('rt',$rt);
       $this->set('dfrom',$dfrom);
       $this->set(compact('roomavl'));
       $this->set('dto',$dto);
       $this->Session->write('ticket','');
       
       
    }
    
    function getroomtypes($hotelId=NULL){
    	$roomtypes = $this->HotelsRoomType->find('all',array(			
    
			 'fields' => array(
     				'HotelsRoomType.id',
                    'HotelsRoomType.`name`'),
		  	'conditions' =>array("HotelsRoomType.hotel_id=$hotelId" ),
		  )
		);
		return $roomtypes;
	}
	
	function getbookingdetails($hotelId=NULL,$rt=NULL,$dfrom=NULL,$dto=NULL,$status=NULL){
		$tbl=$this->Booking->find('all',array(
			'fields'    => array('`Booking`.`status`','`Booking`.`rooms`'),
		    'conditions' => array("`Booking`.`hotel_id`='$hotelId'","Booking.room_type_id='$rt'","Booking.from_date >= '$dfrom'","Booking.end_date <= '$dto'","Booking.status = '$status'"),
		));
		
		return $tbl;
	}
	
	function getroomnumbers($hotelId=NULL,$rt=NULL){
		$roomnums=array();
		$i=0;
		$rnmbs=$this->Rooms->find('all',array(
			'fields'=>array('Rooms.roomname','Rooms.id'),
		    'conditions' =>array("Rooms.hotel_id='$hotelId'","Rooms.room_type_id='$rt';" ),
		));	
			
		foreach ($rnmbs as $key=>$value){
			$roomnums[$i]=$value['Rooms']['roomname'];
			$i++;
		}
		
		return $roomnums;
	}
	
    function login()
	{
            $this->layout = "limejungle_manger_login";
          
           if($this->Auth->isAuthorized()){
                $this->redirect("/manager/index/");
           }
	}
 	function dashboard(){}
	function logout(){
	    $this->Session->setFlash('Logout');
	    $this->redirect($this->Auth->logout());
	}

	
	function getHotels($userid=NULL,$hotelId=NULL){
		$ht='';
		if(!empty($hotelId)){
			$ht=" AND Hotel.id=$hotelId";
		}
		
		$hotels=$this->Hotel->find('all',array(			
			 'fields' => array(
     				'Hotel.id',
                    'Hotel.`name`'),
		'joins' => array(
                   array(
                        'table' => 'hotels_managers',
                        'alias' => 'HotelsManager',
                        'type'  => 'INNER',
                        'foreignKey'    => false,
                        'conditions'    => array('Hotel.id = HotelsManager.hotel_id'),
                        ),
				  array(
                        'table' => 'users',
                        'alias' => 'User',
                        'type'  => 'INNER',
                        'foreignKey'    => false,
                        'conditions'    => array('HotelsManager.user_id=User.id')
                    	
                    ),
		 	
		  	),
		  	'conditions' =>array("User.id=$userid $ht"),
		  )
		);
		return $hotels;
		
	}

	function roomtypes(){
		$ph_id=$this->params['pass'][0];
		/*$fh_id=$this->data['Hotel']['hotelid'];
		if($ph_id==$fh_id){
			
		}*/
		$this->paginate = array(
        				'fields'=>array('Hotel.`name`',
        								'HotelsRoomType.`name`',
									    'HotelsRoomType.price','HotelsRoomType.size',
									    'HotelsRoomType.info',
									    'HotelsRoomType.`view`',
									    'HotelsRoomType.cooling'),
        				'joins'=>array(
        						
                       	 		array(
		                       		'table' => 'hotels',
		                        	'alias' => 'Hotel',
		                        	'type'  => 'INNER',
		                        	'foreignKey'    => false,
                        			'conditions'    => array('Hotel.id = HotelsRoomType.hotel_id'),
                       	 		),
        								
        							   ),
        				'conditions'=>array("Hotel.id=$ph_id "),
        				
        				'order'    => array('HotelsRoomType.id'    => 'asc'),
        				'limit' =>2
        							   
        			);
        		$loadHotelsRoomType=$this->paginate('HotelsRoomType');
      			$this->set(compact('loadHotelsRoomType'));
	}
	function popuproomdetails($hotelId=NULL,$roomtype=NULL){
		$hotelId=$this->Session->read('hotelId'); 
		$roomtype=$this->params['pass'][0];
		$roomTypeDetails=$this->getroomtypedetails($hotelId,$roomtype);

		
		$json = '{
		"uroomdetails": [ 
		{ 
			"roomtype":"'.$roomTypeDetails[0]['HotelsRoomType']['name'].'",
			"price":"'.$roomTypeDetails[0]['HotelsRoomType']['price'].'",
			"size":"'.$roomTypeDetails[0]['HotelsRoomType']['size'].'",
			"info":"'.$roomTypeDetails[0]['HotelsRoomType']['info'].'",
			"view":"'.$roomTypeDetails[0]['HotelsRoomType']['view'].'",
			"cooling":"'.$roomTypeDetails[0]['HotelsRoomType']['cooling'].'",
			"offers":"'.$roomTypeDetails[0]['HotelsRoomType']['coupon'].'" 
		}
		]
	}';
	echo $json;
	}
	
	function roomstatus($hotelId=NULL,$roomtypeid=NULL,$dateFrom=NULL,$dateTo=NULL,$status=NULL){
		$roomStatus=$this->Booking->find('all',
			array(
			'fields' => array(
     				'sum(Booking.number_of_rooms) AS S',
                    'Booking.status'),
			'conditions' =>array(" Booking.hotel_id = $hotelId AND Booking.room_type_id = $roomtypeid AND Booking.from_date >= '".$dateFrom."' AND Booking.end_date <= '".$dateTo."' AND Booking.`status`='".$status."' GROUP BY Booking.`status` ORDER BY Booking.`status` DESC;" ),
			)
		);
		return $roomStatus;
	}
    function room_status_wise_roomnumbers($hotelId=NULL,$roomtypeid=NULL,$dateFrom=NULL,$dateTo=NULL,$status=NULL){
		$roomNumbs=$this->Booking->find('all',
			array(
			'fields' => array(
     				'Booking.rooms',
                    'Booking.status'),
			'conditions' =>array(" Booking.hotel_id = $hotelId AND Booking.room_type_id = $roomtypeid AND Booking.from_date >= '".$dateFrom."' AND Booking.end_date <= '".$dateTo."' AND Booking.`status`='".$status."' ORDER BY Booking.`status` DESC;" ),
			)
		);
		return $roomNumbs;
	}
	function booking($hotelId=NULL,$rtId=NULL){
		$hotelId= $this->Session->read('hotelId');
		
		$rtId=$this->params['pass']['0'];
		$roomdets=$this->HotelsRoomCapacities->find('all',array(
			'fields'=>array('HotelsRoomCapacities.id',
							'HotelsRoomCapacities.hotel_id',
							'HotelsRoomCapacities.room_type_id',
							'HotelsRoomCapacities.max_adults',
							'HotelsRoomCapacities.max_children',
							'HotelsRoomCapacities.additional_adult_charge',
							'HotelsRoomCapacities.additional_child_charge',
							'HotelsRoomCapacities.total_rooms',
							'HotelsRoomType.`name`',
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
					),
					 'conditions' =>array("HotelsRoomCapacities.hotel_id='$hotelId'","HotelsRoomCapacities.room_type_id='$rtId';" ),
			)
		);

		$this->set(compact('roomdets'));
		$this->layout='default';
		$this->render('booking');
		
	}
	
	function getroomtypedetails($hotelId=NULL,$roomtype=NULL){
		$rTypeDes=$this->HotelsRoomType->find('all',array(
			'fields'=>array(
					'HotelsRoomType.`name`',
					'HotelsRoomType.`price`',
					'HotelsRoomType.`size`',
					'HotelsRoomType.`info`',
					'HotelsRoomType.`view`',
					'HotelsRoomType.`cooling`',
					'HotelsRoomType.`coupon`',
					),
			'joins'=>array(
				   array(
                        'table' => 'hotels',
                        'alias' => 'Hotel',
                        'type'  => 'INNER',
                        'foreignKey'    => false,
                        'conditions'    => array('Hotel.id = HotelsRoomType.hotel_id'),
                        ),
                       ),
             					 'conditions' =>array("HotelsRoomType.hotel_id='$hotelId'","HotelsRoomType.id='$roomtype';" ),
			)
		);
		return $rTypeDes;
	}
	
	//Manager STATS	
	function stat($mangerId=NULL,$htlAvl=NULL){
		$userId=$this -> Session -> read();
		$mangerId=$userId['Auth']['User']['id'];
		$htlAvl=$this->Hotel->find('all',array(
				'fields'=>array('count(Hotel.id) as C','Hotel.id'),
				'joins'=>array(
						array(
						'table' => 'hotels_managers',
                        'alias' => 'HotelsManager',
                        'type'  => 'INNER',
                        'foreignKey'    => false,
                        'conditions'    => array('Hotel.id = HotelsManager.hotel_id'),
						),
						),
				'conditions' =>array("HotelsManager.user_id='$mangerId'" ),
				));
		if($htlAvl[0][0]['C'] == 1){
			$this->redirect('stathome/'.$htlAvl[0]['Hotel']['id']);

		}
		else{
		$this->paginate = array(
		'fields'=>array('Hotel.id','Hotel.name'),
		'joins'=>array(
						array(
						'table' => 'hotels_managers',
                        'alias' => 'HotelsManager',
                        'type'  => 'INNER',
                        'foreignKey'    => false,
                        'conditions'    => array('Hotel.id = HotelsManager.hotel_id'),
						),
						),
		'conditions' =>array("HotelsManager.user_id='$mangerId'" ),
		'limit' => 5
		
	        
	    );
	    	$hotels = $this->paginate('Hotel');
			$this->set(compact('hotels'));
		}
	}
	
	function stathome($mangerId=NULL,$hotelId=NULL,$dfrom=NULL,$dto=NULL){
		if(isset($this->data['Hotel'])){
			$dfrom=$this->data['Hotel']['fromdate'];
			$dto=$this->data['Hotel']['dateto'];
			$dfromd=$dfrom;
			$dtod=$dto;
		}
		
		if(empty($dfrom)){
			$dfrom=$dto='now()';
			$dfromd=$dtod=date('Y-m-d');
		}
		
		//die();
		if(empty($hotelId)){
			$hotelId=$this->params['pass'][0];
		}
		$userId=$this -> Session -> read();
		$mangerId=$userId['Auth']['User']['id'];
		$hotels=$this->getHotelNames($mangerId,$hotelId);
		$this->set(compact('hotels'));
		
		
	    $this->paginate = array(
	    	'fields'=>array('HotelsRoomType.id',
	    	'HotelsRoomType.name',
	    	'Booking.`status`',
	    	'Sum(Booking.number_of_rooms) as noOfRooms',
	    	'sum(Booking.estimated_price) as estimated_price',
	    	'Booking.room_type_id',
			'Booking.estimated_price'),
	    	'joins'=>array(
						array(
						'table' => 'bookings',
                        'alias' => 'Booking',
                        'type'  => 'INNER',
                        'foreignKey'    => false,
                        'conditions'    => array('Booking.hotel_id = HotelsRoomType.hotel_id AND HotelsRoomType.id = Booking.room_type_id'),
						),
						),
	        'conditions' => array("HotelsRoomType.hotel_id" => "$hotelId","Booking.from_date >= '$dfrom'" ,"Booking.end_date <= '$dto'"),
			'group'=>array('HotelsRoomType.id,Booking.`status`'),
	        'limit' => 4
	    );
	    $HotelsRoomType = $this->paginate('HotelsRoomType');
	    $totRooms=$this->getTotRoom($hotelId);
	    $booked=$this->getRoomStat($hotelId,'APPROVED',$dfrom,$dto); 
	    $process=$this->getRoomStat($hotelId,'PROCESSING',$dfrom,$dto);
	    $bookedPrc=$processPrc=$income=0;
	    if(isset($totRooms)){
	    	$totRooms=$totRooms[0][0]['R'];
	    }
	    else{
	    	$totRooms=0;
	    }
	    if(isset($booked[0][0]['R'])){
	    	$booked=$booked[0][0]['R'];
	    	$bookedPrc=$this->getRoomTotPrice($hotelId,'APPROVED',$dfrom,$dto);
	    	$bookedPrc=$bookedPrc[0][0]['R'];
	    }
		else{
	    	$booked=0;
	    }
	    if(isset($process[0][0]['R'])){
	    	$process=$process[0][0]['R'];
	    	$processPrc=$this->getRoomTotPrice($hotelId,'PROCESSING',$dfrom,$dto);
	    	$processPrc=$processPrc[0][0]['R'];
	    }
		else{
	    	$process=0;
	    }
	    $pending= ($totRooms -($booked+$process));
	    $this->set('booked',$booked);
	    $this->set('process',$process);
	    $this->set('pending',$pending);
	    $this->set('bookedPrc',$bookedPrc);
	    $this->set('processPrc',$processPrc);
	    $this->set('income',($bookedPrc+$processPrc));
	    $this->set(compact('HotelsRoomType'));
	    $this->set('dfrom',$dfromd);
	    $this->set('dto',$dtod);
	    
	}
	
	function searchstat(){
		debug($this->data);
		//die();
	}
	function getHotelNames($mangerId=NULL,$hotelId=NULL){
		$hotelname=$this->Hotel->find('all',array(
		'fields'=>array('Hotel.id','Hotel.name'),
		'joins'=>array(
						array(
						'table' => 'hotels_managers',
                        'alias' => 'HotelsManager',
                        'type'  => 'INNER',
                        'foreignKey'    => false,
                        'conditions'    => array('Hotel.id = HotelsManager.hotel_id'),
						),
						),
		'conditions' =>array("HotelsManager.user_id='$mangerId'","Hotel.id='$hotelId'" ),
		));
		return $hotelname;
	}
	
	function getRoomStat($hotelId=NULL,$type=NULL,$dfrom=NULL,$dto=NULL){
		$RoomStat=$this->Hotel->find('all',array(
		'fields'=>array('Sum(Booking.number_of_rooms) AS R'),
		'joins'=>array(
						array(
						'table' => 'bookings',
                        'alias' => 'Booking',
                        'type'  => 'INNER',
                        'foreignKey'    => false,
                        'conditions'    => array('Hotel.id = Booking.hotel_id'),
						),
						),
		'conditions' =>array("Booking.hotel_id='$hotelId'","Booking.`status` = '$type'","Booking.from_date >= '$dfrom'" , "Booking.end_date <= '$dto'"),
		'group'=>array("Booking.`status`"),		
					
		));
		return $RoomStat;
		
	}
	
	function getRoomTotPrice($hotelId=NULL,$type=NULL,$dfrom=NULL,$dto=NULL){
		$RoomStat=$this->Hotel->find('all',array(
		'fields'=>array('Sum(Booking.estimated_price) AS R'),
		'joins'=>array(
						array(
						'table' => 'bookings',
                        'alias' => 'Booking',
                        'type'  => 'INNER',
                        'foreignKey'    => false,
                        'conditions'    => array('Hotel.id = Booking.hotel_id'),
						),
						),
		'conditions' =>array("Booking.hotel_id='$hotelId'","Booking.`status` = '$type'","Booking.from_date >= '$dfrom'" , "Booking.end_date <= '$dto'"),
		'group'=>array("Booking.`status`"),		
					
		));
		return $RoomStat;
		
	}
	
	function getTotRoom($hotelId=NULL)
	{
		$RoomTotRooms=$this->Hotel->find('all',array(
		'fields'=>array('Sum(HotelsRoomCapacities.total_rooms) AS R'),
		'joins'=>array(
						array(
						'table' => 'hotels_room_capacities',
                        'alias' => 'HotelsRoomCapacities',
                        'type'  => 'INNER',
                        'foreignKey'    => false,
                        'conditions'    => array('Hotel.id = HotelsRoomCapacities.hotel_id'),
						),
						),
		'conditions' =>array("HotelsRoomCapacities.hotel_id='$hotelId'"),
		'group'=>array("HotelsRoomCapacities.hotel_id"),		
					
		));
		return $RoomTotRooms;

	}
	
	function editrooms($hotelId=NULL){
		
		$hotelId=$this->params['pass'][0];
		$userId=$this -> Session -> read();
		$mangerId=$userId['Auth']['User']['id'];
		$hotels=$this->getHotelNames($mangerId,$hotelId);
		$roomtp=$this->getroomtypes($hotelId);
		$roomtype=array();
		$roomNumbers=array();
		foreach ($roomtp as $key=>$value) {
			$a=$value['HotelsRoomType']['id'];
			$roomtype[$a]=$value['HotelsRoomType']['name'];
		}
		//debug($roomtype);
		
		$roomNumbers='';
		if(isset($this->data['Hotel']['roomtype'])){
		$rt=$this->data['Hotel']['roomtype'];
			if(!empty($rt)){
				$roomNumbers=$this->getroomnumbers_with_id($hotelId,$rt);
			}
		}
		if(isset($this->data['Hotel']['roomtphidden'])){
			$rt=$this->data['Hotel']['roomtphidden'];
			$roomNumbers=$this->getroomnumbers_with_id($hotelId,$rt);
			App::import('Model', 'Manager.Rooms');
            $Rooms = new Rooms();
			foreach ($roomNumbers as $key=>$value){
				$i=$value['Rooms']['id'];
				$this->data['Rooms']['id']=$i;
				$this->data['Rooms']['hotel_id']=$hotelId;
				$this->data['Rooms']['room_type_id']=$rt;
				$roomname=$this->data['Rooms']['roomname']=$this->data['Hotel']['roomtypehidden'.$value['Rooms']['id']];
				$this->data['Rooms']['status']='ACTIVE';
				if($this->Rooms->save($this->data)){
					
				}
			}
			$this->Session->setFlash("Room Numbers Updated!");
			$roomNumbers=$this->getroomnumbers_with_id($hotelId,$rt);
		}
		$this->set(compact('hotels'));
		$this->set(compact('roomtype'));
		$rtselected=$rt;
		$this->set('rtselected',$rtselected);
		$this->set(compact('roomNumbers'));
	}
	
	function getroomnumbers_with_id($hotelId=NULL,$rt=NULL){
		$roomnums=array();
		
		$rnmbs=$this->Rooms->find('all',array(
			'fields'=>array('Rooms.roomname','Rooms.id'),
		    'conditions' =>array("Rooms.hotel_id='$hotelId'","Rooms.room_type_id='$rt';" ),
		));	
		
		return $rnmbs;
	}
	
}
?>
