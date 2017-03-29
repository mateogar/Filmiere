<?php

namespace es\ucm\fdi\aw;

class FormularioRegistro extends Form {

  const HTML5_EMAIL_REGEXP = '^[a-zA-Z0-9.!#$%&\'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$';

  public function __construct() {
    parent::__construct('formRegistro');
  }
  
  protected function generaCamposFormulario ($datos) {

    $usuario = isset($datos['nombreUsuario']) ? $datos['nombreUsuario'] : null ;
    $mail = isset($datos['correo']) ? $datos['correo'] : null ;

    $camposFormulario=<<<EOF
    <p id="usuario">Nombre de Usuario:</p>
	<input type="text" name="nombreUsuario" value="$usuario" />

	<p id="correo">Correo:</p>
	<input type="text" name="correo" value="$mail" />

	<p id="pass">Contraseña:</p>
	<input type="password" name="password" />

	<p id="passRep">Repetir Contraseña:</p>
	<input type="password" name="passwordRep" />

	<div id="chkbxTerminos">
		<input type="checkbox" name="terminosCondiciones" value="on" />Acepto los 
		<a href="termCond.php">términos y condiciones de uso</a>
	</div>
	
	<button type="submit" class='button_input'>Registrarse</button>
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

    $mail = isset($datos['correo']) ? $datos['correo'] : null ;
    if ( !$mail || ! mb_ereg_match(self::HTML5_EMAIL_REGEXP, $mail)) {
      $result[] = 'El mail de usuario no es válido';
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

    $botonTerm= isset($datos['terminosCondiciones']) ? $datos['terminosCondiciones'] : null ;
     if ( ! $botonTerm ) {
      $result[] = 'Debes aceptar los términos y condiciones de uso.';
      $ok = false;
    }

    if ( $ok ) {
      
      $user = Usuario::buscaUsuario($usuario, $password);
      if ( !$user ) {
      	$correo = Socio::buscaCorreo($mail);
      	if ( !$correo ) {
          //Primero generamos un número aleatorio y ciframos la concatenación(la sal)
          $aleatorio = rand();
          //Contraseña + número aleatorio
          $passwordA = $password . $aleatorio;
          $pass = password_hash($passwordA, PASSWORD_BCRYPT);
        // SEGURIDAD: Forzamos que se genere una nueva cookie de sesión por si la han capturado antes de hacer login
        	session_regenerate_id(true);
        	$ok = Socio::registrarSocio($usuario, $pass, $mail, $aleatorio);
			if($ok){
				$u = Usuario::login($usuario, $password);
				Aplicacion::getSingleton()->login($u);
				$result = \es\ucm\fdi\aw\Aplicacion::getSingleton()->resuelve('/perfil_usuario.php');
			}
			else 
        $result[] = 'No se ha podido realizar el registro';

    	}else
    		$result[] = 'Ya hay un usuario registrado con ese correo';
      }else {
        $result[] = 'El usuario ya existe';
      }
    }
    return $result;
  }
}
