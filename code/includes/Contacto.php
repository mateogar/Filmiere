<?php

namespace es\ucm\fdi\aw;

use es\ucm\fdi\aw\Aplicacion as App;

class Contacto
{
	private $id, $nombre, $correo, $asunto, $mensaje;
	
	private function __construct($id, $nombre, $correo, $asunto, $mensaje)
	{
		$this->id = $id;
		$this->nombre = $nombre;
		$this->correo = $correo;
		$this->asunto = $asunto;
		$this->mensaje = $mensaje;
	}
	
	public static function eliminarContacto($id)
	{
		$app = App::getSingleton();
		$conn = $app->conexionBd();
		$sql = sprintf("DELETE FROM contacto WHERE id = '%s';", $conn->real_escape_string($id));
		
		return $conn->query($sql) ? true : false;
	}
	
	public static function enviarFormularioContacto($nombre, $correo, $asunto, $mensaje)
	{
		$app = App::getSingleton();
		$conn = $app->conexionBd();
		$sql = sprintf("INSERT INTO contacto (nombre, email, asunto, mensaje) VALUES ('%s', '%s', '%s', '%s');",
			$conn->real_escape_string($nombre), $conn->real_escape_string($correo), $conn->real_escape_string($asunto),
			$conn->real_escape_string($mensaje));
		
		return $conn->query($sql) ? true : false;
	}
	
	public static function getTodosContactos()
	{
		$app = App::getSingleton();
		$conn = $app->conexionBd();
		$sql = sprintf("SELECT * FROM contacto;");
		$rs = $conn->query($sql);
		$contactos = array();
		
		while($fila = $rs->fetch_assoc())
			$contactos[] = new Contacto($fila['id'], $fila['nombre'], $fila['email'], $fila['asunto'], $fila['mensaje']);
    
		$rs->free();
		
		return $contactos;
	}
	
	public function getId()
	{
		return $this->id;
	}
	
	public function getNombre()
	{
		return $this->nombre;
	}
	
	public function getCorreo()
	{
		return $this->correo;
	}
	
	public function getAsunto()
	{
		return $this->asunto;
	}
	
	public function getMensaje()
	{
		return $this->mensaje;
	}
}
?>