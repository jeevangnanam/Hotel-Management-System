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
		background: none repeat scroll 0 0 #F7FAF6;
		border: 1px dashed #538136;
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
</style>

<script>
	$(document).ready(function(){ 

	$('#fromdate').datepicker({ dateFormat: 'yy-mm-dd' });
 	$('#todate').datepicker({ dateFormat: 'yy-mm-dd' });
	
	}
)
</script>

<div class="container">
	<div> Hotel <?=$hotels[0]['Hotel']['name'];?></div>
		<div class='clr'></div>
		<div class="calenederarea">
			<div id="fromdate" >Date From</div>
			<div id="todate">Date To</div>
			<div class='clr'></div>
			<div class="searchbtn">Search</div>
		</div>
		<div class="detailarea">
			<div>Booked Details</div>
			<div class='clr'></div>
			<div>Booked</div>
			<div class='clr'></div>
			<div>Pending</div>
			<div class='clr'></div>
			<div>Total</div>
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
				}

				if($value['Booking']['status']=='PROCESSING'){
					$pr+=$value[0]['noOfRooms'];
				}
				else if($value['Booking']['status']=='APPROVED'){
					$bk+=$value[0]['noOfRooms'];
				}
			?>
				
				<div><?=$name;?></div><div><?=$pr;?></div><div><?=$bk;?></div>
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