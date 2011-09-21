<div class="hotels index">
	<h2><?php __('Hotels');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('address');?></th>
			<th><?php echo $this->Paginator->sort('phone');?></th>
			<th><?php echo $this->Paginator->sort('email');?></th>
			<th><?php echo $this->Paginator->sort('web');?></th>
			<th><?php echo $this->Paginator->sort('contactperson');?></th>
			<th><?php echo $this->Paginator->sort('starclass');?></th>
			<th><?php echo $this->Paginator->sort('status');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($hotels as $hotel):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $hotel['Hotel']['id']; ?>&nbsp;</td>
		<td><?php echo $hotel['Hotel']['name']; ?>&nbsp;</td>
		<td><?php echo $hotel['Hotel']['address']; ?>&nbsp;</td>
		<td><?php echo $hotel['Hotel']['phone']; ?>&nbsp;</td>
		<td><?php echo $hotel['Hotel']['email']; ?>&nbsp;</td>
		<td><?php echo $hotel['Hotel']['web']; ?>&nbsp;</td>
		<td><?php echo $hotel['Hotel']['contactperson']; ?>&nbsp;</td>
		<td><?php echo $hotel['Hotel']['starclass']; ?>&nbsp;</td>
		<td><?php echo $hotel['Hotel']['status']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $hotel['Hotel']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $hotel['Hotel']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $hotel['Hotel']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $hotel['Hotel']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Hotel', true), array('action' => 'add')); ?></li>
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