 <style>
 .lbl{
	 width:200px;
	 float:left;
	 margin-right:10px;
 }
 .dataf{
	 width:300px;
	 float:left;
  }
 </style>
 <div style="border:2px solid #F7F7F7;width:550px;">
 	<div style="width:550px;height:80px;">
 	<img class="logo" src="http://thetravelclick.com/templates/limejungle/images/png/logo_6.png">
 	</div>
 	

 	<div style="background:url(http://thetravelclick.com/img/email_header.png) repeat-x;width:550px;height:auto;padding:10px;color:#DD7F27;font-weight:bold;">Booking Datails</div>
    <div style="width:550px;height:240px;padding:2px 0 2px 20px;color:#538136;background:#F7F7F7;">
		<div style="width:530px;height:auto;">Dear <?=$User; ?></div>
        <div class="lbl" style="width:200px;float:left;">Customer Name</div><div class="dataf" style="width:300px;float:left;"><?=$User;?></div>
        <div style="clear:both;"></div>
        <div class="lbl" style="width:200px;float:left;">Customer Email</div><div class="dataf" style="width:300px;float:left;"><?=$cemail;?></div>
        <div style="clear:both;"></div>
        <div class="lbl" style="width:200px;float:left;">Customer Contact No</div><div class="dataf" style="width:300px;float:left;"><?=$phone;?></div>
        <div style="clear:both;"></div>
        <div class="lbl" style="width:200px;float:left;">Room Type</div><div class="dataf" style="width:300px;float:left;"><?=$rtype;?></div>
        <div style="clear:both;"></div>
        <div class="lbl" style="width:200px;float:left;">Date From</div><div class="dataf" style="width:300px;float:left;"><?=$fdate;?></div>
        <div style="clear:both;"></div>
        <div class="lbl" style="width:200px;float:left;">Date To</div><div class="dataf" style="width:300px;float:left;"><?=$edate;?></div>
        <div style="clear:both;"></div>
        <div class="lbl" style="width:200px;float:left;">No of Selected Rooms</div><div class="dataf" style="width:300px;"><?=$rooms;?></div>
        <div style="clear:both;"></div>
        <div class="lbl" style="width:200px;float:left;">Additional Adults Charges</div><div class="dataf" style="width:300px;float:left;"><?=$aac;?></div>
        <div style="clear:both;"></div>
        <div class="lbl" style="width:200px;float:left;">Additional Children Charges</div><div class="dataf" style="width:300px;float:left;"><?=$aac;?></div>
        <div style="clear:both;"></div>
        <div class="lbl" style="width:200px;float:left;">Total Price</div><div class="dataf" style="width:300px;float:left;"><?=$estprice;?></div>
        <div style="clear:both;"></div>
        <div style="width:100px;float:left;margin:1px 0 1px 150px;">Thank you !</div>
        <div style="clear:both;"></div>
	</div>
 </div>
 
 