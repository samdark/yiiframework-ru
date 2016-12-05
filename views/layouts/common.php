<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<?php $this->beginContent('@app/views/layouts/main.php') ?>

<div class="container-fluid sect-title">
    <div class="container">
        <div class="row">
            <div class="col-xs-10 col-sm-11 col-md-9 col-lg-9">
                <div class="sect-title-text"><?= Html::encode($this->title) ?></div>
            </div>
            <div class="col-xs-2 col-sm-1 col-md-3 col-lg-3">
                <form action="http://www.google.com/cse" id="cse-search-box" target="_blank" rel="noopener noreferrer">
                    <input type="hidden" name="cx" value="006237035567373325440:sm9smqhhp9u" />
                    <input type="hidden" name="ie" value="UTF-8" />
                    <input type="text" class="form-control input-lg" name="q" size="14" placeholder="<?= Yii::t('app', 'Search') ?>" />
                </form>
            </div>
        </div>
    </div>
</div>

<div class="container page-wrapper page-cont-col">
    <?= $content ?>
</div>

<?php $this->endContent() ?>
