<div class="box">

    <h1>Install manag.ee <span>step 3</span></h1>
    <?php echo form_open('', 'class="form"') ?>

        <p>Choose now your superadmin username and password.</p>

        <label>Username</label>
        <?php echo form_input('username', set_value('username'), 'class="form-control"') ?>
        <label>Password</label>
        <?php echo form_password('password', set_value('password'), 'class="form-control"') ?>

        <br />
        <?php echo form_submit('', 'Avanti', 'class="btn btn-primary"') ?>

    <?php echo form_close() ?>
    
</div>
