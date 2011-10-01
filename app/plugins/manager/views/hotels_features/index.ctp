<div class="hotelsFeatures index">
	<h2><?php __('Hotels Features');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('hotel_id');?></th>
			<th><?php echo $this->Paginator->sort('feature_category');?></th>
			<th><?php echo $this->Paginator->sort('feature');?></th>
			<th><?php echo $this->Paginator->sort('is_available');?></th>
			<th><?php echo $this->Paginator->sort('status');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($hotelsFeatures as $hotelsFeature):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $hotelsFeature['HotelsFeature']['id']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($hotelsFeature['Hotel']['name'], array('controller' => 'hotels', 'action' => 'view', $hotelsFeature['Hotel']['id'])); ?>
		</td>
		<td><?php echo $hotelsFeature['HotelsFeature']['feature_category']; ?>&nbsp;</td>
		<td><?php echo $hotelsFeature['HotelsFeature']['feature']; ?>&nbsp;</td>
		<td><?php echo $hotelsFeature['HotelsFeature']['is_available']; ?>&nbsp;</td>
		<td><?php echo $hotelsFeature['HotelsFeature']['status']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $hotelsFeature['HotelsFeature']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $hotelsFeature['HotelsFeature']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $hotelsFeature['HotelsFeature']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $hotelsFeature['HotelsFeature']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Hotels Feature', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Hotels', true), array('controller' => 'hotels', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Hotel', true), array('controller' => 'hotels', 'action' => 'add')); ?> </li>
	</ul>
</div>