<?php

namespace es\ucm\fdi\aw;

class FormularioEliminarPelicula extends Form {

  const HTML5_EMAIL_REGEXP = '^[a-zA-Z0-9.!#$%&\'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$';

  private $idPelicula;
  public function __construct($idPelicula) {
    parent::__construct('formEliminar'.$idPelicula);
    $this->idPelicula = $idPelicula;
  }
  
  protected function generaCamposFormulario ($datos) {
    $camposFormulario=<<<EOF
    <input type="image" class="eliminarPelicula" src="img/eliminar.png" />
    <input type="hidden" name="pelicula" value="
EOF;
    $camposFormulario.=$this->idPelicula;
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
    Pelicula::eliminarPelicula($this->idPelicula);
    $result = \es\ucm\fdi\aw\Aplicacion::getSingleton()->resuelve('/peliculas_eliminar.php');

	return $result;
  }
}
