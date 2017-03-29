<?php

require_once __DIR__.'/includes/config.php';

?>
<?php
function logout() {
	$app = \es\ucm\fdi\aw\Aplicacion::getSingleton();
	$app->logout();
	header('Location: index.php');
}

logout();

?>