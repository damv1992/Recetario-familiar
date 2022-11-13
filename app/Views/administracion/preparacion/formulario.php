<?= $this->extend('plantilla/administrador') ?>

<?= $this->section('estilos') ?>
    <title><?=$configuracion['NombrePagina'].' | '.$titulo?></title>
<?= $this->endSection() ?>

<?= $this->section('contenidoMenu') ?>
    <h3><?=$titulo?></h3>
    <input id="receta" value="<?=$receta['IdReceta']?>" type="hidden">
    <input id="preparacion" value="<?=$preparacion['IdPreparacion']?>" type="hidden">

    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text">Paso</span>
        </div>
        <input class="paso form-control" value="<?=$preparacion['PasoNumero']?>" type="number" placeholder="Paso número">
    </div>

    Descripción
    <textarea class="descripcion form-control" rows="10"><?=$preparacion['DescripcionPaso']?></textarea>
    <div class="form-group"></div>

    <div class="form-group">
        <a href="<?=site_url('receta/preparacion/'.$receta['IdReceta'])?>" class="btn btn-info pull-left"><i class="fa fa-arrow-left text-white"></i> Volver</a>
        <button class="btnGuardar btn btn-success pull-right"><i class="fa fa-save text-white"></i> Guardar</button>
    </div>
<?= $this->endSection() ?>

<?= $this->section('scriptsAdmin') ?>
    <script src="<?= base_url() ?>/RecipeBook/js/custom/preparaciones.js"></script>
<?= $this->endSection() ?>