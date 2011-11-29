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
</style>
<script>

  
 $(document).ready(function(){ 

 
	$('.hotelLinks').click(function() {
		var hotelid=$('.hotelLinks').attr('id');
		$('#rt').load('/manager/Index/setroomtypes/'+hotelid);
  		/*
			$.post("/manager/Index/setroomtypes/", { hotelid: hotelid},
		   function(data) {
			 $("#tabs").html(data);
			 alert(data);
			  
		   });*/
	});
	
	
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
	<div class="roomTypes">
    	<h3>Room Types </h3>
        <div id='rt'>
        
        </div>
    </div>
	<div class="holelList">
   	 	<h3>Hotels </h3>
    	<ul>
        	<?php foreach($getHotels as $key=>$value){ ?>
            <li><?=$this->Html->link($value['Hotel']['name'], '#', array('class' => 'hotelLinks','id'=>$value['Hotel']['id'])); ?></li>
            <?php }?>
        </ul>
    </div>
</div>
	<div id="popupContact">
		<a id="popupContactClose"><?=$html->image('/img/icons/close.png',array('width'=>'20px'));?></a>
		
        <div id="cap"><h1>Room Details</h1></div>
		<p id="contactArea">
			
		</p>
	</div>
	<div id="backgroundPopup"></div>
