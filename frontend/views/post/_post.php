<?php
/* @var $this \yii\web\View */
/* @var $post \common\models\Post */
use common\helpers\Generator;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Markdown;

$fullView = isset($fullView) ? $fullView : false;

if ($fullView) {
    $this->title = $post->title;
    $textBody = Markdown::process($post->body, 'gfm-comment');
} else {
    $textBody = Markdown::process(Generator::limitWords($post->body, 200));
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

    <?= HtmlPurifier::process($textBody) ?>

    <?php if (!$fullView) : ?>
        <?= Html::a(
            Yii::t('app', 'read more...'),
            ['/post/view', 'id' => $post->id],
            ['class' => 'btn btn-default btn-sm']
        ) ?>
    <?php endif ?>
</article>