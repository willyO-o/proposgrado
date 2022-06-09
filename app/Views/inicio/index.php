<?php if (!isset($publicacion)) $publicacion = array();  ?>
<?php if (!isset($programa)) $programa = array();  ?>
<?php //var_dump($programa);  
?>
<section class="hero-area">
	<div class="hero-slider">
		<div class="hero-inner overlay" style="background-image: url('<?php echo base_url('/edugrids/assets/images/hero/slider-bg1'.IDSEDE.'.jpg') ?>');">
			<div class="container">
				<div class="row ">
					<div class="col-lg-8 offset-lg-2 col-md-12 col-12">
						<div class="home-slider">
							<div class="hero-text">
								<a href="<?= base_url('oferta') ?>">
									<h5 class="wow fadeInUp" data-wow-delay=".3s">
										<?= lang('global.revisarOfertas') ?>
									</h5>
								</a>
								<h1 class="wow fadeInUp" data-wow-delay=".5s">Estudia en Posgrado <br> #EstudiaEnPosgradoUPEA</h1>
								<p class="wow fadeInUp" data-wow-delay=".7s">Porque tus metas no tienen pausa<br>Inscr&iacute;bete a nuestros programas posgraduales.
									<br>Contáctate con nosotros.
								</p>
								<div class="button wow fadeInUp" data-wow-delay=".9s">
									<a href="#" class="btn alt-btn">Más Información</a>
									<a href="#" class="btn alt-btn">Contáctanos</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php foreach ($publicacion as $key => $value) : ?>
			<div class="hero-inner overlay" style="background-image: url('<?= base_url($value['url'] == null ? 'imagenes/afiches/courses-17.jpg' : 'imagenes/afiches/' . $value['url']) ?>');">
				<div class="container">
					<div class="row ">
						<div class="col-lg-8 offset-lg-2 col-md-12 col-12">
							<div class="home-slider">
								<div class="hero-text">
									<a href="<?= base_url('oferta') ?>">
										<h5 class="wow fadeInUp" data-wow-delay=".3s"><?= lang('global.revisarOfertas') ?></h5>
									</a>
									<h1 class="wow fadeInUp" data-wow-delay=".5s"><?= ucwords(mb_convert_case($value['grado_academico'], MB_CASE_LOWER)) ?><br> <?= ucwords(mb_convert_case($value['nombre_programa'], MB_CASE_LOWER)) ?> </h1>
									<p class="wow fadeInUp" data-wow-delay=".7s"><?= $value['objetivo'] ?></p>
									<div class="button wow fadeInUp" data-wow-delay=".9s">
										<a href="<?= route_to('App\Controllers\Oferta::detalle', $value['id_publicacion']) ?>" class="btn"><?= lang('global.masInformacion') ?></a>
										<?php if ($value['fecha_fin_inscripcion'] >= date('Y-m-d')) : ?>
											<a href="<?= route_to('App\Controllers\Inscripcion::formulario', $value['id_publicacion']) ?>" class="btn alt-btn"><?= lang('global.inscribete') ?></a>
										<?php endif; ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php endforeach ?>
	</div>
</section>

<section class="features">
	<div class="container-fluid">
		<div class="single-head">
			<div class="section-title align-center gray-bg pt-5">
				<h2 class="wow fadeInUp" data-wow-delay=".4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInUp;">Nuestros programas a nivel nacional</h2>
				<p class="wow fadeInUp" data-wow-delay=".6s" style="visibility: visible; animation-delay: 0.6s; animation-name: fadeInUp;">Desde la gesti&oacute;n 2018 se han ido brindando los siguientes:</p>
				<div>PROGRAMAS POSGRADUALES</div>
			</div>
			<div class="row">
				<?php $carga_horaria = array('DIPLOMADO' => '4', 'ESPECIALIDAD' => '12', 'MAESTRÍA' => '18', 'DOCTORADO' => '24', 'POST DOCTORADO' => '26',); ?>
				<?php $horas_academicas = array('DIPLOMADO' => '800', 'ESPECIALIDAD' => '2400', 'MAESTRÍA' => '3600', 'DOCTORADO' => '4800', 'POST DOCTORADO' => '5200',); ?>
				<?php foreach ($programa as $key => $value) : ?>
					<div class="col-lg-4 col-md-4 col-12 padding-zero">
						<div class="single-feature pb-1 pt-1">
							<h3><a href="javascript:void(0)"><?= ucwords(mb_convert_case($key, MB_CASE_LOWER)) ?></a></h3>
							<p>Programas especializados de <?= $carga_horaria[$key] ?> meses de duraci&oacute;n y <?= $horas_academicas[$key] ?> Horas Acad&eacute;micas.</p>
							<div class="button">
								<!-- <a href="javascript:void(0)" class="btn">Explore <i class="lni lni-arrow-right"></i></a> -->
								<div class="tab-pane fade show" id="nav-general" role="tabpanel">
									<div class="accordion" id="accordionExample">
										<div class="accordion-item">
											<h2 class="accordion-header" id="headingTwo2">
												<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#<?= preg_replace('/\s+/', '', $key);  ?>" aria-expanded="false" aria-controls="<?= preg_replace('/\s+/', '', $key);  ?>">
													<span>Ver Programas</span><i class="lni lni-chevron-down"></i>
												</button>
											</h2>
											<div id="<?= preg_replace('/\s+/', '', $key);  ?>" class="accordion-collapse collapse" aria-labelledby="headingTwo2" data-bs-parent="#accordionExample">
												<div class="accordion-body">
													<ol>
														<?php foreach ($value as $k => $v) : ?>
															<li><b><?= $k + 1 ?>.-</b> <small><?= $v['nombre_programa'] ?></small></li>
														<?php endforeach ?>
													</ol>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php endforeach ?>
			</div>
		</div>
	</div>
</section>

<section class="our-achievement section overlay">
	<div class="container">
		<div class="row">
			<div class="col-lg-3 col-md-3 col-12">
				<div class="single-achievement wow fadeInUp" data-wow-delay=".4s">
					<h3 class="counter"><span id="secondo1" class="countup" cup-end="<?php echo count($programa['DIPLOMADO']); ?>"><?php echo count($programa['DIPLOMADO']); ?></span>+</h3>
					<h4>Diplomados</h4>
				</div>
			</div>
			<div class="col-lg-3 col-md-3 col-12">
				<div class="single-achievement wow fadeInUp" data-wow-delay=".6s">
					<h3 class="counter"><span id="secondo2" class="countup" cup-end="<?php echo count($programa['MAESTRÍA']); ?>"><?php echo count($programa['MAESTRÍA']); ?></span>+</h3>
					<h4>Maestr&iacute;as</h4>
				</div>
			</div>
			<div class="col-lg-3 col-md-3 col-12">
				<div class="single-achievement wow fadeInUp" data-wow-delay=".8s">
					<h3 class="counter"><span id="secondo3" class="countup" cup-end="<?php echo count($programa['DOCTORADO']); ?>"><?php echo count($programa['DOCTORADO']); ?></span>+</h3>
					<h4>Doctorados</h4>
				</div>
			</div>
			<div class="col-lg-3 col-md-3 col-12">
				<div class="single-achievement wow fadeInUp" data-wow-delay=".9s">
					<h3 class="counter"><span id="secondo3" class="countup" cup-end="5344">5344</span>+</h3>
					<h4>Graduados</h4>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="about-us section">
	<div class="container">
		<div class="row">
			<div class="col-lg-6 col-12">
				<div class="about-left">
					<div class="about-title align-left">
						<span class="wow fadeInDown" data-wow-delay=".2s">Eventos 2021</span>
						<h2 class="wow fadeInUp" data-wow-delay=".4s">Estamos presentes en la FeicoBol 2021</h2>
						<p class="wow fadeInUp" data-wow-delay=".6s">Del 28 de octubre al 07 de noviembre, expondremos nuestra
							oferta académica, nuestros resultados obtenidos, nuestra planificación para la gestión 2022 y mucho más.</p>
						<p class="qote wow fadeInUp" data-wow-delay=".8s">Visita nuestro stand, y recibe diversos beneficios, entre
							los cuales incluiremos: becas, descuentos, regalos y promociones especiales.</p>
						<div class="button wow fadeInUp" data-wow-delay="1s">
							<a href="/inicio/feicobol" class="btn">Seguir Leyendo</a>
							<a href="https://youtu.be/A_QN1g3xgnM" class="glightbox video btn"> Reproducir Video<i class="lni lni-play"></i></a>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-6 col-12">
				<div class="about-right wow fadeInRight" data-wow-delay=".4s">
					<img src="<?= base_url('edugrids/assets/images/about/about-img2.png'); ?>" alt="#">
				</div>
			</div>
		</div>
	</div>
</section>

<section class="testimonials section">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="section-title align-center gray-bg">
					<div class="section-icon wow zoomIn" data-wow-delay=".4s">
						<i class="lni lni-quotation"></i>
					</div>
					<h2 class="wow fadeInUp" data-wow-delay=".4s">Lo que dicen de nosotros:</h2>
					<p class="wow fadeInUp" data-wow-delay=".6s">Declaraciones de los posgraduantes inscritos en nuestros programas.</p>
				</div>
			</div>
		</div>
		<div class="row testimonial-slider">
			<div class="col-lg-4 col-md-6 col-12">
				<div class="single-testimonial">
					<div class="text">
						<p>"Los programas son variados, y los costos son accesibles para la formación profesional requerida."</p>
					</div>
					<div class="author">
						<img src="<?= base_url('edugrids/assets/images/testimonials/testi-1.jpg'); ?>" alt="#">
						<h4 class="name">
							Cecilia Diaz Alcazar
							<span class="deg">Mayo, 2021</span>
						</h4>
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-md-6 col-12">
				<div class="single-testimonial">
					<div class="text">
						<p>"Cuentan con un plantel docente reconocido. He aprendido bastante, y me impulsa a seguir participando de sus programas."</p>
					</div>
					<div class="author">
						<img src="<?= base_url('edugrids/assets/images/testimonials/testi-2.jpg'); ?>" alt="#">
						<h4 class="name">
							Juan Pablo Torrico Ruiz
							<span class="deg">Julio, 2021</span>
						</h4>
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-md-6 col-12">
				<div class="single-testimonial">
					<div class="text">
						<p>"Contar con el respaldo de una Universidad Pública permite que su certificación sea útil en la labor profesional. Por ese motivo continúo al pendiente de programas aptos para mi profesión."</p>
					</div>
					<div class="author">
						<img src="<?= base_url('edugrids/assets/images/testimonials/testi-3.jpg'); ?>" alt="#">
						<h4 class="name">
							Franz Pérez Flores
							<span class="deg">Agosto, 2021</span>
						</h4>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>