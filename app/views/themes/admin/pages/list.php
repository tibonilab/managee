<div class="btn-group pull-right">
	<a href="/admin/contenuti/pagine/categorie" class="btn">Gestisci Categorie <i class="icon-list"></i></a>
	<a href="/admin/contenuti/pagine/inserisci" class="btn btn-primary">Aggiungi Pagina <i class="icon-plus-sign"></i></a>
</div>

<?php echo form_dropdown('category', $categories_list, set_value('category', $category_id), 'class="pull-left" id="category-filter" style="margin-right:20px"') ?>


<?php echo form_open('', 'class="form-search" style="margin-right:20px" method="get"') ?>
    <div class="input-append">
        <?php echo form_input('key', $this->input->get('key'), 'placeholder="Cerca Pagina" class="input-large search-query"') ?>
        <button type="submit" class="btn"><i class="icon-search"></i></button> 
    </div>
<?php echo form_close() ?>


<script>
$().ready(function() {
	$('#category-filter').on('change', function() {
		window.location.href = '/admin/contenuti/pagine/' + $(this).val()
	})
	
	<?php if($category_id):?>
	$('.sortable-list').sortable();
	<?php endif ?>
})
</script>

<?php if($category_id):?>
	<?php echo form_open() ?>
<?php endif ?>


<table class="table table-striped table-hover">
    <thead>
        <tr>
			<th width="50"></th>
            <th width="50%">Nome</th>
			<th width="20%">Categoria</th>
            <th width="10%">One Page</th>
			<th width="10%">Pubblicata</th>
            <th width="10%">Lingue</th>
            <th width="5%">Azioni</th>
        </tr>
    </thead>
    
    <tbody class="sortable-list">
        <?php if(count($pages) > 0): ?>
        <?php foreach($pages as $page): ?>
        <tr>
			<td width="50">
				<?php //if($page->has_default_image()): ?>
					<img src="<?php echo $page->get_default_image()->get_thumb() ?>" style="width:40px; max-width: none">
				<?php //endif ?>
					
			</td>
            <td width="35%"><?php echo $page->name ?></td>
			<td width="20%"><?php echo ($page->has_category()) ? $page->get_category()->name : '-'?></td>
            <td width="10%"><?php echo $this->layout->load_view('layouts/snippets/is_homepage', array('item' => $page), TRUE) ?></td>
			<td width="10%"><?php echo $this->layout->load_view('layouts/snippets/is_published', array('item' => $page), TRUE) ?></td>
            <td width="10%"><?php echo $this->layout->load_view('layouts/snippets/language/active_languages', array('languages' => $page->get_contents()), TRUE) ?></td>
            <td width="5%">
                <div class="btn-group">
                    <a href="<?php echo uri_string() ?>/modifica/<?php echo $page->id ?>" class="btn"><i class="icon-wrench"></i></a>
                    <a href="<?php echo uri_string() ?>/elimina/<?php echo $page->id ?>" class="btn btn-danger"><i class="icon-trash"></i></a>
                </div>
				<?php echo form_hidden('page[]', $page->id)?>
            </td>
        </tr>
        <?php endforeach ?>
        <?php else: ?>
        <tr>
            <td colspan="7">
                Nessuna elemento trovato. <a href="<?php echo uri_string() ?>/inserisci">Inserisci</a>.
            </td>
        </tr>
        <?php endif ?>
    </tbody>
    
</table>

<?php if($category_id):?>

<div class="form-actions">
	<?php echo form_submit('', 'Salva ordinamento', 'class="btn btn-primary"') ?>
</div>
<?php echo form_close() ?>
<?php endif ?>