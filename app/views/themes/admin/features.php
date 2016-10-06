<a href="admin/prodotti/caratteristiche/inserisci" class="btn pull-right">Aggiungi Caratteristica <i class="icon-plus-sign"></i></a>
<?php echo form_open('', 'class="form-search pull-right" style="margin-right:20px"') ?>
    <div class="input-append">
        <?php echo form_input('', set_value(), 'placeholder="Cerca categoria" class="input-large search-query"') ?>
        <a href="" class="btn"><i class="icon-search"></i></a> 
    </div>
<?php echo form_close() ?>

<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th width="80%">Nome</th>
            <th>Lingue</th>
            <th width="5%">Azioni</th>
        </tr>
    </thead>
    
    <tbody>
        <?php if(count($features) > 0): ?>
        <?php foreach($features as $feature): ?>
        <tr>
            <td><?php echo $feature->name ?></td>
            <td><?php echo $this->layout->load_view('layouts/snippets/language/active_languages', array('languages' => $feature->get_contents()), TRUE) ?></td>
            <td>
                <div class="btn-group">
                    <a href="admin/prodotti/caratteristiche/modifica/<?php echo $feature->id ?>" class="btn"><i class="icon-wrench"></i></a>
                    <a href="admin/prodotti/caratteristiche/elimina/<?php echo $feature->id ?>" class="btn btn-danger"><i class="icon-trash"></i></a>
                </div>
            </td>
        </tr>
        <?php endforeach ?>
        <?php else: ?>
        <tr>
            <td colspan="3">
                Nessuna caratteristica attualmente inserita. <a href="<?php echo uri_string() ?>/inserisci">Inserisci una Caratteristica.</a>
            </td>
        </tr>
        <?php endif ?>
    </tbody>
    
</table>