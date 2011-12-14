<?php

class HotelsController extends ManagerAppController {

    var $name = 'Hotels';
    var $components = array('upload','Autocomplete');
    var $helpers = array('Html', 'Javascript', 'Ajax');
	var $uses = array('Hotel','HotelsManager','HotelsPicture','HotelsRoomCapacity','HotelsRoomType','HotelsCategoryList','User');
    //public $uses = array('User');
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
                        'conditions' => array('HotelsManager.hotel_id = Hotel.id', 'HotelsManager.user_id = ' . $this->Auth->user('id'))
                    )
            )));


        $this->set('hotels', $this->paginate('Hotel'));
        #die($this->data);
    }

    function view($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid hotel', true));
            $this->redirect(array('action' => 'index'));
        }
        // $conditions =  array('id' )
        $this->set('hotel', $this->Hotel->read(null, $id));
    }
    function autocomplete(){
    	die('d');
    }
    
	function ajaxLoadManagesDetails($mName=NULL){
			 if (isset($mName)) {       
		        $managerDetails = $this->Hotel->query("SELECT DISTINCT u.`name`,u.mobile,u.home_phone,u.email,u.website,u.first_name,u.last_name FROM users AS u INNER JOIN hotels_managers AS m ON m.id = u.id WHERE u.`name` LIKE '%$mName%' or email LIKE '%$mName%';");

		        header('Content-Type: text/xml'); 
			   echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			    $ResponseXML = "<XMLLoadDetails>";
				foreach ($managerDetails as $key){
					$ResponseXML .= "<Name><![CDATA[" . $key['u']['name'] . "]]></Name>\n";
					$ResponseXML .= "<fName><![CDATA[" . $key['u']['first_name'] . "]]></fName>\n";
					$ResponseXML .= "<lName><![CDATA[" . $key['u']['last_name'] . "]]></lName>\n";
					$ResponseXML .= "<Email><![CDATA[" . $key['u']['email'] . "]]></Email>\n";
					$ResponseXML .= "<website><![CDATA[" . $key['u']['website'] . "]]></website>\n";
					$ResponseXML .= "<mobile><![CDATA[" . $key['u']['mobile'] . "]]></mobile>\n";
					$ResponseXML .= "<home_phone><![CDATA[" . $key['u']['home_phone'] . "]]></home_phone>\n";    					
				}
				$ResponseXML .= "</XMLLoadDetails>";
				echo $ResponseXML;
				
		      //  echo $managerDetails;
			 }
    }
    
    function add() {
	
        if (!empty($this->data)) {

            $this->Hotel->create();

           

            if (isset($this->data['Hotel']['name'])) {
            	$imgName='';
            		if (isset($this->data['Hotel']['name'])) {
					
						if(!empty($this->data['Hotel']['logo']['name'])){
								
								$uploadPath = "webroot/uploads/hotels//";
								$root=APP; 
								$hotelId=$this->Session->read('eid');
								$tmpName=$this->data['Hotel']['logo']['tmp_name'];
								$imgName=$this->data['Hotel']['logo']['name'];
								$this->data['Hotel']['logo']=$this->data['Hotel']['logo']['name'];
								
						}
						else {
							$this->data['Hotel']['logo']='';
						}
            		}
					/*debug($this->data);
					die();*/
                if ($this->Hotel->save($this->data)) {
                    $this->Session->write("id", $this->Hotel->getInsertID());
                    $hotelId=$this->Hotel->getInsertID();
                	if (!is_dir($root . $uploadPath . $hotelId)) {
		                	
		                   			mkdir($root . $uploadPath . $hotelId);
		                    		chmod($root . $uploadPath . $hotelId, 0777);
		               			}
	
			                	if (move_uploaded_file($tmpName, $root . $uploadPath . $hotelId . DS . $imgName)) {
			             				
			                	
								}
					$this->data['HotelsManager']['hotel_id']=$hotelId;
					$this->data['HotelsManager']['user_id']=$this->data['Hotel']['contactperson'];
					if($this->HotelsManager->save($this->data)){
						
					}
                    $this->Session->setFlash(__('The hotel has been saved', true));

                    $this->set('tab', '1');
                } else {
					
                    $this->Session->setFlash(__('The hotel could not be saved. Please, try again.', true));

                    $this->set('tab', '0');
                }
            }

            if (isset($this->data['Hotel']['picture'])) {


                // $this->upload->data = $this->data;
                //$root = "D:\webroot\HotelMS\app\webroot";
                $uploadPath = "webroot/uploads/hotels/";
                $id = $this->Session->read("id");
				$root=APP; 
				
                $this->data['HotelsPicture']['picture'] = $this->data['Hotel']['picture']['name'];
                $this->data['HotelsPicture']['hotel_id'] = $id;
                $this->data['HotelsPicture']['caption'] = 'captions';
                $this->data['HotelsPicture']['status'] = 'APPROVED';
				
                if (!is_dir($root . $uploadPath . $id)) {
                	
                    mkdir($root . $uploadPath . $id);
                    chmod($root . $uploadPath . $id, 0777);
                }
                if (move_uploaded_file($this->data['Hotel']['picture']['tmp_name'], $root . $uploadPath . $id . "/" . $this->data['Hotel']['picture']['name'])) {

                    App::import('Model', 'Manager.HotelsPicture');
                    $HotelsPicture = new HotelsPicture();

                    $HotelsPicture->save($this->data);
					$this->Session->setFlash(__('The Image has been successfully uploaded', true));
                    $this->set('tab', '2');
                } else {
                	$this->Session->setFlash(__('The Image could not be uploaded. Please, try again!', true));
                    $this->set('tab', '1');
                }
            }



            if (isset($this->data['HotelsRoomType']['name'])) {


                $id = $this->Session->read("id");
                $this->data['HotelsRoomType']['hotel_id'] = $id;
                $this->data['HotelsRoomType']['status'] = 'APPROVED';
                //  debug($this->data);die();
                App::import('Model', 'Manager.HotelsRoomType');
                $HotelsRoomType = new HotelsRoomType();

                if($HotelsRoomType->save($this->data)){
                	$this->Session->setFlash(__('The Room Type has been successfully saved.', true));
                	$this->set('tab', '3');
                }
                else{
                	$this->Session->setFlash(__('The Room Type could not be saved. Please, try again!', true));
                    $this->set('tab', '2');
                }
            }


            if (isset($this->data['HotelsRoomCapacity']['rooms'])) {

                $this->data['HotelsRoomCapacity']['hotel_id'] = $this->Session->read("id");
                $this->data['HotelsRoomCapacity']['status'] = 'APPROVED';
                App::import('Model', 'Manager.HotelsRoomCapacity');
                $HotelsRoomCapacity = new HotelsRoomCapacity();

                if($HotelsRoomCapacity->save($this->data)){
                	$this->Session->setFlash(__('The Room Capacity has been successfully saved.', true));
                	$this->set('tab', '4');
                }
                else {
                	$this->Session->setFlash(__('The Room Capacity could not be saved. Please, try again!', true));
                    $this->set('tab', '3');
                }
            }


            if (isset($this->data['HotelsFeature']['features'])) {

                $this->data['HotelsFeature']['hotel_id'] = $this->Session->read("id");
                $this->data['HotelsFeature']['status'] = 'APPROVED';
                App::import('Model', 'Manager.HotelsFeature');
                $HotelsFeature = new HotelsFeature();

                if($HotelsFeature->save($this->data)){
                	$this->Session->setFlash(__('The Hotel Features has been successfully saved.', true));
                	$this->set('tab', '5');
                }
                else{
                	$this->Session->setFlash(__('The Hotel Features could not be saved. Please, try again!', true));
                	$this->set('tab', '4');
                }
                
            }
        }
        //  $categories = $this->Hotel->Category->find('list',array('joins' => array(array('table' => 'hotels_category_lists' , 'alias' => 'CategoryList' , 'type' => 'LEFT' , 'conditions' => array('CategoryList.id = Category.category_id'))),'fields' =>array('CategoryList.name'),'group' => 'CategoryList.id'));

        $categories = $this->HotelsCategoryList->find('list');
      //  $contactperson = $this->

        if ($this->Session->check("id")) {

            $roomTypes = $this->HotelsRoomType->find('list', array('conditions' => array('hotel_id ' => $this->Session->read("id"))));
        } else {
            $roomTypes = $this->HotelsRoomType->find('list');
        }

        //$contactperson = $this->HotelsManager->find('all');
        $contactperson = $this->User->find('all', array(
                'fields' => array(
        			'DISTINCT User.id',
        			'User.`first_name`'),
                'conditions'=>array('User.role_id=2'),
            )
        );

        
    	$contact=array();
	      foreach ($contactperson as $key=>$value){
	      	$contact[$value['User']['id']]=$value['User']['first_name'];
	      
	      }
       
        $contactperson=$contact;
        //$contactperson = $this->Hotel->HotelsManager->query('SELECT DISTINCT users.id,users.`name` FROM hotels_managers INNER JOIN users ON users.id = hotels_managers.id ORDER BY users.id ASC');
		//debug($contactperson);
		$hID=$this->Session->read("id");
		$userId=$this -> Session -> read();
		$uId=$userId['Auth']['User']['id'];

        $metaInfo = $this->Hotel->query("SELECT name,value from metainfo WHERE hotelId='".$hID."' AND userId='$uId' ORDER BY id ASC;");
         
        $this->set(compact('categories', 'roomTypes','contactperson','metaInfo'));
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
	function _myfilter($string=''){
		return htmlentities(strip_tags(mysql_real_escape_string($string)));
	}
	function addtometa(){
		$userId=$this -> Session -> read();
		$hotelId=$this->Session->read("id");
		$userId=$userId['Auth']['User']['id'];
		$name=$this->_myfilter($_REQUEST['metaName']);
		$value=$this->_myfilter($_REQUEST['metaValue']);
		$chkVal1=$this->_myfilter($_REQUEST['chkVal1']);
		$chkVal2=$this->_myfilter($_REQUEST['chkVal2']);

		$this->metaSaveEdit($userId,$hotelId,$name,$value,$chkVal1,$chkVal2);
	}
	
	function edittometa(){
		$userId=$this -> Session -> read();
		$hotelId=$this->Session->read("eid");
		$userId=$userId['Auth']['User']['id'];
		$name=$this->_myfilter($_REQUEST['metaName']);
		$value=$this->_myfilter($_REQUEST['metaValue']);
		$chkVal1=$this->_myfilter($_REQUEST['chkVal1']);
		$chkVal2=$this->_myfilter($_REQUEST['chkVal2']);

		$this->metaSaveEdit($userId,$hotelId,$name,$value,$chkVal1,$chkVal2);
	}
	
	function metaSaveEdit($userId=NULL,$hotelId=NULL,$name=NULL,$value=NULL,$chkVal1=NULL,$chkVal2=NULL){
	if(empty($hotelId)){
			echo 0;
		}		
		else{
			$chk=$this->Hotel->query("select count(*) as c from metainfo where name='".$chkVal2."' and hotelId='".$hotelId."';");
			if($chk[0][0]['c']==0){
				$response=$this->Hotel->query("insert into metainfo(hotelId,name,value,userId,dtmDate) VALUES('".$hotelId."','".$name."','".$value."','".$userId."',now());");
				echo $response;
			}
			else{
				$response=$this->Hotel->query("update metainfo set name ='".$name."' ,value='".$value."',userId='".$userId."',dtmDate=now() where name='".$chkVal2."' and hotelId='".$hotelId."';");
				echo $response;
			}
		}
	}
	function loadMeta(){
		$response=$this->Hotel->query("select name,value from metainfo;");
	}
	
	function deletemeta(){
		$name=$this->_myfilter($_REQUEST['metaName']);
		$response=$this->Hotel->query("delete from metainfo where name='".$name."';");
		echo $response;
	
	}
	
	function deleteImages($id=NULL){
		$userId=$this -> Session -> read();
		$userId=$userId['Auth']['User']['id'];
		
		$hotelId=$_REQUEST['id'];
		$this->Hotel->query("update hotels_pictures set picture='0' where hotel_id=$hotelId;");
		echo "Image successfully delted.";
	}
	
	function edit($id = null,$hotid=NULL) {
		/*----------Defult lodings start-----------*/
		$userId=$this -> Session -> read();
		$userId=$userId['Auth']['User']['id'];
		$hotelDets=$this->defaulthoteldet($userId);
		$contactperson = $this->HotelsManager->find('all', array(
                'fields' => array(
        			'DISTINCT User.id',
        			'User.`name`'),
                'joins' => array(
                    array(
                        'table' => 'users',
                        'alias' => 'User',
                        'type'  => 'INNER',
                        'foreignKey'    => false,
                        'conditions'    => array('User.id = HotelsManager.user_id'),
                        ),
                ),
            )
        );
		$contact=array();
	      foreach ($contactperson as $key=>$value){
	      	$contact[$value['User']['id']]=$value['User']['name'];
	      
	      }       
        $contactperson=$contact;
        $records=$metaInfo=$hotelimages=$roomTypes=$loadhotelroomtypesdes=$roomcapacitys=$roomcapacitydes=$loadfeaturelist=$laodfeturedes=array();
        $hotelname=$hotelid="";
		$hotelRoomTId='';
		$this->set('hotelspage', $this->paginate('Hotel'));
		$this->set(compact('hotelDets','contactperson','records','hotelname','hotelimages','roomTypes','hotelid','loadhotelroomtypesdes','roomcapacitys','roomcapacitydes','hotelRoomTId','loadfeaturelist','laodfeturedes','metaInfo'));
		/*------------end-------------*/
		
		
		if(@$this->params['pass'][0]=='loadhotelinfo'){
		/*----to load hotel datail start----*/
			$roomid=$capId='';
			$hotelid=$this->params['pass'][1];
			$this->Session->write("eid",$hotelid);
			$records=$this->loadhotelinfo($hotid,$userId);
			$hotelname=$records[0]['Hotel']['name'];
			$hotelDets=$this->defaulthoteldet($userId);
			$hotelimages=$this->loadhotelimages($hotelid,$userId);
			$roomTypes=$this->loadhotelroomtypes($hotelid,$userId);
			$loadhotelroomtypesdes =$this->loadhotelroomtypesdes($hotelid,$userId,$roomid); 
			$roomcapacitys=$this->loadhotelroomgapacity($hotelid,$userId);
			$roomcapacitydes=$this->loadhotelroomgapacitydes($hotelid,$userId,$capId);
			$loadfeaturelist=$this->loadfeaturelist($hotelid,$userId);
			$metaInfo = $this->Hotel->query("select name,value from metainfo where hotelId='$hotelid' and userId='$userId' ORDER BY id ASC;");
        	$this->set(compact('metaInfo'));
			$this->set(compact('hotelDets','records','hotelimages','hotelname','roomTypes','loadhotelroomtypesdes','hotelid','roomcapacitys','roomcapacitydes','loadfeaturelist'));
		/*----to load hotel datail end----*/
		}
		
		
		else if(@$this->params['pass'][0]=='changehotelroomtypes'){	
		/*----load room types------*/
		   		$hotelId=$this->Session->read('eid');		   		
		   		$typelid=$this->params['pass'][1];				
				$records=$this->loadhotelinfo($hotelId,$userId);
				$hotelname=$records[0]['Hotel']['name'];
				$hotelimages=$this->loadhotelimages($hotelId,$userId);
				$roomTypes=$this->loadhotelroomtypes($hotelId,$userId);
				$loadhotelroomtypesdes=$this->loadhotelroomtypesdes($hotelId,$userId,$typelid);
				$roomcapacitys=$this->loadhotelroomgapacity($hotelId,$userId);
				$loadfeaturelist=$this->loadfeaturelist($hotelId,$userId);
				$metaInfo = $this->Hotel->query("select name,value from metainfo where hotelId='$hotelId' and userId='$userId' ORDER BY id ASC;");
        		$this->set(compact('metaInfo'));
				$this->set('tab', '2');
				$this->set(compact('records','hotelimages','hotelname','roomTypes','roomcapacitys','loadhotelroomtypesdes','loadfeaturelist'));
			/*---end load room types----*/	 
		   	}
		 else if(@$this->params['pass'][0]=='loadroomcapacitydes'){
		 	/*----load room capacity------*/
			 	$hotelId=$this->Session->read('eid');
			 	
			 	$capId=$this->params['pass'][1];			
				$records=$this->loadhotelinfo($hotelId,$userId);
				$hotelname=$records[0]['Hotel']['name'];
				$hotelimages=$this->loadhotelimages($hotelId,$userId);
				$roomTypes=$this->loadhotelroomtypes($hotelId,$userId);
				$roomcapacitys=$this->loadhotelroomgapacity($hotelId,$userId);
				$roomcapacitydes=$this->loadhotelroomgapacitydes($hotelId,$userId,$capId);
				$loadfeaturelist=$this->loadfeaturelist($hotelId,$userId);
				if(isset($capId)){
					$hotelRoomTId= $capId;
				}
				$metaInfo = $this->Hotel->query("select name,value from metainfo where hotelId='$hotelId' and userId='$userId' ORDER BY id ASC;");
        		$this->set(compact('metaInfo'));
				$this->set('tab', '3');
				$this->set(compact('records','hotelimages','hotelname','roomTypes','loadhotelroomtypesdes','roomcapacitys','roomcapacitydes','hotelRoomTId','loadfeaturelist'));
		 	
		 	/*---end load room capacity----*/
		 }
	
		
		else if(@$this->params['pass'][0]=='loadfeatures'){
		/*---- start room loadfeatures----*/
			 	$hotelId=$this->Session->read('eid');
			 	
			 	$feId=$this->params['pass'][1];			
				$records=$this->loadhotelinfo($hotelId,$userId);
				$hotelname=$records[0]['Hotel']['name'];
				$hotelimages=$this->loadhotelimages($hotelId,$userId);
				$roomTypes=$this->loadhotelroomtypes($hotelId,$userId);
				$roomcapacitys=$this->loadhotelroomgapacity($hotelId,$userId);
//				$roomcapacitydes=$this->loadhotelroomgapacitydes($hotelId,$userId,$capId);
				$loadfeaturelist=$this->loadfeaturelist($hotelId,$userId);
				$laodfeturedes=$this->laodfeturedes($hotelId,$userId,$feId);
				$hotelid=$this->Session->read("id");
				$metaInfo = $this->Hotel->query("select name,value from metainfo where hotelId='$hotelId' and userId='$userId' ORDER BY id ASC;");
        		$this->set(compact('metaInfo'));
				$this->set('tab', '4');
				$this->set(compact('records','hotelimages','hotelname','roomTypes','loadhotelroomtypesdes','roomcapacitys','roomcapacitydes','hotelRoomTId','loadfeaturelist','laodfeturedes'));
		 /*****loadfeatures end ********/	
		 }
		 
		
		/*----to save hotel datail start----*/
	   if (!empty($this->data)) {	
		   	if($this->data['Hotel']['act']=='editHotelInfo' ){
		   		
			  	$this->Hotel->create();	  
				if (isset($this->data['Hotel']['name'])) {
					
						if(!empty($this->data['Hotel']['logo']['name'])){
								
								$uploadPath = "webroot/uploads/hotels//";
								$root=APP; 
								$hotelId=$this->Session->read('eid');
								$tmpName=$this->data['Hotel']['logo']['tmp_name'];
								
								if (!is_dir($root . $uploadPath . $hotelId)) {
		                	
		                   			mkdir($root . $uploadPath . $hotelId);
		                    		chmod($root . $uploadPath . $hotelId, 0777);
		               			}
	
			                	if (move_uploaded_file($tmpName, $root . $uploadPath . $hotelId . DS . $this->data['Hotel']['logo']['name'])) {
			             			$this->data['Hotel']['logo']=$this->data['Hotel']['logo']['name'];	
			                	
								}
						}
							
		                if ($this->Hotel->save($this->data)) {
							
							$records=$this->loadhotelinfo($this->Session->read("eid"),$userId);
							$hotelname=$records[0]['Hotel']['name'];
							$hotelimages=$this->loadhotelimages($this->Session->read("eid"),$userId);
							$roomTypes=$this->loadhotelroomtypes($this->Session->read("eid"),$userId);
							$hotelDets=$this->defaulthoteldet($userId);
							$roomcapacitys=$this->loadhotelroomgapacity($this->Session->read("eid"),$userId);
							$loadfeaturelist=$this->loadfeaturelist($this->Session->read("eid"),$userId);
							$hotelid=$this->Session->read("eid");
							$metaInfo = $this->Hotel->query("select name,value from metainfo where hotelId='$hotelid' and userId='$userId' ORDER BY id ASC;");
        					$this->set(compact('metaInfo'));
							$this->set(compact('hotelDets','records','hotelimages','hotelname','roomTypes','roomcapacitys','loadfeaturelist')); 
							$this->Session->setFlash(__( 'The hotel has been updated.', true));      
							$this->set('tab', '0'); 	
											                     
		                } else {	
		                	
		                	$records=$this->loadhotelinfo($this->Session->read("eid"),$userId);
							$hotelname=$records[0]['Hotel']['name'];
							$hotelimages=$this->loadhotelimages($this->Session->read("eid"),$userId);
							$roomTypes=$this->loadhotelroomtypes($this->Session->read("eid"),$userId);
							$hotelDets=$this->defaulthoteldet($userId);
							$roomcapacitys=$this->loadhotelroomgapacity($this->Session->read("eid"),$userId);
							$loadfeaturelist=$this->loadfeaturelist($this->Session->read("eid"),$userId);
							$hotelid=$this->Session->read("eid");
							$metaInfo = $this->Hotel->query("select name,value from metainfo where hotelId='$hotelid' and userId='$userId' ORDER BY id ASC;");
        					$this->set(compact('metaInfo'));
							$this->set(compact('hotelDets','records','hotelimages','hotelname','roomTypes','roomcapacitys')); 
							$this->set(compact('records','hotelimages','hotelname','loadhotelroomtypesdes','roomTypes','roomcapacitys','loadfeaturelis'));       
						    
							$this->set('tab', '0'); 	                    
		                }
		            }
		   		}
		   /*----to save hotel datail end----*/
		   /*----to upload images------------*/

		   if($this->data['Hotel']['act']=='uploadNewImage' ){
			  	$this->Hotel->create();	  
				if (isset($this->data['HotelsPicture']['picture']['name'])) {
				 $uploadPath = "webroot/uploads/hotels//";
				 $root=APP; 
				 $hotelId=$this->Session->read('eid');
				 $tmpName=$this->data['HotelsPicture']['picture']['tmp_name'];

		    		$this->data['HotelsPicture']['picture'] = $this->data['HotelsPicture']['picture']['name'];
	                $this->data['HotelsPicture']['hotel_id'] = $hotelId;
	                $this->data['HotelsPicture']['caption'] = 'captions';
	                $this->data['HotelsPicture']['status'] = 'APPROVED';
	               $this->data['HotelsPicture']['id'] = '';
	               
	                if (!is_dir($root . $uploadPath . $hotelId)) {
	                	
	                    mkdir($root . $uploadPath . $hotelId);
	                    chmod($root . $uploadPath . $hotelId, 0777);
	                }
	                
				
	                if (move_uploaded_file($tmpName, $root . $uploadPath . $hotelId . DS . $this->data['HotelsPicture']['picture'])) {
	                    App::import('Model', 'Manager.HotelsPicture');
	                    $HotelsPicture = new HotelsPicture();
						
	                    $HotelsPicture->save($this->data);
						$this->Session->setFlash(__( 'The image has been succussfully uploaded.', true)); 
						$records=$this->loadhotelinfo($this->Session->read("eid"),$userId);
						$hotelname=$records[0]['Hotel']['name'];
						$hotelimages=$this->loadhotelimages($this->Session->read("eid"),$userId);
						$roomTypes=$this->loadhotelroomtypes($this->Session->read("eid"),$userId);
						$roomcapacitys=$this->loadhotelroomgapacity($this->Session->read("eid"),$userId);
						$loadfeaturelist=$this->loadfeaturelist($this->Session->read("eid"),$userId);
						$hotelid=$this->Session->read("eid");
						$metaInfo = $this->Hotel->query("select name,value from metainfo where hotelId='$hotelid' and userId='$userId' ORDER BY id ASC;");
        				$this->set(compact('metaInfo'));
						$this->set(compact('records','hotelimages','hotelname','loadhotelroomtypesdes','roomTypes','roomcapacitys','loadfeaturelist'));       
						$this->set('tab', '1'); 
	                   
	                } else {
	                	$records=$this->loadhotelinfo($this->Session->read("eid"),$userId);
						$hotelname=$records[0]['Hotel']['name'];
						$hotelimages=$this->loadhotelimages($this->Session->read("eid"),$userId);
						$roomTypes=$this->loadhotelroomtypes($this->Session->read("eid"),$userId);
						$roomcapacitys=$this->loadhotelroomgapacity($this->Session->read("eid"),$userId);
						$loadfeaturelist=$this->loadfeaturelist($this->Session->read("eid"),$userId);
						$hotelid=$this->Session->read("eid");
						$metaInfo = $this->Hotel->query("select name,value from metainfo where hotelId='$hotelid' and userId='$userId' ORDER BY id ASC;");
        				$this->set(compact('metaInfo'));
						$this->set(compact('records','hotelimages','hotelname','loadhotelroomtypesdes','roomTypes','roomcapacitys','loadfeaturelist'));       						
	                	$this->Session->setFlash(__( 'The Image could not be updated. Please, try again.', true));       
						$this->set('tab', '1'); 
	                     
	                }
		         }
		   	}
		   /****end***/
		   /*------update roomtypes*/
		  if($this->data['Hotel']['act']=='editRoomTypes' ){
		  	$this->Hotel->create();	  
			 if (isset($this->data['HotelsRoomType']['name'])) {			 	
                $this->data['HotelsRoomType']['status'] = 'APPROVED';
       
                App::import('Model', 'Manager.HotelsRoomType');
                $HotelsRoomType = new HotelsRoomType();
				
               if ($HotelsRoomType->save($this->data)) {
	                    $this->Session->setFlash(__('The room type has been updated', true));
	                    $records=$this->loadhotelinfo($this->Session->read("eid"),$userId);
						$hotelname=$records[0]['Hotel']['name'];
						$hotelimages=$this->loadhotelimages($this->Session->read("eid"),$userId);
						$roomTypes=$this->loadhotelroomtypes($this->Session->read("eid"),$userId);
						$roomcapacitys=$this->loadhotelroomgapacity($this->Session->read("eid"),$userId);
						$loadfeaturelist=$this->loadfeaturelist($this->Session->read("eid"),$userId);
						$hotelid=$this->Session->read("eid");
						$metaInfo = $this->Hotel->query("select name,value from metainfo where hotelId='$hotelid' and userId='$userId' ORDER BY id ASC;");
        				$this->set(compact('metaInfo'));
						$this->set(compact('records','hotelimages','hotelname','roomTypes','roomcapacitys','loadfeaturelist')); 
	                    $this->set('tab', '2'); 
	                } else {
	
	                    $this->Session->setFlash(__('The room type could not be updated. Please, try again.', true));
	                    $records=$this->loadhotelinfo($this->Session->read("eid"),$userId);
						$hotelname=$records[0]['Hotel']['name'];
						$hotelimages=$this->loadhotelimages($this->Session->read("eid"),$userId);
						$roomTypes=$this->loadhotelroomtypes($this->Session->read("eid"),$userId);
						$loadfeaturelist=$this->loadfeaturelist($this->Session->read("eid"),$userId);
						$hotelid=$this->Session->read("eid");
						$metaInfo = $this->Hotel->query("select name,value from metainfo where hotelId='$hotelid' and userId='$userId' ORDER BY id ASC;");
        				$this->set(compact('metaInfo'));
						$this->set(compact('records','hotelimages','hotelname','roomTypes','roomcapacitys','loadfeaturelist')); 
	                    $this->set('tab', '2'); 
	                }
	            }
		  }
		   		
		   /*----------end---------*/	
	    if($this->data['Hotel']['act']=='editRoomCapacity'){	    	
		  	//$this->Hotel->create();	  
			 if (isset($this->data['HotelsRoomCapacity']['room_type_id'])) {			 	
                $this->data['HotelsRoomCapacity']['hotel_id'] = $this->Session->read("eid");
                $this->data['HotelsRoomCapacity']['status'] = 'APPROVED';
                App::import('Model', 'Manager.HotelsRoomCapacity');
                $HotelsRoomCapacity = new HotelsRoomCapacity();
       
                App::import('Model', 'Manager.HotelsRoomType');
                $HotelsRoomType = new HotelsRoomType();
				
               	if ($HotelsRoomCapacity->save($this->data)) {
               		
               		$this->Session->setFlash(__('The room capacity has been updated', true));
               		$records=$this->loadhotelinfo($this->Session->read("eid"),$userId);
					$hotelname=$records[0]['Hotel']['name'];
					$hotelimages=$this->loadhotelimages($this->Session->read("eid"),$userId);
					$roomTypes=$this->loadhotelroomtypes($this->Session->read("eid"),$userId);
					$roomcapacitys=$this->loadhotelroomgapacity($this->Session->read("eid"),$userId);
					$loadfeaturelist=$this->loadfeaturelist($this->Session->read("eid"),$userId);
					$hotelid=$this->Session->read("eid");
					$metaInfo = $this->Hotel->query("select name,value from metainfo where hotelId='$hotelid' and userId='$userId' ORDER BY id ASC;");
        			$this->set(compact('metaInfo'));
					$this->set(compact('records','hotelimages','hotelname','roomTypes','roomcapacitys','loadfeaturelist'));
	                $this->set('tab', '3');
	                
               	} 
               	else {
               		 $this->Session->setFlash(__('The room capacity could not be updated. Please, try again.', true));
               		 $records=$this->loadhotelinfo($this->Session->read("eid"),$userId);
					 $hotelname=$records[0]['Hotel']['name'];
					 $hotelimages=$this->loadhotelimages($this->Session->read("eid"),$userId);
					 $roomTypes=$this->loadhotelroomtypes($this->Session->read("eid"),$userId);
					 $roomcapacitys=$this->loadhotelroomgapacity($this->Session->read("eid"),$userId);
					 $loadfeaturelist=$this->loadfeaturelist($this->Session->read("eid"),$userId);
					 $hotelid=$this->Session->read("eid");
					 $metaInfo = $this->Hotel->query("select name,value from metainfo where hotelId='$hotelid' and userId='$userId' ORDER BY id ASC;");
        			 $this->set(compact('metaInfo'));
					 $this->set(compact('records','hotelimages','hotelname','roomTypes','roomcapacitys','loadfeaturelist'));
					 $this->set('tab', '3');
               	}
	            
			 }
		  }
		  if($this->data['Hotel']['act']=='editfeatures'){
		  //	debug(empty($this->data)); die();
			 if (!empty($this->data)) {
			 	$this->data['HotelsFeature']['hotel_id'] =$this->Session->read("eid");
	            $this->data['HotelsFeature']['status'] = 'APPROVED';
	            App::import('Model', 'Manager.HotelsFeature');
	            $HotelsFeature = new HotelsFeature();

	            if ($HotelsFeature->save($this->data)) {
	            	$this->Session->setFlash(__('The features has been updated', true));
					$hotelid=$this->Session->read("eid");
               		$records=$this->loadhotelinfo($this->Session->read("eid"),$userId);
					$hotelname=$records[0]['Hotel']['name'];
					$hotelimages=$this->loadhotelimages($this->Session->read("eid"),$userId);
					$roomTypes=$this->loadhotelroomtypes($this->Session->read("eid"),$userId);
					$roomcapacitys=$this->loadhotelroomgapacity($this->Session->read("eid"),$userId);
					$loadfeaturelist=$this->loadfeaturelist($this->Session->read("eid"),$userId);
					$metaInfo = $this->Hotel->query("select name,value from metainfo where hotelId='$hotelid' and userId='$userId' ORDER BY id ASC;");
        			$this->set(compact('metaInfo'));
					$this->set(compact('records','hotelimages','hotelname','roomTypes','roomcapacitys','loadfeaturelist'));
	            	$this->set('tab', '4');
	            }
	           else{
	           		$this->Session->setFlash(__('The features could not be updated. Please, try again.', true));

               		$records=$this->loadhotelinfo($this->Session->read("eid"),$userId);
					$hotelname=$records[0]['Hotel']['name'];
					$hotelimages=$this->loadhotelimages($this->Session->read("eid"),$userId);
					$roomTypes=$this->loadhotelroomtypes($this->Session->read("eid"),$userId);
					$roomcapacitys=$this->loadhotelroomgapacity($this->Session->read("eid"),$userId);
					$loadfeaturelist=$this->loadfeaturelist($this->Session->read("eid"),$userId);
					$hotelid=$this->Session->read("eid");
					$metaInfo = $this->Hotel->query("select name,value from metainfo where hotelId='$hotelid' and userId='$userId' ORDER BY id ASC;");
        			$this->set(compact('metaInfo'));
					$this->set(compact('records','hotelimages','hotelname','roomTypes','roomcapacitys','loadfeaturelist'));
				    $this->set('tab', '4');
	           }
			 }
	   	  }
	   }
	   
		
    }
	function defaulthoteldet($userId=NULL){
      		$defaulthoteldet= $this->Hotel->find('all', array(
                'fields' => array(
     				'Hotel.id',
                    'Hotel.`name`'),
                'joins' => array(
                    array(
                        'table' => 'hotels_managers',
                        'alias' => 'HotelsManager',
                        'type'  => 'INNER',
                        'foreignKey'    => false,
                        'conditions'    => array('Hotel.id = HotelsManager.hotel_id', 'HotelsManager.user_id ='.$userId
                    	
                    ),
                        ),
                ),
            )
          );
		return $defaulthoteldet;
	}
	
	function loadhotelinfo($hotid=NULL,$userId=NULL){
    	$records = $this->Hotel->find('all', array(
                'fields' => array(
     				'Hotel.id',
                    'Hotel.`name`',
                    'Hotel.address',
                    'Hotel.phone',
                    'Hotel.email',
                    'Hotel.web',
                    'Hotel.contactperson',
                    'Hotel.starclass',
					'Hotel.`status`',
    				'Hotel.`subdomain`'),
                'joins' => array(
                    array(
                        'table' => 'hotels_managers',
                        'alias' => 'HotelsManager',
                        'type'  => 'INNER',
                        'foreignKey'    => false,
                        'conditions'    => array('Hotel.id = HotelsManager.hotel_id', 'HotelsManager.user_id ='.$userId,
                    	'Hotel.id='.$hotid
                    	
                    ),
                        ),
                ),
            )
        );
	
		return $records;
	}
	
	function loadhotelimages($hotid=NULL,$userId=NULL){
		$hotelimges=$this->Hotel->find('all',array(			
		'fields'=>array('HotelsPicture.hotel_id',
						'HotelsPicture.picture',
						'HotelsPicture.id'),
		'joins' => array(
                   array(
                        'table'=>'hotels_managers',
						'alias'=>'HotelsManager',
						'type'=>'INNER',
						'foreignKey'    => false,
						'conditions'    => array('Hotel.id = HotelsManager.hotel_id'),
                        ),
				  array(
                        'table'=>'hotels_pictures',
					    'alias'=>'HotelsPicture',
						'type'=>'INNER',
						'foreignKey'    => false,
					    'conditions'    => array('HotelsPicture.hotel_id = HotelsManager.hotel_id')
                    	
                    ),
		 	
		  	),
		  	'conditions' =>array("HotelsManager.user_id=$userId AND HotelsPicture.hotel_id=$hotid" ),
		  )
		);
		return $hotelimges;
	}
	
	function loadhotelroomtypes($hotid=NULL,$userId=NULL){
		$roomTypes=$this->Hotel->find('all',array(
				  'fields'=>array('HotelsRoomType.id',
								'HotelsRoomType.hotel_id',
								'HotelsRoomType.`name`' ),
				'joins' => array(
                   array(
                        'table'=>'hotels_managers',
						'alias'=>'HotelsManager',
						'type'=>'INNER',
						'foreignKey'    => false,
						'conditions'    => array('Hotel.id = HotelsManager.hotel_id'),
                        ),
                    array(
                        'table'=>'hotels_room_types',
					    'alias'=>'HotelsRoomType',
						'type'=>'INNER',
						'foreignKey'    => false,
					    'conditions'    => array('HotelsRoomType.hotel_id = HotelsManager.hotel_id')
                    ),
		),
					'conditions' =>array("HotelsManager.user_id=$userId AND HotelsRoomType.hotel_id=$hotid" ),
				)
		);

		return  $roomTypes;
	}
	
	function loadhotelroomtypesdes($hotid=NULL,$userId=NULL,$roomId=NULL){
		$roomTypes=$this->Hotel->find('all',array(
				  'fields'=>array('HotelsRoomType.id',
								'HotelsRoomType.hotel_id',
								'HotelsRoomType.`name`',
								'HotelsRoomType.`name`',
								'HotelsRoomType.price',
								'HotelsRoomType.size',
								'HotelsRoomType.info',
								'HotelsRoomType.`view`',
								'HotelsRoomType.cooling',
								'HotelsRoomType.`status`' ),
				'joins' => array(
                   array(
                        'table'=>'hotels_managers',
						'alias'=>'HotelsManager',
						'type'=>'INNER',
						'foreignKey'    => false,
						'conditions'    => array('Hotel.id = HotelsManager.hotel_id'),
                        ),
                    array(
                        'table'=>'hotels_room_types',
					    'alias'=>'HotelsRoomType',
						'type'=>'INNER',
						'foreignKey'    => false,
					    'conditions'    => array('HotelsRoomType.hotel_id = HotelsManager.hotel_id')
                    ),
		),
					'conditions' =>array("HotelsManager.user_id=$userId AND HotelsRoomType.hotel_id=$hotid AND HotelsRoomType.id='$roomId';" ),
				)
		);

		return  $roomTypes;
	}
	
	function  loadhotelroomgapacity($hotid=NULL,$userId=NULL){
		$roomcapacitys=$this->Hotel->find('all',array(
				 'fields'=>array(
				  	  'HotelsRoomCapacity.id',
					  'HotelsRoomCapacity.hotel_id',
					  'HotelsRoomCapacity.room_type_id',
					  'HotelsRoomType.id',
					  'HotelsRoomCapacity.max_adults',
					  'HotelsRoomCapacity.max_children',
					  'HotelsRoomCapacity.additional_adult_charge',
					  'HotelsRoomCapacity.additional_child_charge',
					  'HotelsRoomCapacity.total_rooms',
					  'HotelsRoomType.`name`' ),
				'joins' => array(
		                   array(
		                        'table'=>'hotels_managers',
								'alias'=>'HotelsManager',
								'type'=>'INNER',
								'foreignKey'    => false,
								'conditions'    => array('Hotel.id = HotelsManager.hotel_id'),
		                        ),
		                    array(
		                        'table'=>'hotels_room_types',
							    'alias'=>'HotelsRoomType',
								'type'=>'INNER',
								'foreignKey'    => false,
							    'conditions'    => array('HotelsRoomType.hotel_id = HotelsManager.hotel_id')
		                    ),
		                    array(
		                        'table'=>'hotels_room_capacities',
							    'alias'=>'HotelsRoomCapacity',
								'type'=>'LEFT',
								'foreignKey'    => false,
							    'conditions'    => array('HotelsRoomType.hotel_id = HotelsRoomCapacity.hotel_id  AND HotelsRoomType.id = HotelsRoomCapacity.room_type_id')
		                    ),
		               ),
		                    'conditions' =>array("HotelsManager.user_id='$userId' AND HotelsRoomType.hotel_id='$hotid'" ),
				)

			);
		return  $roomcapacitys;
	}
	
    function  loadhotelroomgapacitydes($hotid=NULL,$userId=NULL,$capId=NULL){
		$roomcapacitydes=$this->Hotel->find('all',array(
				 'fields'=>array(
				  	  'HotelsRoomCapacity.id',
					  'HotelsRoomCapacity.hotel_id',
					  'HotelsRoomCapacity.room_type_id',
					  'HotelsRoomCapacity.max_adults',
					  'HotelsRoomCapacity.max_children',
					  'HotelsRoomCapacity.additional_adult_charge',
					  'HotelsRoomCapacity.additional_child_charge',
					  'HotelsRoomCapacity.total_rooms',
					  'HotelsRoomType.`name`' ),
				'joins' => array(
		                   array(
		                        'table'=>'hotels_managers',
								'alias'=>'HotelsManager',
								'type'=>'INNER',
								'foreignKey'    => false,
								'conditions'    => array('Hotel.id = HotelsManager.hotel_id'),
		                        ),
		                    array(
		                        'table'=>'hotels_room_types',
							    'alias'=>'HotelsRoomType',
								'type'=>'INNER',
								'foreignKey'    => false,
							    'conditions'    => array('HotelsRoomType.hotel_id = HotelsManager.hotel_id')
		                    ),
		                    array(
		                        'table'=>'hotels_room_capacities',
							    'alias'=>'HotelsRoomCapacity',
								'type'=>'INNER',
								'foreignKey'    => false,
							    'conditions'    => array('HotelsRoomType.hotel_id = HotelsRoomCapacity.hotel_id  AND HotelsRoomType.id = HotelsRoomCapacity.room_type_id')
		                    ),
		               ),
		                    'conditions' =>array("HotelsManager.user_id='$userId' AND HotelsRoomCapacity.hotel_id='$hotid' AND HotelsRoomCapacity.room_type_id='$capId'" ),
				)

			);
		return  $roomcapacitydes;
	}
	
	function loadfeaturelist($hotid=NULL,$userId=NULL){
		
		$features=$this->Hotel->find('all', array(
                'fields' => array(
        			'Hotel.`name`',
					'Hotel.id',
     				'HotelsFeatures.id',
            		'HotelsFeatures.hotel_id',
					'HotelsFeatures.feature_category',
					'HotelsFeatures.feature',
					'HotelsFeatures.is_available'),
                'joins' => array(
                    array(
                        'table' => 'hotels_features',
                        'alias' => 'HotelsFeatures',
                        'type'  => 'INNER',
                        'foreignKey'    => false,
                        'conditions'    => array('Hotel.id = HotelsFeatures.hotel_id'),
                        ),
                   array(
                        'table' => 'hotels_managers',
                        'alias' => 'HotelsManager',
                        'type'  => 'INNER',
                        'foreignKey'    => false,
                        'conditions'    => array('Hotel.id = HotelsManager.hotel_id', 'HotelsManager.user_id ='.$userId,'Hotel.id='.$hotid),
                        ),
                ),
            )
        );
         return $features;
		
	}
	
	function laodfeturedes($hotelid=NULL,$userId=NULL,$feId=NULL){
		$featuresDes=$this->Hotel->find('all', array(
                'fields' => array(
        			'Hotel.`name`',
					'Hotel.id',
     				'HotelsFeatures.id',
            		'HotelsFeatures.hotel_id',
					'HotelsFeatures.feature_category',
					'HotelsFeatures.feature',
					'HotelsFeatures.is_available'),
                'joins' => array(
                    array(
                        'table' => 'hotels_features',
                        'alias' => 'HotelsFeatures',
                        'type'  => 'INNER',
                        'foreignKey'    => false,
                        'conditions'    => array('Hotel.id = HotelsFeatures.hotel_id'),
                        ),
                   array(
                        'table' => 'hotels_managers',
                        'alias' => 'HotelsManager',
                        'type'  => 'INNER',
                        'foreignKey'    => false,
                        'conditions'    => array('Hotel.id = HotelsManager.hotel_id'),
                        ),
                ),
                'conditions' =>array("HotelsManager.user_id='$userId' AND Hotel.id='$hotelid' AND HotelsFeatures.id='$feId';" ),
            )
        );
         return $featuresDes;
	}
	
	public function setlogoimag($id=NULL){
		$id=$this->params['pass'][0];
		$this->data['Hotel']['id']=$this->Session->read("eid");
		$this->data['Hotel']['logo']=$this->params['id'];
		if($this->Hotel->save($this->data)){
			echo "Logo saved.";
		}
		else{
			echo "Saving fail.";
		}
	}
}
?>