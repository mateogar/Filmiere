<?php
	namespace es\ucm\fdi\aw;
	require_once '/config.php';

	$idHorario = $_REQUEST['date'];
	$horario = Horario::getHorarioById($idHorario);
	
	if($horario)
	{
		$pelicula = Pelicula::buscaPeliculas($horario->getIdPelicula());
		
		echo '<img src="'.$pelicula->getImg().'" id="imagenPelicula"/>';
		echo 	'<div id="datos_entrada">';
		echo		'<h3>'.$pelicula->getTitulo();
						if($horario->getTD())
							echo ' (3D)';
		echo		'</h3>';
		echo		'<p>Fecha: '.date('d-m-y', strtotime($horario->getHora())).'</p>';
		echo		'<p>Hora: '.date('H:i', strtotime($horario->getHora())).'</p>';
		echo	'</div>';
	}
	else
		 echo '<div class="estilo_bloque">'.
				'<h2>Acceso restringido.</h2>'.
			  '</div>';
?>