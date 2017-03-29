<?php
	namespace es\ucm\fdi\aw;
	require_once '/config.php';
	
	
	$seleccionado = $_REQUEST['codigo'];
	$estado = Butaca::buscaEstadoCodigoDescuento($seleccionado);
	
	if($estado)
	{
		
		echo 'Activado';
	}
		
	else
		echo 'Desactivado';
?>