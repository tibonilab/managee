<?php foreach($languages as $language): ?>
    <?php if($language->is_active()): ?>
    <a href="<?php echo base_url('admin/' . $slug . '/' . $id . '/' . $language->iso) ?>"><?php echo $language->iso ?></a>
    <?php endif ?>
<?php endforeach ?>