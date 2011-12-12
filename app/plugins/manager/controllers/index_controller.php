<?php

class IndexController extends ManagerAppController{
    
    var $uses = array('Hotel','HotelsRoomType','HotelsRoomCapacities','Booking','HotelsManager');
    var $helpers = array('Lightbox');
    
    function beforeFilter(){
        
        $this->Auth->allow('index','login','add');
        $this->Auth->userScope = array('User.status' => 1,'User.role_id' => 2);
        $this->Auth->loginAction = "/manager/index/login";
        //$this->Auth->loginRedirect = array( 'controller' => 'index', 'action' => 'dashboard', 'home');
        $this->Auth->loginRedirect = array( 'controller' => 'index', 'action' => 'index');
    }
    function index(){
        
       //$this->Auth->user('id');
       $ses=$this -> Session -> read();
       $userid=$ses['Auth']['User']['id'];
       $getHotels=$this->getHotels($userid);
       $this->set(compact('getHotels'));
       
    }
    function login()
	{
            $this->layout = "limejungle_manger_login";
          
           if($this->Auth->isAuthorized()){
                $this->redirect("/manager/index/dashboard");
           }
	}
 	function dashboard(){}
	function logout(){
	    $this->Session->setFlash('Logout');
	    $this->redirect($this->Auth->logout());
	}
	/*to get all room types-14-11-2011*/
	function getRoomTypes($userid=NULL){
		
	}
	
	function getHotels($userid=NULL){
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
		  	'conditions' =>array("User.id=$userid" ),
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
			$res.="<div class=\"roomcap\" align=\"center\"><input type=\"text\" value=\"0\" id=\"book".$value['HotelsRoomType']['id']."\" name=\"data[bookings][nsr]\"/></div>";
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
	function setroomavalability($rtId=NULL,$hotelId=NULL){
		$hotelId=$this->Session->read('hotelId');
		$rtId=$this->params['form']['rtid'];
		$dateFrom=$this->params['form']['dateFrom'];
		$dateTo=$this->params['form']['dateTo'];
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
		echo $roomDiv."<div class=\"clr\"></div><div class=\"bookdiv\"><input type=\"submit\" value=\"Book\" class=\"bookimg\" /></div>";
	}
	
	function roomstatus($hotelId=NULL,$roomtypeid=NULL,$dateFrom=NULL,$dateTo=NULL){
		$roomStatus=$this->Booking->find('all',
			array(
			'fields' => array(
     				'sum(Booking.number_of_rooms) AS S',
                    'Booking.status'),
			'conditions' =>array(" Booking.hotel_id = $hotelId AND Booking.room_type_id = $roomtypeid AND Booking.from_date >= '".$dateFrom."' AND Booking.end_date <= '".$dateTo."' GROUP BY Booking.`status` ORDER BY Booking.`status` DESC;" ),
			)
		);
		return $roomStatus;
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
				'fields'=>array('count(Hotel.id) as C'),
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
		if($htlAvl[0][0]['C'] == 2){
			$this->redirect('stathome');

		}
		else{
			$hotels=$this->getHotelNames($mangerId);
			$this->set(compact('hotels'));
		}
	}
	
	function stathome($mangerId=NULL){
		$userId=$this -> Session -> read();
		$mangerId=$userId['Auth']['User']['id'];
		$hotels=$this->getHotelNames($mangerId);
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
	        'conditions' => array('HotelsRoomType.hotel_id' => '43',"Booking.from_date >= '2011-12-11'" ,"Booking.end_date <= '2011-12-31'"),
			'group'=>array('HotelsRoomType.id,Booking.`status`'),
	        'limit' => 5
	    );
	    $HotelsRoomType = $this->paginate('HotelsRoomType');
	    $this->set(compact('HotelsRoomType'));
	    
	}
	
	function getHotelNames($mangerId=NULL){
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
		'conditions' =>array("HotelsManager.user_id='$mangerId'" ),
		));
		return $hotelname;
	}
}
?>
