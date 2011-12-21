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
.tforroomtype{
	background: none repeat scroll 0 0 #E7E7E7;
    border: 1px dashed #CCCCCC;
    color: #336600;
    float: left;
    height: 20px;
    margin: 5px;
    padding-left: 10px;
    width: 335px;
}

.detailLables {
    background: none repeat scroll 0 0 #F7FAF6;
    border: 1px dashed #CCCCCC;
    color: #336600;
    float: left;
    height: 20px;
    margin: 5px;
    padding-left: 10px;
    width: 100px;
}
.detailFields {
    background: none repeat scroll 0 0 #F7FAF6;
    border: 1px dashed #CCCCCC;
    color: #336600;
    float: left;
    height: 20px;
    margin: 5px;	
    padding: 0 10px;
    width: 85px;
	text-align:right;
}
.fcell{
	border: 1px dashed transparent;
	width: 100px;
}
.lcell{
    width: 95px;
	text-align:center;
}
.bthead{
	width: 470px;
}
.btfoot{
	width: 460px;
	padding-right: 10px;
	text-align:right;
}
.cap {
    background: url("/img/booking_steps/box.png") repeat-x scroll 0 0 transparent;
    color: #336600;
    float: left;
    height: 40px;
    margin-bottom: 1px;
    padding-left: 10px;
    padding-top: 10px;
    text-align: left;
    width: 96%;
}
</style>

<script>
	$(document).ready(function(){ 

	$('#fromdate').datepicker({ dateFormat: 'yy-mm-dd' });
 	$('#todate').datepicker({ dateFormat: 'yy-mm-dd' });
	//$('#HotelFromdate').val($('#fromdate').val());
	//$('#HotelDateto').val($('#todate').val());
	
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
	<div class="cap"> Hotel <?=$hotels[0]['Hotel']['name'];?><?php $hid=$hotels[0]['Hotel']['id'];?></div>
		<div class='clr'></div>
		<div class="calenederarea">
		<?=$this->Form->create(array('id'=>'Nodes','action'=>"/stathome/$hid")); ?>
			<div id="fromdate" >Date From</div>
			<div id="todate">Date To</div>
			<div class='clr'></div>
			<div class="searchbtn">
				<div class="dCap fd">
					<?=$this->Form->input('fromdate',array('type'=>'text','label'=>'','class'=>'tf','readonly'=>'readonly','value'=>$dfrom));?>
				</div>
				<div class="dCap td">
					<?=$this->Form->input('dateto',array('type'=>'text','label'=>'','class'=>'tf','readonly'=>'readonly','value'=>$dto));?>
				</div>
				<?php echo $this->Form->end('Search'); ?>
			</div>
		</div>
		<div class="detailarea">
			<div class="tforroomtype">Booked Details </div>
			<div class='clr'></div>
			<div class="detailLables fcell"></div><div class='detailLables lcell'>Rooms Qty.</div><div class='detailLables lcell'>Income</div>
			<div class='clr'></div>
			<div class="detailLables">Booked</div><div class='detailFields'><?=$booked;?></div><div class='detailFields'><?=number_format($bookedPrc,2);?></div>
			<div class='clr'></div>
			<div class="detailLables">Process</div><div class='detailFields'><?=$process;?></div><div class='detailFields'> <?=number_format($processPrc,2);?></div>
			<div class='clr'></div>
			<div class="detailLables">Pending </div> <div class='detailFields'> <?=$pending;?></div>
			<div class='clr'></div>
			<div class="detailLables" >Total </div><div class='detailFields'><?=($booked+$process+$pending);?></div><div class='detailFields'> <?=number_format($income,2);?></div>
			<div class='clr'></div>
			<div class="tforroomtype">From : <?=$dfrom;?> - To : <?=$dto;?></div>
		</div>
		<div class='clr'></div>
		<div class="roomtypedetailarea">
			<div class="tforroomtype bthead">Room Type wise Details</div>
			<div class='clr'></div>
			<?php //debug($HotelsRoomType);
			$rt=$pr=$name='';$pr=$bk=0;?>
				<div class="detailLables">Room Type</div>
				<div class="detailLables">Status</div>
				<div class="detailLables">Rooms Qty.</div>
				<div class="detailLables">Income</div>
				<div class='clr'></div>
			<?php 
			
			foreach($HotelsRoomType as $key=>$value){
			$pr=$value['HotelsRoomType']['id'];
			if($rt=="" || $pr!=$rt){
				$rt=$value['HotelsRoomType']['id'];
				$pr="";?>
				<div class="detailLables"><?=$value['HotelsRoomType']['name'];?></div>
				<div class="detailLables"><?=$value['Booking']['status'];?></div>
				<div class="detailLables"><?=$value[0]['noOfRooms'];?></div>
				<div class="detailFields"><?=number_format($value[0]['estimated_price'],2);?></div>
			<?php }
			else{?>
				<div class="detailLables fcell">&nbsp;</div>
				<div class="detailLables"><?=$value['Booking']['status'];?></div>
				<div class="detailLables"><?=$value[0]['noOfRooms'];?></div>
				<div class="detailFields"><?=number_format($value[0]['estimated_price'],2);?></div>
			<?php }?>
			<div class='clr'></div>
			<?php }?>
			<div class="tforroomtype btfoot">
			<!-- Shows the page numbers -->
			<?php echo $paginator->numbers(); ?>
			<!-- Shows the next and previous links -->
			<?php
				echo $paginator->prev('« Previous ', null, null, array('class' => 'disabled'));
				echo $paginator->next(' Next »', null, null, array('class' => 'disabled'));
			?> 
			<!-- prints X of Y, where X is current page and Y is number of pages -->
			<?php echo $paginator->counter(); ?>
			<div>
	  </div>
</div>