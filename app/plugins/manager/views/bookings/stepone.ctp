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

#bookingsCoupon{
	width:120px;
	height:14px;
}
</style>
<?php
$hotelName=$roomType=$rtId=$price=$maxAdults=$maxChildren=$additionalAdultCharge=$additionalChildCharge='';
foreach($roomDes as $key=>$value){
$hotelName = $value['Hotel']['name'];
$roomType  = $value['HotelsRoomType']['name'];
$rtId	   = $value['HotelsRoomType']['id'];
$price     = $value['HotelsRoomType']['price'];
$maxAdults=$value['HotelsRoomCapacities']['max_adults'];
$maxChildren=$value['HotelsRoomCapacities']['max_children'];
$additionalAdultCharge=$value['HotelsRoomCapacities']['additional_adult_charge'];
$additionalChildCharge=$value['HotelsRoomCapacities']['additional_child_charge'];
$coupon=$value['Coupon']['reduce_percentage'];

}

?>
<div class="container">
<div class="clr"></div>
<div class="cap">Hotel Name : <?=$hotelName;?></div>
<div class="clr"></div>
<div>
      <div id="step1" class="activeDiv">
      	 <div class="stepFont">Step One : Details</div>
         <div id="s1Arrow" class="activeArrow"></div>
        </div>
      
	      <div id="step2" class="inactiveDiv">
        	<div class="stepFont">Step Two : Book</div>
            <div class="inactiveArrow"></div>
	      </div>
	      <div id="step3" class="inactiveDiv">        	
            <div class="stepFont">Step Three : Ticket</div>
            <div class="inactiveArrow"></div>
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

 
<div class="formContainer">
<?=$this->Form->create('Bookings', array('controller'=>'bookings' ,'action' => '/steptwo/','type' => 'post','id'=>'cupon_check'));?>
	<div class="clr"></div>
	<div class="detailLables">Room Type</div>
	<div class="detailFields"><?=$roomType;?><?=$this->Form->input('bookings.room_type',array('type'=>'hidden','value'=>$rtId))?></div>
	<div class="clr"></div>
    <div class="detailLables">Price</div>
	<div class="detailFields"><?=$price;?></div>
	<div class="clr"></div>
	<div class="detailLables">Date From</div>
	<div class="detailFields"><?=$fromDate;?><?=$this->Form->input('bookings.fromdate',array('type'=>'hidden','value'=>$fromDate))?></div>
	<div class="clr"></div>
	<div class="detailLables">Date To</div>
	<div class="detailFields"><?=$toDate;?><?=$this->Form->input('bookings.todate',array('type'=>'hidden','value'=>$toDate))?></div>
	<div class="clr"></div>
	<div class="detailLables">Max Adults</div>
	<div class="detailFields"><?=$maxAdults;?></div>
	<div class="clr"></div>
	<div class="detailLables">Max Children</div>
	<div class="detailFields"><?=$maxChildren;?></div>
	<div class="clr"></div>
	<div class="detailLables">Additional Adult Charge</div>
	<div class="detailFields"><?=$additionalAdultCharge;?></div>
	<div class="clr"></div>
	<div class="detailLables">Additional Child Charge</div>
	<div class="detailFields"><?=$additionalChildCharge;?></div>
	<div class="clr"></div>
	<div class="detailLables">No of Selected Rooms</div>
	<div class="detailFields"><?=$nsr;?><?=$this->Form->input('bookings.nofselectedrooms',array('type'=>'hidden','value'=>$nsr))?></div>
	<div class="clr"></div>
    <div class="detailLables">Coupon</div>
	<div class="detailFields"><?=$this->Form->input('bookings.coupon',array('type'=>'text','value'=>'','label'=>''))?></div>
	<div class="clr"></div>
	<?php $opt=array('0'=>'Select','1'=>'One','2'=>'Two','3'=>'Three','4'=>'Four','5'=>'Five','6'=>'Six','7'=>'Seven');?>
    <div class="detailLableAdditional">No of Additional Adults</div>  
	<div class="detailFieldsAdditional"><?=$this->Form->input('bookings.max_adults',array('type'=>'select','label'=>'','options'=>array_slice($opt, 0, $maxAdults+1)))?></div>
    <div class="detailLableAdditional">No of Additional Children</div>
	<div class="detailFieldsAdditional"><?=$this->Form->input('bookings.max_children',array('type'=>'select','label'=>'','options'=>array_slice($opt, 0, $maxChildren+1)))?></div>
    <div class="clr"></div>
<?=$this->Form->end('Submit');?>
 
</div>

</div>