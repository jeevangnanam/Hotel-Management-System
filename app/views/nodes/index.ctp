<div class="searchbox">
	<div class="heading">Search Hotels</div>
    <div class="clr"></div>
    <div class="searchformcontent">
    <?=$this->Form->create(array('id'=>'Nodes','action'=>'/')); ?>
	<?=$this->Form->input('hotelname',array('type'=>'text','label'=>'Hotel Name'));?>
    <?=$this->Form->input('location',array('type'=>'text','label'=>'Location'));?>
    <?php $opt=array('1'=>'One','2'=>'Two','3'=>'Three','4'=>'Four','5'=>'Five');?>
    <?=$this->Form->input('starclass',array('type'=>'select','label'=>'Star Class','options'=>$opt,'empty'=>'Select One'));?>
	<?=$this->Form->input('category',array('type'=>'select','label'=>'Category','options'=>$catego,'empty'=>'Select One'));?>
    <?php echo $this->Form->end('Search'); ?>
    </div>
</div>
<div class="searchresult">
<?php 
//debug($hotelDets);
	foreach($hotelDets as $key=>$value){?>
    	<div class="hoteldescontainer">
			<div class="hoteldets">
				<div class="hotelname">Hotel <?=$value['Hotel']['name'];?></div>
				<div class="hoteladdress"><span class="htllbl">Address :</span><span class="htldet"><?=$value['Hotel']['address'];?></span></div>
				<div class="hotelphone"><span class="htllbl">Phone :</span><span class="htldet"><?=$value['Hotel']['phone'];?></span></div>
				<div class="hotelweb"><span class="htllbl">Web :</span><span class="htldet"><?=$value['Hotel']['email'];?></span></div>
				<div class="hotelweb"><span class="htllbl">Email :</span><span class="htldet"><?=$value['Hotel']['web'];?></span></div>
				<!--<div class="hotelweb"><span class="htllbl">&nbsp;</span><span class="htldet more">
					<?=$this->Form->create(array('id'=>'htminf','class'=>'moreinfo','action'=>'/hoteldetails')); ?>
					<?=$this->Form->input('hotelid',array('type'=>'hidden','label'=>'','value'=>$value['Hotel']['id']));?>
				 	<?php echo $this->Form->end('More Details...'); ?>
					</span>
				</div>-->
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
			<div class="moredets">
					<?=$this->Form->create(array('id'=>'htminf','class'=>'moreinfo','action'=>'/hoteldetails')); ?>
					<?=$this->Form->input('hotelid',array('type'=>'hidden','label'=>'','value'=>$value['Hotel']['id']));?>
				 	<?php echo $this->Form->end('More Details...'); ?>
			</div>
			</div>
			
        </div>
		
	
	<?php }?>
	<div class="clr"></div>
	<!-- Shows the page numbers -->
	<?php echo $paginator->numbers(); ?>
	<!-- Shows the next and previous links -->
	<?php
		echo $paginator->prev('« Previous ', null, null, array('class' => 'disabled'));
		echo $paginator->next(' Next »', null, null, array('class' => 'disabled'));
	?> 
	<!-- prints X of Y, where X is current page and Y is number of pages -->
	<?php echo $paginator->counter(); ?>
	<div class="clr"></div>
</div> 

