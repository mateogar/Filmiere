<?php

require_once __DIR__.'/includes/config.php';

?>
<!DOCTYPE html>

<head>
    <meta charset="utf-8" />
	<link rel="stylesheet" type="text/css" href="<?= $app->resuelve('/css/general.css') ?>">
	<link rel="icon" type="image/x-icon" href="img/logotipo.png" />
	
    <title>Próximamente</title>
</head>
<body>
	<div class="contenedor">
    <?php include 'cabecera.php'; ?>		
	<?php $peliculas = new \es\ucm\fdi\aw\PeliculasOps(); $peliculas->generaProxPeliculas();?>		
	<?php include 'footer.php'; ?>
	</div>
</body>
</html>