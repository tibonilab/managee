<div class="ajax_attachment">
	
	<div class="btn-group pull-right">
		<a class="btn edit" href="#attach_<?php echo $attachment->id?>"><i class="icon icon-wrench"></i></a>    
		<a class="btn btn-danger areyousure ajax-delete" href="<?php echo base_url('admin/attachments/delete/'. $attachment->id) ?>"><i class="icon-trash icon-white"></i></a>    
	</div>
	<h5><a href="<?php echo $attachment->get_url() ?>" target="_blank"><?php echo $attachment->filename ?></a></h5>
	
	<div class="hide" id="attach_<?php echo $attachment->id?>">
	<?php echo form_hidden('attachment[id][]', $attachment->id) ?>

		<ul class="nav nav-pills" id="attachmentTab_<?php echo $attachment->id ?>" style="margin-bottom:10px">
			<?php $active = 'active';foreach($this->languages as $lang): ?>
				<li class="<?php echo $active ?>"><a href="#attachment_<?php echo $attachment->id ?>_<?php echo $lang->iso ?>" data-toggle="tab" rel="<?php echo $lang->iso ?>"><?php echo $lang->iso ?></a></li>
			<?php $active = ''; endforeach ?>
		</ul>


		<div class="tab-content">
			<?php $active = 'active'; foreach($this->languages as $lang): ?>
			<div class="tab-pane <?php echo $active ?>" id="attachment_<?php echo $attachment->id ?>_<?php echo $lang->iso ?>">
				<?php echo form_label('Testo del link (se non compilato, verrà visualizzato il nome del file)') ?>
				<?php echo form_input('attachment[content]['.$attachment->id.']['.$lang->iso.'][text]', set_value('attachment[content]['.$attachment->id.']['.$lang->iso.'][text]', $attachment->get_contents($lang->iso)->text), 'class="span12"') ?>
			</div>
			<?php $active = '';endforeach ?>
		</div>

	</div>
</div>

