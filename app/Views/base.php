<!DOCTYPE html>
<html class="no-js" lang="es">

<head>
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta content="text/html; charset=UTF-8" http-equiv="content-type">
    <title>Posgrado UPEA | Sitio Oficial</title>
    <link rel="shortcut icon" href="<?= base_url('edugrids/assets/images/favicon.ico'); ?>" type="image/x-icon" />
    <link rel="icon" type="image/png" href="<?= base_url('edugrids/assets/images/favicon.png'); ?>" />

    <meta name="keywords" content="posgrado,upea,postgrado,diplomado,especialidad,maestria,doctorado" />
    <meta name="author" content="POSGRADO Dev's" />
    <meta name="robots" content="robots.txt" />
    <meta name="description" content="FORMANDO PROFESIONALES A NIVEL NACIONAL" />
    <meta property="og:title" content="Posgrado UPEA - Diplomados, Maestrías, Doctorados" />
    <meta property="og:description" content="Formando profesionales a nivel nacional. #EstudiaPosgradoEnCasa" />
    <meta property="og:image" content="<?= base_url('edugrids/assets/images/favicon.png') ?>" />
    <meta name="format-detection" content="telephone=76296846">


    <link rel="stylesheet" href="<?= base_url('edugrids/assets/css/jquery.toast.css') ?>">
    <link rel="stylesheet" href="<?= base_url('edugrids/assets/css/raleway.css') ?>">
    <link rel="stylesheet" href="<?= base_url('edugrids/assets/css/bootstrap.min.css'); ?>" />
    <link rel="stylesheet" href="<?= base_url('edugrids/assets/css/LineIcons.2.0.css'); ?>" />
    <link rel="stylesheet" href="<?= base_url('edugrids/assets/css/animate.css'); ?>" />
    <link rel="stylesheet" href="<?= base_url('edugrids/assets/css/tiny-slider.css'); ?>" />
    <link rel="stylesheet" href="<?= base_url('edugrids/assets/css/glightbox.min.css'); ?>" />
    <link rel="stylesheet" href="<?= base_url('edugrids/assets/css/main' . IDSEDE . '.css'); ?>" />
    <link rel="stylesheet" href="<?= base_url('edugrids/assets/css/select2.min.css'); ?>" />
    <link rel="stylesheet" href="<?= base_url('edugrids/assets/css/sweetalert2.min.css'); ?>" />
    <link rel="stylesheet" href="<?= base_url('edugrids/assets/css/viewer.min.css'); ?>" />

    <link rel="stylesheet" href="<?= base_url('edugrids/assets/css/new.css'); ?>" />
    <link rel="stylesheet" href="<?= base_url('css/posgrado.css'); ?>" />
    <link rel="stylesheet" href="<?= base_url('css/oferta/jqcloud.min.css'); ?>" />
    <link rel="stylesheet" href="<?= base_url('css/oferta/tagify.css'); ?>" />
    <?php $js = str_replace('\\', '/', FCPATH . 'css/' . strtolower(explode('\\', (\Config\Services::router())->controllerName())[3]) . '/' . (\Config\Services::router())->methodName() . '.css');
    if (is_file($js)) : ?>
        <link rel="stylesheet" href="<?php echo base_url('css/' . strtolower(explode('\\', (\Config\Services::router())->controllerName())[3]) . '/' . (\Config\Services::router())->methodName() . '.css'); ?>">
    <?php endif; ?>
</head>

<body>
    <!--[if lte IE 9]>
      <p class="browserupgrade">
        Navegador <strong>OBSOLETO</strong>. Debe actualizar su navegador.
      </p>
    <![endif]-->

    <div class="preloader">
        <div class="preloader-inner">
            <div class="preloader-icon">
                <span></span>
                <span></span>
            </div>
        </div>
    </div>

    <?= $cabecera ?>

    <?= $contenido ?>

    <?= $pie ?>


    <a href="#" class="scroll-top btn-hover">
        <i class="lni lni-chevron-up"></i>
    </a>

    <script src="<?= base_url('edugrids/assets/js/jquery-3.6.0.js'); ?>"></script>
    <script src="<?= base_url('edugrids/assets/js/jquery.form.min.js'); ?>"></script>
    <script src="<?= base_url('edugrids/assets/js/jquery.expander.min.js'); ?>"></script>
    <script src="<?= base_url('edugrids/assets/js/jquery.validate.min.js'); ?>"></script>
    <script src="<?= base_url('edugrids/assets/js/jquery.toast.js'); ?>"></script>
    <script src="<?= base_url('edugrids/assets/js/bootstrap.min.js'); ?>"></script>
    <script src="<?= base_url('edugrids/assets/js/count-up.min.js'); ?>"></script>
    <script src="<?= base_url('edugrids/assets/js/wow.min.js'); ?>"></script>
    <script src="<?= base_url('edugrids/assets/js/tiny-slider.js'); ?>"></script>
    <script src="<?= base_url('edugrids/assets/js/glightbox.min.js'); ?>"></script>
    <script src="<?= base_url('edugrids/assets/js/jquery.inputmask.min.js'); ?>"></script>
    <script src="<?= base_url('edugrids/assets/js/select2.full.min.js'); ?>"></script>
    <script src="<?= base_url('edugrids/assets/js/sweetalert2.all.min.js'); ?>"></script>
    <script src="<?= base_url('edugrids/assets/js/viewer.min.js'); ?>"></script>
    <script src="<?= base_url('edugrids/assets/js/main.js'); ?>"></script>
    <script src="<?= base_url('js/oferta/tagify.min.js'); ?>"></script>
    <script src="<?= base_url('js/posgrado.js'); ?>"></script>
    <script src="<?= base_url('js/oferta/jqcloud.min.js'); ?>"></script>
    <?php $js = str_replace('\\', '/', FCPATH . 'js/' . strtolower(explode('\\', (\Config\Services::router())->controllerName())[3]) . '/' . (\Config\Services::router())->methodName() . '.js');
    if (is_file($js)) : ?>
        <script src="<?php echo base_url('js/' . strtolower(explode('\\', (\Config\Services::router())->controllerName())[3]) . '/' . (\Config\Services::router())->methodName() . '.js'); ?>"></script>
    <?php endif; ?>
    <script type="text/javascript">
        $(function() {
            "use strict";
            <?php foreach ((\Config\Services::session())->getFlashdata() as $kmsg => $msg) : ?>
                $.toast({
                    icon: `<?php echo ((is_numeric($kmsg) || empty($kmsg)) ? 'error' : $kmsg); ?>`,
                    heading: `<?php echo ((is_numeric($kmsg) || empty($kmsg)) ? 'ERROR [' . $kmsg . ']' : 'INFORMACIÓN'); ?>`,
                    text: `<?php echo $msg ?>`,
                    position: `top-right`,
                    showHideTransition: `plain`,
                    allowToastClose: true,
                    loaderBg: `#FFF`,
                    hideAfter: 5000,
                    stack: 5
                });
            <?php endforeach; ?>
        });
        if ($('.glightbox').length) {
            GLightbox({
                'href': 'https://youtu.be/A_QN1g3xgnM',
                'type': 'video',
                'source': 'youtube', //vimeo, youtube or local
                'width': 900,
                'autoplayVideos': true,
            });
        }
    </script>
</body>

</html>