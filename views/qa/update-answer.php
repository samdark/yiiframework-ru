<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $answerForm app\models\QuestionAnswerForm */

$this->title = Yii::t('qa', 'Update answer');
?>

<div class="answer-update">
    <div class="row">
        <div class="col-md-8">

            <h1><?= Html::encode($this->title) ?></h1>

            <div class="question-form">

                <?= $this->render('_formAnswer', [
                    'answerForm' => $answerForm
                ]) ?>

            </div>

        </div>
    </div>
</div>
