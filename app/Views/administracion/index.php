<?= $this->extend('plantilla/administrador') ?>

<?= $this->section('estilos') ?>
    <title><?=$configuracion['NombrePagina'].' | '.$titulo?></title>
<?= $this->endSection() ?>

<?= $this->section('contenidoMenu') ?>
    <h3>Seleccione una opción del menú</h3>
<?= $this->endSection() ?>