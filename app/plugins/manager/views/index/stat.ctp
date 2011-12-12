<script>
$(document).ready(function(){ 

 
	$('.hotelscap').click(function() {
		var hotelid=this.id;
		alert(hotelid);
	});
	
	
}
)
</script>

<?php 
	foreach($hotels as $key=>$value){ ?>
	<div class="hotelscap" id="<?=$value['Hotel']['id'];?>"><?=$value['Hotel']['name'];?></div>
<?php }?>