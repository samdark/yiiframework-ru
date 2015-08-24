<?php

use ijackua\lepture\Markdowneditor;
use kartik\file\FileInput;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

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
                    $initialPreviewConfig = [];

                    foreach ($project->Project->images as $image) {

                        $images[] = Html::img(
                            Yii::$app->params['url.to.project.images'] . $image->name,
                            ['class' => 'file-preview-image']
                        );

                        $initialPreviewConfig[] = [
                            'url' => Url::to(['/project/delete-image']),
                            'key' => $image->id,
                            'caption' => sprintf('<a href="%s">%s</a>', $image->filename, Yii::t('app', 'Link')),
                        ];
                    }

                    echo FileInput::widget(
                        [
                            'name' => 'imageFiles[]',
                            'options' => [
                                'multiple' => true,
                                'maxFileCount' => 7,
                                'id' => 'file-upload'
                            ],
                            'pluginOptions' => [
                                'showPreview' => true,
                                'showCaption' => true,
                                'showRemove' => false,
                                'showUpload' => true,
                                'initialPreview' => $images,
                                'initialPreviewConfig' => $initialPreviewConfig,
                                'overwriteInitial' => false,
                                'uploadUrl' => Url::to(['/project/add-image', 'id' => $project->Project->id]),
                            ],
                            'pluginEvents' => [
                                'filepredelete' => "function(event, key) {
                                    return (!confirm('Are you sure you want to delete ?'));
                                }",
                            ]
                        ]
                    );
                    ?>
                    <p class="hint"><?= $project->getAttributeHint('imageFiles') ?></p>
                    <?= Html::error($project, 'imageFiles', ['class' => 'text-danger']) ?>
                </div>

            </div>

        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
