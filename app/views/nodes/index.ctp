<div class="searchbox">
	<div class="heading">Search Hotels</div>
    <div class="clr"></div>
    <div class="searchformcontent">
    <?=$this->Form->create(); ?>
	<?=$this->Form->input('hotelname',array('type'=>'text','label'=>'Hotel Name'));?>
    <?=$this->Form->input('location',array('type'=>'text','label'=>'Location'));?>
    <?php $opt=array('1'=>'One','2'=>'Two','3'=>'Three','4'=>'Four','5'=>'Five');?>
    <?=$this->Form->input('starclass',array('type'=>'select','label'=>'Star Class','options'=>$opt,'empty'=>'Select One'));?>
    <?php echo $this->Form->end('Search'); ?>
    </div>
</div>
<div class="searchresult">
<?php 
//debug($hotelDets);
	foreach($hotelDets as $key=>$value){?>
    	<div class="hoteldescontainer">
			<div class="hoteldets">
				<div class="hotelname"><?=$value['Hotel']['name'];?></div>
				<div class="hoteladdress"><span class="htllbl">Address :</span><span class="htldet"><?=$value['Hotel']['address'];?></span></div>
				<div class="hotelphone"><span class="htllbl">Phone :</span><span class="htldet"><?=$value['Hotel']['phone'];?></span></div>
				<div class="hotelweb"><span class="htllbl">Web :</span><span class="htldet"><?=$value['Hotel']['email'];?></span></div>
				<div class="hotelweb"><span class="htllbl">Email :</span><span class="htldet"><?=$value['Hotel']['web'];?></span></div>
			</div>
			<?php $path='';
				 if(empty($value['HotelsPicture']['picture']))
					$path='no_photo.jpg';
				  else
				  	$path=$value['Hotel']['id']."/".$value['HotelsPicture']['picture'];
		    ?>
			<?php ?>
			<div class="imgbox"><img src="<?php echo $this->Html->webroot;?>uploads/hotels/<?=$path;?>" class="img" /></div>
        </div>
		<div class="clr"></div>
	
	<?php }?>
	


</div> 