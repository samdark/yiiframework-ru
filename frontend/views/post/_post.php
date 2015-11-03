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

<article class="post-item">

    <div class="post-title">
        <?= $fullView ? Html::encode($post->title) : Html::a(
            Html::encode($post->title),
            ['/post/view', 'id' => $post->id]
        ) ?>
    </div>

    <div class="post-info">
        <?= Yii::$app->formatter->asDate($post->updated_at); ?> <span class="margin-line">|</span>
        <?= Html::a(Html::encode($post->user->username), ['profile/view', 'id' => $post->user->id]); ?>
    </div>

    <?= HtmlPurifier::process(Markdown::process(\common\helpers\Generator::limitWords($post->body, 200), 'gfm-comment')) ?>

    <?= Html::a(Yii::t('app', 'read more...'), ['/post/view', 'id' => $post->id], ['class' => 'btn btn-default btn-sm']) ?>

</article>