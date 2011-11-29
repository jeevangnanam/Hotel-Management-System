<script type="text/javascript">
function loadroomavailabity(){
	var rtid=$('#roomtypes').val()
	var dateFrom=$('#datefrom').val();
	var dateTo=$('#dateto').val();
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
		$.post("/Nodes/roomavailability/", { rtid: rtid,dateFrom:dateFrom,dateTo:dateTo},
		   function(data) {
			 $(".roomtypedes").html(data);
			// alert(data);
			  
		   });
	}
}
	
function loadCalander(obj){
 $('#datefrom').datepicker({ dateFormat: 'yy-mm-dd' });
 $('#dateto').datepicker({ dateFormat: 'yy-mm-dd' });
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

</script>
<style>
.detailLables{
	width: 100px;
}
.detailFields{
	width: 250px;
}
</style>
<?php
	foreach($hoteldets as $key=>$value){ ?>
		<div class="hoteldescontainer">
			<div class="hoteldets">
				<div class="hotelname">Hotel <?=$value['Hotel']['name'];?></div>
				<div class="clr"></div>
				<div class="hoteladdress"><span class="htllbl">Address :</span><span class="htldet"><?=$value['Hotel']['address'];?></span></div>
				<div class="clr"></div>
				<div class="hotelphone"><span class="htllbl">Phone :</span><span class="htldet"><?=$value['Hotel']['phone'];?></span></div>
				<div class="clr"></div>
				<div class="hotelweb"><span class="htllbl">Web :</span><span class="htldet"><?=$value['Hotel']['email'];?></span></div>
				<div class="clr"></div>
				<div class="hotelweb"><span class="htllbl">Email :</span><span class="htldet"><?=$value['Hotel']['web'];?></span></div>
				<div class="clr"></div>
				<div class="hoteladdress"><span class="htllbl">Contact person :</span><span class="htldet"><?=$value['Users']['first_name'];?> &nbsp;<?=$value['Users']['last_name'];?></span></div>
				<div class="clr"></div>
			</div>
			<?php $path='';
				 if(empty($value['HotelsPicture']['picture']))
					$path='no_photo.jpg';
				  else
				  	$path=$value['Hotel']['id']."/".$value['HotelsPicture']['picture'];
		    ?>
			<?php ?>
			<div class="imgbox"><img src="<?php echo $this->Html->webroot;?>uploads/hotels/<?=$path;?>" class="img" /></div>
        </div>
		<div class="clr"></div>
		<div class="roomdets"><?php //debug($hoteltypedets);?>
        <?php foreach($hoteltypedets as $key=>$value){ ?>
			<div class="roomtype"><?=$value['HotelsRoomType']['name'];?><div class="roomdests" onclick="loadPopUpnormal(<?=$value['Hotel']['id'];?>,<?=$value['HotelsRoomType']['id'];?>);"></div></div>
		<?php } ?>
		</div>
		<div class="clr"></div>
		<div class="hotelimages">
			<div ><?php //debug($loadHotelspics);?></div>
            <?php foreach($loadHotelspics as $key=>$value){ ?>
            <div style="float:left;margin:7px;border:dashed 1px #CCC;"><img src="<?php echo $this->Html->webroot;?>uploads/hotels/<?=$value['Hotel']['id'];?>/<?=$value['HotelsPicture']['picture'];?>" class="img" /></div>
            <?php } ?>
		</div>
        <div class="clr"></div>
        
<?php }?>
	<?=$this->Form->button('Booking Process', array('type'=>'button','class'=>'normalbtn','onclick'=>"loadRoomAvailability('".$hotelid."')"));?>
	<div id="popupContact" class="popupContact">
		<a id="popupContactClose"><?=$html->image('/img/icons/close.png',array('width'=>'20px'));?></a>
		
        <div style="" id="cap"><h1>Room Details</h1></div>
        <div class="clr"></div>
        <div class="">
        
        <?=$this->Form->input('roomtypes', array('type'=>'select','options'=>$roomopt ,'empty'=>'','class'=>'idate','label'=>''));?>
        <?=$this->Form->input('datefrom', array('type'=>'text','class'=>'idate','onclick'=>'loadCalander(this)','label'=>''));?>
        <?=$this->Form->input('dateto', array('type'=>'text','class'=>'idate','onclick'=>'loadCalander(this)','label'=>''));?>
        <?=$this->Form->button('Search',array('onclick'=>'loadroomavailabity()')); ?>
        </div>
		<p id="contactArea" class="contactArea">
			
		</p>
        <div class="roomtypedes">
        </div>
	</div>
	<div id="backgroundPopup" class="backgroundPopup"></div>

