<section class="contact-us section ">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="profile-bx ">
                    <div class="card h-100">
                        <div class="about-right wow fadeInLeft" data-wow-delay=".4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInLeft;">
                            <img class="img-fluid" src="<?= base_url($publicacion['url'] == null ? 'imagenes/afiches/courses-17.jpg' : 'imagenes/afiches/' . $publicacion['url']) ?>" alt="">
                        </div>
                        <div class="card-body wow fadeInDown" data-wow-delay=".6s" style="visibility: visible; animation-delay: 0.6s; animation-name: fadeInDown;">
                            <h5 class="card-title"><?= $publicacion['grado_academico'] ?> EN <?= $publicacion['nombre_programa'] ?></h5>
                            <ul class="course-features">
                                <li><i class="lni lni-pencil-alt"></i> <span class="label">Inscripción hasta</span> <span class="value"><?= $publicacion['fecha_fin_inscripcion'] ?></span></li>



                                <li><i class="lni lni-timer"></i> <span class="label">Carga Horaria </span><span class="value"><?= $publicacion['carga_horaria'] ?> horas</span></li>
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
            <div class="col-sm-12 col-md-8 col-lg-8">
                <div class="form-main">
                    <h3 class="title wow fadeInDown" data-wow-delay=".8s" style="visibility: visible; animation-delay: 0.8s; animation-name: fadeInDown;">Formulario de Inscripción</h3>
                    <form id="form-carnet" class="form wow fadeInDown" data-wow-delay=".9s" style="visibility: visible; animation-delay: 0.9s; animation-name: fadeInDown;">
                        <input type="hidden" id="id_publicacion" value="<?= $id_publicacion ?>">
                        <div class="row mt-3 justify-content-end">
                            <label for="ci">Cédula de Identidad</label>
                            <div class="col-sm-12 col-md-8 col-lg-8">
                                <div class="form-group">
                                    <input id="ci" name="ci" type="text">
                                    <small class="text-danger">Incluya su extensión si lo tiene.</small>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4 col-lg-4">
                                <div class="button">
                                    <button type="submit" class="btn w-100" id="enviar-formulario-carnet" disabled><i class="lni lni-arrow-right-circle"></i> Continuar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal fade" id="modal" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div id="modal-dialog" class="modal-dialog">
        <div class="modal-content">
            <div id="modal-header" class="modal-header">
                <h5 id="modal-title" class="modal-title">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="modal-body" class="modal-body">
                <div class="text-center">
                    <h4 class="title" id="h4-mensaje"></h4>
                    <h3 class="title" id="h3-ci"></h3>
                </div>
            </div>
            <div id="modal-footer" class="modal-footer">
                <div class="button">
                    <button type="button" class="btn" data-bs-dismiss="modal"><i class="lni lni-chevron-left-circle"></i> Cancelar</button>
                </div>
                <div class="button">
                    <button type="button" class="btn" id="button-confirmar-ci" disabled><i class="lni lni-chevron-right-circle"></i> Continuar <small id="small-contador-confirmar-ci">(5)</small></button>
                </div>
            </div>
        </div>
    </div>
</div>