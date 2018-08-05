<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<title>Install manag.ee</title>

		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
		
		<!-- Font Awesome -->
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
        				

		<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400" rel="stylesheet">
        
		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->

        <style>
            body {
                background: #eee;
                background: linear-gradient(45deg, #cc00ff 44%, #9600ff 87%);
                /* background: #e84001; */
            }

            .centerd-content {
                min-height: 100vh;
                width: 100%;
                display: flex;
                justify-content: flex-start;
                
            }

            .box {
                min-width: 600px;
                width: 30%;
                background: #fff;
                padding: 3em;
            }

            .box h3 {
                color: #525252;
                text-transform: uppercase;
                
            }

            .box h3 span {
                float: right;
                font-size: 10px;
                text-transform: uppercase;
                background: #9600ff;
                color: #fff;
                width: 60px;
                height: 60px;
                border-radius: 100%;
                display: flex;
                justify-content: center;
                align-items: center;
                line-height: 36px;
                font-weight: bold;
            }

            form {
                padding: 1em 0;
            }

            form p {
                color: #777;
            }

            form label {
                padding: 2.5em 0 .25em 0;
                font-size:10px;
                color: #525252;
                text-transform: uppercase;
            }

            form input[type="submit"] {
                margin-top: 2.5em;
                float: right;
            }

            .form-control {
                border-radius: 0;
                border: 1px solid #eee;
            }

            .btn-primary {
                border-radius: 0;
                background: #9600ff;
                font-size: 10px; 
                letter-spacing: 2pt;
                word-spacing: 5pt;
                text-transform: uppercase;
                border: none;
                padding: 1em 2em;
                font-weight: bold;
                color: #fff;
            }

            .btn-primary:hover, 
            .btn-primary:active,
            .btn-primary:focus,
            .btn-primary:active:focus,
            .btn-primary.active { 
                opacity: .8;
                background: #9600ff;
                color: #fff;                
            }

            .splash {
                display: flex;
                justify-content: center;
                align-items: center;
                
                width: 100%;
                text-align: center;
            }

            .splash h1,
            .splash h2 {
                font-family: "Source Sans Pro", sans-serif;
                letter-spacing: -2pt;
                font-size: 98px;
                font-weight: 200;
                opacity: .6;
                color: #fff;
                text-shadow: 0px 0px 20px rgba(0, 0, 0, 0.3);    
            }

            .splash h2 {
                margin-top: 1em;
                font-size: 42px;
                letter-spacing: -.5pt;
            }
        </style>
	</head>
	<body>

		<div class="centerd-content">
            <?php echo $content_for_layout ?>

            <div class="splash">
                <div>
                    <h1>manag.ee</h1>
                    <h2>PHP over CodeIgniter simple CMS</h2>
                </div>
            </div>
        </div>
        

		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        
        <!-- jQuery Cookie & Easing -->
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
        
		<!-- Latest compiled and minified JavaScript -->
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	</body>
</html>