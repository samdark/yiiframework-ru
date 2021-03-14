<?php

use app\helpers\Text;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Markdown;

/* @var $this \yii\web\View */
/* @var $post \app\models\Post */
?>

<article class="post-item">

    <div class="post-title">
        <?= Html::a(Html::encode($post->title),
            ['/post/view', 'id' => $post->id, 'slug' => $post->slug]
        ) ?>
    </div>

    <div class="post-info">
        <?= Yii::t('post', 'Date publication:') ?> <?= Yii::$app->formatter->asDatetime($post->created_at, 'short'); ?><span class="margin-line">|</span>
        <?= Yii::t('post', 'Author:') ?> <?= Html::a(Html::encode($post->user->username), ['/user/view', 'id' => $post->user->id, 'username' => $post->user->username]); ?>
    </div>

    <?= Text::cut(HtmlPurifier::process(Markdown::process($post->body, 'gfm'))) ?>

    <?= Html::a(Yii::t('post', 'read more...'), ['/post/view', 'id' => $post->id, 'slug' => $post->slug], ['class' => 'btn btn-default btn-sm']) ?>

</article>