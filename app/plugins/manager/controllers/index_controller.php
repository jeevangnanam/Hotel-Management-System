<?php

class IndexController extends ManagerAppController{
    
    var $uses = array('Hotel','HotelsRoomType','HotelsRoomCapacities','Booking');
   
    
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
			$res.="<div  onclick=' getRoomtypes(this)' class=\"roomtype\" id=\"". $value['HotelsRoomType']['id']."\">".$value['HotelsRoomType']['name']."</div>";
			$res.="<div class=\"roomtypedes".$value['HotelsRoomType']['id']."\"></div>";
		}
		echo $res;
	}
	
	function setroomavalability($rtlId=NULL){
		$rtId=$this->params['form']['rtid'];
		$rooms=$this->HotelsRoomCapacities->find('all',array(			
			 'fields' => array(
     				'HotelsRoomCapacities.id',
                    'HotelsRoomCapacities.room_type_id',
					'HotelsRoomCapacities.total_rooms'),
		  	'conditions' =>array("HotelsRoomCapacities.room_type_id=$rtId" ),
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
		$rType=$this->roomstatus(2,$rtId);
		$aCount=$pCount=0;
		if(count($rType) > 0){
			$aCount=$rType[0][0]['S'];
			$pCount=$rType[1][0]['S'];
		}
		
		$empty='E';
		$approved='B';
		$proccessing='BP';
		$a=$p=1;
		if($y==1){
			for($i=1; $i<11; $i++ ){
				if($aCount >= $a){
					$x.="<div class=\"adiv\" onclick=\"loadbookings(this);\">$approved</div>";
					$a++;
				}
				else if ($pCount >= $p){
					$x.="<div class=\"pdiv\" onclick=\"loadbookings(this);\">$proccessing</div>";
					$p++;
				}
				else{
					$x.="<div class=\"ediv\" onclick=\"loadbookings(this);\">$empty</div>";
				}
				
			}
			echo $start.$x.$end;
		}
		else if($noofrooms < 10 && $noofrooms <> 0){
			for($i=1; $i<10; $i++ ){
				if($aCount >= $a ){
						$x.="<div class=\"adiv\" onclick=\"loadbookings(this);\">$approved</div>";
						$a++;
					}
				else if ($pCount >= $p){
						$x.="<div class=\"pdiv\" onclick=\"loadbookings(this);\">$proccessing</div>";
						$p++;
					}
				else{
						$x.="<div class=\"ediv\" onclick=\"loadbookings(this);\">$empty</div>";
					}
				
			}
				echo $start.$x.$end;
		}
		else{
			for($i=1; $i<$noofrooms+1; $i++ ){
				if($i%10 == 1){
					$x.=$start;
				}
					if($aCount >= $a){
						$x.="<div class=\"adiv\" onclick=\"loadbookings(this);\">$approved</div>";
						$a++;
					}
					else if ($pCount >= $p){
						$x.="<div class=\"pdiv\" onclick=\"loadbookings(this);\">$proccessing</div>";
						$p++;
					}
					else{
						$x.="<div class=\"ediv\" onclick=\"loadbookings(this);\">$empty</div>";
					}
				if($i%10 == 0){
					$x.=$end;
				}
				
			}
			echo $x;
		}
	}
	
	function roomstatus($hotelId=NULL,$roomtypeid=NULL){
		$roomStatus=$this->Booking->find('all',
			array(
			'fields' => array(
     				'sum(Booking.number_of_rooms) AS S',
                    'Booking.status'),
			'conditions' =>array(" Booking.hotel_id = 2 AND Booking.room_type_id = $roomtypeid AND Booking.from_date > 2011-11-15 GROUP BY Booking.`status` ORDER BY Booking.`status` DESC;" ),
			)
		);
		return $roomStatus;
	}
	
	function booking(){
	
	}
	
}
?>
