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
.search-container{
	margin:5px;
	float:left;
}
.search-container div{
	margin:5px;
	float:left;
	font-size:15px;
	font-weight:bold;
}
.dets{
	margin-top:5px;
	padding:5px;
	background:#F7F7F7;
	border:solid 1px #F7F7F7;
	border-radius: 5px; 
	-moz-border-radius: 5px; 
	-webkit-border-radius: 5px;
}

.search-hotels-icon{
	float:left;
	background:url(/img/search.png) no-repeat;
	margin: -10px 0;
    padding: 60px 20px 0 40px;
}
.page-cap{
	float:left;
	color:#72A946;
	padding:5px;
}
#search_hotels{
	color: #DD7F27;
    font-weight: bold;
    padding: 5px;
    width: 200px;
}
</style>
<script>
$(document).ready(function(){ 
	$('#search_hotels').change(function() {
		$(".search_details").html("");
		$.getJSON(
			"/nodes/searchpartners/"+$("#search_hotels").val(),
			function(data){// data == response
				$.each(data.Hotels, function(i,Hotel){
					if(Hotel.id != null){
						var img_div="<div class=\"hotel-div\">";	
							img_div+="<div class=\"hotel-logo\">";
							img_div+="<img src=\"<?php echo $html->webroot;?>uploads/hotels/"+Hotel.id+"/"+Hotel.logo+"\" /></div>";
							img_div+="<div class=\"dets\"><div>"+Hotel.name+"</div>";
							img_div+="<div><a href=\""+Hotel.web+"\">"+Hotel.web+"</a></div></div>";
							img_div+="</div>";
							$(".search_details").append(img_div);
					}
				});
			}
		);
	});
})
	
</script>
<div class="container">
	<div class="search-container"><div><span class="search-hotels-icon"></span><span class="page-cap">Search Hotels</span></div><div><input type="text"  id="search_hotels"/></div></div>
    <div class="clr"></div>
    <div class="search_details">
	<?php foreach($hotels as $key=>$value):?>
	<div class="hotel-div">	
		<div class="hotel-logo"><img src="<?php echo $html->webroot;?>uploads/hotels/<?php echo $value['Hotel']['id'];?>/<?php echo $value['Hotel']['logo'];?>" /></div>
        <div class="dets">
			<div><?=$value['Hotel']['name'];?></div>
			<div><a href="<?=$value['Hotel']['web'];?>"><?=$value['Hotel']['web'];?></a></div>
        </div>
	</div>
	<?php endforeach;?>
    </div>
</div>