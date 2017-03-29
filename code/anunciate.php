<?php

require_once __DIR__.'/includes/config.php';

?>
<!DOCTYPE html>

<html>
<head>
    <meta charset="utf-8" />
	<link rel="stylesheet" type="text/css" href="<?= $app->resuelve('/css/general.css') ?>">
	<link rel="icon" type="image/x-icon" href="img/logotipo.png" />
    <title>Anúnciate</title>
</head>
<body>
	<div class="contenedor">
		<?php include 'cabecera.php'; ?>
		
		<div class="estilo_bloque">
			<h2> Anúnciate en Cines Filmière </h2>
			
			<p> La presencia de tu marca en el Cine Filmière te proporcionará ventajas que ningún otro medio puede ofrecerte.
				Una audiencia única y cautiva con ojos sólo para ti.
				El Cine Filmière es el único lugar donde tu marca impacta al público joven y adulto, de todas las clases sociales;
				un público poco afín a la televisión y difícil de captar en otros medios.</p>
			<p>	Tu marca puede formar parte de la experiencia del Cine Filmière desde que los espectadores compran sus entradas (con flyers en taquilla),
				mientras esperan en la cola de las palomitas (con stands y muestras en el hall), cuando entran en la sala (personalizando los reposacabezas)
				y hasta que empieza su película (con increíbles anuncios en pantalla grande).
				Los límites sólo los marca tu imaginación. Sigue navegando, y descubre todo lo que tu marca puede hacer en el Cine Filmière.
			</p>
			
			<p>Contacta con nosotros <a href="contacto.php">aquí </a></p>
		</div>	
		
		<?php include 'footer.php'; ?>
	</div>
</body>
</html>