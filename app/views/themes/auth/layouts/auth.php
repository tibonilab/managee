<!doctype html>
    <head>
      <meta charset="utf-8">
      <title><?php echo $title_for_layout ?></title>
      <base href="<?php echo base_url('admin') ?>">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css" rel="stylesheet">
      <link href="assets/admin/css/default.css" rel="stylesheet" media="screen">
	  <link rel="icon" href="assets/favicon.png" type="image/png" />
      <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
      <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
      <script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>
      <!--<script src="assets/admin/js/jquery.ui.touch-punch.js"></script>-->
      <script src="assets/admin/js/jquery.mjs.nestedSortable.js"></script>
      <script src="assets/admin/ckeditor/ckeditor.js"></script>
	  <link href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" rel="stylesheet" media="screen">
      <?php echo $css_for_layout ?>
      <?php echo $js_for_layout?>
    </head>
    <body>
		
		<div style="margin:10% auto; width:300px">
		<?php echo $content_for_layout ?>
		</div>
        
    </body>
</html>
