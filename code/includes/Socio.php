<?php

namespace es\ucm\fdi\aw;

use es\ucm\fdi\aw\Aplicacion as App;

class Socio extends Usuario {

  public static function buscaCorreo($mail) {
    $app = App::getSingleton();
    $conn = $app->conexionBd();
    $query = sprintf("SELECT correo FROM socio WHERE correo='%s'", $conn->real_escape_string($mail));
    $rs = $conn->query($query);
    if ($rs && $rs->num_rows > 0) return true;
    return false;
  }

  public static function registrarSocio($username, $password, $mail, $aleatorio){
    $app = App::getSingleton();
    $conn = $app->conexionBd();
    $query = sprintf("INSERT INTO usuarios VALUES('%s', '%s', '%s', '%d')", $conn->real_escape_string($username),
      $conn->real_escape_string($password),$conn->real_escape_string('SOCIO'),
      $conn->real_escape_string($aleatorio));
    $rs = $conn->query($query);
    if($rs){
      $query = sprintf("INSERT INTO socio VALUES('%s', null, '%s', null)", $conn->real_escape_string($username),
          $conn->real_escape_string($mail));
      $rs = $conn->query($query);
      if($rs) 
        return true;

      return false;
    }
    return false;
  }


  public static function devuelveSocio($nombreUsuario) {
    $app = App::getSingleton();
    $conn = $app->conexionBd();
    $query = sprintf("SELECT * FROM socio WHERE nombre_usuario='%s'", $conn->real_escape_string($nombreUsuario));
    $rs = $conn->query($query);
    if ($rs && $rs->num_rows > 0) {
      $fila = $rs->fetch_assoc();
	  $rs->free();
      return new Socio($fila['nombre_usuario'],$fila['nombre_completo'] , $fila['correo'], $fila['telefono']);
    }
    return false;
  }

	public static function modificarDatosSocio($nombre, $nombreCompleto, $correo, $tlf, $newPass, $aleatorio)
	{
		$app = App::getSingleton();
		$conn = $app->conexionBd();
		//Modificar los datos personales del usuario.
		$query = sprintf("UPDATE socio SET nombre_completo='%s', correo='%s', telefono='%s' WHERE nombre_usuario='%s';",
			$conn->real_escape_string($nombreCompleto), $conn->real_escape_string($correo), $conn->real_escape_string($tlf),
			$conn->real_escape_string($nombre));
		
		$ok = $conn->query($query);
		
		//Modificar también la contraseña si hace falta.
		if($ok && $newPass)
			$ok = Usuario::cambiarPass($nombre, $newPass, $aleatorio);
		
		return $ok;
	}
  
  private $nombreCompleto;

  private $correo;

  private $telefono;

  private function __construct($username,$nombreCompleto, $mail, $numero) {
    $this->username = $username;
    $this->nombreCompleto = $nombreCompleto;
    $this->correo = $mail;
	  $this->telefono = $numero;
  }


  public function username() {
    return $this->username;
  }

  public function nombreCompleto() {
    return $this->nombreCompleto;
  }

  public function setNombreCompleto($nombre) {
    $this->nombreCompleto = $nombre;
  }

  public function correo() {
    return $this->correo;
  }

  public function numero() {
    return $this->telefono;
  }

  public function setNumero($numero) {
    $this->telefono = $numero;
  }

  

}
