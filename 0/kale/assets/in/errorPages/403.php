<?php
define('ASSETS', (gethostname()=='DCS-PC02'||gethostname()=='DESKTOP-MLP40NM')?'/assets/out/':'https://assets/dcsolution.ch/dcmV2/');
?><!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="x-ua-compatible" content="ie=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<meta name="robots" content="noindex,nofollow"/>
		<meta name="description" content="DCMedia, your app on the Web">
		<link href="https://fonts.googleapis.com/css?family=Lato|Montserrat|Roboto|Pacifico|Varela+Round" rel="stylesheet">
		<link rel="icon" href="<?=constant('ASSETS');?>img/home/favicon.png">
		<link rel="stylesheet" href="<?=constant('ASSETS');?>css/app.css">
		<title>403 - DCMedia</title>
	</head>
	<body class='back_2'>
		<nav class="clearfix">
			<div class="menuLeft">
				<a href="/">
					<img src="<?=constant('ASSETS');?>img/home/logo.png">
				</a>
			</div>
		</nav>
		<section id="titlePage" class="shadower-9">
			<h1>403 | Forbidden</h1>
			<div id="descPage">
				The request was valid, but the server is refusing action. The user might not have the necessary permissions for a resource, or may need an account of some sort.
			</div>
		</section>
		<video loop autoplay id="backgroundVideo">
			<source src="<?=constant('ASSETS');?>video/home/home_background.mp4" type="video/mp4">
			<source src="<?=constant('ASSETS');?>video/home/home_background_lowQuality.mp4" type="video/mp4">
		</video>
	</body>
</html>