<?php

/* @var $this yii\web\View */
/* @var $project common\models\Project */

$this->title = $project->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Projects'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_project', ['project' => $project, 'fullView' => true,]) ?>
