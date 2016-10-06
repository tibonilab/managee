<a href="<?php echo uri_string() ?>/inserisci" class="btn pull-right">Aggiungi Pagina <i class="icon-plus-sign"></i></a>

<?php echo form_open('', 'class="form-search pull-right" style="margin-right:20px" method="get"') ?>
    <div class="input-append">
        <?php echo form_input('key', $this->input->get('key'), 'placeholder="Cerca Pagina" class="input-large search-query"') ?>
        <button type="submit" class="btn"><i class="icon-search"></i></button> 
    </div>
<?php echo form_close() ?>



<table class="table table-striped table-hover">
    <thead>
        <tr>
			<th width="50"></th>
            <th width="70%">Nome</th>
			<th width="10%">Pubbilcata</th>
            <th width="10%">Lingue</th>
            <th width="5%">Azioni</th>
        </tr>
    </thead>
    
    <tbody>
        <?php if(count($pages) > 0): ?>
        <?php foreach($pages as $page): ?>
        <tr>
			<td>
				<?php //if($page->has_default_image()): ?>
					<img src="<?php echo $page->get_default_image()->get_thumb() ?>" style="width:40px; max-width: none">
				<?php //endif ?>
					
			</td>
            <td><?php echo $page->name ?></td>
			<td><?php echo $this->layout->load_view('layouts/snippets/is_published', array('item' => $page), TRUE) ?></td>
            <td><?php echo $this->layout->load_view('layouts/snippets/language/active_languages', array('languages' => $page->get_contents()), TRUE) ?></td>
            <td>
                <div class="btn-group">
                    <a href="<?php echo uri_string() ?>/modifica/<?php echo $page->id ?>" class="btn"><i class="icon-wrench"></i></a>
                    <a href="<?php echo uri_string() ?>/elimina/<?php echo $page->id ?>" class="btn btn-danger"><i class="icon-trash"></i></a>
                </div>
            </td>
        </tr>
        <?php endforeach ?>
        <?php else: ?>
        <tr>
            <td colspan="5">
                Nessuna Pagina trovata. <a href="<?php echo uri_string() ?>/inserisci">Inserisci una Pagina.</a>
            </td>
        </tr>
        <?php endif ?>
    </tbody>
    
</table>