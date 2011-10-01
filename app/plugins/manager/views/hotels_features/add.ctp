<div class="hotelsFeatures form">
<?php echo $this->Form->create('HotelsFeature');?>
	<fieldset>
 		<legend><?php __('Add Hotels Feature'); ?></legend>
	<?php
		echo $this->Form->input('hotel_id');
		echo $this->Form->input('feature_category',array('options' => array( 'NONE' => 'NONE' ,'Facilities' => 'Facilities', 'Sports and Recreation' => 'Sports and Recreation' , 'Internet in Rooms' => 'Internet in Rooms', 'Car park' => 'Car park')));
		echo $this->Form->input('feature');
		echo $this->Form->input('is_available',array('options' => array('YES' => 'YES' , 'NO' => 'NO'),'selected' => 'YES'));
		echo $this->Form->input('status',array('options' => array('APPROVED'=>'APPROVED','NOT_APPROVED' => 'NOT_APPROVED')));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Hotels Features', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Hotels', true), array('controller' => 'hotels', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Hotel', true), array('controller' => 'hotels', 'action' => 'add')); ?> </li>
	</ul>
</div>