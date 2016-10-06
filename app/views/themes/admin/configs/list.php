<a href="<?php echo uri_string() ?>/form" class="btn pull-right">Aggiungi Parametro <i class="icon-plus-sign"></i></a>
<?php echo form_open('', 'class="form-search pull-right" style="margin-right:20px"') ?>
    <div class="input-append">
        <?php echo form_input('', set_value(), 'placeholder="Cerca Parametro" class="input-large search-query"') ?>
        <a href="" class="btn"><i class="icon-search"></i></a> 
    </div>
<?php echo form_close() ?>

<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th width="10%">Key</th>
            <th width="50%">Value</th>
			<th width="30%">Memo</th>
			<th width="10%">Azioni</th>
        </tr>
    </thead>
    
    <tbody>
        <?php if(count($list) > 0): ?>
        <?php foreach($list as $item): ?>
        <tr>
            <td><?php echo $item->key ?></td>
			<td><?php echo $item->value ?></td>
			<td><?php echo $item->memo ?></td>
            <td>
                <div class="btn-group">
                    <a href="<?php echo uri_string() ?>/form/<?php echo $item->id ?>" class="btn"><i class="icon-wrench"></i></a>
                    <a href="<?php echo uri_string() ?>/delete/<?php echo $item->id ?>" class="btn btn-danger"><i class="icon-trash"></i></a>
                </div>
            </td>
        </tr>
        <?php endforeach ?>
        <?php else: ?>
        <tr>
            <td colspan="3">
                Nessun Parametro di configurazione attualmente inserito. <a href="<?php echo uri_string() ?>/form">Inserisci una Parametro di configurazione.</a>
            </td>
        </tr>
        <?php endif ?>
    </tbody>
    
</table>