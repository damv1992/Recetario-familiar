<?= $this->extend('plantilla/index') ?>

<?= $this->section('estilos') ?>
    <title><?=$configuracion['NombrePagina'].' | '.$titulo?></title>
<?= $this->endSection() ?>

<?= $this->section('contenido') ?>
    <section id="recipe">
        <div class="container">
            <form>
                <h3 class="text-center"><?=$titulo?></h3>

                <div class="form-group row wow">
                    <div class="col-12 text-center">
                        <input class="txtUsuario" type="text" placeholder="Usuario">
                    </div>
                </div>
                
                <div class="form-group row wow">
                    <div class="col-12 text-center">
                        <input class="txtContraseña" type="password" placeholder="Contraseña">
                    </div>
                </div>
                
                <div class="form-group row wow">
                    <div class="col-12 text-center">
                        <button class="btnIniciarSesion btn btn-success" type="submit">Iniciar Sesión</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
    <script src="<?= base_url() ?>/RecipeBook/js/custom/usuario.js"></script>
<?= $this->endSection() ?>