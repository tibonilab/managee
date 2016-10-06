<h3><?php echo $this->texts->get('layout-footer-title-contact_me') ?></h3>
	<?php echo form_open('', 'class="fast-contacts" id="form-fast-contacts"') ?>

	<div class="response"><!-- AJAX CONTENT --></div>

	<?php echo form_input('email', set_value('email'), 'placeholder="'.lang('contacts-email').'"') ?>

	<?php echo form_textarea('message', set_value('message'), 'placeholder="'.lang('contacts-message').'"') ?>
	
	<label>
		<?php echo lang('contacts-privacy') ?>
	</label>
	
	<br class="clear">

	<?php echo form_submit('', lang('contacts-send'), 'class="submit"') ?>
<?php echo form_close() ?>

	<script>
	$().ready(function () {
		$('#form-fast-contacts').on('submit', function (e) {
			e.preventDefault();
			var form = $(this);
			
			var data = form.serialize();
			
			$.ajax({
				url		: '<?php echo site_url('ajax/email') ?>',
				type	: 'post',
				data	: data
			}).done(function (r) {
				form.children('.response').html(r)
				if(form.children('.response').children('div').hasClass('success'))
				{
					form.find('input[type=text], textarea').val('');
				}
			})
		})
	})
	</script>