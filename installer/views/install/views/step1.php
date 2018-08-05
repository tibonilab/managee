<div class="box">

    <h3>Database connection <span>step 1</span></h3>
    <?php echo form_open('', 'class="form"') ?>

        <p>Please provide here your database informations.</p>

        <hr />

        <label>Database name</label>
        <?php echo form_input('database', set_value('database'), 'class="form-control"') ?>
        <label>Hostname</label>
        <?php echo form_input('hostname', set_value('hostname'), 'class="form-control"') ?>
        <label>Username</label>
        <?php echo form_input('username', set_value('username'), 'class="form-control"') ?>
        <label>Password</label>
        <?php echo form_password('password', set_value('password'), 'class="form-control"') ?>
        <br />

        <?php if(isset($error)): ?>
        <div style="background: red; color: #fff; padding: 8px;">
            <?php echo $error ?>
        </div>
        <br />
        <?php endif ?>

        <?php echo form_submit(null, 'Go ahead', 'class="btn btn-primary"') ?>

    <?php echo form_close() ?>
</div>