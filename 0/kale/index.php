<?php
	define('ROOT_PATH', substr($_SERVER['DOCUMENT_ROOT'], 0, (strpos($_SERVER['DOCUMENT_ROOT'], 'kale')-1)));
	require(ROOT_PATH.'/bunker/god.php');
	echo $head."\r\n";
?>		<title>Votre site ici</title>
		<meta name="description" content="Un template complet comprenant l'envoi de mail, la connexion à une base de données, la création de logs, de serveurs de ressources externes ...">
	</head>
	<body>
		<?=$menu;?>
		<section class="main-section no_padding clearfix">
			<div class="section-1-img">
				<div class="section-inner-top">
					<h1 class="no_margin">Votre site ici</h1>
					<p>Un template complet comprenant l'envoi de mail, la connexion à une base de données, la création de logs, de serveurs de ressources externes ...</p>
				</div>
			</div>
		</section>
<?=$body;?>