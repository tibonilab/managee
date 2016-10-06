<?php echo form_open('') ?>

    <ul class="nav nav-tabs" id="mainTab">
      <li class="active"><a href="#product" data-toggle="tab">Prodotto</a></li>
      <li><a href="#versions" data-toggle="tab">Versioni</a></li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane active" id="product">
			<fieldset>
				<?php echo form_label('Tipologia prodotto', 'type_products[name]') ?>
				<?php echo form_input('type_products[name]', set_value('type_products[name]', $type_products->name), 'class="span12" id="type_products[name]" placeholder="Nome di riferimento alla caratteristica.."') ?>
				
				<?php echo form_label('Con le seguenti caratteristiche', 'groups') ?>
				<?php echo form_multiselect('related[groups][]', $groups, set_value('related[groups][]', $related_groups), 'class="span12" id="groups"') ?>

			</fieldset>
		</div>
		
		<div class="tab-pane" id="versions">
			<!-- AJAX Content -->
			<?php echo $this->layout->load_view('types/snippets/versions') ?>
		</div>
	</div>

    <div class="form-actions">
    <?php echo form_submit('', 'Salva', 'class="btn btn-primary"') ?>
    </div>
        
<?php echo form_close() ?>

<script>
$().ready(function () {
    $('#contentTab a:first').tab('show');
	
	$('#groups').on('change', function () {
		var group_id_list = {list : $(this).val() }
		
		console.log(group_id_list)
		
		$.ajax({
			url		: '<?php echo base_url('admin/types/get_features_by_group_id_list/' . $type_products->id) ?>',
			data	: group_id_list
		}).done(function (response) {
			$('#versions').html(response);
		})
	})
})
</script>