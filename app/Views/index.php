<?= $this->extend('plantilla/index') ?>

<?= $this->section('estilos') ?>
<title><?=$configuracion['NombrePagina'].' | '.$titulo?></title>
<?= $this->endSection() ?>

<?= $this->section('contenido') ?>
<!-- Atajos Entel -->
<section id="items">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>Entel</h2>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-12">
                <a href="tel:*105%23" class="btn btn-info form-control">Consulta saldo</a>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-6">
                <a href="tel:*133%23" class="btn btn-info form-control">Consulta saldo de proveedor</a>
            </div>
            <div class="col-6">
                <a href="tel:*10*3%23" class="btn btn-warning form-control">Día Entel</a>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-6">
                <input class="telefono form-control" type="number" placeholder="Número móvil (12345678)" required>
            </div>

            <div class="col-6">
                <input class="monto form-control" type="number" placeholder="Monto en Bs." required>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-6">
                <button class="btnRecarga btn btn-primary form-control">Recarga</button>
            </div>
            
            <div class="col-6">
                <button class="btnTransferencia btn btn-primary form-control">Transferencia</button>
            </div>
        </div>
    </div>
</section>

<!-- Recipes Categories -->
<section id="categories">
    <div class="container botonesFiltroRecetas"></div>

    <div class="form-group"></div>

    <div class="container">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fa fa-search"></i></span>
            </div>
            <input class="form-control txtBusqueda" onkeyup="filtrarRecetas();" placeholder="Buscar...">
        </div>
    </div>
</section>

<!-- Recipes Items -->
<section id="items">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>Recetas</h2>
            </div>
        </div>
        <div class="row resultadosFiltroRecetas"></div>
        <div class="paginasFiltroRecetas"></div>
    </div>
</section>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="<?= base_url() ?>/RecipeBook/js/custom/filtro.js"></script>
<script>
    $('.btnRecarga').click(function () {
        let telefono = $('.telefono').val();
        let monto = $('.monto').val();
        if ((telefono === '') || (monto === '')) alert();
        location.href = 'tel:*133*' + telefono + '*' + monto + '%23';
    });
    $('.btnTransferencia').click(function () {
        let telefono = $('.telefono').val();
        let monto = $('.monto').val();
        if ((telefono === '') || (monto === '')) alert();
        location.href = 'tel:*222*2*' + telefono + '*' + monto + '%23';
    });
</script>
<?= $this->endSection() ?>