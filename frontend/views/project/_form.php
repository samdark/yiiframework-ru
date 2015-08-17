<?php

use ijackua\lepture\Markdowneditor;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $project common\models\Project */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="project-form">

    <div class="row">
        <div class="col-md-6">
            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($project, 'title')->textInput(['maxlength' => true]) ?>

            <?= $form->field($project, 'link')->textInput(['maxlength' => true]) ?>

            <?= Html::activeLabel($project, 'body') ?>
            <?= Markdowneditor::widget([
                'model' => $project,
                'attribute' => 'body',
                'options' => ['rows' => 3]
            ]) ?>

            <div class="form-group">
                <?= Html::submitButton($project->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $project->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>

        <div class="col-md-6">
            TODO: Implement load images
        </div>

    </div>


</div>
