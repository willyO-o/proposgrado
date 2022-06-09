<div id="fb-root"></div>
<div class="course-details section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-12">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button" role="tab" aria-controls="overview" aria-selected="true">Detalle</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="instructor-tab" data-bs-toggle="tab" data-bs-target="#instructor" type="button" role="tab" aria-controls="instructor" aria-selected="false">Requisitos</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab" aria-controls="reviews" aria-selected="false">Contenidos Mínimos</button>
                    </li>
                    <?php if (!is_null($programa['infograma'])) : ?>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="infogram-tab" data-bs-toggle="tab" data-bs-target="#infogram" type="button" role="tab" aria-controls="reviews" aria-selected="false">Infograma</button>
                        </li>
                    <?php endif; ?>
                    <!-- <li class="nav-item" role="presentation">
                        <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Contactar</button>
                    </li> -->
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
                        <div class="course-overview">
                            <h3 class="title"><?= $programa['grado_academico'] ?> EN <?= $programa['nombre_programa'] ?></h3>
                            <p><?= $programa['descripcion'] ?></p>
                            <h5 class="pb-1">Objetivo del Programa</h5>
                            <p><?= $programa['objetivo'] ?></p>
                            <div class="overview-course-video">
                                <!-- <iframe title="jQuery Tutorial #1 - jQuery Tutorial for Beginners" src="https://www.youtube.com/embed/hMxGhHNOkCU?feature=oembed"></iframe> -->
                                <img src="<?= base_url($programa['url'] == null ? 'imagenes/afiches/courses-17.jpg' : 'imagenes/afiches/' . $programa['url']) ?>" alt="" class="img-fluid">
                            </div>

                            <h5 class="pb-1">Datos Generales</h5>
                            <div class="row justify-content-center">
                                <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                    <ul class="course-features-1">
                                        <li><i class=" lni lni-pencil-alt"></i> <span class="label">Inscripción hasta</span><span class="value"><?= $programa['fecha_fin_inscripcion'] ?></span></li>
                                        <li><i class="lni lni-timer"></i> <span class="label">Carga Horaria </span><span class="value"><?= $programa['carga_horaria'] ?> horas</span></li>
                                        <li><i class="lni lni-calendar"></i> <span class="label">Duración </span> <span class="value"><?= $programa['duracion'] ?> Meses</span></li>
                                        <li><i class="lni lni-arrow-right-circle"></i> <span class="label">Modalidad </span><span class="value"><?= $programa['modalidad'] ?></span></li>
                                        <li><i class="lni lni-credit-cards"></i> <span class="label">Costo Colegiatura </span><span class="value"><?= $programa['precio_programa'] ?></span></li>
                                        <li><i class="lni lni-credit-cards"></i> <span class="label">Costo Matricula </span><span class="value"><?= $programa['monto_matricula'] ?></span></li>
                                        <li><i class="lni lni-investment"></i> <span class="label">Número de Cuotas</span><span class="value"><?= $programa['numero_cuotas'] ?></i></span></li>
                                        <li><i class="lni lni-whatsapp"></i> <span class="label">Número de Coordinador</span><span class="value"><a target="_blank" href="https://api.whatsapp.com/send/?phone=591<?= $programa['celular_coordinador'] ?>&text= Hola, mas informacion del Programa *<?= $programa['grado_academico'] . ' EN ' . $programa['nombre_programa'] . ' VERSIÓN ' . $programa['numero_version'] . '* ' . base_url(route_to('App\Controllers\Oferta::detalle', $programa['id_publicacion'])) ?>"><?= $programa['celular_coordinador'] ?></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="bottom-content text-center">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-12 p-1 button">
                                        <a class="btn" href="<?= base_url('oferta') ?>"><i class="lni lni-reply"></i> Volver</a>
                                        <!-- <ul class="share text-center">
                                            <li><span>Compartir Este Programa:</span></li>
                                            <br>
                                            <div class="fb-share-button" data-href="<?= route_to('App\Controllers\Oferta::detalle', $programa['id_publicacion']) ?>" data-layout="button_count" data-size="small"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Compartir</a></div>
                                            <li><a href="https://www.facebook.com/Estudia-En-Posgrado-UPEA-128794501288356/"><i class="lni lni-facebook-original"></i></a></li>
                                            <li><a href="javascript:void(0)"><i class="lni lni-twitter-original"></i></a></li>
                                            <li><a href="javascript:void(0)"><i class="lni lni-linkedin-original"></i></a></li>
                                            <li><a href="javascript:void(0)"><i class="lni lni-google"></i></a></li>
                                            <li><a href="javascript:void(0)"><i class="lni lni-whatsapp"></i></a></li>
                                        </ul> -->
                                    </div>
                                    <!-- <div class="col-lg-4 col-md-4 col-12 p-1 button">
                                        <a class="btn informacion-programa" href="javascript:void(0)"><i class="lni lni-circle-plus"></i> Más Información</a>
                                    </div> -->
                                    <?php if ($programa['fecha_fin_inscripcion'] >= date('Y-m-d')) : ?>
                                        <div class="col-lg-6 col-md-6 col-12 p-1 button">
                                            <a class="btn" href="<?= route_to('App\Controllers\Inscripcion::formulario', $programa['id_publicacion']) ?>"><i class="lni lni-credit-cards"></i> Inscríbete Ahora</a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="instructor" role="tabpanel" aria-labelledby="instructor-tab">
                        <div class="course-instructor">
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="profile-info">
                                        <h5>Criterios de Admisión (requisitos)</h5>
                                        <?= $programa['requisitos_inscripcion'] ?>
                                        <!-- <ul class="author-social-networks">
                                            <li class="item">
                                                <a href="JavaScript:Void(0);" target="_blank" class="social-link">
                                                    <i class="lni lni-facebook-original"></i> </a>
                                            </li>
                                            <li class="item">
                                                <a href="JavaScript:Void(0);" target="_blank" class="social-link">
                                                    <i class="lni lni-twitter-original"></i> </a>
                                            </li>
                                            <li class="item">
                                                <a href="JavaScript:Void(0);" target="_blank" class="social-link">
                                                    <i class="lni lni-instagram"></i> </a>
                                            </li>
                                            <li class="item">
                                                <a href="JavaScript:Void(0);" target="_blank" class="social-link">
                                                    <i class="lni lni-linkedin-original"></i> </a>
                                            </li>
                                            <li class="item">
                                                <a href="JavaScript:Void(0);" target="_blank" class="social-link">
                                                    <i class="lni lni-youtube"></i> </a>
                                            </li>
                                        </ul> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="bottom-content">
                            <div class="row align-items-center">
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="button">
                                        <a href="#0" class="btn">Buy this course</a>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <ul class="share">
                                        <li><span>Share this course:</span></li>
                                        <li><a href="javascript:void(0)"><i class="lni lni-facebook-original"></i></a></li>
                                        <li><a href="javascript:void(0)"><i class="lni lni-twitter-original"></i></a></li>
                                        <li><a href="javascript:void(0)"><i class="lni lni-linkedin-original"></i></a></li>
                                        <li><a href="javascript:void(0)"><i class="lni lni-google"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div> -->
                    </div>
                    <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                        <div class="course-reviews">
                            <div class="course-rating">
                                <div class="course-rating-content">
                                    <div class="m-b30 " id="curriculum">
                                        <div class="post-comments">
                                            <h3 class="comment-title">Estructura Curricular (Contenidos Mínimos)</h3>
                                            <?= $programa['contenido_minimo'] ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                        <div class="course-reviews">
                            <div class="course-rating">
                                <div class="course-rating-content">

                                    <div class="post-comments">
                                        <h3 class="comment-title">Reviews</h3>
                                        <ul class="comments-list">
                                            <li>
                                                <div class="comment-img">
                                                    <img src="assets/images/blog/comment1.png" alt="img">
                                                </div>
                                                <div class="comment-desc">
                                                    <div class="desc-top">
                                                        <h6 class="name"><a href="JavaScript:Void(0);">Rosalina Kelian</a></h6>
                                                        <ul class="rating-star">
                                                            <li><i class="lni lni-star-filled"></i></li>
                                                            <li><i class="lni lni-star-filled"></i></li>
                                                            <li><i class="lni lni-star-filled"></i></li>
                                                            <li><i class="lni lni-star-filled"></i></li>
                                                            <li><i class="lni lni-star-filled"></i></li>
                                                        </ul>
                                                        <p class="time">1 days ago</p>
                                                    </div>
                                                    <p>
                                                        Donec aliquam ex ut odio dictum, ut consequat leo interdum.
                                                        Aenean nunc
                                                        ipsum, blandit eu enim sed, facilisis convallis orci. Etiam
                                                        commodo
                                                        lectus
                                                        quis vulputate tincidunt. Mauris tristique velit eu magna
                                                        maximus
                                                        condimentum.
                                                    </p>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="comment-img">
                                                    <img src="assets/images/blog/comment3.png" alt="img">
                                                </div>
                                                <div class="comment-desc">
                                                    <div class="desc-top">
                                                        <h6 class="name"><a href="JavaScript:Void(0);">Arista Williamson</a></h6>
                                                        <ul class="rating-star">
                                                            <li><i class="lni lni-star-filled"></i></li>
                                                            <li><i class="lni lni-star-filled"></i></li>
                                                            <li><i class="lni lni-star-filled"></i></li>
                                                            <li><i class="lni lni-star-filled"></i></li>
                                                            <li><i class="lni lni-star-filled"></i></li>
                                                        </ul>
                                                        <p class="time">5 days ago</p>
                                                    </div>
                                                    <p>
                                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit,
                                                        sed do eiusmod
                                                        tempor incididunt ut labore et dolore magna aliqua. Ut enim
                                                        ad minim
                                                        veniam.
                                                    </p>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="comment-form">
                                        <h3 class="comment-reply-title">Add a review</h3>
                                        <form action="#" method="POST">
                                            <div class="row">
                                                <div class="col-lg-6 col-md-12 col-12">
                                                    <div class="form-box form-group">
                                                        <input type="text" name="#" class="form-control form-control-custom" placeholder="Your Name">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-12">
                                                    <div class="form-box form-group">
                                                        <input type="email" name="#" class="form-control form-control-custom" placeholder="Your Email">
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-box form-group">
                                                        <textarea name="#" rows="6" class="form-control form-control-custom" placeholder="Your Comments"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="button">
                                                        <button type="submit" class="btn">Submit review<span class="dir-part"></span></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="infogram" role="tabpanel" aria-labelledby="infogram-tab">
                        <div class="course-reviews">
                            <div class="course-rating">
                                <div class="course-rating-content">
                                    <div class="post-comments">
                                        <div class="row">
                                            <div class="col-12 col-md-8">
                                                <h3 class="comment-title">Infograma del Programa</h3>

                                            </div>
                                            <div class="col-12 col-md-4">
                                                <div class="float-end button">
                                                    <a download="<?= $programa['grado_academico'] ?> EN <?= $programa['nombre_programa'] ?>, MODALIDAD <?= $programa['modalidad'] ?>, VERSIÓN <?= $programa['numero_version'] ?>.pdf" title="Descargra Infograma del Programa (<?= $programa['infograma'] ?>})" target="_blank" href="<?= base_url('descargas_programa/' . $programa['infograma']) ?>" class="btn">
                                                        <i class="lni lni-download"></i> Descargar Infograma
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <object frameborder="0" height="600px" width="100%" data="<?= base_url('descargas_programa/' . $programa['infograma']) ?>" type="application/pdf">
                                            <div>No online PDF viewer installed</div>
                                        </object>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-lg-4 col-12">
                <div class="course-sidebar">
                    <div class="sidebar-widget">
                        <h3 class="sidebar-widget-title"><?= lang('global.buscar') ?></h3>
                        <div class="sidebar-widget-content">
                            <div class="sidebar-widget-search">
                                <form action="#">
                                    <input type="text" placeholder="<?= lang('global.buscar') ?>...">
                                    <button><i class="lni lni-search-alt"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="sidebar-widget other-course-wedget">
                        <h3 class="sidebar-widget-title">Programas Recientes</h3>
                        <div class="sidebar-widget-content">
                            <ul class="sidebar-widget-course">
                                <?php foreach ($programasRecientes as $key => $value) : ?>
                                    <li class="single-course">
                                        <div class="thumbnail">
                                            <a href="<?= route_to('App\Controllers\Oferta::detalle', $value['id_publicacion']) ?>" class="image"><img src="<?= base_url($value['url'] == null ? 'imagenes/afiches/courses-17.jpg' : 'imagenes/afiches/' . $value['url']) ?>" alt="Course Image"></a>
                                        </div>
                                        <div class="info">
                                            <span class="price">Bs. <?= $value['precio_programa'] ?></span>
                                            <h6 class="title"><a href="<?= route_to('App\Controllers\Oferta::detalle', $value['id_publicacion']) ?>"><?= ucwords(mb_convert_case($value['grado_academico'], MB_CASE_LOWER)) ?> en <?= ucwords(mb_convert_case($value['nombre_programa'], MB_CASE_LOWER)) ?></a></h6>
                                        </div>
                                    </li>
                                <?php endforeach ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v12.0&appId=2623774221243362&autoLogAppEvents=1" nonce="IfTSrdFO"></script>