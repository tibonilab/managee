<a href="<?php echo uri_string() ?>/inserisci" class="btn pull-right">Aggiungi Menu <i class="icon-plus-sign"></i></a>



<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th width="95%">Nome</th>
            <th width="5%">Azioni</th>
        </tr>
    </thead>
    
    <tbody>
        <?php if(count($list) > 0): ?>
        <?php foreach($list as $item): ?>
        <tr>
			
            <td><?php echo $item->name ?></td>
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
                Nessuna meun attualmente inserito. <a href="<?php echo uri_string() ?>/inserisci">Inserisci un Menu.</a>
            </td>
        </tr>
        <?php endif ?>
    </tbody>
    
</table>