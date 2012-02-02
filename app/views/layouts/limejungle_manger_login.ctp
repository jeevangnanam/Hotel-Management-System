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
            '/js/jquery/jquery-ui-1.8.16.custom/css/ui-lightness/jquery-ui-1.8.16.custom'
        ));
        echo $html->script(array(
            'jquery/jquery.hoverIntent.minified',
            'jquery/superfish',
            'jquery/supersubs',
            'theme',
            'jquery/jquery-ui-1.8.16.custom/js/jquery-ui-1.8.16.custom.min'
        ));
        echo $scripts_for_layout;
    ?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="/templates/limejungle/css/style.css" rel="stylesheet" type="text/css" />
<!-- CuFon: Enables smooth pretty custom font rendering. 100% SEO friendly. To disable, remove this section -->
<script type="text/javascript" src="/templates/limejungle/js/cufon-yui.js"></script>
<script type="text/javascript" src="/templates/limejungle/js/arial.js"></script>
<script type="text/javascript" src="/templates/limejungle/js/cuf_run.js"></script>
<script type="text/javascript" src="/templates/limejungle/js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="/templates/limejungle/js/radius.js"></script>
<!-- CuFon ends -->
</head>
<body>
<?php

	$murl='';
	$ses=$this -> Session -> read();
	if(isset($ses['Auth']['User']['role_id'])){
	$userid=$ses['Auth']['User']['role_id'];
		if($userid==2){
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
      <div class="logo fbg_resize" style="width:890px;background-color: #FFF;margin:5px 0px 5px 0px; " ><h1><a href="index.html"><img src="/templates/limejungle/images/png/logo_6.png" /> </a></h1></div>
      <div class="clr"></div>
      <!--<div class="menu_nav">
        <ul>
          <li class="active"><a href="/">Home</a></li>
          <li><a href="support">Users</a></li>
          <li><a href="<?=$murl;?>">HotelManagers</a></li>
          <li><a href="blog">Promotions</a></li>
          <li><a href="/contact/">Contact Us</a></li>
        </ul>
        <div class="searchform">
          <form id="formsearch" name="formsearch" method="post" action="">
            <span><input name="editbox_search" class="editbox_search" id="editbox_search" maxlength="80" value="Search our ste:" type="text" /></span>
            <input name="button_search" src="/templates/limejungle/images/search_btn.gif" class="button_search" type="image" />
          </form>
        </div>
      </div>-->
      <div class="clr"></div>
      <img src="/templates/limejungle/images/hbg_img.jpg" width="970" height="260" alt="image" />
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
          <h2>&nbsp;</h2><div class="clr"></div>
          <p>&nbsp;</p>
        </div>
      </div>
      <div class="sidebar">
        <div class="gadget">
          
        </div>
      </div>
      <div class="clr"></div>
    </div>
  </div>

  <div class="fbg">
    
      <div class="clr">&nbsp;</div>
    </div>
  </div>
  <div class="footer">
    <div class="footer_resize">
      <p class="lf">&copy; Copyright <a href="#">Loooops 2011</a><a href="#"></a></p>
      <ul class="fmenu">
        <li class="active"><a href="#">Home</a></li>
        <li><a href="#">Support</a></li>
        <li><a href="#">Blog</a></li>
        <li><a href="#">About Us</a></li>
        <li><a href="#">Contacts</a></li>
      </ul>
      <div class="clr"></div>
    </div>
  </div>
</div>
</body>
</html>
<?php echo $this->element('sql_dump'); ?>