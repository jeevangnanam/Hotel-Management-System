<div class="bookingEdits form">
<?php echo $this->Form->create('BookingEdit');?>
	<fieldset>
		<legend><?php __('Edit Booking Edit'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('ticket_id');
		echo $this->Form->input('user_id');
		echo $this->Form->input('hotel_id');
		echo $this->Form->input('room_type_id');
		echo $this->Form->input('number_of_rooms');
		echo $this->Form->input('from_date');
		echo $this->Form->input('end_date');
		echo $this->Form->input('estimated_price');
		echo $this->Form->input('coupon_id');
		echo $this->Form->input('notes');
		echo $this->Form->input('status');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('BookingEdit.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('BookingEdit.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Booking Edits', true), array('action' => 'index'));?></li>
	</ul>
</div>