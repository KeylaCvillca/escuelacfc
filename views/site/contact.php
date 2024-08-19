<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap4\ActiveForm $form */
/** @var app\models\ContactForm $model */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\captcha\Captcha;

$this->title = 'Contacto';
?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>

        <div class="alert alert-success">
            Gracias por contactar con nosotros. Responderemos a la mayor brevedad posible.
        </div>

        <p>
            
            <?php if (Yii::$app->mailer->useFileTransport): ?>
                Puedes ver el email resultante en:  <code><?= Yii::getAlias(Yii::$app->mailer->fileTransportPath) ?></code>.
            <?php endif; ?>
        </p>

    <?php else: ?>

        <p>
            Si tienes preguntas acerca de la inscripción, contacta con nosotros por medio de este formulario, o bien escríbenos un whatsapp.
        </p>

        <div class="row">
            <div class="col-lg-5">

                <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

                    <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

                    <?= $form->field($model, 'email') ?>

                    <?= $form->field($model, 'subject') ?>

                    <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>

                    <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                        'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                    ]) ?>

                    <div class="form-group">
                        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                    </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>

    <?php endif; ?>
    <div class="col-md-5">
        <!-- Incluir la vista parcial del mapa -->
        <?= $this->render('map') ?>
    </div>
    <div class="Whatsapp row">
        <h1 class="center">Contacta con nosotros</h1>
        <p>
            Puedes contactarnos directamente a través de WhatsApp haciendo clic en el siguiente enlace:
        </p>

        <p>
            <?= Html::a('Contáctanos por WhatsApp', 'https://api.whatsapp.com/send?phone=+34605594430&text=Hola%20me%20gustaria%20obtener%20informacion', ['class' => 'btn btn-success']) ?>
        </p>

    </div>
</div>
