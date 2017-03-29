<?php
namespace es\ucm\fdi\aw;
use es\ucm\fdi\aw\Aplicacion as App;

class HistorialCompras
{
	public static function insertarHistorial($usuario, $idPelicula, $numEntradas, $precio, $fecha)
	{
		$app = App::getSingleton();
		$conn = $app->conexionBd();
		$sql = "";
		
		if($usuario == null)
			$sql = sprintf("INSERT INTO historial_compras (id_pelicula, num_entradas, precio, fecha) VALUES ('%d', '%d', '%f', '%s')",
				$conn->real_escape_string($idPelicula), $conn->real_escape_string($numEntradas), $conn->real_escape_string($precio),
				$conn->real_escape_string($fecha));
		else
			$sql = sprintf("INSERT INTO historial_compras (socio, id_pelicula, num_entradas, precio, fecha) VALUES ('%s', '%d', '%d', '%f', '%s')",
				$conn->real_escape_string($usuario), $conn->real_escape_string($idPelicula), $conn->real_escape_string($numEntradas),
				$conn->real_escape_string($precio), $conn->real_escape_string($fecha));
		
		$rs = $conn->query($sql);
		
		return $conn->insert_id;
	}
}
?>