<?php

namespace es\ucm\fdi\aw;

class FormularioLogin extends Form {

  const HTML5_EMAIL_REGEXP = '^[a-zA-Z0-9.!#$%&\'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$';

  public function __construct() {
    parent::__construct('formLogin');
  }
  
  protected function generaCamposFormulario ($datos) {
    $username = 'admin';
    $password = 'admin';
    if ($datos) {
      $username = isset($datos['username']) ? $datos['username'] : $username;
      $password = isset($datos['password']) ? $datos['password'] : $password;
    }

    $camposFormulario=<<<EOF
    <p><label>Usuario:</label></p>
	<input type="text" name="username" />
	
    <p><label>Contraseña:</label></p>
	<input type="password" name="password" /><br />
    
	<button type="submit" class="button_input">Entrar</button>
    <p>Si todavía no eres socio, <a href="register.php">regístrate</a></p>
EOF;
    return $camposFormulario;
  }

  /**
   * Procesa los datos del formulario.
   */
  protected function procesaFormulario($datos) {
    $result = array();
    $ok = true;
    $username = isset($datos['username']) ? $datos['username'] : null ;
    if ( !$username ) {
      $result[] = 'El nombre de usuario no es válido';
      $ok = false;
    }

    $password = isset($datos['password']) ? $datos['password'] : null ;
    if ( ! $password ||  mb_strlen($password) < 4 ) {
      $result[] = 'La contraseña no es válida';
      $ok = false;
    }

    if ( $ok ) {
      $user = Usuario::login($username, $password);
      if ( $user ) {
        // SEGURIDAD: Forzamos que se genere una nueva cookie de sesión por si la han capturado antes de hacer login
        session_regenerate_id(true);
        Aplicacion::getSingleton()->login($user);
        if($user->rol() === 'GESTOR'){
		     Gestor::actualizarRegistro($username);
          $result = \es\ucm\fdi\aw\Aplicacion::getSingleton()->resuelve('/i_gestor.php');
		}
        elseif($user->rol() === 'ADMIN')
          $result = \es\ucm\fdi\aw\Aplicacion::getSingleton()->resuelve('/i_admin.php');
        else
          $result = \es\ucm\fdi\aw\Aplicacion::getSingleton()->resuelve('/perfil_usuario.php');
      }else
           $result[] = 'El usuario o la contraseña es incorrecta';
    }
    return $result;
  }
}
