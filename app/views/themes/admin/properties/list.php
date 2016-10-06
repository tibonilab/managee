<a href="<?php echo uri_string() ?>/inserisci" class="btn pull-right">Aggiungi Proprietà <i class="icon-plus-sign"></i></a>
<?php echo form_open('', 'class="form-search pull-right" style="margin-right:20px"') ?>
    <div class="input-append">
        <?php echo form_input('', set_value(), 'placeholder="Cerca Proprietà" class="input-large search-query"') ?>
        <a href="" class="btn"><i class="icon-search"></i></a> 
    </div>
<?php echo form_close() ?>

<table class="table table-striped table-hover">
    <thead>
        <tr>
			<th width="5%"></th>
            <th width="70%">Nome</th>
			<th	width="10%">Lingue</th>
            <th width="5%">Azioni</th>
        </tr>
    </thead>
    
    <tbody>
        <?php if(count($properties) > 0): ?>
        <?php foreach($properties as $property): ?>
        <tr>
			<td><?php if($property->icon): ?><img width="30" src="<?php echo $property->get_icon() ?>"><?php endif ?></td>
            <td><?php echo $property->name ?></td>
			<td><?php echo $this->layout->load_view('layouts/snippets/language/active_languages', array('languages' => $property->get_contents()), TRUE) ?></td></td>
            <td>
                <div class="btn-group">
                    <a href="<?php echo uri_string() ?>/modifica/<?php echo $property->id ?>" class="btn"><i class="icon-wrench"></i></a>
                    <a href="<?php echo uri_string() ?>/elimina/<?php echo $property->id ?>" class="btn btn-danger"><i class="icon-trash"></i></a>
                </div>
            </td>
        </tr>
        <?php endforeach ?>
        <?php else: ?>
        <tr>
            <td colspan="3">
                Nessun Proprietà attualmente inserita. <a href="<?php echo uri_string() ?>/inserisci">Inserisci una Proprietà.</a>
            </td>
        </tr>
        <?php endif ?>
    </tbody>
    
</table>