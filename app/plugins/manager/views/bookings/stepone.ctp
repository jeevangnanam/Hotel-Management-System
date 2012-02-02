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
	background: none repeat scroll 0 0 #F7FAF6;
    border: medium none !important;
    color: #336600;
    float: left;
    height: 20px;
    margin: 5px;
    padding-left: 10px;
    width: 150px;
}
.detailFields{
	background: none repeat scroll 0 0 #F7FAF6;
    border: medium none !important;
    color: #336600;
    float: left;
    height: 20px;
    margin: 5px;
    padding-left: 10px;
    width: 150px;
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
	/*background:url(<?php echo $html->webroot;?>img/icons/book_bg.png) repeat-x;*/
	width:58px;
	height:25px;
	cursor:pointer;
	color:#FFF;
	text-align:center;
	margin-left: 325px;
}

#bookingsCoupon{
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
<div class="hotelname"><span class="ht-icon"></span><span class="ht-name"><?=$hotelName;?></span></div>
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
	      <!--<div id="step4" class="inactiveDiv">
            <div class="stepFont">Step 4</div>
            <div class="inactiveArrow"></div>
        	
	      </div>
	      <div id="step5" class="inactiveDiv">
        	<div class="stepFont">Step 5</div>
            <div class="inactiveArrow"></div>	
	      </div>-->
</div>

 
<div class="formContainer">
<?=$this->Form->create('Bookings', array('controller'=>'bookings' ,'action' => '/steptwo/','type' => 'post','id'=>'cupon_check'));?>
	<div class="clr"></div>
    <div class="main-detals">
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
    </div>
	<div class="clr"></div>
    <div class="selections-div">
        <div class="selections">
            <div class="selections-detailLables">No of Selected Rooms</div>
            <div class="selections-detailFields"><?=$nsr;?><?=$this->Form->input('bookings.nofselectedrooms',array('type'=>'hidden','value'=>$nsr))?></div>
            <div class="clr"></div>
            <div class="selections-detailLables">Selected Rooms</div>
            <div class="selections-detailFields"><?=$nsrooms;?><?=$this->Form->input('bookings.selectedrooms',array('type'=>'hidden','value'=>$nsrooms))?></div>
            <div class="clr"></div>
            <div class="selections-detailLables">Coupon</div>
            <div class="selections-detailFields"><?=$this->Form->input('bookings.coupon',array('type'=>'text','value'=>'','label'=>''))?></div>
            <div class="clr"></div>
         </div>
    
        <div class="selections">
			<?php $opt=array('0'=>'Select','1'=>'One','2'=>'Two','3'=>'Three','4'=>'Four','5'=>'Five','6'=>'Six','7'=>'Seven');?>
            <div class="selections-detailLables">No of Additional Adults</div>  
            <div class="selections-detailFields"><?=$this->Form->input('bookings.max_adults',array('type'=>'select','label'=>'','options'=>array_slice($opt, 0, $maxAdults+1)))?></div>
            <div class="selections-detailLables">No of Additional Children</div>
            <div class="selections-detailFields"><?=$this->Form->input('bookings.max_children',array('type'=>'select','label'=>'','options'=>array_slice($opt, 0, $maxChildren+1)))?></div>
            <div class="clr"></div>
         </div>
     </div>
<?=$this->Form->end('Submit');?>
 
</div>

</div>