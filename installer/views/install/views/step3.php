<div class="box">

    <h3>Access keys <span>step 3</span></h3>
    <?php echo form_open('', 'class="form"') ?>

        <p>Choose now your superadmin username and password.</p>

        <hr />

        <div class="form-group <?php echo form_error('username') ? 'has-error' : '' ?>">
            <label>Username</label>
            <?php echo form_input('username', set_value('username'), 'class="form-control"') ?>
            <?php echo form_error('username'); ?>
        </div>
        <div class="form-group  <?php echo form_error('password') ? 'has-error' : '' ?>">
            <label>Password</label>
            <?php echo form_password('password', set_value('password'), 'class="form-control"') ?>
            <?php echo form_error('password'); ?>
        </div>

        <br />
        <?php echo form_submit('', 'Avanti', 'class="btn btn-primary"') ?>

    <?php echo form_close() ?>
    
</div>
