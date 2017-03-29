<?php

namespace es\ucm\fdi\aw;

class FormularioEliminarContacto extends Form
{
	const HTML5_EMAIL_REGEXP = '^[a-zA-Z0-9.!#$%&\'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$';

	private $id;
  
	public function __construct($id)
	{
		parent::__construct('formEliminarContacto'.$id);
		$this->id = $id;
	}
  
	protected function generaCamposFormulario ($datos)
	{
		$camposFormulario=<<<EOF
		<input type="image" src="img/eliminar.png" />
		<input type="hidden" name="id" value="
EOF;
		$camposFormulario .= $this->id;
		$camposFormulario .= <<<EOF
		"/>
EOF;
		return $camposFormulario;
	}

	/**
	* Procesa los datos del formulario.
	*/
	protected function procesaFormulario($datos)
	{
		$result = array();
		session_regenerate_id(true);
		Contacto::eliminarContacto($this->id);
		$result = \es\ucm\fdi\aw\Aplicacion::getSingleton()->resuelve('/mensajes_contacto.php');

		return $result;
	}
}
?>