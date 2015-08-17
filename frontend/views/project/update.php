<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $project common\models\Project */

$this->title = Yii::t('app', 'Update {projectClass}: ', ['projectClass' => 'Project',]) . ' ' . $project->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Projects'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $project->title, 'url' => ['view', 'id' => $project->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="project-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', ['project' => $project,]) ?>

</div>
