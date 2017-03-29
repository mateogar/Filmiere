<?php

namespace es\ucm\fdi\aw;

class FormularioRegistroAdmin extends Form {

  const HTML5_EMAIL_REGEXP = '^[a-zA-Z0-9.!#$%&\'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$';

  public function __construct() {
    parent::__construct('formRegistroAdmin');
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

	<p><button class="button_input" type="submit">Registrar </button></p>
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

        // SEGURIDAD: Forzamos que se genere una nueva cookie de sesión por si la han capturado antes de hacer login
        	session_regenerate_id(true);
          $aleatorio = rand();
          //Contraseña + número aleatorio
          $password = $password . $aleatorio;
          $pass = password_hash($password, PASSWORD_BCRYPT);
        	$ok = Admin::registrarAdmin($usuario, $pass, $aleatorio);
			     if($ok){
				      $result = \es\ucm\fdi\aw\Aplicacion::getSingleton()->resuelve('/i_admin.php');
			     }
			     else 
              $result[] = 'No se ha podido realizar el registro';
      }else {
        $result[] = 'El usuario ya existe';
      }
    }
    return $result;
  }
}
