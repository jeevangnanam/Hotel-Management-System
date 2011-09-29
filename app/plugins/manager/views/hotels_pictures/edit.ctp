<div class="hotelsPictures form">
<?php echo $this->Form->create('HotelsPicture');?>
	<fieldset>
 		<legend><?php __('Edit Hotels Picture'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('hotel_id');
		echo $this->Form->input('picture');
		echo $this->Form->input('caption');
		echo $this->Form->input('status');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('HotelsPicture.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('HotelsPicture.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Hotels Pictures', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Hotels', true), array('controller' => 'hotels', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Hotel', true), array('controller' => 'hotels', 'action' => 'add')); ?> </li>
	</ul>
</div>