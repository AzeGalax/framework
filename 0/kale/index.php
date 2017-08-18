<?php
	define('ROOT_PATH', substr($_SERVER['DOCUMENT_ROOT'], 0, (strpos($_SERVER['DOCUMENT_ROOT'], 'kale')-1)));
	require(ROOT_PATH.'/bunker/god.php');
	echo $head."\r\n";
?>		<title></title>
	</head>
	<body>

	</body>
<?=$body;?>