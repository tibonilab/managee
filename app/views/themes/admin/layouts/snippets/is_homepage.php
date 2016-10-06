<?php 
	$type		= ($item->is_homepage) ? 'success' : 'important';
	$text		= ($item->is_homepage) ? 'Si' : 'No' 
?>
<span class="label label-<?php echo $type ?>"><?php echo $text ?></span>