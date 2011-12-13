<style>
	.calenederarea{
		float:left;
		width:55%;
		height:275px;
		background:#F7FAF6;
		border:dashed 1px #538136;
	}
	.detailarea{
		margin-left:5px;
		padding:5px;
		float:left;
		width:40%;
		background:#F7FAF6;
		border:dashed 1px #538136;
		height:300px;
	}
	.roomtypedetailarea{
		float:left;
		width:96.8%;
		background:#F7FAF6;
		border:dashed 1px #538136;
	}
	.searchbtn{
		/*background: none repeat scroll 0 0 #F7FAF6;
		border: 1px dashed #538136;*/
		float: left;
		margin-left: -1px;
		margin-top: 10px;
		padding: 5px;
		width: 98%;
		height:20px;
	}
	#fromdate,#todate{
		float:left;
		margin:8px;
	}
	#HotelFromdate{
		float:left;
		width:100px;
	}
	#HotelDateto{
		float:left;
		width:100px;
	}
	.dCap{
		float:left;
		width:100px;
	}
	.td{
		margin-left:150px;
	}
</style>

<script>
	$(document).ready(function(){ 

	$('#fromdate').datepicker({ dateFormat: 'yy-mm-dd' });
 	$('#todate').datepicker({ dateFormat: 'yy-mm-dd' });
	$('#HotelFromdate').val($('#fromdate').val());
	$('#HotelDateto').val($('#todate').val());
	
	$('#fromdate').click(function(){
		$('#HotelFromdate').val($('#fromdate').val());
	});
 	
	$('#todate').click(function(){
		$('#HotelDateto').val($('#todate').val());
	});
	}
)
</script>

<div class="container">
	<div> Hotel <?=$hotels[0]['Hotel']['name'];?><?php $hid=$hotels[0]['Hotel']['id'];?></div>
		<div class='clr'></div>
		<div class="calenederarea">
		<?=$this->Form->create(array('id'=>'Nodes','action'=>"/stathome/$hid")); ?>
			<div id="fromdate" >Date From</div>
			<div id="todate">Date To</div>
			<div class='clr'></div>
			<div class="searchbtn">
				<div class="dCap fd">
					<?=$this->Form->input('fromdate',array('type'=>'text','label'=>'','class'=>'tf','readonly'=>'readonly'));?>
				</div>
				<div class="dCap td">
					<?=$this->Form->input('dateto',array('type'=>'text','label'=>'','class'=>'tf','readonly'=>'readonly'));?>
				</div>
				<?php echo $this->Form->end('Search'); ?>
			</div>
		</div>
		<div class="detailarea">
			<div>Booked Details </div>
			<div class='clr'></div>
			<div>Booked<?=$booked;?> | <?=$bookedPrc;?></div>
			<div class='clr'></div>
			<div>Process<?=$process;?> | <?=$processPrc;?></div>
			<div class='clr'></div>
			<div>Pending | <?=$pending;?></div>
			<div class='clr'></div>
			<div>Total | <?=$income;?></div>
		</div>
		<div class='clr'></div>
		<div class="roomtypedetailarea">
			<div>Room Type Details</div>
			<div class='clr'></div>
			<?php //debug($HotelsRoomType);
			$rt=$pr=$name='';$pr=$bk=0;?>
			<?php foreach($HotelsRoomType as $key=>$value){
				if($value['HotelsRoomType']['id']!=$rt){
					$rt=$value['HotelsRoomType']['id'];
					$name=$value['HotelsRoomType']['name'];
					$pr=$bk=0;
				

				if($value['Booking']['status']=='PROCESSING'){
					$pr+=$value[0]['noOfRooms'];
				}
				else if($value['Booking']['status']=='APPROVED'){
					$bk+=$value[0]['noOfRooms'];
				} ?>
				<div><?=$name;?></div><div><?=$pr;?></div><div><?=$bk;?></div>
			<?php	}
			?>
				
				
			<?php }?>
			<!-- Shows the page numbers -->
<?php echo $paginator->numbers(); ?>
<!-- Shows the next and previous links -->
<?php
	echo $paginator->prev('« Previous ', null, null, array('class' => 'disabled'));
	echo $paginator->next(' Next »', null, null, array('class' => 'disabled'));
?> 
<!-- prints X of Y, where X is current page and Y is number of pages -->
<?php echo $paginator->counter(); ?>
		</div>
</div>