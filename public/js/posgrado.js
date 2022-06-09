document.addEventListener('DOMContentLoaded', function () {
	window.parametrosModal = function (idModal, titulo, tamano = 'modal-lg', keyboard = true, backdrop = 'static', focus = true) {
		$(`#${idModal}-title`).html(titulo);
		$(`#${idModal}-dialog`).addClass(tamano);
		$(`#${idModal}-dialog`).addClass('modal-dialog');
		var modal = new bootstrap.Modal(document.getElementById(idModal), {
			keyboard: keyboard,
			backdrop: backdrop,
			focus: focus,
		}).show();
	};
});
