<?php if($this->session->flashdata('success')): ?>
<div class="alert alert-success">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <strong>TUTTO OK!</strong> <?php echo $this->session->flashdata('success') ?>
</div>
<?php endif ?>

<?php if($this->session->flashdata('error')): ?>
<div class="alert alert-error">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <strong>ATTENZIONE!</storng> <?php echo $this->session->flashdata('error') ?>
</div>
<?php endif ?>


<?php if($this->session->flashdata('warning')): ?>
<div class="alert alert-warning">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <strong>ATTENZIONE!</strong> <?php echo $this->session->flashdata('warning') ?>
</div>
<?php endif ?>

<?php if($this->session->flashdata('info')): ?>
<div class="alert alert-info">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <strong>ATTENZIONE!</strong> <?php echo $this->session->flashdata('info') ?>
</div>
<?php endif ?>

<?php if(validation_errors()): ?>
<div class="alert alert-error">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>ATTENZIONE!</strong>
    
    <?php echo validation_errors() ?>
</div>
<?php endif ?>


<?php if(isset($error)): ?>
<div class="alert alert-error">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <strong>ATTENZIONE!</strong> <?php echo $error ?>
</div>
<?php endif ?>

<?php if(isset($infomsg)): ?>
<div class="alert alert-info">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <strong>NOTA: </strong> <?php echo $infomsg ?>
</div>
<?php endif ?>