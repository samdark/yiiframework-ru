<?php
/* @var $this \yii\web\View */
/* @var $post \common\models\Post */
use yii\helpers\Html;

$this->title = Yii::t('app', 'Create post');
?>

<div class="post-create">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', ['post' => $post]) ?>
</div>