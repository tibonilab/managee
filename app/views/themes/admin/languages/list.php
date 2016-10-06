<a href="<?php echo uri_string() ?>/form" class="btn pull-right">Aggiungi Lingua <i class="icon-plus-sign"></i></a>
<?php echo form_open('', 'class="form-search pull-right" style="margin-right:20px"') ?>
    <div class="input-append">
        <?php echo form_input('', set_value(), 'placeholder="Cerca Lingua" class="input-large search-query"') ?>
        <a href="" class="btn"><i class="icon-search"></i></a> 
    </div>
<?php echo form_close() ?>

<table class="table table-striped table-hover">
    <thead>
        <tr>
	        <th width="5%">Iso</th>
			<th width="30%">Lingua</th>
			<th width="10%">Attiva</th>
			<th	width="30%">Default</th>
            <th width="5%">Azioni</th>
        </tr>
    </thead>
    
    <tbody>
        <?php if(count($list) > 0): ?>
        <?php foreach($list as $item): ?>
        <tr>
			<td><?php echo $item->iso ?></td>
            <td><?php echo $item->description ?></td>
			<td><?php echo ($item->is_active()) ? 'Attiva' : 'Non attiva' ?></td>
			<td><?php echo ($item->is_default()) ? 'Default' : '' ?></td>
            <td>
                <div class="btn-group">
                    <a href="<?php echo uri_string() ?>/form/<?php echo $item->iso ?>" class="btn"><i class="icon-wrench"></i></a>
                    <!--<a href="<?php echo uri_string() ?>/elimina/<?php echo $item->iso ?>" class="btn btn-danger"><i class="icon-trash"></i></a>-->
                </div>
            </td>
        </tr>
        <?php endforeach ?>
        <?php else: ?>
        <tr>
            <td colspan="3">
                Nessun Lingua attualmente inserita. <a href="<?php echo uri_string() ?>/form">Inserisci una Lingua.</a>
            </td>
        </tr>
        <?php endif ?>
    </tbody>
    
</table>