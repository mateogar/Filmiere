<?php
namespace es\ucm\fdi\aw;
require_once __DIR__.'/includes/config.php';

?>
<!DOCTYPE html>
<html>
	<head>
	    <meta charset="utf-8" />
		<link rel="stylesheet" type="text/css" href="<?= $app->resuelve('/css/general.css') ?>">
		<link rel="icon" type="image/x-icon" href="img/logotipo.png" />
		<script type="text/javascript" src="<?= $app->resuelve('/js/jquery-2.2.4.min.js') ?>"></script>
	    <title>Butacas</title>
		<script>
			var butacas = [];
			var total = null;
			function get(name)
			{
			   if(name = (new RegExp('[?&]' + encodeURIComponent(name) + '=([^&]*)')).exec(location.search))
				  return decodeURIComponent(name[1]);
			}
			
			$(document).ready(function()
			{
				var situacionB = [];
				total = document.getElementById("precioTotal");
				var c = 0;
				
				
				$idHorario = get('date');
				$.get("includes/mostrarDatosButacas.php?date=" + $idHorario, mostrarDatos);
				$("#datos_compra").hide();
				$("#div_codigo_promo").hide();
				//$("#div_selector_cantidad_butacas").hide();
				//$("#seleccion_descuento").hide();
				
				function mostrarDatos(data, status)
				{
					document.getElementById("datos_butacas").innerHTML = data;
				}
				
				$("#tramitar").click(function(){
					tramitarCompra("", "sin_descuento");
				});
				
				$("#button_input_codp").click(function()
				{
					tramitarCompra(document.getElementById("input_codp").value, "cod_promo");
				});
				
				function tramitarCompra(codigoPromo, tipoDescuento){
					if(butacas.length > 0)
					{
						$.get("tramitarCompra.php?date="+$idHorario+"&butacas="+butacas+"&codigopromo="+codigoPromo+"&tipodescuento="+tipoDescuento, mostrarDatosButacas);
						$("#leyenda").hide();
						$("#salaButacas").hide();
						$("#datos_compra").show();
					}
				}
				
				function mostrarDatosButacas(data, status)
				{
					document.getElementById("datos_entradas").innerHTML = data;
				}
				
				$("#btn_ComprarEntradas").click(function()
				{
					if(butacas.length > 0)
					{
						var tipoDescuento = document.getElementById("selector_descuento").value;
						
						$.get("validarDescuento.php?tipodescuento="+tipoDescuento, realizarCompra);
					}
				});
				
				function realizarCompra(data, status)
				{
					//var nButacas = document.getElementById("selector_cantidad_butacas").value;
					if(data == "true")
					{
						var tipoDescuento = document.getElementById("selector_descuento").value;
						
						if(tipoDescuento != "sin_descuento")
						{
							if(tipoDescuento == "cod_promo")
							{
								var cP = document.getElementById("input_codp").value;
								
								$.get("realizarCompra.php?date="+$idHorario+"&butacas="+butacas+"&codigopromo="+cP+"&tipodescuento="+tipoDescuento, finalizarCompra);
							}
							else
							{
								var cP = "";
								
								if((tipoDescuento == "packmayor5" && butacas.length > 5) || (tipoDescuento == "pack4o5" && (butacas.length == 4 || butacas.length == 5)))
									$.get("realizarCompra.php?date="+$idHorario+"&butacas="+butacas+"&codigopromo="+cP+"&tipodescuento="+tipoDescuento, finalizarCompra);
								else
									alert("Seleccione un tipo de descuento válido.");
							}
						}
						else
						{
							var cP = "";
							
							$.get("realizarCompra.php?date="+$idHorario+"&butacas="+butacas+"&codigopromo="+cP+"&tipodescuento="+tipoDescuento, finalizarCompra);
						}
					}
					else
						alert("Regístrese o inicie sesión en Filmière para aplicar descuentos a sus compras.");
				}
				
				function finalizarCompra(data, status)
				{
					$("#datos_compra").hide();
					document.getElementById("datos_butacas").innerHTML = data;
				}
				
				$(".img_butaca").click(function(){
					var estaSeleccionado = $.inArray($(this).attr('value'), butacas) > -1;
					if(estaSeleccionado){
						var valor = $(this).attr('value');
						var source;
						for(i in situacionB){
							var situacion = situacionB[i];
							
							if(situacion.value == valor){
								source = situacion.src;
							}
						}
						$(this).attr('src',source);
						var i = butacas.indexOf($(this).attr('value'));
						butacas.splice(i,1);
					}else{
						var situacion = new Object();
						situacion.value = $(this).attr('value');
						situacion.src = $(this).attr('src');
						situacionB.push(situacion);
						$(this).attr('src','img/seleccionado.png');
						butacas.push($(this).attr('value'));
					}
				});
				
				/*function generarSelectorCantidadEntradas()
				{
					var html = '';
					
					for(var i = 0; i <= butacas.length; i++)
						html += '<option value="' + i +'">' + i + '</option>';
					
					document.getElementById("selector_cantidad_butacas").innerHTML = html;
				}*/
				
				$("#selector_descuento").change(function()
				{
					var tipoDescuento = document.getElementById("selector_descuento").value;
					
					//$("#div_selector_cantidad_butacas").hide();
					$("#div_mensaje_info").hide();
					
					if(tipoDescuento == "sin_descuento")
					{
						$("#div_codigo_promo").hide();
						tramitarCompra("", "sin_descuento");
					}
					else
						if(tipoDescuento == "cod_promo")
						{
							tramitarCompra("", "sin_descuento");
							$("#div_codigo_promo").show();
						}
						else
						{
							$("#div_codigo_promo").hide();

							if(tipoDescuento == "packmayor5")
							{
								if(butacas.length > 5)
									tramitarCompra("", "packmayor5");
								else
								{
									tramitarCompra("", "sin_descuento");
									$("#div_mensaje_info").show();
									document.getElementById("div_mensaje_info").innerHTML = "<p class='negrita'>Este tipo de descuento no es aplicable para menos de 6 entradas.</p>";
								}
							}
							else
								if(tipoDescuento == "pack4o5")
								{
									if(butacas.length == 4 || butacas.length == 5)
										tramitarCompra("", "pack4o5");
									else
									{
										tramitarCompra("", "sin_descuento");
										$("#div_mensaje_info").show();
										document.getElementById("div_mensaje_info").innerHTML = "<p class='negrita'>Este tipo de descuento es aplicable a 4 ó 5 entradas únicamente.</p>";
									}
								}
						}
				});
				
				/*$("#selector_cantidad_butacas").change(function()
				{
					var nButacas = document.getElementById("selector_cantidad_butacas").value;
					var tipoDescuento = document.getElementById("selector_descuento").value;
					
					tramitarCompra("", tipoDescuento, nButacas);
				});*/
			});
		</script>
	</head>
	<body>
		<div class="contenedor">
	   		<?php include 'cabecera.php'; ?>
			
			<div class="estilo_bloque" id="datos_butacas">
			</div>

			<div class="estilo_centrado estilo_bloque" id="salaButacas">
				<?php ButacasOps::generaButacas($_REQUEST['date']); ?>
			</div>

			<div class="estilo_bloque estilo_centrado" id="leyenda">
				<ul id="leyenda_butacas">
					<li>Libre <div class="c_imagen_butacas"><img src="img/butaca.png" class="imagenButaca"/></div></li>
					<li>Seleccionada <div class="c_imagen_butacas"><img src="img/seleccionado.png" class="imagenButaca"/></div></li>
					<li>Ocupada <div class="c_imagen_butacas"><img src="img/ocupado.png" class="imagenButaca"/></div></li>
					<li>Minusválido <div class="c_imagen_butacas"><img src="img/minus.png" class="imagenButaca"/></div></li>
					<li>VIP <div class="c_imagen_butacas"><img src="img/especial.png" class="imagenButaca"/></div></li>
				</ul>
				
				<input class="button_input" type="button"  value="Tramitar Compra" id="tramitar"/>
			</div>
			
			<div class="estilo_bloque estilo_centrado" id="datos_compra">
				<h2>Datos de la compra</h2>
				
				<table class="estilo_centrado tablasEnGeneral" id="datos_entradas">
				</table>
				
				<div>
					<p>Seleccione su tipo de descuento
						<select class="descuento" id="selector_descuento">
							<option value="sin_descuento">Sin Descuento</option>
							<option value="pack4o5">Pack de 4 o 5</option>
							<option value="packmayor5">Pack grupo > 5</option>
							<!--<option value="+65">+65 años</option>
							<option value="carnetuni">Carnet Universitario</option>
							<option value="menor10">&lt 10 años</option>-->
							<option value="cod_promo">Código Promocional</option>
						</select>
				</div>
				
				<!--<div id="div_selector_cantidad_butacas">
					<p>Aplicar a <select id="selector_cantidad_butacas">
					</select> entradas</p>
				</div>-->
				
				<div id="div_mensaje_info">
				</div>
				
				<div id="div_codigo_promo">
					<p>Código promocional <input type="text" id="input_codp"/> <button id="button_input_codp">Aplicar</button></p>
				</div>
				
				<div class="negrita" id="texto_datos_compra">*Será imprescindible presentar algún documento que verifique la pertenencia
					al descuento seleccionado, salvo para los códigos promocionales.
				</div>
					
				<input class="button_input" type="button" value="Comprar" id="btn_ComprarEntradas"/>
			</div>
			
			<?php include 'footer.php'; ?>
		</div>
		
	</body>
</html>