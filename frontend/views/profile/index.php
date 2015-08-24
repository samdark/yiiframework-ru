<?php

/* @var $this yii\web\View */
/* @var $profile common\models\User */

use yii\helpers\Html;

$this->title = Yii::t('app', 'My profile');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profile-index">
    <h1><?= Html::encode($this->title) ?> : <?= Html::encode($profile->username) ?></h1>

    <div class="row">
        <div class="col-md-2">
            <?= \common\widgets\Gravatar::widget([
                'email' => Html::encode($profile->email),
                'size' => 150,
                'options' => [
                    'class' => 'img-thumbnail',
                    'title' => Html::encode($profile->username),
                    'alt' => Html::encode($profile->username)
                ]
            ]) ?>
        </div>
        <div class="col-md-10">
            <p><?= Yii::t('app', 'Email') ?>: <?= Html::encode($profile->email) ?> (<?= $profile->email_verified ? Yii::t('app', 'Verified') : Yii::t('app', 'Not verified') ?>)</p>
            <p><?= Yii::t('app', 'Site') ?>: <?= Html::encode($profile->site) ? Html::a(Html::encode($profile->site), Html::encode($profile->site)) : Yii::t('app', 'no site') ?></p>
            <p><?= Yii::t('app', 'Registration') ?>: <?= Yii::$app->formatter->asDatetime($profile->created_at, 'long') ?></p>
            <p><?= Html::a(Yii::t('app', 'Edit profile'), ['/profile/update'], ['class' => 'btn btn-theme']) ?></p>
        </div>
    </div>

</div>
