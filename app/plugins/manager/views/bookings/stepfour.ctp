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
	width:auto;
	height:20px;
	float:left;
}
.detailFields{
	width:auto;
	height:20px;
	float:left;
}
</style>
<?php
$hotelName=$roomType=$maxAdults=$maxChildren=$additionalAdultCharge=$additionalChildCharge='';
foreach($roomDes as $key=>$value){
$hotelName = $value['Hotel']['name'];
$roomType  = $value['HotelsRoomType']['name'];
$maxAdults=$value['HotelsRoomCapacities']['max_adults'];
$maxChildren=$value['HotelsRoomCapacities']['max_children'];
$additionalAdultCharge=$value['HotelsRoomCapacities']['additional_adult_charge'];
$additionalChildCharge=$value['HotelsRoomCapacities']['additional_child_charge'];
}

?>
<div class="container">
<div class="clr"></div>
<div class="cap">Hotel Name : <?=$hotelName;?></div>
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
	      <div id="step3" class="inactiveDiv">        	
            <div class="stepFont">Step Three : Paymants</div>
            <div class="inactiveArrow"></div>
	      </div>
	      <div id="step4" class="activeDiv">
            <div class="stepFont">Step 4</div>
            <div class="activeArrow"></div>
        	
	      </div>
	      <div id="step5" class="inactiveDiv">
        	<div class="stepFont">Step 5</div>
            <div class="inactiveArrow"></div>	
	      </div>
</div>
<div class="clr"></div>
<?=$this->Form->create('Bookings', array('controller'=>'bookings' ,'action' => '/steptwo/','type' => 'post','id'=>'cupon_check'));?>
 
<div style="width:500px;margin:50px 150px;">
	<div class="clr"></div>
	<div class="detailLables">Room Type</div>
	<div class="detailFields"><?=$roomType;?></div>
	<div class="clr"></div>
	<div class="detailLables">Date From</div>
	<div class="detailFields"><?=$fromDate;?></div>
	<div class="clr"></div>
	<div class="detailLables">Date To</div>
	<div class="detailFields"><?=$toDate;?></div>
	<div class="clr"></div>
	<div class="detailLables">Max Adults</div>
	<div class="detailFields"><?=$maxAdults;?></div>
	<div class="clr"></div>
	<div class="detailLables">Max Children</div>
	<div class="detailFields"><?=$maxChildren;?></div>
	<div class="clr"></div>
	<div class="detailLables">Max Adult Charge</div>
	<div class="detailFields"><?=$additionalAdultCharge;?></div>
	<div class="clr"></div>
	<div class="detailLables">Max Child Charge</div>
	<div class="detailFields"><?=$additionalChildCharge;?></div>
	<div class="clr"></div>
	<div class="detailLables">No of Selected Rooms</div>
	<div class="detailFields"><?=$nsr;?></div>
	<div class="clr"></div>
<?=$this->Form->end('Submit');?>
 
</div>

</div>