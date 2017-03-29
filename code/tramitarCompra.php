<?php
	namespace es\ucm\fdi\aw;
	require_once __DIR__.'/includes/config.php';
	
	 $desc = null;
	
	if(isset($_REQUEST['butacas']) && isset($_REQUEST['date']))
	{	
		$butacas = array();
		$butacas = $_REQUEST['butacas'];
		$date = $_REQUEST['date'];
		$codigoPromo = $_REQUEST['codigopromo'];
		$tipoDescuento = $_REQUEST['tipodescuento'];
		ButacasOps::generaCampoCompraButacas($butacas, $date, $codigoPromo, $tipoDescuento);
	}else{
		echo "<h1>Seleccione alguna butaca</h1>";
	}
?>