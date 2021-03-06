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
  height: 450px;
  
}
.detailLables{
	padding-left:10px;
	width:300px;
	height:20px;
	float:left;
	background:#F7FAF6;
	border:none !important;
	margin:5px ;
	color:#360;
}
.detailFields{
	padding-left:10px;
	width:450px;
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
	background:url(<?php echo $html->webroot;?>img/icons/book_bg.png) repeat-x;
	width:58px;
	height:20px;
	cursor:pointer;
	color:#FFF;
	text-align:center;
	margin-left: 325px;
}
#BookingName,#BookingEmail {
	height: 20px;
    width: 350px;
}
#BookingContactno{
	height: 20px;
    width: 100px !important;
}
.submitbtn {
   /* background: url("/img/icons/book_bg.png") repeat-x scroll 0 0 transparent;
	height: 20px; 
	width: 58px;*/
	border: medium none;
	background: none repeat scroll 0 0 #538136;
    color: #FFFFFF;
    cursor: pointer;
    float: left; 
    margin-left: 325px;
    text-align: center;
	height: 25px;
    width: 70px;
	border-radius: 5px 5px 5px 5px;
	font-weight: bold;
}
.submitbtn:hover {
	background:#DD7F27;
}
.submit{
	display:none;
}
.msg{
	margin-left:350px;
	color:#F00;
}
.selections{
	float:left;
	border:solid 1px #E9E9E9;
	border-radius: 5px; 
	-moz-border-radius: 5px; 
	-webkit-border-radius: 5px;	
	margin:5px 0;
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
<script>
 function submitform(){
	 var chk=0;
	 var flow='<ul>';
	 if($('#BookingName').val()==''){
		 flow+='<li>*Please enter your name.</li>';
		 chk=1;
	 }
	 if($('#BookingEmail').val()==''){
		 flow+='<li>*Please enter your email.</li>';
		  chk=1;
	 }
	 if($('#BookingEmail').val()!='' && !vbalidate_email($('#BookingEmail').val())){
		flow+='<li>*Please enter valid email.</li>';
		  chk=1; 
	 }
	 
	 if($('#BookingContactno').val()==''){
		flow+='<li>*Please enter your contact number.</li>';		
		 chk=1;
	 }
	 
	 flow+='</ul>';
	 $('.msg').html(flow);
	 if(chk==0){
		 $('#cupon_check').submit();
	 }
 }
 
function vbalidate_email(e){
	 var	email = /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/;
  	return e.match(email);
}
</script>
<?php

$hotelid=$hotelName=$roomType=$roomTypeId=$price=$maxAdults=$maxChildren=$additionalAdultCharge=$additionalChildCharge='';

foreach($roomDes as $key=>$value){
$hotelid=$value['Hotel']['id'];
$hotelName=$value['Hotel']['name'];
$roomTypeId=$value['HotelsRoomType']['id'];
$roomType=$value['HotelsRoomType']['name'];
$price=$value['HotelsRoomType']['price'];
$additionalAdultCharge=$value['HotelsRoomCapacities']['additional_adult_charge'];
$additionalChildCharge=$value['HotelsRoomCapacities']['additional_child_charge'];
}

?>
<div class="container">
<div class="clr"></div>
<div class="hotelname"> <span class="ht-icon"></span><span class="ht-name"><?=$hotelName;?></span></div>
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
            <div class="stepFont">Step Three : Paymants</div>
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

<?=$this->Form->create('Nodes', array('controller'=>'Nodes' ,'action' => '/stepthree/'.$hotelid,'type' => 'post','id'=>'cupon_check'));?>
 	<div class="clr"></div>
    <div class="selections">
        <div class="detailLables">Room Type</div>
        <div class="detailFields"><?=$roomType;?><?=$this->Form->input('room_type',array('type'=>'hidden','value'=>$roomTypeId))?></div>	
        <div class="clr"></div>
        <div class="detailLables">Price <?=$price;?>*<?=$noOfSelectedRooms;?></div>
        <div class="detailFields"><?=$price*$noOfSelectedRooms;?><?=$this->Form->input('price',array('type'=>'hidden','value'=>$price*$noOfSelectedRooms))?></div>	
        <div class="clr"></div>
        <div class="detailLables">Date From</div>
        <div class="detailFields"><?=$dateFrom;?><?=$this->Form->input('dateFrom',array('type'=>'hidden','value'=>$dateFrom))?></div>
        <div class="clr"></div>
        <div class="detailLables">Date To</div>
        <div class="detailFields"><?=$dateTo;?><?=$this->Form->input('dateTo',array('type'=>'hidden','value'=>$dateTo))?></div>
        <div class="clr"></div>
        <div class="detailLables">No of Selected Rooms</div>
        <div class="detailFields"><?=$noOfSelectedRooms?><?=$this->Form->input('nofselectedrooms',array('type'=>'hidden','value'=>$noOfSelectedRooms))?><?=$this->Form->input('selectedrooms',array('type'=>'hidden','value'=>$selectedrooms))?></div>
    
        <div class="clr"></div>
        <div class="detailLables">Additional Adults Charges <?=$additionalAdultCharge; ?> * <?=$additionalAdults;?></div>
         <?php $addAd=$additionalAdultCharge*$additionalAdults;?>
        <div class="detailFields"><?=$addAd;?><?=$this->Form->input('maxadults',array('type'=>'hidden','value'=>$additionalAdults))?></div>
        
        <div class="clr"></div>
        <div class="detailLables">Additional Children Charges <?=$additionalChildCharge; ?> * <?=$additionalChildren;?></div>
        <?php $addC=$additionalChildren*$additionalChildCharge;?>
        <div class="detailFields"><?=$addC;?><?=$this->Form->input('maxchildren',array('type'=>'hidden','value'=>$additionalChildren))?></div>
        <div class="clr"></div>
        <?php 
            $date1 = $dateFrom;
            $date2 = $dateTo;
            
            $diff = abs(strtotime($date2) - strtotime($date1));
            $s=(strlen($dateFrom)-2);
            $e=strlen($dateTo);
            $m=(substr($dateTo,$s,$e));
            $mc=30;
            if($m==31){
                $mc=$m;
            }
            $years = floor($diff / (365*60*60*24));
            $months = floor(($diff - $years * 365*60*60*24) / ($mc*60*60*24));
            $days = floor(($diff - $years * 365*60*60*24 - $months*$mc*60*60*24)/ (60*60*24));
        ?>
        <div class="detailLables">Cost for <?=($days+1);?> day(s)  <?=(($price*$noOfSelectedRooms)+$addC+$addAd);?>*<?=($days+1);?></div>
        <div class="detailFields"><?=(($price*$noOfSelectedRooms)+$addC+$addAd)*($days+1);?><?=$this->Form->input('nofselecteddays',array('type'=>'hidden','value'=>($days+1)))?></div>
        
        <div class="clr"></div>
        <div class="detailLables">Coupon Deduction <?=$cd;?>%</div>
        <?php $couponDeduction=(($price*$noOfSelectedRooms)+$addC+$addAd)*$days*($cd/100); ?>
        <div class="detailFields"><?=$couponDeduction;?><?=$this->Form->input('coupondeduction',array('type'=>'hidden','value'=>$cd))?><?=$this->Form->input('couponid',array('type'=>'hidden','value'=>$cid))?></div>
        <div class="clr"></div>
        <div class="detailLables">Total Price</div>
        <?php $total=((($price*$noOfSelectedRooms)+$addC+$addAd)*$days)-$couponDeduction; ?>
        <div class="detailFields"><?=$total?><?=$this->Form->input('total',array('type'=>'hidden','value'=>$total))?></div>
        
    </div>
    <div class="selections">
    	<div class="clr"></div>
        <div class="msg"></div>
        <div class="clr"></div>
        <div class="detailLables">Enter Your Name</div>
        <div class="detailFields"><?=$this->Form->input('Booking.name',array('type'=>'text','value'=>'','class'=>'BookingName','label'=>''))?></div>
        <div class="clr"></div>
        <div class="detailLables">Enter Your Email</div>
        <div class="detailFields"><?=$this->Form->input('Booking.email',array('type'=>'text','value'=>'','class'=>'BookingEmail','label'=>''))?></div>
        <div class="clr"></div>
        <div class="detailLables">Enter Your Contact Number</div>
        <div class="detailFields"><?=$this->Form->input('Booking.contactno',array('type'=>'text','value'=>'','class'=>'BookingContact','label'=>''))?></div>
        <div class="clr"></div>
    </div>
    <?=$this->Form->button('Submit',array('onclick'=>'submitform()','type'=>'button','class'=>"submitbtn"));?>
<?=$this->Form->end('Submit');?>
 
</div>

</div>