<?php

require_once __DIR__.'/includes/config.php';

?>
<!DOCTYPE html>

<html>
	<head>
		<title>Perfil</title>
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="<?= $app->resuelve('/css/general.css') ?>">
		<link rel="icon" type="image/x-icon" href="img/logotipo.png" />
		<style>
			#div_term{
				margin: 2%;
			}
		</style>
	</head>
	
	<body>
		<div class="contenedor">
			<?php
				include 'cabecera.php';
			?>
			<div class="estilo_bloque">
			<h2>Términos y condiciones de Filmière</h2>
				
				
				<p>El Usuario es consciente y acepta, voluntaria y expresamente, que el uso de la Web y/o de la
						Aplicación se realiza, en todo caso, bajo su única y exclusiva responsabilidad.</p>
				<p>En la utilización del Web y/o de la Aplicación, el Usuario se compromete a no llevar a cabo
					ninguna conducta que pudiera (i) violar la ley y/o las Condiciones Generales, las Condiciones
					de Uso para Compra o las Condiciones Particulares; (ii) dañar la imagen, los intereses y los
					derechos de FILMIÈRE o de terceros; o (iii) dañar, inutilizar o sobrecargar el Web y/o la
					Aplicación, o que impidiera o alterara, de cualquier forma, la normal utilización del Web y/o de
					la Aplicación. En particular, el Usuario se compromete expresamente a (i) no destruir, alterar,
					inutilizar o, de cualquier otra forma, dañar los datos, programas o documentos electrónicos y
					demás que se encuentren en el Web y/o en la Aplicación; y (ii) no introducir programas, virus,
					macros, controles o cualquier otro dispositivo lógico o secuencia de caracteres que causen, o
					sean susceptibles de causar, cualquier tipo de alteración en los sistemas informáticos del Web,
					de la Aplicación o de terceros</p>
					<p>FILMIÈRE adopta medidas de seguridad razonablemente adecuadas para detectar la existencia de
					virus. No obstante, el Usuario debe ser consciente de que las medidas de seguridad de los
					sistemas informáticos en Internet no son inexpugnables y que, por tanto, FILMIÈRE no puede
					garantizar la inexistencia de virus, software malicioso, gusanos, ataques de ingeniería social de
					terceros (phising, pharming, troyanos, etc.) u otros elementos que puedan producir alteraciones
					en los sistemas informáticos (software y hardware) del Usuario o en sus documentos
					electrónicos y ficheros contenidos en los mismos.
					Se prohíbe el acceso al Web y/o la Aplicación por medio de sistemas mecanizados que sean
					distintos a personas físicas, ya que éstos ocasionan daños a FILMIÈRE al no poder medir con
					objetividad las audiencias.
					FILMIÈRE excluye toda responsabilidad que se pudiera derivar por causas ajenas a FILMIÈRE de
					(i) interferencias, omisiones, interrupciones, virus informáticos, averías telefónicas o
					desconexiones en el funcionamiento operativo del sistema electrónico; o (ii) retrasos o bloqueos
					en el funcionamiento operativo del sistema electrónico causado por deficiencias o sobrecarga en
					las líneas telefónicas o en Internet, así como daños causados por terceros.
					FILMIÈRE está facultada para suspender temporalmente, y sin previo aviso, el acceso al Web y/o
					la Aplicación con motivo de operaciones de mantenimiento, reparación, actualización o mejora. </p>
			</div>
			
			<?php
				include 'footer.php';
			?>
		</div>
	</body>
</html>