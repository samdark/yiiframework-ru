<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<?php $this->beginContent('@frontend/views/layouts/main.php') ?>

<div class="container-fluid sect-title">
    <div class="container">
        <div class="row">
            <div class="col-xs-10 col-sm-11 col-md-9 col-lg-9">
                <div class="sect-title-text"><?= Html::encode($this->title) ?></div>
            </div>
            <div class="col-xs-2 col-sm-1 col-md-3 col-lg-3">
                <input class="form-control input-lg page-search" type="text" placeholder="<?= Yii::t('app', 'Search') ?>">
            </div>
        </div>
    </div>
</div>

<div class="container page-wrapper page-cont-col">
    <?= $content ?>
</div>

<?php $this->endContent() ?>
