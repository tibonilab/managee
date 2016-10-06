<legend>Caratteristiche prodotto</legend>

<?php if(count($product->get_groups_features()) == 0): ?>
<div class="alert alert-info">
	<a href="<?php echo uri_string() ?>#product" onclick="javascript:$('a[href=#product]').tab('show')" class="btn btn-inverse pull-right" style="margin-top:6px">Vai alla tab Prodotto</a>
	<b>ATTENZIONE:</b><br>
	Per poter inserire i valori delle caratteristiche è necessario selezionare una tipologia per il prodotto all'interno della tab "Prodotto".
</div>
<?php endif ?>

<fieldset>
    <?php foreach($product->get_groups_features() as $group_features): ?>	
    <legend><?php echo $group_features->name ?></legend>
        <?php foreach($group_features->get_features() as $feature): ?>
            <?php echo $this->layout->load_view('products/snippets/feature_input', array('feature' => $feature, 'group_id' => $group_features->group_features_id), TRUE) ?>
        <?php endforeach ?>
    <?php endforeach ?>
</fieldset>