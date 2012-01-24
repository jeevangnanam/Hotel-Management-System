<?php
/**
 * Nodes Controller
 *
 * PHP version 5
 *
 * @category Controller
 * @package  Croogo
 * @version  1.0
 * @author   Fahad Ibnay Heylaal <contact@fahad19.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.croogo.org
 */
class NodesController extends AppController {
/**
 * Controller name
 *
 * @var string
 * @access public
 */
    public $name = 'Nodes';
/**
 * Components
 *
 * @var array
 * @access public
 */
    public $components = array(
        'Recaptcha','Email'
    );//  use component email 
/**
 * Models used by the Controller
 *
 * @var array
 * @access public
 */
    public $uses = array(
        'Node','Hotel','HotelsPicture','Users','HotelsRoomType','HotelsRoomCapacities','Booking','Coupon','HotelsCategoryList','User','Rooms'
    );
    
	
    public function beforeFilter() {
    	
        parent::beforeFilter();

        if (isset($this->params['slug'])) {
            $this->params['named']['slug'] = $this->params['slug'];
        }
        if (isset($this->params['type'])) {
            $this->params['named']['type'] = $this->params['type'];
        }

        // CSRF Protection
        if (in_array($this->params['action'], array('admin_add', 'admin_edit'))) {
            $this->Security->validatePost = false;
        }
    }

    public function admin_index() {
        $this->set('title_for_layout', __('Content', true));

        $this->Node->recursive = 0;
        $this->paginate['Node']['order'] = 'Node.created DESC';
        $this->paginate['Node']['conditions'] = array();

        $types = $this->Node->Taxonomy->Vocabulary->Type->find('all');
        $typeAliases = Set::extract('/Type/alias', $types);
        $this->paginate['Node']['conditions']['Node.type'] = $typeAliases;

        if (isset($this->params['named']['filter'])) {
            $filters = $this->Croogo->extractFilter();
            foreach ($filters AS $filterKey => $filterValue) {
                if (strpos($filterKey, '.') === false) {
                    $filterKey = 'Node.' . $filterKey;
                }
                $this->paginate['Node']['conditions'][$filterKey] = $filterValue;
            }
            $this->set('filters', $filters);
        }

        $nodes = $this->paginate('Node');
        $this->set(compact('nodes', 'types', 'typeAliases'));

        if (isset($this->params['named']['links'])) {
            $this->layout = 'ajax';
            $this->render('admin_links');
        }
    }

    public function admin_create() {
        $this->set('title_for_layout', __('Create content', true));

        $types = $this->Node->Taxonomy->Vocabulary->Type->find('all', array(
            'order' => array(
                'Type.alias' => 'ASC',
            ),
        ));
        $this->set(compact('types'));
    }

    public function admin_add($typeAlias = 'node') {
        $type = $this->Node->Taxonomy->Vocabulary->Type->findByAlias($typeAlias);
        if (!isset($type['Type']['alias'])) {
            $this->Session->setFlash(__('Content type does not exist.', true));
            $this->redirect(array('action' => 'create'));
        }

        $this->set('title_for_layout', sprintf(__('Create content: %s', true), $type['Type']['title']));
        $this->Node->type = $type['Type']['alias'];
        $this->Node->Behaviors->attach('Tree', array(
            'scope' => array(
                'Node.type' => $this->Node->type,
            ),
        ));

        if (!empty($this->data)) {
            // CSRF Protection
            if ($this->params['_Token']['key'] != $this->data['Node']['token_key']) {
                $blackHoleCallback = $this->Security->blackHoleCallback;
                $this->$blackHoleCallback();
            }

            if (isset($this->data['TaxonomyData'])) {
                $this->data['Taxonomy'] = array(
                    'Taxonomy' => array(),
                );
                foreach ($this->data['TaxonomyData'] AS $vocabularyId => $taxonomyIds) {
                    if (is_array($taxonomyIds)) {
                        $this->data['Taxonomy']['Taxonomy'] = array_merge($this->data['Taxonomy']['Taxonomy'], $taxonomyIds);
                    }
                }
            }
            $this->Node->create();
            $this->data['Node']['path'] = $this->Croogo->getRelativePath(array(
                'admin' => false,
                'controller' => 'nodes',
                'action' => 'view',
                'type' => $this->Node->type,
                'slug' => $this->data['Node']['slug'],
            ));
            $this->data['Node']['visibility_roles'] = $this->Node->encodeData($this->data['Role']['Role']);
            if ($this->Node->saveWithMeta($this->data)) {
                $this->Session->setFlash(sprintf(__('%s has been saved', true), $type['Type']['title']), 'default', array('class' => 'success'));
                $this->redirect(array('action'=>'index'));
            } else {
                $this->Session->setFlash(sprintf(__('%s could not be saved. Please, try again.', true), $type['Type']['title']), 'default', array('class' => 'error'));
            }
        } else {
            $this->data['Node']['user_id'] = $this->Session->read('Auth.User.id');
        }

        $nodes = $this->Node->generatetreelist();
        $roles   = $this->Node->User->Role->find('list');
        $users = $this->Node->User->find('list');
        $vocabularies = Set::combine($type['Vocabulary'], '{n}.id', '{n}');
        $taxonomy = array();
        foreach ($type['Vocabulary'] AS $vocabulary) {
            $vocabularyId = $vocabulary['id'];
            $taxonomy[$vocabularyId] = $this->Node->Taxonomy->getTree($vocabulary['alias'], array('taxonomyId' => true));
        }
        $this->set(compact('typeAlias', 'type', 'nodes', 'roles', 'vocabularies', 'taxonomy', 'users'));
    }

    public function admin_edit($id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid content', true), 'default', array('class' => 'error'));
            $this->redirect(array('action'=>'index'));
        }
        
        $this->Node->id = $id;
        $typeAlias = $this->Node->field('type');
        
        $type = $this->Node->Taxonomy->Vocabulary->Type->findByAlias($typeAlias);
        if (!isset($type['Type']['alias'])) {
            $this->Session->setFlash(__('Content type does not exist.', true), 'default', array('class' => 'error'));
            $this->redirect(array('action' => 'create'));
        }

        $this->set('title_for_layout', sprintf(__('Edit content: %s', true), $type['Type']['title']));
        $this->Node->type = $type['Type']['alias'];
        $this->Node->Behaviors->attach('Tree', array('scope' => array('Node.type' => $this->Node->type)));

        if (!empty($this->data)) {
            // CSRF Protection
            if ($this->params['_Token']['key'] != $this->data['Node']['token_key']) {
                $blackHoleCallback = $this->Security->blackHoleCallback;
                $this->$blackHoleCallback();
            }

            if (isset($this->data['TaxonomyData'])) {
                $this->data['Taxonomy'] = array(
                    'Taxonomy' => array(),
                );
                foreach ($this->data['TaxonomyData'] AS $vocabularyId => $taxonomyIds) {
                    if (is_array($taxonomyIds)) {
                        $this->data['Taxonomy']['Taxonomy'] = array_merge($this->data['Taxonomy']['Taxonomy'], $taxonomyIds);
                    }
                }
            }
            $this->data['Node']['path'] = $this->Croogo->getRelativePath(array(
                'admin' => false,
                'controller' => 'nodes',
                'action' => 'view',
                'type' => $this->Node->type,
                'slug' => $this->data['Node']['slug'],
            ));
            $this->data['Node']['visibility_roles'] = $this->Node->encodeData($this->data['Role']['Role']);
            if ($this->Node->saveWithMeta($this->data)) {
                $this->Session->setFlash(sprintf(__('%s has been saved', true), $type['Type']['title']), 'default', array('class' => 'success'));
                $this->redirect(array('action'=>'index'));
            } else {
                $this->Session->setFlash(sprintf(__('%s could not be saved. Please, try again.', true), $type['Type']['title']), 'default', array('class' => 'error'));
            }
        }
        if (empty($this->data)) {
            $data = $this->Node->read(null, $id);
            
            $data['Role']['Role'] = $this->Node->decodeData($data['Node']['visibility_roles']);
      
            $this->data = $data;
        }

        $nodes = $this->Node->generatetreelist();
        $roles   = $this->Node->User->Role->find('list');
        $users = $this->Node->User->find('list');
        $vocabularies = Set::combine($type['Vocabulary'], '{n}.id', '{n}');
        $taxonomy = array();
        foreach ($type['Vocabulary'] AS $vocabulary) {
            $vocabularyId = $vocabulary['id'];
            $taxonomy[$vocabularyId] = $this->Node->Taxonomy->getTree($vocabulary['alias'], array('taxonomyId' => true));
        }
        $this->set(compact('typeAlias', 'type', 'nodes', 'roles', 'vocabularies', 'taxonomy', 'users'));
    }

    public function admin_update_paths() {
        $types = $this->Node->Taxonomy->Vocabulary->Type->find('list', array(
            'fields' => array(
                'Type.id',
                'Type.alias',
            ),
        ));
        $typesAlias = array_values($types);

        $nodes = $this->Node->find('all', array(
            'conditions' => array(
                'Node.type' => $typesAlias,
            ),
            'fields' => array(
                'Node.id',
                'Node.slug',
                'Node.type',
                'Node.path',
            ),
            'recursive' => '-1',
        ));
        foreach ($nodes AS $node) {
            $node['Node']['path'] = $this->Croogo->getRelativePath(array(
                'admin' => false,
                'controller' => 'nodes',
                'action' => 'view',
                'type' => $node['Node']['type'],
                'slug' => $node['Node']['slug'],
            ));
            $this->Node->id = false;
            $this->Node->save($node);
        }

        $this->Session->setFlash(__('Paths updated.', true), 'default', array('class' => 'success'));
        $this->redirect(array('action' => 'index'));
    }

    public function admin_delete($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for Node', true), 'default', array('class' => 'error'));
            $this->redirect(array('action'=>'index'));
        }
        if (!isset($this->params['named']['token']) || ($this->params['named']['token'] != $this->params['_Token']['key'])) {
            $blackHoleCallback = $this->Security->blackHoleCallback;
            $this->$blackHoleCallback();
        }
        if ($this->Node->delete($id)) {
            $this->Session->setFlash(__('Node deleted', true), 'default', array('class' => 'success'));
            $this->redirect(array('action'=>'index'));
        }
    }

    public function admin_delete_meta($id = null) {
        $success = false;
        if ($id != null && $this->Node->Meta->delete($id)) {
            $success = true;
        }

        $this->set(compact('success'));
    }

    public function admin_add_meta() {
        $this->layout = 'ajax';
    }

    public function admin_process() {
        $action = $this->data['Node']['action'];
        $ids = array();
        foreach ($this->data['Node'] AS $id => $value) {
            if ($id != 'action' && $value['id'] == 1) {
                $ids[] = $id;
            }
        }

        if (count($ids) == 0 || $action == null) {
            $this->Session->setFlash(__('No items selected.', true), 'default', array('class' => 'error'));
            $this->redirect(array('action' => 'index'));
        }

        if ($action == 'delete' &&
            $this->Node->deleteAll(array('Node.id' => $ids), true, true)) {
            $this->Session->setFlash(__('Nodes deleted.', true), 'default', array('class' => 'success'));
        } elseif ($action == 'publish' &&
            $this->Node->updateAll(array('Node.status' => 1), array('Node.id' => $ids))) {
            $this->Session->setFlash(__('Nodes published', true), 'default', array('class' => 'success'));
        } elseif ($action == 'unpublish' &&
            $this->Node->updateAll(array('Node.status' => 0), array('Node.id' => $ids))) {
            $this->Session->setFlash(__('Nodes unpublished', true), 'default', array('class' => 'success'));
        } elseif ($action == 'promote' &&
            $this->Node->updateAll(array('Node.promote' => 1), array('Node.id' => $ids))) {
            $this->Session->setFlash(__('Nodes promoted', true), 'default', array('class' => 'success'));
        } elseif ($action == 'unpromote' &&
            $this->Node->updateAll(array('Node.promote' => 0), array('Node.id' => $ids))) {
            $this->Session->setFlash(__('Nodes unpromoted', true), 'default', array('class' => 'success'));
        } else {
            $this->Session->setFlash(__('An error occurred.', true), 'default', array('class' => 'error'));
        }

        $this->redirect(array('action' => 'index'));
    }

    public function index($hotelname=NULL,$location=NULL,$starclass=NULL,$category=NULL) {
       $hotelname=$location=$starclass=$hotelId=$subdomain=$category='';
       $domain=$this->getSubdomain();
       if(!empty($domain) && $domain!='demo-hotelms'){
        $this->setLogo($domain);
       }
       $param=$this->params;
       $tag=0;
       $subdomain=$domain;
       if(isset($this->params['data'])){
       	if(isset($this->params['data']['Node']['hotelname'])){
       		$hotelname=$this->params['data']['Node']['hotelname'];
       	}
       	else{	
       		$location=$this->params['data']['Node']['location'];
       		$starclass=$this->params['data']['Node']['starclass'];
       		$category=$this->params['data']['Node']['category'];
       	}
       		$tag=1;
       }
       	$hotelDets=$this->hotelsDets($hotelId,$hotelname,$location,$starclass,$tag,$category,$subdomain);
        $cat=$this->setHotelCategory();
        $category = array();
        $c=0;
        foreach ($cat as $key=>$value){
        	$catego[$c]=$value['HotelsCategoryList']['name'];
        	$c++;
        }
      // debug($cat);
       
       $this->set(compact('hotelDets','catego'));
    }
    
    function bookingindex(){
    	$hotelId=$this->params['pass'][0];
    	$this->Session->write('hotelId',$hotelId);
    	$getHotels=$this->getHotels($hotelId);
        $this->set('hotelid',$hotelId);
        $this->set(compact('getHotels'));
        $roomtypes=$this->getroomtypes($hotelId);
       $rtyp=array();
       foreach ($roomtypes as $key=>$value){
       	$rtyp[$value['HotelsRoomType']['id']]=$value['HotelsRoomType']['name'];
       }
       $rt=$dfrom=$dto=$roomavl='';
    	if(isset($this->data['Node']['tag']) && $this->data['Node']['tag']==1){  		
    		
		    		$rt=$this->data['Node']['roomtype'];
		    		$dfrom=$this->data['Node']['dateFrom'];
		    		$dto=$this->data['Node']['dateTo'];
		    		
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
    
	function getHotels($hotelId=NULL){
		$ht='';
		if(!empty($hotelId)){
			$ht="Hotel.id=$hotelId";
		}
		
		$hotels=$this->Hotel->find('all',array(			
			 'fields' => array(
     				'Hotel.id',
                    'Hotel.`name`'),
		  	'conditions' =>array("$ht"),
		  )
		);
		return $hotels;
		
	}
	
	function getbookingdetails($hotelId=NULL,$rt=NULL,$dfrom=NULL,$dto=NULL,$status=NULL){
		$tbl=$this->Booking->find('all',array(
			'fields'    => array('`Booking`.`status`','`Booking`.`rooms`'),
		    'conditions' => array("`Booking`.`hotel_id`='$hotelId'","Booking.room_type_id='$rt'","Booking.from_date >= '$dfrom'","Booking.end_date <= '$dto'","Booking.status = '$status'"),
		));
		
		return $tbl;
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
	
	function getSubdomain() {
		$domain = parse_url($_SERVER['HTTP_HOST']);
		$domain = explode('.',$domain['path']);
		if(count($domain)==3 and !empty($domain[0]) && $domain[0]!='demo-hotelms') {
		return $domain[0];
		}
		return '';
	}
	
	function setHotelCategory(){
		$cat=$this->HotelsCategoryList->find('all',array(
			'fields'=>array('HotelsCategoryList.`id`','HotelsCategoryList.`name`'),
			'order'=>array('HotelsCategoryList.`name`')
			)
		);
		return $cat;
	}
	function setLogo($domain=NULL){
		if($domain != 'demo-hotelms' && $domain==''){
		$logoDets=$this->Hotel->find('all',array(
        		'fields'=>array('Hotel.subdomain','Hotel.logo','Hotel.id'),
        		'conditions'=>array("Hotel.subdomain='$domain'"),)
        
        );
        	$path="/uploads/hotels/".$logoDets[0]['Hotel']['id']."/".$logoDets[0]['Hotel']['logo'];
       
    		$this->set('logo',$path);
		}
	}
	function hotelsDets($hotelId=NULL,$hotelname=NULL,$location=NULL,$starclass=NULL,$tag=NULL,$category=NULL,$subdomain=NULL){
		$domain=$this->getSubdomain();
       		if(!empty($domain)){
        	$this->setLogo($domain);
       	}
		$hw='';
		if($tag==1){
			if(!empty($hotelname) && !empty($location) && !empty($starclass) && !empty($category))
				$hw=" AND Hotel.name like '%$hotelname%' AND Hotel.address like '%$location%' AND Hotel.starclass = '$starclass' AND Hotel.category = '$category' ";					
			else if(!empty($hotelname) && !empty($location) && !empty($starclass))
				$hw=" AND Hotel.name like '%$hotelname%' AND Hotel.address like '%$location%' AND Hotel.starclass = '$starclass' ";						
			elseif (!empty($hotelname) &&!empty($location) && !empty($category))
				$hw=" AND Hotel.name like '%$hotelname%' AND Hotel.address like '%$location%' AND Hotel.category = '$category'";
			else if(!empty($hotelname) && !empty($starclass) && !empty($category))
				$hw=" AND Hotel.name like '%$hotelname%' AND Hotel.starclass = '$starclass' AND Hotel.category = '$category' ";
			else if(!empty($location)&& !empty($starclass) && !empty($category) )
				$hw=" AND Hotel.address like '%$location%' AND Hotel.starclass = '$starclass' AND Hotel.category = '$category'";
			else if(!empty($hotelname) && !empty($location))
				$hw=" AND Hotel.name like '%$hotelname%' AND Hotel.address like '%$location%'";				
			else if(!empty($hotelname) && !empty($category))
				$hw=" AND Hotel.name like '%$hotelname%' AND Hotel.category = '$category'";
			else if(!empty($hotelname) && !empty($starclass))
				$hw=" AND Hotel.name like '%$hotelname%' AND Hotel.starclass = '$starclass'";
    		else if(!empty($location) && !empty($starclass))
				$hw=" AND Hotel.address like '%$location%' AND Hotel.starclass = '$starclass '";
			else if(!empty($location) && !empty($category))
				$hw=" AND Hotel.address like '%$location%' AND Hotel.category = '$category'";			
			else if(!empty($starclass) && !empty($category))
				$hw=" AND Hotel.starclass like '%$starclass%' AND Hotel.category = '$category'";							
			else if(!empty($hotelname))
				$hw=" AND Hotel.name like '%$hotelname%'";				
			else if(!empty($location))
				$hw=" AND Hotel.address like '%$location%' ";			
			else if(!empty($starclass))
				$hw=" AND Hotel.starclass = '$starclass'";				
			else if(!empty($category))
				$hw=" AND Hotel.category = '$category' ";
				
		}
		else if(!empty($hotelId)) {
			$hw=" AND Hotel.id='$hotelId'";
		}
		else if(!empty($subdomain) && $subdomain!="www"){
			$hw=" AND Hotel.subdomain='$subdomain' ";
		}
		 $this->paginate = array(
        				'fields'=>array('Hotel.id',
        								'Hotel.`name`',
        								'Hotel.address',
        								'Hotel.phone',
        								'Hotel.email',
        								'Hotel.web',
        								'Hotel.contactperson',
										'Hotel.starclass',
		 								'Hotel.logo',
        								'Users.first_name',
										'Users.last_name'),
        				'joins'=>array(
        						
                       	 		array(
		                       		'table' => 'users',
		                        	'alias' => 'Users',
		                        	'type'  => 'LEFT',
		                        	'foreignKey'    => false,
                        			'conditions'    => array('Users.id = Hotel.contactperson'),
                       	 		),
        								
        							   ),
        				'conditions'=>array("Hotel.`status`=1 $hw "),
        				
        				'order'    => array('Hotel.id'    => 'asc'),
        				'limit' =>3
        							   
        			);
        		$loadHotels=$this->paginate('Hotel');
      			return $loadHotels;
	}
	
	function hoteltypedets($hotelId=NULL){
		/*if(empty($hotelId)){
			$hotelId=$this->Session->read('hotelId');
		}*/
		$this->paginate =array(
        				'fields'=>array('Hotel.id',
        								'HotelsRoomType.id',
        								'HotelsRoomType.name',
										'HotelsRoomType.`status`',
										'HotelsRoomType.price',
										'HotelsRoomType.size',
										'HotelsRoomType.info',
										'HotelsRoomType.view',
										'HotelsRoomType.cooling'),
        				'joins'=>array(
        						 array(
		                       		'table' => 'hotels_room_types',
		                        	'alias' => 'HotelsRoomType',
		                        	'type'  => 'INNER',
		                        	'foreignKey'    => false,
                        			'conditions'    => array('Hotel.id = HotelsRoomType.hotel_id'),
                       	 		),        								
        					 ),
        				'conditions'=>array("HotelsRoomType.`status`='APPROVED' AND HotelsRoomType.hotel_id='$hotelId'"),
        				/*'group'=>array('HotelsRoomType.id'),*/
        				'order'    => array('HotelsRoomType.id'    => 'asc'),
        				'limit' =>3
        							   
        			
        	);
      $loadtypes=$this->paginate('Hotel');
      return $loadtypes;
	}
	
	function gethotelpictures($hotelId=NULL){
	/*if(empty($hotelId)){
			$hotelId=$this->Session->read('hotelId');
	}*/
	$loadHotelspics=$this->Hotel->find('all',
        			array(
        				'fields'=>array('Hotel.id',
        								'HotelsPicture.id',
        								'HotelsPicture.picture'),
        				'joins'=>array(
        						 array(
		                       		'table' => 'hotels_pictures',
		                        	'alias' => 'HotelsPicture',
		                        	'type'  => 'LEFT',
		                        	'foreignKey'    => false,
                        			'conditions'    => array('Hotel.id = HotelsPicture.hotel_id'),
                       	 		),
                       	 		
        								
        							   ),
        				'conditions'=>array("Hotel.`status`=1 AND Hotel.id= '$hotelId'"),
        				'group'=>array('HotelsPicture.id'),
        				'order'    => array('HotelsPicture.id'    => 'asc')
        							   
        			)
        	);
      return $loadHotelspics;
	}
	
	function popuproomdetails($hotelId=NULL,$roomtype=NULL){
		
		$hotelId=$this->params['pass'][0]; 
		$roomtype=$this->params['pass'][1];
		$roomTypeDetails=$this->getroomtypedetails($hotelId,$roomtype);
		//debug($roomTypeDetails);
		
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
	
	function getroomtypedetails($hotelId=NULL,$roomtype=NULL){
		$rTypeDes=$this->HotelsRoomType->find('all',array(
			'fields'=>array(
					'Hotel.name',
					'HotelsRoomType.id',
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
	function searchhotels(){
		$this->layout='default';
		$this->render('index');
		
		$hotelDets=$this->hotelsDets();
		//debug($hotelDets);
        $this->set(compact('hotelDets'));
	}

	function hoteldetails($hotelId=NULL){
		if(!isset($this->params['pass'][0])){
			$hotelId=$this->data['Node']['hotelid'];
		}
		$hotelId=$this->params['pass'][0];
		$this->Session->write('hotelId',$hotelId);
		$hotelId=$this->Session->read('hotelId');
		
		$hoteldets=$this->hotelsDets($hotelId);
		
		$hoteltypedets=$this->hoteltypedets($hotelId);
		$loadHotelspics=$this->gethotelpictures($hotelId);
		$roomopt=array();
		for($i=0;$i<count($hoteltypedets);$i++){
			$rid=$hoteltypedets[$i]['HotelsRoomType']['id'];
			$name=$hoteltypedets[$i]['HotelsRoomType']['name'];
			$roomopt[$rid]=$name;
		}
		$this->set('hotelid',$hotelId);
		$this->set('roomopt',$roomopt);
		
		$this->set(compact('hoteldets','hoteltypedets','loadHotelspics'));
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
	
	
	function getroomtypes($hotelId=NULL){
		
		$roomtypes=$this->HotelsRoomType->find('all',array(			
			 'fields' => array(
     				'HotelsRoomType.id',
                    'HotelsRoomType.`name`'),
		  	'conditions' =>array("HotelsRoomType.hotel_id=$hotelId" ),
		  )
		);
		return $roomtypes;
	}
	
	/* booking steps */
	/* booking step one */
	function stepone(){
	$domain=$this->getSubdomain();
       if(!empty($domain)){
        $this->setLogo($domain);
       }
		$params=$this->params;
		//$hotelId=$this->Session->read('hotelId');
		$hotelId=$params['pass'][0];
		$noOfRooms=$this->data['Nodes']['roomcount'];
		$fromDate=$this->data['Nodes']['fromDate'];
		$toDate=$this->data['Nodes']['toDate'];
		$selectedroomnos=$this->data['Nodes']['roomnos'];
		$rtId=$this->data['Nodes']['rtype'];
		$roomDes=$this->getRoomTypeDets($hotelId,$rtId);
		$this->set('fromDate',$fromDate);
		$this->set('toDate',$toDate);
		$this->set('nsr',$noOfRooms);
		$this->set('nsrooms',substr($selectedroomnos,0,strlen($selectedroomnos)-1));
		$this->set(compact('roomDes'));
		
	}
	/* booking step two */
	function steptwo(){
	$domain=$this->getSubdomain();
       if(!empty($domain)){
        $this->setLogo($domain);
       }
		$params=$this->params;
		
		//$hotelId=$this->Session->read('hotelId');
		$hotelId=$params['pass'][0];
		$rtId=$params['data']['Nodes']['room_type'];
		$dateFrom=$params['data']['Nodes']['fromdate'];
		$dateTo=$params['data']['Nodes']['todate'];
		$noOfSelectedRooms=$params['data']['Nodes']['nofselectedrooms'];
		$selectedrooms=$params['data']['Nodes']['selectedrooms'];
		$additionalAdults=$params['data']['Nodes']['max_adults'];
		$additionalChildren=$params['data']['Nodes']['max_children'];
		$coupon=$params['data']['Nodes']['coupon'];
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
		$this->set('dateFrom',$dateFrom);
		$this->set('dateTo',$dateTo);
		$this->set('noOfSelectedRooms',$noOfSelectedRooms);
		$this->set('selectedrooms',$selectedrooms);
		$this->set('additionalAdults',$additionalAdults);		
		$this->set('additionalChildren',$additionalChildren);
		$this->set('cd',$cd);	
		$this->set('cid',$cid);	
		$roomDes=$this->getRoomTypeDets($hotelId,$rtId);
		$this->set(compact('roomDes'));
		
	}
	/* booking step stepthree */

	function stepthree(){
	$domain=$this->getSubdomain();
       if(!empty($domain)){
        $this->setLogo($domain);
       }
		
		
		$nofr=$this->params['data']['Nodes']['nofselectedrooms'];
		$noofdays=$this->params['data']['Nodes']['nofselecteddays'];
		$selectedrooms=$this->params['data']['Nodes']['selectedrooms'];
		$cd=$this->params['data']['Nodes']['coupondeduction']; 
		$aac=$this->params['data']['Nodes']['maxadults']; 
		
		
		$acc=$this->params['data']['Nodes']['maxchildren'];
		
		
		$rt=$this->params['data']['Nodes']['room_type'];
		$hotel=$this->Session->read('hotelId');
		$aacp=$this->getAddChages($hotel,$rt,'additional_adult_charge');
		$accp=$this->getAddChages($hotel,$rt,'additional_child_charge');
		
		$aacp=$aacp[0]['HotelsRoomCapacities']['additional_adult_charge'];
		$accp=$accp[0]['HotelsRoomCapacities']['additional_child_charge'];
		
		$det=$this->HotelsRoomType->find('all',array(
			'fields'=>array('HotelsRoomType.price','HotelsRoomType.name'
							),
			
					 'conditions' =>array("HotelsRoomType.hotel_id='$hotel'","HotelsRoomType.id='$rt';" ),
			)
		);

		$p=$det[0]['HotelsRoomType']['price'];
		$rname=$det[0]['HotelsRoomType']['name'];
		$rtype=$this->params['data']['Nodes']['room_type'];
		$estimated_price=((($nofr*$p)+($aacp*$aac)+($accp*$acc))*$noofdays)*((100-$cd)/100);
		$user=$this->Auth->user('id');
		$this->data['Booking']['user_id'] = 0 ;
		$this->data['Booking']['hotel_id'] = $this->Session->read('hotelId');
        $this->data['Booking']['room_type_id'] = $this->params['data']['Nodes']['room_type'];
        $this->data['Booking']['from_date'] = $this->params['data']['Nodes']['dateFrom']; 
        $this->data['Booking']['end_date'] = $this->params['data']['Nodes']['dateTo'];
        $this->data['Booking']['number_of_rooms'] = $this->params['data']['Nodes']['nofselectedrooms'];
        $this->data['Booking']['estimated_price'] = $estimated_price;
        $this->data['Booking']['coupon_id'] = $this->params['data']['Nodes']['couponid'];
        $this->data['Booking']['notes'] = 'n';
        $this->data['Booking']['status'] = "PROCESSING";
        $this->data['Booking']['rtype'] = $rname;
        $this->data['Booking']['adchrg']=$aacp*$aac;
        $this->data['Booking']['acchrg']=$accp*$acc;
        $this->data['Booking']['rooms']=$selectedrooms;
         $ticket=$this->Session->read('ticket');
        $ticketavl='';
        //echo $hotel.$ticket;
        if(!empty($ticket)){
        	
        	$ticketavl=$this->Booking->find('all',array(
        	'fields'=>array('count(*) as c'),
        	'conditions'=>array("Booking.id=$ticket"),
        	));
        	
        	if($ticketavl[0][0]['c'] > 0){
        	 	$dets=$this->getticketdet($hotel,$rtype);	
        	 	$this->set('rID',$ticket);	   
	        	$this->set(compact('dets','dFrom','dTo','noofdays','estimated_price','rtype'));
	        	 $ht=$this->Hotel->find('all',array(
				'fields'=>array('Hotel.name',
								),
				
						 'conditions' =>array("Hotel.id='$hotel'" ),
				)
				);
				$ht=$ht[0]['Hotel']['name'];
				$this->set('hotelName',$ht);
	        	$this->Session->setFlash(__( 'Your already have a ticket.', true)); 
        	}
        }
        else{
        	if($this->Booking->save($this->data)){
        		$bID=$this->Booking->getInsertID();
	        	$this->Session->write('ticket',$bID);
        	    $ht=$this->Hotel->find('all',array(
				'fields'=>array('Hotel.name',
								),
				
						 'conditions' =>array("Hotel.id='$hotel'" ),
				)
				);
			$ht=$ht[0]['Hotel']['name'];
			$this->set('hotelName',$ht);
			$this->_sendNewUserMail( $this->data);
        	
        	}
        	else{}
        }        
        
         
        
		
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
	function getAddChages($hotelId=NULL,$rt=NULL,$col=NULL){
		$chr=$this->HotelsRoomCapacities->find('all',array(
		'fields'=>array("HotelsRoomCapacities.`$col`"),
		'conditions' =>array("HotelsRoomCapacities.hotel_id='$hotelId'","HotelsRoomCapacities.room_type_id='$rt';" ),
		));
		return $chr;
	}
	function _sendNewUserMail($data) {
		
	   // $User = $this->User->read(null,$id);
	    $this->Email->to = $data['Booking']['email'];
	    $this->Email->bcc = array('lasantha@loooops.com');  
	    $this->Email->subject = 'Welcome to Hotel Management System';
	    $this->Email->replyTo = 'lasantha@loooops.com';
	    $this->Email->from = 'HotelMS <lasantha@loooops.com>';
	    $this->Email->template = 'simple_message'; // note no '.ctp'
	    //Send as 'html', 'text' or 'both' (default is 'text')
	    $this->Email->sendAs = 'html'; // because we like to send pretty mail
	    //Set view variables as normal
	    
	    $this->set('User', $data['Booking']['name']);
	    $em=$data['Booking']['email'];
	    $this->set('cemail',$em);
	    $phone=$data['Booking']['contactno'];
	    $this->set('phone',$phone);
	    $rtype=$data['Booking']['rtype'];
	    $this->set('rtype',$rtype);
	    $fdate=$data['Booking']['from_date'];
	    $this->set('fdate',$fdate);
	    $edate=$data['Booking']['end_date'];
	    $this->set('edate',$edate);
	    $rooms=$data['Booking']['number_of_rooms'];
	    $this->set('rooms',$rooms);
	    $aac=$data['Booking']['adchrg'];
	    $this->set('aac',$aac);
	    $acc=$data['Booking']['acchrg'];
	    $this->set('aac',$acc);
	    $estprice=$data['Booking']['estimated_price'];
	    $this->set('estprice',$estprice);
	    //Do not pass any args to send()
	    $this->Email->send();
	 }

	
	
	function getRoomTypeDets($hotelId=NULL,$rtId=NULL){
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
							'Hotel.`name`','Hotel.id'),
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
    public function term() {
        $term = $this->Node->Taxonomy->Term->find('first', array(
            'conditions' => array(
                'Term.slug' => $this->params['named']['slug'],
            ),
            'cache' => array(
                'name' => 'term_'.$this->params['named']['slug'],
                'config' => 'nodes_term',
            ),
        ));
        if (!isset($term['Term']['id'])) {
            $this->Session->setFlash(__('Invalid Term.', true), 'default', array('class' => 'error'));
            $this->redirect('/');
        }

        if (!isset($this->params['named']['type'])) {
            $this->params['named']['type'] = 'node';
        }

        $this->paginate['Node']['order'] = 'Node.created DESC';
        $this->paginate['Node']['limit'] = Configure::read('Reading.nodes_per_page');
        $this->paginate['Node']['conditions'] = array(
            'Node.status' => 1,
            'Node.terms LIKE' => '%"' . $this->params['named']['slug'] . '"%',
            'OR' => array(
                'Node.visibility_roles' => '',
                'Node.visibility_roles LIKE' => '%"' . $this->Croogo->roleId . '"%',
            ),
        );
        $this->paginate['Node']['contain'] = array(
            'Meta',
            'Taxonomy' => array(
                'Term',
                'Vocabulary',
            ),
            'User',
        );
        if (isset($this->params['named']['type'])) {
            $type = $this->Node->Taxonomy->Vocabulary->Type->find('first', array(
                'conditions' => array(
                    'Type.alias' => $this->params['named']['type'],
                ),
                'cache' => array(
                    'name' => 'type_'.$this->params['named']['type'],
                    'config' => 'nodes_term',
                ),
            ));
            if (!isset($type['Type']['id'])) {
                $this->Session->setFlash(__('Invalid content type.', true), 'default', array('class' => 'error'));
                $this->redirect('/');
            }
            if (isset($type['Params']['nodes_per_page'])) {
                $this->paginate['Node']['limit'] = $type['Params']['nodes_per_page'];
            }
            $this->paginate['Node']['conditions']['Node.type'] = $type['Type']['alias'];
            $this->set('title_for_layout', $term['Term']['title']);
        }

        if ($this->usePaginationCache) {
            $cacheNamePrefix = 'nodes_term_'.$this->Croogo->roleId.'_'.$this->params['named']['slug'].'_'.Configure::read('Config.language');
            if (isset($type)) {
                $cacheNamePrefix .= '_'.$type['Type']['alias'];
            }
            $this->paginate['page'] = isset($this->params['named']['page']) ? $this->params['named']['page'] : 1;
            $cacheName = $cacheNamePrefix.'_'.$this->paginate['page'].'_'.$this->paginate['Node']['limit'];
            $cacheNamePaging = $cacheNamePrefix.'_'.$this->paginate['page'].'_'.$this->paginate['Node']['limit'].'_paging';
            $cacheConfig = 'nodes_term';
            $nodes = Cache::read($cacheName, $cacheConfig);
            if (!$nodes) {
                $nodes = $this->paginate('Node');
                Cache::write($cacheName, $nodes, $cacheConfig);
                Cache::write($cacheNamePaging, $this->params['paging'], $cacheConfig);
            } else {
                $paging = Cache::read($cacheNamePaging, $cacheConfig);
                $this->params['paging'] = $paging;
                $this->helpers[] = 'Paginator';
            }
        } else {
            $nodes = $this->paginate('Node');
        }

        $this->set(compact('term', 'type', 'nodes'));
        $this->__viewFallback(array(
            'term_' . $term['Term']['id'],
            'term_' . $type['Type']['alias'],
        ));
    }

    public function promoted() {
        $this->set('title_for_layout', __('Nodes', true));
		$this->layout = "limejungle";

        $this->paginate['Node']['order'] = 'Node.created DESC';
        $this->paginate['Node']['limit'] = Configure::read('Reading.nodes_per_page');
        $this->paginate['Node']['conditions'] = array(
            'Node.status' => 1,
            'Node.promote' => 1,
            'OR' => array(
                'Node.visibility_roles' => '',
                'Node.visibility_roles LIKE' => '%"' . $this->Croogo->roleId . '"%',
            ),
        );
        $this->paginate['Node']['contain'] = array(
            'Meta',
            'Taxonomy' => array(
                'Term',
                'Vocabulary',
            ),
            'User',
        );

        if (isset($this->params['named']['type'])) {
            $type = $this->Node->Taxonomy->Vocabulary->Type->findByAlias($this->params['named']['type']);
            if (!isset($type['Type']['id'])) {
                $this->Session->setFlash(__('Invalid content type.', true), 'default', array('class' => 'error'));
                $this->redirect('/');
            }
            if (isset($type['Params']['nodes_per_page'])) {
                $this->paginate['Node']['limit'] = $type['Params']['nodes_per_page'];
            }
            $this->paginate['Node']['conditions']['Node.type'] = $type['Type']['alias'];
            $this->set('title_for_layout', $type['Type']['title']);
            $this->set(compact('type'));
        }

        if ($this->usePaginationCache) {
            $cacheNamePrefix = 'nodes_promoted_'.$this->Croogo->roleId.'_'.Configure::read('Config.language');
            if (isset($type)) {
                $cacheNamePrefix .= '_'.$type['Type']['alias'];
            }
            $this->paginate['page'] = isset($this->params['named']['page']) ? $this->params['named']['page'] : 1;
            $cacheName = $cacheNamePrefix.'_'.$this->paginate['page'].'_'.$this->paginate['Node']['limit'];
            $cacheNamePaging = $cacheNamePrefix.'_'.$this->paginate['page'].'_'.$this->paginate['Node']['limit'].'_paging';
            $cacheConfig = 'nodes_promoted';
            $nodes = Cache::read($cacheName, $cacheConfig);
            if (!$nodes) {
                $nodes = $this->paginate('Node');
                Cache::write($cacheName, $nodes, $cacheConfig);
                Cache::write($cacheNamePaging, $this->params['paging'], $cacheConfig);
            } else {
                $paging = Cache::read($cacheNamePaging, $cacheConfig);
                $this->params['paging'] = $paging;
                $this->helpers[] = 'Paginator';
            }
        } else {
            $nodes = $this->paginate('Node');
        }
        $this->set(compact('nodes'));
    }

    public function search($typeAlias = null) {
        if (!isset($this->params['named']['q'])) {
            $this->redirect('/');
        }

        App::import('Core', 'Sanitize');
        $q = Sanitize::clean($this->params['named']['q']);
        $this->paginate['Node']['order'] = 'Node.created DESC';
        $this->paginate['Node']['limit'] = Configure::read('Reading.nodes_per_page');
        $this->paginate['Node']['conditions'] = array(
            'Node.status' => 1,
            'AND' => array(
                array(
                    'OR' => array(
                        'Node.title LIKE' => '%' . $q . '%',
                        'Node.excerpt LIKE' => '%' . $q . '%',
                        'Node.body LIKE' => '%' . $q . '%',
                        'Node.terms LIKE' => '%"' . $q . '"%',
                    ),
                ),
                array(
                    'OR' => array(
                        'Node.visibility_roles' => '',
                        'Node.visibility_roles LIKE' => '%"' . $this->Croogo->roleId . '"%',
                    ),
                ),
            ),
        );
        $this->paginate['Node']['contain'] = array(
            'Meta',
            'Taxonomy' => array(
                'Term',
                'Vocabulary',
            ),
            'User',
        );
        if ($typeAlias) {
            $type = $this->Node->Taxonomy->Vocabulary->Type->findByAlias($typeAlias);
            if (!isset($type['Type']['id'])) {
                $this->Session->setFlash(__('Invalid content type.', true), 'default', array('class' => 'error'));
                $this->redirect('/');
            }
            if (isset($type['Params']['nodes_per_page'])) {
                $this->paginate['Node']['limit'] = $type['Params']['nodes_per_page'];
            }
            $this->paginate['Node']['conditions']['Node.type'] = $typeAlias;
        }

        $nodes = $this->paginate('Node');
        $this->set('title_for_layout', sprintf(__('Search Results: %s', true), $q));
        $this->set(compact('q', 'nodes'));
        if ($typeAlias) {
            $this->__viewFallback(array(
                'search_' . $typeAlias,
            ));
        }
    }

    public function view($id = null) {
        if (isset($this->params['named']['slug']) && isset($this->params['named']['type'])) {
            $this->Node->type = $this->params['named']['type'];
            $type = $this->Node->Taxonomy->Vocabulary->Type->find('first', array(
                'conditions' => array(
                    'Type.alias' => $this->Node->type,
                ),
                'cache' => array(
                    'name' => 'type_'.$this->Node->type,
                    'config' => 'nodes_view',
                ),
            ));
            $node = $this->Node->find('first', array(
                'conditions' => array(
                    'Node.slug' => $this->params['named']['slug'],
                    'Node.type' => $this->params['named']['type'],
                    'Node.status' => 1,
                    'OR' => array(
                        'Node.visibility_roles' => '',
                        'Node.visibility_roles LIKE' => '%"' . $this->Croogo->roleId . '"%',
                    ),
                ),
                'contain' => array(
                    'Meta',
                    'Taxonomy' => array(
                        'Term',
                        'Vocabulary',
                    ),
                    'User',
                ),
                'cache' => array(
                    'name' => 'node_'.$this->Croogo->roleId.'_'.$this->params['named']['slug'],
                    'config' => 'nodes_view',
                ),
            ));
        } elseif ($id == null) {
            $this->Session->setFlash(__('Invalid content', true), 'default', array('class' => 'error'));
            $this->redirect('/');
        } else {
            $node = $this->Node->find('first', array(
                'conditions' => array(
                    'Node.id' => $id,
                    'Node.status' => 1,
                    'OR' => array(
                        'Node.visibility_roles' => '',
                        'Node.visibility_roles LIKE' => '%"' . $this->Croogo->roleId . '"%',
                    ),
                ),
                'contain' => array(
                    'Meta',
                    'Taxonomy' => array(
                        'Term',
                        'Vocabulary',
                    ),
                    'User',
                ),
                'cache' => array(
                    'name' => 'node_'.$this->Croogo->roleId.'_'.$id,
                    'config' => 'nodes_view',
                ),
            ));
            $this->Node->type = $node['Node']['type'];
            $type = $this->Node->Taxonomy->Vocabulary->Type->find('first', array(
                'conditions' => array(
                    'Type.alias' => $this->Node->type,
                ),
                'cache' => array(
                    'name' => 'type_'.$this->Node->type,
                    'config' => 'nodes_view',
                ),
            ));
        }

        if (!isset($node['Node']['id'])) {
            $this->Session->setFlash(__('Invalid content', true), 'default', array('class' => 'error'));
            $this->redirect('/');
        }

        if ($node['Node']['comment_count'] > 0) {
            $comments = $this->Node->Comment->find('threaded', array(
                'conditions' => array(
                    'Comment.node_id' => $node['Node']['id'],
                    'Comment.status' => 1,
                ),
                'contain' => array(
                    'User',
                ),
                'cache' => array(
                    'name' => 'comment_node_'.$node['Node']['id'],
                    'config' => 'nodes_view',
                ),
            ));
        } else {
            $comments = array();
        }

        $this->set('title_for_layout', $node['Node']['title']);
        $this->set(compact('node', 'type', 'comments'));
        $this->__viewFallback(array(
            'view_' . $node['Node']['id'],
            'view_' . $type['Type']['alias'],
        ));
    }

    private function __viewFallback($views) {
        if (is_string($views)) {
            $views = array($views);
        }

        if ($this->theme) {
            foreach ($views AS $view) {
                $viewPath = APP.'views'.DS.'themed'.DS.$this->theme.DS.Inflector::underscore($this->name).DS.$view.$this->ext;
                if (file_exists($viewPath)) {
                    return $this->render($view);
                }
            }
        }
    }
    
    public function partners(){
    	$this->paginate =array(
        				'fields'=>array('Hotel.id',
        								'Hotel.logo',
        								'Hotel.name'),
        				'conditions'=>array("Hotel.status"=>1),
        							   
        			
        	);
     $this->set('hotels',$this->paginate('Hotel'));
    }

}
?>