


<script>
    $(document).ready(function(){

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
		htm+="<td><img src=\"../../img/icons/add.png\" width=\"20\" onclick=\"addNew(this)\"/></td>";
		htm+="<td><img src=\"../../img/icons/edit.png\" width=\"20\" onclick=\"editDet(this)\"/></td>";		
		htm+="<td><img src=\"../../img/icons/delete.png\" width=\"20\" onclick=\"deletDet(this)\"/></td>";
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
		htmlObj= $.ajax({url:"/manager/Hotels/deletemeta/?metaName="+chkVal,async:false});
		$(obj.parentNode.parentNode).remove();
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
					
	htmlObj= $.ajax({url:"/manager/Hotels/addtometa/?metaName="+metaName+"&metaValue="+metaValue+"&chkVal1="+chkVal1+"&chkVal2="+chkVal2,async:false});
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
					alert("Meta Date Fields cann't be empoty and delete empty field!.");
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


        <div id="tabs">

			<ul>
				<li><a href="#hotel-details">Hotel details</a></li>
				<li><a href="#hotel-pictures"><span>Hotel Pictures</span></a></li>
				<li><a href="#hotel-room-types">Room types</a></li>				
                <li><a href="#hotel-rooms"><span>Rooms</span></a></li>
				<li><a href="#hotel-meal-plan">Meal Plan</a></li>
				<li><a href="#hotel-features">Features</a></li>
				<li><a href="#hotel-managers">Managers</a></li>
				<li><a href="#hotel-meta">Meta values</a></li>
			</ul>
    
  
        <div id="hotel-details">





    <div class="hotels form">
     <?php echo $this->Form->create('Hotel',array("enctype" => "multipart/form-data","name" => "frm","id"=>"frm" ));?>
	<fieldset>
 		<legend><?php __('Add Hotel'); ?></legend>
		<div style="float:left;width:100px;">Name :</div>
		<div style="float:left;">
			<?=$this->Form->input('Hotel.name',array('label'=>''));?>
		</div>
		<div style="clear:both;"></div>
		<div style="float:left;width:100px;">Address :</div>
		<div style="float:left;">
			<?=$this->Form->input('Hotel.address',array('label'=>''));?>
		</div>
		<div style="clear:both;"></div>
		<div style="float:left;width:100px;">Phone :</div>
		<div style="float:left;">
			<?=$this->Form->input('Hotel.phone',array('label'=>''));?>
		</div>
		<div style="clear:both;"></div>
		<div style="float:left;width:100px;">Email :</div>
		<div style="float:left;">
			<?=$this->Form->input('Hotel.email',array('label'=>''));?>
		</div>
		<div style="clear:both;"></div>
		<div style="float:left;width:100px;">Web :</div>
		<div style="float:left;">
		    <?=$this->Form->input('Hotel.web',array('label'=>''));?>	
		</div>
		<div style="clear:both;"></div>
		<div style="float:left;width:100px;">Subdomain :</div>
		<div style="float:left;">
			<?=$this->Form->input('Hotel.subdomain',array('type' => 'text','label' => false)); ?>
		</div>
		<div style="clear:both;"></div>
		<div style="float:left;width:100px;">Contactperson :</div>
		<div style="float:left;">	
		<?php //debug($contactperson); ?>
		    <?=$this->Form->input('Hotel.contactperson',array('options'=>$contactperson, 'label'=>'', 'empty'=>''));?>
		</div>
		<div style="clear:both;"></div>
		<div style="float:left;width:100px;">Starclass :</div>
		<div style="float:left;">
			<?php $options = array(''=>'Select','1'=>'One','2'=>'Two','3'=>'Three','4'=>'Four','5'=>'Five');?>
			<?=$this->Form->input('Hotel.starclass',array('options'=>$options, 'label'=>'' , 'empty'=>''));?>
		</div>
		<div style="clear:both;"></div>
				<div style="float:left;width:100px;">Logo :</div>
				<div style="float:left;">
					<?=$this->Form->input('Hotel.logo',array('type' => 'file','label' => false)); ?>
		</div>
		<div style="clear:both;"></div>
		<div style="float:left;width:100px;">Status :</div>
		<div style="float:left;">
		    <?=$this->Form->input('Hotel.status',array('label'=>''));?>
		</div>
		<div style="clear:both;"></div>
		<div style="float:left;width:100px;">Category :</div>
		<div style="float:left;">
		   <?=$this->Form->input('Hotel.category',array('label'=>'', 'empty'=>''));?>
		</div>	
		<div style="clear:both;"></div>
		<div style="float:left;width:100px;"></div>
		<div style="clear:both;"></div>
		<div style="float:left;width:100px;">Description :</div>
		<div style="float:left;">
		   <?=$this->Form->input('Hotel.description',array('label'=>'', 'empty'=>''));?>
		</div>
		<div style="clear:both;"></div>
		<div style="float:left;">
			<?=$this->Form->end(__('Submit', true)); ?>
		<div>
        </fieldset>
     
</div>
</div>








<div id="hotel-pictures">
<fieldset>
	<legend>Upload Photo</legend>
	
           <?= $this->Form->create('Hotel',array("enctype" => "multipart/form-data" ));?>
           <?= $this->Form->input('picture',array('type' => 'file','label' => false)); ?>
           <? // = $this->Form->input('id',array('type' => 'hidden','label' => false,'value' => $this->params['named']['hotel_id'])); ?>
          
    
	<?php echo $this->Form->end(__('Upload..', true)); ?>


</fieldset>
</div>

<div id="hotel-room-types">
<fieldset>
	<legend>Room Types</legend>
		<?=$this->Form->create('Hotel');?>
 		
		<div style="float:left;width:100px;">Name :</div>
		<div style="float:left;">
       		<?=$this->Form->input('HotelsRoomType.name',array('label'=>''));?>
		</div>
		<div style="clear:both;"></div>
		<div style="float:left;width:100px;">Price :</div>
		<div style="float:left;">
             <?=$this->Form->input('HotelsRoomType.price',array('label'=>''));?>
		</div>
		<div style="clear:both;"></div>
		<div style="float:left;width:100px;">Size :</div>
		<div style="float:left;">
			<?=$this->Form->input('HotelsRoomType.size',array('label'=>''));?>
		</div>
		<div style="clear:both;"></div>
		<div style="float:left;width:100px;">Info :</div>
		<div style="float:left;">
			<?=$this->Form->input('HotelsRoomType.info',array('label'=>''));?>
		</div>
		<div style="clear:both;"></div>
		<div style="float:left;width:100px;">View :</div>
		<div style="float:left;">
			<?=$this->Form->input('HotelsRoomType.view',array('label'=>'','options' => array('Garden'=>'Garden','Sea' => 'Sea' , 'Pond' => 'Pond' , 'NONE' => 'NONE'  )));?>
		</div>
		<div style="clear:both;"></div>
		<div style="float:left;width:100px;">Cooling :</div>
		<div style="float:left;">
			<?=$this->Form->input('HotelsRoomType.cooling',array('label'=>'','options' => array('AC' => 'AC' , 'Fan' => 'Fan' , 'NONE' => 'NONE')));?>
		</div>
		<div style="clear:both;"></div>
		<div style="float:left;width:100px;"></div>
		<div style="float:left;">
       	    <?=$this->Form->end(__('Save', true));?>
		</div>
</fieldset>
</div>

<div id="hotel-rooms">
   <fieldset>
	<legend>Room Capacity</legend>
 <?= $this->Form->create('Hotel');?>
                <?php

                echo $this->Form->input('HotelsRoomCapacity.rooms',array('value' =>'yes'));
                echo $this->Form->input('HotelsRoomCapacity.room_type_id');
                echo $this->Form->input('HotelsRoomCapacity.max_adults');
		echo $this->Form->input('HotelsRoomCapacity.max_children');
		echo $this->Form->input('HotelsRoomCapacity.additional_adult_charge');
		echo $this->Form->input('HotelsRoomCapacity.additional_child_charge');
		echo $this->Form->input('HotelsRoomCapacity.total_rooms');

                ?>
 <?php echo $this->Form->end(__('Save..', true)); ?>

</div>

<div id="hotel-meal-plan">
   <fieldset>
	<legend>Meal Plan</legend>
 <?= $this->Form->create('Hotel');?>
                <?php

                
                echo $this->Form->input('MealTypes.room_type_id');
                echo $this->Form->input('MealTypes.max_adults');
		echo $this->Form->input('MealTypes.max_children');
		echo $this->Form->input('MealTypes.additional_adult_charge');
		echo $this->Form->input('MealTypes.additional_child_charge');
		echo $this->Form->input('MealTypes.total_rooms');

                ?>
 <?php echo $this->Form->end(__('Save..', true)); ?>

</div>



<div id="hotel-features">
   <fieldset>
	<legend>Upload Photo</legend>

 <?= $this->Form->create('Hotel');?>

      <?php

                echo $this->Form->input('HotelsFeature.features',array('value' =>'yes','type' => 'hidden'));
                echo $this->Form->input('HotelsFeature.feature_category',array('options' =>array('Facilities' => 'Facilities','Sports and Recreation' => 'Sports and Recreation','Internet in Rooms' => 'Internet in Rooms','Car park' =>'Car park' )));
                echo $this->Form->input('HotelsFeature.feature');
                echo $this->Form->input('HotelsFeature.is_available', array('options' => array('YES' => 'YES', 'NO' => 'NO')));
		

      ?>
 <?= $this->Form->end(__('Save..', true)); ?>
  </fieldset>
</div>


<div id="hotel-managers">
 <div>
 	<input type='text' value='' id='managersearch' name='managersearch' /><input type='button' value='Search person..' />
 </div>
 <div>
 	<?php
	//print_r($managerDetails);
	?>
	<table id="searchdet">
		<tbody>
		</tbody>
		
	</table>
 </div>
 
</div>

<div id="hotel-meta">
	<div>Hotel meta&nbsp;<?php echo $html->image('icons/add.png',array("width" => "20px","onclick" => "addNew(this)")); ?></div>
	<div style="clear:both;"></div>	 
	<div>
	 
	<!-- <?= $this->Form->create('addmeta', array('url' => array('controller' => 'hotels', 'action' => 'addtometa')));?>-->
		
		<table id="metaTab">
		<?php 
		foreach($metaInfo as $key){
		?>
			<tr>
				<td><input type="text" value="<?php print($key['metainfo']['name']);?>" readonly="readonly" onkeyup="setToHidden(this);"/></td>
				<td><input type="text" value="<?php print($key['metainfo']['value']);?>" readonly="readonly"/></td>
				<td><?php echo $html->image('icons/add.png',array("width" => "20px","onclick" => "addNew(this)")); ?></td>
				<td><?php echo $html->image('icons/edit.png',array("width" => "20px","onclick" => "editDet(this)")); ?></td>
				<td><?php echo $html->image('icons/delete.png',array("width" => "20px","onclick" => "deletDet(this)")); ?></td>
				<td><input type="hidden" value="1"/></td> 
				<td><input type="hidden" value="<?php print($key['metainfo']['name']);?>"/></td> 
			</tr>
		<?php } ?>
		</table>
		<div style="clear:both;"></div>	 
		<div><input type='button' value='Save..' onclick="saveMeta();"/></div>
	<!--	<?= $this->Form->end(__('Save..', true)); ?>-->
	</div>
</div> 
</fieldset>



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