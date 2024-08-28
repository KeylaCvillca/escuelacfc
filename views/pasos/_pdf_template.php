<?php

use app\controllers\BibliaController;
use yii\helpers\Html;
/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

?>


<div class="container">
    <div class="row logo">
        <?= Html::img("@web/imagenes/logopdf.png") ?>
        <div class="d-flex justify-content-center">
            <h1>"Escuela de Danza CFC"</h1>
        </div>

    </div>
    <div class="text-align-center">
        <h2><strong><?= $model->nombre ?></strong>Paso <?= $model->id ?> Nivel: <?= $model->color ?></h2>
        <p><?= BibliaController::getText($model->cita_biblica) ?></p>
        <h4><?= $model->cita_biblica ?></h4>
    </div>
    <div class="row">
        <h3>Descripción</h3>
        <p><?= $model->descripcion?></p>
    </div>
    <div class="row">
        <p><strong>Instrumentos<strong><?= $model->getInstrumentosNombres()?></p>
    </div>
    <div class="row" >
        <?= Html::img("@web/imagenes/pasos/" . $model->imagen) ?>
    </div>
    <div class="row">
        <p>Dirección: Calle Nueve Valles 3, Polígono de Candina. <?= date("d-m-Y") ?></p>
    </div>




</div>