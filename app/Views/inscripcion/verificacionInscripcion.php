<section class="contact-us section ">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-5 col-xl-4">
                <div class="profile-bx ">
                    <div class="card h-100">
                        <?php if ($publicacion) :  ?>
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
                        <?php else :  ?>
                            <img class="img-fluid" src="<?= base_url('imagenes/afiches/courses-17.jpg') ?>" alt="">
                            <div class="card-body">
                                <h5 class="card-title">Sin Programa</h5>
                                <ul class="course-features">
                                    <li><i class="lni lni-pencil-alt"></i> <span class="label">Inscripción hasta</span> <span class="value"></span></li>
                                    <li><i class="lni lni-timer"></i> <span class="label">Carga Horaria </span> <span class="value">0 horas</span></li>
                                    <li><i class="lni lni-calendar"></i> <span class="label">Duración </span> <span class="value">0 Meses</span></li>
                                    <li><i class="lni lni-arrow-right-circle"></i> <span class="label">Modalidad </span><span class="value">
                                        </span>
                                    </li>
                                    <li><i class="lni lni-dollar"></i> <span class="label">Precio Programa </span><span class="value"></span></li>
                                    <li><i class="lni lni-credit-cards"></i> <span class="label">Precio Matricula </span><span class="value"></span></li>
                                    <li><i class="lni lni-investment"></i> <span class="label">Número de Cuotas</span><span class="value"><i class="fas fa-signal-alt-2    "></i></span></li>
                                </ul>
                            </div>
                        <?php endif  ?>

                    </div>
                </div>
            </div>
            <div class="col-12 col-md-7 col-xl-8">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="alert alert-<?= $estadoInscripcion ? 'info' : 'danger' ?> alert-dismissible fade show" role="alert">
                                    <!-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> -->

                                    <h4 class="card-title"><?= $estadoInscripcion ?  'Inscripci&oacute;n Verificada' : 'No se encontraron Registros de la inscripcion' ?> </h4>
                                    <?php if ($estadoInscripcion) : ?>
                                        <p><b><?= $datos["nombre"] . " " . $datos["paterno"] . " " . $datos["materno"] ?></b> esta pre inscrito en l&iacute;nea satisfactoriamente, <br>
                                            en el programa <b> <?= $publicacion["grado_academico"]. " EN ". $publicacion["nombre_programa"]. " VERSI&Oacute;N ".$publicacion["numero_version"] ?> </b>
                                        </p>
                                        <br>
                                        <a href="<?= base_url("inscripcion/mensajeFinalInscripcion/".$idPersona."/".$idPublicacion)?>"><i class="lni lni-arrow-left"></i> Ver Formularios </a>
                                        <br>



                                    <?php else : ?>
                                        <h5></h5>

                                        <p><b class="font-weight-bold">El c&oacute;digo de inscripcion no existe,</b> verifique nuevamente escaneando el codigo QR en su formulario.</p>
                                        <br>
                                        <a href="<?=base_url() ?>"> Ir a Inicio</a>
                                        <br>
                                        

                                    <?php endif; ?>
                                </div>
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