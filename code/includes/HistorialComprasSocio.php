<?php

namespace es\ucm\fdi\aw;

use es\ucm\fdi\aw\Aplicacion as App;

class HistorialComprasSocio
{
	private $pelicula, $numEntradas, $precio, $fecha, $fila, $columna;
	
	private function __construct($pelicula, $numEntradas, $precio, $fecha, $fila, $columna)
	{
		$this->pelicula = $pelicula;
		$this->numEntradas = $numEntradas;
		$this->precio = $precio;
		$this->fecha = $fecha;
		$this->fila = $fila;
		$this->columna = $columna;
	}

    public static function getHistorialCompras()
    {
        $app = App::getSingleton();
		$conn = $app->conexionBd();
        $nombreSocio = $app->nombreUsuario();
		$sql = "SELECT titulo,num_entradas,precio,fecha,fila,columna
				FROM historial_compras,butacas_ocupadas,horario,peliculas
				WHERE historial_compras.socio = '$nombreSocio' AND
					  butacas_ocupadas.id_compra = historial_compras.id_compra AND
					  horario.id_horario = butacas_ocupadas.id_horario AND
					  peliculas.id_pelicula = horario.id_pelicula";

		$rs = $conn->query($sql);
		$historial = array();
		
		while($fila = $rs->fetch_assoc())
			$historial[] = new HistorialComprasSocio($fila['titulo'], $fila['num_entradas'], $fila['precio'], $fila['fecha'], $fila['fila'], $fila['columna']);
    
		$rs->free();
		
		return $historial;
    }
    
    public function getPelicula()
    {
        return $this->pelicula;
    }
    
    public function getNumentradas()
    {
        return $this->numEntradas;
    }
    
    public function getPrecio()
    {
        return $this->precio;
    }
    
    public function getFecha()
    {
        return $this->fecha;
    }
	
	public function getFila()
    {
        return $this->fila;
    }
	
	public function getColumna()
    {
        return $this->columna;
    }
}
?>