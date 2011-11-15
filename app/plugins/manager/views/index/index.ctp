<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<script>
 $(document).ready(function(){
	$('.hotelLinks').click(function() {
		var hotelid=$('.hotelLinks').attr('id');
		$('#rt').load('/manager/Index/setroomtypes/'+hotelid);
  		/*
			$.post("/manager/Index/setroomtypes/", { hotelid: hotelid},
		   function(data) {
			 $("#tabs").html(data);
			 alert(data);
			  
		   });*/
	});
	
	
}
)
function getRoomtypes(obj){
    var rtid=$(obj).attr('id');
	$(".roomtypedes"+rtid).slideToggle("slow");
		$.post("/manager/Index/setroomavalability/", { rtid: rtid},
		   function(data) {
			 $(".roomtypedes"+rtid).html(data);
			// alert(data);
			  
		   });

}

function loadbookings(){
	$.ajax({url:"/manager/Index/booking",async:false})
}
</script>
<div class="container">
	<div class="roomTypes">
    	<h3>Room Types </h3>
        <div id='rt'>
        
        </div>
    </div>
	<div class="holelList">
   	 	<h3>Hotels </h3>
    	<ul>
        	<?php foreach($getHotels as $key=>$value){ ?>
            <?=$this->Html->link($value['Hotel']['name'], '#', array('class' => 'hotelLinks','id'=>$value['Hotel']['id'])); ?>
            <?php }?>
        </ul>
    </div>
</div>