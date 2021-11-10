<?php include_once 'config/database.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?= @$layout_title ?></title>
	<meta name="viewport" content="width=1144">
	<link rel="shortcut icon" href="img/img_logo/logo_company.png">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<link rel="stylesheet" href="css/font-awesome.css">
	<link rel="stylesheet" href="css/animate.css">
	<link rel="stylesheet" href="css/style.css">

	<!-- facebook meta--> 
    <meta property="og:image" content="../img/img_logo/logo_company.png" />    
    <meta property="og:url" content="http://khmerboy26.wordpress.com" />
    <meta property="og:title" content="Rithy Granite (Cambodia)" />
    <meta property="og:description" content="Granite Open Source is the ..." />

	<style type="text/css">
		*,h1,h2,h3,h4,h5,h6{ padding: 0px; margin: 0px; box-sizing: border-box; }
		@font-face{
			font-family: 'robo_light';
			src: url('fonts/roboto/Roboto-Light.ttf');
		}
		@font-face{
			font-family: 'robo_bold';
			src: url('fonts/roboto/Roboto-Bold.ttf');
		}
		@font-face{
			font-family: 'robo_regular';
			src: url('fonts/roboto/Roboto-Regular.ttf');
		}
		@font-face{
			font-family: 'robo_medium';
			src: url('fonts/roboto/Roboto-Medium.ttf');
		}
		
	</style>
	<script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>
</head>
<body>
	<div class="container">
		<header class="row">
			<div style="position: fixed; top: 0px; left: 0px; width: 100%; z-index: 999; text-align: center;">
				<?php include_once('navigation.php') ?>
			</div>
			<div class="lang">
				<ol>
					
				</ol>
			</div>

		</header>
	</div>