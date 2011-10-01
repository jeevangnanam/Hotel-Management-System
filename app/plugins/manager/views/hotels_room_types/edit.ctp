<div class="hotelsRoomTypes form">
<?php echo $this->Form->create('HotelsRoomType');?>
	<fieldset>
 		<legend><?php __('Edit Hotels Room Type'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('hotel_id');
		echo $this->Form->input('name');
		echo $this->Form->input('price');
		echo $this->Form->input('size');
		echo $this->Form->input('info');
		echo $this->Form->input('view',array('type' => 'select', 'options' => array('Garden'=> 'Garden','Sea' => 'Sea','Pond'=>'Pond','NONE'=>'NONE')));
		echo $this->Form->input('cooling',array('type' => 'select', 'options' => array('AC' => 'AC','FAN' => 'FAN','NONE' => "NONE") ));

		echo $this->Form->input('status' ,array('type' => 'select','options' => array('APPROVED' => 'APPROVED','NOT_APPROVED' => 'NOT_APPROVED')));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('HotelsRoomType.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('HotelsRoomType.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Hotels Room Types', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Hotels', true), array('controller' => 'hotels', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Hotel', true), array('controller' => 'hotels', 'action' => 'add')); ?> </li>
	</ul>
</div>