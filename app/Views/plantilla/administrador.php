<?= $this->extend('plantilla/index') ?>

<?= $this->section('estilos') ?>
    <!-- DataTables -->
    <link rel="stylesheet" href="https://adminlte.io/themes/v3/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://adminlte.io/themes/v3/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="https://adminlte.io/themes/v3/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<?= $this->endSection() ?>

<?= $this->section('contenido') ?>
    <section id="recipe">
        <div class="container">
            <div class="row vertical-align">
                <div class="col-12">
                    <!-- Menu -->
                    <div class="col-md-3 pull-left">
                        <div class="recipe-info">
                            <h3>Menú</h3>
                            <div class="row">
                                <?php if ($_SESSION['RolAsignado'] == 'Administrador') { ?>
                                    <div class="col-12"><a href="<?=site_url('administrador/pagina')?>">Página</a></div>
                                    <div class="col-12"><a href="<?=site_url('usuario')?>">Usuarios</a></div>
                                <?php } ?>
                                <div class="col-12"><a href="<?=site_url('categoria')?>">Recetas</a></div>
                            </div>
                        </div>
                    </div>
                    <!-- Contenido Menu -->
                    <div class="col-md-9 pull-right">
                        <div class="recipe-info">
                            <?= $this->renderSection('contenidoMenu') ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
    <!-- DataTables & Plugins -->
    <script src="https://adminlte.io/themes/v3/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="https://adminlte.io/themes/v3/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://adminlte.io/themes/v3/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="https://adminlte.io/themes/v3/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="https://adminlte.io/themes/v3/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="https://adminlte.io/themes/v3/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="https://adminlte.io/themes/v3/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="https://adminlte.io/themes/v3/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="https://adminlte.io/themes/v3/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <?= $this->renderSection('scriptsAdmin') ?>
<?= $this->endSection() ?>