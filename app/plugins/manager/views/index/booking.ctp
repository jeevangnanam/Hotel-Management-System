<h2><?php __('Room Details'); ?></h2>
<div>
<?php
	foreach($roomdets as $key=>$value){ ?>
	<div style="width:150px;float:left;">Hotel Name :</div>
	<div style="width:150px;float:left;"><?=$value['Hotel']['name'];?></div>
	<div style="clear:both;"></div>
	<div style="width:150px;float:left;">Room Type :</div>
	<div style="width:150px;float:left;"><?=$value['HotelsRoomType']['name'];?></div>
	<div style="clear:both;"></div>
	<div style="width:150px;float:left;">max_adults</div>
	<div style="width:150px;float:left;"><?=$value['HotelsRoomCapacities']['max_adults'];?></div>
	<div style="clear:both;"></div>
	<div style="width:150px;float:left;">max_children</div>
	<div style="width:150px;float:left;"><?=$value['HotelsRoomCapacities']['max_children'];?></div>
	<div style="clear:both;"></div>
	<div style="width:150px;float:left;">additional_adult_charge</div>
	<div style="width:150px;float:left;"><?=$value['HotelsRoomCapacities']['additional_adult_charge'];?></div>
	<div style="clear:both;"></div>
	<div style="width:150px;float:left;">additional_child_charge</div>
	<div style="width:150px;float:left;"><?=$value['HotelsRoomCapacities']['additional_child_charge'];?></div>
	<div style="clear:both;"></div>
	<div style="width:150px;float:left;">total_rooms</div>
	<div style="width:150px;float:left;"><?=$value['HotelsRoomCapacities']['total_rooms'];?></div>
	
	<?php }?>
</div>