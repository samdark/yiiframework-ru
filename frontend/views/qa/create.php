<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $question common\models\Question */

$this->title = Yii::t('app', 'Create Question');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Questions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="question-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-md-8">
            <?= $this->render(
                '_form',
                [
                    'question' => $question,
                ]
            ) ?>
        </div>
    </div>

</div>
