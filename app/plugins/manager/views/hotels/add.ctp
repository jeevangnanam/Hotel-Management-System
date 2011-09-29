<script>

$(document).ready(function(){
$('#tabs').tabs();
$('#tabs ul li a').click(function () {location.hash = $(this).attr('href');});
$( 'html, body' ).animate( { scrollTop: 0 }, 0 );
});

</script>

<div id="tabs">

			<ul>
				<li><a href="#tabs-1">Hotel details</a></li>
				<li><a href="/manager/hotelsPictures/add"><span>Hotel Pictures</span></a></li>
				<li><a href="/manager/hotelsPictures/add"><span>Rooms</span></a></li>
				 
				<li><a href="#tabs-3">Room types</a></li>
				<li><a href="#tabs-3">Features</a></li>
				<li><a href="#tabs-3">Managers</a></li>
				<li><a href="#tabs-3">Meta values</a></li>
			</ul>
			<div id="tabs-1"><div class="hotels form">
<?php echo $this->Form->create('Hotel');?>
	<fieldset>
 		<legend><?php __('Add Hotel'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('address');
		echo $this->Form->input('phone');
		echo $this->Form->input('email');
		echo $this->Form->input('web');
		echo $this->Form->input('contactperson');
		echo $this->Form->input('starclass');
		echo $this->Form->input('status');
		echo $this->Form->input('Category');

	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
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
</div></div>
			<div id="tabs-2">Phasellus mattis tincidunt nibh. Cras orci urna, blandit id, pretium vel, aliquet ornare, felis. Maecenas scelerisque sem non nisl. Fusce sed lorem in enim dictum bibendum.</div>

			<div id="tabs-3">Nam dui erat, auctor a, dignissim quis, sollicitudin eu, felis. Pellentesque nisi urna, interdum eget, sagittis et, consequat vestibulum, lacus. Mauris porttitor ullamcorper augue.</div>
		</div>
