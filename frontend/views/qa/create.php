<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $questionForm \frontend\models\QuestionForm */

$this->title = Yii::t('app', 'Create Question');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Questions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="question-create">
    <div class="row">
        <div class="col-md-8">
            <h1><?= Html::encode($this->title) ?></h1>

            <div class="row">
                <div class="col-md-8">
                    <?= $this->render(
                        '_form',
                        [
                            'questionForm' => $questionForm,
                        ]
                    ) ?>
                </div>
            </div>

        </div>
    </div>
</div>
