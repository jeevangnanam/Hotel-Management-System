<style>
.hotel-div{
	float:left;
	width:auto;
	margin:5px;
}
.hotel-logo{
	width: 275px;
	height:70px;
	padding:5px;
	background:#E9E9E9;
	border:solid 1px #E9E9E9;
	border-radius: 5px; 
	-moz-border-radius: 5px; 
	-webkit-border-radius: 5px;
}
.hotel-logo img{
	width:275px;
	height:70px;
}
</style>
<div class="container">
	<?php foreach($hotels as $key=>$value):?>
	<div class="hotel-div">	
		<div class="hotel-logo"><img src="<?php echo $html->webroot;?>uploads/hotels/<?php echo $value['Hotel']['id'];?>/<?php echo $value['Hotel']['logo'];?>" /></div>
		<div><?=$value['Hotel']['name'];?></div>
		<div><?=$value['Hotel']['name'];?></div>
	</div>
	<?php endforeach;?>
</div>