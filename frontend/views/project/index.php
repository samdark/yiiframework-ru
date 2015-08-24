<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Projects based on Yii framework');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-index">

    <div class="row">

        <div class="col-md-10">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>

        <div class="col-md-2">
            <h1>
                <?= Html::a(Yii::t('app', 'Add Project'), ['create'], ['class' => 'btn btn-success btn-lg']) ?>
            </h1>
        </div>

    </div>

    <section class="list">
        <div class="items">
            <?php foreach ($dataProvider->getModels() as $project): ?>
                <?= $this->render('_project', ['project' => $project]) ?>
            <?php endforeach ?>
        </div>

        <?= LinkPager::widget([
            'pagination' => $dataProvider->getPagination(),
        ]) ?>
    </section>

</div>

