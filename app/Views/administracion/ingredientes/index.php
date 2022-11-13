<?= $this->extend('plantilla/administrador') ?>

<?= $this->section('estilos') ?>
    <title><?=$configuracion['NombrePagina'].' | '.$titulo?></title>
<?= $this->endSection() ?>

<?= $this->section('contenidoMenu') ?>
    <h3><?=$titulo?></h3>
    <input id="receta" value="<?=$receta['IdReceta']?>" type="hidden">

    <a href="<?=site_url('ingrediente/nuevo/'.$receta['IdReceta'])?>" class="btn btn-success form-group">Agregar ingrediente</a>

    <table class="tabla table table-hover table-dark table-responsive-sm">
        <thead>
            <tr>
                <th>Ingrediente</th>
                <th style="width: 1%;">Cantidad</th>
                <th style="width: 1%;">Acciones</th>
            </tr>
        </thead>
    </table>

    <a href="<?=site_url('categoria/recetas/'.$receta['IdReceta'])?>" class="btn btn-info">
        <i class="fa fa-angle-double-left text-white"></i> Volver
    </a>
<?= $this->endSection() ?>

<?= $this->section('scriptsAdmin') ?>
    <script src="<?= base_url() ?>/RecipeBook/js/custom/ingredientes.js"></script>
<?= $this->endSection() ?>