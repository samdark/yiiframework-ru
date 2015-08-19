<?php

/* @var $this yii\web\View */
/* @var $profile common\models\User */

use yii\helpers\Html;

$this->title = Yii::t('app', 'View Profile - {username}', ['username' => $profile->username]);
$this->params['breadcrumbs'][] = Yii::t('app', 'View Profile');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profile-view">
    <h1><?= Yii::t('app', 'View Profile') ?> : <?= $profile->username ?></h1>

    <div class="row">
        <div class="col-md-12">
            <p><?= Yii::t('app', 'Email') ?>: <?= $profile->email ?> (<?= $profile->email_verified ? Yii::t('app', 'Verified') : Yii::t('app', 'Not verified') ?>)</p>
            <p><?= Yii::t('app', 'Site') ?>: <?= $profile->site ? Html::a($profile->site, $profile->site) : Yii::t('app', 'no site') ?></p>
            <p><?= Yii::t('app', 'Registration') ?>: <?= Yii::$app->formatter->asDatetime($profile->created_at, 'long') ?></p>
        </div>
    </div>

</div>
