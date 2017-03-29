<?php

namespace es\ucm\fdi\aw;

class FormularioContacto extends Form
{
	const HTML5_EMAIL_REGEXP = '^[a-zA-Z0-9.!#$%&\'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$';

	public function __construct()
	{
		parent::__construct('FormContacto');
	}
  
	protected function generaCamposFormulario($datos)
	{
		$nombre = isset($datos['nombre']) ? $datos['nombre'] : null;
		$correo = isset($datos['email']) ? $datos['email'] : null;
		$asunto = isset($datos['asunto']) ? $datos['asunto'] : null;
		$mensaje = isset($datos['cuadroConsulta']) ? $datos['cuadroConsulta'] : null;

		$camposFormulario = <<<EOF
		<div class="cNombre">
			<p>Nombre</p>
			<input type="text" name="nombre" value="$nombre" />
			
			</div>
				<div>
					<p>E-mail</p>
					<input type="text" name="email" value="$correo" />
				</div>
				<div>
					<p>Asunto</p>
					<input type="text" name="asunto" value="$asunto" />
				</div>
				<div>
					<p>Mensaje</p>
					<textarea name="cuadroConsulta" rows="4" cols="50">$mensaje</textarea>
			</div>
			
			<input type="reset" value="Limpiar"  class="button_input"/>
			<input type="submit" value="Enviar"  class="button_input"/>
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
	
		$nombre = isset($datos['nombre']) ? $datos['nombre'] : null;
		$correo = isset($datos['email']) ? $datos['email'] : null;
		
		if(!$correo || !mb_ereg_match(self::HTML5_EMAIL_REGEXP, $correo)) //Correo obligatorio.
		{
			$result[] = 'Correo inválido.';
			$ok = false;
		}
		
		$asunto = isset($datos['asunto']) ? $datos['asunto'] : null;
		$mensaje = isset($datos['cuadroConsulta']) ? $datos['cuadroConsulta'] : null;
		
		if(!$mensaje)
		{
			$result[] = 'Indicar la consulta en el cuadro de mensaje.';
			$ok = false;
		}
		
		if($ok)
		{		
			$ok = Contacto::enviarFormularioContacto($nombre, $correo, $asunto, $mensaje);
			
			if($ok)
				$result = \es\ucm\fdi\aw\Aplicacion::getSingleton()->resuelve('/contacto.php');
			else
				$result[] = 'No se han podido enviar el formulario.';
		}
		
		return $result;
	}
}
?>