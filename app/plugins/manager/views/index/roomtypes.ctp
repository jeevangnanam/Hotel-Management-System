<style>
.container{
	margin:10px 0 10px 80px;
}
.detailLables {
    background: none repeat scroll 0 0 #F7FAF6;
    border: 1px dashed #CCCCCC;
    color: #336600;
    float: left;
    height: 20px;
    margin: 5px;
    padding-left: 10px;
    width: 300px;
}
.detailFields {
    background: none repeat scroll 0 0 #F7FAF6;
    border: 1px dashed #CCCCCC;
    color: #336600;
    float: left;
    height: 20px;
    margin: 5px;
    padding-left: 10px;
    width: 377px;
}

.tforroomtype{
	background: none repeat scroll 0 0 #E7E7E7;
    border: 1px dashed #CCCCCC;
    color: #336600;
    float: left;
    height: 20px;
    margin: 5px;
    padding-left: 10px;
    width: 700px;
}
</style>
<div class="container">

<?php 

foreach($loadHotelsRoomType as $key => $value){
?>
<div class="tforroomtype"><?=$value['Hotel']['name'];?> Room Type Details.</div>
<div class="clr"></div>
<div class="detailLables">Room Type </div>
<div class="detailFields"><?=$value['HotelsRoomType']['name'];?></div>
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
<?php }?>
<div class="tforroomtype" align="right">
<!-- Shows the page numbers -->
	<?php echo $paginator->numbers(); ?>
	<!-- Shows the next and previous links -->
	<?php
		echo $paginator->prev('« Previous ', null, null, array('class' => 'disabled'));
		echo $paginator->next(' Next »', null, null, array('class' => 'disabled'));
	?> 
	<!-- prints X of Y, where X is current page and Y is number of pages -->
	<?php echo $paginator->counter(); ?>
</div>
</div>