<style>
.leftdiv{
	float:left;
	width:45%;
}
.rightdiv{
	float:left;
	width:50%;
	border:dashed 1px #538136;
	height:300px;
}
.pageheading{
	padding:10px 10px 0 10px;
	float:left;
	margin-top:10px;
	width:99%;
	height:40px;
	background:#F7F7F7;
	color:#538136;
	font-size:30px;
}
.hotelscap{
	margin:5px;
	color:#538136;
	font-size:15px;
	background:#F7FAF6;
}
.linkbtn{
	
}
.pagnate{
	background:#F7F7F7;
	margin:220px 10px 1px
};

</style>
<script>
$(document).ready(function(){ 

 
	
	
	
}
)
</script>
<div id="container">
<div class="pageheading">Hotel Statistics</div>
<div class="clr"></div>
<div class="leftdiv">&nbsp;</div>
<div class="rightdiv">
<?php 
	foreach($hotels as $key=>$value){ ?>
	<div class="hotelscap">
    <?php echo $this->Html->link($value['Hotel']['name'], '/manager/index/stathome/'.$value['Hotel']['id'], array('class' => 'linkbtn')); ?>
    </div>  
	<?php }?>
    <div class="clr"></div>
    <div class="pagnate">
  
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
</div>