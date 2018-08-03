<div class="highlight-content">
    <h1 class="coursive main-title text-center"><?php echo $item->get_content('title') ?></h1>

    <div class="row">
        <div class="col-md-5">
            <img src="<?php echo $item->get_default_image()->get_big() ?>" alt="" class="img-responsive img-thumbnail">



        </div>
        <div class="col-md-7">

            <ul>
                <?php foreach (explode(',', $item->get_content('list')) as $item_list): ?>
                    <li>
                        <i class="fa fa-circle"></i> <?php echo $item_list ?>
                    </li>
                <?php endforeach ?>
            </ul>

            <p class="text-center">
                <span class="price-off"><?php echo $item->full_price ?></span>
                <span class="price"><?php echo $item->discounted ?></span>
            </p>

            <?php echo $item->get_content('content') ?>
            
            <div class="text-center">
                <br>
                <a href="#contatti" class="btn btn-primary scrollTo">Prenota questa offerta!</a>
            </div>
        </div>
    </div>
</div>