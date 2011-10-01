<div class="hotelsFeatures view">
<h2><?php  __('Hotels Feature');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $hotelsFeature['HotelsFeature']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Hotel'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($hotelsFeature['Hotel']['name'], array('controller' => 'hotels', 'action' => 'view', $hotelsFeature['Hotel']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Feature Category'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $hotelsFeature['HotelsFeature']['feature_category']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Feature'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $hotelsFeature['HotelsFeature']['feature']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Is Available'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $hotelsFeature['HotelsFeature']['is_available']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Status'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $hotelsFeature['HotelsFeature']['status']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Hotels Feature', true), array('action' => 'edit', $hotelsFeature['HotelsFeature']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Hotels Feature', true), array('action' => 'delete', $hotelsFeature['HotelsFeature']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $hotelsFeature['HotelsFeature']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Hotels Features', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Hotels Feature', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Hotels', true), array('controller' => 'hotels', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Hotel', true), array('controller' => 'hotels', 'action' => 'add')); ?> </li>
	</ul>
</div>
