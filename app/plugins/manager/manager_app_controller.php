<?php
class ManagerAppController extends AppController {
    
    
    var $components = array('Auth');
    
    
    function beforeFilter() {     
        
       $this->Auth->loginAction = "/manager/index/login";
       $this->Auth->loginRedirect = array( 'controller' => 'index', 'action' => 'dashboard', 'home');
       $this->Auth->authorize = 'controller';  
        }

}
?>