<div class="box">

    <h1>Install manag.ee <span>step 2</span></h1>
    <?php echo form_open('', 'class="form"') ?>

        <p>Insert here basic informations about the website.</p>

        <label>Website name</label>
        <?php echo form_input('website_title', set_value('website_title'), 'class="form-control"') ?>

        <label>Frontend default title</label>
        <?php echo form_input('default_title', set_value('default_title'), 'class="form-control"') ?>

        <label>Frontend theme name</label>
        <?php echo form_input('frontend_theme', set_value('frontend_theme'), 'class="form-control"') ?>

        <br />
        <?php echo form_submit('', 'Avanti', 'class="btn btn-primary"') ?>

    <?php echo form_close() ?>
    
</div>
