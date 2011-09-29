<div class="hotels view">
<h2><?php  __('Hotel');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $hotel['Hotel']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $hotel['Hotel']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Address'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $hotel['Hotel']['address']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Phone'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $hotel['Hotel']['phone']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Email'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $hotel['Hotel']['email']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Web'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $hotel['Hotel']['web']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Contactperson'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $hotel['Hotel']['contactperson']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Starclass'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $hotel['Hotel']['starclass']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Status'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $hotel['Hotel']['status']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Hotel', true), array('action' => 'edit', $hotel['Hotel']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Hotel', true), array('action' => 'delete', $hotel['Hotel']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $hotel['Hotel']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Hotels', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Hotel', true), array('action' => 'add')); ?> </li>
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
<div class="related">
	<h3><?php __('Related Bookings');?></h3>
	<?php if (!empty($hotel['Booking'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('User Id'); ?></th>
		<th><?php __('Hotel Id'); ?></th>
		<th><?php __('Room Type Id'); ?></th>
		<th><?php __('Number Of Rooms'); ?></th>
		<th><?php __('From Date'); ?></th>
		<th><?php __('End Date'); ?></th>
		<th><?php __('Estimated Price'); ?></th>
		<th><?php __('Coupon Id'); ?></th>
		<th><?php __('Notes'); ?></th>
		<th><?php __('Status'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($hotel['Booking'] as $booking):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $booking['id'];?></td>
			<td><?php echo $booking['user_id'];?></td>
			<td><?php echo $booking['hotel_id'];?></td>
			<td><?php echo $booking['room_type_id'];?></td>
			<td><?php echo $booking['number_of_rooms'];?></td>
			<td><?php echo $booking['from_date'];?></td>
			<td><?php echo $booking['end_date'];?></td>
			<td><?php echo $booking['estimated_price'];?></td>
			<td><?php echo $booking['coupon_id'];?></td>
			<td><?php echo $booking['notes'];?></td>
			<td><?php echo $booking['status'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'bookings', 'action' => 'view', $booking['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'bookings', 'action' => 'edit', $booking['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'bookings', 'action' => 'delete', $booking['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $booking['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Booking', true), array('controller' => 'bookings', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php __('Related Hotels Categories');?></h3>
	<?php if (!empty($hotel['Category'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Hotel Id'); ?></th>
		<th><?php __('Category Id'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($hotel['Category'] as $category):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $category['id'];?></td>
			<td><?php echo $category['hotel_id'];?></td>
			<td><?php echo $category['category_id'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'hotels_categories', 'action' => 'view', $category['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'hotels_categories', 'action' => 'edit', $category['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'hotels_categories', 'action' => 'delete', $category['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $category['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Category', true), array('controller' => 'hotels_categories', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php __('Related Hotels Category Lists');?></h3>
	<?php if (!empty($hotel['CategoryList'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Name'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($hotel['CategoryList'] as $categoryList):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $categoryList['id'];?></td>
			<td><?php echo $categoryList['name'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'hotels_category_lists', 'action' => 'view', $categoryList['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'hotels_category_lists', 'action' => 'edit', $categoryList['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'hotels_category_lists', 'action' => 'delete', $categoryList['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $categoryList['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Category List', true), array('controller' => 'hotels_category_lists', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php __('Related Hotels Features');?></h3>
	<?php if (!empty($hotel['Feature'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Hotel Id'); ?></th>
		<th><?php __('Feature Category'); ?></th>
		<th><?php __('Feature'); ?></th>
		<th><?php __('Is Available'); ?></th>
		<th><?php __('Status'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($hotel['Feature'] as $feature):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $feature['id'];?></td>
			<td><?php echo $feature['hotel_id'];?></td>
			<td><?php echo $feature['feature_category'];?></td>
			<td><?php echo $feature['feature'];?></td>
			<td><?php echo $feature['is_available'];?></td>
			<td><?php echo $feature['status'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'hotels_features', 'action' => 'view', $feature['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'hotels_features', 'action' => 'edit', $feature['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'hotels_features', 'action' => 'delete', $feature['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $feature['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Feature', true), array('controller' => 'hotels_features', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php __('Related Hotels Managers');?></h3>
	<?php if (!empty($hotel['Manager'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Hotel Id'); ?></th>
		<th><?php __('User Id'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($hotel['Manager'] as $manager):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Manager', true), array('controller' => 'hotels_managers', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php __('Related Meta');?></h3>
	<?php if (!empty($hotel['Metum'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Model'); ?></th>
		<th><?php __('Foreign Key'); ?></th>
		<th><?php __('Key'); ?></th>
		<th><?php __('Value'); ?></th>
		<th><?php __('Weight'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($hotel['Metum'] as $metum):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $metum['id'];?></td>
			<td><?php echo $metum['model'];?></td>
			<td><?php echo $metum['foreign_key'];?></td>
			<td><?php echo $metum['key'];?></td>
			<td><?php echo $metum['value'];?></td>
			<td><?php echo $metum['weight'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'meta', 'action' => 'view', $metum['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'meta', 'action' => 'edit', $metum['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'meta', 'action' => 'delete', $metum['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $metum['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Metum', true), array('controller' => 'meta', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php __('Related Hotels Pictures');?></h3>
	<?php if (!empty($hotel['Picture'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Hotel Id'); ?></th>
		<th><?php __('Picture'); ?></th>
		<th><?php __('Caption'); ?></th>
		<th><?php __('Status'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($hotel['Picture'] as $picture):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $picture['id'];?></td>
			<td><?php echo $picture['hotel_id'];?></td>
			<td><?php echo $picture['picture'];?></td>
			<td><?php echo $picture['caption'];?></td>
			<td><?php echo $picture['status'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'hotels_pictures', 'action' => 'view', $picture['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'hotels_pictures', 'action' => 'edit', $picture['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'hotels_pictures', 'action' => 'delete', $picture['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $picture['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Picture', true), array('controller' => 'hotels_pictures', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php __('Related Hotels Room Capacities');?></h3>
	<?php if (!empty($hotel['RoomCapacity'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Hotel Id'); ?></th>
		<th><?php __('Room Type Id'); ?></th>
		<th><?php __('Max Adults'); ?></th>
		<th><?php __('Max Children'); ?></th>
		<th><?php __('Additional Adult Charge'); ?></th>
		<th><?php __('Additional Child Charge'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($hotel['RoomCapacity'] as $roomCapacity):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $roomCapacity['id'];?></td>
			<td><?php echo $roomCapacity['hotel_id'];?></td>
			<td><?php echo $roomCapacity['room_type_id'];?></td>
			<td><?php echo $roomCapacity['max_adults'];?></td>
			<td><?php echo $roomCapacity['max_children'];?></td>
			<td><?php echo $roomCapacity['additional_adult_charge'];?></td>
			<td><?php echo $roomCapacity['additional_child_charge'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'hotels_room_capacities', 'action' => 'view', $roomCapacity['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'hotels_room_capacities', 'action' => 'edit', $roomCapacity['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'hotels_room_capacities', 'action' => 'delete', $roomCapacity['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $roomCapacity['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Room Capacity', true), array('controller' => 'hotels_room_capacities', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php __('Related Hotels Room Types');?></h3>
	<?php if (!empty($hotel['RoomType'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Hotel Id'); ?></th>
		<th><?php __('Name'); ?></th>
		<th><?php __('Price'); ?></th>
		<th><?php __('Size'); ?></th>
		<th><?php __('Info'); ?></th>
		<th><?php __('View'); ?></th>
		<th><?php __('Cooling'); ?></th>
		<th><?php __('Status'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($hotel['RoomType'] as $roomType):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $roomType['id'];?></td>
			<td><?php echo $roomType['hotel_id'];?></td>
			<td><?php echo $roomType['name'];?></td>
			<td><?php echo $roomType['price'];?></td>
			<td><?php echo $roomType['size'];?></td>
			<td><?php echo $roomType['info'];?></td>
			<td><?php echo $roomType['view'];?></td>
			<td><?php echo $roomType['cooling'];?></td>
			<td><?php echo $roomType['status'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'hotels_room_types', 'action' => 'view', $roomType['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'hotels_room_types', 'action' => 'edit', $roomType['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'hotels_room_types', 'action' => 'delete', $roomType['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $roomType['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Room Type', true), array('controller' => 'hotels_room_types', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
