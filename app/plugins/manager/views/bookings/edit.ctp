<style>
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
.submit{
	display:none;
}
</style>
<script>
 $(document).ready(function(){ 
	$('#BookingDfrom').datepicker({ dateFormat: 'yy-mm-dd' });
 	$('#BookingDto').datepicker({ dateFormat: 'yy-mm-dd' });	
	}
  )
</script>
<div class="container">
<?=$this->Form->create('Booking',array('action'=>'/'));?>
<div>Ticket No.</div><div><?=$ticket;?></div>
<div>Hotel Name </div><div><?=$hotelname;?></div>
<div>Room Type</div><div><?=$roomtype;?></div>
<div>Number of selected rooms</div><div><?=$this->Form->input('noofselectedrooms',array('type'=>'hidden','class'=>'','label'=>'','value'=>$nofr));?></div>
<div>Date From</div><div><?=$this->Form->input('dfrom',array('type'=>'text','class'=>'','label'=>'','value'=>$fromdate));?></div>
<div>Date To</div><div><?=$this->Form->input('dto',array('type'=>'text','class'=>'','label'=>'','value'=>$todate));?></div>
<?php $opt=array('0'=>'Select','1'=>'One','2'=>'Two','3'=>'Three','4'=>'Four','5'=>'Five','6'=>'Six','7'=>'Seven');?>
<div>Additional Adults</div><div><?=$this->Form->input('noofadults',array('type'=>'select','class'=>'','label'=>'','selected'=>$aadult,'options'=>array_slice($opt, 0, $maxAdults+1)));?></div>
<div>Additional Children</div><div><?=$this->Form->input('noofchildren',array('type'=>'select','class'=>'','label'=>'','selected'=>$achild,'options'=>array_slice($opt, 0, $maxChildren+1)));?></div>

<?=$this->Form->button('Cancel Booking',array('type'=>'button','class'=>''));?>
<?=$this->Form->button('Edit Booking',array('type'=>'button','class'=>''));?>
<?=$this->Form->button('Go Back',array('type'=>'button','class'=>'','onclick'=>'history.go(-1)'));?>
<?=$this->Form->end('Sumbit');?>
</div>