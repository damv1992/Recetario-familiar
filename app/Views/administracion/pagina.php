<?= $this->extend('plantilla/administrador') ?>

<?= $this->section('estilos') ?>
    <title><?=$configuracion['NombrePagina'].' | '.$titulo?></title>
<?= $this->endSection() ?>

<?= $this->section('contenidoMenu') ?>
    <h3><?=$titulo?></h3>

    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text">Nombre</span>
        </div>
        <input type="text" class="form-control nombrePagina" placeholder="Nombre de la página" value="<?=$configuracion['NombrePagina']?>">
    </div>

    <div class="input-group form-group">
        <p class="custom-file">
            <input class="logoPagina custom-file-input" type="file">
            <label class="custom-file-label">Logo</label>
        </p>
        <div class="input-group-prepend">
            <img id="verLogo" <?php if ($configuracion['LogoPagina']) { ?> src="<?=base_url().$configuracion['LogoPagina']?>" <?php } ?> height="35">
        </div>
    </div>

    <div class="input-group form-group">
        <p class="custom-file">
            <input class="iconoPagina custom-file-input" type="file">
            <label class="custom-file-label">Icono</label>
        </p>
            <img id="verIcono" <?php if ($configuracion['IconoPagina']) { ?> src="<?=base_url().$configuracion['IconoPagina']?>" <?php } ?> height="35">
    </div>

    Sobre Nosotros
    <textarea id="sobrePagina" class="sobrePagina form-control" rows="10"><?=$configuracion['SobreNosotros']?></textarea>

    <div class="mensajeConfiguracion form-group"></div>
    <div class="form-group">
        <a href="<?=site_url('administrador')?>" class="btn btn-info pull-left"><i class="fa fa-arrow-left text-white"></i> Volver</a>
        <button class="btnGuardarConfiguracion btn btn-success pull-right"><i class="fa fa-save text-white"></i> Guardar</button>
    </div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
    <script src="<?= base_url() ?>/RecipeBook/js/custom/pagina.js"></script>
<?= $this->endSection() ?>