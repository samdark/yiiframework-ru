<?php
/* @var $this \yii\web\View */
/* @var $post \common\models\Post */
?>
<?= $this->render('_post', [
    'post' => $post,
    'fullView' => true,
]) ?>
