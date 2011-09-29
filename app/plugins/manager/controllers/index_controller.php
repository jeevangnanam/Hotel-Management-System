<?php

class IndexController extends ManagerAppController{
    
    var $uses = array();
   
    
    function beforeFilter(){
        
        $this->Auth->allow('index','login','add');
        $this->Auth->userScope = array('User.status' => 1,'User.role_id' => 2);
        $this->Auth->loginAction = "/manager/index/login";
        $this->Auth->loginRedirect = array( 'controller' => 'index', 'action' => 'dashboard', 'home');
        
    }
    function index(){
        
       //$this->Auth->user('id');
    }
    
    
    function login()
{
        
       
            
          
           if($this->Auth->isAuthorized()){
                $this->redirect("/manager/index/dashboard");
           }
        
}
 function dashboard(){}
function logout(){
    $this->Session->setFlash('Logout');
    $this->redirect($this->Auth->logout());
}
}
?>
