<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $title_for_layout; ?> &raquo; <?php echo Configure::read('Site.title'); ?></title>
    <?php
        echo $layout->meta();
        echo $layout->feed();
        echo $html->script(array('jquery/jquery-ui-1.8.16.custom/js/jquery-1.6.2.min'));
        echo $layout->js();
        echo $html->css(array(
            'reset',
            '960',
            'theme',
            '/js/jquery/jquery-ui-1.8.16.custom/css/ui-lightness/jquery-ui-1.8.16.custom',
			'hotelmanager.css',
			'popup.css',
			'basic'
        ));
        echo $html->script(array(
            'jquery/jquery.hoverIntent.minified',
            'jquery/superfish',
            'jquery/supersubs',
            'theme',
            'jquery/jquery-ui-1.8.16.custom/js/jquery-ui-1.8.16.custom.min',
			'/js/image_upload/jquery.imgareaselect-0.3.min',
			'popup.js'
        ));
        echo $scripts_for_layout;
    ?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="/templates/limejungle/css/style.css" rel="stylesheet" type="text/css" />
<!-- CuFon: Enables smooth pretty custom font rendering. 100% SEO friendly. To disable, remove this section -->
<script type="text/javascript" src="/templates/limejungle/js/cufon-yui.js"></script>
<script type="text/javascript" src="/templates/limejungle/js/arial.js"></script>
<script type="text/javascript" src="/templates/limejungle/js/cuf_run.js"></script>
<!--<script type="text/javascript" src="/templates/limejungle/js/jquery-1.3.2.min.js"></script>-->
<script type="text/javascript" src="/templates/limejungle/js/radius.js"></script>
<!-- CuFon ends -->
<script>

$(document).ready(function(){

$('#tabs').tabs();

$( "#tabs" ).tabs({ selected: <?=(isset($tab))?$tab:"0";?> });



$( 'html, body' ).animate( { scrollTop: 0 }, 0 );
});



</script>
<style>
.content .mainbar{
	float: left;
    margin: 0;
    padding: 0;
    width: 100%;
}

.content_resize {
    background: url("../images/content_bg.gif") repeat-y scroll center top transparent;
    margin: 0 auto;
    padding: 0;
    width: 970px;}
.content .mainbar .article {
    border-bottom: 1px solid #EFEFEF;
    min-height: 520px;
    margin: 0;
    padding: 8px 24px 8px 40px;

}
.logo{
	width:200pcx;
	height:80px;
}
.logingpanel{
	float: right;
    height: 32px;
    margin: -24px 0 0;
    width: auto;
	
}
.leftcorner{
	background:url(<?php echo $html->webroot;?>img/login_panel/tab_l.png) no-repeat scroll 0 0 transparent;
    float: left;
    height: 32px;
    width: 30px;
}
.rightcorner{
	background:url(<?php echo $html->webroot;?>img/login_panel/tab_r.png) no-repeat scroll 0 0 transparent;
    float: left;
    height: 32px;
    width: 30px;
}
.logindetailarea{
	float: left;
	background:url(<?php echo $html->webroot;?>img/login_panel/tab_m.png) repeat-x;
	padding-top:10px;
	height: 32px;
    width: auto;
}
</style>
</head>
<body>
<?php $dlogo='/templates/limejungle/images/png/logo_6.png';//logo.png
	if(empty($logo)){
		$logo=$dlogo;
	}
	$murl='/manager/index/login';
	$username="";
	$ses=$this -> Session -> read();
	if(isset($ses['Auth']['User']['role_id'])){
	$userid=$ses['Auth']['User']['role_id'];
	
	
	if($userid==2){
		$username=$ses['Auth']['User']['name'];
		$murl="/manager/index/";
	}
	else{
		$murl="/manager/index/login";
	}
}
?>
<div class="main">

  <div class="header">
    <div class="header_resize">
      <div class="logo fbg_resize" style="width:890px;background-color: #FFF;margin:5px 0px 5px 0px; " >
      <?php if(!empty($username)){?>
      <div class="logingpanel">
      <div class="leftcorner"></div>
      <div class="logindetailarea">Your Login as <?=$username?> | <?=$this->Html->link('Logout', '/manager/index/logout', array('class' => 'button', 'target' => '_self'));?></div>
      <div class="rightcorner"></div>
      </div>
      <?php }?>
      <h1><a href="/"><img src="<?=$logo;?>" class="logo" /> </a></h1></div>
      <div class="clr"></div>
    </div>
  </div>

  <div class="content">
    <div class="content_resize">
      <div class="mainbar">    
        <div class="article">
        <?php
                $layout->sessionFlash();
                echo $content_for_layout;
            ?>
          
        </div>
        
        
      </div>
      <div class="clr"></div>
    </div>
  </div>

<!--  <div class="fbg">
    <div class="fbg_resize">
      <div class="clr"></div>
    </div>
  </div>-->
  
  <div class="footer">
    <div class="footer_resize">
      <p class="lf">&copy; Copyright <a href="#">Loooops Selects</a><!--. Layout by [Z] <a href="http://www.freewebsitetemplatez.com/">Website Templates</a>--></p>
      <ul class="fmenu">
        <!--<li class="active"><a href="/">Home</a></li>
        <li><a href="#">Support</a></li>
        <li><a href="#">Blog</a></li>
        <li><a href="#">About Us</a></li>
        <li><a href="/contact/">Contacts</a></li>
        <li><a href="/nodes/partners">Partner Hotels</a></li> -->
		<?php echo $this->Layout->menu('footer', array('dropdown' => true)); ?>
      </ul>
      
      <div class="clr"></div>
    </div>
  </div>
</div>
</body>
</html>
<?php echo $this->element('sql_dump'); ?>