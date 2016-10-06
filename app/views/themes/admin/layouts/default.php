<!doctype html>
    <head>
      <meta charset="utf-8">
      <title><?php echo $title_for_layout ?></title>
      <base href="<?php echo base_url('admin') ?>">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css" rel="stylesheet">
      <link href="assets/admin/css/default.css" rel="stylesheet" media="screen">
	  
        <link rel="apple-touch-icon" sizes="57x57" href="/assets/agririo/images/layout/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="/assets/agririo/images/layout/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="/assets/agririo/images/layout/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="/assets/agririo/images/layout/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="/assets/agririo/images/layout/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="/assets/agririo/images/layout/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="/assets/agririo/images/layout/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="/assets/agririo/images/layout/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="/assets/agririo/images/layout/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="/assets/agririo/images/layout/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/assets/agririo/images/layout/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="/assets/agririo/images/layout/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/assets/agririo/images/layout/favicon-16x16.png">
        <link rel="manifest" href="/manifest.json">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="/assets/agririo/images/layout/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">
      
      <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
      <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
      <script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>
      <!--<script src="assets/admin/js/jquery.ui.touch-punch.js"></script>-->
      <script src="assets/admin/js/jquery.mjs.nestedSortable.js"></script>
      <script src="assets/admin/ckeditor/ckeditor.js"></script>
	  <link href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" rel="stylesheet" media="screen">
      <?php echo $css_for_layout ?>
      <?php echo $js_for_layout?>
      <script type="text/javascript">
	  $().ready(function () {
		  $('.label').tooltip();
		  
		  $(document).on('click', '.btn-danger', function (e) {
			  var ask = confirm('ATTENZIONE!!! \n\nSi sta per eliminare in maniera irrecuperabile l\'elemento selezionato.\n\nContinuare?');
			  
			  if ( ! ask) e.preventDefault();
		  })
          
          $(document).on('keypress', 'input[name="*[name]"]', function( ) {
              
            $('input[name="content[it][name]"]').val($(this).val())
            $('input[name="content[it][title]"]').val($(this).val())
            
          })
	  })
	  </script>
    </head>
    <body>
        <div class="container-fluid">
            <?php echo $this->layout->load_view('layouts/snippets/navbar') ?>
            
            <div class="row-fluid">
                <div class="span2">
                    <?php echo $this->layout->load_view('layouts/snippets/left-menu') ?>
                </div>
                
                <div class="span10">
                    <?php echo $this->layout->load_view('layouts/snippets/breadcrumbs') ?>
                    
                    <?php echo $this->layout->load_view('layouts/snippets/messages') ?>
                
                    <?php echo $content_for_layout ?>
                </div>
            </div>
            
        </div>
        
        <footer>
           <!-- Driven by TiboniLab &copy; - Creative Web Design Studio -->
        </footer>
        
    </body>
</html>
