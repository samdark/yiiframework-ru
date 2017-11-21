<?php
/* @var $this \yii\web\View */
/* @var $post \app\models\Post */

$this->title = Yii::t('post', 'Create post');
?>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <?= $this->render('_form', ['post' => $post, 'canEditStatus' => false, 'canEditPost' => false]) ?>
    </div>
</div>