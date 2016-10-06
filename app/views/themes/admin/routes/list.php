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
	        <th width="50%">URL</th>
			<th width="5%"></th>
			<th	width="30%">Rotta</th>
            <th width="5%">Azioni</th>
        </tr>
    </thead>
    
    <tbody>
        <?php if(count($list) > 0): ?>
        <?php foreach($list as $item): ?>
        <tr>
            <td><a href="<?php echo base_url($item->slug) ?>" target="_blank"><?php echo base_url($item->slug) ?></a></td>
			<td>
				<?php $type = (empty($item->redirect)) ? 'success' : 'important' ?>
				<?php $title = (empty($item->redirect)) ? 'Attiva' : 'Redirect' ?>
			    <span title="<?php echo $title ?>" data-placement="top" data-origina-title="test" data-animation="true" data-toggle="tooltip" class="label label-<?php echo $type ?>">&nbsp;&nbsp;</span>
			</td>
			<td><?php echo $item->route ?></td>
				<?php //echo $this->layout->load_view('layouts/snippets/language/active_languages', array('languages' => $item->get_contents()), TRUE) ?></td></td>
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
            <td colspan="3">
                Nessun Proprietà attualmente inserita. <a href="<?php echo uri_string() ?>/inserisci">Inserisci una Proprietà.</a>
            </td>
        </tr>
        <?php endif ?>
    </tbody>
    
</table>