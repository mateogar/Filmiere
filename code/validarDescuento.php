<?php
	namespace es\ucm\fdi\aw;
	require_once __DIR__.'/includes/config.php';
	
	if(isset($_REQUEST['tipodescuento']))
	{
		$tipoDescuento = $_REQUEST['tipodescuento'];
		
		if($tipoDescuento != "sin_descuento")
		{
			if(\es\ucm\fdi\aw\Aplicacion::getSingleton()->usuarioLogueado()
				&& \es\ucm\fdi\aw\Aplicacion::getSingleton()->rolUsuario() === "SOCIO")
				echo "true";
			else
				echo "false";
		}
		else
			echo "true";	
	}
	else
		echo "false"
?>