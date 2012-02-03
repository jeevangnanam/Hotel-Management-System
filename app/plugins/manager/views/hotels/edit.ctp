<style>
.ui-widget-content {
    background: #FFFFFF;
    border: 1px solid #DDDDDD;
    color: #333333;
}
#frm,#hotel-room-types div{
	color:#538136;
}
fieldset legend{
	color: #72A946;
    font-size: 20px;
    font-weight: bold;
    height: 35px;
    margin-left: -10px;
    padding: 5px 0 5px 10px;
}
</style>
<?=  $html->script(array('/js/image_upload/jquery.imgareaselect-0.3.min'),false); ?>
<script>
    $(document).ready(function(){
		$('.setlogo').click(function(){
				if(confirm("Do you want set this image as the logo?")){
					htmlobj=$.ajax({url:"/manager/Hotels/setlogoimag/"+this.id,async:false});
				//	alert(htmlobj.responseText);
				}
				
			});
			
        $("#managersearch").change(function(){

            if($("#managersearch").val().length > 0){

			//alert($("#managersearch").val().length);
			}

           /*htmlObj= $.ajax({
                url: "/manager/Hotels/ajaxLoadManagesDetails/"+$(this).val(),
                context: document.body,
                beforeSend : function(){$("#crap").html('waiting...')},
                success: function(msg){
				 
                }
            });*/
			
			htmlObj= $.ajax({url:"/manager/Hotels/ajaxLoadManagesDetails/"+$(this).val(),async:false});
			var name=htmlObj.responseXML.getElementsByTagName("Name");
			var fName=htmlObj.responseXML.getElementsByTagName("fName");
			var lName=htmlObj.responseXML.getElementsByTagName("lName");
			var Email=htmlObj.responseXML.getElementsByTagName("Email");
			var website=htmlObj.responseXML.getElementsByTagName("website");
			var mobile=htmlObj.responseXML.getElementsByTagName("mobile");
			var home_phone=htmlObj.responseXML.getElementsByTagName("home_phone");
			
			var htm="";
			var tbl=document.getElementById('searchdet').tBodies[0];
			if(name.length < 1){
				tbl.innerHTML="";
			}
			for(var i=0;i<name.length;i++){
			    htm+="<tr><td><table style=\"background:#FFF;\"><tr>";
				htm+="<tr><td>Name</td>";
				htm+="<td>:"+name[i].childNodes[0].nodeValue+"</td></tr>";
				htm+="<td>First Name</td>";
				htm+="<td>:"+lName[i].childNodes[0].nodeValue+"</td>";
				htm+="</tr><tr>";
				htm+="<td>Last Name</td>";
				htm+="<td>:"+lName[i].childNodes[0].nodeValue+"</td>";
				htm+="</tr><tr>";
				htm+="<td>EMail</td>";
				htm+="<td>:"+Email[i].childNodes[0].nodeValue+"</td>";
				htm+="</tr><tr>";
				htm+="<td>Phone(Residence)</td>";
				htm+="<td>:"+home_phone[i].childNodes[0].nodeValue+"</td>";
				htm+="</tr><tr>";
				htm+="<td>Phone(Mobile)</td>";
				htm+="<td>:"+mobile[i].childNodes[0].nodeValue+"</td>";
				htm+="</tr><tr>";
				htm+="<td>Web Site</td>";
				htm+="<td>:"+website[i].childNodes[0].nodeValue+"</td>";
				htm+="</tr></table></td></tr>";
			}
				tbl.innerHTML=htm;
			
        });
 			
        
    });
	
	function addNew(obj){
		var rCount=document.getElementById('metaTab').rows.length;
		var htm="<tr id=\""+rCount+"\"><td><input type=\"text\" onkeyup=\"setToHidden(this);\"/></td><td><input type=\"text\" /></td>";
		htm+="<td><img src=\"/img/icons/add.png\" width=\"20\" onclick=\"addNew(this)\"/></td>";
		htm+="<td><img src=\"/img/icons/edit.png\" width=\"20\" onclick=\"editDet(this)\"/></td>";		
		htm+="<td><img src=\"/img/icons/delete.png\" width=\"20\" onclick=\"deletDet(this)\"/></td>";
		htm+="<td><input type=\"hidden\" value=\"\"/></td> ";
		htm+="<td><input type=\"hidden\" value=\"\"/></td> ";
		htm+="</tr>";
				
				
			$('#metaTab').append(htm);
	}
	
	function editDet(obj){
		$(obj.parentNode.parentNode.cells[0].childNodes[0]).removeAttr('readonly');
		$(obj.parentNode.parentNode.cells[1].childNodes[0]).removeAttr('readonly');
	}
	
	function deletDet(obj){
		var chkVal=obj.parentNode.parentNode.cells[6].childNodes[0].value;
		if(obj.parentNode.parentNode.cells[6].childNodes[0].value.trim()==""){
			chkVal=obj.parentNode.parentNode.cells[0].childNodes[0].value;
		}
		htmlObj= $.ajax({url:"/manager/Hotels/deletemeta/?metaName="+chkVal,async:false});
		if(htmlObj.responseText==1){
			alert('Meta value has been successfully deleted.');
			$(obj.parentNode.parentNode).remove();
		}
		else{
			alert('Meta value has been successfully deleted.');
		}
		
	}
	
	function saveMeta(){
			var tbl=document.getElementById('metaTab');
			var rCount=tbl.rows.length;
			var c=rCount;

			if(checkValidity(tbl,rCount)){
				for(var i=0;i<rCount;i++){
					var metaName=tbl.rows[i].cells[0].childNodes[0].value;
					var metaValue=tbl.rows[i].cells[1].childNodes[0].value;
					var chkVal1=tbl.rows[i].cells[5].childNodes[0].value;
					var chkVal2=tbl.rows[i].cells[6].childNodes[0].value;
					
	htmlObj= $.ajax({url:"/manager/Hotels/edittometa/?metaName="+metaName+"&metaValue="+metaValue+"&chkVal1="+chkVal1+"&chkVal2="+chkVal2,async:false});
						if(htmlObj.responseText==1){
							$(tbl.rows[i].cells[0].childNodes[0]).attr('readonly','readonly');
							$(tbl.rows[i].cells[1].childNodes[0]).attr('readonly','readonly');
							$(tbl.rows[i].cells[5].childNodes[0]).val(1);
							$(tbl.rows[i].cells[6].childNodes[0]).val(metaName);
							c--;
						}
						else if(htmlObj.responseText==0){
							alert("Please add hotel first.");
							return false;
						}
				}
				if(c==0){
					alert("Meta Date Successfully Saved.");
				}
			}
	}
	
	function checkValidity(tbl,rCount){
		var chk=1;
		if(rCount==0){
			alert("Please add a meta data.");
			return false;
		}
		for(var i=0;i<rCount;i++){
				var metaName=tbl.rows[i].cells[0].childNodes[0].value;
				var metaValue=tbl.rows[i].cells[1].childNodes[0].value;
				if(metaName=="" || metaValue==""){
					$('#flashMessage').html("Meta Date Fields cann't be empoty and delete empty field!.");
					chk=0;
					break;
				}
		}
		if(chk==0){
			return false;
			}
		else{
			return true;
			}
	}
	
	function setToHidden(obj){
		if(obj.parentNode.parentNode.cells[5].childNodes[0].value != 1){
			obj.parentNode.parentNode.cells[6].childNodes[0].value = obj.parentNode.parentNode.cells[0].childNodes[0].value;
		}
	}
</script>

<script>

$(document).ready(function(){;

$('#tabs').tabs();

$( "#tabs" ).tabs({ selected: <?=(isset($tab))?$tab:"0";?> });



$( 'html, body' ).animate( { scrollTop: 0 }, 0 );
});



</script>


<script>
    function deleteImage(obj,id){
		$.ajax({
                url: "/manager/Hotels/deleteImages/?id="+id,
                context: document.body,
                beforeSend : function(){$("#crap").html('waiting...')},
                success: function(msg){
					//$(obj.parentNode.parentNode.cells[1].childNodes[0]).addClass("");;
				 	alert(msg);
                }
            });
}
	function uploadNew(obj,frm){
		document.getElementById(frm).submit();
	}
</script>


        <div id="tabs">

			<ul>
				<li><a href="#hotel-details">Hotel details</a></li>
				<li><a href="#hotel-pictures"><span>Hotel Pictures</span></a></li>
				<li><a href="#hotel-room-types">Room types</a></li>
                <li><a href="#hotel-rooms"><span>Rooms</span></a></li>
				<li><a href="#hotel-features">Features</a></li>
				<!--<li><a href="#hotel-managers">Managers</a></li>-->
				<li><a href="#hotel-meta">Meta values</a></li>
			</ul>
    
  
<div id="hotel-details">
    <div class="hotels form">
     
	<fieldset>
 		<legend><?php __('Edit Hotel'); ?></legend>
<div style="float:left;width:60%">
	<?php

		  echo  $this->Form->create('Hotel',array("enctype" => "multipart/form-data","name" => "frm","id"=>"frm" ));
		  if(count($records) < 1){
		 	 $hid=$hname=$haddress=$hphone=$hemail=$hweb=$hcontact=$hstar=$hstatus=$subdomain=$description='';
		  }
		  else{
		    $hid=$records[0]['Hotel']['id'];
			$hname=$records[0]['Hotel']['name'];
			$haddress=$records[0]['Hotel']['address'];
			$hphone=$records[0]['Hotel']['phone'];
			$hemail=$records[0]['Hotel']['email'];
			$hweb=$records[0]['Hotel']['web'];
			$hcontact=$records[0]['Hotel']['contactperson'];
			$hstar=$records[0]['Hotel']['starclass'];
			$hstatus=$records[0]['Hotel']['status'];
			$subdomain=$records[0]['Hotel']['subdomain'];
			$description=$records[0]['Hotel']['description'];
		  }
		?>
				<div style="width:25%;float:left;">Name :</div>
				<div style="width:75%;float:left;">
				
					<?php echo $this->Form->input('act', array('type' => 'hidden','label'=>'','value'=>'editHotelInfo')); ?>
					<?php echo $this->Form->input('Hotel.id', array('type' => 'hidden','label'=>'','value'=>$hid)); ?>
					<?php echo $this->Form->input('Hotel.name', array('type' => 'text','label'=>'','value'=>$hname)); ?>
				</div>
				
				<div style="width:100%;clear:both;">&nbsp;</div>
				<div style="width:25%;float:left;">Address :</div>
				<div style="width:75%;float:left;">
					<?php echo $this->Form->input('Hotel.address', array('type' => 'text','label'=>'','value'=>$haddress)); ?>
				</div>
				
				<div style="width:100%;clear:both;">&nbsp;</div>
				<div style="width:25%;float:left;">Phone :</div>
				<div style="width:75%;float:left;">
					<?php echo $this->Form->input('Hotel.phone', array('type' => 'text','label'=>'','value'=>$hphone)); ?>
				</div>
				
				<div style="width:100%;clear:both;">&nbsp;</div>
				<div style="width:25%;float:left;">Email :</div>
				<div style="width:75%;float:left;">
					<?php echo $this->Form->input('Hotel.email', array('type' => 'text','label'=>'','value'=>$hemail)); ?>
				</div>
				<div style="width:100%;clear:both;">&nbsp;</div>
				<div style="width:25%;float:left;">Subdomain :</div>
				<div style="width:75%;float:left;">
					<?=$this->Form->input('Hotel.subdomain',array('type' => 'text','value'=>$subdomain,'label' => false)); ?>
				</div>
				
				<div style="width:100%;clear:both;">&nbsp;</div>
				<div style="width:25%;float:left;">Web :</div>
				<div style="width:75%;float:left;">
					<?php echo $this->Form->input('Hotel.web', array('type' => 'text','label'=>'','value'=>$hweb)); ?>
				</div>
				
				<div style="width:100%;clear:both;">&nbsp;</div>
				<div style="width:25%;float:left;">Contactperson :</div>
				<div style="width:75%;float:left;">
					<?php echo $this->Form->input('Hotel.contactperson',array('options'=>$contactperson, 'label'=>'', 'selected'=>$hcontact ,'empty'=>''));  ?>
				</div>
				
				<div style="width:100%;clear:both;">&nbsp;</div>
				<div style="width:25%;float:left;">Starclass :</div>
				<div style="width:75%;float:left;">
				<?php 
					$options = array(''=>'Select','1'=>'One','2'=>'Two','3'=>'Three','4'=>'Four','5'=>'Five');
					echo $this->Form->input('Hotel.starclass',array('options'=>$options, 'label'=>'' , 'selected'=>$hstar));
				?>
				</div>
				<div style="width:100%;clear:both;">&nbsp;</div>
				<div style="width:25%;float:left;">Logo :</div>
				<div style="width:75%;float:left;">
					<?=$this->Form->input('Hotel.logo',array('type' => 'file','label' => false)); ?>
				</div>
				<div style="width:100%;clear:both;">&nbsp;</div>
				<div style="float:left;width:100px;">Description :</div>
				<div style="float:left;">
				   <?=$this->Form->input('Hotel.description',array('label'=>'', 'value'=>$description));?>
				</div>
				<div style="width:25%;float:left;">Status :</div>
				<div style="width:75%;float:left;">
					<?php echo $this->Form->input('Hotel.status',array('type' => 'checkbox','label'=>'','checked'=>$hstatus)); ?>
				</div>
		   		<?php echo $this->Form->end(__('Submit', true));
		

	?>
	</div>
	<div style="float:left;width:40%;">
	<?php foreach($hotelDets as $key=>$value){ ?>
		<div >
		<?php 
		$hotid=$value['Hotel']['id'];
		$name=$value['Hotel']['name'];?>
		<div style="float:left;width:100%;border-bottom:dashed 1px #538136;">
			<?=$this->Html->link("$name", "/manager/hotels/edit/loadhotelinfo/$hotid", array('class' => 'button', 'target' => '_self'));?>
	    </div>
		</div>
	<?php } ?>
	<?php //debug($hotelspage);?>
	
	</div>
        </fieldset>
     
</div>
</div>

<div id="hotel-pictures">
<fieldset>
	<legend>Edit  Photo</legend>
	<div style="float:left;width:60%">
			
			<div style="float:left;">Hotel Name :<?=$hotelname;?></div>
		 	<div style="float:left;width:100%">
			<?php 
			$hotelid=$picid='';
			if(count($hotelimages) > 0){ 
				foreach($hotelimages as $key=>$value){
				$hotelid=$value['HotelsPicture']['hotel_id'];
				$hotelImage=$value['HotelsPicture']['picture'];
				$picid=$value['HotelsPicture']['id'];
			?>
					<?php $img=$this->webroot."uploads/hotels/$hotelid/$hotelImage";?>
					<img class="setlogo" id="<?=$picid;?>"src="<?php echo $img; ?>" style="width:50px;height:50px;"/>
			<?php 
				}
			}
			else {
				$img=$this->webroot."img/no_photo.jpg"; ?>
				<img src="<?php echo $img; ?>" style="width:50px;"/>
			<?php }
			?>
			</div>
	
	</div>	
	<div style="float:left;width:40%">
		<?=$this->Form->create('Hotel',array("enctype" => "multipart/form-data" ,"name" => "frm","id"=>"frm"));?>
		<?=$this->Form->input('HotelsPicture.picture',array('type' => 'file','label' => false)); ?>
		<?=$this->Form->input('act', array('type' => 'hidden','label'=>'','value'=>'uploadNewImage')); ?>
		<?=$this->Form->input('HotelsPicture.hotel_id', array('type' => 'hidden','label'=>'','value'=>$hotelid)); ?>
	    <?=$this->Form->input('HotelsPicture.id', array('type' => 'hidden','label'=>'','value'=>$picid)); ?>
		<?=$this->Form->end(__('Upload..', true)); ?>
	</div>

</fieldset>
</div>
<div id="hotel-room-types">
<fieldset>
	<legend>Room Details</legend>
<div style="float:left;width:50%">

 <?php

 	$hotelID=$hotelName=$hotelRoomTypeId=$hotelRoomTypeRT=$hotelRoomPrice=$hotelRoomSize=$hotelRoomInfo=$hotelRoomView=$hotelRoomView=$hotelRoomCooling='';
	if(count($loadhotelroomtypesdes) > 0){
		$hotelRoomTypeId=$loadhotelroomtypesdes[0]['HotelsRoomType']['id'];
		$hotelRoomTypeRT=$loadhotelroomtypesdes[0]['HotelsRoomType']['name'];
		$hotelRoomPrice=$loadhotelroomtypesdes[0]['HotelsRoomType']['price'];
		$hotelRoomSize=$loadhotelroomtypesdes[0]['HotelsRoomType']['size'];
		$hotelRoomInfo=$loadhotelroomtypesdes[0]['HotelsRoomType']['info'];
		$hotelRoomView=$loadhotelroomtypesdes[0]['HotelsRoomType']['view'];
		$hotelRoomCooling=$loadhotelroomtypesdes[0]['HotelsRoomType']['cooling'];
		//$hotelid=$loadhotelroomtypesdes[0]['HotelsRoomType']['hotel_id'];
	}
	
	
	echo $this->Form->create('Hotel',array("name" => "frm","id"=>"frm" ))
	?>
		<div style="width:25%;float:left;">Hotel Name :</div>
		<div style="width:75%;float:left;">
		<?=$hotelname;?>
		</div>
		
		<div style="clear:both;">&nbsp;</div>
		<div style="width:25%;float:left;">Room Type :</div>
		<div style="width:75%;float:left;">
		<?php echo $this->Form->input('act', array('type' => 'hidden','label'=>'','value'=>'editRoomTypes')); ?>
		<?php echo $this->Form->input('HotelsRoomType.hotel_id', array('type' => 'hidden','label'=>'','value'=>$hotelid)); ?>
		<?php echo $this->Form->input('HotelsRoomType.id', array('type' => 'hidden','label'=>'','value'=>$hotelRoomTypeId)); ?>
		<?php echo $this->Form->input('HotelsRoomType.name', array('type' => 'text','label'=>'','value'=>$hotelRoomTypeRT)); ?>
		</div>
		
		<div style="clear:both;">&nbsp;</div>
		<div style="width:25%;float:left;">Price :</div>
		<div style="width:75%;float:left;">
		<?php echo $this->Form->input('HotelsRoomType.price', array('type' => 'text','label'=>'','value'=>$hotelRoomPrice)); ?>
		</div>
		
		<div style="clear:both;">&nbsp;</div>
		<div style="width:25%;float:left;">Room Size :</div>
		<div style="width:75%;float:left;">
		<?php echo $this->Form->input('HotelsRoomType.size', array('type' => 'text','label'=>'','value'=>$hotelRoomSize)); ?>
		</div>
		
		<div style="clear:both;">&nbsp;</div>
		<div style="width:25%;float:left;">Room Info :</div>
		<div style="width:75%;float:left;">
		<?php echo $this->Form->input('HotelsRoomType.info', array('type' => 'text','label'=>'','value'=>$hotelRoomInfo)); ?>
		</div>
		
		<div style="clear:both;">&nbsp;</div>
		<div style="width:25%;float:left;">Room View :</div>
		<div style="width:75%;float:left;">
		<?php echo $this->Form->input('HotelsRoomType.view',array('options'=>array('Garden'=>'Garden','Sea' => 'Sea' , 'Pond' => 'Pond' , 'NONE' => 'NONE'  ), 'label'=>'' , 'selected'=>$hotelRoomView)); ?>
		</div>
		
		<div style="clear:both;">&nbsp;</div>
		<div style="width:25%;float:left;">Cooling :</div>
		<div style="width:75%;float:left;">
		<?php echo $this->Form->input('HotelsRoomType.cooling',array('options'=>array('AC' => 'AC' , 'Fan' => 'Fan' , 'NONE' => 'NONE'), 'label'=>'' , 'selected'=>$hotelRoomCooling)); ?>
		</div>
	<?php 
	 echo $this->Form->end(__('Update', true)); 


?>
 </div>    
 <div style="float:left;width:45%">

	
		<div>	
		<?php if(count($roomTypes) > 0){ 
				foreach($roomTypes as $key=>$value){?>
			<div style="float:left;width:100%;border-bottom:dashed 1px #538136;">
				<?=$this->Html->link($value['HotelsRoomType']['name'], "/manager/hotels/edit/changehotelroomtypes/".$value['HotelsRoomType']['id'], array('class' => 'button', 'target' => '_self'));?>
			</div>
		<?php }
		} ?>
		</div>

	</div>     
</fieldset>
</div>

<div id="hotel-rooms">
   <fieldset>
	<legend>Hotels Room Capacity</legend>
 	<div style="float:left;width:60%"> 
 			<?php
			$hotelID=$hotelRoomCapId=$hotelName=$hotelRoomTypes=$hotelRoomCapTypeId=$hotelRoomCapTypes=$hotelRoomCapMaxAdults=$hotelRoomCapMaxChildren=$hotelRoomCapAdditionalAdultCharge=$hotelRoomCapAdditionalChildCharge=$hotelRoomCapTotalRooms='';

			if(count($roomcapacitydes) > 0){
				$hotelRoomCapId =$roomcapacitydes[0]['HotelsRoomCapacity']['id'];
				$hotelID = $roomcapacitydes[0]['HotelsRoomCapacity']['hotel_id'];
				$hotelRoomCapTypeId=$roomcapacitydes[0]['HotelsRoomCapacity']['room_type_id'];
				$hotelRoomCapTypes=$roomcapacitydes[0]['HotelsRoomType']['name'];
				$hotelRoomCapMaxAdults=$roomcapacitydes[0]['HotelsRoomCapacity']['max_adults'];
				$hotelRoomCapMaxChildren=$roomcapacitydes[0]['HotelsRoomCapacity']['max_children'];
				$hotelRoomCapAdditionalAdultCharge=$roomcapacitydes[0]['HotelsRoomCapacity']['additional_adult_charge'];
				$hotelRoomCapAdditionalChildCharge=$roomcapacitydes[0]['HotelsRoomCapacity']['additional_child_charge'];
				$hotelRoomCapTotalRooms=$roomcapacitydes[0]['HotelsRoomCapacity']['total_rooms'];
			}/**/

		//debug($roomCapacity);
			echo $this->Form->create('Hotel',array("name" => "frm","id"=>"frm", ));
			?>
			<div style="width:40%;float:left;">Hotel Name :</div>
			<div style="width:60%;float:left;">			
				<?=$hotelname;?>
			</div>
			
			<div style="clear:both;">&nbsp;</div>
			<div style="width:40%;float:left;">Rooms :</div>
			<div style="width:60%;float:left;">
				<?php echo $this->Form->input('act', array('type' => 'hidden','label'=>'','value'=>'editRoomCapacity'));?>
				<?php echo $this->Form->input('HotelsRoomCapacity.rooms', array('type' => 'text','label'=>'','value' =>'yes')); ?>	
			</div>
			
			<div style="clear:both;">&nbsp;</div>
			<div style="width:40%;float:left;">Room Type :</div>
			<div style="width:60%;float:left;">	
			<?php 
				$rTypes=array();
				foreach($roomTypes as $key=>$value){
					$rTypes[$value['HotelsRoomType']['id']]=$value['HotelsRoomType']['name'];
				}
				
				if($hotelRoomCapTypeId==''){
					$hotelRoomCapTypeId=$hotelRoomTId;
				}
			?>
				<?php echo $this->Form->input('HotelsRoomCapacity.room_type_id',array('options'=>$rTypes, 'label'=>'' , 'selected'=>$hotelRoomCapTypeId ,'empty'=>'')); ?>
		
				<?php echo $this->Form->input('HotelsRoomCapacity.id', array('type' => 'hidden','label'=>'Room Type','value'=>$hotelRoomCapId));?>
				
			</div>
			
			<div style="clear:both;">&nbsp;</div>
			<div style="width:40%;float:left;">Max Adults :</div>
			<div style="width:60%;float:left;">
				<?php echo $this->Form->input('HotelsRoomCapacity.max_adults', array('type' => 'text','label'=>'','value'=>$hotelRoomCapMaxAdults));?>
			</div>
			
			<div style="clear:both;">&nbsp;</div>
			<div style="width:40%;float:left;">Max Children :</div>
			<div style="width:60%;float:left;">	
				<?php echo $this->Form->input('HotelsRoomCapacity.max_children', array('type' => 'text','label'=>'','value'=>$hotelRoomCapMaxChildren));?>
			</div>
			
			<div style="clear:both;">&nbsp;</div>
			<div style="width:40%;float:left;">Additional Adult Charge :</div>
			<div style="width:60%;float:left;">	
				<?php echo $this->Form->input('HotelsRoomCapacity.additional_adult_charge', array('type' => 'text','label'=>'','value'=>$hotelRoomCapAdditionalAdultCharge));?>
			</div>
			
			<div style="clear:both;">&nbsp;</div>
			<div style="width:40%;float:left;">Additional Child Charge :</div>
			<div style="width:60%;float:left;">
				<?php echo $this->Form->input('HotelsRoomCapacity.additional_child_charge', array('type' => 'text','label'=>'','value'=>$hotelRoomCapAdditionalChildCharge));?>
			</div>
			
			<div style="clear:both;">&nbsp;</div>
			<div style="width:40%;float:left;">Total Rooms :</div>
			<div style="width:60%;float:left;">
				<?php echo $this->Form->input('HotelsRoomCapacity.total_rooms', array('type' => 'text','label'=>'','value'=>$hotelRoomCapTotalRooms));?>
			</div>	
				<?php echo $this->Form->end(__('Save..', true)); ?>

	</div>    
 <div style="float:left;width:40%">
 	<?php //debug($roomcapacitys);?>
	<?php foreach($roomcapacitys as $key=>$value){ ?>
		
			<div style="float:left;width:100%;border-bottom:dashed 1px #538136;">
				<?=$this->Html->link($value['HotelsRoomType']['name'], "/manager/hotels/edit/loadroomcapacitydes/".$value['HotelsRoomType']['id'], array('class' => 'button', 'target' => '_self'));?>
			</div>
	<?php } ?>
	</div>  
	</fieldset> 
</div>

<div id="hotel-features">
   <fieldset>
	<legend>Update Hotel Features</legend>
	<div style="float:left;width:60%">
      <?php 
	  		$hotelID=$hotFId=$hotFCat=$hotF=$hotFIsAvl='';
			
	  //foreach($features as $key=>$value){ 
	//  debug($laodfeturedes);
	  	if(count($laodfeturedes) > 0){
			$hotelID = $laodfeturedes[0]['Hotel']['id'];
			$hotFId=$laodfeturedes[0]['HotelsFeatures']['id'];
			$hotFCat=$laodfeturedes[0]['HotelsFeatures']['feature_category'];
			$hotF=$laodfeturedes[0]['HotelsFeatures']['feature'];
			$hotFIsAvl=$laodfeturedes[0]['HotelsFeatures']['is_available'];
		}	?>
		<div style="width:30%;float:left;">Hotel Name :</div>
			<div style="width:60%;float:left;">			
				<?=$hotelname;?>
		</div>
			
	  		<?=$this->Form->create('Hotel',array("name" => "frmF","id"=>"frmF" ));?>
			<?=$this->Form->input('act', array('type' => 'hidden','label'=>'','value'=>'editfeatures'));?>
			<?=$this->Form->input('HotelsFeature.id',array('value' =>$hotFId,'type' => 'hidden'));?>
		<div style="clear:both;">&nbsp;</div>
		<div style="width:30%;float:left;">Facilities :</div>
		<div style="width:60%;float:left;">
			<?=$this->Form->input('HotelsFeature.feature_category',array('options'=>array('Facilities' => 'Facilities','Sports and Recreation' => 'Sports and Recreation','Internet in Rooms' => 'Internet in Rooms','Car park' =>'Car park' ), 'label'=>'' , 'selected'=>$hotFCat));?>
		</div>
		<div style="clear:both;">&nbsp;</div>
		<div style="width:30%;float:left;">Feature :</div>
		<div style="width:60%;float:left;">
			<?=$this->Form->input('HotelsFeature.feature',array('type' => 'text','label'=>'','value'=>$hotF));?>
		</div>
		<div style="clear:both;">&nbsp;</div>
		<div style="width:30%;float:left;">Is Available :</div>
		<div style="width:60%;float:left;">
			
			<?=$this->Form->input('HotelsFeature.is_available',array('options'=>array('YES' => 'YES', 'NO' => 'NO'), 'label'=>'' , 'selected'=>$hotFIsAvl));?>
        </div>
		<div style="clear:both;">&nbsp;</div>
		<div style="width:30%;float:left;"></div>
		<div style="width:60%;float:left;">
			<?=$this->Form->end(__('Update', true));?>
		</div>
  </div>
  <div style="float:left;width:40%">	
		<?php foreach($loadfeaturelist as $key=>$value){ ?>
			<div style="float:left;width:100%;border-bottom:dashed 1px #538136;">
				<?=$this->Html->link($value['HotelsFeatures']['feature'], "/manager/hotels/edit/loadfeatures/".$value['HotelsFeatures']['id'], array('class' => 'button', 'target' => '_self'));?>
			</div>
	<?php } ?>
	</div>  
  </fieldset>
</div>

<div id="hotel-meta">
	<fieldset>
	<legend>Hotel meta</legend>
	<div>&nbsp;<?php echo $html->image('icons/add.png',array("width" => "20px","onclick" => "addNew(this)")); ?></div>
	<div style="clear:both;"></div>	 
	<div>
	 
	<!-- <?= $this->Form->create('addmeta', array('url' => array('controller' => 'hotels', 'action' => 'addtometa')));?>-->
		
		<table id="metaTab">
		<?php 
		
		foreach($metaInfo as $key=>$value){
		?>
			<tr>
				<td><input type="text" value="<?=$value['metainfo']['name'];?>" readonly="readonly" onkeyup="setToHidden(this);"/></td>
				<td><input type="text" value="<?=$value['metainfo']['value'];?>" readonly="readonly"/></td>
				<td><?php echo $html->image('icons/add.png',array("width" => "20px","onclick" => "addNew(this)")); ?></td>
				<td><?php echo $html->image('icons/edit.png',array("width" => "20px","onclick" => "editDet(this)")); ?></td>
				<td><?php echo $html->image('icons/delete.png',array("width" => "20px","onclick" => "deletDet(this)")); ?></td>
				<td><input type="hidden" value="1"/></td> 
				<td><input type="hidden" value="<?php $value['metainfo']['name'];?>"/></td> 
			</tr>
		<?php } ?>
		</table>
		<div style="clear:both;"></div>	 
		<div><input type='button' value='Save..' onclick="saveMeta();"/></div>
	<!--	<?= $this->Form->end(__('Save..', true)); ?>-->
	</div>
	</fieldset>
</div> 


<div class="actions" style="display:none">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Hotels', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Bookings', true), array('controller' => 'bookings', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Booking', true), array('controller' => 'bookings', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Hotels Categories', true), array('controller' => 'hotels_categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Category', true), array('controller' => 'hotels_categories', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Hotels Category Lists', true), array('controller' => 'hotels_category_lists', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Category List', true), array('controller' => 'hotels_category_lists', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Hotels Features', true), array('controller' => 'hotels_features', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Feature', true), array('controller' => 'hotels_features', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Hotels Managers', true), array('controller' => 'hotels_managers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Manager', true), array('controller' => 'hotels_managers', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Meta', true), array('controller' => 'meta', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Metum', true), array('controller' => 'meta', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Hotels Pictures', true), array('controller' => 'hotels_pictures', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Picture', true), array('controller' => 'hotels_pictures', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Hotels Room Capacities', true), array('controller' => 'hotels_room_capacities', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Room Capacity', true), array('controller' => 'hotels_room_capacities', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Hotels Room Types', true), array('controller' => 'hotels_room_types', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Room Type', true), array('controller' => 'hotels_room_types', 'action' => 'add')); ?> </li>
	</ul>
</div>