<?=$html->script(array('jquery/jquery.alerts.js'));?>
<?=$html->css(array('jquery.alerts.css'));?>
<style>
.container{
	width:90%
}
.edit_form{
	width:545px;
	margin:10px 150px;
	border:dotted #CCC 1px;
	background:#F7FAF6;
}
.detailLables{
	width:200px;
	height:20px;
	float:left;
}
.detailFields{
	width:300px;
	height:20px;
	float:left;
}
button  {
    background: none repeat scroll 0 0 #72A946;
    border: medium none;
    color: #FFFFFF;
    cursor: pointer;
    float: right;
    font-size: 14px;
    font-style: normal;
    height: 25px;
    margin-right: 10px;
    width: auto;
}
#BookingDfrom,#BookingDto{
	width:80px;
}
.btndiv{
	   background: none repeat scroll 0 0 #F7FAF6;
    border: 1px dotted #CCCCCC;
    float: left;
    height: 30px;
    margin-top: 10px;
    padding-top: 5px;
    width: 545px;
}
.submit{
	display:none;
}
#err{
	margin-left:30px;
	color:#E02727;
}
</style>
<script>
 $(document).ready(function(){ 
	$('#BookingDfrom').datepicker({ dateFormat: 'yy-mm-dd' });
 	$('#BookingDto').datepicker({ dateFormat: 'yy-mm-dd' });	
 })
 
function cancelbooking(){
	jConfirm('Do you really need to cancel your booking?', 'H o t e l M S', function(r) {
    	if(r){
			$('#BookingTicket').val();
			$("#frm_edit").attr("action", "/manager/bookings/cancelbooking/"+$('#BookingTicket').val());
			$("#frm_edit").submit();
		}
});
	
}

function editbooking(){
	var err="<ul>";
	var chk=0;
	if($('#BookingDfrom').val().length==0){
		err+="<li>* Please select 'Date From'.</li>";
		chk=1;
	}
	if($('#BookingDto').val().length==0){
		err+="<li>* Please select 'Date To'.</li>";
		chk=1;
	}
	if($('#BookingDto').val() < $('#BookingDfrom').val()){
		err+="<li>'* Date To' is grater than or equal to 'Date From'.</li>";
		chk=1;
	}
	err+="</ul>";
	if(chk==1){	
		$('#err').html(err);
		return false;
	}
	jConfirm('Do you really need to edit your booking?', 'H o t e l M S', function(r) {
		if(r){
			$("#frm_edit").attr("action", "/manager/bookings/editbooking/"+$('#BookingTicket').val());
			$("#frm_edit").submit();
		}
			
	});
}
</script>
<div class="container">
	<div class="edit_form" >
		<div id='err'></div>
		<?=$this->Form->create('Booking',array('id'=>'frm_edit'));?>
		<div class="detailLables">Ticket No.</div><div class="detailFields"><?=$ticket;?><?=$this->Form->input('ticket',array('type'=>'hidden','value'=>$ticket));?></div>
		<div class="clr"></div>
		<div class="detailLables">Hotel Name </div><div class="detailFields"><?=$hotelname;?></div>
		<div class="clr"></div>
		<div class="detailLables">Room Type</div><div class="detailFields"><?=$roomtype;?></div>
		<div class="clr"></div>
		<div class="detailLables">Number of selected rooms</div><div class="detailFields"><?=$nofr;?><?=$this->Form->input('noofselectedrooms',array('type'=>'hidden','class'=>'','label'=>'','value'=>$nofr));?></div>
		<div class="clr"></div>
		<div class="detailLables">Date From</div><div class="detailFields"><?=$this->Form->input('dfrom',array('type'=>'text','class'=>'','label'=>'','value'=>$fromdate));?></div>
		<div class="clr"></div>
		<div class="detailLables">Date To</div><div class="detailFields"><?=$this->Form->input('dto',array('type'=>'text','class'=>'','label'=>'','value'=>$todate));?></div>
		<div class="clr"></div>
		<?php $opt=array('0'=>'Select','1'=>'One','2'=>'Two','3'=>'Three','4'=>'Four','5'=>'Five','6'=>'Six','7'=>'Seven');?>
		<div class="detailLables">Additional Adults</div><div class="detailFields"><?=$this->Form->input('noofadults',array('type'=>'select','class'=>'','label'=>'','selected'=>$aadult,'options'=>array_slice($opt, 0, $maxAdults+1)));?></div>
		<div class="clr"></div>
		<div class="detailLables">Additional Children</div><div class="detailFields"><?=$this->Form->input('noofchildren',array('type'=>'select','class'=>'','label'=>'','selected'=>$achild,'options'=>array_slice($opt, 0, $maxChildren+1)));?></div>
		<div class="clr"></div>
		<div class="btndiv">
		<?=$this->Form->button('Cancel Booking',array('type'=>'button','class'=>'cancelbooking','onclick'=>'cancelbooking()'));?>
		<?=$this->Form->button('Edit Booking',array('type'=>'button','class'=>'editbooking','onclick'=>'editbooking()'));?>
		<?=$this->Form->button('Go Back',array('type'=>'button','class'=>'','onclick'=>'history.go(-1)'));?>
		<?=$this->Form->end('Sumbit');?>
		</div>
	</div>
</div>