<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $project common\models\Project */

$this->title = Yii::t('app', 'Add Project');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Projects'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'project' => $project,
    ]) ?>

</div>
