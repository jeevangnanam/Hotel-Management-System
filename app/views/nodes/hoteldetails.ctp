<script type="text/javascript">

function loadroomavailabity(){
	$('#roomcount').val(0);
	var rtid=$('#roomtypes').val()
	var dateFrom=$('#datefrom').val();
	var dateTo=$('#dateto').val();
	if(dateFrom==""){
		alert("Please select 'Date From'.");
		return false;
	}
	else if(dateTo==""){
		alert("Please select 'Date To'.");
		return false;
	}
	else{
		//$(".roomtypedes"+rtid).slideToggle("slow");
		$.post("/Nodes/roomavailability/", { rtid: rtid,dateFrom:dateFrom,dateTo:dateTo},
		   function(data) {
			 $(".roomtypedes").html(data);
			// alert(data);
			  
		   });
	}
}
	
function loadCalander(str){
 $('#'+str).datepicker({ dateFormat: 'yy-mm-dd' });
 //$('#'+str).datepicker({ dateFormat: 'yy-mm-dd' });
}

function selectDiv(obj,id){
	var sr=0;
	if($(obj).is('.ediv')){
		$(obj).removeClass('ediv');
		$(obj).addClass('roomselected');
			sr=$('#roomcount').val();
			$('#roomcount').val(parseInt(sr)+1);
	}
	else{
		if($(obj).is('.roomselected')){
			$(obj).removeClass('roomselected');
			$(obj).addClass('ediv');
			   sr=$('#roomcount').val();
			   $('#roomcount').val(parseInt(sr)-1);
		}			
	}
}

function submitform(frm){
	$('#'+frm)[0].submit();
}
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
	display:none;
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
</style>
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
			<div class="roomtype"><?=$value['HotelsRoomType']['name'];?><div class="roomdests" onclick="loadPopUpnormal(<?=$value['Hotel']['id'];?>,<?=$value['HotelsRoomType']['id'];?>);"></div></div>
		<?php } ?>
		</div>
		<div class="clr"></div>
        	<?=$this->Form->button('Booking Process', array('type'=>'button','class'=>'normalbtn','onclick'=>"loadRoomAvailability('".$hotelid."')"));?>
        <div class="clr"></div>
	
        
<?php }?>
		<?=$html->css(array('skins/ie7/skin.css','fancybox/jquery.fancybox-1.3.4.css'));//'slide_show.css'?>,
		<?=$html->script(array('jquery/jquery.jcarousel.min.js','thickbox/thickbox.js','fancybox/jquery.fancybox-1.3.4.pack.js'));?>


		<!--asdadas-->
		<script type="text/javascript">

// Set thickbox loading image
tb_pathToImage = "img/loading-thickbox.gif"; 

var mycarousel_itemList = new Array();
</script>
<?php $i=0; 
		foreach($loadHotelspics as $key=>$value){
	 ?>
<script>

	mycarousel_itemList[<?=$i;?>]= {url:"<?=$this->Html->webroot;?>uploads/hotels/<?=$value['Hotel']['id'];?>/<?=$value['HotelsPicture']['picture'];?>", title: "" ,id:"<?=$value['HotelsPicture']['picture'];?>"}
</script>
<?php $i++; } ?>
<script>
function mycarousel_itemLoadCallback(carousel, state)
{
    for (var i = carousel.first; i <= carousel.last; i++) {
        if (carousel.has(i)) {
            continue;
        }

        if (i > mycarousel_itemList.length) {
            break;
        }

        // Create an object from HTML
        var item = jQuery(mycarousel_getItemHTML(mycarousel_itemList[i-1])).get(0);

        // Apply thickbox
        tb_init(item);

        carousel.add(i, item);
    }
};

/**
 * Item html creation helper.
 */
function mycarousel_getItemHTML(item)
{
    var url_m = item.url.replace(/_s.jpg/g, '_m.jpg');
    return '<a rel="fancyboxclass"  id="' + item.id + '"href="' + url_m + '" title="' + item.title + '"><img src="' + item.url + '" width="140" height="140" border="0" alt="' + item.title + '" /></a>';
};

jQuery(document).ready(function() {
    jQuery('#mycarousel').jcarousel({
        size: mycarousel_itemList.length,
        itemLoadCallback: {onBeforeAnimation: mycarousel_itemLoadCallback}
    });
	/*$(".fancyboxclass").fancybox({
				'overlayShow'	: true,
				'transitionIn'	: 'elastic',
				'transitionOut'	: 'elastic'
			});*/
	$("a[rel=fancyboxclass]").fancybox({
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'titlePosition' 	: 'over',
				'transitionIn'	: 'elastic',
				'transitionOut'	: 'elastic',
				'titleFormat'		: function(title, currentArray, currentIndex, currentOpts) {
					return '<span id="fancybox-title-over">Image ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
				}
			});

});

function loadfancybox(obj) {

			$(".fancyboxclass").fancybox({
				'overlayShow'	: false,
				'transitionIn'	: 'elastic',
				'transitionOut'	: 'elastic'
			});

			
		}
</script>

<div id="wrap">
  

  <ul id="mycarousel" class="jcarousel-skin-ie7">
    <!-- The content will be dynamically loaded in here -->
  </ul>

</div>
<!--end-->

	<div id="popupContact" class="popupContact">
		<a id="popupContactClose"><?=$html->image('/img/icons/close.png',array('width'=>'20px'));?></a>
		
        <div style="" id="cap"><h1>Room Details</h1></div>
        <div class="clr"></div>
        
		<p id="contactArea" class="contactArea">
		<div class="searchformdet">
        	<?=$this->Form->create('Nodes', array('type' => 'post','id'=>'frm','action' => '/stepone/'));?>
        	<div class="lbl">Room Types</div>
            <div class="lbl">Date From</div>
            <div class="lbl">Data To</div>
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
	<div id="backgroundPopup" class="backgroundPopup"></div>
