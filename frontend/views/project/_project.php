<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $project \common\models\Project */

$stylePreviewImage = '';
if ($project->images) {
    $stylePreviewImage = 'background-image: url(' . Yii::$app->params['url.to.project.images'] . $project->images[0]->name . ');';
}
?>

<div class="project-item">

    <?= Html::a('', ['/project/view', 'id' => $project->id], ['class' => "project-cover", 'style' => $stylePreviewImage]) ?>

    <div class="post-info">
        <?= Yii::$app->formatter->asDate($project->created_at, 'long'); ?>
        <span class="margin-line">|</span>
        <?= Html::a(Html::encode($project->user->username), ['profile/view', 'id' => $project->user->id]); ?>
    </div>

    <div class="project-title">
        <?= Html::a(
            '<span class="ellipsis_text">' . Html::encode($project->title) . '</span>',
            ['/project/view', 'id' => $project->id],
            ['class' => 'project-title-text']
        ); ?>
    </div>

    <div class="project-info">
        <div class="p-info-like">
            <svg>
                <use xlink:href="#ico_like"/>
            </svg>
            <span>32</span>
        </div>

        <div class="p-info-view">
            <svg>
                <use xlink:href="#ico_view"/>
            </svg>
            <span>205</span>
        </div>

        <div class="p-info-comment">
            <svg>
                <use xlink:href="#ico_comment"/>
            </svg>
            <span>12</span>
        </div>
    </div>
</div>
