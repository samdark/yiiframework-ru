<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Markdown;

/* @var $project common\models\Project */

$this->title = $project->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Projects'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-view">

    <h2>
        <?= Html::a('<span class="glyphicon glyphicon-pencil"></span> ', ['/project/update', 'id' => $project->id]); ?>
        <?= Html::encode($project->title); ?>
    </h2>

    <div class="bottom-article">
        <ul class="meta-post">
            <li>
                <i class="glyphicon glyphicon-calendar"></i><?= Yii::$app->formatter->asDate($project->created_at); ?>
            </li>
            <li>
                <i class="glyphicon glyphicon-user"></i>
                <?= Html::a(Html::encode($project->user->username), ['profile/view', 'id' => $project->user->id]); ?>
            </li>
            <?php if ($project->link) : ?>
                <li>
                    <i class="glyphicon glyphicon-link"></i>
                    <?= Html::a(Yii::t('app', 'To web'), $project->link); ?>
                </li>
            <?php endif; ?>
        </ul>
    </div>

    <section class="body">
        <?= HtmlPurifier::process(Markdown::process($project->body, 'gfm-comment')) ?>
    </section>

    <?php foreach ($project->images as $image) : ?>

        <div class="img-thumbnail">

            <a href="<?= Yii::$app->params['url.to.project.images'] . $image->name ?>">
                <?= Html::img(
                    Yii::$app->params['url.to.project.images'] . $image->name,
                    ['class' => 'img-responsive']
                ) ?>
            </a>

        </div>

    <?php endforeach ?>

</div>