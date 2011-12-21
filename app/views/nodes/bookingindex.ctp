<style>
.cap {
    background: url("/img/booking_steps/box.png") repeat-x scroll 0 0 transparent;
    color: #336600;
    float: left;
    height: 40px;
    margin-bottom: 1px;
    padding-left: 10px;
    padding-top: 10px;
    text-align: left;
    width: 98.5%;
}
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
	background:#F7FAF6;
}
.detailFields {
    width: 250px;
}
.detailLables {
    width: 100px;
}
#NodeRoomtype{
	width:243px;
}
#NodeDateFrom,#NodeDateTo{
	width:100px;
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
#dsubmit{
	display:none;
}
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
	background:#F7FAF6;
}
#frmsearchavl div {
	float:left;
	margin-left:10px;
}
#frmsearch {
	background:#F7FAF6;
}
.rnr{
	border:0; color:#f6931f; font-weight:bold;width:100px;
}
.ui-slider-horizontal {
    height: 0.8em;
    width: 250px;
	margin-left:0px;
}
#amount{
	width:100px;
}
.rng{
	margin-left:0px;
	height:30px;
}
.srooms{
	border:dotted 1px;
    float: left;
    overflow-y:scroll;
    width: 400px;
	height:50px;	
}
#roomnos{
	display:none;
}
#errormsg {
    color: #D55E35;
}

</style>
<script>

  
 $(document).ready(function(){ 
 $('#NodeDateFrom').datepicker({ dateFormat: 'yy-mm-dd' });
 $('#NodeDateTo').datepicker({ dateFormat: 'yy-mm-dd' });
	$('#bookbtn').click(function() {
		if($('#book').val() > 0){
			var ids='';
			$(".srooms div").each(function() {
				  var pid=($(this).attr('id')+',').split('RP-');
				  ids += pid[1];
			})
			$('#roomnos').val(ids);
 		 	$('#frmbook').submit();
		}
	});
	
	$('#searchroomavl').click(function() {
		var HotelDateFrom =  $('#NodeDateFrom').val().length;
		var HotelDateTo = $('#NodeDateTo').val().length;

		$('.xdiv').html("");
		if($('#HotelRoomtype').val() == '' || HotelDateFrom == '0' || HotelDateTo == '0' ){
             $('#errormsg').html("* Required fields can not be empty.!");
		}
		else{
			$('#frmsearch').submit();
		}
	})
	
}
)

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
		$.post("/manager/Index/setroomavalability/", { rtid: rtid,dateFrom:dateFrom,dateTo:dateTo},
		   function(data) {
			 $(".roomtypedes").html(data);
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
			$('.srooms').append("<div id=\"RP-"+obj.id+"\" align=\"center\" class=\"rdiv\">"+obj.id+"</div>");
			
	}
	else{
		if($(obj).is('.roomselected')){
			$(obj).removeClass('roomselected');
			$(obj).addClass('ediv');
			   sr=$('#book').val();
			   $('#book').val(parseInt(sr)-1);
			   var id=$(obj).id;
			   $('#RP-'+obj.id).remove();
		}			
	}
}


function loadbookings(obj,hotelId,rtId){
	window.location.href = 'http://hotelms-dev.com/manager/index/booking/'+rtId;
}

$(function() {
		$( "#slider-range" ).slider({
			range: true,
			min: 1,
			max: 100,
			values: [ 1, 100 ],
			slide: function( event, ui ) {
				$( "#amount" ).val(ui.values[ 0 ] + " - " + ui.values[ 1 ] );
			}
		});
		$( "#amount" ).val($( "#slider-range" ).slider( "values", 0 ) +
			" - " + $( "#slider-range" ).slider( "values", 1 ) );
	});
	



</script>




<div class="container">
	<div class="cap"> Hotel <?=$getHotels[0]['Hotel']['name']; ?></div>
    <div class="clr"></div>
	<div class="searchroomsavl">
     <?php //$rt=$dfrom=$dto=$roomavl=''?>
   	 <?php echo $this->Form->create('',array('id'=>'frmsearch','action'=>'/bookingindex/'.$getHotels[0]['Hotel']['id']));?>
     <div class="heading">Search Room Availability</div>
     <div id="frmsearchavl">
	 <div id="errormsg"></div>
     <?=$this->Form->input('tag',array('type'=>'hidden','value'=>'1'));?>
     <?=$this->Form->input('roomtype',array('type'=>'select','options'=>$rtyp,'label'=>'Room Type','empty'=>'','selected'=>$rt));?>
     <?=$this->Form->input('dateFrom',array('type'=>'text','label'=>'Date From','value'=>$dfrom));?>
     <?=$this->Form->input('dateTo',array('type'=>'text','label'=>'Date To','value'=>$dto));?>


    <?=$this->Form->input('amount',array('id'=>'amount','class'=>'rnr','type'=>'text','label'=>'Room Number range','value'=>0,'readonly'=>"readonly"));?>
    <div class="rng">
    	<div id="slider-range"></div>
    </div>
     
     </div>
     <div class="clr">&nbsp;</div>
	 <?=$this->Form->button('Search',array('type'=>'button','id'=>'searchroomavl'));?>
	 <div id="dsubmit">
	 	<?=$this->Form->end('Search');?>	
     </div>
    </div>
    
    <div class="roomTypes" style="height:250px;">
    
    <div class="caps">
		<?=$this->Form->button('Available',array('type'=>'button','id'=>'ravlilable','class'=>'ravlilable'));?>
        <?=$this->Form->button('Processing',array('type'=>'button','id'=>'rprocessing','class'=>'rprocessing'));?>
		<?=$this->Form->button('Booked',array('type'=>'button','id'=>'rselected','class'=>'rselected'));?>
    </div>
    <div class="clr"></div>
        <?php
		$start="<div class=\"xdiv\">";
		$end="</div>";
		$empty='&nbsp';
		$approved='&nbsp';
		$proccessing='&nbsp';
		$roomDiv='';
		$x='';
		$appStr=$proStr='';
		$appStatus='';
		$aArray=$pArray=array();
		if(isset($data_in_booking_tblApp) && count($data_in_booking_tblApp) > 0){
			$i=0;
			foreach($data_in_booking_tblApp as $key => $value){
				$appStr	   .= $value['Booking']['rooms'].',';
			}
			$aArray = explode(',',substr($appStr,0,(strlen($appStr)-1)));
		}
		if(isset($data_in_booking_tblPro) && count($data_in_booking_tblPro) > 0){
			$i=0;
			foreach($data_in_booking_tblPro as $key => $value){
				$proStr	   .= $value['Booking']['rooms'].',';
			}
			$pArray = explode(',',substr($proStr,0,(strlen($proStr)-1)));
		}
		
		if(isset($hotel_room_numbs) && count($hotel_room_numbs) > 0 && $hotel_room_numbs != 0){
			for($i=0;$i < count($hotel_room_numbs); $i++ ){
				
				if(in_array($hotel_room_numbs[$i],$aArray)){
					$approved=$hotel_room_numbs[$i];
					$x.="<div id='".$hotel_room_numbs[$i]."' class=\"adiv\" onclick=\"selectDiv(this,'".$rt."');\" id=\"\">$approved</div>";
				}
				else if(in_array($hotel_room_numbs[$i],$pArray)){
					$proccessing=$hotel_room_numbs[$i];
					$x.="<div id='".$hotel_room_numbs[$i]."' class=\"pdiv\" onclick=\"selectDiv(this,'".$rt."');\">$proccessing</div>";
				}
				else{
					$empty=$hotel_room_numbs[$i];
					$x.="<div id='".$hotel_room_numbs[$i]."' class=\"ediv\" onclick=\"selectDiv(this,'".$rt."');\">$empty</div>";
				}
			}
			echo $roomDiv=$start.$x.$end;
		}
       
        ?>
    </div>
    <div class="bookfrm">
    <div class="srooms">
    
    </div>
	<?=$this->Form->create('Nodes',array('id'=>'frmbook','action'=>'/stepone/'));?>
    <?=$this->Form->input('roomcount',array('id'=>'book','label'=>'','value'=>'0','readonly'=>'readonly'));?>
    <?=$this->Form->input('fromDate',array('type'=>'hidden','id'=>'fromDate','label'=>'','value'=>$dfrom));?>
    <?=$this->Form->input('toDate',array('type'=>'hidden','id'=>'toDate','label'=>'','value'=>$dto));?>
    <?=$this->Form->input('rtype',array('type'=>'hidden','id'=>'rtype','label'=>'','value'=>$rt));?>
    <?=$this->Form->input('roomnos',array('type'=>'text','id'=>'roomnos','label'=>''));?>
    <?=$this->Form->button('Book',array('type'=>'button','id'=>'bookbtn'));?>
        <div id="dsubmit">
        <?=$this->Form->end('Book',array());?>
        </div>
    </div>
    <div class="clr"></div>
    
</div>