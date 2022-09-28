$.expander.defaults.slicePoint = 120;
document.addEventListener("DOMContentLoaded", function() {




            $(".informacion-programa").on("click", function(e) {
                e.preventDefault();
                parametrosModal("modal", "Formulario de solicitud de información");
                $("#detalle-programa").html($(this).data("detalle"));
                $("#id_publicacion").val($(this).data("id-publicacion"));
            });
            $("#suscribirse").on("click", function(e) {
                e.preventDefault();
                parametrosModal("suscripcion-area", "Formulario de suscripción a un Area");
            });

            $("div.expandable h5").expander({
                slicePoint: 35, // default is 100
                expandPrefix: '<small class="small fw-lighter fs-6 text-info">...</small>', // default is '... '
                expandText: '<small class="small fw-lighter fs-6 text-info">leer mas</small>', // default is 'read more'
                collapseTimer: 5000, // re-collapses after 5 seconds; default is 0, so no re-collapsing
                userCollapseText: '<small class="small fw-lighter fs-6 text-info">ocultar</small>', // default is 'read less'
            });
            Inputmask.extendDefaults({ placeholder: "" });
            $("#ci").inputmask("[9{6,9}][-*{1,2}]");
            //
            // Inputmask.extendDefinitions({
            // 	A: {
            // 		validator: '[A-Z0-9 ]',
            // 		cardinality: 1,
            // 	},
            // });

            $("#paterno").inputmask("A{1,20} A{1,20} A{1,20}");
            $("#materno").inputmask("A{1,20} A{1,20} A{1,20}");
            $("#nombre").inputmask("A{1,20} A{1,20} A{1,20}");
            $("#celular").inputmask("9{8,8}");

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
            $("#btn-enviar-informacion-programa").on("click", function(e) {
                $("#form-informacion-programa").addClass("was-validated");
            });
            $("#btn-enviar-informacion-suscripcion-area").on("click", function(e) {
                $("#form-suscripcion-area").addClass("was-validated");
            });



            $("#form-informacion-programa").ajaxForm({
                // data: new FormData($(this)[0]),
                beforeSend: function() {
                    parametrosEnvio(false, "icono-enviar-formulario");
                },
                uploadProgress: function(event, position, total, percentComplete) {
                    $("#porcentaje-enviar-formulario").html(`${percentComplete}%`);
                },
                complete: function(r) {},
                success: function(r) {
                    if (r.exito) {
                        // Swal.fire({ icon: "success", title: "INFORMACIÓN", text: r.mensaje || "Solicitud Registrada, " });
                        const swalWithBootstrapButtons = Swal.mixin({
                            customClass: {
                                confirmButton: 'btn btn-success',
                                cancelButton: 'btn btn-danger'
                            },
                            buttonsStyling: false
                        })

                        if (r.programa != null) {

                            swalWithBootstrapButtons.fire({
                                title: 'Listo...',
                                html: r.mensaje || 'Registrado Exitosamente...',
                                icon: 'success',
                                showCancelButton: true,
                                confirmButtonText: '<i class="lni lni-whatsapp"></i> Contactar al coordinador',
                                confirmButtonColor: "#01ac00",
                                cancelButtonText: 'Cerrar',
                                reverseButtons: true
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    let mensaje_wp = `https://api.whatsapp.com/send?phone=+591${r.programa.celular_coordinador}&text=Hola, necesito mas información sobre ${r.solicitud.tipo_informacion_solicitada} ${r.solicitud.otra_informacion ? " y " + r.solicitud.otra_informacion : ""} del Programa ${r.programa.grado_academico} EN ${r.programa.nombre_programa}, MODALIDAD ${r.programa.modalidad}, VERSIÓN ${r.programa.numero_version}. https://posgrado.upea.bo/programa/${r.programa.id_publicacion}`;


                                    var win = window.open(
                                        mensaje_wp,
                                        "_blank"
                                    );

                                    win.focus();
                                } else if (result.dismiss === Swal.DismissReason.cancel) {

                                }
                            })
                        } else {
                            Swal.fire({
                                title: 'Listo...',
                                html: r.mensaje || 'Registrado Exitosamente...',
                                icon: 'success',
                            });
                        }
                        $("#modal").modal("hide");
                        $("#ciudad").val(null).trigger("change");;
                        $("#form-informacion-programa").clearForm();
                        $("#form-informacion-programa").removeClass("was-validated");
                        parametrosEnvio(true, "icono-enviar-formulario");
                        generar_captcha();

                    } else {

                        let mensaje = "";
                        if (r.error) {

                            let valores = Object.values(r.error); // valores = ["Scott", "Negro", true, 5];
                            for (let i = 0; i < valores.length; i++) {
                                mensaje += "<p>" + valores[i] + "</p> ";
                            }
                        } else {
                            mensaje = r.mensaje
                        }

                        Swal.fire({
                            title: 'INFORMACIÓN',
                            icon: 'Error',
                            html: mensaje || "No se pudo procesar su solicitud, por favor verifique sus datos e intente nuevamente.",
                            showCloseButton: true,
                            focusConfirm: false,
                        });

                        parametrosEnvio(true, 'icono-enviar-formulario');
                        $('#porcentaje-enviar-formulario').html('');
                    }

                    if (r.captcha == false) {
                        generar_captcha();
                    }
                },
                error: function() {
                    parametrosEnvio(true, "icono-enviar-formulario");
                    $("#porcentaje-enviar-formulario").html("");
                },
            });





            $("#form-suscripcion-area").ajaxForm({
                // data: new FormData($(this)[0]),
                beforeSend: function() {
                    parametrosEnvio(false, "icono-enviar-formulario-suscripcion-area");
                },
                uploadProgress: function(event, position, total, percentComplete) {
                    $("#porcentaje-enviar-formulario-area").html(`${percentComplete}%`);
                },
                complete: function(r) {},
                success: function(r) {
                    if (typeof r.exito !== "undefined") {
                        Swal.fire({ icon: "success", title: "INFORMACIÓN", text: r.exito });
                        $("#suscripcion-area").modal("hide");
                        $("#form-suscripcion-area").clearForm();
                        $("#form-suscripcion-area").removeClass("was-validated");
                        parametrosEnvio(true, "icono-enviar-formulario-suscripcion-area");
                    } else if (typeof r.error) {
                        Swal.fire({
                            title: "INFORMACIÓN",
                            icon: "error",
                            html: r.error,
                            showCloseButton: true,
                            focusConfirm: false,
                        });

                        parametrosEnvio(true, "icono-enviar-formulario-suscripcion-area");
                        $("#porcentaje-enviar-formulario-area").html("");
                    }
                },
                error: function() {
                    parametrosEnvio(true, "icono-enviar-formulario-suscripcion-area");
                    $("#porcentaje-enviar-formulario-area").html("");
                },
            });

            const parametrosEnvio = (activarDesactivar, iconoEnviarFormulario) => {
                e = $(`#${iconoEnviarFormulario}`);
                e.removeClass();
                if (activarDesactivar) {
                    e.addClass("lni lni-arrow-right-circle");
                    e.parent().attr("disabled", false);
                } else {
                    e.addClass("lni lni-reload");
                    e.parent().attr("disabled", true);
                }
            };

            // modal suscripción area
            $(".sucripcion_area").on("click", function(e) {
                e.preventDefault();
                parametrosModal(
                    "modal",
                    "Formulario de solicitud de información de una área"
                );
            });

            var words = [];
            let eliminado = [];

            // $('#id_area').on('change', function (e) {
            // 	let id = $(this).val();
            // 	eliminado = [];
            // 	$.ajax({
            // 		type: 'POST',
            // 		url: '/oferta/verificar_etiqueta',
            // 		data: { id, todos: 'no' },
            // 	}).done(function (data) {
            // 		// console.log(data);
            // 		words = JSON.parse(JSON.stringify(data));
            // 		$('#demo').jQCloud('update', words);
            // 	});

            // 	console.log($(this).val());
            // });
            $(".enviar-whatsapp").on("click", function() {
                $.get(
                    `/oferta/detalleProgramaJson/id_publicacion,nombre_programa,descripcion_whatsapp,celular_coordinador,grado_academico,nombre_programa,numero_version,id_publicacion,modalidad/${$(
        "#id_publicacion"
      ).val()}`,
                    function(r) {
                        window.open(
                            `https://api.whatsapp.com/send?phone=+591${r.celular_coordinador}&text=Hola, necesito mas información del Programa ${r.grado_academico} EN ${r.nombre_programa}, MODALIDAD ${r.modalidad}, VERSIÓN ${r.numero_version}. https://posgrado.upea.bo/programa/${r.id_publicacion}`,
                            "_blank"
                        );
                    }
                ).fail(function(xhr, textStatus, errorThrown) {
                    Swal.fire({
                        icon: "error",
                        title: "ERROR",
                        text: "No se pudo enviar el mensaje",
                    });
                });
                // if (/^\d{8}$/.test($('#celular').val()) && /^\d+$/.test($('#id_publicacion').val())) {
                // 	$.get(`/oferta/detalleProgramaJson/id_publicacion,nombre_programa,descripcion_whatsapp/${$('#id_publicacion').val()}`, function (r) {
                // 		window.open(`https://api.whatsapp.com/send?phone=+591${$('#celular').val()}&text=${r.descripcion_whatsapp}`, '_blank');
                // 	}).fail(function (xhr, textStatus, errorThrown) {
                // 		Swal.fire({ icon: 'error', title: 'ERROR', text: 'No se pudo enviar el mensaje' });
                // 	});
                // } else Swal.fire({ icon: 'error', title: 'INFORMACIÓN', text: 'El celular no es válido' });
            });
            $("#enviar-whatsapp-area").on("click", function() {
                        if (/^\d{8}$/.test($("#celular-area").val())) {
                            window.open(
                                    `https://api.whatsapp.com/send?phone=+591${$(
          "#celular-area"
        ).val()}&text=${encodeURI(`
			Sea usted bienvenid@ a *POSGRADO UPEA*
			Para seguir nuestra amplia oferta académica de 
			DIPLOMADOS, ESPECIALIDADES, MAESTRIAS, DOCTORADOS Y POST DOCTORADOS visítenos en *https://posgrado.upea.bo*
			
			🌐 Dirección de la Oficina 🗺️
			Ciudad de El Alto, Av. Juan Pablo II, Edificio emblemático 🏢, piso 3, oficina 2, ventanilla 4 (INFORMACIONES E INSCRIPCIONES)
			Ingreso: 
			Atención Lunes, miércoles y viernes de 8:30 a 13:00.
			🏢 *POSGRADO UPEA* 🏢
			==========================
			PROGRAMAS DE POSGRADO A NIVEL NACIONAL 🇧🇴
			`)}`,
        "_blank"
      );
    } else {
      Swal.fire({
        icon: "error",
        title: "INFORMACIÓN",
        text: "El celular no es válido",
      });
    }
  });

  let cadena = [];

  let tagify;
  tagify = new Tagify(document.getElementById("etiquetas"), {
    callbacks: {
      remove: (e) => console.log(e.detail.data.value),
    },
  });

  $("#demo").on("click", ".jqcloud-word", function (e) {
    e.stopPropagation();
    e.stopImmediatePropagation();

    var word_value = $(this)[0].outerText;

    words.map(function (data, index) {
      if (word_value == data.text) {
        cadena.push(data.text);
        eliminado.push(data);
        words.splice(index, 1);
      }
      $("#etiquetas").val($("#etiquetas").val() + cadena);
      // var input = document.querySelector('input[name=etiquetas]'),

      // tagify.addTags(cadena)
      // // tagify.destroy();
    });
    console.log(cadena);
    // tagify.removeTags();
    tagify.addTags(cadena);
    $("#demo").jQCloud("update", words);
  });

  $("#etiquetas").on("change", function (e) {
    // console.log($(this).val())
  });

  $(".tengoCorreoElectronico").on("click", function () {
    $(".rowCorreo").html(`<div class="col-12 col-sm-12 col-md-12 col-lg-12">
			<div class="form-group-1">
				<label for="correo">Correo</label>
				<input class="form-control text-lowercase" id="correo" name="correo" type="text" onkeyup="this.value = this.value.toLowerCase();" required>
			</div>
		</div>`);
    $(".tengoCorreoElectronico").addClass("d-none");
    $(".noTengoCorreoElectronico").removeClass("d-none");
  });

  $(".noTengoCorreoElectronico").on("click", function () {
    $(this).addClass("d-none");
    $(".rowCorreo").children().remove();
    $(".tengoCorreoElectronico").removeClass("d-none");
  });

  var checkboxes = $(".checkboxes");
  checkboxes.change(function () {
    if ($(".checkboxes:checked").length > 0) {
      checkboxes.removeAttr("required");
    } else {
      checkboxes.attr("required", "required");
    }
  });

  $("#marcarTodo").on("change", function () {
    let checkboxes = $(".checkboxes");
    if ($(this).is(":checked")) {
      checkboxes.prop("checked", true);
    } else {
      checkboxes.prop("checked", false);
      checkboxes.attr("required", "required");
    }
  });

  $("#ciudad").select2({
    dropdownParent: $("#modal #modal-body")
  });


  generar_captcha();

  function generar_captcha() {
    $.post("/informacion/informacion_generar_captcha", {})
      .done(function (response) {

        $("#codigo_captcha").attr("value", response.captcha.codigo);
        $("#img_captcha").attr("src", response.captcha.ruta);
        $("#input_captcha").val("");
      });
  }

  $("#form-informacion-programa #celular").on("input", function () {
    if ($(this).val().length > 8) {
      $(this).val($(this).val().slice(0, 8))
    }
  });

});




var datos = null;

$.getJSON("/oferta/programasAjax", {},
  function (data) {
    // console.log(data);
    datos = data.programas;
    // console.log(datos);

  }
);


$("#filtro-area").change(function () {
  let area = $(this).val();

  filtrar_datos($("#buscar-programa").val(), area, $("#filtro-modalidad").val());

});

$("#filtro-modalidad").change(function () {
  let modalidad = $(this).val();
  filtrar_datos($("#buscar-programa").val(), $("#filtro-area").val(), modalidad);
});


$("#buscar-programa").on("input", function () {

  let buscar = $(this).val();
  filtrar_datos(buscar, $("#filtro-area").val(), $("#filtro-modalidad").val());

});


function filtrar_datos(texto_buscar, area, modalidad = null) {

  if (datos) {
    $("#contenedor-programas").show()
    $("#no-encontrado").hide();

    $(".cartas-psg").hide();

    texto_buscar = texto_buscar.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, "");
    modalidad = modalidad.toLowerCase();




    if (area != "0" && modalidad != "0") {
      let filtrado = datos.filter((item) => {
        return item.nombre_programa_completo.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, "").indexOf(texto_buscar) > -1;
      }).filter((item) => {
        return item.area_especialidad.indexOf(area) > -1;
      }).filter((item) => {
        return item.modalidad.toLowerCase().indexOf(modalidad) > -1;
      }).forEach((item) => {
        let carta = $(`.cartas-psg[data-id='${item.id_publicacion}']`)

        carta.find(".wow").css({ "visibility": "visible", "animation-delay": "0.2s", "animation-name": "fadeInUp" });
        carta.show();

      });

    } else if (area != "0" && modalidad == "0") {
      let filtrado = datos.filter((item) => {
        return item.nombre_programa_completo.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, "").indexOf(texto_buscar) > -1;
      }).filter((item) => {
        return item.area_especialidad.indexOf(area) > -1;
      }).forEach((item) => {
        let carta = $(`.cartas-psg[data-id='${item.id_publicacion}']`)

        carta.find(".wow").css({ "visibility": "visible", "animation-delay": "0.2s", "animation-name": "fadeInUp" });
        carta.show();

      });
    } else if (area == "0" && modalidad != "0") {

      let filtrado = datos.filter((item) => {
        return item.nombre_programa_completo.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, "").indexOf(texto_buscar) > -1;
      }).filter((item) => {
        return item.modalidad.toLowerCase().indexOf(modalidad) > -1;
      }).forEach((item) => {
        let carta = $(`.cartas-psg[data-id='${item.id_publicacion}']`)

        carta.find(".wow").css({ "visibility": "visible", "animation-delay": "0.2s", "animation-name": "fadeInUp" });
        carta.show();

      });

    } else {
      let filtrado = datos.filter((item) => {
        return item.nombre_programa_completo.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, "").indexOf(texto_buscar) > -1;
      }).forEach((item) => {
        let carta = $(`.cartas-psg[data-id='${item.id_publicacion}']`)

        carta.find(".wow").css({ "visibility": "visible", "animation-delay": "0.2s", "animation-name": "fadeInUp" });
        carta.show();

      });
    }

    if ($(".cartas-psg:visible").length == 0) {
      $("#contenedor-programas").hide()
      $("#no-encontrado").show();

    }
  }



}


$("#mostrar-filtros").click(function () {
  $("#caja-filtros").slideToggle();


  $("#filtro-area").val("0").trigger("change");
  $("#filtro-modalidad").val("0").trigger("change");


  $(this).find("i").toggleClass("lni lni-chevron-down lni lni-chevron-up");


  // $(this).find("b").text($(this).find("b").text() == "Mostrar filtros" ? "Ocultar filtros" : "Mostrar filtros");

});