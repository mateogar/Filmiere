<?php

namespace es\ucm\fdi\aw;

class FormularioEliminarPromo extends Form {

  const HTML5_EMAIL_REGEXP = '^[a-zA-Z0-9.!#$%&\'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$';

  private $idPromo;
  public function __construct($idPromo) {
    parent::__construct('formEliminar'.$idPromo);
    $this->idPromo = $idPromo;
  }
  
  protected function generaCamposFormulario ($datos) {
    $camposFormulario=<<<EOF
    <input type="image" class="eliminarPromo" src="img/eliminar.png" />
    <input type="hidden" name="promo" value="
EOF;
    $camposFormulario.=$this->idPromo;
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
    Promo::eliminarPromo($this->idPromo);
    $result = \es\ucm\fdi\aw\Aplicacion::getSingleton()->resuelve('/promociones_gestor.php');

	return $result;
  }
}
