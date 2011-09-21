<div class="hotels form">
<?php echo $this->Form->create('Hotel');?>
	<fieldset>
 		<legend><?php __('Edit Hotel'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('address');
		echo $this->Form->input('phone');
		echo $this->Form->input('email');
		echo $this->Form->input('web');
		echo $this->Form->input('contactperson');
		echo $this->Form->input('starclass');
		echo $this->Form->input('status');
		echo $this->Form->input('Category');
		echo $this->Form->input('CategoryList');
		echo $this->Form->input('Feature');
		echo $this->Form->input('Manager');
		echo $this->Form->input('Metum');
		echo $this->Form->input('Picture');
		echo $this->Form->input('RoomCapacity');
		echo $this->Form->input('RoomType');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Hotel.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Hotel.id'))); ?></li>
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