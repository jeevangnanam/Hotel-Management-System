<div class="hotelsRoomCapacities view">
<h2><?php  __('Hotels Room Capacity');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $hotelsRoomCapacity['HotelsRoomCapacity']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Hotel'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($hotelsRoomCapacity['Hotel']['name'], array('controller' => 'hotels', 'action' => 'view', $hotelsRoomCapacity['Hotel']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Hotel Room Type'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($hotelsRoomCapacity['HotelRoomType']['name'], array('controller' => 'hotels_room_types', 'action' => 'view', $hotelsRoomCapacity['HotelRoomType']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Max Adults'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $hotelsRoomCapacity['HotelsRoomCapacity']['max_adults']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Max Children'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $hotelsRoomCapacity['HotelsRoomCapacity']['max_children']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Additional Adult Charge'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $hotelsRoomCapacity['HotelsRoomCapacity']['additional_adult_charge']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Additional Child Charge'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $hotelsRoomCapacity['HotelsRoomCapacity']['additional_child_charge']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Hotels Room Capacity', true), array('action' => 'edit', $hotelsRoomCapacity['HotelsRoomCapacity']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Hotels Room Capacity', true), array('action' => 'delete', $hotelsRoomCapacity['HotelsRoomCapacity']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $hotelsRoomCapacity['HotelsRoomCapacity']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Hotels Room Capacities', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Hotels Room Capacity', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Hotels', true), array('controller' => 'hotels', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Hotel', true), array('controller' => 'hotels', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Hotels Room Types', true), array('controller' => 'hotels_room_types', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Hotel Room Type', true), array('controller' => 'hotels_room_types', 'action' => 'add')); ?> </li>
	</ul>
</div>
