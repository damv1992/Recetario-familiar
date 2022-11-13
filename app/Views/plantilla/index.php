<!DOCTYPE html>
<html lang="es">
    <head>
        <input type="hidden" class="site_url" value="<?=site_url()?>">
        <!-- Basic meta info -->
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="icon" type="image/png" href="<?=base_url().$configuracion['IconoPagina']?>" />

        <!-- CSS files -->
        <link rel="stylesheet" type="text/css" href="<?=base_url()?>/RecipeBook/css/reset.css" />
        <link rel="stylesheet" type="text/css" href="<?=base_url()?>/RecipeBook/css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="<?=base_url()?>/RecipeBook/css/font-awesome.min.css" />
        <link rel="stylesheet" type="text/css" href="<?=base_url()?>/RecipeBook/css/animate.min.css" />
        <link rel="stylesheet" type="text/css" href="<?=base_url()?>/RecipeBook/css/styles.css" />
        <?= $this->renderSection('estilos') ?>
        
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <!-- Modernizr file -->
        <script charset="utf-8" type="text/javascript " src="<?=base_url()?>/RecipeBook/js/modernizr.custom.js"></script>
    </head>

    <body>
        <!-- Splash Screen -->
        <div id="splash"></div>

        <!-- Website Logo -->
        <section id="logo">
            <a href="<?=base_url()?>">
                <div class="container text-center wow pulse">
                    <img src="<?=base_url().$configuracion['LogoPagina']?>" alt="logo" />
                    <br />
                    <h1><?=$configuracion['NombrePagina']?></h1>
                </div>
            </a>
        </section>

        <?= $this->renderSection('contenido') ?>

        <!-- Website Footer -->
        <footer>
            <div class="container">
                <div class="row">
                    <!-- About -->
                    <div class="col-md-12 col-sm-12 text-center">
                        <h3>Acerca</h3>
                        <div class="footer-about">
                            <?=$configuracion['SobreNosotros']?>
                            Desarrollado por <a href="https://wa.me/59173354006">Daniel Alejandro Miranda Villalta</a>
                        </div>
                        <p><a href="<?=site_url('administrador')?>">Administrar sitio</a></p>
                        <?php if ($_SESSION['Usuario']) { ?>
                            <p><a href="<?=site_url('usuario/logout')?>">Desconectar</a></p>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </footer>

        <!-- JavaScript files -->
        <script charset="utf-8" src="<?=base_url()?>/RecipeBook/js/jquery-3.3.1.min.js"></script>
        <script charset="utf-8" src="<?=base_url()?>/RecipeBook/js/bootstrap.min.js"></script>
        <script charset="utf-8" src="<?=base_url()?>/RecipeBook/js/wow.min.js"></script>
        <script charset="utf-8" src="<?=base_url()?>/RecipeBook/js/scripts.js"></script>
        <?= $this->renderSection('scripts') ?>
    </body>

</html>