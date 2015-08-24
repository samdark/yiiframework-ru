<?php
/* @var $this \yii\web\View */
/* @var $provider \yii\data\ActiveDataProvider */
use yii\helpers\Html;
use yii\widgets\LinkPager;

$this->title = \Yii::t('app', 'Posts');
?>

<div class="post-index">

    <h4 class="pull-right">
        <?= Html::a(
            Yii::t('app', 'Publish post'),
            ['/post/create']
        ) ?>
    </h4>

    <h1><?= Html::encode($this->title) ?></h1>

    <section class="list">
        <div class="items">
            <?php foreach ($provider->getModels() as $post): ?>
                <?= $this->render('_post', ['post' => $post]) ?>
            <?php endforeach ?>
        </div>

        <?= LinkPager::widget([
             'pagination' => $provider->getPagination(),
        ]) ?>
    </section>
</div>
