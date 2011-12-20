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
       $rtyp='';
       $x=$y='';$noofrooms=0;
       foreach ($roomtypes as $key=>$value){
       	$rtyp[$value['HotelsRoomType']['id']]=$value['HotelsRoomType']['name'];
       }
       $rt=$dfrom=$dto=$roomavl='';
    	if(isset($this->data['Hotel']['tag']) && $this->data['Hotel']['tag']==1){  		
		    		$rt=$this->data['Hotel']['roomtype'];
		    		$dfrom=$this->data['Hotel']['dateFrom'];
		    		$dto=$this->data['Hotel']['dateTo'];
		    		//$roomavl=$this->setroomavalability($rt,$hotelId,$dfrom,$dto);	
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
			'fields'=>array('Rooms.roomname'),
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
	
	function setroomtypes($hotelId=NULL){
		
		$hotelId=$this->params['pass'][0];
		$this->Session->write('hotelId',$hotelId);
		$roomtypes=$this->HotelsRoomType->find('all',array(			
			 'fields' => array(
     				'HotelsRoomType.id',
                    'HotelsRoomType.`name`'),
		  	'conditions' =>array("HotelsRoomType.hotel_id=$hotelId" ),
		  )
		);
		
		//debug($roomtypes);
		
		
		$res='';
		foreach($roomtypes as $key=>$value){
			$res.="<form action=\"/manager/bookings/stepone/\" name=\"frm\" method=\"get\"><div class=\"roomtypediv\">";
			$res.="<div class=\"roomtype\">".$value['HotelsRoomType']['name']."</div>";
			$res.="<div class=\"roomtypesearch\" onclick='showRoomSearch(this)'  id=\"". $value['HotelsRoomType']['id']."\"></div>";
			$res.="<div class=\"roomdests\" onclick=\"loadPopUp('".$value['HotelsRoomType']['id']."');\"></div>";
			$res.="<div class=\"roomcap\" align=\"center\"><input type=\"text\" value=\"0\" id=\"book".$value['HotelsRoomType']['id']."\" name=\"data[bookings][nsr]\" readonly=\"readonly\"/></div>";
			$res.="<input type=\"hidden\" value=\"".$value['HotelsRoomType']['id']."\" id=\"rtype".$value['HotelsRoomType']['id']."\" name=\"data[bookings][roomtype]\"/></div>";		
			$res.="<div class=\"clr\"></div>";	
			$res.="<div class=\"roomtypesearch".$value['HotelsRoomType']['id']."\"  id=\"roomtypesearch". $value['HotelsRoomType']['id']."\"></div>";
			$res.="<div class=\"clr\"></div>";	
			$res.="<div class=\"roomtypedes".$value['HotelsRoomType']['id']."\"></div></form>";
				
		}
		echo $res;
		
	}
	
	function popuproomdetails($hotelId=NULL,$roomtype=NULL){
		$hotelId=$this->Session->read('hotelId'); 
		$roomtype=$this->params['pass'][0];
		$roomTypeDetails=$this->getroomtypedetails($hotelId,$roomtype);
	//	debug($roomTypeDetails[0]['HotelsRoomType']['name']);
		
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
	function setroomavalability($rtId=NULL,$hotelId=NULL,$dateFrom=NULL,$dateTo=NULL){
		//$hotelId=$this->Session->read('hotelId');
		//$rtId=$this->params['form']['rtid'];
		//$dateFrom=$this->params['form']['dateFrom'];
		//$dateTo=$this->params['form']['dateTo'];
		$rooms=$this->HotelsRoomCapacities->find('all',array(			
			 'fields' => array(
     				'HotelsRoomCapacities.id',
                    'HotelsRoomCapacities.room_type_id',
					'HotelsRoomCapacities.total_rooms'),
		  	'conditions' =>array("HotelsRoomCapacities.room_type_id=$rtId AND HotelsRoomCapacities.hotel_id=$hotelId" ),
		  )
		);
		$noofrooms=0;
		if(count($rooms) > 0){
			$noofrooms=$rooms[0]['HotelsRoomCapacities']['total_rooms'];
		}
		
		$pages=1;
		if($noofrooms > 100){
			$pages=$noofrooms/100;
		}
		$x='';
		$y=$noofrooms/10;
		$rest=$noofrooms%10;
		
		$start="<div class=\"xdiv\">";
		$end="</div>";
		$rType=$this->roomstatus($hotelId,$rtId,$dateFrom,$dateTo);
		$aCount=$pCount=0;
		if(count($rType) > 0){
			$aCount=$rType[0][0]['S'];
			//$pCount=$rType[1][0]['S'];
		}
		
		$empty='&nbsp';
		$approved='&nbsp';
		$proccessing='&nbsp';
		$a=$p=1;
		$roomDiv='';
		if($y==1){
			for($i=1; $i<11; $i++ ){
				if($aCount >= $a){
					$x.="<div class=\"adiv\" onclick=\"selectDiv(this,'".$rtId."');\" id=\"\">$approved</div>";
					$a++;
				}
				else if ($pCount >= $p){
					$x.="<div class=\"pdiv\" onclick=\"selectDiv(this,'".$rtId."');\">$proccessing</div>";
					$p++;
				}
				else{
					$x.="<div class=\"ediv\" onclick=\"selectDiv(this,'".$rtId."');\">$empty</div>";
				}
				
			}
			$roomDiv= $start.$x.$end;
		}
		else if($noofrooms < 10 && $noofrooms <> 0){
			for($i=1; $i<10; $i++ ){
				if($aCount >= $a ){
						$x.="<div class=\"adiv\" onclick=\"selectDiv(this,'".$rtId."');\">$approved</div>";
						$a++;
					}
				else if ($pCount >= $p){
						$x.="<div class=\"pdiv\" onclick=\"selectDiv(this,'".$rtId."');\">$proccessing</div>";
						$p++;
					}
				else{
						$x.="<div class=\"ediv\" onclick=\"selectDiv(this,'".$rtId."');\">$empty</div>";
					}
				
			}
				$roomDiv= $start.$x.$end;
		}
		else{
			for($i=1; $i<$noofrooms+1; $i++ ){
				if($i%10 == 1){
					$x.=$start;
				}
					if($aCount >= $a){
						$x.="<div class=\"adiv\" onclick=\"selectDiv(this,'".$rtId."');\">$approved</div>";
						$a++;
					}
					else if ($pCount >= $p){
						$x.="<div class=\"pdiv\" onclick=\"selectDiv(this,'".$rtId."');\">$proccessing</div>";
						$p++;
					}
					else{
						$x.="<div class=\"ediv\" onclick=\"selectDiv(this,'".$rtId."');\">$empty</div>";
					}
				if($i%10 == 0){
					$x.=$end;
				}
				
			}
			$roomDiv= $x;
		}
		return $roomDiv."<div class=\"clr\"></div><div class=\"bookdiv\"><input type=\"submit\" value=\"Book\" class=\"bookimg\" /></div>";
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
		}
		
		if(empty($dfrom)){
			$dfrom=$dto='now()';
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
	        'limit' => 5
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
}
?>
