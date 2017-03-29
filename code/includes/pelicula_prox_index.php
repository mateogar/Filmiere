<?php
	namespace es\ucm\fdi\aw;
	require_once 'config.php';
	
	
	$pelicula = Pelicula::buscaProximaPeliculaIndex();
	
	if($pelicula)
	{
		$date = explode('-',$pelicula->getFecha());
		$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		$mes = (int) $date[1];
		echo '<p id="fecha_prox_index">'.$date[2].' de '.$meses[$mes-1].' de '.$date[0].'</p><p><img id="img_prox_index" src="'.$pelicula->getImg().'" /></p>';
	}
		
	else
		echo '<h3>No hay próximas películas</h3>';
?>