<a href="<?php echo uri_string() ?>/inserisci" class="btn pull-right">Aggiungi Categoria <i class="icon-plus-sign"></i></a>
<?php echo form_open('', 'class="form-search pull-right" style="margin-right:20px"') ?>
    <div class="input-append">
        <?php echo form_input('', set_value(), 'placeholder="Cerca categoria" class="input-large search-query"') ?>
        <a href="" class="btn"><i class="icon-search"></i></a> 
    </div>
<?php echo form_close() ?>

<br class="clear">


<div class="categories">
<?php 
function show_childs($categories)
{
    $CI =& get_instance();
    
    if(count($categories) > 0 ) echo "\n".'<ul>';
    foreach($categories as $category)
    {
        echo "\n".'<li id="list_'.$category->id.'">';
        if($category->is_branch()) echo $CI->layout->load_view('product_categories/snippets/toggle');
        echo '<div><img src="'. $category->get_default_image()->get_thumb().'" style="width:32px; margin:-5px 8px 0 0" class="pull-left">' . $category->name;
        echo $CI->layout->load_view('product_categories/snippets/actions', array('id' => $category->id));
		$type		= ($category->is_published()) ? 'success' : 'important';
		$title		= ($category->is_published()) ? 'Pubblicata' : 'Non pubblicata';
		$text		= ($category->is_published()) ? 'Pubblicata' : 'Non pubbilcata';
		?>
		<span title="<?php echo $title ?>" data-placement="top" data-origina-title="test" data-animation="true" data-toggle="tooltip" class="label label-<?php echo $type ?>"><?php echo $text ?></span>
        <?php
		echo '</div>';
        
        if ($category->is_leaf()) echo "</li>";
        
        show_childs($category->get_childs());
        
        if ($category->is_branch()) echo "\n</li>";
    }
    if(count($categories) > 0 ) echo "\n</ul>";
}

show_childs($categories);

?>
</div>

<br>
<div class="form-actions">
<?php echo form_button('', 'Salva ordinamento', 'class="btn btn-primary" id="sort"') ?>
</
<div id="output"></div>

<script>
$().ready(function () {
        
        $('.categories > ul').nestedSortable({
            handle                  : 'div',
            items                   : 'li',
            toleranceElement        : '> div',
            forcePlaceholderSize    : true,
            listType                : 'ul',
            placeholder             : 'placeholder',
        });
        
        $('#sort').on('click', function () {
            var list = $('.categories > ul').nestedSortable('toHierarchy');
               
            $.post(
                '<?php echo base_url('admin/product_categories/sort')?>',
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

		.categories ul{
			margin: 0;
			padding: 0;
			/*padding-left: 30px;*/
		}
        
        .categories > ul {
            margin-left:6px
        }
        
		.categories > ul ul{
			margin: 0 0 0 35px;
			padding: 0;
			list-style-type: none;
		}
        
        .categories > ul > ul{
            margin-bottom:10px;
        }

		.categories > ul li {
			margin: 5px 0 0 0;
			padding: 0;
		}

		.categories > ul li.mjs-nestedSortable-branch div {
			background: -moz-linear-gradient(top,  #ffffff 0%, #f6f6f6 47%, #f0ece9 100%);
			background: -webkit-linear-gradient(top,  #ffffff 0%,#f6f6f6 47%,#f0ece9 100%);

		}

		.categories > ul li.mjs-nestedSortable-leaf div {
			background: -moz-linear-gradient(top,  #ffffff 0%, #f6f6f6 47%, #bcccbc 100%);
			background: -webkit-linear-gradient(top,  #ffffff 0%,#f6f6f6 47%,#bcccbc 100%);

		}

		li.mjs-nestedSortable-collapsed.mjs-nestedSortable-hovering div {
			border-color: #999;
			background: #fafafa;
		}

		.categories > ul li.mjs-nestedSortable-collapsed > ul{
			display: none;
		}

		.categories > ul li.mjs-nestedSortable-branch > div > .disclose {
			display: inline-block;
		}

		.categories > ul li.mjs-nestedSortable-collapsed > div > .disclose > span:before {
			content: '+ ';
		}

		.categories > ul li.mjs-nestedSortable-expanded > div > .disclose > span:before {
			content: '- ';
		}

</style>