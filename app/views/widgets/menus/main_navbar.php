<?php 
function get_menu_childs($menu_item) 
{
	$active = (base_url(uri_string()) == $menu_item->get_url()) ? ' current-menu-item' : '';
	echo '<li class="menu-item menu-item-type-post_type menu-item-object-page page_item page-item-9 current_page_item'.$active.'">';

	echo '<a href="'.$menu_item->get_url().'">';
	echo $menu_item->get('label');
	echo '</a>';

	/*
	if($menu_item->has_childs())
	{
		echo '<ul class="nav-dropdown">';
		foreach($menu_item->get_childs() as $child)
		{
			echo get_menu_childs($child);
		}
		echo '</ul>';
	}
	*/
	
	echo '</li>';
}

$menu_name = isset($menu_name) ? $menu_name : 'default';

$this->db->where('name', $menu_name);
$menu = $this->db->get('menus')->row(0, 'menu');

if(is_object($menu))
{
	echo '<ul id="menu-main-menu" class="clearfix">';
	foreach($menu->get_items() as $menu_item)
	{
		get_menu_childs($menu_item);
	}
	echo '</ul>';
}
else
	echo 'Attenzione, impossibile trovare il menu "' . $menu_name . '"';
	 
?>
