<!doctype html>
    <head>
      <meta charset="utf-8">
      <title><?php echo $title_for_layout ?></title>
      <base href="<?php echo base_url('admin') ?>">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css" rel="stylesheet">
      <link href="assets/admin/css/default.css" rel="stylesheet" media="screen">
      <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
      <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
      <script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>
      <script src="assets/admin/ckeditor/ckeditor.js"></script>
      <?php echo $css_for_layout ?>
      <?php echo $js_for_layout?>
      <script type="text/javascript"></script>
    </head>
    <body>
        <?php echo $this->layout->load_view('layouts/snippets/messages') ?>

        <?php echo $content_for_layout ?>
    </body>
</html>
