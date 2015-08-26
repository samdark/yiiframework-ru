<?php

use ijackua\lepture\Markdowneditor;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $question common\models\Question */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="question-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($question, 'title')->textInput(['maxlength' => true]) ?>

    <?= Html::activeLabel($question, 'body') ?>
    <?= Markdowneditor::widget(
        [
            'model' => $question,
            'attribute' => 'body',
        ]
    ) ?>

    <div class="form-group">
        <div>
            <?= Html::submitButton(
                Yii::t('app', 'Publish'),
                ['class' => 'btn btn-primary', 'name' => 'submit-question']
            ) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
