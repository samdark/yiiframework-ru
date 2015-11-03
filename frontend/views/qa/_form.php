<?php

use ijackua\lepture\Markdowneditor;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $questionForm \frontend\models\QuestionForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="question-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($questionForm, 'title')->textInput(['maxlength' => true]) ?>

    <?= Html::activeLabel($questionForm, 'body') ?>
    <?= Markdowneditor::widget(
        [
            'model' => $questionForm,
            'attribute' => 'body',
        ]
    ) ?>

    <?= $form->field($questionForm, 'tags')->dropDownList(
        $questionForm->listTags,
        ['multiple' => true]
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
