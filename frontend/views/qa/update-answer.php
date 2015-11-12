<?php

use yii\helpers\Html;
use ijackua\lepture\Markdowneditor;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $answer common\models\Answer */
/* @var $form yii\widgets\ActiveForm */

$this->title = Yii::t('app', 'Update answer');

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Questions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = [
    'label' => $answer->question->title,
    'url' => ['view', 'id' => $answer->question->id]
];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="answer-update">
    <div class="row">
        <div class="col-md-8">

            <h1><?= Html::encode($this->title) ?></h1>

            <div class="question-form">

                <?php $form = ActiveForm::begin(); ?>

                <?= Html::activeLabel($answer, 'body') ?>
                <?= Markdowneditor::widget(
                    [
                        'model' => $answer,
                        'attribute' => 'body',
                    ]
                ) ?>

                <div class="form-group">
                    <div>
                        <?= Html::submitButton(
                            Yii::t('app', 'Save edits'),
                            ['class' => 'btn btn-primary', 'name' => 'submit-answer']
                        ) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>

            </div>

        </div>
    </div>
</div>
