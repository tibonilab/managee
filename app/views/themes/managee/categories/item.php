<?php foreach($category->get_childs() as $x): ?>

    <a href="<?php echo $x->get_route() ?>">
        <?php echo $x->get_content('name') ?>
    </a>

<?php endforeach ?>