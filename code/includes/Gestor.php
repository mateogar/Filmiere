<?php

namespace es\ucm\fdi\aw;

use es\ucm\fdi\aw\Aplicacion as App;

class Gestor extends Usuario {

  public static function buscaSalas($salas) {
    $app = App::getSingleton();
    $conn = $app->conexionBd();

    $sentenciaWhere = "";

     
    for($i = 1; $i <= 6; $i++) {
      if($salas[$i-1])
        $sentenciaWhere .= " sala = " . $i . " or";
  }
    $sentenciaWhere = substr($sentenciaWhere, 0, -2);
    $query = sprintf("SELECT nombre_usuario FROM gestor WHERE" . $sentenciaWhere);
    $rs = $conn->query($query);
    if ($rs && $rs->num_rows > 0) 
      return true;

    return false;
  }





	public static function buscaSalasGestorConectado() {
	$app = App::getSingleton();
    $conn = $app->conexionBd();
    $uSalas = array();
	$username = $app->nombreUsuario();
    $query = sprintf("SELECT * FROM gestor WHERE gestor.nombre_usuario = '".$username."'");
    $rs = $conn->query($query);
    while ($fila = $rs->fetch_assoc()) {
      $uSalas[] =  $fila['sala'];
    }
    $rs->free();
    return $uSalas;
	}

  public static function registrarGestor($username, $password, $salas, $aleatorio){
    $app = App::getSingleton();
    $conn = $app->conexionBd();
    $ok = false;
    $query = sprintf("INSERT INTO usuarios VALUES('%s', '%s', '%s', '%d')", $conn->real_escape_string($username),
      $conn->real_escape_string($password),$conn->real_escape_string('GESTOR'),
      $conn->real_escape_string($aleatorio));
    $rs = $conn->query($query);
    
     if($rs){
      for($i = 1; $i <= 6 ; $i++) 
        if($salas[$i-1]){
          $query = sprintf("INSERT INTO gestor VALUES('%d', '%s')", $conn->real_escape_string($i),
                            $conn->real_escape_string($username));
          $rs = $conn->query($query);
          
        if($rs) {
          $query = sprintf("INSERT INTO registro_logs VALUES('%s', null)", 
            $conn->real_escape_string($username));
            $rs = $conn->query($query);
            }
            
          if($rs)
            $ok = true;
        }
    }
    
    return $ok;
  }

  public static function devuelveGestoresEnSala() {
    $app = App::getSingleton();
    $conn = $app->conexionBd();
    $gestores = array();
    $query = sprintf("SELECT nombre_usuario, sala, ultimo_log 
      FROM gestor LEFT JOIN registro_logs ON gestor.nombre_usuario= registro_logs.gestor
      ORDER BY sala");
    $rs = $conn->query($query);
    while ($fila = $rs->fetch_assoc()) {
      $gestores[] = new Gestor($fila['nombre_usuario'], $fila['sala'], $fila['ultimo_log']);    
    }
    $rs->free();
    return $gestores;
  }

  public static function devuelveTodosGestores() {
    $app = App::getSingleton();
    $conn = $app->conexionBd();
    $gestores = array();
    $query = sprintf("SELECT nombreU FROM usuarios WHERE Tipo = 'GESTOR'");
    $rs = $conn->query($query);
    while ($fila = $rs->fetch_assoc()) {
      $gestores[] = $fila['nombreU'];    
    }
    $rs->free();
    return $gestores;
  }

  
   public static function actualizarRegistro($name){
	$gestores = array();
	$app = App::getSingleton();
    $conn = $app->conexionBd();
	 
    $query = sprintf("UPDATE registro_logs SET ultimo_log = CURRENT_TIMESTAMP WHERE gestor = '%s'", 
      $conn->real_escape_string($name));
	$rs = $conn->query($query);
	
    }

  public static function eliminarGestorSala($numSala){
    $app = App::getSingleton();
    $conn = $app->conexionBd();
    $query = sprintf("DELETE FROM gestor WHERE sala = '%d'",
      $conn->real_escape_string($numSala));
    $rs = $conn->query($query);
  }


  public static function gestorEnSala($sala){
  
  $app = App::getSingleton();
  $conn = $app->conexionBd();
  $query = sprintf("SELECT nombre_usuario FROM gestor WHERE sala = '%d'", $conn->real_escape_string($sala));
  $rs = $conn->query($query);
    if($rs->fetch_assoc()) {
      return true;
  }
  $rs->free();
    return false;
  }

  public static function insertarGestorEnSala($sala, $username){
    $app = App::getSingleton();
    $conn = $app->conexionBd();
    $ok = false;
    $query = sprintf("INSERT INTO gestor VALUES('%d', '%s')", $conn->real_escape_string($sala),
                            $conn->real_escape_string($username));
    $rs = $conn->query($query);
    if($rs)
      $ok = true;
  
    return $ok;
  }

  public static function cambiarGestorSala($sala, $username){
  $app = App::getSingleton();
  $conn = $app->conexionBd();
   
  $query = sprintf("UPDATE gestor SET nombre_usuario = '%s' WHERE sala = '%d'", $conn->real_escape_string($username),
                            $conn->real_escape_string($sala));
  $rs = $conn->query($query);
  if($rs)
    return true;
  
  return false;
  }
  
  private $userName;

  private $sala;

  private $ultimoRegistro;

  //Solo se almacena una sala del gestor.
  private function __construct($userName, $sala, $ultimoRegistro) {
    $this->userName = $userName;
    $this->sala = $sala;
    $this->ultimoRegistro = $ultimoRegistro;
	}

  public function userName() {
    return $this->userName;
  }

  public function sala() {
    return $this->sala;
  }

  public function ultimoRegistro() {
    return $this->ultimoRegistro;
  }

}
?>