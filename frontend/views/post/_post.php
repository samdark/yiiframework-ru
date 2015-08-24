<?php
/* @var $this \yii\web\View */
/* @var $post \common\models\Post */
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Markdown;

$fullView = isset($fullView) ? $fullView : false;

if ($fullView) {
    $this->title = $post->title;
}
?>

<article class="post">
    <div class="post-image">
        <div class="post-heading">
            <h3> <?= $fullView ? Html::encode($post->title) : Html::a(
                    Html::encode($post->title),
                    ['/post/view', 'id' => $post->id]
                ) ?></h3>
        </div>
    </div>

    <div class="body">
        <?= HtmlPurifier::process(Markdown::process($post->body, 'gfm-comment')) ?>
    </div>

    <div class="bottom-article">
        <ul class="meta-post">
            <li><i class="glyphicon glyphicon-calendar"></i><?= Yii::$app->formatter->asDate($post->updated_at); ?></li>
            <li>
                <i class="glyphicon glyphicon-user"></i>
                <?= Html::a(Html::encode($post->user->username), ['profile/view', 'id' => $post->user->id]); ?>
            </li>
        </ul>
    </div>
</article>