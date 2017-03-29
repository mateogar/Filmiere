<?php

namespace es\ucm\fdi\aw;

use es\ucm\fdi\aw\Aplicacion as App;

class Usuario {

  //Password: Contraseña en texto plano.
  public static function login($username, $password) {
    $user = self::buscaUsuario($username);
    if ($user && $user->compruebaPassword($password)) {
      return $user;
    }    
    return false;
  }

  public static function buscaUsuario($username) {
    $app = App::getSingleton();
    $conn = $app->conexionBd();
    $query = sprintf("SELECT * FROM usuarios WHERE nombreU='%s'", $conn->real_escape_string($username));
    $rs = $conn->query($query);
    if ($rs && $rs->num_rows == 1) {
      $fila = $rs->fetch_assoc();
      $user = new Usuario($fila['NombreU'], $fila['Contrasena'], $fila['Tipo'],$fila['num_aleatorio']);
      $rs->free();

      return $user;
    }
    return false;
  }

  public static function cambiarPass($username, $pass, $aleatorio) {
    $app = App::getSingleton();
    $conn = $app->conexionBd();
    $query = sprintf("UPDATE usuarios SET Contrasena = '%s', num_aleatorio = '%d' WHERE nombreU = '%s'", $conn->real_escape_string($pass)
            ,$conn->real_escape_string($aleatorio),$conn->real_escape_string($username));
    $rs = $conn->query($query);

    if($rs)
      return true;

    return false;
  }


  public static function getUsuarios() {
    $app = App::getSingleton();
    $conn = $app->conexionBd();
    $usuarioConectado = $app->nombreUsuario();
    $users = array();
    $query = sprintf("SELECT NombreU FROM usuarios WHERE nombreU <> '%s'", $conn->real_escape_string($usuarioConectado));
    $rs = $conn->query($query);
    while ($fila = $rs->fetch_assoc()) {
      
      $users[] = $fila['NombreU'];      
    }
    $rs->free();
    return $users;
  }

  public static function eliminarUsuario($user) {
    $app = App::getSingleton();
    $conn = $app->conexionBd();
    $query = sprintf("DELETE FROM usuarios WHERE nombreU='%s'", $conn->real_escape_string($user));
    $rs = $conn->query($query);
    if($rs)
      return true;

    return false;
  }


  
  
  private $username;

  private $password;

  private $rol;

  private $aleatorio;

  private function __construct($username, $password, $tipo, $aleatorio) {
    $this->username = $username;
    $this->password = $password;
    $this->rol = $tipo;
    $this->aleatorio = $aleatorio;
  }

  public function setRol($role) {
    $this->rol = $role;
  }
  
  public function setPass($pass) {
    $this->password = $pass;
  }

  public function rol() {
    return $this->rol;
  }

  public function username() {
    return $this->username;
  }

  public function aleatorio() {
    return $this->aleatorio;
  }

  //$this->password la de la bd.
  public function compruebaPassword($pass) {
    $contrasena = $pass . $this->aleatorio;
    return password_verify($contrasena, $this->password);
  }
}