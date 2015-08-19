<?php

use ijackua\lepture\Markdowneditor;
use kartik\file\FileInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $project \frontend\models\ProjectForm */
/* @var $form yii\widgets\ActiveForm */
/* @var $this yii\web\View */
/* @var $project common\models\Project */

$this->title = Yii::t('app', 'Add Project');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Projects'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="project-form">

        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

        <div class="row">

            <div class="col-md-5">

                <?= $form->field($project, 'title')->textInput(['maxlength' => true]) ?>

                <?= $form->field($project, 'link')->textInput(['maxlength' => true]) ?>

                <div class="form-group">
                    <?= Html::activeLabel($project, 'body') ?>
                    <?= Markdowneditor::widget([
                        'model' => $project,
                        'attribute' => 'body',
                        'options' => ['rows' => 3]
                    ]) ?>
                    <?= Html::error($project, 'body', ['class' => 'text-danger']) ?>
                </div>

                <div class="form-group">
                    <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success btn-block']) ?>
                </div>

            </div>

            <div class="col-md-7">

                <div class="form-group">
                    <label class="control-label">Add screenshots</label>
                    <?=
                    FileInput::widget([
                        'model' => $project,
                        'attribute' => 'imageFiles[]',
                        'options' => [
                            'multiple' => true,
                            'accept' => 'image/*',
                            'maxFileCount' => 7,
                            'previewFileType' => 'any',
                        ],
                        'pluginOptions' => [
                            'showPreview' => true,
                        ],
                    ]);
                    ?>
                    <p class="hint"><?= $project->getAttributeHint('imageFiles') ?></p>
                    <?= Html::error($project, 'imageFiles', ['class' => 'text-danger']) ?>
                </div>

            </div>

        </div>

        <?php ActiveForm::end(); ?>

    </div>


</div>
