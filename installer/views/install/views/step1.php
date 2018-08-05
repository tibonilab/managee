<div class="box">

    <h3>Database connection <span>step 1</span></h3>
    <?php echo form_open('', 'class="form"') ?>

        <p>Please provide here your database informations.</p>

        <hr />

        <div class="form-group <?php echo form_error('database') ? 'has-error' : '' ?>">
            <label>Database name</label>
            <?php echo form_input('database', set_value('database'), 'class="form-control"') ?>
            <?php echo form_error('database') ?>
        </div>

        <div class="form-group <?php echo form_error('hostname') ? 'has-error' : '' ?>">
            <label>Hostname</label>
            <?php echo form_input('hostname', set_value('hostname'), 'class="form-control"') ?>
            <?php echo form_error('hostname') ?>
        </div>
        
        <div class="form-group <?php echo form_error('username') ? 'has-error' : '' ?>">
            <label>Username</label>
            <?php echo form_input('username', set_value('username'), 'class="form-control"') ?>
            <?php echo form_error('username') ?>
        </div>
        
        <div class="form-group <?php echo form_error('password') ? 'has-error' : '' ?>">
            <label>Password</label>
            <?php echo form_password('password', set_value('password'), 'class="form-control"') ?>
            <?php echo form_error('password') ?>
        </div>

        <?php if(isset($error)): ?>
        <div class="error">
            <?php echo $error ?>
        </div>
        <br />
        <?php endif ?>

        <?php echo form_submit(null, 'Go ahead', 'class="btn btn-primary"') ?>

    <?php echo form_close() ?>
</div>