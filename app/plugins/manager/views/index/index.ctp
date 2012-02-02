<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<style>
	.detailLables{
		width:200px;
	}
	.detailFields{
		width:150px;
	}
	.btn{
		margin-left:50px;
		width:50px;
		
		float:left;
	}
	.hlink{
		float:left;
		width:200px;
	}
	.dv{
		float:left;
		width:100%;
		margin-bottom:5px;
	}
	.submit input {
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

.hotelname{
	float:left;
	width: 45%;
	height:30px;
	background:#F7FAF6;
	margin:2px;
}

.btns{
	float:left;
	width:13%;
	height:30px;
	text-align:center;
	background:#F7FAF6;
	margin:2px;
}
.main_row{
	float:left;
	width:50%;
	margin:5px;
}
.tpdiv,.btndiv{
	float:left;
}
.tpdiv{
	width:50%;
}
table{
	 width: 95%;	
}
th {
	width:auto;
	color:#72A946;	
	font-weight:bold;
	background:#F7F7F7;
	text-align:center;
}
td {
	width:auto;
	color:#72A946;	
	font-weight:bold;
	text-align:center;
	border-bottom:1px dashed #CCC;
}
#hotelName{
	width:40%;
}
.hotelName{
	text-align:left;
}
.pg-div {
    padding-left: 30px;
    width: auto;
}
</style>
<script>

  
 $(document).ready(function(){ 
	
}
)

function showRoomDetails(obj){
	 var rtid=$(obj).attr('id');
	$(".roomtypesearch"+rtid).slideToggle("slow");
		$(".roomtypesearch"+rtid).html("<div>From  <input type=\"text\" style=\"width: 70px;\" id=\"dateFrom\" name=\"data[bookingi][dateFrom]\" /> </div><div>To </div><div class='searcdiv'></div>");
}

function showRoomSearch(obj){	
	 var rtid=$(obj).attr('id');
	 var htm ="<div class=\"sdate\">Date From  </div>";
	 htm+="<div class=\"idate\"><input type=\"text\" style=\"width: 70px;\" id=\"dateFrom"+rtid+"\" name=\"data[bookings][dateFrom]\" onclick=\"loadCalander(this)\"/> </div>";
	 htm+="<div class=\"sdate\">Date To  </div>";
	 htm+="<div class=\"idate\"><input type=\"text\" style=\"width: 70px;\" id=\"dateTo"+rtid+"\" name=\"data[bookings][dateT0]\"  onclick=\"loadCalander(this)\" /> </div>";
	 htm+="<div class='searcdiv' id=\""+rtid+"\" onclick=\"getRoomtypes(this)\"></div>";
	//$(".roomtypesearch"+rtid).slideToggle("slow");
		document.getElementById("roomtypesearch"+rtid).innerHTML=htm;
}
function getRoomtypes(obj){
    var rtid=$(obj).attr('id');
	var dateFrom=$("#dateFrom"+rtid).val();
	var dateTo=$("#dateTo"+rtid).val();
	if(dateFrom==""){
		alert("Please select 'Date From'.");
		return false;
	}
	else if(dateTo==""){
		alert("Please select 'Date To'.");
		return false;
	}
	else{
		//$(".roomtypedes"+rtid).slideToggle("slow");
		$.post("/manager/Index/setroomavalability/", { rtid: rtid,dateFrom:dateFrom,dateTo:dateTo},
		   function(data) {
			 $(".roomtypedes"+rtid).html(data);
			// alert(data);
			  
		   });
	}

}

function loadCalander(obj){
 $('#'+obj.id).datepicker({ dateFormat: 'yy-mm-dd' });
 $('#'+obj.id).datepicker({ dateFormat: 'yy-mm-dd' });
}


function selectDiv(obj,id){
	var sr=0;
	if($(obj).is('.ediv')){
		$(obj).removeClass('ediv');
		$(obj).addClass('roomselected');
			sr=$('#book'+id).val();
			$('#book'+id).val(parseInt(sr)+1);
	}
	else{
		if($(obj).is('.roomselected')){
			$(obj).removeClass('roomselected');
			$(obj).addClass('ediv');
			   sr=$('#book'+id).val();
			   $('#book'+id).val(parseInt(sr)-1);
		}			
	}
}
function openPopUp(){
		 $('#tabs-1').load('/pages/shajah_shopping_popup/');
	}

function loadbookings(obj,hotelId,rtId){
	window.location.href = 'http://hotelms-dev.com/manager/index/booking/'+rtId;
	//$.ajax({url:"/manager/Index/booking",async:false})
}
</script>
<div class="container">
			<div class="topic">
            	Control Panel
            </div>
   	 		<div class="clr"></div>
            <div class="main_row">
            <div class="tpdiv">Add new Hotels</div>
            <div class="btndiv">
            	<?=$this->Form->create('Hotels',array("action" => "/add/" ));?>
			    <?=$this->Form->end('Add New Hotels');?>
             </div>
             </div>
             <div class="clr"></div>
             <div class="main_row">
             <div class="tpdiv">Edit Hotels</div>
             <div class="btndiv">   
                <?=$this->Form->create('Hotels',array("action" => "/edit/" ));?>
			    <?=$this->Form->end('Edit Hotels');?>
             </div>	 
            </div>
            <div class="clr"></div>
            <table>
            <thead>
            <tr>
            <th id="hotelName">Hotels</th>
            <th>Room Types</th>
            <th>Edit Rooms</th>
            <th>Booking Info</th>
            <th>Booking</th>
            </tr>
            </thead>
            <tbody>
			<?php foreach($getHotels as $key=>$value){ ?>
            <tr>
            <td class="hotelName"><?=$value['Hotel']['name']; ?></td>
            <td>
			<?=$this->Form->create('',array("action" => "/roomtypes/".$value['Hotel']['id'] ));?>
            <?=$this->Form->input('hotelid',array('type'=>'hidden','value'=>$value['Hotel']['id']));?>
			<?=$this->Form->end('Room Types');?>
            </td>
            <td>
			<?=$this->Form->create('',array("action" => "/editrooms/".$value['Hotel']['id'] ));?>
            <?=$this->Form->input('hotelid',array('type'=>'hidden','value'=>$value['Hotel']['id']));?>
			<?=$this->Form->end('Edit Rooms');?>
            </td>
            <td>
			<?php echo $this->Form->create('',array("action" => "/stathome/".$value['Hotel']['id'] ));?>
			<?=$this->Form->end('Booking Info');?>
            </td>
            <td>
			<?=$this->Form->create('',array("action" => "/bookingindex/".$value['Hotel']['id'] ));?>
            <?=$this->Form->input('hotelid',array('type'=>'hidden','value'=>$value['Hotel']['id']));?>
			<?=$this->Form->end('Booking');?>
            </td>
            </tr>
           
            <?php }?>
            </tbody>
        </table>
        <div class="clr"></div>
	<div class="pg-div">
	<!-- Shows the next and previous links -->
	<?php
		echo $paginator->prev('« Previous ', null, null, array('class' => 'disabled'));
	?>
	 <!-- Shows the page numbers -->
	<?php 
		echo $paginator->numbers();
		echo $paginator->next(' Next »', null, null, array('class' => 'disabled')); 
	?>
	
	<!-- prints X of Y, where X is current page and Y is number of pages -->
	<?php echo $paginator->counter(); ?>
	</div>
<div class="clr"></div>
    </div>
   