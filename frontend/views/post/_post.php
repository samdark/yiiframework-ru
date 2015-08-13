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

<div class="post">
    <h2>
        <?= $fullView ? Html::encode($post->title) : Html::a(Html::encode($post->title), ['/post/view', 'id' => $post->id]) ?>
    </h2>

    <section class="body">
        <?= HtmlPurifier::process(Markdown::process($post->body, 'gfm-comment')) ?>
    </section>
</div>
