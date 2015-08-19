<?php
/* @var $this \yii\web\View */
/* @var $project \common\models\Project */

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Markdown;

$fullView = isset($fullView) ? $fullView : false;

if ($fullView) {
    $this->title = $project->title;
}
?>

<div class="post">

    <h2>
        <?php
        if ($fullView) {
            echo Html::a('<span class="glyphicon glyphicon-pencil"></span> ', ['/project/update', 'id' => $project->id]);
            echo Html::encode($project->title);

        } else {
            echo Html::a(Html::encode($project->title), ['/project/view', 'id' => $project->id]);
        } ?>
    </h2>

    <section class="body">
        <?= HtmlPurifier::process(Markdown::process($project->body, 'gfm-comment')) ?>
    </section>

    <div class="row">
        <?php foreach ($project->images as $image) : ?>
            <div class="col-md-3">
                <div class="img-thumbnail">

                    <a href="<?= Yii::$app->params['url.to.project.images'] . $image->name ?>">
                        <?= Html::img(
                            Yii::$app->params['url.to.project.images'] . $image->name,
                            ['class' => 'img-responsive']
                        ) ?>
                    </a>

                </div>
            </div>
        <?php endforeach ?>
    </div>
</div>
