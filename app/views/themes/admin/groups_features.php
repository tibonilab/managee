<a href="admin/prodotti/gruppi-caratteristiche/inserisci" class="btn pull-right">Aggiungi Gruppo <i class="icon-plus-sign"></i></a>
<?php echo form_open('', 'class="form-search pull-right" style="margin-right:20px"') ?>
    <div class="input-append">
        <?php echo form_input('', set_value(), 'placeholder="Cerca gruppo" class="input-large search-query"') ?>
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
        <?php if(count($groups_features) > 0): ?>
        <?php foreach($groups_features as $group_features): ?>
        <tr>
            <td><?php echo $group_features->name ?></td>
            <td><?php echo $this->layout->load_view('layouts/snippets/language/active_languages', array('languages' => $group_features->get_contents()), TRUE) ?></td>
            <td>
                <div class="btn-group">
                    <a href="admin/prodotti/gruppi-caratteristiche/modifica/<?php echo $group_features->id ?>" class="btn"><i class="icon-wrench"></i></a>
                    <a href="admin/prodotti/gruppi-caratteristiche/elimina/<?php echo $group_features->id ?>" class="btn btn-danger"><i class="icon-trash"></i></a>
                </div>
            </td>
        </tr>
        <?php endforeach ?>
        <?php else: ?>
        <tr>
            <td colspan="3">
                Nessun Gruppo di caratteristiche attualmente inserita. <a href="<?php echo uri_string() ?>/inserisci">Inserisci una Gruppo di caratteristiche.</a>
            </td>
        </tr>
        <?php endif ?>
    </tbody>
    
</table>