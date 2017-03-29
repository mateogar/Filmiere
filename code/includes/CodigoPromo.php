<?php
namespace es\ucm\fdi\aw;
use es\ucm\fdi\aw\Aplicacion as App;

class CodigoPromo
{
	private $codigo;
	private $porcentajeDescuento;
	private $activo;
	
	private function __construct($codigo, $porcentajeDescuento, $activo)
	{
		$this->codigo = $codigo;
		$this->porcentajeDescuento = $porcentajeDescuento;
		$this->activo = $activo;
	}

	public function getEstado() {

		return $this->activo;	
	}
	
	public function getPorcentajeDescuento()
	{
	  return $this->porcentajeDescuento;
	}
	
	public static function getCodigoPromo($codigopromo)
	{
		$app = App::getSingleton();
		$conn = $app->conexionBd();
		$query = sprintf("SELECT * FROM codigos_descuentos WHERE codigo = '%s'", $conn->real_escape_string($codigopromo));
		$rs = $conn->query($query);
		$codigo = null;
		
		if($fila = $rs->fetch_assoc())
			  $codigo = new CodigoPromo($fila['codigo'], $fila['porcentaje'], $fila['activado']); 
				
		$rs->free();
		
		return $codigo;
	}
}
?>