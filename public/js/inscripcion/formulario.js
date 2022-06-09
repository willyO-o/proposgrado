$(function () {
	//assign json response to javascript variable
	let publicacion = null;
	$.get(`/oferta/detalleProgramaJson/id_publicacion,monto_matricula,precio_programa/${$('#id_publicacion').val()}`, function (r) {
		publicacion = r;
	});

	$('#form-carnet').on('submit', function (e) {
		e.preventDefault();
		$.get(
			`/inscripcion/buscarpersona/${$('#ci').val().replace(/\s/g, '')}`,
			function (data) {
				$('#h4-mensaje').html(data.mensaje);
				parametrosModal('modal', 'Verifique nuevamente su numero de Carnet', 'modal-md');
			},
			'json'
		);
		$('#h3-ci').html($('#ci').val().replace(/\s/g, ''));

		$('#button-confirmar-ci').prop('disabled', true);

		var spn = document.getElementById('small-contador-confirmar-ci');
		var btn = document.getElementById('button-confirmar-ci');

		var count = 5; // Set count

		//clear timer
		if (timer != null) clearInterval(timer);

		(function countDown() {
			// Display counter and start counting down
			if (count == 0) spn.textContent = ``;
			else spn.textContent = `(${count})`;

			// Run the function again every second if the count is not zero
			if (count !== 0) {
				timer = setTimeout(countDown, 1000);
				count--; // decrease the timer
			} else {
				// Enable the button
				btn.removeAttribute('disabled');
			}
		})();
	});
	$('#button-confirmar-ci').on('click', function () {
		window.location = `${window.origin}/inscripcion/${$('#id_publicacion').val()}/${$('#ci').val()}`;
	});

	$('#ciudad').select2();
	let tamanoTotalEnvio = 30;
	let cantidadMaximoArchivos = 3;
	let tamanoMaximoArchivo = 5;
	let extensionesValidas = ['.jpg', '.jpeg', '.png', '.JPG', '.JPEG', '.PNG'];
	let extensionesValidasString = extensionesValidas.join(', ');

	function verificarArchivo(archivo, tamanoMaximo, tipos) {
		extension = /[.]/.exec(archivo.name) ? /[^.]+$/.exec(archivo.name) : undefined;
		tamano = Math.round((archivo.size / 1000000) * 100) / 100;
		if (tipos.includes(`.${extension[0]}`)) {
			if (tamano <= tamanoMaximo) {
				return true;
			} else return `El archivo ${archivo.name} demasiado grande (${archivo.size}). Tamaño maximo: ${tamanoMaximo} MB.`;
		} else return `No puede cargar archivos de este tipo ${archivo.name}.`;
	}
	function crearComponente(idComponente, eliminarComponente, cantidadComponente, valores) {
		return `<div class="row ${cantidadComponente}" id="${idComponente}">
		
		<div class="col-11 col-xl-11">
			<div class="row col">
				<div class="form-group-1">
					<label for="${valores.tipoDeposito}">Tipo Deposito</label>
					<select class="form-select form-control" id="${valores.tipoDeposito}" name="${valores.tipoDeposito}" required>
						<option value="">Seleccione</option>
						<option value="1">PAGO POR MATRICULACION</option>
						<option value="2">PAGO POR COLEGIATURA</option>
					</select>
				</div>
			</div>
			<div class="row mt-2">
				<div class="col-12 col-xl-4">
					<div class="form-group-1">
						<label for="${valores.numeroDeposito}">Nro Deposito</label>
						<input class="p-0 form-control" id="${valores.numeroDeposito}" name="${valores.numeroDeposito}" type="text" minlength="15" required disabled>
					</div>
				</div>
				<div class="col-12 col-xl-5">
					<div class="form-group-1">
						<label for="${valores.fechaDeposito}">Fecha Deposito</label>
						<input class="p-0 form-control" id="${valores.fechaDeposito}" name="${valores.fechaDeposito}" value="${new Date().toISOString().substr(0, 10)}" type="date" required disabled>
					</div>
				</div>
				<div class="col-12 col-xl-3">
					<div class="form-group-1">
						<label for="${valores.montoDeposito}">Monto</label>
						<input class="p-0 form-control" id="${valores.montoDeposito}" name="${valores.montoDeposito}" type="text" required readonly>
					</div>
				</div>
			</div>
			<div class="row d-flex justify-content-center">
				<div class="col-sm-12 col-md-6 col-xl-6 border">
					<img class="w-100 img-fluid ${valores.clasePrevImagen}" src="${window.location.origin}/edugrids/assets/images/svg/upload-alt.svg" alt="Seleccione ${valores.nombreImagenAdjunto}" style="cursor:pointer" >
					<input class="form-control" type="file" id="${valores.nombreImagenAdjunto}" name="${valores.nombreImagenAdjunto}" accept="${extensionesValidasString}" disabled>
					<p class="text-dark fw-bold text-center">Seleccione imagen</p>
				</div>
			</div>
		</div>
		<div class="col-1 col-xl-1">
			<div class="col-sm-12 col-md-6 col-xl-2 text-center ${eliminarComponente} center" data-id-componente-eliminar="${idComponente}">
				<i class="lni lni-cross-circle btn text-danger"></i>
			</div>
		</div>
		<hr>
		<input id="${valores.tieneRespaldo}" name="${valores.tieneRespaldo}" type="hidden" value="false">
	</div>`;
	}
	function crearContenedorDeposito() {
		return `<div class="row mt-3">
		<h5>Datos del Depósito Bancario</h5>
		<div id="contenedor-deposito-matricula"></div>
	</div>
	<div class="row">
		<div class="button d-grid gap-2 d-md-flex justify-content-md-end">
			<button id="btn-agregar-deposito-matricula" class="btn p-1 pt-0 pb-0"> Agregar mas depositos</button>
		</div>
	</div>`;
	}
	$('[name="tiene_deposito"]').on('click', function () {
		if ($(this).val() == 'tiene-deposito') {
			$('#depositos').empty();
			$('#depositos').append(crearContenedorDeposito());
			$('#btn-agregar-deposito-matricula').on('click', function (e) {
				e.preventDefault();
				eliminarComponenteMatricula = 'eliminar-componente-matricula';
				cuantosComponentesMatricula = 'elemento-matricula';

				var j = (cantidadComponentes = contarComponentes(cuantosComponentesMatricula));
				desabilitarBoton('btn-agregar-deposito-matricula', cuantosComponentesMatricula);

				idElementoMatricula = `elemento-matricula-${j}`;
				$('#contenedor-deposito-matricula').append(crearComponente(idElementoMatricula, eliminarComponenteMatricula, cuantosComponentesMatricula, { numeroDeposito: 'numero_deposito_matricula[]', fechaDeposito: 'fecha_deposito_matricula[]', montoDeposito: 'monto_matricula[]', nombreImagenAdjunto: 'imagen_matricula[]', clasePrevImagen: 'prev_matricula', tipoDeposito: 'tipo_deposito_matricula[]', tieneRespaldo: 'tiene_respaldo[]' }));

				$('[name="imagen_matricula[]"]').on('change', function (e) {
					e.preventDefault();
					e.stopPropagation();
					e.stopImmediatePropagation();

					idPadre = $(this).closest('.elemento-matricula').attr('id');
					elementos = $(`#${idPadre} :input`);
					// console.log(elementos);

					archivo = e.target.files[0];
					if (typeof archivo !== 'undefined') {
						// alert('Click en file imagen matricula');
						respuesta = verificarArchivo(archivo, tamanoMaximoArchivo, extensionesValidas);
						if (respuesta === true) {
							$(elementos[5]).val(true);

							$(this).prev().attr('src', URL.createObjectURL(archivo));
							$(this).next().html(`${archivo.name}`);
							var image = new Image();
							image.src = URL.createObjectURL(archivo);
							var viewer = new Viewer(image, {
								toolbar: { zoomIn: 4, oneToOne: true, zoomOut: 4 },
								hidden: function () {
									viewer.destroy();
								},
							});

							viewer.show();
						} else {
							Swal.fire({ icon: 'error', title: 'INFORMACIÓN', text: respuesta });
							$(this).val('');
						}
					} else {
						$(this).prev().attr('src', `${window.location.origin}/edugrids/assets/images/svg/upload-alt.svg`);
						$(this).next().html(`Seleccione imagen`);
						$(elementos[5]).val(false);
					}
				});

				$('.prev_matricula').on('click', function (e) {
					e.preventDefault();
					e.stopPropagation();
					e.stopImmediatePropagation();
					// alert('Click en imagen matricula');
					$(this).next().click();
				});
				$('.eliminar-componente-matricula').one('click', function (e) {
					e.preventDefault();
					e.stopPropagation();
					e.stopImmediatePropagation();
					$(`#${$(this).data('id-componente-eliminar')}`).remove();
					defectoBoton('btn-agregar-deposito-matricula');

					console.log(new Date().getTime());
				});
				$('[name="tipo_deposito_matricula[]"]').on('change', function (e) {
					e.preventDefault();
					e.stopPropagation();
					e.stopImmediatePropagation();
					idPadre = $(this).closest('.elemento-matricula').attr('id');
					elementos = $(`#${idPadre} :input`);
					console.log(elementos);
					bloquearDesbloquearInputs(elementos, false, ['tiene_respaldo[]'], ['fecha_deposito_matricula[]', 'monto_matricula[]', 'tipo_deposito_matricula[]', 'tiene_respaldo[]']);
					if ($(this).val() == 1) {
						$(elementos[3]).val(publicacion.monto_matricula);
						$(elementos[3]).prop('readonly', true);
					} else if ($(this).val() == 2) {
						$(elementos[3]).prop('readonly', false);
						$(elementos[3]).val('');
						$(elementos[3]).inputmask('integer', { min: 1, max: publicacion.precio_programa });
					} else {
						bloquearDesbloquearInputs(elementos, true, ['tipo_deposito_matricula[]', 'monto_matricula[]', 'tiene_respaldo[]'], ['fecha_deposito_matricula[]', 'tipo_deposito_matricula[]', 'tiene_respaldo[]']);
					}
					$(elementos[1]).inputmask('9{1,15}');
				});
			});

			$('#btn-agregar-deposito-matricula').trigger('click');
		} else if ($(this).val() == 'no-tiene-deposito') {
			$('#depositos').empty();
		}
	});
	function bloquearDesbloquearInputs(elementos, estado, exceptoDesabilitar = [], exceptoVaciar = []) {
		elementos.each(function (index, element) {
			if (exceptoDesabilitar.indexOf($(element).attr('id')) == -1) {
				$(element).attr('disabled', estado);
			}
			if (exceptoVaciar.indexOf($(element).attr('id')) == -1) {
				$(element).val('');
			}
		});
	}
	// function verificarCantidadMatriculas(cantidadMatriculas) {
	// 	contarComponentes('elemento-matricula');
	// }

	function desabilitarBoton(idElemento, componentes) {
		if (contarComponentes(componentes) < cantidadMaximoArchivos) {
			$(`#${idElemento}`).attr('disabled', false);
		} else {
			$(`#${idElemento}`).attr('disabled', true);
			$(`#${idElemento}`).html(`Solo puede agregar ${cantidadMaximoArchivos} archivos`);
		}
	}
	function defectoBoton(idElemento) {
		$(`#${idElemento}`).attr('disabled', false);
		$(`#${idElemento}`).html('Agregar Depositos?');
	}

	function contarComponentes(componentes) {
		var j = 1;
		$(`.${componentes}`).each(function (i, obj) {
			j++;
		});
		return j;
	}
	function agregarInputMask(tipoPago) {
		$(`[name="numero_deposito_${tipoPago}[]"]`).inputmask('9{1,15}');
		$(`[name="monto_${tipoPago}[]"]`).inputmask('9{1,3}');
	}

	$('input:radio[name="tiene_deposito"]').filter(`[value="tiene-deposito"]`).trigger('click');

	var elementosHtmlEnvio = `
		<h6>Este proceso tardara de acuerdo a la velocidad de su internet</h6>
			<div class="progress">
                <div class="bar"></div>
                <div class="percent">0%</div>
            </div>
        <div id="status"></div>
	`;
	var bar = null;
	var percent = null;
	var status = null;

	var options = {
		beforeSend: function () {
			$('#modal-body').html(elementosHtmlEnvio);
			$('#modal').modal('hide');
			bar = $('.bar');
			percent = $('.percent');
			status = $('#status');
			parametrosModal('modal', 'Gracias por inscribirse, espere mientras enviamos sus datos');
			status.empty();
			var percentVal = '0%';
			bar.width(percentVal);
			percent.html(percentVal);
		},
		uploadProgress: function (event, position, total, percentComplete) {
			var percentVal = percentComplete + '%';
			bar.width(percentVal);
			percent.html(percentVal);
		},
		complete: function (xhr) {
			status.html(xhr.responseText);
		},
		success: function (r) {
			if (typeof r.exito !== 'undefined') {
				$('#modal').modal('hide');
				Swal.fire({
					icon: 'success',
					title: 'INFORMACIÓN',
					text: r.exito,
					confirmButtonText: `<div class="button"><button class="btn">Aceptar</button></div>`,
				}).then((result) => {
					window.location = `${window.origin}/inscripcion/mensajeFinalInscripcion/${r.idPersonaExterna}/${r.idPublicacion}`;
					// window.open(`${window.origin}/inscripcion/mensajeFinalInscripcion/${idPersonaExterna}/${$idPublicacion}`);
				});
				$('.swal2-confirm').removeClass();
				$('#form-inscribir').clearForm();
				$('#form-inscribir').removeClass('was-validated');
			} else if (typeof r.error) {
				$('#modal').modal('hide');
				Swal.fire({ title: 'INFORMACIÓN', icon: 'error', html: r.error, showCloseButton: true, focusConfirm: false });

				parametrosEnvio(true, 'icono-enviar-formulario');
				$('#porcentaje-enviar-formulario').html('');
			}
		},
		error: function () {
			parametrosEnvio(true, 'icono-enviar-formulario');
			$('#porcentaje-enviar-formulario').html('');
		},
	};
	$('#form-inscribir').on('submit', function (e) {
		e.preventDefault();
		var j = this;
		datosPersonales = $(`#datos-personales :input`);
		depositosBancarios = $(`.elemento-matricula`);
		parametrosModal('modal', 'Por favor verifica los datos a enviar en el siguiente detalle', 'modal-lg');
		$('#modal-body').html(``);
		if (datosPersonales.length > 0) {
			$('#modal-body').append('<h4 class="title pb-3">Datos Personales<h4>');
			datosPersonales.each(function (index, element) {
				$('#modal-body').append(etiquetaValor($('label[for=' + element.id + ']').html(), element.value));
			});
		}
		if (depositosBancarios.length > 0) {
			$('#modal-body').append('<h4 class="title pb-3 pt-3">Depositos Bancarios<h4>');
			depositosBancarios.each(function (i, obj) {
				$('#modal-body').append(`<h6 class="title">Deposito Nro ${i + 1}<h6>`);
				$(`#${obj.id} :input`).each(function (j, element) {
					etiqueta = $('label[for="' + element.id + '"]').html();
					valor = element.id == 'tipo_deposito_matricula[]' ? $(element).find(':selected').text() : element.value;
					if (typeof etiqueta != 'undefined' && typeof valor != 'undefined') $('#modal-body').append(etiquetaValor(etiqueta, valor, false));
				});
				$('#modal-body').append('<hr>');
			});
		}
		$('#modal-body').append(`
		<div class="row mt-3">
			<div class="col-4 col-xl-4 button">
				<button class="btn" type="button" data-bs-dismiss="modal">Dejame revisar</button>
			</div>
			<div class="col-8 col-xl-8 d-grid gap-2 d-md-flex justify-content-md-end">
				<div class="button">
					<button class="btn" id="btn-enviar-formulario-inscripcion"><i class="lni lni-arrow-right-circle" id="icono-enviar-formulario"></i> ¡He revisado!, deseo enviar <small id="porcentaje-enviar-formulario"></small> </button>
				</div>
			</div>
		</div>
		`);
		$('#btn-enviar-formulario-inscripcion').on('click', function (e) {
			$(j).ajaxSubmit(options);
		});
	});

	$('#btn-revisar-formulario-inscripcion').on('click', function (e) {
		$('#form-inscribir').addClass('was-validated');
	});

	Inputmask.extendDefaults({ placeholder: '' });
	Inputmask.extendDefinitions({
		// A: {
		// 	validator: '[A-Z0-9 ]',
		// 	cardinality: 1,
		// },
	});
	var timer = null; // For referencing the timer
	$('#ci').inputmask('[9{7,9}][-*{1,2}]');
	$('#ci').on('keyup', function () {
		if ($(this).val().length < 7) $('#enviar-formulario-carnet').attr('disabled', true);
		else $('#enviar-formulario-carnet').attr('disabled', false);
	});

	$('#paterno').inputmask('A{1,20} A{1,20} A{1,20}');
	$('#materno').inputmask('A{1,20} A{1,20} A{1,20}');
	$('#nombre').inputmask('A{1,20} A{1,20} A{1,20}');
	$('#oficio_trabajo').inputmask('A{1,30} A{1,30} A{1,30}');
	$('#celular').inputmask('9{8,8}');
	$('#domicilio').attr('maxlength', '100');

	// $('#correo').inputmask({
	// 	mask: '*{1,20}[.*{1,20}][.*{1,20}][.*{1,20}]@*{1,20}[.*{2,6}][.*{1,2}]',
	// 	greedy: false,
	// 	onBeforePaste: function (pastedValue, opts) {
	// 		pastedValue = pastedValue.toLowerCase();
	// 		return pastedValue.replace('mailto:', '');
	// 	},
	// 	definitions: {
	// 		'*': {
	// 			validator: "[0-9A-Za-z!#$%&'*+/=?^_`{|}~-]",
	// 			casing: 'lower',
	// 		},
	// 	},
	// });
	const parametrosEnvio = (activarDesactivar, iconoEnviarFormulario) => {
		e = $(`#${iconoEnviarFormulario}`);
		e.removeClass();
		if (activarDesactivar) {
			e.addClass('lni lni-arrow-right-circle');
			e.parent().attr('disabled', false);
		} else {
			e.addClass('lni lni-reload');
			e.parent().attr('disabled', true);
		}
	};
	function etiquetaValor(etiqueta, valor, separador = true) {
		return `<div class="row">
					<div class="col-sm-12 col-md-6">
						<strong><label>${etiqueta}</label></strong>
					</div>
					<div class="col-sm-12 col-md-6">
						<label>${valor}</label>
					</div>
					${separador == true ? '<hr>' : ''}
				</div>`;
	}
});
