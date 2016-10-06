<?php echo form_open() ?>

	<div class="thumbnails">
		<a href="<?php echo uri_string() ?>/inserisci" class="btn pull-right">Aggiungi Vetrina <i class="icon-plus-sign"></i></a>
		<h3>Vetrine</h3>
		<div class="thumbnail">
			<?php echo $this->layout->load_view('showcases/snippets/table_list') ?>
		</div>
	</div>

	<div class="thumbnails">
		<a href="<?php echo uri_string() ?>/inserisci-lista" class="btn pull-right">Aggiungi Lista prodotti <i class="icon-plus-sign"></i></a>
		<h3>Liste prodotti in evidenza</h3>
		<div class="thumbnail">
			<?php echo $this->layout->load_view('showcases/snippets/table_list', array('showcases' => $groups, 'suffix' => '-lista', 'label' => 'Lista prodotti')) ?>
		</div>
	</div>

	<div class="form-actions">
		<?php echo form_submit('', 'Salva predefinita', 'class="btn btn-inverse"') ?>
	</div>

<?php echo form_close() ?>


<script>
	$().ready(function () {
		$('.form-actions').hide();
		
		$('input:radio').on('change', function() {
			$('.form-actions').fadeIn();
		})
		
	})
</script>