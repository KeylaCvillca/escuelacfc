<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use yii\captcha\Captcha;

/** @var yii\web\View $this */

$this->title = 'My Yii Application';
?>
<div id="inicio" class="site-index">

    <div class="jumbotron text-center bg-transparent" style="height: 100vh; background-image: url('<?= Yii::getAlias('@web/imagenes/banner.png') ?>'); background-size: cover; background-position: center; display: flex; justify-content: center; align-items: center;">
        <div style="background-color: rgba(0, 0, 0, 0.5); padding: 20px; border-radius: 10px;">
            <h1 class="display-4 text-white">Escuela de Danza</h1>
            <p class="lead text-white">Centro Familiar Cristiano Santander</p>
        </div>
    </div>

    
    <div class="body-content">
        <div class="jumbotron d-flex justify-content-center bg-transparent pb-2">
            <h2 id="instrumentos"> Instrumentos</h2>
        </div>

        <div class="row">
            <?php foreach ($instrumentos as $instrumento): ?>
                <div class="col-lg-3">
                    <div class="card" style="height:400px; background-image: url('<?= Yii::getAlias('@web/imagenes/instrumentos/' . $instrumento->nombre . ".jpg") ?>'); background-size: cover; background-position: center; transition: transform 0.3s;">
                        <div class="card-body d-flex flex-column justify-content-end" style="background-color: rgba(255, 255, 255, 0.65);">
                            <h2 class="card-title"><?= Html::encode($instrumento->nombre) ?></h2>
                            <p><a class="btn btn-outline-secondary" href="<?= Url::to(['instrumentos/view', 'id' => $instrumento->id]) ?>">Ver detalles &raquo;</a></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
    
    <div class="noticias-read container mt-4">

    <h2 id="noticias" class="mb-4 text-center">Noticias</h2>

    <?php foreach ($noticias as $noticia): ?>
    <div class="row mb-3 news-item">
        <div class="col-md-8">
            <h3><?= Html::encode($noticia->titulo) ?></h3>
            <p class="text-muted">
                Autor: <?= Html::encode($noticia->autorNombreApellidos) ?>
            </p>
            <p style="text-align: justify;">
                <?= nl2br(Html::encode($noticia->contenido)) ?>
            </p>
        </div>
        <div class="col-md-4 text-right">
            <p class="text-muted">
                Fecha de publicación: <?= $noticia->getFechaFormateada() ?>
            </p>
        </div>
    </div>
<?php endforeach; ?>
</div>
    
<div class="container quienes-somos">
    <div class="title-somos d-flex justify-content-center flex-column align-items-center">
        <h2 id="about" class="mb-4 mt-5">¿Quiénes somos?</h2>
        <p>Somos Danza CFC , una escuela de danza cristiana dedicada a glorificar a Dios a través del arte del baile.
            Fundada con la pasión de integrar la fe y la expresión artística, nuestra institución se centra en proporcionar
            una formación de danza que no solo busca la excelencia técnica, sino que también fomenta el crecimiento espiritual
            y el desarrollo del carácter cristiano.<br>
            En Danza CFC, creemos que cada movimiento es una oportunidad para adorar y honrar a Dios. Nuestros programas están
            diseñados para todos los niveles y edades, desde principiantes hasta avanzados, ofreciendo una variedad de estilos
            de danza que incluyen danza con pandero, danza hebrea y profética, siempre con un enfoque en principios y valores cristianos.<br>
            Nuestro equipo está compuesto por instructores altamente calificados y apasionados, quienes no solo son expertos en su campo,
            sino también mentores comprometidos con el bienestar y crecimiento integral de nuestros estudiantes. Nos esforzamos por
            crear un ambiente de apoyo y amor, donde cada estudiante se sienta valorado y motivado a alcanzar su máximo potencial.<br>
            En Danza CFC, nuestra comunidad es una extensión de nuestra fe. Organizamos eventos, presentaciones y proyectos de servicio
            que permiten a nuestros estudiantes utilizar sus talentos para impactar positivamente a la comunidad y compartir el mensaje
            de esperanza y amor de Cristo.<br>
            Únete a nosotros en Danza CFC, donde la danza y la fe se unen para crear algo verdaderamente hermoso y
            significativo.
        </p>
    </div>

    <!-- VISIÓN Y MISIÓN POSIBLE -->
    <div class="row">
        <div class="col-6 d-flex align-items-center flex-column">
            <h3>Visión</h3>
            <p>"Ser una comunidad de fe donde la danza se convierte en una expresión viva de la adoración a Dios, inspirando y
                transformando vidas a través del arte y el compromiso cristiano. Aspiramos a ser un faro de luz y esperanza,
                promoviendo la excelencia en la danza mientras cultivamos valores de amor, fe y servicio en cada estudiante."
            </p>
        </div>
        <div class="col-6 d-flex align-items-center flex-column">
            <h3>Misión</h3>
            <p>"Nuestra misión es glorificar a Dios y edificar Su reino a través de la enseñanza de la danza. Nos dedicamos
                a proporcionar una formación integral que combina la excelencia técnica con el desarrollo espiritual.
                Fomentamos un ambiente donde los estudiantes pueden crecer en su fe, descubrir sus talentos dados por Dios
                y usar sus habilidades para impactar positivamente a la comunidad y el mundo. Nos comprometemos a inculcar
                valores cristianos, promoviendo el respeto, la humildad y el amor en todas nuestras actividades."
            </p>
        </div>
    </div>

    <div class="row">
    <!-- Tarjeta Directora -->
    <div class="col-lg-4">
        <div class="card" style="height:400px; background-image: url('<?= Yii::getAlias('@web/imagenes/Directora.jpg') ?>'); background-size: cover; background-position: center; transition: transform 0.3s;">
            <div class="card-body d-flex flex-column justify-content-end" style="background-color: rgba(255, 255, 255, 0.65);">
                <h5 class="card-title text-center">Directora</h5>
                <p class="card-text text-center">Fidelina Hamilton</p>
            </div>
        </div>
    </div>

    <!-- Tarjeta Líder -->
    <div class="col-lg-4">
        <div class="card" style="height:400px; background-image: url('<?= Yii::getAlias('@web/imagenes/Lider.jpg') ?>'); background-size: cover; background-position: center; transition: transform 0.3s;">
            <div class="card-body d-flex flex-column justify-content-end" style="background-color: rgba(255, 255, 255, 0.65);">
                <h5 class="card-title text-center">Líder</h5>
                <p class="card-text text-center">Helena Canty</p>
            </div>
        </div>
    </div>

    <!-- Tarjeta Secretaria -->
    <div class="col-lg-4">
        <div class="card" style="height:400px; background-image: url('<?= Yii::getAlias('@web/imagenes/Secretaria.jpg') ?>'); background-size: cover; background-position: center; transition: transform 0.3s;">
            <div class="card-body d-flex flex-column justify-content-end" style="background-color: rgba(255, 255, 255, 0.65);">
                <h5 class="card-title text-center">Secretaria</h5>
                <p class="card-text text-center">Keyla Mccue</p>
            </div>
        </div>
    </div>
</div>

</div> 
<div class="site-contact">
    <h1 id="contact">Contacto</h1>
    <?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>

        <div class="alert alert-success">
            Gracias por contactar con nosotros. Responderemos a la mayor brevedad posible.
        </div>

        <p>
            <?php if (Yii::$app->mailer->useFileTransport): ?>
                Puedes ver el email resultante en: <code><?= Yii::getAlias(Yii::$app->mailer->fileTransportPath) ?></code>.
            <?php endif; ?>
        </p>

    <?php else: ?>

        <p>
            Si tienes preguntas acerca de la inscripción, contacta con nosotros por medio de este formulario, o bien escríbenos un whatsapp.
        </p>

        <div class="row">
            <!-- Columna izquierda para el formulario -->
            <div class="col-lg-6 col-md-6">
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

            <!-- Columna derecha para el mapa y el botón de WhatsApp -->
            <div class="col-lg-6 col-md-6">
                <!-- Mapa -->
                <?= $this->render('map') ?>

                <!-- Botón de WhatsApp -->
                <div class="Whatsapp">
                    <p>Puedes contactarnos directamente a través de WhatsApp haciendo clic en el siguiente enlace:</p>
                    <p>
                        <?= Html::a('Contáctanos por WhatsApp', 'https://api.whatsapp.com/send?phone=+34605594430&text=Hola%20me%20gustaria%20obtener%20informacion', ['class' => 'btn btn-success']) ?>
                    </p>
                </div>
            </div>
        </div>

    <?php endif; ?>
</div>

<?php
// Añadimos los estilos de hover al final del archivo para hacer que las tarjetas se agranden al pasar el ratón
$this->registerCss("
    .card:hover {
        transform: scale(1.05);
    }
");
?>