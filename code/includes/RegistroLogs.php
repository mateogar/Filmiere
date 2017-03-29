<?php

namespace es\ucm\fdi\aw;

use es\ucm\fdi\aw\Aplicacion as App;

class RegistroLogs {

  public static function buscaRegistros() {
	$uRegistros = array();
    $app = App::getSingleton();
    $conn = $app->conexionBd();
   
    $query = sprintf("SELECT DISTINCT nombreU, ultimo_log FROM usuarios
     LEFT JOIN registro_logs ON usuarios.nombreU=registro_logs.gestor WHERE usuarios.tipo = 'GESTOR' 
     ORDER BY registro_logs.ultimo_log DESC");
    $rs = $conn->query($query);
	//Si no devuelve un booleano pon $rs->fetch_assoc()!= null
    while ($fila = $rs->fetch_assoc()) {
     
      $uRegistros[] = new RegistroLogs($fila['nombreU'], $fila['ultimo_log']);   
    }
	$rs->free();
    return $uRegistros;
  }

  private $username;

  private $uRegister;


  private function __construct($nombre, $ultimoReg) {
    $this->username = $nombre;
    $this->uRegister = $ultimoReg;
  }



   public function userName() {
    return $this->username;
  }


  public function ultimoRegistro() {
    return $this->uRegister;
  }

}