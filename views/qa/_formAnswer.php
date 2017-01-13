<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $answerForm \app\models\QuestionAnswerForm */
/* @var $form yii\widgets\ActiveForm */

\app\assets\MarkdownEditorAsset::register($this);
?>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($answerForm, 'body', [
    'template' => "{label}\n{error}\n{input}\n{hint}"
])->textarea(['class' => 'markdown-editor'])->label(false) ?>

<div class="form-group">
    <div>
        <?= Html::submitButton(
            Yii::t('qa', ($answerForm->answer === null) ? 'Post Your Answer' : 'Update Your Answer'),
            ['class' => ($answerForm->answer === null) ? 'btn btn-border-success btn-lg' : 'btn btn-border-primary btn-lg', 'name' => 'submit-question']
        ) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>