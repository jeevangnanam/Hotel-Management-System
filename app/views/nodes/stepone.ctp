<style>
.stepFont{
	width:267px;
	float:left;
	padding-top: 5px;
    text-align: center;
}
.inactiveDiv{
	background:url(<?php echo $html->webroot;?>img/booking_steps/stepsbg.png) repeat-x;
	height:35px;
	width:300px;
	color:#360;
	float:left;
}

.activeDiv{
	background:url(<?php echo $html->webroot;?>img/booking_steps/activestep.png) repeat-x;
	height:35px;
	color:#FFF;
	width:300px;
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
	font-size:16px;
    width: 98.5%;
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
	width:150px;
	height:20px;
	float:left;
	background:#F7FAF6;
	border:none !important;
	margin:5px ;
	color:#360;
}
.detailFields{
	padding-left:10px;
	width:150px;
	height:20px;
	float:left;
	background:#F7FAF6;
	border:none !important;
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
	/*background:url(<?php echo $html->webroot;?>img/icons/book_bg.png) repeat-x;
	width:58px;
	height:20px;*/
	cursor:pointer;
	color:#FFF;
	text-align:center;
	margin-left: 325px;
}

#NodesCoupon{
	width:120px;
	height:14px;
}
.main-detals{
	float:left;
	margin: 5px;
    width: 42%;
	padding: 10px;
	border:solid 1px #E9E9E9;
	border-radius: 5px; 
	-moz-border-radius: 5px; 
	-webkit-border-radius: 5px;
}
.add-charges{
	float:left;
	margin: 5px;
	padding: 10px;
    width: 42%;
	border:solid 1px #E9E9E9;
	border-radius: 5px; 
	-moz-border-radius: 5px; 
	-webkit-border-radius: 5px;
}
.selections{
	float:left;
	width:45%;
	margin: 0 0 0 10px;
	
}

.selections-detailLables{
	padding-left:10px;
	width:150px;
	height:20px;
	float:left;
	background:#F7FAF6;
	/*border:dashed 1px #CCC;*/
	margin:5px ;
	color:#360;
}
.selections-detailFields{
	padding-left:10px;
	width:150px;
	height:20px;
	float:left;
	background:#F7FAF6;
	/*border:dashed 1px #CCC;*/
	margin:5px ;
	color:#360;
}
.selections-div{
	float:left;
	margin:5px ;
	height:auto;
	padding: 2px;
}
</style>
<?php
$hotelId=$hotelName=$roomType=$rtId=$price=$maxAdults=$maxChildren=$additionalAdultCharge=$additionalChildCharge='';

foreach($roomDes as $key=>$value){
$hotelId = $value['Hotel']['id'];
$hotelName = $value['Hotel']['name'];
$roomType  = $value['HotelsRoomType']['name'];
$rtId	   = $value['HotelsRoomType']['id'];
$price     = $value['HotelsRoomType']['price'];
$maxAdults=$value['HotelsRoomCapacities']['max_adults'];
$maxChildren=$value['HotelsRoomCapacities']['max_children'];
$additionalAdultCharge=$value['HotelsRoomCapacities']['additional_adult_charge'];
$additionalChildCharge=$value['HotelsRoomCapacities']['additional_child_charge'];
//$coupon=$value['Coupon']['reduce_percentage'];

}

?>
<div class="container">
<div class="clr"></div>
<div class="hotelname"> <span class="ht-icon"></span><span class="ht-name"><?=$hotelName;?></span></div>
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
            <div class="stepFont">Step Three : Paymants</div>
            <div class="inactiveArrow"></div>
	      </div>
</div>

 
<div class="formContainer">
<?=$this->Form->create('Nodes', array('controller'=>'bookings' ,'action' => '/steptwo/'.$hotelId,'type' => 'post','id'=>'cupon_check'));?>
	<div class="clr"></div>
    <div class="main-detals">
        <div class="detailLables">Room Type</div>
        <div class="detailFields"><?=$roomType;?><?=$this->Form->input('room_type',array('type'=>'hidden','value'=>$rtId))?></div>
        <div class="clr"></div>
        <div class="detailLables">Price</div>
        <div class="detailFields"><?=$price;?></div>
        <div class="clr"></div>
        <div class="detailLables">Date From</div>
        <div class="detailFields"><?=$fromDate;?><?=$this->Form->input('fromdate',array('type'=>'hidden','value'=>$fromDate))?></div>
        <div class="clr"></div>
        <div class="detailLables">Date To</div>
        <div class="detailFields"><?=$toDate;?><?=$this->Form->input('todate',array('type'=>'hidden','value'=>$toDate))?></div>
        <div class="clr"></div>
    </div>
    <div class="add-charges">
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
    </div>
     <?php 
		
		
		$date1 = $fromDate;
		$date2 = $toDate;
		
		$diff = abs(strtotime($date2) - strtotime($date1));
		$s=(strlen($toDate)-2);
		$e=strlen($toDate);
		$m=(substr($toDate,$s,$e));
		$mc=30;
		if($m==31){
			$mc=$m;
		}
		$years = floor($diff / (365*60*60*24));
		$months = floor(($diff - $years * 365*60*60*24) / ($mc*60*60*24));
		$days = floor(($diff - $years * 365*60*60*24 - $months*$mc*60*60*24)/ (60*60*24));
		
		
	?>
    <div class="selections-div">
        <div class="selections">
            <div class="selections-detailLables">Number of days</div>
            <div class="selections-detailFields"><?=($days+1);?><?=$this->Form->input('nofselecteddays',array('type'=>'hidden','value'=>($days+1)))?></div>
            <div class="selections-detailLables">No of Selected Rooms</div>
            <div class="selections-detailFields"><?=$nsr;?><?=$this->Form->input('nofselectedrooms',array('type'=>'hidden','value'=>$nsr))?></div>
            <div class="selections-detailLables">Selected Rooms</div>
            <div class="selections-detailFields"><?=$nsrooms;?><?=$this->Form->input('Nodes.selectedrooms',array('type'=>'hidden','value'=>$nsrooms))?></div>
        </div>
    
        <div class="selections">
            <div class="selections-detailLables">Coupon</div>
            <div class="selections-detailFields"><?=$this->Form->input('coupon',array('type'=>'text','value'=>'','label'=>''))?></div>
            <div class="clr"></div>
            <?php $opt=array('0'=>'Select','1'=>'One','2'=>'Two','3'=>'Three','4'=>'Four','5'=>'Five','6'=>'Six','7'=>'Seven');?>
            <div class="selections-detailLables">No of Additional Adults</div>  
            <div class="selections-detailFields"><?=$this->Form->input('max_adults',array('type'=>'select','label'=>'','options'=>array_slice($opt, 0, $maxAdults+1)))?></div>
            <div class="selections-detailLables">No of Additional Children</div>
            <div class="selections-detailFields"><?=$this->Form->input('max_children',array('type'=>'select','label'=>'','options'=>array_slice($opt, 0, $maxChildren+1)))?></div>
            <div class="clr"></div>
         </div>
     </div>
     <div class="clr"></div>
<?=$this->Form->end('Submit');?>
 
</div>

</div>