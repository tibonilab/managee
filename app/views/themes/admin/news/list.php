<a href="<?php echo uri_string() ?>/inserisci" class="btn pull-right">Aggiungi News <i class="icon-plus-sign"></i></a>
<?php echo form_open('', 'class="form-search pull-right" style="margin-right:20px" method="get"') ?>
    <div class="input-append">
        <?php echo form_input('key', $this->input->get('key'), 'placeholder="Cerca News" class="input-large search-query"') ?>
        <button type="submit" class="btn"><i class="icon-search"></i></button> 
    </div>
<?php echo form_close() ?>




<table class="table table-striped table-hover">
    <thead>
        <tr>
			<th width="50"></th>
            <th width="5%">Data</th>
			<th width="65%">Titolo</th>
			<th width="10%">Pubblicata</th>
            <th width="10%">Lingue</th>
            <th width="5%">Azioni</th>
        </tr>
    </thead>
    
    <tbody>
        <?php if(count($news) > 0): ?>
        <?php foreach($news as $item): ?>
        <tr>
			<td>
				<?php if($item->has_deafult_image()): ?>
					<img src="<?php echo $item->get_default_image()->get_thumb() ?>" style="width:40px; max-width: none">
				<?php endif ?>
			</td>
			<td><?php echo $item->get_date() ?></td>
            <td><?php echo $item->name ?></td>
            <td><?php echo $this->layout->load_view('layouts/snippets/is_published', array('item' => $item), TRUE) ?></td>
			<td><?php echo $this->layout->load_view('layouts/snippets/language/active_languages', array('languages' => $item->get_contents()), TRUE) ?></td>
            <td>
                <div class="btn-group">
                    <a href="admin/contenuti/news/modifica/<?php echo $item->id ?>" class="btn"><i class="icon-wrench"></i></a>
                    <a href="admin/contenuti/news/elimina/<?php echo $item->id ?>" class="btn btn-danger"><i class="icon-trash"></i></a>
                </div>
            </td>
        </tr>
        <?php endforeach ?>
        <?php else: ?>
        <tr>
            <td colspan="3">
                Nessuna news attualmente inserita. <a href="<?php echo uri_string() ?>/inserisci">Inserisci una News.</a>
            </td>
        </tr>
        <?php endif ?>
    </tbody>
    
</table>