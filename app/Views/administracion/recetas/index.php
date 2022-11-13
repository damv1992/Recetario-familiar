<?= $this->extend('plantilla/administrador') ?>

<?= $this->section('estilos') ?>
    <title><?=$configuracion['NombrePagina'].' | '.$titulo?></title>
<?= $this->endSection() ?>

<?= $this->section('contenidoMenu') ?>
    <h3><?=$titulo?></h3>
    <input id="idCategoria" value="<?=$categoria['IdCategoria']?>" type="hidden">

    <a href="<?=site_url('receta/nuevo/'.$categoria['IdCategoria'])?>" class="btn btn-success form-group">Agregar receta</a>

    <table class="tablaRecetas table table-hover table-dark table-responsive-sm">
        <thead>
            <tr>
                <th>Receta</th>
                <th>Foto</th>
                <th style="width: 49%;">Acciones</th>
            </tr>
        </thead>
    </table>

    <a href="<?=site_url('administrador/recetas')?>" class="btn btn-info">
        <i class="fa fa-angle-double-left text-white"></i> Volver
    </a>
<?= $this->endSection() ?>

<?= $this->section('scriptsAdmin') ?>
    <script src="<?= base_url() ?>/RecipeBook/js/custom/recetas.js"></script>
<?= $this->endSection() ?>