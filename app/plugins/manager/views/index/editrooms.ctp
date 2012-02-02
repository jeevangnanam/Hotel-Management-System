<?=$html->script(array('jquery/jquery.alerts.js'));?>
<?=$html->css(array('jquery.alerts.css'));?>
<style>
.container{
	width:100%;
}
.cap {
    background: url("/img/booking_steps/box.png") repeat-x scroll 0 0 transparent;
    color: #336600;
    float: left;
    height: 40px;
    margin-bottom: 1px;
    padding-left: 10px;
    padding-top: 10px;
    text-align: left;
    width: 96%;
}
.roomdetails{
	background:#F7FAF6;
	width:98%;
	height:300px;
	overflow-y:scroll;
}
.roomdiv{
	background: none repeat scroll 0 0 #F7FAF6;
    border: 1px dashed #CCCCCC;
    color: #336600;
    float: left;
    height: 30px;
    margin: 5px;
    width: 80px;
	text-align:center;
}
.roomnumber{
	width: 70px;
	height:20px;
	background:#F7FAF6;
	border:none;
	cursor: hand;
}
.roomnumberedit{
	width: 70px;
	height:20px;
	background:#FFFFFF;
	cursor: hand;
}
.roomnum{
	background: none repeat scroll 0 0 #F7FAF6;
    border: 1px dashed #CCCCCC;
    color: #336600;
    float: left;
    height: 30px;
    margin: 5px;
    width: 80px;
	text-align:center;
}
.rtype{
	width:200px;
}
.sbox{
	width:50%;
}
.sbox div{
	float:left;
}
#ssubmit{
	margin: 20px 0 0 10px;
	
}
.sphdn{
	display:none;
}
</style>
<script>

 $(document).ready(function(){ 
	
 });
function loadprompt(obj){
	var rn=($(obj).attr('id'));
	
	var rnh="rnh-"+rn.split('-')[1];
		jPrompt('Room Number:'+$(obj).html(),'', 'Enter new room number', function(r) {
			if(r.trim()!=''){
				document.getElementById(rn).innerHTML=r;
				document.getElementById(rnh).value=r;
			}
			
		});
}
</script>
<div class="container">
	<div class="hotelname"><span class="ht-icon"></span><span class="ht-name"><?=$hotels[0]['Hotel']['name'];?></span></div>
	<div class="clr"></div>
	<div class="sbox">
	<?php $rt=$rtselected;?>
		<?=$this->Form->create('',array('id'=>'editrooms','controller'=>'index','action'=>'/editrooms/'.$hotels[0]['Hotel']['id']));?>
		<?=$this->Form->input('roomtype',array('type'=>'select','class'=>'rtype','options'=>$roomtype,'id'=>'roomtype','empty'=>'','label'=>'Room Type','selected'=>$rt));?>
		<div id="ssubmit">
		<?=$this->Form->end('Search');?>
		</div>
	</div>
	
	<div class="clr"></div>	
	<?=$this->Form->create('',array('id'=>'editroomsrn','controller'=>'index','action'=>'/editrooms/'.$hotels[0]['Hotel']['id']));?>
	<div class="roomdetails">
	<?php 
	$c=1;
	//debug(count($roomNumbers));
	if(count($roomNumbers) > 1){
		foreach($roomNumbers as $key=>$value){?>
			<div class="roomdiv" onclick=" loadprompt(this)" id=<?="roomnumber-".$value['Rooms']['id'];?>>
				<?=$value['Rooms']['roomname'];?>
			</div>
			<div class='sphdn'>
			<?=$this->Form->input('roomtypehidden'.$value['Rooms']['id'],array('type'=>'text','id'=>'rnh-'.$value['Rooms']['id'],'value'=>$value['Rooms']['roomname']));?>
			<?=$this->Form->input('upid'.$c,array('type'=>'text','value'=>$value['Rooms']['id']));?>
			</div>
		<?php $c++;
		}
		} 
	?>
	</div>
	<div class='sphdn'>
			<?=$this->Form->input('roomtphidden',array('type'=>'text','value'=>$rtselected));?>
	</div>
	<?=$this->Form->end('Edit');?>
</div>
