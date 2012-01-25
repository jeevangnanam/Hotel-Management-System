<style>
.contact-frm{
	margin: 0 50px 0 100px;
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
.address{
	float:left;
	width:308px;
	height: 60px;
	margin: 10px 20px;
	font-size:14px;
	font-weight:bold;
	
	
}
</style>
<div id="contact-<?php echo $contact['Contact']['id']; ?>" class="contact-frm">
    <!--<h2><?php echo $contact['Contact']['title']; ?></h2>-->
    <div class="contact-body">
    <?php echo $contact['Contact']['body']; ?>
    </div>
    <div class="contact-categories">
    	<div class="contact-us"></div><div class="inq"></div>
    </div>
    <div class="clr"></div>
	<div class="skype">
    	<img src="/img/contact_form/skype.gif" />
    	<div>skypename</div>
    	<div></div>
        <div class="clr"></div>
    </div>
    <div class="clr"></div>
    <div class="address">
    	<div>
        	<div>Address</div>
        	<div>ASASASAS</div>
        </div>
    	<div>
            <div>Phone</div>
            <div>01478520</div>
        </div>
    </div>
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