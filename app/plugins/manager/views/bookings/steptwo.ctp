<style>
.stepFont{
	width:247px;
	float:left;
	padding-top: 5px;
    text-align: center;
}
.inactiveDiv{
	background:url(<?php echo $html->webroot;?>img/booking_steps/stepsbg.png) repeat-x;
	height:35px;
	width:280px;
	color:#360;
	float:left;
}

.activeDiv{
	background:url(<?php echo $html->webroot;?>img/booking_steps/activestep.png) repeat-x;
	height:35px;
	color:#FFF;
	width:325px;
	float:left;
	
}
.activeArrow{
	background:url(<?php echo $html->webroot;?>img/booking_steps/stepsarrowactiveright.png) no-repeat;
	margin-left:45px;
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
.formContainer{
  width:90%;
  margin:50px 50px;
  
}
.detailLables{
	padding-left:10px;
	width:300px;
	height:20px;
	float:left;
	background:#F7FAF6;
	border:dashed 1px #CCC;
	margin:5px ;
	color:#360;
}
.detailFields{
	padding-left:10px;
	width:450px;
	height:20px;
	float:left;
	background:#F7FAF6;
	border:dashed 1px #CCC;
	margin:5px ;
	color:#360;
}
.detailLableAdditional{
	padding:0 10px;
	width:155px;
	height:20px;
	float:left;
	background:#F7FAF6;
	border:dashed 1px #CCC;
	margin:5px ;
	color:#360;
}

.detailFieldsAdditional{
	padding:0 10px;
	width:103px;
	height:20px;
	float:left;
	background:#F7FAF6;
	border:dashed 1px #CCC;
	margin:5px ;
	color:#360;
}
.detailFieldsAdditional select{
	width:103px;
}
.submit input{
	float:left;
	background:url(<?php echo $html->webroot;?>img/icons/book_bg.png) repeat-x;
	width:58px;
	height:20px;
	cursor:pointer;
	color:#FFF;
	text-align:center;
	margin-left: 325px;
}
</style>
<?php
$hotelName=$roomType=$roomTypeId=$price=$maxAdults=$maxChildren=$additionalAdultCharge=$additionalChildCharge=$cd='';

foreach($roomDes as $key=>$value){
$hotelName=$value['Hotel']['name'];
$roomTypeId=$value['HotelsRoomType']['id'];
$roomType=$value['HotelsRoomType']['name'];
$price=$value['HotelsRoomType']['price'];
$cd=$value['Coupon']['reduce_percentage'];
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
      
	      <div id="step2" class="activeDiv">
        	<div class="stepFont">Step Two : Book</div>
            <div class="activeArrow"></div>
	      </div>
	      <div id="step3" class="inactiveDiv">        	
            <div class="stepFont">Step Three : Ticket</div>
            <div class="inactiveArrow"></div>
	      </div>
<!--	      <div id="step4" class="inactiveDiv">
            <div class="stepFont">Step 4</div>
            <div class="inactiveArrow"></div>
        	
	      </div>
	      <div id="step5" class="inactiveDiv">
        	<div class="stepFont">Step 5</div>
            <div class="inactiveArrow"></div>	
	      </div>-->
</div>

<div class="formContainer">
<?=$this->Form->create('Booking', array('controller'=>'Booking' ,'action' => '/stepthree/','type' => 'post','id'=>'cupon_check'));?>
 	<div class="clr"></div>
	<div class="detailLables">Room Type</div>
	<div class="detailFields"><?=$roomType;?><?=$this->Form->input('Booking.room_type',array('type'=>'hidden','value'=>$roomTypeId))?></div>	
    <div class="clr"></div>
	<div class="detailLables">Price <?=$price;?>*<?=$noOfSelectedRooms;?></div>
	<div class="detailFields"><?=$price*$noOfSelectedRooms;?><?=$this->Form->input('Booking.price',array('type'=>'hidden','value'=>$price*$noOfSelectedRooms))?></div>	
	<div class="clr"></div>
	<div class="detailLables">Date From</div>
	<div class="detailFields"><?=$dateFrom;?><?=$this->Form->input('Booking.dateFrom',array('type'=>'hidden','value'=>$dateFrom))?></div>
    <div class="clr"></div>
	<div class="detailLables">Date To</div>
	<div class="detailFields"><?=$dateTo;?><?=$this->Form->input('Booking.dateTo',array('type'=>'hidden','value'=>$dateTo))?></div>
    <div class="clr"></div>
	<div class="detailLables">No of Selected Rooms</div>
	<div class="detailFields"><?=$noOfSelectedRooms?><?=$this->Form->input('Booking.nofselectedrooms',array('type'=>'hidden','value'=>$noOfSelectedRooms))?><?=$this->Form->input('Booking.selectedrooms',array('type'=>'hidden','value'=>$selectedrooms))?></div>

    <div class="clr"></div>
	<div class="detailLables">Additional Adults Charges <?=$additionalAdultCharge; ?> * <?=$additionalAdults;?></div>
     <?php $addAd=$additionalAdultCharge*$additionalAdults;?>
	<div class="detailFields"><?=$addAd;?><?=$this->Form->input('Booking.aac',array('type'=>'hidden','value'=>$additionalAdults))?></div>
    
    <div class="clr"></div>
	<div class="detailLables">Additional Children Charges <?=$additionalChildCharge; ?> * <?=$additionalChildren;?></div>
    <?php $addC=$additionalChildren*$additionalChildCharge;?>
	<div class="detailFields"><?=$addC;?><?=$this->Form->input('Booking.acc',array('type'=>'hidden','value'=>$additionalChildren))?></div>
	<div class="clr"></div>
    <?php 
		$date1 = $dateFrom;
		$date2 = $dateTo;
		
		$diff = abs(strtotime($date2) - strtotime($date1));
		
		$years = floor($diff / (365*60*60*24));
		$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
		$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
	?>
    <div class="detailLables">Cost for <?=$days;?> day(s)  <?=(($price*$noOfSelectedRooms)+$addC+$addAd);?>*<?=$days;?></div>
	<div class="detailFields"><?=(($price*$noOfSelectedRooms)+$addC+$addAd)*$days;?><?=$this->Form->input('Booking.nofselecteddays',array('type'=>'hidden','value'=>$days))?></div>
 
    <div class="clr"></div>
	<div class="detailLables">Coupon Deduction <?=$cd;?>%</div>
    <?php $couponDeduction=$price*($cd/100); ?>
	<div class="detailFields"><?=$couponDeduction;?><?=$this->Form->input('Booking.coupondeduction',array('type'=>'hidden','value'=>$cd))?><?=$this->Form->input('Booking.couponid',array('type'=>'hidden','value'=>$cid))?></div>
	<div class="clr"></div>
	<div class="detailLables">Total Price</div>
    <?php $total=((($price*$noOfSelectedRooms)+$addC+$addAd)*$days)-$couponDeduction; ?>
	<div class="detailFields"><?=$total?><?=$this->Form->input('Booking.total',array('type'=>'hidden','value'=>$total))?></div>
    <div class="clr"></div>
<?=$this->Form->end('Submit');?>
 
</div>

</div>