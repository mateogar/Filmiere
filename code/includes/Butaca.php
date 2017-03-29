<?php

namespace es\ucm\fdi\aw;

use es\ucm\fdi\aw\Aplicacion as App;

class Butaca {
	
	public static function ocuparButaca($fila, $columna, $idHorario, $idHistorial)
	{
		$app = App::getSingleton();
		$conn = $app->conexionBd();
		$query = sprintf("INSERT INTO butacas_ocupadas (id_horario, fila, columna, id_compra) VALUES ('%d', '%d', '%d', '%d')",
				$conn->real_escape_string($idHorario), $conn->real_escape_string($fila), $conn->real_escape_string($columna),
				$conn->real_escape_string($idHistorial));
		$rs = $conn->query($query);
		
		if($rs)
			return true;
		else
			return false;
	}
	
	public static function butacasOcupadasEnSala($id_horario, $nSala)
	{
		$app = App::getSingleton();
		$conn = $app->conexionBd();
		$query = sprintf("SELECT * FROM butacas_ocupadas NATURAL JOIN plantilla_butacas_sala WHERE id_horario = '%d' AND num_sala = '%d' ",
			$conn->real_escape_string($id_horario), $conn->real_escape_string($nSala));
		$rs = $conn->query($query);
		$butacasOcupadas = array();
		
		while ($fila = $rs->fetch_assoc()) 
		  $butacasOcupadas[] = new Butaca($fila['num_sala'], $fila['fila'], $fila['columna'], $fila['tipo_butaca']);		  
	  
		$rs->free();
		
		return $butacasOcupadas;
	}


	public static function tiposButacas()
	{
		$app = App::getSingleton();
		$conn = $app->conexionBd();
		$query = sprintf("SELECT tipo FROM precios_butacas");
		$rs = $conn->query($query);
		$tiposButacas = array();
		
		while ($fila = $rs->fetch_assoc()) 
		  $tiposButacas[] = $fila['tipo'];		  
	  
		$rs->free();
		
		return $tiposButacas;
	} 

	public static function codigosDescuentos()
	{
		$app = App::getSingleton();
		$conn = $app->conexionBd();
		$query = sprintf("SELECT codigo FROM codigos_descuentos");
		$rs = $conn->query($query);
		$cods = array();
		
		while ($fila = $rs->fetch_assoc()) 
		  $cods[] = $fila['codigo'];		  
	  
		$rs->free();
		
		return $cods;
	} 

	
	public static function tiposDescuentos()
	{
		$app = App::getSingleton();
		$conn = $app->conexionBd();
		$query = sprintf("SELECT tipo FROM descuentos");
		$rs = $conn->query($query);
		$tipos = array();
		
		while ($fila = $rs->fetch_assoc()) 
		  $tipos[] = $fila['tipo'];		  
	  
		$rs->free();
		
		return $tipos;
	} 

	public static function buscaPrecioTipoButaca($tipo) {

		$app = App::getSingleton();
		$conn = $app->conexionBd();
		$query = sprintf("SELECT precio FROM precios_butacas WHERE tipo = '%s'",
		 $conn->real_escape_string($tipo));
		$rs = $conn->query($query);
		
		
		if ($fila = $rs->fetch_assoc()) 
		  $precio = $fila['precio'];		  
	  
		$rs->free();
		
		return $precio;

	}

	public static function buscaEstadoCodigoDescuento($codigo) {

		$app = App::getSingleton();
		$conn = $app->conexionBd();
		$query = sprintf("SELECT activado FROM codigos_descuentos WHERE codigo = '%s'",
		 $conn->real_escape_string($codigo));
		$rs = $conn->query($query);
		
		
		if ($fila = $rs->fetch_assoc()) 
		  $estado = $fila['activado'];		  
	  
		$rs->free();
		
		return $estado;

	}
	

	public static function buscaPorcentajeDescuento($tipo) {

		$app = App::getSingleton();
		$conn = $app->conexionBd();
		$query = sprintf("SELECT porcentaje FROM descuentos WHERE tipo = '%s'",
		 $conn->real_escape_string($tipo));
		$rs = $conn->query($query);
		
		
		if ($fila = $rs->fetch_assoc()) 
		  $porcentaje = $fila['porcentaje'];		  
	  
		$rs->free();
		
		return $porcentaje;

	}

	
	public static function cambiarPrecioButaca($tipo, $nuevoPrecio) {

		$app = App::getSingleton();
		$conn = $app->conexionBd();
		$query = sprintf("UPDATE precios_butacas SET precio = '%d' WHERE tipo = '%s'",
		 $conn->real_escape_string($nuevoPrecio),$conn->real_escape_string($tipo));
		$rs = $conn->query($query);
	

	}

	public static function cambiarCodDescuento($cod, $nuevoEstado) {

		$app = App::getSingleton();
		$conn = $app->conexionBd();
		$query = sprintf("UPDATE codigos_descuentos SET activado = '%d' WHERE codigo = '%s'",
		 $conn->real_escape_string($nuevoEstado),$conn->real_escape_string($cod));
		$rs = $conn->query($query);
	

	}

	public static function cambiarPorcentajeDescuento($tipo, $nuevoPrecio) {

		$app = App::getSingleton();
		$conn = $app->conexionBd();
		$query = sprintf("UPDATE descuentos SET porcentaje = '%d' WHERE tipo = '%s'",
		 $conn->real_escape_string($nuevoPrecio),$conn->real_escape_string($tipo));
		$rs = $conn->query($query);
	

	}

	public static function anyadirCodigoDescuento($codigo, $porcentaje, $activo) {

		$app = App::getSingleton();
		$ok = false;
		$conn = $app->conexionBd();
		$query = sprintf("INSERT INTO codigos_descuentos(codigo,porcentaje, activado) VALUES ('%s', '%d','%d') ",
		 $conn->real_escape_string($codigo),$conn->real_escape_string($porcentaje),$conn->real_escape_string($activo));
		$rs = $conn->query($query);
		if($rs)
			$ok = true;
		return $ok;
	}



	public static function buscaButaca($fila, $columna, $sala) {
		$app = App::getSingleton();
		$conn = $app->conexionBd();
		$query = sprintf("SELECT * FROM butacas WHERE num_sala='%s' AND fila='%s' AND columna='%s'", $conn->real_escape_string($sala),$conn->real_escape_string($fila),$conn->real_escape_string($columna));
		$rs = $conn->query($query);
		if ($rs && $rs->num_rows >0) {
		  $row = $rs->fetch_assoc();
		  $butaca = new Butaca($row['num_sala'], $row['fila'], $row['columna'], $row['tipo_butaca']);
		  $rs->free();
		  $srcImg = 'img/butaca.png';
		  if($butaca->getTipo() === 'OCUPADA'){
			  $srcImg = 'img/ocupado.png';
		  }else{
			  if($butaca->getTipo() === 'VIP'){
				$srcImg = 'img/especial.png';
			  }else{
				  if($butaca->getTipo() === 'MINUSVALIDOS'){
					$srcImg = 'img/minus.png';
				  }else{
			if($butaca->getTipo() === 'SELECCIONADO'){
			$srcImg = 'img/seleccionado.png';
			}
		  }
			  }
		  }
		  return App::getSingleton()->resuelve($srcImg) ;
		}
		return false;
	}
  
	public static function butacasSala($sala) {
		$app = App::getSingleton();
		$conn = $app->conexionBd();
		$butaca = array();
		$query = sprintf("SELECT DISTINCT * FROM plantilla_butacas_sala WHERE num_sala='%s'", $conn->real_escape_string($sala));
		$rs = $conn->query($query);		
		while ($fila = $rs->fetch_assoc()) {
		  $butaca[] = new Butaca($fila['num_sala'], $fila['fila'], $fila['columna'], $fila['tipo_butaca']);		  
		}
		$rs->free();
		return $butaca;
	}
	
	public static function getFilasSala($sala) {
		$app = App::getSingleton();
		$conn = $app->conexionBd();
		$query = sprintf("SELECT MAX(fila) as filas FROM plantilla_butacas_sala WHERE num_sala='%s'", $conn->real_escape_string($sala));
		$rs = $conn->query($query);		
		while ($fila = $rs->fetch_assoc()) {
		  $filas = $fila['filas'];
		}
		$rs->free();
		return $filas;
	}
	
	public static function getColumnasSala($sala) {
		$app = App::getSingleton();
		$conn = $app->conexionBd();
		$query = sprintf("SELECT MAX(columna) as columnas FROM plantilla_butacas_sala WHERE num_sala='%s'", $conn->real_escape_string($sala));
		$rs = $conn->query($query);		
		while ($fila = $rs->fetch_assoc()) {
		  $columnas = $fila['columnas'];
		}
		$rs->free();
		return $columnas;
	}
	
	public static function getSalaEnHorario($date) {
		$app = App::getSingleton();
		$conn = $app->conexionBd();
		$query = sprintf("SELECT sala FROM horario WHERE id_horario='%s'", $conn->real_escape_string($date));
		$rs = $conn->query($query);		
		while ($fila = $rs->fetch_assoc()) {
		  $sala = $fila['sala'];		  
		}
		$rs->free();
		return $sala;
	}
	
	public static function buscaButacaSalaCompra($sala, $fila, $columna) {
		$app = App::getSingleton();
		$conn = $app->conexionBd();
		$query = sprintf("SELECT DISTINCT * FROM plantilla_butacas_sala WHERE num_sala='%s' AND fila='%s' AND columna='%s'", 
								$conn->real_escape_string($sala),
								$conn->real_escape_string($fila),
								$conn->real_escape_string($columna));
		$rs = $conn->query($query);		
		while ($fila = $rs->fetch_assoc()) {
		  $butaca = new Butaca($fila['num_sala'], $fila['fila'], $fila['columna'], $fila['tipo_butaca']);		  
		}
		$rs->free();
		return $butaca;
	}
	
	public static function devuelvePrecio($tipo){
		$app = App::getSingleton();
		$conn = $app->conexionBd();
		$precio = 0;
		$query = sprintf("SELECT precio FROM precios_butacas WHERE tipo = '%s'", $conn->real_escape_string($tipo));
		$rs = $conn->query($query);		
		if($fila = $rs->fetch_assoc()) {
		  $precio = $fila['precio'];
		}
		
		$rs->free();
		return $precio;
	}
	
	public static function estaOcupada($date, $fila, $columna) {
		$app = App::getSingleton();
		$conn = $app->conexionBd();
		$query = sprintf("SELECT * FROM `butacas_ocupadas` WHERE id_horario = '%s' AND fila = '%s' AND columna = '%s'", 
						$conn->real_escape_string($date),
						$conn->real_escape_string($fila),
						$conn->real_escape_string($columna));
		$rs = $conn->query($query);
		if ($rs && $rs->num_rows >0) {
		 return true;
		}
		return false;
	}
  
  private $fila;
  private $columna;
  private $tipo;
  private $sala;

  private function __construct($sala, $fila, $columna, $tipo) {
	$this->sala = $sala;
    $this->fila = $fila;
    $this->columna = $columna;
	$this->tipo = $tipo;
  }
  
  public function getSala() {
    return $this->sala;
  }
  
  public function getFila() {
    return $this->fila;
  }
  
  public function getColumna() {
    return $this->columna;
  }
  
  public function getTipo() {
    return $this->tipo;
  }
  
  public function setTipo($type) {
    $this->tipo = $type;
  }

}
?>