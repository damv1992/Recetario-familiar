<?= $this->extend('plantilla/administrador') ?>

<?= $this->section('estilos') ?>
    <title><?=$configuracion['NombrePagina'].' | '.$titulo?></title>
<?= $this->endSection() ?>

<?= $this->section('contenidoMenu') ?>
    <h3><?=$titulo?></h3>
    <input id="receta" value="<?=$receta['IdReceta']?>" type="hidden">
    <input id="ingrediente" value="<?=$ingrediente['IdIngrediente']?>" type="hidden">

    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text">Ingrediente</span>
        </div>
        <input class="nombre form-control" value="<?=$ingrediente['NombreIngrediente']?>" type="text">
    </div>

    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text">Cantidad</span>
        </div>
        <input class="cantidad form-control" value="<?=$ingrediente['Cantidad']?>" type="number">
        <select class="medida custom-select">
            <option value="">Seleccionar unidad de medida</option>
            <option value="unidad" <?php if ($ingrediente['UnidadMedida'] == 'unidad') { ?> selected<?php } ?>>unidad(es)</option>
            <option value="taza" <?php if ($ingrediente['UnidadMedida'] == 'taza') { ?> selected<?php } ?>>taza(s)</option>
            <option value="cuchara" <?php if ($ingrediente['UnidadMedida'] == 'cuchara') { ?> selected<?php } ?>>cuchara(s)</option>
            <option value="cucharilla" <?php if ($ingrediente['UnidadMedida'] == 'cucharilla') { ?> selected<?php } ?>>cucharilla(s)</option>
            <option value="gramo" <?php if ($ingrediente['UnidadMedida'] == 'gramo') { ?> selected<?php } ?>>gramo(s)</option>
            <option value="kilogramo" <?php if ($ingrediente['UnidadMedida'] == 'kilogramo') { ?> selected<?php } ?>>kilogramo(s)</option>
            <option value="mililitro" <?php if ($ingrediente['UnidadMedida'] == 'mililitro') { ?> selected<?php } ?>>mililitro(s)</option>
            <option value="litro" <?php if ($ingrediente['UnidadMedida'] == 'litro') { ?> selected<?php } ?>>litro(s)</option>
        </select>
    </div>

    <div class="form-group">
        <a href="<?=site_url('receta/ingredientes/'.$receta['IdReceta'])?>" class="btn btn-info pull-left"><i class="fa fa-arrow-left text-white"></i> Volver</a>
        <button class="btnGuardar btn btn-success pull-right"><i class="fa fa-save text-white"></i> Guardar</button>
    </div>
<?= $this->endSection() ?>

<?= $this->section('scriptsAdmin') ?>
    <script src="<?= base_url() ?>/RecipeBook/js/custom/ingredientes.js"></script>
<?= $this->endSection() ?>