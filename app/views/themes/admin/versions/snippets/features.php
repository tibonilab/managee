<fieldset>
    <?php foreach($version->get_groups_features() as $group_features): ?>	
    <legend><?php echo $group_features->name ?></legend>
        <?php foreach($group_features->get_features() as $feature): ?>
            <?php echo $this->layout->load_view('products/snippets/feature_input', array('feature' => $feature, 'group_id' => $group_features->group_features_id), TRUE) ?>
        <?php endforeach ?>
    <?php endforeach ?>
</fieldset>