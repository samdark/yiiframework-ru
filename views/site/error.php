<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = $name;
?>
<div class="site-error">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>

    <p>
        Что-то пошло не так. Скорее всего, мы уже знаем, но на всякий случай
        <a href="https://github.com/samdark/yiiframework-ru/issues/" target="_blank" rel="noreferrer noopener">сообщите в issues на GitHub</a>.
    </p>

</div>
