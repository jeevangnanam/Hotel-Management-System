<div class="hotelsRoomTypes index">
	<h2><?php __('Hotels Room Types');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('hotel_id');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('price');?></th>
			<th><?php echo $this->Paginator->sort('size');?></th>
			<th><?php echo $this->Paginator->sort('info');?></th>
			<th><?php echo $this->Paginator->sort('view');?></th>
			<th><?php echo $this->Paginator->sort('cooling');?></th>
			<th><?php echo $this->Paginator->sort('status');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($hotelsRoomTypes as $hotelsRoomType):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $hotelsRoomType['HotelsRoomType']['id']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($hotelsRoomType['Hotel']['name'], array('controller' => 'hotels', 'action' => 'view', $hotelsRoomType['Hotel']['id'])); ?>
		</td>
		<td><?php echo $hotelsRoomType['HotelsRoomType']['name']; ?>&nbsp;</td>
		<td><?php echo $hotelsRoomType['HotelsRoomType']['price']; ?>&nbsp;</td>
		<td><?php echo $hotelsRoomType['HotelsRoomType']['size']; ?>&nbsp;</td>
		<td><?php echo $hotelsRoomType['HotelsRoomType']['info']; ?>&nbsp;</td>
		<td><?php echo $hotelsRoomType['HotelsRoomType']['view']; ?>&nbsp;</td>
		<td><?php echo $hotelsRoomType['HotelsRoomType']['cooling']; ?>&nbsp;</td>
		<td><?php echo $hotelsRoomType['HotelsRoomType']['status']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $hotelsRoomType['HotelsRoomType']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $hotelsRoomType['HotelsRoomType']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $hotelsRoomType['HotelsRoomType']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $hotelsRoomType['HotelsRoomType']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Hotels Room Type', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Hotels', true), array('controller' => 'hotels', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Hotel', true), array('controller' => 'hotels', 'action' => 'add')); ?> </li>
	</ul>
</div>