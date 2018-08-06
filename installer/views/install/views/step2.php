<div class="box">

    <h3>Website informations <span>step 2</span></h3>
    <?php echo form_open('', 'class="form"') ?>

        <p>Insert here basic informations about the website.</p>

        <hr />

        <div class="form-group <?php echo form_error('website_title') ? 'has-error' : '' ?>">
            <label>Website name</label>
            <?php echo form_input('website_title', set_value('website_title'), 'class="form-control"') ?>
            <?php echo form_error('website_title') ?>
        </div>

        <div class="form-group <?php echo form_error('default_title') ? 'has-error' : '' ?>">
            <label>Frontend default title</label>
            <?php echo form_input('default_title', set_value('default_title'), 'class="form-control"') ?>
            <?php echo form_error('default_title') ?>
        </div>

        <div class="form-group <?php echo form_error('frontend_theme') ? 'has-error' : '' ?>">
            <label>Frontend theme name</label>
            <?php echo form_input('frontend_theme', set_value('frontend_theme'), 'class="form-control"') ?>
            <?php echo form_error('frontend_theme') ?>
        </div>

        <br />
        <?php echo form_submit('', 'Go ahead', 'class="btn btn-primary"') ?>

    <?php echo form_close() ?>
    
</div>
