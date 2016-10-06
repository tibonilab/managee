<a href="<?php echo uri_string() ?>/inserisci" class="btn pull-right">Aggiungi Pagina <i class="icon-plus-sign"></i></a>
<?php echo form_open('', 'class="form-search pull-right" style="margin-right:20px"') ?>
    <div class="input-append">
        <?php echo form_input('', set_value(), 'placeholder="Cerca pagina" class="input-large search-query"') ?>
        <a href="" class="btn"><i class="icon-search"></i></a> 
    </div>
<?php echo form_close() ?>




<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th width="80%">Nome</th>
            <th width="15%">Lingue</th>
            <th width="5%">Azioni</th>
        </tr>
    </thead>
    
    <tbody>
        <?php if(count($pages) > 0): ?>
        <?php foreach($pages as $page): ?>
        <tr>
            <td><?php echo $page->name ?></td>
            <td><?php echo $this->layout->load_view('layouts/snippets/language/active_languages', array('languages' => $page->get_contents()), TRUE) ?></td>
            <td>
                <div class="btn-group">
                    <a href="admin/contenuti/pagine/modifica/<?php echo $page->id ?>" class="btn"><i class="icon-wrench"></i></a>
                    <a href="admin/contenuti/pagine/elimina/<?php echo $page->id ?>" class="btn btn-danger"><i class="icon-trash"></i></a>
                </div>
            </td>
        </tr>
        <?php endforeach ?>
        <?php else: ?>
        <tr>
            <td colspan="3">
                Nessuna pagina attualmente inserita. <a href="<?php echo uri_string() ?>/inserisci">Inserisci una Pagina.</a>
            </td>
        </tr>
        <?php endif ?>
    </tbody>
    
</table>