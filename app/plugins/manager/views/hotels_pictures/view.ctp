<div class="hotelsPictures view">
<h2><?php  __('Hotels Picture');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $hotelsPicture['HotelsPicture']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Hotel'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($hotelsPicture['Hotel']['name'], array('controller' => 'hotels', 'action' => 'view', $hotelsPicture['Hotel']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Picture'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $hotelsPicture['HotelsPicture']['picture']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Caption'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $hotelsPicture['HotelsPicture']['caption']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Status'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $hotelsPicture['HotelsPicture']['status']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Hotels Picture', true), array('action' => 'edit', $hotelsPicture['HotelsPicture']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Hotels Picture', true), array('action' => 'delete', $hotelsPicture['HotelsPicture']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $hotelsPicture['HotelsPicture']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Hotels Pictures', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Hotels Picture', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Hotels', true), array('controller' => 'hotels', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Hotel', true), array('controller' => 'hotels', 'action' => 'add')); ?> </li>
	</ul>
</div>
