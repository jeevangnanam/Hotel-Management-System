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
<div class="main">

  <div class="header">
    <div class="header_resize">
      <div class="logo fbg_resize" style="width:890px;background-color: #FFF;margin:5px 0px 5px 0px; " ><h1><a href="index.html"><img src="/templates/limejungle/images/logo.png" /> </a></h1></div>
      <div class="clr"></div>
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
          <h2 class="star"><span>Help topics</span></h2><div class="clr"></div>
          <ul class="sb_menu">
            <li><a href="#">Who can register?</a></li>
            <li><a href="#">Registration faq</a></li>
            <li><a href="#">Quick contact regarding registration</a></li>
            <li><a href="#">Travel blog</a></li>
            <li><a href="#">Tourism stats</a></li>
            <li><a href="http://www.dreamtemplate.com/">Customer testimonials</a></li>
          </ul>
        </div>
      </div>
      <div class="clr"></div>
    </div>
  </div>

  <div class="fbg">
    <div class="fbg_resize">
      <div class="col c1">
        <h2><span>Image Gallery</span></h2>
        <a href="#"><img src="/templates/limejungle/images/pix1.jpg" width="58" height="58" alt="pix" /></a>
        <a href="#"><img src="/templates/limejungle/images/pix2.jpg" width="58" height="58" alt="pix" /></a>
        <a href="#"><img src="/templates/limejungle/images/pix3.jpg" width="58" height="58" alt="pix" /></a>
        <a href="#"><img src="/templates/limejungle/images/pix4.jpg" width="58" height="58" alt="pix" /></a>
        <a href="#"><img src="/templates/limejungle/images/pix5.jpg" width="58" height="58" alt="pix" /></a>
        <a href="#"><img src="/templates/limejungle/images/pix6.jpg" width="58" height="58" alt="pix" /></a>
      </div>
      <div class="col c2">
        <h2><span>Lorem Ipsum</span></h2>
        <p>Lorem ipsum dolor<br />Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec libero. Suspendisse bibendum. Cras id urna. <a href="#">Morbi tincidunt, orci ac convallis aliquam</a>, lectus turpis varius lorem, eu posuere nunc justo tempus leo. Donec mattis, purus nec placerat bibendum, dui pede condimentum odio, ac blandit ante orci ut diam.</p>
      </div>
      <div class="col c3">
        <h2><span>Contact</span></h2>
        <p>Praesent dapibus, neque id cursus faucibus, tortor neque egestas augue.</p>
        <p><a href="mailto:support@yoursite.com">support@yoursite.com</a></p>
        <p>+1 (123) 444-5677<br />+1 (123) 444-5678</p>
        <p>Address: 123 TemplateAccess Rd1</p>
      </div>
      <div class="clr"></div>
    </div>
  </div>
  <div class="footer">
    <div class="footer_resize">
      <p class="lf">&copy; Copyright <a href="#">Loooops 2011</a><a href="http://www.freewebsitetemplatez.com/"></a></p>
      <ul class="fmenu">
        <li class="active"><a href="index.html">Home</a></li>
        <li><a href="support.html">Support</a></li>
        <li><a href="blog.html">Blog</a></li>
        <li><a href="about.html">About Us</a></li>
        <li><a href="contact.html">Contacts</a></li>
      </ul>
      <div class="clr"></div>
    </div>
  </div>
</div>
</body>
</html>
<?php echo $this->element('sql_dump'); ?>