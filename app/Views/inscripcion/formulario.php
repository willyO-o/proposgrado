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
                <div class="form-main">
                    <h3>FORMULARIO DE INSCRIPCIÓN</h3>
                    <form action="<?= base_url('inscripcion/inscribir') ?>" class="form form needs-validation" id="form-inscribir" enctype="multipart/form-data" method="post">
                        <input class="form-control" type="hidden" id="id_publicacion" name="id_publicacion" value="<?= $id_publicacion ?>">
                        <input class="form-control" name="ci" type="hidden" value="<?= $carnet ?>">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <h5><?= $mensaje[0] ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>

                        <?php if ($mensaje['estado'] == 'esta_inscrito') : ?>
                        <?php elseif ($mensaje['estado'] == 'no_esta_inscrito') : ?>
                            <div class="row">
                                <div class="col-12">
                                    <h5>Deposito Bancario</h5>
                                    <p class="text-danger">Los depositos bancarios deben ser por concepto de Matricula <?= $publicacion['monto_matricula'] ?> Bs., tambien puede adjuntar su deposito del primer pago de su colegiatura.</p>
                                </div>
                                <div id="depositos">
                                    <div id="contenedor-deposito-matricula">
                                        <div class="row elemento-matricula" id="elemento-matricula-1">

                                            <div class="col-11 col-xl-11">
                                                <div class="row col">
                                                    <div class="form-group-1">
                                                        <label for="tipo_deposito_matricula[]">Tipo Deposito</label>
                                                        <select class="form-select form-control" id="tipo_deposito_matricula[]" name="tipo_deposito_matricula[]" required="">
                                                            <!-- <option value="" disabled>Seleccione</option> -->
                                                            <option value="1" selected>PAGO POR MATRICULACION</option>
                                                            <!-- <option value="2" disabled>PAGO POR COLEGIATURA</option> -->
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mt-2">
                                                    <div class="col-12 col-xl-4">
                                                        <div class="form-group-1">
                                                            <label for="numero_deposito_matricula[]">Nro Deposito</label>
                                                            <input class="p-0 form-control" id="numero_deposito_matricula[]" name="numero_deposito_matricula[]" type="text" minlength="15" maxlength="15" required="" inputmode="text">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-xl-5">
                                                        <div class="form-group-1">
                                                            <label for="fecha_deposito_matricula[]">Fecha Deposito</label>
                                                            <input class="p-0 form-control" id="fecha_deposito_matricula[]" name="fecha_deposito_matricula[]" value="<?= date("Y-m-d") ?>" type="date" required="">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-xl-3">
                                                        <div class="form-group-1">
                                                            <label for="monto_matricula[]">Monto (Bs.)</label>
                                                            <input class="p-0 form-control" id="monto_matricula[]" name="monto_matricula[]" type="text" required="" value="<?= $publicacion['monto_matricula'] ?>" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row d-flex justify-content-center">
                                                    <div class="col-sm-12 col-md-6 col-xl-6 border">
                                                        <img class="w-100 img-fluid prev_matricula" src="https://proposgrado1.upea.bo/edugrids/assets/images/svg/upload-alt.svg" alt="Seleccione imagen_matricula[]" style="cursor:pointer">
                                                        <input class="form-control" type="file" id="imagen_matricula[]" name="imagen_matricula[]" accept=".jpg, .jpeg, .png, .JPG, .JPEG, .PNG">
                                                        <p class="text-dark fw-bold text-center">Seleccione imagen</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-1 col-xl-1">

                                            </div>
                                            <hr>
                                            <input id="tiene_respaldo[]" name="tiene_respaldo[]" type="hidden" value="false">
                                        </div>
                                    </div>





                                    <div class="row">
                                        <div class="button d-grid gap-2 d-md-flex justify-content-md-end">
                                            <button id="btn-agregar-deposito-matricula" class="btn p-1 pt-0 pb-0"> Agregar mas depositos</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <hr>
                        <?php elseif ($mensaje['estado'] == 'no_existe_persona') : ?>
                            <div id="datos-personales">
                                <div class="row mt-3">
                                    <div class="col-12 col-sm-12 col-md-6">
                                        <div class="form-group-1">
                                            <label for="ci">Cédula de Identidad</label>
                                            <input class="form-control" id="ci" name="ci" type="text" value="<?= $carnet ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-6">
                                        <div class="form-group-1">
                                            <label for="expedido">Expedido en</label>
                                            <select id="expedido" name="expedido" class="form-select" required>
                                                <option value=""></option>
                                                <option value="QR">QR</option>
                                                <option value="LP" selected>LP</option>
                                                <option value="CH">CH</option>
                                                <option value="CB">CB</option>
                                                <option value="OR">OR</option>
                                                <option value="PT">PT</option>
                                                <option value="TJ">TJ</option>
                                                <option value="SC">SC</option>
                                                <option value="BE">BE</option>
                                                <option value="PD">PD</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <h4>Datos Personales</h4>
                                <span class="mt-2">Registre y Verifique su infomación personal</span>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-12 col-md-6 col-lg-4">
                                        <div class="form-group-1">
                                            <label for="paterno">Paterno</label>
                                            <input class="form-control" id="paterno" name="paterno" type="text" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-4">
                                        <div class="form-group-1">
                                            <label for="materno">Materno</label>
                                            <input class="form-control" id="materno" name="materno" type="text">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-4">
                                        <div class="form-group-1">
                                            <label for="nombre">Nombre(s)</label>
                                            <input class="form-control" id="nombre" name="nombre" type="text" required>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-4">
                                        <div class="form-group-1">
                                            <label for="genero">Genero</label>
                                            <select id="genero" name="genero" class="form-select" required>
                                                <option value="">Seleccione su genero</option>
                                                <option value="M">MASCULINO</option>
                                                <option value="F">FEMENINO</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6 col-sm-6 col-md-4">
                                        <div class="form-group-1">
                                            <label for="fecha_nacimiento">Fecha Nacimiento</label>
                                            <input class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" type="date" required>
                                        </div>
                                    </div>
                                    <div class="col-6 col-sm-6 col-md-4">
                                        <div class="form-group-1">
                                            <label for="celular">Celular</label>
                                            <input class="form-control" id="celular" name="celular" type="text" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-xl-8">
                                        <div class="form-group-1">
                                            <label for="correo">Correo</label>
                                            <input class="form-control text-lowercase" id="correo" name="correo" type="text" onkeyup="this.value = this.value.toUpperCase();" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-xl-7">
                                        <div class="form-group-1">
                                            <label for="oficio_trabajo">Oficio de trabajo</label>
                                            <input class="form-control" id="oficio_trabajo" name="oficio_trabajo" type="text" required>
                                        </div>
                                    </div>
                                    <div class="col-12 col-xl-5">
                                        <div class="form-group-1">
                                            <label for="ciudad">Ciudad donde vive</label>
                                            <select id="ciudad" name="ciudad" class="form-select w-100" required>
                                                <option value="">Seleccione la ciudad</option>
                                                <?php foreach ($ciudades as $key => $value) : ?>
                                                    <option value="<?= $value['nombre_ciudad'] ?>" <?= isset($inscripcion['ciudad']) ? ($inscripcion['ciudad'] == $value['nombre_ciudad'] ?  'selected' : '') : ''; ?>><?= $value['nombre_ciudad'] ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="form-group-1">
                                        <label for="domicilio">Dirección donde vive</label>
                                        <input class="form-control text-uppercase" id="domicilio" name="domicilio" type="text" onkeyup="this.value = this.value.toUpperCase();" required>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-12">
                                    <h5>Deposito Bancario</h5>
                                    <p class="text-danger">Los depositos bancarios deben ser por concepto de Matricula <?= $publicacion['monto_matricula'] ?> Bs., tambien puede adjuntar su deposito del primer pago de su colegiatura.</p>
                                </div>
                                <div id="depositos">
                                    <div id="contenedor-deposito-matricula">
                                        <div class="row elemento-matricula" id="elemento-matricula-1">

                                            <div class="col-11 col-xl-11">
                                                <div class="row col">
                                                    <div class="form-group-1">
                                                        <label for="tipo_deposito_matricula[]">Tipo Deposito</label>
                                                        <select class="form-select form-control" id="tipo_deposito_matricula[]" name="tipo_deposito_matricula[]" required="">
                                                            <!-- <option value="" disabled>Seleccione</option> -->
                                                            <option value="1" selected>PAGO POR MATRICULACION</option>
                                                            <!-- <option value="2" disabled>PAGO POR COLEGIATURA</option> -->
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mt-2">
                                                    <div class="col-12 col-xl-4">
                                                        <div class="form-group-1">
                                                            <label for="numero_deposito_matricula[]">Nro Deposito</label>
                                                            <input class="p-0 form-control" id="numero_deposito_matricula[]" name="numero_deposito_matricula[]" type="text" minlength="15" maxlength="15" required="" inputmode="text">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-xl-5">
                                                        <div class="form-group-1">
                                                            <label for="fecha_deposito_matricula[]">Fecha Deposito</label>
                                                            <input class="p-0 form-control" id="fecha_deposito_matricula[]" name="fecha_deposito_matricula[]" value="<?= date("Y-m-d") ?>" type="date" required="">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-xl-3">
                                                        <div class="form-group-1">
                                                            <label for="monto_matricula[]">Monto (Bs.)</label>
                                                            <input class="p-0 form-control" id="monto_matricula[]" name="monto_matricula[]" type="text" required="" value="<?= $publicacion['monto_matricula'] ?>" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row d-flex justify-content-center">
                                                    <div class="col-sm-12 col-md-6 col-xl-6 border">
                                                        <img class="w-100 img-fluid prev_matricula" src="https://proposgrado1.upea.bo/edugrids/assets/images/svg/upload-alt.svg" alt="Seleccione imagen_matricula[]" style="cursor:pointer">
                                                        <input class="form-control" type="file" id="imagen_matricula[]" name="imagen_matricula[]" accept=".jpg, .jpeg, .png, .JPG, .JPEG, .PNG">
                                                        <p class="text-dark fw-bold text-center">Seleccione imagen</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-1 col-xl-1">

                                            </div>
                                            <hr>
                                            <input id="tiene_respaldo[]" name="tiene_respaldo[]" type="hidden" value="false">
                                        </div>
                                    </div>





                                    <div class="row">
                                        <div class="button d-grid gap-2 d-md-flex justify-content-md-end">
                                            <button id="btn-agregar-deposito-matricula" class="btn p-1 pt-0 pb-0"> Agregar mas depositos</button>
                                        </div>
                                    </div>

                                </div>
                            </div>


                        <?php endif; ?>


                        <div class="row mt-3">
                            <div class="col-4 col-xl-4 button">
                                <a class="btn" href="<?= base_url('oferta') ?>"><i class="lni lni-reply"></i> Volver</a>
                            </div>
                            <?php if ($mensaje['estado'] == 'esta_inscrito') : ?>
                                <div class="col-8 col-xl-8 d-grid gap-2 d-md-flex justify-content-md-end">
                                    <div class="button">
                                        <a class="btn" href="<?= base_url("inscripcion/mensajeFinalInscripcion/{$mensaje['idPersonaExterna']}/{$mensaje['idPublicacion']}") ?>"><i class="lni lni-arrow-right-circle"></i> Ver formularios</a>
                                    </div>
                                </div>
                            <?php else : ?>
                                <div class="col-8 col-xl-8 d-grid gap-2 d-md-flex justify-content-md-end">
                                    <div class="button">
                                        <button class="btn" id="btn-revisar-formulario-inscripcion"><i class="lni lni-arrow-right-circle" id="icono-enviar-formulario"></i> Enviar Datos para su Inscripción <small id="porcentaje-enviar-formulario"></small> </button>
                                    </div>
                                </div>
                            <?php endif ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="modal" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div id="modal-dialog">
        <div class="modal-content">
            <div id="modal-header" class="modal-header">
                <h4 id="modal-title" class="modal-title"></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="modal-body" class="modal-body">

            </div>

            <div id="modal-footer" class="modal-footer d-none">
                <div class="button">
                    <button class="btn" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
                <div class="button d-grid gap-2 d-md-flex justify-content-md-end">
                    <button class="btn" type="submit" class="btn btn-primary"> Enviar Informacíon</button>
                </div>
            </div>
        </div>
    </div>
</div>