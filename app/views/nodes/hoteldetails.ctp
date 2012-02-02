<?php  
 echo $html->css(array('jsCarousel-2.0.0.css','colorbox.css'));
 echo $html->script(array('jsCarousel-2.0.0.js'));
 echo $html->script(array('colorbox/jquery.colorbox.js','colorbox/jquery.colorbox-min.js'));
?>
<script type="text/javascript">
 $(document).ready(function() {
            $('#carouselh').jsCarousel({ autoscroll: false, circular: true, masked: false, itemstodisplay: 10, orientation: 'h' });
			//onthumbnailclick: function(src) { alert(src); },

				//Examples of how to assign the ColorBox event to elements
				$(".group1").colorbox({rel:'group1'});
				$(".group2").colorbox({rel:'group2', transition:"fade"});
				$(".group3").colorbox({rel:'group3', transition:"none", width:"75%", height:"75%"});
				$(".group4").colorbox({rel:'group4', slideshow:true});
				$(".ajax").colorbox();
				$(".youtube").colorbox({iframe:true, innerWidth:425, innerHeight:344});
				$(".iframe").colorbox({iframe:true, width:"80%", height:"80%"});
				$(".inline").colorbox({inline:true, width:"50%"});
				$(".callbacks").colorbox({
					onOpen:function(){ alert('onOpen: colorbox is about to open'); },
					onLoad:function(){ alert('onLoad: colorbox has started to load the targeted content'); },
					onComplete:function(){ alert('onComplete: colorbox has displayed the loaded content'); },
					onCleanup:function(){ alert('onCleanup: colorbox has begun the close process'); },
					onClosed:function(){ alert('onClosed: colorbox has completely closed'); }
				});
				
				//Example of preserving a JavaScript event for inline calls.
				$("#click").click(function(){ 
					$('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
					return false;
				});
			});

</script>
<style>
.detailLables{
	width: 100px;
}
.detailFields{
	width: 250px;
}
.lbl{
	float:left;
}
.submit{
	margin: 30px 35px;
}
#datefrom,#dateto{
	margin-left:2px;
	width:70px;
	height:15px;
}
#roomcount{
	margin-left:2px;
	width:20px;
	height:15px;
}
.rtypestopic{
	margin:5px;
	color:#538136;
	font-size:14px;
	background:#E7E7E9;
}
.gallerystopic{
	margin:1px 5px -8px;
	color:#538136;
	font-size:14px;
	background:#E7E7E9;
}
.img {
   	height: 80px;
    margin: 5px;
    width: 261px;
}
.cap{
	color:#538136;
	border:dashed 1px #538136;
}
.roomtypedes{
	border:dashed 1px #538136;
}
.cmb{
	width:120px;
}
.submit input {
    background: none repeat scroll 0 0 #DD7F27;
    border-radius: 5px 5px 5px 5px;
    font-weight: bold;
    margin: 30px 40px 5px 20px;
    width: auto;
}
.submit input:hover {
	color:#538136;
}
</style>
<?php
	foreach($hoteldets as $key=>$value){ ?>
		<div class="hoteldescontainer">
			<div class="hoteldets">
				<div class="hotelname"><span class="ht-icon"></span><span class="ht-name"><?=$value['Hotel']['name'];?></span></div>
				<div class="clr"></div>
				<div class="hoteladdress"><span class="htllbl">Address :</span><span class="htldet"><?=$value['Hotel']['address'];?></span></div>
				<div class="clr"></div>
				<div class="hotelphone"><span class="htllbl">Phone :</span><span class="htldet"><?=$value['Hotel']['phone'];?></span></div>
				<div class="clr"></div>
				<div class="hotelweb"><span class="htllbl">Web :</span><span class="htldet"><?=$value['Hotel']['email'];?></span></div>
				<div class="clr"></div>
				<div class="hotelweb"><span class="htllbl">Email :</span><span class="htldet"><?=$value['Hotel']['web'];?></span></div>
				<div class="clr"></div>
				<div class="hoteladdress"><span class="htllbl">Contact person :</span><span class="htldet"><?=$value['Users']['first_name'];?>&nbsp;<?=$value['Users']['last_name'];?></span></div>
                <div class="clr"></div>
                 <div class="description-container"><?=$value['Hotel']['description'];?></div>
				<div class="clr"></div>
               
			</div>
            
			<?php $path='';
				 if(empty($value['Hotel']['logo']))
					$path='no_photo.jpg';
				  else
				  	$path=$value['Hotel']['id']."/".$value['Hotel']['logo'];
		    ?>
			<?php ?>
			<div class="imgbox"><img src="<?php echo $this->Html->webroot;?>uploads/hotels/<?=$path;?>" class="img" />
            <? //$this->Form->create('Nodes',array('controller'=>'nodes','action'=>'bookingindex/'.$hotelid));?>
            <? //$this->Form->submit('Book Now');?>
            <div class="bookiing-link">
            	<?=$this->Html->link('Book Now',array('controller'=>'nodes','action'=>'bookingindex/'.$hotelid));?>
            </div>
            </div>
            
        </div>
		<div class="clr"></div>
		<div class="roomdets">
        <div class="clr"></div>
        <!--<div class="rtypestopic">Room Types</div>-->
        <div class="clr"></div>
            <div id="tabs">
                <ul>
                <?php foreach($hoteltypedets as $key=>$value){ ?>
                    <li><a href="#<?=$value['HotelsRoomType']['id'];?>"><?=$value['HotelsRoomType']['name'];?></a></li>
                    
                <?php } ?>
                </ul>
            <?php foreach($hoteltypedets as $key=>$value){ ?>
                <div id="<?=$value['HotelsRoomType']['id'];?>" class="roomtype-des">
				<div>Room Type</div><div><?=$value['HotelsRoomType']['name'];?></div>
                <div class="clr"></div>
                <div>Price</div><div><?=$value['HotelsRoomType']['price'];?></div>
                <div class="clr"></div>
                <div>Size</div><div><?=$value['HotelsRoomType']['size'];?></div>
                <div class="clr"></div>
                <div>Info</div><div><?=$value['HotelsRoomType']['info'];?></div>
                <div class="clr"></div>
                <div>View</div><div><?=$value['HotelsRoomType']['view'];?></div>
                <div class="clr"></div>
                <div>Colling</div><div><?=$value['HotelsRoomType']['cooling'];?></div>
                </div>
            <?php } ?>
            
            </div>
        </div>
		<div class="clr"></div>
        	
            
        <div class="clr"></div>
<?php }?>
		
<div id="v2">
<div id="demo-wrapper">
<div id="demo-right">
<div id="hWrapper">
<div id="carouselh">
<?php $i=0; 
	foreach($loadHotelspics as $key=>$value){
?>
<div>
<a class="group1" href="<? echo $this->Html->webroot."uploads/hotels/".$value['Hotel']['id']."/".$value['HotelsPicture']['picture'];?>" ><img alt="" src="<? echo $this->Html->webroot."uploads/hotels/".$value['Hotel']['id']."/".$value['HotelsPicture']['picture'];?>" /></a>
</div>


<?php $i++; } ?>
</div>
</div>
</div>
</div>
</div>

	<!--<div id="popupContact" class="popupContact">
		<a id="popupContactClose"><?=$html->image('/img/icons/close.png',array('width'=>'20px'));?></a>
		
        <div style="" class="cap">Room Details</div>
        <div class="clr"></div>
        
		<p id="contactArea" class="contactArea">
		<div class="searchformdet">
        	<?=$this->Form->create('Nodes', array('type' => 'post','id'=>'frm','action' => '/stepone/'));?>
            <div style="background:#F7F7F7;height: 20px;width: 420px;">
        	<div class="lbl" style="width:120px;">Room Types</div>
            <div class="lbl" style="width:80px;">Date From</div>
            <div class="lbl" style="width:80px;">Data To</div>
            <div class="lbl"><input type="button" style="background:#000033;border:none;color:#FFF;width:62px;" value="Allocated" /></div>
             <div class="lbl"><input type="button" style="background:#0066CC;border:none;color:#000033;width:65px;" value="Alvailable" /></div>
            </div>
            <div class="clr"></div>
            <div class="lbl">
				<?=$this->Form->input('roomtypes', array('type'=>'select','options'=>$roomopt ,'empty'=>'','class'=>'cmb','label'=>'','id'=>'roomtypes'));?>
            </div>
            <div class="lbl">
           		<?=$this->Form->input('datefrom', array('type'=>'text','id'=>'datefrom','class'=>'idate','onclick'=>"loadCalander('datefrom')",'label'=>''));?>
            </div>
            <div class="lbl">
            	<?=$this->Form->input('dateto', array('type'=>'text','id'=>'dateto','class'=>'idate','onclick'=>"loadCalander('dateto')",'label'=>''));?>
            </div>
			<div class="lbl">
				<?=$this->Form->input('roomcount', array('type'=>'text','id'=>'roomcount','class'=>'cbox','readonly'=>"readonly",'label'=>'','value'=>0));?>
            </div>
            <div class="searcdiv" onclick="loadroomavailabity();">
            	
        	</div>
            <?=$this->Form->end('Book',array('id'=>'book'));?>
            <div class="clr"></div>
        	<div class="roomtypedes"></div>
        </div>
		</p>
       
	</div>
	<div id="backgroundPopup" class="backgroundPopup"></div>-->
    
    
    <!-- This contains the hidden content for inline calls -->
		<div style='display:none'>
			<div id='inline_content' style='padding:10px; background:#fff;'>
			<p><strong>This content comes from a hidden element on this page.</strong></p>
			<p>The inline option preserves bound JavaScript events and changes, and it puts the content back where it came from when it is closed.</p>
			<p><a id="click" href="#" style='padding:5px; background:#ccc;'>Click me, it will be preserved!</a></p>
			
			<p><strong>If you try to open a new ColorBox while it is already open, it will update itself with the new content.</strong></p>
			<p>Updating Content Example:<br />
			<a class="ajax" href="../content/flash.html">Click here to load new content</a></p>
			</div>
		</div>
