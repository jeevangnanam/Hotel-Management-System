<style>
.contact-frm{
	margin: 0 30px;
}
.contact-form{
	float:left;	
}
.contact-categories{
	margin: 10px 10px 0;
	float:left;
	height:auto;
	width:95%;
}
.contact-us{
	float:left;
	background:url("/img/contact_form/contact-us.jpg") repeat scroll 0 0 transparent;
	height: 64px;
    margin: 0 10px;
    width: 308px;
}
.inq{
	float:left;
	background:url("/img/contact_form/quick-inq.jpg") repeat scroll 0 0 transparent;
	height: 64px;
    margin: 0 10px;
    width: 308px;
}
.skype{
	float:left;
	width:308px;
	height: auto;
	margin: 0 20px;
	
}
.skype img{	
	float:left;
	border:none !important;
	width:50px;
}
.contact-left-div{
	margin: 10px 20px;
	width:45%;
	 float: left;
}
.contact-right-div{
	margin: 10px 20px;
	width:45%;
	 float: left;
}
.address{
	float: left;
    font-size: 14px;
    font-weight: bold;
    height: auto;
    margin: 10px 10px;
    width: 45%;
}
.tp{
	float: left;
    font-size: 14px;
    font-weight: bold;
    height: auto;
    margin: 5px 10px;
    width: 45%;
}
.address span{
	color:#72A946;
}
.tp span {
    color: #72A946;
}
.contact-icon{
	float:left;
	background:url("/img/contact_us.png") no-repeat;
    padding: 60px 30px 0 40px;
}
.add-icon{
	background: url("/img/address_s.png") no-repeat scroll 0 0 transparent;
    float: left;
    padding: 40px 30px 0 35px;
}
.tp-icon{
	background: url("/img/tp.png") no-repeat scroll 0 0 transparent;
    float: left;
    padding: 40px 30px 0 35px;
}
.fax-icon{
	background: url("/img/fax.png") no-repeat scroll 0 0 transparent;
    float: left;
    padding: 40px 30px 0 35px;
}

.email-icon{
	background: url("/img/email_s.png") no-repeat scroll 0 0 transparent;
    float: left;
    padding: 40px 30px 0 35px;
}
.skype-icon{
	background: url("/img/contact_form/skype.gif") no-repeat scroll 0 0 transparent;
    float: left;
    padding: 40px 30px 0 35px;
}

.page-cap{
	color: #72A946;
    float: left;
    font-size: 20px;
    font-weight: bold;
    padding: 20px;
}

</style>
<div id="contact-<?php echo $contact['Contact']['id']; ?>" class="contact-frm">
    <!--<h2><?php echo $contact['Contact']['title']; ?></h2>-->
    <div class="contact-body">
    <?php echo $contact['Contact']['body']; ?>
    </div>
    <div><span class="contact-icon"></span><span class="page-cap">Contact and Enquire</span></div>
    <div class="clr"></div>
    <div class="contact-categories">
    	<div class="contact-us"></div><div class="inq"></div>
    </div>
    <div class="clr"></div>
    <div class="contact-left-div">
    		<div class="skype-icon"></div>
            <div class="tp">
                <span>Skype ID</span>
            </div>
            <div class="clr"></div>
        	<div class="add-icon"></div>
            <div class="address">
                <span>Loops Solutions Pvt Ltd.</span>
                <div class="clr"></div>
                <span>3rd Floor,</span>
                <div class="clr"></div>
                <span>91 Galle Road,</span>
                <div class="clr"></div>
                <span>Colombo 4,</span>
                <div class="clr"></div>
                <span>Sri lanka</span>
            </div>
            <div class="clr"></div>
            <div class="email-icon"></div>
            <div class="tp">
                <span><a href="inquiry@loooops.com">inquiry@loooops.com</a></span>
            </div>
            <div class="clr"></div>
            <div class="tp-icon"></div>
            <div class="tp">
                <span>(+94) 11 4 374324</span>
            </div>
          	<div class="clr"></div>
            <div class="fax-icon"></div>
            <div class="tp">
                <span>(+94) 11 4 374323</span>
            </div>
    </div>
    <div class="contact-right-div">
    <?php if ($contact['Contact']['message_status']) { ?>
    <div class="contact-form">
    <?php
        echo $form->create('Message', array(
            'url' => array(
                'controller' => 'contacts',
                'action' => 'view',
                $contact['Contact']['alias'],
            ),
        ));
        echo $form->input('Message.name', array('label' => __('Your name', true)));
        echo $form->input('Message.email', array('label' => __('Your email', true)));
        echo $form->input('Message.title', array('label' => __('Subject', true)));
		echo $form->input('Message.message_type', array('label' => __('Enquiry', true),'type'=>'select','options'=>array('Billing'=>'Billing','Inquiry'=>'Inquiry','Cancellation'=>'Cancellation')));
        echo $form->input('Message.body', array('label' => __('Message', true)));
        if ($contact['Contact']['message_captcha']) {
            echo $recaptcha->display_form();
        }
        echo $form->end(__('Send', true));
    ?>
    </div>
    <?php } ?>
    </div>
    <div class="clr"></div>
</div>