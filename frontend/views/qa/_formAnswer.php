<?php

use ijackua\lepture\Markdowneditor;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $answerForm \frontend\models\QuestionAnswerForm */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($answerForm, 'body', [
    'template' => "{label}\n{error}\n{input}\n{hint}"
])->widget(Markdowneditor::className())->label(false) ?>

<div class="form-group">
    <div>
        <?= Html::submitButton(
            Yii::t('qa', ($answerForm->answer === null) ? 'Post Your Answer' : 'Update Your Answer'),
            ['class' => ($answerForm->answer === null) ? 'btn btn-border-success btn-lg' : 'btn btn-border-primary btn-lg', 'name' => 'submit-question']
        ) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>