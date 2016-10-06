<?php 
	$type		= ($item->is_published()) ? 'success' : 'important';
	$text		= ($item->is_published()) ? 'Si' : 'No' 
?>
<span class="label label-<?php echo $type ?>"><?php echo $text ?></span>