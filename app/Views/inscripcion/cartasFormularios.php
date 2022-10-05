<section class="contact-us section ">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-5 col-xl-4">
                <div class="profile-bx ">
                    <div class="card h-100">
                        <img class="img-fluid" src="<?= base_url($publicacion['url'] == null ? 'imagenes/afiches/courses-17.jpg' : 'imagenes/afiches/' . $publicacion['url']) ?>" alt="">
                        <div class="card-body">
                            <h5 class="card-title"><?= $publicacion['grado_academico'] ?> EN <?= $publicacion['nombre_programa'] ?></h5>
                            <ul class="course-features">
                                <li><i class="lni lni-pencil-alt"></i> <span class="label">Inscripción hasta</span> <span class="value"><?= $publicacion['fecha_fin_inscripcion'] ?></span></li>
                                <li><i class="lni lni-timer"></i> <span class="label">Carga Horaria </span> <span class="value"><?= $publicacion['carga_horaria'] ?> horas</span></li>
                                <li><i class="lni lni-calendar"></i> <span class="label">Duración </span> <span class="value"><?= $publicacion['duracion'] ?> Meses</span></li>
                                <li><i class="lni lni-arrow-right-circle"></i> <span class="label">Modalidad </span><span class="value"><?= $publicacion['modalidad'] ?></span></li>
                                <li><i class="lni lni-dollar"></i> <span class="label">Precio Programa </span><span class="value"><?= $publicacion['precio_programa'] ?></span></li>
                                <li><i class="lni lni-credit-cards"></i> <span class="label">Precio Matricula </span><span class="value"><?= $publicacion['monto_matricula'] ?></span></li>
                                <li><i class="lni lni-investment"></i> <span class="label">Número de Cuotas</span><span class="value"><?= $publicacion['numero_cuotas'] ?><i class="fas fa-signal-alt-2    "></i></span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-7 col-xl-8">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Gracias por su Inscripci&oacute;n </h4>
                                <p>Concluy&oacute; su pre inscripci&oacute;n en l&iacute;nea satisfactoriamente, se realizar&aacute; la revisi&oacute;n correspondiente de sus datos enviados para la inscripci&oacute;n al programa. Este proceso durar&aacute; 48 horas si est&aacute; todo correcto, se le enviar&aacute; a su correo electr&oacute;nico y n&uacute;mero de WhatsApp su <strong><em><u>USUARIO Y CONTRASEÑA</u></em></strong>, si no, se le enviar&aacute; las observaciones correspondientes</p>
                                <br>
                                <br>
                                <strong> NOTA:</strong>
                                <br>
                                1.- Si pasa m&aacute;s de 48 horas comuniquese con el administrador o al n&uacute;mero <strong><a href="https://api.whatsapp.com/send?phone=59176296846&text=Pasó las 48 horas y no me llego mi usuario y contraseña o alguna observación" title="haga click para enviar un mensaje de WhatsApp">76296846</a></strong>
                                <br>
                                2.- <strong> Para regularizar la inscripci&oacute;n debe entregar toda la documentaci&oacute;n f&iacute;sica a su coordinador del programa durante el periodo de dos semanas.</strong>
                                <br>
                                <br>
                                <strong> Descarga tus archivos:</strong>
                                <br>
                                <ol>
                                    <li>1.- <a href="<?= $formulario01 ?>" id="solicitud_inscripcion" download="Formulario 01">FORMULARIO 01 </a></li>
                                    <li>2.- <a href="<?= $solicitud ?>" id="solicitud_inscripcion" download="Solicitud de inscripcion">SOLICITUD DE INSCRIPCI&Oacute;N </a></li>
                                    <li>3.- <a href="<?= $cartaCompromiso ?>" download="Carta de Compromiso">CARTA DE COMPROMISO</a></li>
                                    <li>4.- <a href="<?= $formulario ?>" id="formulario_inscripcion" download="Formulario de inscripcion">FORMULARIO DE INSCRIPCI&Oacute;N</a></li>
                                    <li>5.- <a href="<?= $solicitudProrroga ?>" download="Carta de Prorroga">SOLICITUD DE PR&Oacute;RROGA</a></li>
                                </ol>
                                <!-- 4.- <a href="" id="formulario_01" download="formulario 01">FORMULARIO 01</a> -->
                                <!-- <br> -->
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>