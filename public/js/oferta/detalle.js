$.expander.defaults.slicePoint = 120;
document.addEventListener('DOMContentLoaded', function () {
	$('.informacion-programa').on('click', function (e) {
		e.preventDefault();
		parametrosModal('modal', 'FORMULARIO DE SOLICITUD DE INFORMACIÓN');
	});
	
});
