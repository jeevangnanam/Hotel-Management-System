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
.searchroomsavl {
    float: left;
    font-size: 16px;
    width: 35%;
}
.detailFields {
    width: 250px;
}
.detailLables {
    width: 100px;
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
	padding: 0 10px;
}
/*.submit{
	display:none;
}*/
form label {
    display: block;
	font-weight: normal;
}
.roomTypes {
    border: 1px dotted #CCCCCC;
    float: left;
    margin-left: 20px;
    padding-left: 20px;
    width: 60%;
}
</style>
<script>

  
 $(document).ready(function(){ 
 $('#HotelDateFrom').datepicker({ dateFormat: 'yy-mm-dd' });
 $('#HotelDateTo').datepicker({ dateFormat: 'yy-mm-dd' });
 
	//$('.hotelLinks').click(function() {
		//var hotelid=this.id;
		/*var hotelid=<?=$hotelid; ?>;
		$('#rt').load('/manager/Index/setroomtypes/'+hotelid);*/
  		/*
			$.post("/manager/Index/setroomtypes/", { hotelid: hotelid},
		   function(data) {
			 $("#tabs").html(data);
			 alert(data);
			  
		   });*/
	//});
	
	
}
)

/*function showRoomDetails(obj){
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
}*/
function getRoomtypes(obj){
	//alert(obj);
    var rtid=$('#HotelRoomtype').val();
	$('#book'+rtid).val(0);
	var dateFrom=$("#HotelDateFrom").val();
	var dateTo=$("#HotelDateTo").val();
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
			 $(".roomtypedes").html(data);
			// alert(data);
			  
		   });
	}

}



function selectDiv(obj,id){
	var sr=0;
	if($(obj).is('.ediv')){
		$(obj).removeClass('ediv');
		$(obj).addClass('roomselected');
			sr=$('#book').val();
			$('#book').val(parseInt(sr)+1);
	}
	else{
		if($(obj).is('.roomselected')){
			$(obj).removeClass('roomselected');
			$(obj).addClass('ediv');
			   sr=$('#book').val();
			   $('#book').val(parseInt(sr)-1);
		}			
	}
}


function loadbookings(obj,hotelId,rtId){
	window.location.href = 'http://hotelms-dev.com/manager/index/booking/'+rtId;
	//$.ajax({url:"/manager/Index/booking",async:false})
}
</script>
<div class="container">
	<div> Hotel <?=$getHotels[0]['Hotel']['name']; ?></div>
    <div class="clr"></div>
	<div class="searchroomsavl">
     <?php //$rt=$dfrom=$dto=$roomavl=''?>
   	 <?php echo $this->Form->create('',array('action'=>'/bookingindex/'.$getHotels[0]['Hotel']['id']));?>
     <div class="heading">Search Room Availability</div>
     <?=$this->Form->input('tag',array('type'=>'hidden','value'=>'1'));?>
     <?=$this->Form->input('roomtype',array('type'=>'select','options'=>$rtyp,'label'=>'Room Type','empty'=>'','selected'=>$rt));?>
     <?=$this->Form->input('dateFrom',array('type'=>'text','label'=>'Date From','value'=>$dfrom));?>
     <?=$this->Form->input('dateTo',array('type'=>'text','label'=>'Date To','value'=>$dto));?>
     <?php //$this->Form->button('Search',array('type'=>'button','onclick'=>'getRoomtypes()'));?>
	 <?=$this->Form->end('Search');?>	
    	
        	<!--<?foreach($getHotels as $key=>$value){ ?>
            <div class="dv">
            
            <div class="btn" align="center">
			<?$this->Form->create('',array("action" => "/stathome/".$value['Hotel']['id'] ));?>
			<?$this->Form->end('Booking Info');?>
            </div>
            </div>
            <?}?>-->
        
    </div>
    <div class="roomTypes" style="background:#FFF;height:200px;">
        <?php
		$pages=1;
		$noofrooms=$noofroomsset;
			if($noofrooms > 100){
				$pages=$noofrooms/100;
			}
			$x='';
			$y=$noofrooms/10;
			$rest=$noofrooms%10;
		$start="<div class=\"xdiv\">";
		$end="</div>";
		$rType=$rTypestatus;
		$aCount=$pCount=0;
		if(count($rType) > 0){
			$aCount=$rType[0][0]['S'];
			//$pCount=$rType[1][0]['S'];
		}
		
		$empty='&nbsp';
		$approved='&nbsp';
		$proccessing='&nbsp';
		$a=$p=1;
		$roomDiv='';
		if($y==1){
			for($i=1; $i<11; $i++ ){
				if($aCount >= $a){
					$x.="<div class=\"adiv\" onclick=\"selectDiv(this,'".$rt."');\" id=\"\">$approved</div>";
					$a++;
				}
				else if ($pCount >= $p){
					$x.="<div class=\"pdiv\" onclick=\"selectDiv(this,'".$rt."');\">$proccessing</div>";
					$p++;
				}
				else{
					$x.="<div class=\"ediv\" onclick=\"selectDiv(this,'".$rt."');\">$empty</div>";
				}
				
			}
			$roomDiv= $start.$x.$end;
		}
		else if($noofrooms < 10 && $noofrooms <> 0){
			for($i=1; $i<10; $i++ ){
				if($aCount >= $a ){
						$x.="<div class=\"adiv\" onclick=\"selectDiv(this,'".$rt."');\">$approved</div>";
						$a++;
					}
				else if ($pCount >= $p){
						$x.="<div class=\"pdiv\" onclick=\"selectDiv(this,'".$rt."');\">$proccessing</div>";
						$p++;
					}
				else{
						$x.="<div class=\"ediv\" onclick=\"selectDiv(this,'".$rt."');\">$empty</div>";
					}
				
			}
				$roomDiv= $start.$x.$end;
		}
		else{
			for($i=1; $i<$noofrooms+1; $i++ ){
				if($i%10 == 1){
					$x.=$start;
				}
					if($aCount >= $a){
						$x.="<div class=\"adiv\" onclick=\"selectDiv(this,'".$rt."');\">$approved</div>";
						$a++;
					}
					else if ($pCount >= $p){
						$x.="<div class=\"pdiv\" onclick=\"selectDiv(this,'".$rt."');\">$proccessing</div>";
						$p++;
					}
					else{
						$x.="<div class=\"ediv\" onclick=\"selectDiv(this,'".$rt."');\">$empty</div>";
					}
				if($i%10 == 0){
					$x.=$end;
				}
				
			}
			$roomDiv= $x;
		}
		echo $roomDiv."<div class=\"clr\"></div><div class=\"bookdiv\"></div>";
	
        ?>
    </div>
    <div>
	<?=$this->Form->create('Booking',array('action'=>'/stepone/'));?>
    <?=$this->Form->input('book',array('id'=>'book','label'=>'','value'=>'0','readonly'=>'readonly'));?>
     <?=$this->Form->button('Book',array('type'=>'button'));?>
    <?=$this->Form->end('Book');?>
    </div>
</div>
	<div id="popupContact">
		<a id="popupContactClose"><?=$html->image('/img/icons/close.png',array('width'=>'20px'));?></a>
		<p id="contactArea">
			
		</p>
	</div>
	<div id="backgroundPopup"></div>
<!--<?$this->Form->create('',array("action" => "/stathome/".$value['Hotel']['id'] ));?>
			<?$this->Form->end('Booking Info');?>-->