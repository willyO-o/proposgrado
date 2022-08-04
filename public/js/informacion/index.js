$(function() {
    $("#ciudad").select2();

    generar_captcha();




    $("#form-informacion").submit(function(e) {
        $("#form-informacion").addClass("was-validated");

        e.preventDefault();

        let datos = $(this).serializeArray();
        // console.log($(".checkboxes").val());
        // $(".checkboxes:checkbox:checked").each(function() {
        //     console.log($(this).val());
        // });
        $.post("/informacion/informacion_registrar_solicitud", datos)
            .done(function(res) {

                if (res.captcha == true) {

                    const swalWithBootstrapButtons = Swal.mixin({
                        customClass: {
                            confirmButton: 'btn btn-success',
                            cancelButton: 'btn btn-danger'
                        },
                        buttonsStyling: false
                    })

                    if (res.programa != null) {

                        swalWithBootstrapButtons.fire({
                            title: 'Listo...',
                            html: res.mensaje || 'Registrado Exitosamente...',
                            icon: 'success',
                            showCancelButton: true,
                            confirmButtonText: '<i class="lni lni-whatsapp"></i> Contactar al coordinador',
                            confirmButtonColor: "#01ac00",
                            cancelButtonText: 'Cerrar',
                            reverseButtons: true
                        }).then((result) => {
                            if (result.isConfirmed) {
                                let mensaje_wp = `https://api.whatsapp.com/send?phone=+591${res.programa.celular_coordinador}&text=Hola, necesito mas información sobre ${res.solicitud.tipo_informacion_solicitada} ${res.solicitud.otra_informacion ? " y " + res.solicitud.otra_informacion : ""} del Programa ${res.programa.grado_academico} EN ${res.programa.nombre_programa}, MODALIDAD ${res.programa.modalidad}, VERSIÓN ${res.programa.numero_version}. https://posgrado.upea.bo/programa/${res.programa.id_publicacion}`;


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
                            html: res.mensaje || 'Registrado Exitosamente...',
                            icon: 'success',
                        });
                    }


                    $("#form-informacion")[0].reset();
                    $("#form-informacion #ciudad").val(null).trigger("change");
                    generar_captcha();
                    $("#form-informacion").removeClass("was-validated");

                } else {
                    let mensaje = "";
                    if (res.error) {

                        let valores = Object.values(res.error); // valores = ["Scott", "Negro", true, 5];
                        for (let i = 0; i < valores.length; i++) {
                            mensaje += "<p>" + valores[i] + "</p> ";
                        }
                    } else {
                        mensaje = res.mensaje
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Error!!',
                        html: mensaje || 'No se pudo procesar su solicitud, por favor intente nuevamente.',
                    })

                    if (res.captcha == false) {
                        $("#input_captcha").focus();
                        setTimeout(() => {
                            $("#input_captcha").focus();

                        }, 1500);
                    }



                    generar_captcha();
                }
            })
            .fail(function(error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!!',
                    html: 'No se pudo procesar su solicitud, por favor intente nuevamente.',
                })
                generar_captcha();

                // console.log(error);
            });


    });


    $("#check-correo").on("change", function(e) {

        $("#mostrar-correo").slideToggle(300);

        if ($(this).is(":checked")) {
            $("#correo").attr("disabled", false);
        } else {
            $("#correo").attr("disabled", true);
        }
    });

    // permitir hasta 10 digitos en el campo telefono
    $("#form-informacion input[name='celular']").on("input", function(e) {
        if ($(this).val().length > 8) {
            $(this).val($(this).val().slice(0, 8))
        }
    })




    function generar_captcha() {
        $.post("/informacion/informacion_generar_captcha", {})
            .done(function(response) {

                $("#codigo_captcha").attr("value", response.captcha.codigo);
                $("#img_captcha").attr("src", response.captcha.ruta);
                $("#input_captcha").val("");
            });
    }


});