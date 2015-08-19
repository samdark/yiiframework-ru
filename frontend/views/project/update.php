<?php

use common\models\ProjectImage;
use ijackua\lepture\Markdowneditor;
use kartik\file\FileInput;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $project \frontend\models\ProjectForm */

$this->title = Yii::t('app', 'Update post');;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Projects'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $project->Project->title, 'url' => ['view', 'id' => $project->Project->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="project-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="project-form">

        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

        <div class="row">

            <div class="col-md-5">

                <?= $form->field($project, 'title')->textInput(['maxlength' => true]) ?>

                <?= $form->field($project, 'link')->textInput(['maxlength' => true]) ?>

                <div class="form-group">
                    <?= Html::activeLabel($project, 'body') ?>
                    <?= Markdowneditor::widget(
                        [
                            'model' => $project,
                            'attribute' => 'body',
                            'options' => ['rows' => 3]
                        ]
                    ) ?>
                    <?= Html::error($project, 'body', ['class' => 'text-danger']) ?>
                </div>

                <div class="form-group">
                    <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success btn-block']) ?>
                </div>

            </div>

            <div class="col-md-7">

                <div class="form-group">
                    <label class="control-label">Add screenshots</label>
                    <?php

                    $images = [];
                    foreach ($project->Project->images as $image) {
                        $images[] = ArrayHelper::getValue(
                            $image,
                            function ($image) {
                                /* @var $image ProjectImage */
                                return Html::img(
                                    Yii::$app->params['url.to.project.images'] . $image->name,
                                    ['class' => 'file-preview-image']
                                );
                            }
                        );
                    }
                    //TODO: Edit "update" action of controller and create ajax action for delete and upload images
                    /*
                    echo FileInput::widget(
                        [
                            'name' => 'imageFiles[]',
                            'options' => ['multiple' => true],
                            'pluginOptions' => [
                                'initialPreview' => $images,
                            ]
                        ]
                    );
                    //*/

                    echo FileInput::widget([
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
                            'initialPreview' => $images,
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
