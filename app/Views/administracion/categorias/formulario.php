<?= $this->extend('plantilla/administrador') ?>

<?= $this->section('estilos') ?>
    <title><?=$configuracion['NombrePagina'].' | '.$titulo?></title>
<?= $this->endSection() ?>

<?= $this->section('contenidoMenu') ?>
    <h3><?=$titulo?></h3>
    <input id="idCategoria" value="<?=$categoria['IdCategoria']?>" type="hidden">

    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text">Categoría</span>
        </div>
        <input type="text" class="form-control nombreCategoria" placeholder="Nombre de categoría" value="<?=$categoria['NombreCategoria']?>">
    </div>

    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text">Icono</span>
        </div>
        <input class="iconoCategoria form-control" type="file">
        <img id="verIconoCategoria" <?php if ($categoria['IconoCategoria']) { ?> src="<?=base_url().$categoria['IconoCategoria']?>" <?php } ?> height="35">
    </div>

    <div class="mensajeCategoria form-group"></div>
    <div class="form-group">
        <a href="<?=site_url('administrador/recetas')?>" class="btn btn-info pull-left"><i class="fa fa-arrow-left text-white"></i> Volver</a>
        <button class="btnGuardarCategoria btn btn-success pull-right"><i class="fa fa-save text-white"></i> Guardar</button>
    </div>
<?= $this->endSection() ?>

<?= $this->section('scriptsAdmin') ?>
    <script src="<?= base_url() ?>/RecipeBook/js/custom/categorias.js"></script>
<?= $this->endSection() ?>