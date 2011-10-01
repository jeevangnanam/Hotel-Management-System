<div class="hotelsRoomCapacities index">
	<h2><?php __('Hotels Room Capacities');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('hotel_id');?></th>
			<th><?php echo $this->Paginator->sort('room_type_id');?></th>
			<th><?php echo $this->Paginator->sort('max_adults');?></th>
			<th><?php echo $this->Paginator->sort('max_children');?></th>
			<th><?php echo $this->Paginator->sort('additional_adult_charge');?></th>
			<th><?php echo $this->Paginator->sort('additional_child_charge');?></th>
			<th><?php echo $this->Paginator->sort('total_rooms');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($hotelsRoomCapacities as $hotelsRoomCapacity):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $hotelsRoomCapacity['HotelsRoomCapacity']['id']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($hotelsRoomCapacity['Hotel']['name'], array('controller' => 'hotels', 'action' => 'view', $hotelsRoomCapacity['Hotel']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($hotelsRoomCapacity['HotelRoomType']['name'], array('controller' => 'hotels_room_types', 'action' => 'view', $hotelsRoomCapacity['HotelRoomType']['id'])); ?>
		</td>
		<td><?php echo $hotelsRoomCapacity['HotelsRoomCapacity']['max_adults']; ?>&nbsp;</td>
		<td><?php echo $hotelsRoomCapacity['HotelsRoomCapacity']['max_children']; ?>&nbsp;</td>
		<td><?php echo $hotelsRoomCapacity['HotelsRoomCapacity']['additional_adult_charge']; ?>&nbsp;</td>
		<td><?php echo $hotelsRoomCapacity['HotelsRoomCapacity']['additional_child_charge']; ?>&nbsp;</td>
		<td><?php echo $hotelsRoomCapacity['HotelsRoomCapacity']['total_rooms']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $hotelsRoomCapacity['HotelsRoomCapacity']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $hotelsRoomCapacity['HotelsRoomCapacity']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $hotelsRoomCapacity['HotelsRoomCapacity']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $hotelsRoomCapacity['HotelsRoomCapacity']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Hotels Room Capacity', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Hotels', true), array('controller' => 'hotels', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Hotel', true), array('controller' => 'hotels', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Hotels Room Types', true), array('controller' => 'hotels_room_types', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Hotel Room Type', true), array('controller' => 'hotels_room_types', 'action' => 'add')); ?> </li>
	</ul>
</div>