<?php

/* @var $this yii\web\View */
/* @var $provider yii\data\ActiveDataProvider */
/* @var $user common\models\User */

use yii\widgets\LinkPager;

$this->title = Yii::t('app', 'Member List');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profile-list">
    <h1><?= Yii::t('app', 'Member List') ?></h1>

    <table class="table table-bordered table-responsive table-striped table-hover">
        <thead>
        <tr>
            <th><?= Yii::t('app', 'Username') ?></th>
            <th><?= Yii::t('app', 'Registration') ?></th>
            <th>---</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($provider->getModels() as $user): ?>
            <?= $this->render('_user', ['user' => $user]) ?>
        <?php endforeach ?>
        </tbody>
    </table>

    <?= LinkPager::widget([
        'options' => ['class' => 'pagination pagination-sm'],
        'pagination' => $provider->getPagination(),
    ]) ?>

</div>
