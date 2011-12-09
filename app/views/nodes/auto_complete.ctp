<?php
if(!empty($Hotels)) {
	foreach($Hotels as $key => $value) {
	  echo $value['Hotel']['name'];
	 }
}
else {
 	echo 'No results';
}
?>