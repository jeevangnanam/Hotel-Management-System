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
<div>Ticket No.</div><div></div>
<div>Name </div><div></div>
<div>Number of selected rooms</div><div><?=$this->Form->input('noofselectedrooms',array('type'=>'select','class'=>'','label'=>''));?></div>
<div>Date From</div><div><?=$this->Form->input('dfrom',array('type'=>'text','class'=>'','label'=>''));?></div>
<div>Date To</div><div><?=$this->Form->input('dto',array('type'=>'text','class'=>'','label'=>''));?></div>
<div>Additional Adults</div><div><?=$this->Form->input('noofadults',array('type'=>'select','class'=>'','label'=>''));?></div>
<div>Additional Children</div><div><?=$this->Form->input('noofchildren',array('type'=>'select','class'=>'','label'=>''));?></div>
<div>Coupon id</div><div><?=$this->Form->input('dfrom',array('type'=>'text','class'=>'','label'=>''));?></div>
<?=$this->Form->button('Cancel Booking',array('type'=>'button','class'=>''));?>
<?=$this->Form->button('Edit Booking',array('type'=>'button','class'=>''));?>
<?=$this->Form->button('Go Back',array('type'=>'button','class'=>'','onclick'=>'history.go(-1)'));?>
<?=$this->Form->end('Sumbit');?>
</div>