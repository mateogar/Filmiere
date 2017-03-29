<?php

namespace es\ucm\fdi\aw;

use es\ucm\fdi\aw\Aplicacion as App;

class Admin extends Usuario {


  public static function registrarAdmin($username, $password, $aleatorio){
    $app = App::getSingleton();
    $conn = $app->conexionBd();
    $ok = false;
    $query = sprintf("INSERT INTO usuarios VALUES('%s', '%s', '%s', '%d')", $conn->real_escape_string($username),
      $conn->real_escape_string($password),$conn->real_escape_string('ADMIN'),
      $conn->real_escape_string($aleatorio));
    $rs = $conn->query($query);

      if($rs)
        $ok = true;
    
    
    
    return $ok;
  }


  
  private $userName;

  //Solo se almacena una sala del gestor.
  private function __construct($userName) {
    $this->userName = $userName;
	}

  public function userName() {
    return $this->userName;
  }

}
?>