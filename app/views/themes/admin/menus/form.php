<?php echo form_open() ?>

<fieldset>
	<legend>Menu</legend>
	<?php echo form_label('Nome menu', 'item[name]') ?>
	<?php echo form_input('item[name]', set_value('item[name]', $item->name), 'class="span12"') ?>
	
</fieldset>

<?php if($item->id): ?>
<fieldset style="margin-top:30px">
	<a style="margin-top:-60px" href="<?php echo base_url('admin/contenuti/menu/voce-di-menu/' . $item->id) ?>" class="btn pull-right"><i class="icon-plus-sign"></i> Aggiungi voce di menu</a>
	<legend>Organizza voci di menu</legend>

	<div class="menu-items">
	<ul>
	<?php foreach($item->get_items() as $menu_item): ?>

		<?php echo get_childs($menu_item) ?>

	<?php endforeach ?>
	</ul>
	</div>
	
	<br class="clear">
	
	<a href="<?php echo base_url('admin/menus/ajax_sort_menu_items')?>" class="btn btn-inverse" id="sort">Salva ordinamento</a>

</fieldset>
<?php endif ?>

<div class="form-actions">
	<?php echo form_submit('', 'Salva', 'class="btn btn-primary"') ?>
</div>


<?php echo form_close() ?>


<?php 
function get_childs($menu_item) 
{
	echo '<li id="list_'.$menu_item->id.'">';
	echo '<div>';
	?>
	<div class="btn-group pull-right">
		<a href="<?php echo base_url('admin/contenuti/menu/voce-di-menu/'. $menu_item->menu_id . '/' .$menu_item->id) ?>" class="btn"><i class="icon icon-wrench"></i></a>
		<a href="<?php echo base_url('admin/menus/delete_menu_item/' . $menu_item->menu_id . '/' . $menu_item->id) ?>" class="btn btn-danger"><i class="icon icon-trash icon-white"></i></a>
	</div>	
	<?php
	echo $menu_item->name . '</div>';
	
	if($menu_item->has_childs())
	{
		echo '<ul>';
		foreach($menu_item->get_childs() as $child)
		{
			echo get_childs($child);
		}
		echo '</ul>';
	}
	
	echo '</li>';
}
?>


<div id="output"></div>


<script>
$().ready(function () {
        
        $('.menu-items > ul').nestedSortable({
            handle                  : 'div',
            items                   : 'li',
            toleranceElement        : '> div',
            forcePlaceholderSize    : true,
            listType                : 'ul',
            placeholder             : 'placeholder',
        });
        
        $('#sort').on('click', function (e) {
			e.preventDefault();
			
            var list = $('.menu-items > ul').nestedSortable('toHierarchy');
            var url = $(this).prop('href');
			
            $.post(url,
                { list: list },
                function(data){
                    $("#output").html(data)
                },
                "html"
            );
        })

        
        $('.mjs-nestedSortable-collapsed').on('click', function () {
            $(this).toggleClass('mjs-nestedSortable-collapsed').toggleClass('mjs-nestedSortable-expanded');
        });
});
</script>
<style>
		.menu-items ul { margin:0 0 0 -6px; padding:0;}
		.menu-items li { list-style: none; margin-left:30px; position: relative }
		.menu-items li > div { background: #f6f6f6; background-image:none; border-bottom:1px solid #fff; display:block; padding: 12px 8px; position: relative; cursor: move }
		.menu-items li > div:hover { background: #efefef }
		.menu-items li > div .btn-group { position: absolute; right:5px; top:6px }
		.menu-items li > div .btn-group btn { padding:6px 5px }
		.menu-items li > div .label { position: absolute; right:150px; top:12px}
	
	
		.placeholder {
			outline: 1px dashed #4183C4;
			/*-webkit-border-radius: 3px;
			-moz-border-radius: 3px;
			border-radius: 3px;
			margin: -1px;*/
		}
        
        .mjs-nestedSortable-error {
			background: #fbe3e4;
			border-color: transparent;
		}

		.menu-items ul {
			margin: 0;
			padding: 0;
			/*padding-left: 30px;*/
		}
        
        .menu-items > ul {
            margin-left:6px
        }
        
		.menu-items > ul ul{
			margin: 0 0 0 35px;
			padding: 0;
			list-style-type: none;
		}
        
        .menu-items > ul > ul{
            margin-bottom:10px;
        }

		.menu-items > ul li {
			margin: 5px 0 0 0;
			padding: 0;
		}

		.menu-items > ul li.mjs-nestedSortable-branch div {
			background: -moz-linear-gradient(top,  #ffffff 0%, #f6f6f6 47%, #f0ece9 100%);
			background: -webkit-linear-gradient(top,  #ffffff 0%,#f6f6f6 47%,#f0ece9 100%);

		}

		.menu-items > ul li.mjs-nestedSortable-leaf div {
			background: -moz-linear-gradient(top,  #ffffff 0%, #f6f6f6 47%, #bcccbc 100%);
			background: -webkit-linear-gradient(top,  #ffffff 0%,#f6f6f6 47%,#bcccbc 100%);

		}

		li.mjs-nestedSortable-collapsed.mjs-nestedSortable-hovering div {
			border-color: #999;
			background: #fafafa;
		}

		.menu-items > ul li.mjs-nestedSortable-collapsed > ul{
			display: none;
		}

		.menu-items > ul li.mjs-nestedSortable-branch > div > .disclose {
			display: inline-block;
		}

		.menu-items > ul li.mjs-nestedSortable-collapsed > div > .disclose > span:before {
			content: '+ ';
		}

		.menu-items > ul li.mjs-nestedSortable-expanded > div > .disclose > span:before {
			content: '- ';
		}
		


</style>