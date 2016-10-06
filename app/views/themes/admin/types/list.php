<a href="admin/prodotti/tipologie/inserisci" class="btn pull-right">Aggiungi Tipologia <i class="icon-plus-sign"></i></a>
<?php echo form_open('', 'class="form-search pull-right" style="margin-right:20px"') ?>
    <div class="input-append">
        <?php echo form_input('', set_value(), 'placeholder="Cerca Tipologia" class="input-large search-query"') ?>
        <a href="" class="btn"><i class="icon-search"></i></a> 
    </div>
<?php echo form_close() ?>

<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th width="95%">Nome</th>
            <th width="5%">Azioni</th>
        </tr>
    </thead>
    
    <tbody>
        <?php if(count($types) > 0): ?>
        <?php foreach($types as $type): ?>
        <tr>
            <td><?php echo $type->name ?></td>
            <td>
                <div class="btn-group">
                    <a href="admin/prodotti/tipologie/modifica/<?php echo $type->id ?>" class="btn"><i class="icon-wrench"></i></a>
                    <a href="admin/prodotti/tipologie/elimina/<?php echo $type->id ?>" class="btn btn-danger"><i class="icon-trash"></i></a>
                </div>
            </td>
        </tr>
        <?php endforeach ?>
        <?php else: ?>
        <tr>
            <td colspan="3">
                Nessun Tipologia prodotti attualmente inserita. <a href="<?php echo uri_string() ?>/inserisci">Inserisci una Tipologia prodotti.</a>
            </td>
        </tr>
        <?php endif ?>
    </tbody>
    
</table>