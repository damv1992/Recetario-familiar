<?= $this->extend('plantilla/administrador') ?>

<?= $this->section('estilos') ?>
    <title><?=$configuracion['NombrePagina'].' | '.$titulo?></title>
<?= $this->endSection() ?>

<?= $this->section('contenidoMenu') ?>
    <h3><?=$titulo?></h3>

    <a href="<?=site_url('categoria/nuevo')?>" class="btn btn-success form-group">Nueva categoría</a>

    <table class="tablaCategorias table table-hover table-dark table-responsive-sm">
        <thead>
            <tr>
                <th>Categoría</th>
                <th style="width: 1%;">Icono</th>
                <th style="width: 30%;">Acciones</th>
            </tr>
        </thead>
    </table>

    <a href="<?=site_url('administrador')?>" class="btn btn-info">
        <i class="fa fa-angle-double-left text-white"></i> Volver
    </a>
<?= $this->endSection() ?>

<?= $this->section('scriptsAdmin') ?>
    <script src="<?= base_url() ?>/RecipeBook/js/custom/categorias.js"></script>
<?= $this->endSection() ?>