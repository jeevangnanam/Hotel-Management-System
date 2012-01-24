<div class="bookingEdits index">
	<h2><?php __('Booking Edits');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('ticket_id');?></th>
			<th><?php echo $this->Paginator->sort('user_id');?></th>
			<th><?php echo $this->Paginator->sort('hotel_id');?></th>
			<th><?php echo $this->Paginator->sort('room_type_id');?></th>
			<th><?php echo $this->Paginator->sort('number_of_rooms');?></th>
			<th><?php echo $this->Paginator->sort('from_date');?></th>
			<th><?php echo $this->Paginator->sort('end_date');?></th>
			<th><?php echo $this->Paginator->sort('estimated_price');?></th>
			<th><?php echo $this->Paginator->sort('coupon_id');?></th>
			<th><?php echo $this->Paginator->sort('notes');?></th>
			<th><?php echo $this->Paginator->sort('status');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($bookingEdits as $bookingEdit):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $bookingEdit['BookingEdit']['id']; ?>&nbsp;</td>
		<td><?php echo $bookingEdit['BookingEdit']['ticket_id']; ?>&nbsp;</td>
		<td><?php echo $bookingEdit['BookingEdit']['user_id']; ?>&nbsp;</td>
		<td><?php echo $bookingEdit['BookingEdit']['hotel_id']; ?>&nbsp;</td>
		<td><?php echo $bookingEdit['BookingEdit']['room_type_id']; ?>&nbsp;</td>
		<td><?php echo $bookingEdit['BookingEdit']['number_of_rooms']; ?>&nbsp;</td>
		<td><?php echo $bookingEdit['BookingEdit']['from_date']; ?>&nbsp;</td>
		<td><?php echo $bookingEdit['BookingEdit']['end_date']; ?>&nbsp;</td>
		<td><?php echo $bookingEdit['BookingEdit']['estimated_price']; ?>&nbsp;</td>
		<td><?php echo $bookingEdit['BookingEdit']['coupon_id']; ?>&nbsp;</td>
		<td><?php echo $bookingEdit['BookingEdit']['notes']; ?>&nbsp;</td>
		<td><?php echo $bookingEdit['BookingEdit']['status']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $bookingEdit['BookingEdit']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $bookingEdit['BookingEdit']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $bookingEdit['BookingEdit']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $bookingEdit['BookingEdit']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Booking Edit', true), array('action' => 'add')); ?></li>
	</ul>
</div>