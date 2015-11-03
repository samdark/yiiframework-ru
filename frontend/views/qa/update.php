<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $questionForm \frontend\models\QuestionForm */

$this->title = Yii::t('app', 'Update Question');

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Questions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $questionForm->title, 'url' => ['view', 'id' => $questionForm->question->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="question-update">
    <div class="row">
        <div class="col-md-8">
            <h1><?= Html::encode($this->title) ?></h1>

            <?= $this->render(
                '_form',
                [
                    'questionForm' => $questionForm,
                ]
            ) ?>

        </div>
    </div>
</div>
