function getHorario(seleccionado){
	alert("Hola");
}

$(document).ready(function(){
	$("#dia").change(function(){
		$seleccionado = document.getElementById('dia').value;
		getHorario($seleccionado);
	});
});