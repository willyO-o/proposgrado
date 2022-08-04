<section id="contact-us" class="contact-us section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-12 col-12">
                <div class="form-main">
                    <h3 class="title"><span>List@ para comenzar?</span>
                        Solicitar Informacion
                        <?php if ($programa) : ?>
                            para 
                           <?= $programa ?>
                        <?php endif ?>

                        <span>los campos con <b class="text-danger font-weight-bold">*</b> son requeridos</span>
                    </h3>

                    <form id="form-informacion" method="post" action="">
                        <div class="row">
                            <?php if (is_null($id_publicacion)) : ?>
                                <div class=" col-lg-12">
                                    <div class="form-group">
                                        <label for="area_interes">Area de Interes <span class="text-danger">*</span></label>
                                        <select name="area_interes" id="area_interes" class="form-select" required>
                                            <option value="">
                                                <- Seleccione ->
                                            </option>
                                            <?php foreach ($areas as $area) : ?>

                                                <option value="<?= $area['id_area']    ?>">
                                                    <?= $area['nombre_area']    ?>
                                                </option>

                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                            <?php endif ?>


                            <div class=" col-12">
                                <div class="form-group">
                                    <label for="nombre_persona">Tu Nombre completo <span class="text-danger">*</span></label>
                                    <input name="nombre_persona" id="nombre_persona" type="text" placeholder="" required="required" oninput="javascript:this.value=this.value.toUpperCase();">
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="celular">Tu número de Celular <span class="text-danger">*</span></label>
                                    <input name="celular" type="number" placeholder="" id="celular" required="required">
                                </div>
                            </div>

                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label>Tu Ciudad <span class="text-danger">*</span></label>
                                    <select name="ciudad" id="ciudad" class="" required >
                                        <option value="">
                                            <- Seleccione ->
                                        </option>
                                        <?php foreach ($ciudades as $ciudad) : ?>

                                            <option value="<?= $ciudad['nombre_ciudad']    ?>">
                                                <?= $ciudad['nombre_ciudad']    ?>
                                            </option>

                                        <?php endforeach ?>

                                    </select>
                                </div>
                            </div>


                            <div class="col-lg-12 col-12 mb-3" id="caja-correo">
                                <div class="form-check">
                                    <input type="checkbox" id="check-correo" class="form-check-input checkboxes width-auto btn-collapse">
                                    <label class="form-check-label btn-collapse" for="check-correo">Recibir Informacion a mi Correo</label>
                                </div>

                                <div class="collapse" id="mostrar-correo">
                                    <div class="form-group">
                                        <label>Tu correo electrónico</label>
                                        <input name="correo" type="email" placeholder="" id="correo">
                                    </div>
                                </div>

                            </div>


                            <div class="col-12">
                                <div class="form-group message">
                                    <label>Recibir Informacion sobre: <span class="text-danger">*</span></label>
                                    <div class="form-check">
                                        <input type="checkbox" id="check1" class="form-check-input checkboxes width-auto" name="informacion[]" value="Contenido" required>
                                        <label class="form-check-label" for="check1">Contenido</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" id="check2" class="form-check-input checkboxes width-auto" name="informacion[]" value="Precio">
                                        <label class="form-check-label" for="check2">Precio</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" id="check3" class="form-check-input checkboxes width-auto" name="informacion[]" value="Duracion">
                                        <label class="form-check-label" for="check3">Duraci&oacuten</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" id="check4" class="form-check-input checkboxes width-auto" name="informacion[]" value="Requisitos Minimos">
                                        <label class="form-check-label" for="check4">Requisitos Minimos</label>
                                    </div>

                                </div>
                            </div>

                            <div class="form-group">
                                <label for="otra_info">Otra Informacion <small>(opcional)</small></label>
                                <input class="" id="otra_info" name="otra_info" type="text">
                            </div>

                            <div class="row mb-4">
                                <div class="col-lg-6 col-12">
                                    <div class="form-group">
                                        <label>Captcha</label>
                                    </div>
                                    <div class="input-group">
                                        <input type="hidden" name="codigo_captcha" id="codigo_captcha" value="">

                                        <img src="" alt="" id="img_captcha">
                                        <input name="captcha" type="number" placeholder="" id="input_captcha" class="input-captcha" required="required">
                                    </div>
                                </div>

                            </div>



                            <input type="hidden" name="publicacion" id="publicacion" value="<?= $id_publicacion ?>">
                            <div class="col-12">
                                <div class="form-group button">
                                    <button type="submit" class="btn ">Solicitar Informacion</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-4 col-12">
                <div class="contact-info">

                    <div class="single-info">
                        <i class="lni lni-map-marker"></i>
                        <h4>Visite nuestra oficina</h4>
                        <p class="no-margin-bottom">Ciudad de El Alto, Zona Villa Esperanza,
                            <br> Av. Juan Pablo II, Edificio Emblemático,
                            <br> Piso 3 Alto, Bolivia.
                        </p>
                    </div>


                    <div class="single-info">
                        <i class="lni lni-phone"></i>
                        <h4>Hablemos</h4>
                        <p class="no-margin-bottom">Teléfono: 2-2844005
                            <br> Cel: 76296846
                        </p>
                    </div>


                    <div class="single-info">
                        <i class="lni lni-envelope"></i>
                        <h4>Envíenos un correo electrónico</h4>
                        <p class="no-margin-bottom">
                            <a href="/cdn-cgi/l/email-protection#f1989f979eb1889e8483959e9c90989fdf929e9c">
                                <span class="__cf_email__" data-cfemail="abc2c5cdc4ebd2c4ded9cfc4c6cac2c585c8c4c6"><a href="posgradoceforpiupea@gmail.com">posgradoceforpiupea@gmail.com</a></span>
                            </a>

                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

<div class="map-section">
    <div class="mapouter">
        <div class="gmap_canvas"><iframe width="100%" height="500" id="gmap_canvas" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3825.6857894120094!2d-68.19690749867836!3d-16.491440390943858!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x751eeb65e70b8c3b!2sPosgrado%20UPEA!5e0!3m2!1ses-419!2sbo!4v1632007611183!5m2!1ses-419!2sbo" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
        </div>
    </div>
</div>