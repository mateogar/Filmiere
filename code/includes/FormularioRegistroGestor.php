<?php

namespace es\ucm\fdi\aw;

class FormularioRegistroGestor extends Form {

  const HTML5_EMAIL_REGEXP = '^[a-zA-Z0-9.!#$%&\'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$';

  public function __construct() {
    parent::__construct('formRegistroGestor');
  }
  
  protected function generaCamposFormulario ($datos) {
    
    
    $userName = isset($datos['nombreUsuario']) ? $datos['nombreUsuario'] : null ;
    $camposFormulario=<<<EOF
    <p id="usuario">Nombre de Usuario:</p>
	<input type="text" name="nombreUsuario" value="$userName" />

	<p id="pass">Contraseña:</p>
	<input type="password" name="password" />

	<p id="passRep">Repetir Contraseña:</p>
	<input type="password" name="passwordRep" />

	<div id="chkbxSala1">
		<input type="checkbox" name="Sala1" value="on"/>Sala 1
	</div>
  <div id="chkbxSala2">
    <input type="checkbox" name="Sala2" value="on" />Sala 2
  </div>
  <div id="chkbxSala3">
    <input type="checkbox" name="Sala3" value="on" />Sala 3
  </div>
  <div id="chkbxSala4">
    <input type="checkbox" name="Sala4" value="on" />Sala 4
  </div>
  <div id="chkbxSala5">
    <input type="checkbox" name="Sala5" value="on" />Sala 5
  </div>
  <div id="chkbxSala6">
    <input type="checkbox" name="Sala6" value="on" />Sala 6
  </div>
	
	<button class="button_input" type="submit">Registrarse</button>
EOF;
    return $camposFormulario;
  }

  /**
   * Procesa los datos del formulario.
   */
  protected function procesaFormulario($datos) {
    $result = array();
    $ok = true;
    $usuario = isset($datos['nombreUsuario']) ? $datos['nombreUsuario'] : null ;
    if ( !$usuario ) {
      $result[] = 'El nombre de usuario no es válido';
      $ok = false;
    }

    //$salas[] coloca en la siguiente posición libre
    $salas[0] = isset($datos['Sala1']) ? $datos['Sala1'] : null ;
    $salas[1] = isset($datos['Sala2']) ? $datos['Sala2'] : null ;
    $salas[2] = isset($datos['Sala3']) ? $datos['Sala3'] : null ;
    $salas[3] = isset($datos['Sala4']) ? $datos['Sala4'] : null ;
    $salas[4] = isset($datos['Sala5']) ? $datos['Sala5'] : null ;
    $salas[5] = isset($datos['Sala6']) ? $datos['Sala6'] : null ;
    if ( !$salas[0] && !$salas[1] && !$salas[2] && !$salas[3] && !$salas[4] && !$salas[5]) {
      $result[] = 'Debes seleccionar alguna sala';
      $ok = false;
    }

    $password = isset($datos['password']) ? $datos['password'] : null ;
    if ( ! $password ||  mb_strlen($password) < 4 ) {
      $result[] = 'La contraseña no es válida';
      $ok = false;
    }

    $passRep= isset($datos['passwordRep']) ? $datos['passwordRep'] : null ;
    if (  $password !== $passRep) {
      $result[] = 'Las contraseñas no coinciden';
      $ok = false;
    }

    if ( $ok ) {

      $user = Usuario::buscaUsuario($usuario, $password);
      if ( !$user ) {

      	$salaOcupada = Gestor::buscaSalas($salas);
      	if ( !$salaOcupada ) {
        // SEGURIDAD: Forzamos que se genere una nueva cookie de sesión por si la han capturado antes de hacer login
        	session_regenerate_id(true);
          $aleatorio = rand();
          //Contraseña + número aleatorio
          $password = $password . $aleatorio;
          $pass = password_hash($password, PASSWORD_BCRYPT);
        	$ok = Gestor::registrarGestor($usuario, $pass, $salas, $aleatorio);
			     if($ok){
				      $result = \es\ucm\fdi\aw\Aplicacion::getSingleton()->resuelve('/i_admin.php');
			     }
			     else 
              $result[] = 'No se ha podido realizar el registro';
    	  }else
  		    $result[] = 'Ya hay un gestor con esa sala asignada.';
      }else {
        $result[] = 'El usuario ya existe';
      }
    }
    return $result;
  }
}
