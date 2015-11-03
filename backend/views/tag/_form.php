<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Tag */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="tag-form">

    <?php $form = ActiveForm::begin(
        [
            'layout' => 'horizontal',
            'fieldConfig' => [
                'horizontalCssClasses' => [
                    'label' => 'col-md-2',
                    'offset' => 'col-md-offset-2',
                    'wrapper' => 'col-md-6 col-lg-4',
                    'error' => '',
                    'hint' => '',
                ],
            ],
        ]
    ); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'color')->input('color', ['maxlength' => true]) ?>

    <?= $form->field($model, 'parent_id')->dropDownList(
        \yii\helpers\ArrayHelper::map($model->find()->canBeParent($model->id)->all(), 'id', 'name'),
        ['prompt' => Yii::t('app', 'Select parent')]
    ) ?>

    <?= $form->field($model, 'position')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(
            $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
        ) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
