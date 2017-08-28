<?php
	define('ROOT_PATH', substr($_SERVER['DOCUMENT_ROOT'], 0, (strpos($_SERVER['DOCUMENT_ROOT'], 'kale')-1)));
	require(ROOT_PATH.'/bunker/god.php');
	echo $head."\r\n";
?>		<title></title>
		<meta name="description" content="">
	</head>
	<body>
		<?=$menu;?>
		<section class="main-section clearfix">
			
		</section>
	</body>
<?=$body;?>