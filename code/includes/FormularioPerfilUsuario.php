<?php

namespace es\ucm\fdi\aw;

class FormularioPerfilUsuario extends Form {

  const HTML5_EMAIL_REGEXP = '^[a-zA-Z0-9.!#$%&\'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$';

  public function __construct() {
    parent::__construct('FormPerfilUsuario');
  }
  
  protected function generaCamposFormulario ($datos) {
    $app = \es\ucm\fdi\aw\Aplicacion::getSingleton();
    $nombreUsuario = $app->nombreUsuario();
    $socio = Socio::devuelveSocio($nombreUsuario);
    $userName = $socio->username();
    $nombreCompleto = $socio->nombreCompleto();
    $correo = $socio->correo();
    $telefono = $socio->numero();
    $camposFormulario=<<<EOF
     <p>Nombre Usuario: </p><input type="text" name="nombre_usuario" value="$userName" readonly/>
    <p>Nombre Completo: </p><input type="text" name="nombre_completo" value="$nombreCompleto" />
	<p>Correo: </p><input type="text" name="email" value="$correo" />
	<p>Teléfono: </p><input type="text" name="tlf" value="$telefono" />
	<p>Cambiar Contraseña: </p><input type="password" name="nuevo_pass" />
	<p>Repetir Contraseña: </p><input type="password" name="nuevo_pass_rep" />
	
	<p><button type="reset" class="button_input">Limpiar</button>
	<button class="button_input" type="submit">Confirmar Cambios</button></p>
EOF;
    return $camposFormulario;
  }

  /**
   * Procesa los datos del formulario.
   */
	protected function procesaFormulario($datos)
	{
		$result = array();
		$ok = true;
		
		$nombre = isset($datos['nombre_usuario']) ? $datos['nombre_usuario'] : null;
		
		if(!$nombre) //Nombre de usuario obligatorio.
		{
			$result[] = 'Nombre de Usuario inválido.';
			$ok = false;
		}
		
		$nombreCompleto = isset($datos['nombre_completo']) ? $datos['nombre_completo'] : null;
		
		$correo = isset($datos['email']) ? $datos['email'] : null;
		
		if(!$correo || !mb_ereg_match(self::HTML5_EMAIL_REGEXP, $correo)) //Correo obligatorio.
		{
			$result[] = 'Correo inválido.';
			$ok = false;
		}
		
		$tlf = isset($datos['tlf']) ? $datos['tlf'] : null;
		$newPass = isset($datos['nuevo_pass']) ? $datos['nuevo_pass'] : null;
		$newPassRep = isset($datos['nuevo_pass_rep']) ? $datos['nuevo_pass_rep'] : null;
		
		//Si alguno de los campos de contraseña tienen datos y el otro no.
		if(($newPass && !$newPassRep) || (!$newPass && $newPassRep))
		{
			$result[] = 'Las contraseñas no coinciden.';
			$ok = false;
		}
		else
		{
			if($newPass && $newPassRep)
			{
				//Si la contraseña tiene longitud mínima y coinciden.
				if(mb_strlen($newPass) < 4 || ($newPass !== $newPassRep))
				{
					$result[] = 'La contraseña no es válida o no coinciden.';
					$ok = false;
				}
			}			
		}
		
		if($ok)
		{
			$socio = Socio::devuelveSocio($nombre);
			$correoAnterior = $socio->correo();
			$existeCorreo = Socio::buscaCorreo($correo);
			
			//Si el nuevo correo no existe en la base o es el mismo de antes.
			if(!$existeCorreo || $correoAnterior == $correo)
			{
				if($newPass) {
					$aleatorio = rand();
          			//Contraseña + número aleatorio
          			$passwordA = $newPass . $aleatorio;
					$newPass = password_hash($passwordA, PASSWORD_BCRYPT);
				}
				$ok = Socio::modificarDatosSocio($nombre, $nombreCompleto, $correo, $tlf, $newPass, $aleatorio);
				
				if($ok)
					$result = \es\ucm\fdi\aw\Aplicacion::getSingleton()->resuelve('/perfil_usuario.php');
				else
					$result[] = 'No se han podido guardar los cambios.';
			}
			else
				$result[] = 'Ya hay un usuario registrado con ese correo.';
		}
		
		return $result;
	}
}
?>