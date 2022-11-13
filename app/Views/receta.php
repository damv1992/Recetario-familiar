<?php
    /*use App\Models\GenerosProductoModel;
    use App\Models\GenerosModel;
    use App\Models\PlataformaModel;

    $generosProductos = new GenerosProductoModel();
    $generos = new GenerosModel();
    $plataformass = new PlataformaModel();*/
?>
<?= $this->extend('plantilla/index') ?>

<?= $this->section('estilos') ?>
    <title><?=$configuracion['NombrePagina'].' | '.$titulo?></title>
<?= $this->endSection() ?>

<?= $this->section('contenido') ?>
    <!-- Recipe Section -->
    <section id="recipe">
        <div class="container">
            <div class="row">
                <!-- Title -->
                <div class="col-12">
                    <h2><?=$receta['NombreReceta']?></h2>
                </div>
            </div>
            <div class="row vertical-align">
                <div class="col-12">
                    <!-- Picture -->
                    <div class="col-md-8 pull-left wow swing">
                        <img src="<?=base_url().$receta['FotoReceta']?>" alt="<?=$receta['NombreReceta']?>" class="recipe-picture" />
                    </div>
                    <!-- Info -->
                    <div class="col-md-4 pull-right wow lightSpeedIn">
                        <div class="recipe-info">
                            <h3>Información</h3>
                            <!-- Time -->
                            <div class="row">
                                <div class="col-2 text-center">
                                    <i class="fa fa-clock-o" aria-hidden="true"></i>
                                </div>
                                <div class="col-6">Tiempo (H:m:s)</div>
                                <div class="col-4"><?=$receta['Tiempo']?></div>
                            </div>
                            <!-- Difficulty -->
                            <div class="row">
                                <div class="col-2 text-center">
                                    <i class="fa fa-area-chart" aria-hidden="true"></i>
                                </div>
                                <div class="col-6">Dificultad</div>
                                <div class="col-4">
                                    <?php for ($i = 0; $i < $receta['Dificultad']; $i++) { ?>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                    <?php } ?>
                                </div>
                            </div>
                            <!-- Serves -->
                            <div class="row">
                                <div class="col-2 text-center">
                                    <i class="fa fa-users" aria-hidden="true"></i>
                                </div>
                                <div class="col-6">Porciones</div>
                                <div class="col-4"><?=$receta['Porciones']?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Ingredients -->
            <div class="row wow slideInUp">
                <div class="col-12">
                    <div class="recipe-ingredients">
                        <h3>Ingredientes</h3>
                        <dl class="ingredients-list">
                            <?php foreach ($ingredientes as $ingrediente) { ?>
                                <dt style="width: 30%;"><?=$ingrediente['Cantidad'].' '.$ingrediente['UnidadMedida']?></dt>
                                <dd style="width: 70%;"><?=$ingrediente['NombreIngrediente']?></dd>
                            <?php } ?>
                        </dl>
                    </div>
                </div>
            </div>
            <!-- Directions -->
            <div class="row wow slideInUp">
                <div class="col-12">
                    <div class="recipe-directions">
                        <h3>Preparación</h3>
                        <ol>
                            <?php foreach ($preparaciones as $preparacion) { ?>
                                <li><?=$preparacion['DescripcionPaso']?></li>
                            <?php } ?>
                        </ol>
                    </div>
                </div>
            </div>
            <!-- Back to recipes -->
            <div class="row wow rollIn">
                <div class="col-12 text-center">
                    <a href="<?=base_url()?>">
                        <i class="fa fa-backward" aria-hidden="true"></i>
                        Volver a recetas.
                    </a>
                </div>
            </div>
        </div>
    </section>
<?= $this->endSection() ?>