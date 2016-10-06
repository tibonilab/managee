<a href="<?php echo uri_string() ?>/inserisci" class="btn pull-right">Aggiungi Luogo <i class="icon-plus-sign"></i></a>

<?php echo form_dropdown('category', $categories_list, set_value('category', $category_id), 'class="pull-right" id="category-filter" style="margin-right:20px"') ?>

<?php echo form_open('', 'class="form-search pull-left" style="margin-right:20px"') ?>
    <div class="input-append">
        <?php echo form_input('', set_value(), 'placeholder="Cerca luogo" class="input-large search-query"') ?>
        <a href="" class="btn"><i class="icon-search"></i></a> 
    </div>
<?php echo form_close() ?>


<script>
$().ready(function() {
	$('#category-filter').on('change', function() {
		window.location.href = 'admin/luoghi/inventario/' + $(this).val()
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
            <th width="10%"></th>
            <!--<th width="20%">Codice</th>-->
			<th width="40%">Nome</th>
			<th width="10%">Pubblicato</th>			
            <th width="15%">Lingue</th>
            <th width="5%">Azioni</th>
        </tr>
    </thead>
    
    <tbody class="sortable-list">
        <?php if(count($products) > 0): ?>
        <?php foreach($products as $product): ?>
        <tr>
            <td width="10%">
				<div class="image-wrap">
					<img src="<?php echo base_url($product->get_default_image()->get_thumb()) ?>" width="50">
					<?php if($product->is_new()): ?>
					<img class="hover" src="<?php echo base_url('assets/admin/images/new-product.png') ?>" alt="new">
					<?php endif ?>
				</div>
			</td>
            <!--<td><?php echo $product->code ?></td>-->
			<td width="40%"><?php echo $product->name ?></td>
			<td width="10%" style="text-align: center">
				<?php $type = ($product->is_published()) ? 'success' : 'important' ?>
				<?php $title = ($product->is_published()) ? 'Si' : 'No' ?>
				<span class="label label-<?php echo $type ?>"><?php echo $title ?></span>
			</td>
            <td width="15%"><?php echo $this->layout->load_view('layouts/snippets/language/active_languages', array('languages' => $product->get_contents())) ?></td>
            <td width="5%">
                <div class="btn-group">
                    <a href="<?php echo uri_string() ?>/modifica/<?php echo $product->id ?>" class="btn"><i class="icon-wrench"></i></a>
                    <a href="<?php echo uri_string() ?>/elimina/<?php echo $product->id ?>" class="btn btn-danger"><i class="icon-trash"></i></a>
                </div>
				<?php echo form_hidden('product[]', $product->id)?>
            </td>
        </tr>
        <?php endforeach ?>
        <?php else: ?>
        <tr>
            <td colspan="6">
                Nessun luogo attualmente inserito. <a href="<?php echo uri_string() ?>/inserisci">Inserisci un Luogo.</a>
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