<div class="searchbox">
	<div class="heading">Search Hotels</div>
    <div class="clr"></div>
    <div class="searchformcontent">
    <?=$this->Form->create(array('id'=>'searc_one','controller'=>'nodes','action'=>'index')); ?>	
    <?=$this->Form->input('location',array('type'=>'text','label'=>'Location'));?>
    <?php $opt=array('1'=>'One','2'=>'Two','3'=>'Three','4'=>'Four','5'=>'Five');?>
    <?=$this->Form->input('starclass',array('type'=>'select','label'=>'Star Class','options'=>$opt,'empty'=>'Any'));?>
	<?=$this->Form->input('category',array('type'=>'select','label'=>'Category','options'=>$catego,'empty'=>'Any'));?>
    <?php echo $this->Form->end('Search'); ?>
    </div>
	<div class="clr"></div>
	<div class="searchformcontent">
		<?=$this->Form->create(array('id'=>'searc_one','controller'=>'nodes','action'=>'index')); ?>
		<?=$this->Form->input('hotelname',array('type'=>'text','label'=>'Hotel Name'));?>
		<?php echo $this->Form->end('Search'); ?>
	</div>
</div>
<div class="searchresult">
<?php 
//debug($hotelDets);
	foreach($hotelDets as $key=>$value){?>
    	<div class="hoteldescontainer">
			<div class="hoteldets">
				<div class="hotelname"><span class="ht-icon"></span><span class="ht-name"><?=$value['Hotel']['name'];?></span></div>
				<div class="clr"></div>
				<div class="description-container">
				
				<?=$value['Hotel']['description'];?>
				<div class="moredets">
					<?=$this->Form->create(array('id'=>'htminf','class'=>'moreinfo','action'=>'/hoteldetails/'.$value['Hotel']['id'])); ?>
					<?=$this->Form->input('hotelid',array('type'=>'hidden','label'=>'','value'=>$value['Hotel']['id']));?>
				 	<?php echo $this->Form->end('More Details'); ?>
				</div>
				</div>
			</div>
			<?php $path='';
				 if(empty($value['Hotel']['logo']))
					$path='no_photo.jpg';
				  else
				  	$path=$value['Hotel']['id']."/".$value['Hotel']['logo'];
		    ?>
			<?php ?>
			<div class="imgbox">
			<img src="<?php echo $this->Html->webroot;?>uploads/hotels/<?=$path;?>" class="img" />
			<div class="clr"></div>
			<div class="contact-inf">
				<div><?=$value['Hotel']['address'];?></div>
				<div class="clr"></div>
				<div><?=$value['Hotel']['phone'];?></div>
				<div class="clr"></div>
				<div><?=$value['Hotel']['email'];?></div>
				<div class="clr"></div>
				<div><?=$value['Hotel']['web'];?></div>
			</div>
			</div>
			
        </div>
		
	
	<?php }?>
	
	<div class="clr"></div>
</div> 
	<div class="clr"></div>
	<div class="pg-div">
	<!-- Shows the next and previous links -->
	<?php
		echo $paginator->prev('« Previous ', null, null, array('class' => 'disabled'));
	?>
	 <!-- Shows the page numbers -->
	<?php 
		echo $paginator->numbers();
		echo $paginator->next(' Next »', null, null, array('class' => 'disabled')); 
	?>
	
	<!-- prints X of Y, where X is current page and Y is number of pages -->
	<?php echo $paginator->counter(); ?>
	</div>
<div class="clr"></div>