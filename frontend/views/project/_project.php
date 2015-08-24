<?php
/* @var $this \yii\web\View */
/* @var $project \common\models\Project */

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Markdown;
use common\helpers\Generator;

$this->title = $project->title;
?>

<div class="post">

    <h4>
        <?= Html::a(Html::encode($project->title), ['/project/view', 'id' => $project->id]); ?>
    </h4>

    <div class="row">
        <div class="col-md-2">

            <?php if ($project->images) : ?>
                <div class="img-thumbnail">
                    <a href="<?= Yii::$app->params['url.to.project.images'] . $project->images[0]->name ?>">
                        <?= Html::img(
                            Yii::$app->params['url.to.project.images'] . $project->images[0]->name,
                            ['class' => 'img-responsive']
                        ) ?>
                    </a>
                </div>
            <?php endif ?>

        </div>

        <div class="col-md-10">

            <section class="body">
                <?= HtmlPurifier::process(Markdown::process(Generator::limitWords($project->body, 40), 'gfm-comment')) ?>
            </section>

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

        </div>

    </div>

</div>
