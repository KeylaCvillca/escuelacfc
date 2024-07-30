<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $files array */

$this->title = 'Archivos';
?>
<div style="display: flex; justify-content:space-around; align-items:center">
    <div class="col-md-3"></div>
    <h1><?= Html::encode($this->title) ?></h1>
    <p><?= Html::a('Subir Archivo', ['upload'], ['class' => 'btn btn-primary', 'style' => 'margin-top:0.7vh']) ?></p>
    <div class="col-md-3"></div>
</div>
<div class="d-flex flex-wrap justify-content-evenly" style="margin-left: 15vw;margin-right:15vw">
    <?php foreach ($files as $file) : ?>
        <div class="card card-tarjeta-pasos">
            <div class="card-body d-flex flex-column justify-content-center align-items-center" style="border: 1px solid white;border-radius: 10%; margin:2%">
                <p><?= basename($file) ?></p>
                <p><?= Html::a('Ver', '#', [
                        'class' => 'btn btn-primary view-file-btn',
                        'data-filename' => basename($file),
                        'data-toggle' => 'modal',
                        'data-target' => '#fileModal'
                    ]) ?></p>
                <p><?= Html::a('<i class="fa-regular fa-trash-can"></i> ' . Yii::t('app', 'Eliminar'), ['delete-file', 'filename' => basename($file)], [
                        'class' => 'btn btn-primary',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this file?',
                            'method' => 'post',
                        ],
                    ]) ?></p>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<!-- Modal -->
<div class="modal fade" id="fileModal" tabindex="-1" role="dialog" aria-labelledby="fileModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="fileModalLabel">View File</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="fileModalBody">
                <!-- File content will be loaded here dynamically -->
            </div>
        </div>
    </div>
</div>

<?php
$this->registerJs("
    $('.view-file-btn').on('click', function() {
        var filename = $(this).data('filename');
        $.ajax({
            url: 'view-file',
            type: 'get',
            data: { filename: filename },
            success: function(data) {
                $('#fileModalBody').html(data);
            },
            error: function() {
                $('#fileModalBody').html('<p>Error loading file.</p>');
            }
        });
    });
");
?>
