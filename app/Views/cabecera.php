<header class="header navbar-area">
    <div class="toolbar-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-12">
                    <div class="toolbar-social">
                        <ul>
                            <li><span class="title"><?= lang('global.siguenosEn') ?></span></li>
                            <li><a target="_blank" href="https://www.facebook.com/estudiaenposgradoupea/"><i class="lni lni-facebook-original"></i></a></li>
                            <li><a target="_blank" href="https://twitter.com/posgradoupea"><i class="lni lni-twitter-original"></i></a></li>
                            <li><a target="_blank" href="https://www.linkedin.com/in/posgrado-upea-9324581a3/"><i class="lni lni-linkedin-original"></i></a></li>
                            <li><a target="_blank" href="https://www.instagram.com/posgrado_upea/"><i class="lni lni-instagram-original"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-12">
                <div class="nav-inner">
                    <nav class="navbar navbar-expand-lg">
                        <a class="navbar-brand" href="<?= base_url('inicio') ?>">
                            <img src="<?= base_url('edugrids/assets/images/logo/logo.png'); ?>" alt="POSGRADO UPEA">
                        </a>
                        <button class="navbar-toggler mobile-menu-btn" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="toggler-icon"></span>
                            <span class="toggler-icon"></span>
                            <span class="toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse sub-menu-bar" id="navbarSupportedContent">
                            <ul id="nav" class="navbar-nav ms-auto">
                                <li class="nav-item"><a class="active" href="<?= base_url('inicio') ?>"><?= lang('global.inicio') ?></a></li>
                                <li class="nav-item"><a class="" href="<?= base_url('oferta') ?>"><?= lang('global.programaVigentes') ?></a></li>
                                <li class="nav-item"><a class="page-scroll dd-menu collapsed" href="javascript:void(0)" data-bs-toggle="collapse" data-bs-target="#submenu-1-3" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">Institucional</a>
                                    <ul class="sub-menu collapse" id="submenu-1-3">
                                        <li class="nav-item"><a href="/inicio/mision_vision">Misión y Visión</a></li>
                                        <li class="nav-item"><a href="/inicio/organizacion">Organización</a></li>
                                    </ul>
                                </li>
                                <li class="nav-item"><a class="page-scroll dd-menu collapsed" href="javascript:void(0)" data-bs-toggle="collapse" data-bs-target="#submenu-1-3" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">Nuestros Eventos</a>
                                    <ul class="sub-menu collapse" id="submenu-1-3">
                                        <!--<li class="nav-item"><a href="/inicio/expocruz">FexpoCruz 2021</a></li>-->
                                        <li class="nav-item"><a href="/inicio/feicobol">FeicoBol 2021</a></li>
                                        <li class="nav-item"><a href="/inicio/fexpo_sucre">Fexpo Sucre 2022</a></li>
                                        <!--<li class="nav-item"><a href="#">Graduación II/2021</a></li>-->
                                    </ul>
                                </li>
                                <!-- <li class="nav-item"><a href="/inicio/testimonios"><?= lang('global.testimonios') ?></a></li> -->
                                <li class="nav-item"><a href="/informacion"><?= lang('global.informacion') ?></a></li>
                            </ul>
                            <!--<form class="d-flex search-form">
                                <input class="form-control me-2" type="search" placeholder="<?php // lang('global.buscar') 
                                                                                            ?>" aria-label="<?php // lang('global.buscar') 
                                                                                                            ?>">
                                <button class="btn btn-outline-success" type="submit"><i class="lni lni-search-alt"></i></button>
                            </form>-->
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>