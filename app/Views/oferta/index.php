<section class="courses section grid-page section pt-2">
	<div class="container">


		<div class="row mt-5 d-flex justify-content-center">


			<div class="col-md-12 col-lg-8">
				<div class="input-group">

					<input type="search" name="" id="buscar-programa" placeholder="Buscar programa" class="form-control">
					<div class="button">
						<label class="input-group-text btn" for="buscar-programa"><i class="lni lni-search"></i> </label>
					</div>
				</div>

			</div>
		</div>

		<div class="row justify-content-center pt-3" id="caja-filtros" style="display:none">
			<div class="col-md-6 col-lg-4">
				<div class="input-group mb-3">
					<div class="button">
						<label class="input-group-text btn" for="filtro-modalidad">Modalidad</label>
					</div>
					<select class="form-control" id="filtro-modalidad">
						<option selected value="0">TODOS</option>
						<?php foreach ($modalidades as $modalidad) : ?>
							<option value="<?= $modalidad->nombre_tipo_programa ?>"><?= $modalidad->nombre_tipo_programa ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>

			<div class="col-md-6 col-lg-4">
				<div class="input-group mb-3">
					<div class="button">
						<label class="input-group-text btn" for="filtro-area">Area</label>

					</div>
					<select class="form-control" id="filtro-area">
						<option selected value="0">Todos</option>
						<?php foreach ($areas as $area) : ?>
							<option value="<?= $area->id_area ?>"><?= $area->nombre_area ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
		</div>
		<p class="text-center"><a href="javascript:void(0)" class="my-3 font-weight-bold text-primary  text-center" id="mostrar-filtros"><b>Busqueda Avanzada</b> <i class="lni lni-chevron-down"></i> </a></p>


		<div id="no-encontrado" class=" py-5" style="display: none;">
			<h3>NO SE ENCONTRARON RESULTADOS QUE COINCIDAN CON LA BUSQUEDA </h3>
		</div>
		<div id="contenedor-programas">
			<?php foreach (['TECNICO MEDIO' => 'TECNICO MEDIO', 'TECNICO SUPERIOR' => 'TECNICO SUPERIOR', 'LICENCIATURA' => 'LICENCIATURAS', 'DIPLOMADO' => 'DIPLOMADOS', 'ESPECIALIDAD' => 'ESPECIALIDADES', 'MAESTRÍA' => 'MAESTRÍAS', 'DOCTORADO' => 'DOCTORADOS', 'POST DOCTORADO' => 'POST DOCTORADOS'] as $key => $value) : ?>

				<?php $contador = 0 ?>
				<?php if (isset($programa[$key])) : ?>
					<div class="row wow fadeInUp pb-5 row-psg" data-wow-delay=".2s">
						<h3 class="title"><?= $value . ' SEDE ' . (IDSEDE == 1 ? 'CENTRAL' : SEDE) ?></h3>
						<?php if (!empty($programa[$key])) : ?>
							<?php foreach ($programa[$key] as $k => $v) : ?>
								<div class="col-lg-4 col-md-6 col-12 text-center cartas-psg " data-id="<?= $v["id_publicacion"] ?>">
									<div class="single-course wow fadeInUp" data-wow-delay=".2s">
										<div class="course-image caja-imagen">
											<a href="<?= route_to('App\Controllers\Oferta::detalle', $v['id_publicacion']) ?>">
												<img src="<?= base_url('imagenes/afiches/' . ($v['url'] == null ? 'programa.jpg' : $v['url'])) ?>" alt="#"></a>

											<p class="price">Bs <?= number_format($v['precio_programa'], '0', ',', '.'); ?></p>
										</div>
										<div class="content pb-0">
											<div class="mb-2">
												<h5 class="mb-0 titulo-programa" style="min-height: 70px;"><a href="<?= route_to('App\Controllers\Oferta::detalle', $v['id_publicacion']) ?>"><?= $key . ' EN ' . $v['nombre_programa'] ?><br /><small><?= ' Versión: ' . numero_romano($v['numero_version']) ?></small></a></h5>

												<?php if ($v["mostrar_coordinador"] == "NO") : ?>
													<p> POSGRADO - SEDE CENTRAL </p>


												<?php else : ?>
													<?php if ($v["id_responsable_interno"]) : ?>
														<p>Coordinador: <?= $v["nombre"] . " " . $v["paterno"] . " " . $v["materno"] ?></p>
													<?php endif ?>
												<?php endif ?>


											</div>
											<!-- <a href="service-single.html">
											<small class="h5 mb-0 truncate-text text-dark" title="<?= $v['nombre_programa'] ?>"><?= $v['nombre_programa'] ?></small>
										</a> -->
											<div class="button pb-3">
												<a href="<?= route_to('App\Controllers\Oferta::detalle', $v['id_publicacion']) ?>" class="btn p-2">
													<i class="lni lni-book"></i> Contenido del programa
												</a>
												<?php if (!is_null($v['infograma'])) : ?>
													<a title="Descargra Infograma del Programa (<?= $v['infograma'] ?>})" target="_blank" href="<?= base_url('descargas_programa/' . $v['infograma']) ?>" class="btn p-2">
														<i class="lni lni-download"></i>
													</a>
												<?php endif; ?>
											</div>

											<ul class="course-features-1">
												<li><i class=" lni lni-pencil-alt"></i> <span class="label">Inscripción hasta</span>
													<span class="value"><?= $v['fecha_fin_inscripcion'] ?></span>
												</li>
												<li><i class="lni lni-timer"></i> <span class="label">Carga Horaria </span>
													<span class="value"><?= $v['carga_horaria'] ?> horas</span>
												</li>
												<li><i class="lni lni-calendar"></i> <span class="label">Duración </span>
													<span class="value"><?= $v['duracion'] ?> Meses</span>
												</li>
												<li><i class="lni lni-arrow-right-circle"></i> <span class="label">Modalidad </span>
													<span class="value"><?= $v['modalidad'] ?></span>
												</li>
												<li><i class="lni lni-credit-cards"></i> <span class="label">Costo Colegiatura </span>
													<span class="value"><?= $v['precio_programa'] ?></span>
												</li>
												<li><i class="lni lni-credit-cards"></i> <span class="label">Costo Matricula </span>
													<span class="value"><?= $v['monto_matricula'] ?></span>
												</li>
												<li><i class="lni lni-investment"></i> <span class="label">Número de Cuotas</span>
													<span class="value"><?= $v['numero_cuotas'] ?></i></span>
												</li>
											</ul>
										</div>
										<div class="bottom-content">
											<div class="row">
												<div class="col-sm-12 col-lg-6 button p-1">
													<a class="btn informacion-programa p-3" href="javascript:void(0)" data-id-publicacion="<?= $v['id_publicacion'] ?>" data-detalle=" <?= $v['grado_academico'] . ' EN ' . $v['nombre_programa'] . (empty($v['modalidad']) ? '' : ' Mod. ' . $v['modalidad']) . (empty($v['numero_version']) ? '' : ' Versión ' . $v['numero_version']) ?>"><i class="lni lni-question-circle"></i> Información</a>
												</div>
												<div class="col-sm-12 col-lg-6 button p-1">
													<?php if ($v['fecha_fin_inscripcion'] >= date('Y-m-d')) : ?>
														<a class="btn p-3" href="<?= route_to('App\Controllers\Inscripcion::formulario', $v['id_publicacion']) ?>"><i class="lni lni-credit-cards"></i> Inscríbete</a>
													<?php endif ?>
												</div>
											</div>
										</div>
									</div>

								</div>
							<?php endforeach ?>
						<?php else : ?>
							<div class="col-lg-12 col-md-12 col-12 text-center">
								<div class="single-feature">
									<h5><a href="javascript:void(0)">No hay <?= $value ?> vigentes </a></h5>
									<p>No contamos con <?= $value ?> vigentes para la inscripción en Linea.</p>
								</div>
							</div>
						<?php endif ?>
					</div>
				<?php endif ?>
			<?php endforeach ?>
		</div>

	</div>
</section>

<div class="modal" id="modal" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div id="modal-dialog">
		<div class="modal-content">
			<div id="modal-header" class="modal-header">
				<h4 id="modal-title" class="modal-title"></h4>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form action="<?= base_url("informacion/informacion_registrar_solicitud") ?>" class="form form needs-validation" method="post" id="form-informacion-programa">
				<input type="hidden" name="publicacion" id="id_publicacion">
				<div id="modal-body" class="modal-body">
					<div class="contact-us">
						<div class="form-main">
							<div class="row">
								<div class="col">
									<p class="text-center">Recibira información del programa:
										<b id="detalle-programa"></b>
										<br>
									</p>
								</div>
							</div>
							<div class="row mt-1">


								<div class="col-12 col-sm-12 col-md-6 col-lg-6">
									<div class="form-group-1">
										<label for="nombre_persona">Nombre Completo <span class="text-danger">*</span></label>
										<input class="form-control" id="nombre_persona" name="nombre_persona" type="text" required oninput="javascript:this.value=this.value.toUpperCase();">
									</div>
								</div>
								<div class="col-12 col-sm-12 col-md-6 col-lg-6">
									<div class="form-group-1">
										<label for="materno">Tu Ciudad</label>
										<select name="ciudad" id="ciudad" class="form-select" required>
											<option value="">
												<- Seleccione ->
											</option>
											<?php foreach ($ciudades as $ciudad) : ?>
												<option value="<?= $ciudad->nombre_ciudad ?>">
													<?= $ciudad->nombre_ciudad ?>
												</option>
											<?php endforeach ?>
										</select>
										<!-- <input class="form-control" id="materno" name="materno" type="text"> -->
									</div>
								</div>
								<div class="col-12 col-sm-12 col-md-6 col-lg-6">
									<div class="form-group-1">
										<label for="celular">Celular (WhatsApp) <span class="text-danger">*</span></label>
										<div class="input-group">
											<input class="form-control" id="celular" name="celular" type="number" required style="width: 20px;" min="60000000" max="79999999">
											<!-- <a href="javascript:void(0)" class="enviar-whatsapp"><span class="input-group-text pe-auto">
													<i class="lni lni-whatsapp"></i>
												</span>
											</a> -->
										</div>
									</div>
								</div>

								<div class="col-12 col-sm-12 col-md-6 col-lg-6">
									<div class="form-group-1">
										<label for="correo">Correo <small>(opcional)</small></label>
										<input class="form-control" id="correo" name="correo" type="email">
									</div>
								</div>


							</div>

							<div class="row">
								<div class="col-12">
									<!-- <a class="tengoCorreoElectronico text-center d-flex justify-content-center" href="javascript:;">Tengo correo electrónico</a>
									<a class="noTengoCorreoElectronico text-center d-flex justify-content-center d-none" href="javascript:;">No tengo correo electrónico</a> -->
								</div>
							</div>

							<div class="row rowCorreo">
							</div>

							<div class="row">
								<div class="col">
									<p class="font-weight-bold mt-2"><strong>Recibir información sobre:</strong></p>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-6 col-12">
									<div class="form-check">
										<input type="checkbox" class="form-check-input width-auto" id="marcarTodo" value="Marcar Todo">
										<label class="form-check-label" for="marcarTodo">Marcar Todo</label>
									</div>
									<hr>

								</div>
								<div class="col-12 col-sm-12 col-md-12 col-lg-12">

									<div class="col-lg-6 col-12">
										<div class="form-check">
											<input type="checkbox" class="form-check-input checkboxes width-auto" name="informacion[]" id="check-input1" value="Contenido" required>
											<label class="form-check-label" for="check-input1">Contenido</label>
										</div>
									</div>
									<div class="col-lg-6 col-12">
										<div class="form-check">
											<input type="checkbox" class="form-check-input checkboxes width-auto" name="informacion[]" id="check-input2" value="Precio" required>
											<label class="form-check-label" for="check-input2">Precio</label>
										</div>
									</div>
									<div class="col-lg-6 col-12">
										<div class="form-check">
											<input type="checkbox" class="form-check-input checkboxes width-auto" name="informacion[]" id="check-input3" value="Duración" required>
											<label class="form-check-label" for="check-input3">Duración</label>
										</div>
									</div>
									<div class="col-lg-6 col-12">
										<div class="form-check">
											<input type="checkbox" class="form-check-input checkboxes width-auto" name="informacion[]" id="check-input4" value="Requisitos mínimos" required>
											<label class="form-check-label" for="check-input4">Requisitos mínimos</label>
										</div>
									</div>

								</div>
								<div class="col-12 col-sm-12 col-md-6 col-lg-6">
									<div class="form-group-1">
										<label for="otra_info">Otra Informacion <small>(opcional)</small></label>
										<input class="form-control" id="otra_info" name="otra_info" type="text">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6 col-12">
									<div class="form-group">
										<label>Captcha</label>
									</div>
									<div class="input-group">
										<input type="hidden" name="codigo_captcha" id="codigo_captcha" value="QPW">

										<img src="" alt="" id="img_captcha">
										<input name="captcha" type="number" placeholder="" id="input_captcha" class="input-captcha form-control" required="required">
									</div>
								</div>
							</div>

							<!-- <div class="row">
								<div class="col-12 col-sm-12 col-md-12">
									<div class="form-group-1">
										<label for="ci">Área</label>
										<select class="form-select" id="id_area" name="id_area" required>
											<option value="">-- Seleccione --</option>
											<?php
											foreach ($areas as $key => $value) {
												echo '<option value="' . $value->id_area . '">' . $value->nombre_area . '</option>';
											}
											?>
										</select>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-12">
									<div class="form-group-1">
										<label for="ci">Seleccione etiquetas para recibir información</label>
										<div id="demo" style="width: 100%; height: 200px; position: relative;"></div>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-12 col-sm-12 col-md-12">
									<div class="form-group-1">
										<label for="expedido">Etiquetas seleccionados</label>
										<input type="text" name="etiquetas" id="etiquetas" value='' />
									</div>
								</div>
							</div> -->

						</div>

					</div>
				</div>

				<div id="modal-footer" class="modal-footer">
					<div class="button d-flex align-items-center">
						<button id="btn-enviar-informacion-programa" class="btn btn-info" type="submit" class="btn btn-primary"><i class="lni lni-arrow-right-circle" id="icono-enviar-formulario"></i> Solicitar Información<small id="porcentaje-enviar-formulario"></small></button>
						<button type="button" class="btn btn-secondary enviar-whatsapp" style="margin-left: 2px;">Contacto Coordinador</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal" id="modal1" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div id="modal-dialog">
		<div class="modal-content">
			<div id="modal-header" class="modal-header">
				<h4 id="modal-title" class="modal-title"></h4>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form action="" class="form form needs-validation" method="post" id="">
				<input type="hidden" name="id_publicacion" id="id_publicacion">
				<div id="modal-body" class="modal-body">
					<div class="contact-us">
						<div class="form-main">
							<div class="row">
								<div class="col">
									<p class="text-center">Recibira información del programa:
										<b id="detalle-programa"></b>
									</p>
								</div>
							</div>
							<div class="row">
								<div class="col-12 col-sm-12 col-md-4">
									<div class="form-group-1">
										<label for="ci">Cédula de Identidad</label>
										<input class="form-control" id="ci" name="ci" type="text" required>
									</div>
								</div>
								<div class="col-12 col-sm-12 col-md-3">
									<div class="form-group-1">
										<label for="expedido">Exp</label>
										<select class="form-select" id="expedido" name="expedido" required>
											<option value=""></option>
											<option value="LP">LP</option>
											<option value="CH">CH</option>
											<option value="CB">CB</option>
											<option value="OR">OR</option>
											<option value="PT">PT</option>
											<option value="TJ">TJ</option>
											<option value="SC">SC</option>
											<option value="BE">BE</option>
											<option value="PD">PD</option>
											<option value="QR">QR</option>

										</select>
									</div>
								</div>
								<div class="col-12 col-sm-12 col-md-5">
									<div class="form-group-1">
										<label for="nombre">Nombre(s)</label>
										<input class="form-control" id="nombre" name="nombre" type="text" required>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-12 col-sm-12 col-md-7">
									<div class="form-group-1">
										<label for="paterno">Paterno</label>
										<input class="form-control" id="paterno" name="paterno" type="text" required>
									</div>
								</div>
								<div class="col-12 col-sm-12 col-md-5">
									<div class="form-group-1">
										<label for="materno">Materno</label>
										<input class="form-control" id="materno" name="materno" type="text">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-12 col-sm-12 col-md-7">
									<div class="form-group-1">
										<label for="correo">Correo</label>
										<input class="form-control text-lowercase" id="correo" name="correo" type="text" onkeyup="this.value = this.value.toUpperCase();" required>
									</div>
								</div>
								<div class="col-12 col-sm-12 col-md-5">
									<div class="form-group-1">
										<label for="celular">Celular</label>
										<input class="form-control" id="celular" name="celular" type="text" required>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-6 col-sm-12 col-md-4">
									<div class="form-group-1">
										<label for="ci">Área</label>
										<select class="form-select" id="expedido" name="expedido" required>
											<option value=""></option>
										</select>
									</div>
								</div>
								<div class="col-6 col-sm-12 col-md-3">
									<div class="form-group-1">
										<label for="expedido">Programas</label>
										<select class="form-select" id="expedido" name="expedido" required>
											<option value=""></option>

										</select>
									</div>
								</div>
							</div>

						</div>

					</div>
				</div>

				<div id="modal-footer" class="modal-footer">
					<div class="button">
						<button class="btn" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
					</div>
					<div class="button d-grid gap-2 d-md-flex justify-content-md-end">
						<button id="" class="btn" type="submit" class="btn btn-primary"><i class="lni lni-arrow-right-circle" id="icono-enviar-formulario"></i> Enviar Informacíon <small id="porcentaje-enviar-formulario-area"></small></button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal" id="suscripcion-area" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div id="suscripcion-area-dialog">
		<div class="modal-content">
			<div id="suscripcion-area-header" class="modal-header">
				<h4 id="suscripcion-area-title" class="modal-title"></h4>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form action="<?= base_url('inscripcion/suscripcionArea') ?>" class="form form needs-validation" method="post" id="form-suscripcion-area">
				<div id="suscripcion-area-body" class="modal-body">
					<div class="contact-us">
						<div class="form-main">
							<div class="row">
								<div class="col-12 col-sm-12 col-md-4">
									<div class="form-group-1">
										<label for="ci">Cédula de Identidad</label>
										<input class="form-control" id="ci" name="ci" type="text" required>
									</div>
								</div>
								<div class="col-12 col-sm-12 col-md-3">
									<div class="form-group-1">
										<label for="expedido">Exp</label>
										<select class="form-select" id="expedido" name="expedido" required>
											<option value=""></option>
											<option value="LP">LP</option>
											<option value="CH">CH</option>
											<option value="CB">CB</option>
											<option value="OR">OR</option>
											<option value="PT">PT</option>
											<option value="TJ">TJ</option>
											<option value="SC">SC</option>
											<option value="BE">BE</option>
											<option value="PD">PD</option>
											<option value="QR">QR</option>

										</select>
									</div>
								</div>
								<div class="col-12 col-sm-12 col-md-5">
									<div class="form-group-1">
										<label for="nombre">Nombre(s)</label>
										<input class="form-control" id="nombre" name="nombre" type="text" required>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-12 col-sm-12 col-md-7">
									<div class="form-group-1">
										<label for="paterno">Paterno</label>
										<input class="form-control" id="paterno" name="paterno" type="text" required>
									</div>
								</div>
								<div class="col-12 col-sm-12 col-md-5">
									<div class="form-group-1">
										<label for="materno">Materno</label>
										<input class="form-control" id="materno" name="materno" type="text">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-12 col-sm-12 col-md-7">
									<div class="form-group-1">
										<label for="correo">Correo</label>
										<input class="form-control text-lowercase" id="correo" name="correo" type="text" onkeyup="this.value = this.value.toUpperCase();" required>
									</div>
								</div>
								<div class="col-12 col-sm-12 col-md-5">
									<div class="form-group-1">
										<label for="celular">Celular</label>
										<div class="input-group">
											<input class="form-control" id="celular-area" name="celular" type="text" required style="width: 20px;">
											<a href="javascript:void(0)" id="enviar-whatsapp-area"><span class="input-group-text pe-auto">
													<i class="lni lni-whatsapp"></i>
												</span>
											</a>
										</div>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-12 col-sm-12 col-md-12">
									<div class="form-group-1">
										<label for="ci">Área</label>
										<select class="form-select" id="id_area" name="id_area" required>
											<option value=""></option>
											<?php foreach ($areas as $v) : ?>
												<option value="<?= $v->id_area ?>"><?= $v->nombre_area ?></option>
											<?php endforeach ?>
										</select>
									</div>
								</div>
							</div>

						</div>

					</div>
				</div>

				<div id="modal-footer" class="modal-footer">
					<div class="button">
						<button class="btn" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
					</div>
					<div class="button d-grid gap-2 d-md-flex justify-content-md-end">
						<button class="btn" type="submit" class="btn btn-primary" id="btn-enviar-informacion-suscripcion-area"><i class="lni lni-arrow-right-circle" id="icono-enviar-formulario-suscripcion-area"></i> Suscribirse <small id="porcentaje-enviar-formulario-area"></small></button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>