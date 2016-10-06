<h1><?php echo lang('login_heading');?></h1>


<?php echo form_open(base_url('auth/login'));?>
<br>
  <p>
    <?php echo lang('login_identity_label', 'identity');?>
    <?php echo form_input($identity, set_value('identity'), 'style="width:96%"');?>
    <?php echo form_error('identity'); ?>
  </p>

  <p>
    <?php echo lang('login_password_label', 'password');?>
    <?php echo form_input($password, set_value('password'), 'style="width:96%"');?>
    <?php echo form_error('password'); ?>
  </p>
  
  <br class="clear">
  
  <p>
      <?php echo form_submit('submit', 'Accedi', 'class="btn btn-primary pull-right"');?>
      
      <label class="checkbox">
        <?php echo form_checkbox('remember', '1', FALSE, 'id="remember"');?>
        Ricordami su questo PC
      </label>
  </p>


<?php echo form_close();?>

<!--<p><a href="forgot_password"><?php echo lang('login_forgot_password');?></a></p>-->