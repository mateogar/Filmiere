<?php

namespace es\ucm\fdi\aw;

class FormularioEliminarGestor extends Form {

  const HTML5_EMAIL_REGEXP = '^[a-zA-Z0-9.!#$%&\'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$';

  private $numSala;
  public function __construct($numSala) {
    parent::__construct('formEliminar'.$numSala);
    $this->numSala = $numSala;
  }
  
  protected function generaCamposFormulario ($datos) {
    $camposFormulario=<<<EOF
    <input type="image" src="img/eliminar.png" />
    <input type="hidden" name="numSala" value="
EOF;
    $camposFormulario.=$this->numSala;
    $camposFormulario.=<<<EOF
    "/>
EOF;
    return $camposFormulario;
  }

  /**
   * Procesa los datos del formulario.
   */
  protected function procesaFormulario($datos) {
    $result = array();
    session_regenerate_id(true);
    Gestor::eliminarGestorSala($this->numSala);
    $result = \es\ucm\fdi\aw\Aplicacion::getSingleton()->resuelve('/i_admin.php');

	return $result;
  }
}
