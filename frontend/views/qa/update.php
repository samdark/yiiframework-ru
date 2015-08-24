<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $question common\models\Question */

$this->title = Yii::t('app', 'Update question');

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Questions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $question->title, 'url' => ['view', 'id' => $question->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="question-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'question' => $question,
    ]) ?>

</div>
