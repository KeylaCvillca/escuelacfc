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
        <h3>Patrón <?= $model->codigo ?></h3>
        <h2><?= $model->nombre ?></h2>
        <h4>Instrumento: <?= $model->getInstrumento() ?></h4>
        <p>"<?= BibliaController::getVersiculo($model->cita_biblica) ?>"</p>
        <h4><?= $model->cita_biblica ?></h4>
    </div>
    <div class="row" style="background-color: #a469a8">
        <?= Html::img("@web/imagenes/" . $model->imagen) ?>
    </div>
    <div class="row">
        <p>Dirección: Calle Nueve Valles 3, Polígono de Candina.</p>
        <p><?= date("d-m-Y") ?></p>
    </div>




</div>