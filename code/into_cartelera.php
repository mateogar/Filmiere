<?php
require_once __DIR__.'/includes/config.php';

?>	
<div class="estilo_bloque_grande">
    <?php $peliculas = new \es\ucm\fdi\aw\PeliculasOps(); $peliculas->generaCartelera();?>
</div>