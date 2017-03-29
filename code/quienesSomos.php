<?php

require_once __DIR__.'/includes/config.php';

?>
<!DOCTYPE html>

<head>
    <meta charset="utf-8" />
	<link rel="stylesheet" type="text/css" href="<?= $app->resuelve('/css/general.css') ?>">
	
	<link rel="icon" type="image/x-icon" href="img/logotipo.png" />
    <title>¿Quiénes somos?</title>
</head>
<body>
	<div class="contenedor">
    <?php include 'cabecera.php'; ?>
	<div class="estilo_bloque">
		<h2> ¿Quiénes somos? </h2>
		
		<p> Somos un humilde cine de barrio situado en la localidad de Talavera de la Reina. 
			Nuestra único objetivo es conseguir que nuestros clientes disfruten del séptimo arte tanto como lo hacemos nosotros,
			para ello siempre disponemos de las mejores novedades en nuestra cartelera, y estamos abiertos a escuchar las 
			opiniones de nuestros clientes para mejorar en lo posible. </p>
			
		<p>	Nos gusta decir que lo mejor que tenemos, nuestra página web, fue desarrollada por un grupo de cuatro estudiantes de 
			Ingeniería Informática de la Universidad Complutense de Madrid (Mateo García, Cárlos López, Sorin Draghici y Aarón Durán). </p>

		<p>	Te estamos esperando, ven a conocernos!. </p>
			
		<h2> Localización </h2>
		<p> C/ Av. Pío XII Nº 12 </p>
		<p> CP: 45600 </p>
		<p> Localidad: Talavera de la Reina, Toledo </p>
			
		<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3057.97232790393!2d-4.827214685081536!3d39.96437139095102!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd401bf614d94e49%3A0x7bd5c6a96aa2adab!2sAv.+P%C3%ADo+XII%2C+12%2C+45600+Talavera+de+la+Reina%2C+Toledo!5e0!3m2!1ses!2ses!4v1460190974574"
		 width="500" height="350" frameborder="0" style="border:0" allowfullscreen></iframe>
	</div>	
	<?php include 'footer.php'; ?>
	</div>
</body>
</html>