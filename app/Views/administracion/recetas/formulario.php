<?= $this->extend('plantilla/administrador') ?>

<?= $this->section('estilos') ?>
    <title><?=$configuracion['NombrePagina'].' | '.$titulo?></title>
<?= $this->endSection() ?>

<?= $this->section('contenidoMenu') ?>
    <h3><?=$titulo?></h3>
    <input id="idCategoria" value="<?=$categoria['IdCategoria']?>" type="hidden">
    <input id="idReceta" value="<?=$receta['IdReceta']?>" type="hidden">

    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text"><?=rtrim($categoria['NombreCategoria'], "s")?></span>
        </div>
        <input type="text" class="form-control nombreReceta" value="<?=$receta['NombreReceta']?>">
    </div>

    <div class="input-group form-group">
        <p class="custom-file">
            <input class="fotoReceta custom-file-input" type="file">
            <label class="custom-file-label">Foto</label>
        </p>
    </div>
    <?php if ($receta['FotoReceta']) { ?><script>$('.verFotoReceta').show();</script><?php } ?>
    <img class="verFotoReceta form-group" <?php if ($receta['FotoReceta']) { ?> src="<?=base_url().$receta['FotoReceta']?>" height="350" <?php } ?>>

    <div class="input-group mb-3">
        <?php
        $horas = 0;
        $minutos = 0;
        $segundos = 0;
        if ($receta['Tiempo']) {
            $tiempo = strtotime($receta['Tiempo']);
            $horas = date("H", $tiempo);
            $minutos = date("i", $tiempo);
            $segundos = date("s", $tiempo);
        }
        ?>
        <div class="input-group-prepend">
            <span class="input-group-text">Tiempo de preparación</span>
        </div>
        <input class="horasReceta form-control" value=<?=$horas?> type="text" placeholder="Horas">
        <input class="minutosReceta form-control" value=<?=$minutos?> type="number" placeholder="Minutos">
        <input class="segundosReceta form-control" value=<?=$segundos?> type="number" placeholder="Segundos">
    </div>

    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text">Dificultad</span>
        </div>
        <select class="dificultadReceta custom-select">
            <option value="1" <?php if ($receta['Dificultad'] == 1) { ?> selected<?php } ?>>Muy fácil</option>
            <option value="2" <?php if ($receta['Dificultad'] == 2) { ?> selected<?php } ?>>Fácil</option>
            <option value="3" <?php if ($receta['Dificultad'] == 3) { ?> selected<?php } ?>>Intermedio</option>
            <option value="4" <?php if ($receta['Dificultad'] == 4) { ?> selected<?php } ?>>Difícil</option>
            <option value="5" <?php if ($receta['Dificultad'] == 5) { ?> selected<?php } ?>>Muy difícil</option>
        </select>
    </div>

    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text">Porciones</span>
        </div>
        <input class="porcionesReceta form-control" value="<?=$receta['Porciones']?>" type="number">
    </div>

    <div class="form-group">
        <a href="<?=site_url('categoria/recetas/'.$categoria['IdCategoria'])?>" class="btn btn-info pull-left"><i class="fa fa-arrow-left text-white"></i> Volver</a>
        <button class="btnGuardarReceta btn btn-success pull-right"><i class="fa fa-save text-white"></i> Guardar</button>
    </div>
<?= $this->endSection() ?>

<?= $this->section('scriptsAdmin') ?>
    <script src="<?= base_url() ?>/RecipeBook/js/custom/recetas.js"></script>
<?= $this->endSection() ?>