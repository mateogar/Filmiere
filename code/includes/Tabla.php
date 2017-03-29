<?php

namespace es\ucm\fdi\aw;

/**
 * Clase de  de gestión de tablas.
 *
 * Gestión de token CSRF está basada en: https://www.owasp.org/index.php/PHP_CSRF_Guard
 */
interface Tabla {

  public function __construct();
  
  /**
   * Devuelve un <code>string</code> con el HTML necesario para presentar los campos del tabla. Es necesario asegurarse que como parte del envío se envía un parámetro con nombre <code$tablaId</code> (i.e. utilizado como valor del atributo name del botón de envío del tabla).
   */
  public function generaCamposTabla();
  
  /**
   * Función que genera el HTML necesario para el tabla.
   */
  public function generaTabla();
}
?>