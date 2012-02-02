<style>
.container{
	margin: 10px 0 10px 0;
}
.detailLables {
    background: none repeat scroll 0 0 #E7E7E7;/*F7FAF6*/
    border: none !important;
    color: #336600;
    float: left;
    height: 20px;
    margin: 5px;
    padding-left: 10px;
    width: 300px;
}
.detailFields {
    background: none repeat scroll 0 0 #E7E7E7;
    border: none !important;
    color: #336600;
    float: left;
    height: 20px;
    margin: 5px;
    padding-left: 10px;
    width: 377px;
}

.tforroomtype{
	background: none repeat scroll 0 0 #E7E7E7;
    border: none !important;
    color: #336600;
    float: left;
    height: 20px;
    margin: 5px;
    padding-left: 10px;
    width: 700px;
}
</style>
<div class="container">
<div class="hotelname"><span class="ht-icon"></span><span class="ht-name"><?=$hotelName;?> Room Type Details.</span></div>
    <div id="tabs">
             <ul>
                 <?php foreach($loadHotelsRoomType as $key=>$value){ ?>
                 <li><a href="#<?=$value['HotelsRoomType']['id'];?>"><?=$value['HotelsRoomType']['name'];?></a></li>                        
                 <?php } ?>
             </ul>
			<?php 
            foreach($loadHotelsRoomType as $key => $value){
            ?>
            <div id="<?=$value['HotelsRoomType']['id'];?>">
            <div class="tforroomtype"><?=$value['Hotel']['name'];?> Room Type Details.</div>
            <div class="clr"></div>
            <div class="detailLables">Room Price </div>
            <div class="detailFields"><?=$value['HotelsRoomType']['price'];?></div>
            <div class="clr"></div>
            <div class="detailLables">Room Size </div>
            <div class="detailFields"><?=$value['HotelsRoomType']['size'];?></div>
            <div class="clr"></div>
            <div class="detailLables">Room Info </div>
            <div class="detailFields"><?=$value['HotelsRoomType']['info'];?></div>
            <div class="clr"></div>
            <div class="detailLables">Room View </div>
            <div class="detailFields"><?=$value['HotelsRoomType']['view'];?></div>
            <div class="clr"></div>
            <div class="detailLables">Room Cooling </div>
            <div class="detailFields"><?=$value['HotelsRoomType']['cooling'];?></div>
            <div class="clr"></div>
            </div>
            <?php }?>
    </div>
</div>