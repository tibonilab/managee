<a href="<?php echo uri_string() ?>/inserisci" class="btn pull-right">Aggiungi Proprietà <i class="icon-plus-sign"></i></a>
<?php echo form_open('', 'class="form-search pull-right" style="margin-right:20px" method="get"') ?>
    <div class="input-append">
        <?php echo form_input('key', $this->input->get('key'), 'placeholder="Cerca Testo" class="input-large search-query"') ?>
        <button type="submit" class="btn"><i class="icon-search"></i></button> 
    </div>
<?php echo form_close() ?>

<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th width="45%">Promemoria</th>
			<th width="25%">Codice</th>
			<th	width="10%">Lingue</th>
            <th width="5%">Azioni</th>
        </tr>
    </thead>
    
    <tbody>
        <?php if(count($list) > 0): ?>
        <?php foreach($list as $item): ?>
        <tr>
			<td><?php echo $item->memo ?></td>
            <td><?php echo $item->key ?></td>
			<td><?php echo $this->layout->load_view('layouts/snippets/language/active_languages', array('languages' => $item->get_contents()), TRUE) ?></td></td>
            <td>
                <div class="btn-group">
                    <a href="<?php echo uri_string() ?>/modifica/<?php echo $item->id ?>" class="btn"><i class="icon-wrench"></i></a>
                    <a href="<?php echo uri_string() ?>/elimina/<?php echo $item->id ?>" class="btn btn-danger"><i class="icon-trash"></i></a>
                </div>
            </td>
        </tr>
        <?php endforeach ?>
        <?php else: ?>
        <tr>
            <td colspan="4">
                Nessun Testo trovato. <a href="<?php echo uri_string() ?>/inserisci">Inserisci un Testo.</a>
            </td>
        </tr>
        <?php endif ?>
    </tbody>
    
</table>