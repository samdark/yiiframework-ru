<?php
/* @var $this \yii\web\View */
/* @var $project \common\models\Project */

use yii\helpers\Html;
?>

<div class="col-md-4">
    <div class="project-item">
        <?php if ($project->images) : ?>
            <a href="<?= yii\helpers\Url::to(['/project/view', 'id' => $project->id]); ?>" class="project-cover"
               style="background-image: url(<?= Yii::$app->params['url.to.project.images'] . $project->images[0]->name ?>);">
            </a>
        <?php endif ?>

        <div class="post-info">
            <?= Yii::$app->formatter->asDate($project->created_at); ?>
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
</div>