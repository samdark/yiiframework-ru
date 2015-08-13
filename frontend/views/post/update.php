<?php
/* @var $this \yii\web\View */
/* @var $post \common\models\Post */
use yii\helpers\Html;

$this->title = Yii::t('app', 'Update post');
?>

<div class="post-update">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', ['post' => $post]) ?>
</div>