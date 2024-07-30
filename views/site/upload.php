<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\UploadForm */

?>
<style>
form#w0 {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    margin-top: 5vh;
}

</style>


<?php $form = ActiveForm::begin([
    'options' => ['enctype' => 'multipart/form-data']
]) ?>
    <h1>Subir archivo</h1>
    <?= $form->field($model, 'file')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Subir', ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end() ?>
