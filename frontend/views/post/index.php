<?php
/* @var $this \yii\web\View */
/* @var $provider \yii\data\ActiveDataProvider */
use yii\helpers\Html;
use yii\widgets\LinkPager;

$this->title = 'New posts';
?>

<div class="post-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= Html::a(Yii::t('app', 'Publish post'), ['/post/create']) ?>

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
