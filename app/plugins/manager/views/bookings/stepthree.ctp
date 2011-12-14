<style>
.stepFont{
	width:147px;
	float:left;
	padding-top: 5px;
    text-align: center;
}
.inactiveDiv{
	background:url(<?php echo $html->webroot;?>img/booking_steps/stepsbg.png) repeat-x;
	height:35px;
	width:180px;
	color:#360;
	float:left;
}

.activeDiv{
	background:url(<?php echo $html->webroot;?>img/booking_steps/activestep.png) repeat-x;
	height:35px;
	color:#FFF;
	width:180px;
	float:left;
	
}
.activeArrow{
	background:url(<?php echo $html->webroot;?>img/booking_steps/stepsarrowactiveright.png) no-repeat;
	float:left;
	height:35px;
	width:33px;
}
.inactiveArrow{
	background:url(<?php echo $html->webroot;?>img/booking_steps/stepsarrow.png) no-repeat;
	float:left;
	height:35px;
	width:33px;
}
.cap{
	float:left;
	width:50%;
	height:40px;
	color:#360;
	text-align:center;
	background:url(<?php echo $html->webroot;?>img/booking_steps/box.png) repeat-x; 
	margin-bottom:1px;
	padding-top:10px;
	padding-left:10px;
	text-align:left;
	
}
.detailLables{
	width:100px;
	height:20px;
	float:left;
}
.detailFields{
	width:200px;
	height:20px;
	float:left;
}
.welcomenote{
	margin:0 0 5px 5px;
	width:210px;
	height:20px;
	float:left;
	color:#538136;
	font-size:16px;
}
.thanks{
	margin:0 0 5px 5px;
	width:210px;
	height:20px;
	float:left;
	color:#538136;
	font-size:12px;
}
.ticket{
	margin:0 0 5px 5px;
	width:310px;
	height:20px;
	float:left;
	color:#538136;
	font-size:12px;	
}
</style>
<?php
$hotelName=$roomType=$maxAdults=$maxChildren=$additionalAdultCharge=$additionalChildCharge=$usename='';
foreach($dets as $key=>$value){
$hotelName = $value['Hotel']['name'];
$roomType  = $value['HotelsRoomType']['name'];
$usename   = $value['User']['first_name']." ".$value['User']['last_name'];
}

?>
<div class="container">

<div class="clr"></div>
<div>
      <div id="step1" class="inactiveDiv">
      	 <div class="stepFont">Step One : Details</div>
         <div id="s1Arrow" class="inactiveArrow"></div>
        </div>
      
	      <div id="step2" class="inactiveDiv">
        	<div class="stepFont">Step Two : Book</div>
            <div class="inactiveArrow"></div>
	      </div>
	      <div id="step3" class="activeDiv">        	
            <div class="stepFont">Step Three : Ticket</div>
            <div class="activeArrow"></div>
	      </div>
	      <div id="step4" class="inactiveDiv">
            <div class="stepFont">Step 4</div>
            <div class="inactiveArrow"></div>
        	
	      </div>
	      <div id="step5" class="inactiveDiv">
        	<div class="stepFont">Step 5</div>
            <div class="inactiveArrow"></div>	
	      </div>
</div>
<div class="clr"></div>

 
<div style="width:500px;margin:50px 150px;">
	<div class="ticket" align="right"><span> Ticket No. :<?=$rID;?></span></div>
    <div class="clr"></div>
	<div class="welcomenote" align="center">Welecome to <?=$hotelName;?></div>
	<div class="clr"></div>
    <div class="detailLables">Customer Name :</div>
    <div class="detailFields"><?=$usename;?></div>
	<div class="clr"></div>
	<div class="detailLables">Room Type :</div>
	<div class="detailFields"><?=$roomType;?></div>
	<div class="clr"></div>
	<div class="detailLables">Date From :</div>
	<div class="detailFields"><?=$dFrom;?></div>
	<div class="clr"></div>
	<div class="detailLables">Date To :</div>
	<div class="detailFields"><?=$dTo;?></div>
	<div class="clr"></div>
	<div class="detailLables">Duration :</div>
	<div class="detailFields"><?=$noofdays;?> Day(s)</div>
	<div class="clr"></div>
	<div class="detailLables">Total Amount :</div>
	<div class="detailFields"><?=$estimated_price;?></div>
	<div class="clr"></div>
    <div class="thanks" align="center"><span >Thank you!</span></div>

 
</div>

</div>