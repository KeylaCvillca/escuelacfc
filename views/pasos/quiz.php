<?php

use yii\helpers\Html;
?>

<div class="slide intro quiz w-100">
    <h2 class="title-quiz mb-4">¿Preparado para comprobar tus conocimientos?</h2>
    <button class="btn btn-primary" onclick="startQuiz()">¡Vamos allá!</button>
</div>

<?php for ($i = 0; $i < 4; $i++) : ?>
    <div class="slide pregunta" id="question-<?= $i ?>" style="display:none">
        <h2>¿Qué paso es este?</h2>
        <?= Html::img($answers[$i]->getImgUrl(), ["class" => "imagen_paso img-quiz img-fluid"]) ?>
        <script>console.log(<?= "\"" . $answers[$i]->nombre . "\""?>)</script>
        <div class="d-flex botones-quiz justify-content-evenly">
            <?php foreach ($questions[$i] as $j => $question) : ?>
                <button id="ans<?= $i . $j ?>" class="btn btn-primary" onclick="checkAnswer(<?= $i ?>, <?= $j ?>)">
                    <?= Html::encode($question->nombre) ?>
                </button>
            <?php endforeach; ?>
        </div>
    </div>
<?php endfor; ?>

<div class="slide resultado" style="display:none">
    <h2 id="resultado" class="mb-4" >RESULTADO</h2>
    <p><?= Html::a("Volver a jugar", ['pasos/quiz'], ["class" => "btn btn-primary"]) ?></p>
</div>

<script>
    const correctAnswers = [
        <?= json_encode($answers[0]->nombre) ?>,
        <?= json_encode($answers[1]->nombre) ?>,
        <?= json_encode($answers[2]->nombre) ?>,
        <?= json_encode($answers[3]->nombre) ?>
    ];

    let correctCount = 0;

    function startQuiz() {
        document.queryEligeor('.slide.intro').style.display = 'none';
        document.getElementById('question-0').style.display = 'block';
    }

    function checkAnswer(questionIndex, answerIndex) {
        const selectedAnswer = document.getElementById('ans' + questionIndex + answerIndex).textContent.trim();
        if (selectedAnswer === correctAnswers[questionIndex]) {
            correctCount++;
        }
        // Hide the current question and show the next one
        if (questionIndex < 3) {
            document.getElementById('question-' + questionIndex).style.display = 'none';
            document.getElementById('question-' + (questionIndex + 1)).style.display = 'block';
        } else {
            document.getElementById('question-' + questionIndex).style.display = 'none';
            showResult();
        }
    }

    function showResult() {
        const resultDiv = document.queryEligeor('.slide.resultado');
        resultDiv.style.display = 'block';
        const resultadoText = document.getElementById('resultado');
        resultadoText.textContent = `Has respondido correctamente ${correctCount} de 4 preguntas.`;
    }
</script>