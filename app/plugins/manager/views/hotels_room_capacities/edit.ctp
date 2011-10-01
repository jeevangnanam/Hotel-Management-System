<script>
    $(document).ready(function(){
    
        $("#HotelsRoomCapacityHotelId").change(function(){
            
      
            $.ajax({
                url: "/manager/hotels_room_capacities/ajaxRoomTypeLoad/"+$(this).val(),
                context: document.body,
                beforeSend : function(){$("#crap").html('waiting...')},
                success: function(msg){
                    $("#ajaxRoomType").html(msg);
                }
            });
        });
        
    });
</script>
<div class="hotelsRoomCapacities form">
<?php echo $this->Form->create('HotelsRoomCapacity');?>
	<fieldset>
 		<legend><?php __('Edit Hotels Room Capacity'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('hotel_id');
		echo $this->Form->input('room_type_id',array('div'=> array('id'=>'ajaxRoomType'), 'options' => $hotelRoomTypes));
		echo $this->Form->input('max_adults');
		echo $this->Form->input('max_children');
		echo $this->Form->input('additional_adult_charge');
		echo $this->Form->input('additional_child_charge');
		echo $this->Form->input('total_rooms');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('HotelsRoomCapacity.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('HotelsRoomCapacity.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Hotels Room Capacities', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Hotels', true), array('controller' => 'hotels', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Hotel', true), array('controller' => 'hotels', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Hotels Room Types', true), array('controller' => 'hotels_room_types', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Hotel Room Type', true), array('controller' => 'hotels_room_types', 'action' => 'add')); ?> </li>
	</ul>
</div>