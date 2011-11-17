<html>
	<head>
    </head>
	<body>
		<div style="width:100%;">
			<div>
			<?php 
			//$dirname=ROOT .DS.  'vendors' . DS; APP.'webroot'.DS. 'img' . DS. 
			$dirname=APP.'webroot'.DS. 'img' . DS. 'dest_reviews' .DS .'places_for_shopping'.DS .'gaya'.DS ;//;
			$dh= opendir($dirname); 
			$files=array(); 
			while (false !== ($entry= readdir($dh))) 
			{ 
					if ( $entry!= '..' && $entry!= '.') 
					{ 
						 $files[$entry]=$entry;
						 $s="/"; 
/* echo $this->Html->image('dest_reviews' .$s.'places_for_shopping'.$s.'gaya'.$s.$entry, 
 array('alt' => $entry,'class' => 'image_pr','rel' => 'lightbox'));//,'onclick'=>'loadRealSize(this)'*/
					if($entry!="_notes"){
						echo "<a class=\"thumbnail\" href=\"#thumb\">";
						echo $this->Html->image('dest_reviews' .$s.'places_for_shopping'.$s.'gaya'.$s.$entry, array('alt' => $entry,'class' => 'image_pr')) ;
						echo "<span>"; 
						echo $this->Html->image('dest_reviews'.$s.'places_for_shopping'.$s.'gaya'.$s.$entry,array('alt' => $entry,'class' => 'image_pr'));
						echo "</span></a>";	
					}
					} 
			} 

?> 	
		</div>
	</body>
</html>