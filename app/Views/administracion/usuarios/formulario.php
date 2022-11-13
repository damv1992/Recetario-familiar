<?= $this->extend('plantilla/administrador') ?>

<?= $this->section('estilos') ?>
    <title><?=$configuracion['NombrePagina'].' | '.$titulo?></title>
<?= $this->endSection() ?>

<?= $this->section('contenidoMenu') ?>
    <h3><?=$titulo?></h3>
    <input id="idUsuario" value="<?=$usuario['IdUsuario']?>" type="hidden">

    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text">Nombre Completo</span>
        </div>
        <input type="text" class="form-control nombre" placeholder="Nombre completo" value="<?=$usuario['NombreCompleto']?>">
    </div>

    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text">Usuario</span>
        </div>
        <input type="text" class="form-control usuario" placeholder="Usuario" value="<?=$usuario['Usuario']?>">
    </div>

    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text">Contraseña</span>
        </div>
        <input type="password" class="form-control contraseña" placeholder="Contraseña" value="<?=$usuario['Contraseña']?>">
    </div>

    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text">Rol</span>
        </div>
        <select class="form-control rol">
            <option value="Editor" <?php if ($usuario['RolAsignado'] == 'Editor') { ?> selected<?php } ?>>
                Editor</option>
            <option value="Administrador" <?php if ($usuario['RolAsignado'] == 'Administrador') { ?> selected<?php } ?>>
                Administrador</option>
        </select>
    </div>

    <div class="mensajeUsuario form-group"></div>
    <div class="form-group">
        <a href="<?=site_url('usuario')?>" class="btn btn-info pull-left"><i class="fa fa-arrow-left text-white"></i> Volver</a>
        <button class="btnGuardarUsuario btn btn-success pull-right"><i class="fa fa-save text-white"></i> Guardar</button>
    </div>
<?= $this->endSection() ?>

<?= $this->section('scriptsAdmin') ?>
    <script src="<?= base_url() ?>/RecipeBook/js/custom/usuario.js"></script>
<?= $this->endSection() ?>