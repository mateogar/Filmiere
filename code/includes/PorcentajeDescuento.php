<?php
	namespace es\ucm\fdi\aw;
	require_once '/config.php';
	
	
	$seleccionado = $_REQUEST['porcentaje'];
	$porcentaje = Butaca::buscaPorcentajeDescuento($seleccionado);
	
	if($porcentaje != null)
	{
		
		echo $porcentaje;
	
	}
		
	else
		echo '<p>Error al mostrar el precio</p>';
?>