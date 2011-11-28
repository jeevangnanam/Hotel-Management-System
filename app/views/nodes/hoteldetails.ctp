
<?php
	foreach($hoteldets as $key=>$value){ ?>
		<div class="hoteldescontainer">
			<div class="hoteldets">
				<div class="hotelname">Hotel <?=$value['Hotel']['name'];?></div>
				<div class="clr"></div>
				<div class="hoteladdress"><span class="htllbl">Address :</span><span class="htldet"><?=$value['Hotel']['address'];?></span></div>
				<div class="clr"></div>
				<div class="hotelphone"><span class="htllbl">Phone :</span><span class="htldet"><?=$value['Hotel']['phone'];?></span></div>
				<div class="clr"></div>
				<div class="hotelweb"><span class="htllbl">Web :</span><span class="htldet"><?=$value['Hotel']['email'];?></span></div>
				<div class="clr"></div>
				<div class="hotelweb"><span class="htllbl">Email :</span><span class="htldet"><?=$value['Hotel']['web'];?></span></div>
				<div class="clr"></div>
				<div class="hoteladdress"><span class="htllbl">Contact person :</span><span class="htldet"><?=$value['Users']['first_name'];?> &nbsp;<?=$value['Users']['last_name'];?></span></div>
				<div class="clr"></div>
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
		<div class="roomdets"><?php //debug($hoteltypedets);?>
        <?php foreach($hoteltypedets as $key=>$value){ ?>
			<div class="roomtype"><?=$value['HotelsRoomType']['name'];?></div>
		<?php } ?>
		</div>
		<div class="clr"></div>
		<div class="hotelimages">
			<div ><?php //debug($loadHotelspics);?></div>
            <?php foreach($loadHotelspics as $key=>$value){ ?>
            <div style="float:left;margin:7px;border:dashed 1px #CCC;"><img src="<?php echo $this->Html->webroot;?>uploads/hotels/<?=$value['Hotel']['id'];?>/<?=$value['HotelsPicture']['picture'];?>" class="img" /></div>
            <?php } ?>
		</div>
        <div class="clr"></div>
        <div>BOOK</div>
<?php }?>